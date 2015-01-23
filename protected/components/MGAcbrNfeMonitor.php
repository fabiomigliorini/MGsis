<?php

/**
 * Description of MGSocket
 *
 * @author Fabio Migliorini
 * @property NotaFiscal $NotaFiscal
 * @property NfeTerceiro $NfeTerceiro
 * @property Filial $Filial
 * @property Array      $retornoMonitor  
 * @property string     $erroMonitor     Descricao do erro ocorrido na comunicacao com o monitor
 */

class MGAcbrNfeMonitor extends MGSocket 
{
	public $NotaFiscal;
	public $NfeTerceiro;
	public $Filial;
	
	public $erroMonitor;
	public $retornoMonitor;
	
	public $urlpdf;
	
	public $path;
	public $arquivoxml;
	public $xml;
	
	/**
	 * 
	 * @param NotaFiscal $NotaFiscal
	 * @param NfeTerceiro $NfeTerceiro
	 * @param string $servidor
	 * @param string $porta
	 * @return boolean
	 */
	public function __construct($NotaFiscal = NULL, $NfeTerceiro = NULL, $servidor = NULL, $porta = NULL)
	{
		$this->NotaFiscal = $NotaFiscal;
		$this->NfeTerceiro = $NfeTerceiro;
		
		if (!empty($this->NotaFiscal))
		{
			$this->Filial = $this->NotaFiscal->Filial;
			$this->montaUrlPdf();
		}
		elseif (!empty($this->NfeTerceiro))
			$this->Filial = $this->NfeTerceiro->Filial;
		else 
			return false;	
		
		if (isset($this->Filial))
			return parent::__construct($this->Filial->acbrnfemonitorip, $this->Filial->acbrnfemonitorporta);
		else
			return parent::__construct ();
		
	}
	
	public function montaUrlPdf()
	{
		$this->urlpdf = "{$this->Filial->acbrnfemonitorcaminhorede}/PDF/{$this->NotaFiscal->nfechave}.pdf";
	}
	
	public function conectar()
	{
		
		if (!parent::conectar())
		{
			$this->erroMonitor = "Impossivel conectar ao monitor de NFE!";
			$this->retorno = $this->errno . " - " . $this->errstr;
			return false;
		}
		
		if (strstr($this->retorno, "Esperando por comandos."))
			return true;
		
		$this->desconectar();
		
	}
	
	public function enviaComando($str)
	{
		if (!$this->envia($str))
			return false;
		
		if (!$this->recebe())
			return false;
		
		return true;
	}

	// pega a string de retorno e converte em um array retornoMonitor
	public function processaRetorno()
	{
		//inicializa variaveis
		$this->erroMonitor = "";
		$this->retornoMonitor = array();
		
		//limpa espaco em branco do retorno
		$ret = trim($this->retorno);
		
		//se estiver vazio, retorna falso
		if (empty($ret))
		{
			$this->erroMonitor = "Retorno Vazio";
			return false;
		}
		
		//processa 1a linha - e joga como Mensagem
		$ret = split("\n", $ret);
		$mensagem = split(":", $ret[0], 2);
		for ($i=0; $i<sizeof($mensagem); $i++)
			$mensagem[$i] = trim($mensagem[$i]);
		$this->retornoMonitor = array("Mensagem" => $mensagem);
		
		//processa arquivo ini se existir anexado
		if (sizeof($ret)>1)
		{
			unset($ret[0]);
			$ret = implode("\n", $ret);
			$this->processaIni($ret);
		}
		
		return true;
		
	}
	
	function processaIni($str)
	{
		//quebra a string em linhas
		$str = str_replace("\r", "", $str);
		$linhas = explode("\n", $str);
		
		//inicializa
		$grupo = "";
		$arr = array();
		
		//percorre linhas
		foreach ($linhas as $linha)
		{
			//Ignora grupos em branco
			if (empty($linha))
				continue;
			
			//Inicio de Grupo
			if (substr($linha, 0, 1) == "[")
			{
				$grupo = trim($linha);
				$grupo = str_replace("[", "", $grupo);
				$grupo = str_replace("]", "", $grupo);
				$arr[$grupo] = array();
				continue;
			}
			
			//par chave=valor
			if (strstr($linha, "="))
			{
				list($chave, $valor) = explode("=", $linha, 2);
				$arr[$grupo][trim($chave)] = trim($valor);
				continue;
			}
			
			$arr["Texto"][] = $linha;
			//$arr[$grupo][$chave] .= "\n$linha";
		}
		$this->retornoMonitor = array_merge($this->retornoMonitor, $arr);
		
		return true;
	
	}
	
	function geraIni($arr) 
	{ 
		$conteudo = "";
		foreach ($arr as $chave=>$valor) 
		{ 
			if (!empty($chave))
				$conteudo .= "[".$chave."]\n"; 
			foreach ($valor as $chave2=>$valor2) 
			{ 
				if(is_array($valor2)) 
				{ 
					for($i=0;$i<count($valor2);$i++) 
					{ 
						$conteudo .= $chave2."[]=".$valor2[$i]."\n"; 
					} 
				} 
				else 
					$conteudo .= $chave2."=".$valor2."\n"; 
			} 
		} 
		return $conteudo;
	}	
	
	
	public function recebe($timeout = 200)
	{
		if (!$ret = parent::recebe($timeout))
			return false;
		
		return $this->processaRetorno();
	}
	
	/*
	 * Status do servico de NFE
	 */
	public function statusServico()
	{
		if (!$this->enviaComando("NFE.StatusServico\n.\n"))
			return false;
		
		if ($this->retornoMonitor["Mensagem"][0] != "OK")
			return false;
		
		if ($this->retornoMonitor["Mensagem"][1] != "Servico em Operacao")
			return false;
		
		return true;
	}
	

	/*
	NFe.Ativo - Responde com OK caso o ACBrNFeMonitor esteja aberto.
	 */
	public function ativo()
	{
		if (!$this->enviaComando("NFE.Ativo\n.\n"))
			return false;
		
		if ($this->retornoMonitor["Mensagem"][0] != "OK")
			return false;
		
		if ($this->retornoMonitor["Mensagem"][1] != "Ativo")
			return false;
		
		return true;
	}
	
	public function gerarErro($texto)
	{
		$this->erroMonitor = $texto;
		$this->retorno = $this->erroMonitor;
		$this->retornoMonitor["Mensagem"] = array("Erro", $this->erroMonitor);
		return false;
	}
	
	public function criarNFe() 
	{
		if (!in_array($this->NotaFiscal->codstatus, array(NotaFiscal::CODSTATUS_NAOAUTORIZADA, NotaFiscal::CODSTATUS_DIGITACAO)))
			return $this->gerarErro("Status da Nota Fiscal nao permite envio ao Sefaz!");
		
		if (!$this->NotaFiscal->emitida)
			return $this->gerarErro("Nota Fiscal nao e de nossa emissao!");
		
		if (sizeof($this->NotaFiscal->NotaFiscalProdutoBarras) <= 0)
			return $this->gerarErro("Nao existe nenhum produto na nota fiscal!");
		
		if (!$this->confereNumero())
			return $this->gerarErro("Erro ao gerar numero da Nota Fiscal!");
		
		$arr = array(
			//Identificacao
			"Identificacao" => array(
				"NaturezaOperacao" => $this->NotaFiscal->NaturezaOperacao->naturezaoperacao,
				"Codigo" => $this->NotaFiscal->numero,
				"Emissao" => $this->NotaFiscal->emissao,
				"Saida" => $this->NotaFiscal->saida,
				"Modelo" => $this->NotaFiscal->modelo,
				"Serie" => $this->NotaFiscal->serie,
				"Numero" => $this->NotaFiscal->numero,
				"Tipo" => ($this->NotaFiscal->codoperacao == 1)?2:1,
				"FormaPag" => (sizeof($this->NotaFiscal->NotaFiscalDuplicatass)>0)?1:0,				
			),
			//Emitente
			"Emitente" => array(
				"CNPJ" => Yii::app()->format->formataPorMascara($this->Filial->Pessoa->cnpj, "##############", true),
				"IE" => $this->Filial->Pessoa->ie,
				"Razao" => $this->Filial->Pessoa->pessoa,
				"Fantasia" => $this->Filial->Pessoa->fantasia,
				"Fone" => Yii::app()->format->numeroLimpo($this->Filial->Pessoa->telefone1),
				"CEP" => $this->Filial->Pessoa->cep,
				"Logradouro" => $this->Filial->Pessoa->endereco,
				"Numero" => $this->Filial->Pessoa->numero,
				"Complemento" => $this->Filial->Pessoa->complemento,
				"Bairro" => $this->Filial->Pessoa->bairro,
				"CidadeCod" => $this->Filial->Pessoa->Cidade->codigooficial,
				"Cidade" => $this->Filial->Pessoa->Cidade->cidade,
				"UF" => $this->Filial->Pessoa->Cidade->Estado->sigla,
				"CRT" => $this->Filial->crt,
			),
			//Destinatario
			"Destinatario" => array(
				"CNPJ" => ($this->NotaFiscal->Pessoa->fisica)?
					Yii::app()->format->formataPorMascara($this->NotaFiscal->Pessoa->cnpj, "###########", true):
					Yii::app()->format->formataPorMascara($this->NotaFiscal->Pessoa->cnpj, "##############", true),
				"IE" => empty($this->NotaFiscal->Pessoa->ie)?"ISENTO":$this->NotaFiscal->Pessoa->ie,
				"NomeRazao" => substr($this->NotaFiscal->Pessoa->pessoa, 0, 60),
				"Fone" => Yii::app()->format->numeroLimpo($this->NotaFiscal->Pessoa->telefone1),
				"CEP" => $this->NotaFiscal->Pessoa->cep,
				"Logradouro" => $this->NotaFiscal->Pessoa->endereco,
				"Numero" => $this->NotaFiscal->Pessoa->numero,
				"Complemento" => $this->NotaFiscal->Pessoa->complemento,
				"Bairro" => $this->NotaFiscal->Pessoa->bairro,
				"CidadeCod" => $this->NotaFiscal->Pessoa->Cidade->codigooficial,
				"Cidade" => $this->NotaFiscal->Pessoa->Cidade->cidade,
				"UF" => $this->NotaFiscal->Pessoa->Cidade->Estado->sigla,
			),
			
		);
		
		
		
		//Produtos
		$i = 1;
		$totalPis = 0;
		$totalCofins = 0;
			
		foreach ($this->NotaFiscal->NotaFiscalProdutoBarras as $NotaFiscalpb)
		{
			$valorDesconto = 0;
			$vFrete = 0;
			$vSeg = 0;
			$vOutro = 0;

			if ($this->NotaFiscal->valorprodutos <> 0)
			{
                        	$valorDesconto = round(($this->NotaFiscal->valordesconto / $this->NotaFiscal->valorprodutos) * $NotaFiscalpb->valortotal, 2);
                                $vFrete = round(($this->NotaFiscal->valorfrete / $this->NotaFiscal->valorprodutos) * $NotaFiscalpb->valortotal, 2);
                                $vSeg = round(($this->NotaFiscal->valorseguro / $this->NotaFiscal->valorprodutos) * $NotaFiscalpb->valortotal, 2);
                                $vOutro = round(($this->NotaFiscal->valoroutras / $this->NotaFiscal->valorprodutos) * $NotaFiscalpb->valortotal, 2);
			}
			$arr["Produto" . Yii::app()->format->formataPorMascara($i, "###", true)] = 
				array(
					"CFOP" => $NotaFiscalpb->codcfop,
					"Codigo" => 
						Yii::app()->format->formataPorMascara($NotaFiscalpb->ProdutoBarra->codproduto, "######") 
						//. empty($NotaFiscalpb->ProdutoBarra->codprodutoembalagem)?'':'-' . $NotaFiscalpb->ProdutoBarra->ProdutoEmbalagem->quantidade
						,
					"EAN" => $NotaFiscalpb->ProdutoBarra->barrasValido()?$NotaFiscalpb->ProdutoBarra->barras:"",
					/*
					If Len(NumeroLimpo($NotaFiscalpb->barras)) > 6 _
						And NumeroLimpo(Mid($NotaFiscalpb->barras, 1, 6)) <> Format($NotaFiscalpb->codproduto, "000000") _
						And NumeroLimpo(Mid($NotaFiscalpb->barras, 1, 3)) <> "999" _
						And ValidaEan($NotaFiscalpb->barras) Then
					End If
					 */ 
					"Descricao" => (empty($NotaFiscalpb->descricaoalternativa))?$NotaFiscalpb->ProdutoBarra->descricao:$NotaFiscalpb->descricaoalternativa,
					"Unidade" => $NotaFiscalpb->ProdutoBarra->UnidadeMedida->sigla,
					"NCM" => Yii::app()->format->formataPorMascara($NotaFiscalpb->ProdutoBarra->Produto->ncm, "########"),
					"Quantidade" => $NotaFiscalpb->quantidade,
					"ValorUnitario" => $NotaFiscalpb->valorunitario,
					"ValorTotal" => $NotaFiscalpb->valortotal,
					"ValorDesconto" => $valorDesconto,
					"vFrete" => $vFrete,
					"vSeg" => $vSeg,
					"vOutro" => $vOutro,
				);
			
			if ($this->NotaFiscal->Filial->crt == Filial::CRT_REGIME_NORMAL)
			{
				/*
				[ICMS001]
				Origem=0
				Modalidade=1
				 * CST=51
				 * ValorBase=0.00
				PercentualReducao=0.00
				 * Aliquota=0.00
				 * Valor=0.00
				 * 
				 * [PIS001]
				 * CST=50
				 * ValorBase=100.00
				 * Aliquota=1.65
				 * Valor=1.65
				 * 
				 * [COFINS001]
				 * CST=50
				 * ValorBase=100.00
				 * Aliquota=7.60
				 * Valor=7.60
				 */
				$arr["ICMS" . Yii::app()->format->formataPorMascara($i, "###", true)] = 
					array(
						//"CST" => Nz(prsItem!csosn,
						"CST" => Yii::app()->format->formataPorMascara($NotaFiscalpb->icmscst, "##", true),
						"ValorBase" => $NotaFiscalpb->icmsbase,
						"Aliquota" => $NotaFiscalpb->icmspercentual,
						"Valor" => $NotaFiscalpb->icmsvalor,
						//"ValorBase=0\n";
						//"Aliquota=0\n";
						//"valor=0\n";
					);
				
				$arr["PIS" . Yii::app()->format->formataPorMascara($i, "###", true)] = 
					array(
						"CST" => Yii::app()->format->formataPorMascara($NotaFiscalpb->piscst, "##", true),
						"ValorBase" => $NotaFiscalpb->pisbase,
						"Aliquota" => $NotaFiscalpb->pispercentual,
						"Valor" => $NotaFiscalpb->pisvalor,
					);
				$totalPis += $NotaFiscalpb->pisvalor;
				
				$arr["COFINS" . Yii::app()->format->formataPorMascara($i, "###", true)] = 
					array(
						"CST" => Yii::app()->format->formataPorMascara($NotaFiscalpb->cofinscst, "##", true),
						"ValorBase" => $NotaFiscalpb->cofinsbase,
						"Aliquota" => $NotaFiscalpb->cofinspercentual,
						"Valor" => $NotaFiscalpb->cofinsvalor,
					);
				$totalCofins += $NotaFiscalpb->cofinsvalor;
				
			}
			else
			{

				$arr["ICMS" . Yii::app()->format->formataPorMascara($i, "###", true)] = 
					array(
						//"CST" => Nz(prsItem!csosn,
						"CSOSN" => $NotaFiscalpb->csosn,
						//"ValorBase" => Nz(prsItem!icmsbase,
						//"Aliquota" => Nz(prsItem!icmspercentual,
						//"valor" => Nz(prsItem!icmsvalor,
						//"ValorBase=0\n";
						//"Aliquota=0\n";
						//"valor=0\n";
					);
				
			}
			
			$i++;

		}
		
		//Totais
		$arr["Total"] = 
			array(
				"ValorProduto" => $this->NotaFiscal->valorprodutos,
				"ValorFrete" => $this->NotaFiscal->valorfrete,
				"ValorSeguro" => $this->NotaFiscal->valorseguro,
				"ValorDesconto" => $this->NotaFiscal->valordesconto,
				"ValorOutrasDespesas" => $this->NotaFiscal->valoroutras,
				"ValorNota" => $this->NotaFiscal->valortotal,
			);

		if ($this->NotaFiscal->Filial->crt == Filial::CRT_REGIME_NORMAL)
		{
			$arr["Total"]["ValorPIS"]    = $totalPis;
			$arr["Total"]["ValorCOFINS"] = $totalCofins;
			$arr["Total"]["BaseICMS"]    = $this->NotaFiscal->icmsbase;
			$arr["Total"]["ValorICMS"]   = $this->NotaFiscal->icmsvalor;
		}
		
		//Transportador
		$arr["Transportador"] =
			array(
				"FretePorConta" => $this->NotaFiscal->frete,
			);
		
		//Volumes
		if ($this->NotaFiscal->volumes > 0)
			$arr["Volume001"] =
				array(
					"Quantidade" => $this->NotaFiscal->volumes,
				);
		
		//Duplicatas
		$i = 1;
		$totalDup = 0;
		foreach ($this->NotaFiscal->NotaFiscalDuplicatass as $dup)
		{
			$totalDup += $dup->valor;
			
			if ($this->NotaFiscal->modelo != NotaFiscal::MODELO_NFCE)
				$arr["Duplicata" . Yii::app()->format->formataPorMascara($i, "###", true)] =
					array(
						"Numero" => $dup->fatura,
						"DataVencimento" => $dup->vencimento,
						"Valor" => $dup->valor,
					);
					
			$i++;
			
		}
		
		if ($this->NotaFiscal->modelo == NotaFiscal::MODELO_NFCE)
		{
			if (empty($this->NotaFiscal->Pessoa->cnpj))
				unset($arr["Destinatario"]["CNPJ"]);
			
			$arr["Identificacao"]["Emissao"] .= " " . date("H:i:s");
			$arr["Identificacao"]["Saida"] .= " " . date("H:i:s");
			$arr["Identificacao"]["ProcEmi"] = 0;
			$arr["Identificacao"]["tpImp"] = 4;
			$arr["Identificacao"]["tpemis"] = 1;
			$arr["Identificacao"]["indFinal"] = 1;
			$arr["Identificacao"]["indPres"] = 1;
			$arr["Identificacao"]["Finalidade"] = 1;
			unset($arr["Identificacao"]["Serie"]);
			unset($arr["Identificacao"]["Tipo"]);
			
			$arr["InfNFE"]["Versao"] = "3.10";
			
			if (!empty($this->NotaFiscal->Pessoa->ie))
				return $this->gerarErro ("Nao permitida emissao de NFC-e para Pessoas que tenham IE!");
			
			if ($this->NotaFiscal->codpessoa == Pessoa::CONSUMIDOR)
				unset($arr["Destinatario"]);
			else
			{
				$arr["Destinatario"]["indIedest"] = 9;
				unset($arr["Destinatario"]["IE"]);
			}
			
			
			//$arr["Transportador"]["FretePorConta"] = 9;

			//pagamentos
			//01=Dinheiro
			//02=Cheque
			//03=Cartão de Crédito
			//04=Cartão de Débito
			//05=Crédito Loja
			//10=Vale Alimentação
			//11=Vale Refeição
			//12=Vale Presente
			//13=Vale Combustível
			//99=Outros.
			
			//Total a Prazo
			$i = '001';
			if ($totalDup > 0)
			{
				$arr["Pag$i"]["Tpag"] = 05; // Credito Loja
				$arr["Pag$i"]["Vpag"] = $totalDup;
				$i = '002';
			}
			
			//Total a vista
			if ($this->NotaFiscal->valortotal > $totalDup)
			{
				$arr["Pag$i"]["Tpag"] = 01; // Dinheiro
				$arr["Pag$i"]["Vpag"] = $this->NotaFiscal->valortotal - $totalDup;
				$i = '003';
			}
			
		}

		//Dados Adicionais
		$compl = $this->NotaFiscal->observacoes;
		$compl = str_replace("\n", ";", $compl);
		$compl = str_replace("\r", "", $compl);
		
		//substitui ICMSVALOR e ICMSPERCENTUAL da observacao
		$compl = str_replace("#ICMSVALOR#", Yii::app()->format->formatNumber($this->NotaFiscal->icmsvalor), $compl);
		if ($this->NotaFiscal->icmsbase > 0 && $this->NotaFiscal->icmsvalor > 0)
			$perc = ($this->NotaFiscal->icmsvalor / $this->NotaFiscal->icmsbase) * 100;
		else
			$perc = 0;
		$compl = str_replace("#ICMSPERCENTUAL#", Yii::app()->format->formatNumber($perc), $compl);

		//Adiciona valor aproximado tributos
		$command = Yii::app()->db->createCommand("SELECT max(valoribpt) FROM vwIbptaxNotaFiscal WHERE codNotaFiscal = :codnotafiscal");
		$command->params = array(':codnotafiscal' => $this->NotaFiscal->codnotafiscal);
		if ($ibpt = $command->queryScalar())
		{
			$compl = str_replace("#IBPTVALOR#", Yii::app()->format->formatNumber($ibpt), $compl);
		}
		
		if ($this->NotaFiscal->modelo == NotaFiscal::MODELO_NFCE)
			$compl = str_replace (";", " ", $compl);
		
		$arr["DadosAdicionais"] =
			array(
				"Complemento" => $compl,
			);

		//Monta Comando
		$cmd = "NFE.CriarNFe(\"\n";
		$cmd .= $this->geraIni($arr);
		$cmd .= "\")\n.\n";

		//Envia Comando
		if (!$this->enviaComando($cmd))
			return false;
		
		//Se retornou diferente de OK aborta
		if ($this->retornoMonitor["Mensagem"][0] != "OK")
		{
			$this->erroMonitor = $this->retornoMonitor["Mensagem"][1];
			return false;
		}
		
		//
		// Processa Chave da NFE
		// C:\ACBrNFeMonitor\Arquivos\EnvioResp\51110404576775000160550010000000011000000016-nfe.xml
		$chave = $this->retornoMonitor["Mensagem"][1];
		$chave = str_replace($this->Filial->acbrnfemonitorcaminho, "", $chave);
		$chave = str_replace("\\Arquivos\\EnvioResp\\", "", $chave);
		$chave = str_replace("-nfe.xml", "", $chave);

		//grava chave da NFE
		$this->NotaFiscal->nfechave = $chave;
		$this->NotaFiscal->update();
		
		$this->montaUrlPdf();
		
		//retorna sucesso
		return true;

	}

	public function confereNumero()
	{

		If (!empty($this->NotaFiscal->numero))
			return true;
		
		$numero = Codigo::PegaProximo(
			"NumeroNotaFiscal-CodFilial#" 
			. $this->NotaFiscal->codfilial 
			. "-Serie#" . $this->NotaFiscal->serie
			. "-Modelo#" . $this->NotaFiscal->modelo
		);
		
		if (empty($numero))
			return false;
		
		$this->NotaFiscal->numero = $numero;
		$this->NotaFiscal->emissao = date('d/m/Y');
		$this->NotaFiscal->saida = date('d/m/Y');
		$this->NotaFiscal->update();
		
		return true;
		
	}
	
	//EnviarNFE
	public function enviarNfe()
	{
		if (!in_array($this->NotaFiscal->codstatus, array(NotaFiscal::CODSTATUS_NAOAUTORIZADA, NotaFiscal::CODSTATUS_DIGITACAO)))
			return $this->gerarErro("Status da Nota Fiscal nao permite envio ao Sefaz!");
		
		if (!$this->NotaFiscal->emitida)
			return $this->gerarErro("Nota Fiscal nao e de nossa emissao!");

		//Monta Comando
		$cmd = "NFE.EnviarNFe(\"";
		$cmd .= $this->Filial->acbrnfemonitorcaminho . "\\Arquivos\\EnvioResp\\" . $this->NotaFiscal->nfechave . "-nfe.xml";
		$cmd .= "\", 1, 1, 1, 1, 1)\n.\n";
			
		//Envia Comando
		if (!$this->enviaComando($cmd))
			return false;
		
		//Se retornou diferente de OK aborta
		if ($this->retornoMonitor["Mensagem"][0] != "OK")
			return false;
		
		//Salva retorno do envio
		return $this->salvaRetorno();
		
	}
	
	//ConsultaNFE
	public function consultarNfe()
	{
		if (!$this->NotaFiscal->emitida)
			return $this->gerarErro("Nota Fiscal nao e de nossa emissao!");

		$mes = '20' . substr($this->NotaFiscal->nfechave, 2, 4);
		
		//Monta Comando
		$cmd  = "NFE.ConsultarNFE(\"";
		$cmd .= $this->Filial->acbrnfemonitorcaminho . "\\Arquivos\\NFe\\$mes\\" . $this->NotaFiscal->nfechave . "-nfe.xml";
		$cmd .= "\")\n.\n";
		
		//Envia Comando
		if (!$this->enviaComando($cmd))
			return false;
		
		if ($this->retornoMonitor["Mensagem"][0] == "ERRO")
		{
			
			//Monta Comando
			$cmd  = "NFE.ConsultarNFE(\"";
			$cmd .= $this->Filial->acbrnfemonitorcaminho . "\\Arquivos\\EnvioResp\\" . $this->NotaFiscal->nfechave . "-nfe.xml";
			$cmd .= "\")\n.\n";
			
			//Envia Comando
			if (!$this->enviaComando($cmd))
				return false;
		}
		
		//Se retornou diferente de OK aborta
		if ($this->retornoMonitor["Mensagem"][0] != "OK")
			return false;
		
		return $this->salvaRetorno();
		
	}
	
	public function imprimirDanfePdf()
	{
		
		if (!$this->NotaFiscal->emitida)
			return $this->gerarErro("Nota Fiscal nao e de nossa emissao!");
		
		$mes = '20' . substr($this->NotaFiscal->nfechave, 2, 4);
		
		//Monta Comando
		$cmd = "NFE.ImprimirDANFEPDF(\"";
		$cmd .= $this->Filial->acbrnfemonitorcaminho . "\\Arquivos\\NFe\\$mes\\" . $this->NotaFiscal->nfechave . "-nfe.xml";
		$cmd .= "\")\n.\n";
		
		
		//Envia Comando
		if (!$this->enviaComando($cmd))
			return false;
		
		//Se retornou diferente de OK aborta
		if ($this->retornoMonitor["Mensagem"][0] != "OK")
			return false;
		
		return true;
	}
	
	public function imprimirDanfePdfTermica($impressoraUsuarioCriacao = false)
	{
		if ($this->NotaFiscal->modelo != NotaFiscal::MODELO_NFCE)
			return false;
		
		$arquivo = "{$this->NotaFiscal->nfechave}.pdf";
		
		if ($impressoraUsuarioCriacao)
			$impressora = $this->NotaFiscal->UsuarioCriacao->impressoratermica;
		else
			$impressora = Yii::app()->user->impressoraTermica;
		
		$cmd = "cd /tmp; rm -f $arquivo; wget {$this->urlpdf} ; lpr -P $impressora $arquivo;";
		return exec($cmd);		
	}
	
	public function imprimirDanfe()
	{
		
		if (!$this->NotaFiscal->emitida)
			return $this->gerarErro("Nota Fiscal nao e de nossa emissao!");
		
		$mes = '20' . substr($this->NotaFiscal->nfechave, 2, 4);
		
		//Monta Comando
		$cmd = "NFE.ImprimirDANFE(\"";
		$cmd .= $this->Filial->acbrnfemonitorcaminho . "\\Arquivos\\NFe\\$mes\\" . $this->NotaFiscal->nfechave . "-nfe.xml";
		$cmd .= "\", \"". Yii::app()->user->getState('impressoraTermica') ."\")\n.\n";
		
		//Envia Comando
		if (!$this->enviaComando($cmd))
			return false;
		
		//Se retornou diferente de OK aborta
		if ($this->retornoMonitor["Mensagem"][0] != "OK")
			return false;
		
		return true;
	}	
	
	public function cancelarNfe($justificativa)
	{
		if (!$this->NotaFiscal->emitida)
			return $this->gerarErro("Nota Fiscal nao e de nossa emissao!");
		
		if (strlen($justificativa) < 15)
			return $this->gerarErro("Texto de justificativa deve ter no minimo 15 caracteres!");
		
		//Monta Comando
		$cmd = "NFE.CancelarNFE(\"";
		$cmd .= $this->NotaFiscal->nfechave;
		$cmd .= "\", \"$justificativa\")\n.\n";
		$cmd .= "\")\n.\n";
		
		//Envia Comando
		if (!$this->enviaComando($cmd))
			return false;
		
		//Se retornou diferente de OK aborta
		if ($this->retornoMonitor["Mensagem"][0] != "OK")
			return false;
		
		return $this->salvaRetorno($justificativa);
	}
	
	public function inutilizarNfe($justificativa)
	{
		if (!$this->NotaFiscal->emitida)
			return $this->gerarErro("Nota Fiscal nao e de nossa emissao!");
		
		if (strlen($justificativa) < 15)
			return $this->gerarErro("Texto de justificativa deve ter no minimo 15 caracteres!");
		
		//Monta Comando
		$cmd = "Nfe.InutilizarNFE (\"" . Yii::app()->format->formataPorMascara($this->Filial->Pessoa->cnpj, "##############", true) . "\"";
		$cmd .= ", \"" . $justificativa . "\"";
		$cmd .= ", \"" . substr($this->NotaFiscal->emissao, 6, 4) . "\"";
		$cmd .= ", \"" . $this->NotaFiscal->modelo . "\"";
		$cmd .= ", \"" . $this->NotaFiscal->serie . "\"";
		$cmd .= ", \"" . $this->NotaFiscal->numero . "\"";
		$cmd .= ", \"" . $this->NotaFiscal->numero . "\")\n.\n";
		
		//Envia Comando
		if (!$this->enviaComando($cmd))
			return false;
		
		if (trim($this->retorno) == 'ERRO: Rejeicao: Acesso BD NFE-Inutilizacao (Chave: Ano, CNPJ Emit, Modelo, Serie, nNFIni, nNFFin): ja existe um Pedido de inutilizacao igual (NT 2011/004)'
			|| trim($this->retorno) == 'ERRO: Rejeicao: uma NF-e da faixa ja esta inutilizada na Base de dados da SEFAZ')
		{
			if (empty($this->NotaFiscal->nfeinutilizacao))
				$this->NotaFiscal->nfeinutilizacao = '999999999999999';
			
			if (empty($this->NotaFiscal->nfedatainutilizacao))
				$this->NotaFiscal->nfedatainutilizacao = date('d/m/Y H:i:s');
			
			if (empty($this->NotaFiscal->justificativa))
				$this->NotaFiscal->justificativa = $justificativa;
			
			return $this->NotaFiscal->update();
		}
		
		//Se retornou diferente de OK aborta
		if ($this->retornoMonitor["Mensagem"][0] != "OK")
			return false;
		
		return $this->salvaRetorno($justificativa);
	}
	
	public function cartaCorrecao($texto)
	{
		if (!$this->NotaFiscal->emitida)
			return $this->gerarErro("Nota Fiscal nao e de nossa emissao!");
		
		if ($this->NotaFiscal->codstatus != NotaFiscal::CODSTATUS_AUTORIZADA)
			return $this->gerarErro("Status da nota nao permite emissao de carta de correcao!");

		//Verifica se o texto tem mais de 15 caracteres
		if (strlen($texto) < 15)
			return $this->gerarErro("Texto deve ter no minimo 15 caracteres!");
		
		//armazena o timestamp
		$data = date('d/m/Y H:i:s');
		
		//descobre numero do lote e sequencia
		$lote = 0;
		$sequencia = 0;
		foreach ($this->NotaFiscal->NotaFiscalCartaCorrecaos as $cc)
		{
			if ($cc->lote > $lote)
				$lote = $cc->lote;
			if ($cc->sequencia > $sequencia)
				$sequencia = $cc->sequencia;
		}
		$lote++;
		$sequencia++;

		$cmd  = "NFE.CARTADECORRECAO(\"[CCE] \n";
		$cmd .= "idLote=$lote\n";
		$cmd .= "[EVENTO001]\n";
		$cmd .= "chNFe=" . $this->NotaFiscal->nfechave . "\n";
		$cmd .= "cOrgao=" . substr($this->NotaFiscal->nfechave, 0, 2) . "\n";
		$cmd .= "CNPJ=" . substr($this->NotaFiscal->nfechave, 6, 14) . "\n";
		$cmd .= "dhEvento=$data\n";
		$cmd .= "nSeqEvento=$sequencia\n";
		$cmd .= "xCorrecao=$texto\n";
		$cmd .= "\")\n.\n";
		
		//Envia Comando
		if (!$this->enviaComando($cmd))
			return false;
		
		//Se retornou diferente de OK aborta
		if ($this->retornoMonitor["Mensagem"][0] != "OK")
			return false;
		
		if ($this->retornoMonitor["EVENTO001"]["cStat"] <> 135)
			return false;
		
		$cc = new NotaFiscalCartaCorrecao();
		
		$cc->codnotafiscal = $this->NotaFiscal->codnotafiscal;
		$cc->lote = $lote;
		$cc->data = $data;
		$cc->sequencia = $sequencia;
		$cc->texto = $texto;
		$cc->protocolo = $this->retornoMonitor["EVENTO001"]["nProt"];
		$cc->protocolodata = $this->retornoMonitor["EVENTO001"]["dhRegEvento"];
		
		if (!$cc->save())
		{
			$this->erroMonitor = "Erro ao salvar";
			$this->retorno = $cc->getErrors();
			return false;
		}
		
		return true;
		
	}

	/**
	 * Envia e-mail da NFE com arquivo xml, e altera o cadastro caso solicitado
	 * @param string $email
	 * @param boolean $alterarcadastro
	 * @return boolean
	 */
	public function enviarEmail($email, $alterarcadastro = false)
	{
		if (!$this->NotaFiscal->emitida)
			return $this->gerarErro("Nota Fiscal nao e de nossa emissao!");
		
		//se nao passou email 
		if (empty($email))
			return $this->gerarErro("Nenhum email informado!");
		
		//altera cadastro da pessoa
		if ($alterarcadastro)
		{
			Yii::app()->db
				->createCommand("UPDATE tblPessoa SET emailnfe = :emailnfe WHERE codpessoa=:codpessoa")
				->bindValues(array(':emailnfe' => $email, ':codpessoa' => $this->NotaFiscal->codpessoa))
				->execute();			
		}
		
		//verifica se e mais de um email
		$email = str_replace(",", ";", $email);
		$email = str_replace(" ", ";", $email);
		if (strstr($email, ";"))
			$emails = explode(";", $email);
		else
			$emails = array($email);
		
		//percorre todos os emails
		foreach ($emails as $email)
		{
			$email = trim($email);
			
			if (empty($email))
				next;

			$mes = '20' . substr($this->NotaFiscal->nfechave, 2, 4);

			//Monta Comando
			$cmd = "NFE.EnviarEmail(\"$email\", \"";
			$cmd .= $this->Filial->acbrnfemonitorcaminho . "\\Arquivos\\NFe\\$mes\\" . $this->NotaFiscal->nfechave . "-nfe.xml";
			$cmd .= "\", \"1\")\n.\n";

			//Envia Comando
			if (!$this->enviaComando($cmd))
				return false;

			//Se retornou diferente de OK aborta
			if ($this->retornoMonitor["Mensagem"][0] != "OK")
				return false;
			
		}
		
		return true;
	}
	
	/**
	 * Busca listagem de NFes emitidas por terceiros na base da sefaz a partir do NSU informado
	 * @param bigint $nsu
	 * @return boolean
	 */
	public function consultaNfeDest($nsu = 0)
	{
		//Monta Comando
		$cnpj = str_pad($this->Filial->Pessoa->cnpj, 14, 0, STR_PAD_LEFT);
		$cmd = "NFE.ConsultaNFeDest(\"{$cnpj}\", 0, 0, {$nsu})\n.\n";
		
		$ret = $this->enviaComando($cmd);
		
		$this->processaRetorno();
		
		return $ret;
	}
	
	/**
	 * Efetua o Download do arquivo XML de uma NFe de terceiro
	 * @return boolean
	 */
	public function downloadNfe()
	{
		//Monta Comando
		$cnpj = str_pad($this->Filial->Pessoa->cnpj, 14, 0, STR_PAD_LEFT);
		$cmd = "NFE.DownloadNFe(\"{$cnpj}\", \"{$this->NfeTerceiro->nfechave}\")\n.\n";
		
		if (!$this->enviaComando($cmd))
			return false;
		
		$this->processaRetorno();
		
		if ($this->retornoMonitor["Mensagem"][0] != "OK")
		{
			$this->erroMonitor = isset($this->retornoMonitor["NFE001"]["xMotivo"])?$this->retornoMonitor["NFE001"]["xMotivo"]:"";
			return false;
		}
		
		if (!isset($this->retornoMonitor["NFE001"]["cStat"]))
		{
			$this->erroMonitor = isset($this->retornoMonitor["NFE001"]["xMotivo"])?$this->retornoMonitor["NFE001"]["xMotivo"]:"";
			return false;
		}
		
		if ($this->retornoMonitor["NFE001"]["cStat"] <> 140)
		{
			$this->erroMonitor = isset($this->retornoMonitor["NFE001"]["xMotivo"])?$this->retornoMonitor["NFE001"]["xMotivo"]:"";
			return false;
		}
		
		$this->retornoMonitor["Mensagem"][1] = isset($this->retornoMonitor["NFE001"]["xMotivo"])?$this->retornoMonitor["NFE001"]["xMotivo"]:$this->retornoMonitor["Mensagem"][1];
		
		
		$pos = strpos($this->retorno, 'procNFe=');
		$stringxml = substr($this->retorno, $pos + 8);
		
		if (!$this->NfeTerceiro->importarXmlViaString($stringxml))
			return false;
		
		return true;
		
	}
	
	/**
	 * Envia evento de manifestacao do destinatario de uma NFe de Terceiro
	 * @param int $indManifestacao 
	 * @return boolean
	 */
	public function enviarEventoManifestacao($indManifestacao, $justificativa)
	{
		
		switch ($indManifestacao)
		{
			case NfeTerceiro::INDMANIFESTACAO_CONFIRMADA:
				$tpEvento = 210200;
				break;
			
			case NfeTerceiro::INDMANIFESTACAO_DESCONHECIDA:
				$tpEvento = 210220;
				break;
			
			case NfeTerceiro::INDMANIFESTACAO_NAOREALIZADA:
				$tpEvento = 210240;
				break;
			
			case NfeTerceiro::INDMANIFESTACAO_CIENCIA:
				$tpEvento = 210210;
				break;

			default:
				return false;
				break;
		}
		
		if ($indManifestacao == NfeTerceiro::INDMANIFESTACAO_NAOREALIZADA)
			if (strlen($justificativa) < 15)
				return $this->gerarErro("Texto de justificativa deve ter no minimo 15 caracteres!");
		
		$cnpj = str_pad($this->Filial->Pessoa->cnpj, 14, 0, STR_PAD_LEFT);
		$data = date('d/m/Y H:i:s');

		//Monta Comando
		$cmd  = "NFE.ENVIAREVENTO(\"[EVENTO] \n";
		$cmd .= "idLote=1\n";
		$cmd .= "[EVENTO001]\n";
		$cmd .= "chNFe={$this->NfeTerceiro->nfechave}\n";
		$cmd .= "cOrgao=91\n";
		$cmd .= "CNPJ={$cnpj}\n";
		if (!empty($justificativa))
			$cmd .= "xJust={$justificativa}\n";
		$cmd .= "dhEvento={$data}\n";
		$cmd .= "tpEvento={$tpEvento}\n";
		$cmd .= "nSeqEvento=1\n";
		$cmd .= "versaoEvento=1.00\n";
		$cmd .= "\")\n.\n";
		
		if (!$this->enviaComando($cmd))
			return false;
		
		$this->processaRetorno();
		
		//Se retornou diferente de OK aborta
		if ($this->retornoMonitor["Mensagem"][0] != "OK")
		{
			$this->erroMonitor = isset($this->retornoMonitor["EVENTO001"]["xMotivo"])?$this->retornoMonitor["EVENTO001"]["xMotivo"]:"";
			return false;
		}
		
		if ($this->retornoMonitor["EVENTO001"]["cStat"] <> 135)
		{
			$this->erroMonitor = isset($this->retornoMonitor["EVENTO001"]["xMotivo"])?$this->retornoMonitor["EVENTO001"]["xMotivo"]:"";
			return false;
		}
		
		$this->retornoMonitor["Mensagem"][1] = isset($this->retornoMonitor["EVENTO001"]["xMotivo"])?$this->retornoMonitor["EVENTO001"]["xMotivo"]:$this->retornoMonitor["Mensagem"][1];	

		$this->NfeTerceiro->indmanifestacao = $indManifestacao;
		$this->NfeTerceiro->justificativa = $justificativa;
		return $this->NfeTerceiro->save();
	}
	
	
	public function salvaRetorno($justificativa = "")
	{
		
		if (isset($this->retornoMonitor["ENVIO"]))
		{
			//Grava Recibo Envio
			if (isset($this->retornoMonitor["ENVIO"]["NRec"]))
				$this->NotaFiscal->nfereciboenvio = $this->retornoMonitor["ENVIO"]["NRec"];

			//Grava Data e Hora de Envio
			if (isset($this->retornoMonitor["ENVIO"]["DhRecbto"]))
				$this->NotaFiscal->nfedataenvio = $this->retornoMonitor["ENVIO"]["DhRecbto"];

			//Salva
			$this->NotaFiscal->update();

			//Se o envio nao teve status 103 - Lote recebido com sucesso
			if ($this->retornoMonitor["ENVIO"]["CStat"] != 103)
			{
				$this->erroMonitor = $this->retornoMonitor["ENVIO"]["XMotivo"];
				return false;
			}	
		}
		
		if (isset($this->retornoMonitor["RETORNO"]))
		{
			//Se o retorno nao teve status 100 - Autorizado nem 302 - Denegado
			if ($this->retornoMonitor["RETORNO"]["CStat"] != 100 && $this->retornoMonitor["RETORNO"]["CStat"] != 302) 
			{
				$this->erroMonitor = $this->retornoMonitor["RETORNO"]["XMotivo"];
				return false;			
			}
		}

		
		//NFE123 - Nfe número 123
		$nfe = "NFE" . $this->NotaFiscal->numero;
		if (isset($this->retornoMonitor[$nfe]))
		{
			//Se a NFE nao teve status 100 - Autorizado nem 302 - Denegado
			if ($this->retornoMonitor[$nfe]["CStat"] != 100 && $this->retornoMonitor[$nfe]["CStat"] != 302) 
			{
				$this->erroMonitor = $this->retornoMonitor[$nfe]["XMotivo"];
				return false;			
			}

			//Denegada
			if ($this->retornoMonitor[$nfe]["CStat"] == 302) 
			{

				//Grava protocolo cancelamento iguao ao envio
				$this->NotaFiscal->nfecancelamento = $this->NotaFiscal->nfereciboenvio;
				if (empty($this->NotaFiscal->nfecancelamento)) 
					$this->NotaFiscal->nfecancelamento = "999999999999999";

				//Data e Hora
				$this->NotaFiscal->nfedatacancelamento = $this->NotaFiscal->nfedataenvio;
				if (empty($this->NotaFiscal->nfedatacancelamento)) 
					$this->NotaFiscal->nfedatacancelamento = date('d/m/Y H:i:s');

				//Justificativa
				$this->NotaFiscal->justificativa = substr($this->retornoMonitor[$nfe]["XMotivo"], 0, 200);
				if (empty($this->NotaFiscal->justificativa)) 
					$this->NotaFiscal->justificativa = "Uso Denegado";

				//salva
				$this->NotaFiscal->update();

				//retorna
				$this->erroMonitor = $this->NotaFiscal->justificativa;
				return false;
			}

			//se chegou ate aqui e porque foi autorizada
			$this->NotaFiscal->nfeautorizacao = $this->retornoMonitor[$nfe]["NProt"];
			$this->NotaFiscal->nfedataautorizacao = $this->retornoMonitor[$nfe]["DhRecbto"];

			//salva
			$this->NotaFiscal->update();
		}
		
		//consulta
		if (isset($this->retornoMonitor["CONSULTA"]))
		{
			switch ($this->retornoMonitor["CONSULTA"]["CStat"])
			{
				//cancelada
				case 101:
					$this->NotaFiscal->nfecancelamento = $this->retornoMonitor["CONSULTA"]["NProt"];
					$this->NotaFiscal->nfedatacancelamento = $this->retornoMonitor["CONSULTA"]["DhRecbto"];
					break;
				
				//inexistente
				case 217:
					break;
				
				//denegada
				case 302:
					//protocolo
					$this->NotaFiscal->nfecancelamento = $this->NotaFiscal->nfereciboenvio;
					if (empty($this->NotaFiscal->nfecancelamento))
						$this->NotaFiscal->nfecancelamento = "999999999999999";
					
					//data e hora
					$this->NotaFiscal->nfedatacancelamento = $this->NotaFiscal->nfedataenvio;
					if (empty($this->NotaFiscal->nfedatacancelamento))
						$this->NotaFiscal->nfedatacancelamento = date('d/m/Y H:i:s');
					
					//justificativa
					$this->NotaFiscal->justificativa = substr($this->retornoMonitor["CONSULTA"]["XMotivo"], 0, 200);
					if (empty($this->NotaFiscal->justificativa)) 
						$this->NotaFiscal->justificativa = "Uso Denegado";
					break;
				
				//autorizada
				default :
					$this->NotaFiscal->nfeautorizacao = $this->retornoMonitor["CONSULTA"]["NProt"];
					$this->NotaFiscal->nfedataautorizacao = $this->retornoMonitor["CONSULTA"]["DhRecbto"];
					break;
					
			}
			
			$this->NotaFiscal->update();
		
		}
		
		//cancelamento
		if (isset($this->retornoMonitor["CANCELAMENTO"]))
		{
			
			if ($this->retornoMonitor["CANCELAMENTO"]["CStat"] != 135)
			{
				$this->erroMonitor = $this->retornoMonitor["CANCELAMENTO"]["XMotivo"];
				return false;
			}
			
			$this->NotaFiscal->nfecancelamento = $this->retornoMonitor["CANCELAMENTO"]["NProt"];
			$this->NotaFiscal->nfedatacancelamento = $this->retornoMonitor["CANCELAMENTO"]["DhRecbto"];
			$this->NotaFiscal->justificativa = $justificativa;
			
			$this->NotaFiscal->update();		
			
		}
		
		//Inutilizacao
		if (isset($this->retornoMonitor["INUTILIZACAO"]))
		{
			
			if ($this->retornoMonitor["INUTILIZACAO"]["CStat"] != 102)
			{
				$this->erroMonitor = $this->retornoMonitor["INUTILIZACAO"]["XMotivo"];
				return false;
			}
			
			$this->NotaFiscal->nfeinutilizacao = $this->retornoMonitor["INUTILIZACAO"]["NProt"];
			$this->NotaFiscal->nfedatainutilizacao = $this->retornoMonitor["INUTILIZACAO"]["DhRecbto"];
			$this->NotaFiscal->justificativa = $justificativa;
			
			$this->NotaFiscal->update();		
			
		}
		
		//retorna verdadeiro
		return true;
		
	}
	
	
}

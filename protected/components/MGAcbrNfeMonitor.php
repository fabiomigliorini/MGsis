<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MGSocket
 *
 * @author Fabio Migliorini
 * @property NotaFiscal $model           Model da Nota Fiscal
 * @property Array      $retornoMonitor  Model da Nota Fiscal
 * @property string     $erroMonitor     Descricao do erro ocorrido na comunicacao com o monitor
 */
class MGAcbrNfeMonitor extends MGSocket 
{
	public $model;
	
	public $erroMonitor;
	public $retornoMonitor;
	
	public function __construct($model, $servidor = NULL, $porta = NULL)
	{
		$this->model = $model;
		
		if (isset($this->model->Filial))
			return parent::__construct($this->model->Filial->acbrnfemonitorip, $this->model->Filial->acbrnfemonitorporta);
		else
			return parent::__construct ();
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
	
	
	public function recebe($timeout = 10)
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
		
		if (!$this->model->emitida)
			return $this->gerarErro("Nota Fiscal nao e de nossa emissao!");
		
		if (!$this->confereNumero())
			return $this->gerarErro("Erro ao gerar numero da Nota Fiscal!");
		
		$arr = array(
			//Identificacao
			"Identificacao" => array(
				"NaturezaOperacao" => $this->model->NaturezaOperacao->naturezaoperacao,
				"Codigo" => $this->model->numero,
				"Emissao" => $this->model->emissao,
				"Saida" => $this->model->saida,
				"Modelo" => $this->model->modelo,
				"Serie" => $this->model->serie,
				"Numero" => $this->model->numero,
				"Tipo" => ($this->model->codoperacao == 1)?2:1,
				"FormaPag" => (sizeof($this->model->NotaFiscalDuplicatass)>0)?1:0,				
			),
			//Emitente
			"Emitente" => array(
				"CNPJ" => Yii::app()->format->formataPorMascara($this->model->Filial->Pessoa->cnpj, "##############", true),
				"IE" => $this->model->Filial->Pessoa->ie,
				"Razao" => $this->model->Filial->Pessoa->pessoa,
				"Fantasia" => $this->model->Filial->Pessoa->fantasia,
				"Fone" => Yii::app()->format->numeroLimpo($this->model->Filial->Pessoa->telefone1),
				"CEP" => $this->model->Filial->Pessoa->cep,
				"Logradouro" => $this->model->Filial->Pessoa->endereco,
				"Numero" => $this->model->Filial->Pessoa->numero,
				"Complemento" => $this->model->Filial->Pessoa->complemento,
				"Bairro" => $this->model->Filial->Pessoa->bairro,
				"CidadeCod" => $this->model->Filial->Pessoa->Cidade->codigooficial,
				"Cidade" => $this->model->Filial->Pessoa->Cidade->cidade,
				"UF" => $this->model->Filial->Pessoa->Cidade->Estado->sigla,
				"CRT" => $this->model->Filial->crt,
			),
			//Destinatario
			"Destinatario" => array(
				"CNPJ" => ($this->model->Pessoa->fisica)?
					Yii::app()->format->formataPorMascara($this->model->Pessoa->cnpj, "###########", true):
					Yii::app()->format->formataPorMascara($this->model->Pessoa->cnpj, "##############", true),
				"IE" => empty($this->model->Pessoa->ie)?"ISENTO":$this->model->Pessoa->ie,
				"NomeRazao" => substr($this->model->Pessoa->pessoa, 0, 60),
				"Fone" => Yii::app()->format->numeroLimpo($this->model->Pessoa->telefone1),
				"CEP" => $this->model->Pessoa->cep,
				"Logradouro" => $this->model->Pessoa->endereco,
				"Numero" => $this->model->Pessoa->numero,
				"Complemento" => $this->model->Pessoa->complemento,
				"Bairro" => $this->model->Pessoa->bairro,
				"CidadeCod" => $this->model->Pessoa->Cidade->codigooficial,
				"Cidade" => $this->model->Pessoa->Cidade->cidade,
				"UF" => $this->model->Pessoa->Cidade->Estado->sigla,
			),
			
		);
		
		
		
		//Produtos
		$i = 1;
		foreach ($this->model->NotaFiscalProdutoBarras as $nfpb)
		{
			$arr["Produto" . Yii::app()->format->formataPorMascara($i, "###", true)] = 
				array(
					"CFOP" => $nfpb->codcfop,
					"Codigo" => 
						Yii::app()->format->formataPorMascara($nfpb->ProdutoBarra->codproduto, "######") 
						//. empty($nfpb->ProdutoBarra->codprodutoembalagem)?"":"*" . $nfpb->ProdutoBarra->ProdutoEmbalagem->quantidade
						,
					"EAN" => 
						strlen($nfpb->ProdutoBarra->barras) >= 10?
						Yii::app()->format->numeroLimpo($nfpb->ProdutoBarra->barras):"",
					/*
					If Len(NumeroLimpo($nfpb->barras)) > 6 _
						And NumeroLimpo(Mid($nfpb->barras, 1, 6)) <> Format($nfpb->codproduto, "000000") _
						And NumeroLimpo(Mid($nfpb->barras, 1, 3)) <> "999" _
						And ValidaEan($nfpb->barras) Then
					End If
					 */ 
					"Descricao" => $nfpb->ProdutoBarra->descricao,
					"Unidade" => $nfpb->ProdutoBarra->UnidadeMedida->sigla,
					"NCM" => Yii::app()->format->formataPorMascara($nfpb->ProdutoBarra->Produto->ncm, "########"),
					"Quantidade" => $nfpb->quantidade,
					"ValorUnitario" => $nfpb->valorunitario,
					"ValorTotal" => $nfpb->valortotal,
					"ValorDesconto" => round(($this->model->valordesconto / $this->model->valorprodutos) * $nfpb->valortotal, 2),
					"vFrete" => round(($this->model->valorfrete / $this->model->valorprodutos) * $nfpb->valortotal, 2),
					"vSeg" => round(($this->model->valorseguro / $this->model->valorprodutos) * $nfpb->valortotal, 2),
					"vOutro" => round(($this->model->valoroutras / $this->model->valorprodutos) * $nfpb->valortotal, 2),
				);
			
			$arr["ICMS" . Yii::app()->format->formataPorMascara($i, "###", true)] = 
				array(
					//"CST" => Nz(prsItem!csosn,
					"CSOSN" => $nfpb->csosn,
					//"ValorBase" => Nz(prsItem!icmsbase,
					//"Aliquota" => Nz(prsItem!icmspercentual,
					//"valor" => Nz(prsItem!icmsvalor,
					//"ValorBase=0\n";
					//"Aliquota=0\n";
					//"valor=0\n";
				);

			$i++;

		}
		
		//Totais
		$arr["Total"] = 
			array(
				//"BaseICMS" => $this->model->icmsbase,
				//"ValorICMS" => $this->model->icmsvalor,
				//"BaseICMS=0\n";
				//"ValorICMS=0\n";
				"ValorProduto" => $this->model->valorprodutos,
				"ValorFrete" => $this->model->valorfrete,
				"ValorSeguro" => $this->model->valorseguro,
				"ValorDesconto" => $this->model->valordesconto,
				"ValorOutrasDespesas" => $this->model->valoroutras,
				"ValorNota" => $this->model->valortotal,
			);
		
		//Transportador
		$arr["Transportador"] =
			array(
				"FretePorConta" => ($this->model->fretepagar)?1:0,
			);
		
		//Volumes
		if ($this->model->volumes > 0)
			$arr["Volume001"] =
				array(
					"Quantidade" => $this->model->volumes,
				);
		
		//Duplicatas
		$i = 1;
		$totalDup = 0;
		foreach ($this->model->NotaFiscalDuplicatass as $dup)
		{
			$totalDup += $dup->valor;
			
			if ($this->model->modelo != NotaFiscal::MODELO_NFCE)
				$arr["Duplicata" . Yii::app()->format->formataPorMascara($i, "###", true)] =
					array(
						"Numero" => $dup->fatura,
						"DataVencimento" => $dup->vencimento,
						"Valor" => $dup->valor,
					);
					
			$i++;
			
		}
		
		if ($this->model->modelo == NotaFiscal::MODELO_NFCE)
		{
			
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
			
			if (!empty($this->model->Pessoa->ie))
				return $this->gerarErro ("Nao permitida emissao de NFC-e para Pessoas que tenham IE!");
			
			$arr["Destinatario"]["indIedest"] = 9;
			unset($arr["Destinatario"]["IE"]);
			
			$arr["Transportador"]["FretePorConta"] = 9;

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
			if ($this->model->valortotal > $totalDup)
			{
				$arr["Pag$i"]["Tpag"] = 01; // Dinheiro
				$arr["Pag$i"]["Vpag"] = $this->model->valortotal - $totalDup;
				$i = '003';
			}
			
		}

		//Dados Adicionais
		$compl = $this->model->observacoes;
		$compl = str_replace("\n", ";", $compl);
		$compl = str_replace("\r", "", $compl);
		
		//substitui ICMSVALOR e ICMSPERCENTUAL da observacao
		$compl = str_replace("#ICMSVALOR#", Yii::app()->format->formatNumber($this->model->icmsvalor), $compl);
		if ($this->model->icmsbase > 0 && $this->model->icmsvalor > 0)
			$perc = ($this->model->icmsvalor / $this->model->icmsbase) * 100;
		else
			$perc = 0;
		$compl = str_replace("#ICMSPERCENTUAL#", Yii::app()->format->formatNumber($perc), $compl);

		//Adiciona valor aproximado tributos
		$command = Yii::app()->db->createCommand("SELECT valoribpt, valortotal FROM vwIbptaxNotaFiscal WHERE codNotaFiscal = :codnotafiscal");
		$command->params = array(':codnotafiscal' => $this->model->codnotafiscal);
		if ($resultado = $command->queryAll())
		{
			$compl .= ";Valor Aprox Tributos R$ ";
			$compl .= Yii::app()->format->formatNumber($resultado[0]["valoribpt"]);
			$compl .= ". Fonte: IBPT";
		}
		
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
		$chave = str_replace($this->model->Filial->acbrnfemonitorcaminho, "", $chave);
		$chave = str_replace("\\Arquivos\\EnvioResp\\", "", $chave);
		$chave = str_replace("-nfe.xml", "", $chave);

		//grava chave da NFE
		$this->model->nfechave = $chave;
		$this->model->update();
		
		//retorna sucesso
		return true;

	}

	public function confereNumero()
	{

		If (!empty($this->model->numero))
			return true;
		
		$numero = Codigo::PegaProximo(
			"NumeroNotaFiscal-CodFilial#" 
			. $this->model->codfilial 
			. "-Serie#" . $this->model->serie
			. "-Modelo#" . $this->model->modelo
		);
		
		if (empty($numero))
			return false;
		
		$this->model->numero = $numero;
		$this->model->emissao = date('d/m/Y');
		$this->model->saida = date('d/m/Y');
		$this->model->update();
		
		return true;
		
	}
	
	//EnviarNFE
	public function enviarNfe()
	{
		
		if (!$this->model->emitida)
			return $this->gerarErro("Nota Fiscal nao e de nossa emissao!");

		//Monta Comando
		$cmd = "NFE.EnviarNFe(\"";
		$cmd .= $this->model->Filial->acbrnfemonitorcaminho . "\\Arquivos\\EnvioResp\\" . $this->model->nfechave . "-nfe.xml";
		$cmd .= "\")\n.\n";
			
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
		if (!$this->model->emitida)
			return $this->gerarErro("Nota Fiscal nao e de nossa emissao!");

		//Monta Comando
		$cmd  = "NFE.ConsultarNFE(\"";
		$cmd .= $this->model->Filial->acbrnfemonitorcaminho . "\\Arquivos\\NFe\\" . $this->model->nfechave . "-nfe.xml";
		$cmd .= "\")\n.\n";
		
		//Envia Comando
		if (!$this->enviaComando($cmd))
			return false;
		
		//Se retornou diferente de OK aborta
		if ($this->retornoMonitor["Mensagem"][0] != "OK")
			return false;
		
		return $this->salvaRetorno();
		
	}
	
	public function imprimirDanfePdf()
	{
		
		if (!$this->model->emitida)
			return $this->gerarErro("Nota Fiscal nao e de nossa emissao!");
		
		//Monta Comando
		$cmd = "NFE.ImprimirDANFEPDF(\"";
		$cmd .= $this->model->Filial->acbrnfemonitorcaminho . "\\Arquivos\\NFe\\" . $this->model->nfechave . "-nfe.xml";
		$cmd .= "\")\n.\n";
		
		//Envia Comando
		if (!$this->enviaComando($cmd))
			return false;
		
		//Se retornou diferente de OK aborta
		if ($this->retornoMonitor["Mensagem"][0] != "OK")
			return false;
		
		return true;
	}
	
	public function imprimirDanfePdfTermica()
	{
		$arquivo = "{$this->model->nfechave}.pdf";
		$url = "{$this->model->Filial->acbrnfemonitorcaminhorede}/PDF/$arquivo";
		$cmd = "cd /tmp; rm -f $arquivo; wget $url ; lpr -P bematech-escmig98-pc $arquivo;";
		return exec($cmd);		
	}
	
	public function imprimirDanfe()
	{
		
		if (!$this->model->emitida)
			return $this->gerarErro("Nota Fiscal nao e de nossa emissao!");
		
		//Monta Comando
		$cmd = "NFE.ImprimirDANFE(\"";
		$cmd .= $this->model->Filial->acbrnfemonitorcaminho . "\\Arquivos\\NFe\\" . $this->model->nfechave . "-nfe.xml";
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
		if (!$this->model->emitida)
			return $this->gerarErro("Nota Fiscal nao e de nossa emissao!");
		
		if (strlen($justificativa) < 15)
			return $this->gerarErro("Texto de justificativa deve ter no minimo 15 caracteres!");
		
		//Monta Comando
		$cmd = "NFE.CancelarNFE(\"";
		$cmd .= $this->model->nfechave;
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
		if (!$this->model->emitida)
			return $this->gerarErro("Nota Fiscal nao e de nossa emissao!");
		
		if (strlen($justificativa) < 15)
			return $this->gerarErro("Texto de justificativa deve ter no minimo 15 caracteres!");
		
		//Monta Comando
		$cmd = "Nfe.InutilizarNFE (\"" . Yii::app()->format->formataPorMascara($this->model->Filial->Pessoa->cnpj, "##############", true) . "\"";
		$cmd .= ", \"" . $justificativa . "\"";
		$cmd .= ", \"" . substr($this->model->emissao, 6, 4) . "\"";
		$cmd .= ", \"" . $this->model->modelo . "\"";
		$cmd .= ", \"" . $this->model->serie . "\"";
		$cmd .= ", \"" . $this->model->numero . "\"";
		$cmd .= ", \"" . $this->model->numero . "\")\n.\n";
		
		//Envia Comando
		if (!$this->enviaComando($cmd))
			return false;
		
		//Se retornou diferente de OK aborta
		if ($this->retornoMonitor["Mensagem"][0] != "OK")
			return false;
		
		return $this->salvaRetorno($justificativa);
	}
	
	public function cartaCorrecao($texto)
	{
		if (!$this->model->emitida)
			return $this->gerarErro("Nota Fiscal nao e de nossa emissao!");
		
		if ($this->model->codstatus != NotaFiscal::CODSTATUS_AUTORIZADA)
			return $this->gerarErro("Status da nota nao permite emissao de carta de correcao!");

		//Verifica se o texto tem mais de 15 caracteres
		if (strlen($texto) < 15)
			return $this->gerarErro("Texto deve ter no minimo 15 caracteres!");
		
		//armazena o timestamp
		$data = date('d/m/Y H:i:s');
		
		//descobre numero do lote e sequencia
		$lote = 0;
		$sequencia = 0;
		foreach ($this->model->NotaFiscalCartaCorrecaos as $cc)
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
		$cmd .= "chNFe=" . $this->model->nfechave . "\n";
		$cmd .= "cOrgao=" . substr($this->model->nfechave, 0, 2) . "\n";
		$cmd .= "CNPJ=" . substr($this->model->nfechave, 6, 14) . "\n";
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
		
		$cc->codnotafiscal = $this->model->codnotafiscal;
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

	
	public function enviarEmail($email, $alterarcadastro = false)
	{
		if (!$this->model->emitida)
			return $this->gerarErro("Nota Fiscal nao e de nossa emissao!");
		
		//se nao passou email 
		if (empty($email))
			return $this->gerarErro("Nenhum email informado!");
		
		//altera cadastro da pessoa
		if ($alterarcadastro)
		{
			Yii::app()->db
				->createCommand("UPDATE tblPessoa SET emailnfe = :emailnfe WHERE codpessoa=:codpessoa")
				->bindValues(array(':emailnfe' => $email, ':codpessoa' => $this->model->codpessoa))
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
			
			//Monta Comando
			$cmd = "NFE.EnviarEmail(\"$email\", \"";
			$cmd .= $this->model->Filial->acbrnfemonitorcaminho . "\\Arquivos\\NFe\\" . $this->model->nfechave . "-nfe.xml";
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
	
	public function salvaRetorno($justificativa = "")
	{
		/*
		$debug = true;
		
		if ($debug)
		{
			echo "<pre>";
			print_r ($this->retorno);
			print_r ($this->retornoMonitor);
			echo "</pre>";
			die();
		}
		 * 
		 */
		
		if (isset($this->retornoMonitor["ENVIO"]))
		{
			//Grava Recibo Envio
			if (isset($this->retornoMonitor["ENVIO"]["NRec"]))
				$this->model->nfereciboenvio = $this->retornoMonitor["ENVIO"]["NRec"];

			//Grava Data e Hora de Envio
			if (isset($this->retornoMonitor["ENVIO"]["DhRecbto"]))
				$this->model->nfedataenvio = $this->retornoMonitor["ENVIO"]["DhRecbto"];

			//Salva
			$this->model->update();

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
		$nfe = "NFE" . $this->model->numero;
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
				$this->model->nfecancelamento = $this->model->nfereciboenvio;
				if (empty($this->model->nfecancelamento)) 
					$this->model->nfecancelamento = "999999999999999";

				//Data e Hora
				$this->model->nfedatacancelamento = $this->model->nfedataenvio;
				if (empty($this->model->nfedatacancelamento)) 
					$this->model->nfedatacancelamento = date('d/m/Y H:i:s');

				//Justificativa
				$this->model->justificativa = substr($this->retornoMonitor[$nfe]["XMotivo"], 0, 200);
				if (empty($this->model->justificativa)) 
					$this->model->justificativa = "Uso Denegado";

				//salva
				$this->model->update();

				//retorna
				$this->erroMonitor = $this->model->justificativa;
				return false;
			}

			//se chegou ate aqui e porque foi autorizada
			$this->model->nfeautorizacao = $this->retornoMonitor[$nfe]["NProt"];
			$this->model->nfedataautorizacao = $this->retornoMonitor[$nfe]["DhRecbto"];

			//salva
			$this->model->update();
		}
		
		//consulta
		if (isset($this->retornoMonitor["CONSULTA"]))
		{
			switch ($this->retornoMonitor["CONSULTA"]["CStat"])
			{
				//cancelada
				case 101:
					$this->model->nfecancelamento = $this->retornoMonitor["CONSULTA"]["NProt"];
					$this->model->nfedatacancelamento = $this->retornoMonitor["CONSULTA"]["DhRecbto"];
					break;
				
				//inexistente
				case 217:
					break;
				
				//denegada
				case 302:
					//protocolo
					$this->model->nfecancelamento = $this->model->nfereciboenvio;
					if (empty($this->model->nfecancelamento))
						$this->model->nfecancelamento = "999999999999999";
					
					//data e hora
					$this->model->nfedatacancelamento = $this->model->nfedataenvio;
					if (empty($this->model->nfedatacancelamento))
						$this->model->nfedatacancelamento = date('d/m/Y H:i:s');
					
					//justificativa
					$this->model->justificativa = substr($this->retornoMonitor["CONSULTA"]["XMotivo"], 0, 200);
					if (empty($this->model->justificativa)) 
						$this->model->justificativa = "Uso Denegado";
					break;
				
				//autorizada
				default :
					$this->model->nfeautorizacao = $this->retornoMonitor["CONSULTA"]["NProt"];
					$this->model->nfedataautorizacao = $this->retornoMonitor["CONSULTA"]["DhRecbto"];
					break;
					
			}
			
			$this->model->update();
		
		}
		
		//cancelamento
		if (isset($this->retornoMonitor["CANCELAMENTO"]))
		{
			
			if ($this->retornoMonitor["CANCELAMENTO"]["CStat"] != 135)
			{
				$this->erroMonitor = $this->retornoMonitor["CANCELAMENTO"]["XMotivo"];
				return false;
			}
			
			$this->model->nfecancelamento = $this->retornoMonitor["CANCELAMENTO"]["NProt"];
			$this->model->nfedatacancelamento = $this->retornoMonitor["CANCELAMENTO"]["DhRecbto"];
			$this->model->justificativa = $justificativa;
			
			$this->model->update();		
			
		}
		
		//Inutilizacao
		if (isset($this->retornoMonitor["INUTILIZACAO"]))
		{
			
			if ($this->retornoMonitor["INUTILIZACAO"]["CStat"] != 102)
			{
				$this->erroMonitor = $this->retornoMonitor["INUTILIZACAO"]["XMotivo"];
				return false;
			}
			
			$this->model->nfeinutilizacao = $this->retornoMonitor["INUTILIZACAO"]["NProt"];
			$this->model->nfedatainutilizacao = $this->retornoMonitor["INUTILIZACAO"]["DhRecbto"];
			$this->model->justificativa = $justificativa;
			
			$this->model->update();		
			
		}
		
		//retorna verdadeiro
		return true;
		
	}
	
	
}

/*

********************************************************************************
NFE.AssinarNFe( cArquivo )

Parâmetros
cArquivo - Caminho do arquivo a ser assinado.

Exemplo:
NFE.ASSINARNFE("c:\35XXXXXXXXXXXXXXXX550010000000050000000058-nfe.xml")

Exemplo de Resposta:
OK:


********************************************************************************
NFE.ValidarNFe	
Valida arquivo da NFe. Arquivo deve estar assinado.

NFE.ValidaNFe( cArquivo )

Parâmetros
cArquivo - Caminho do arquivo a ser validado.

Exemplo: 
NFE.VALIDARNFE("c:\35XXXXXXXXXXXXXXXX550010000000050000000058-nfe.xml")

Exemplo de Resposta:
OK: 
ERRO: 1871 - Element '{http://www.portalfiscal.inf.br/nfe}NFe': Missing child element(s). Expected is ( {http://www.w3.org/2000/09/xmldsig#}Signature ).


********************************************************************************
NFE.ConsultarNFe	
Consulta uma NFe.

NFE.ConsultarNFe( cChaveNFe )

Parâmetros
cChaveNFe - Chave da NFe a ser consultada.

Exemplo:
NFE.CONSULTARNFE("35XXXXXXXXXXXXXXXX550010000000050000000058")

Exemplo de Resposta:
OK: Autorizado o uso da NF-e
[CONSULTA]
Versao=1.07
Id=
TpAmb=2
VerAplic=SP_NFE_PL_005c
CStat=100
XMotivo=Autorizado o uso da NF-e
CUF=35
ChNFe=350XXXXXXXXXXXXXXXX550010000000220000000229
DhRecbto=2009-03-24T20:19:38
NProt=1350900073XXXXX
DigVal=OZl9uzQ+JVFPxNuqBJ/ex7TTxhc=
NFE.CancelarNFe	
Cancela um NFe já autorizada.


********************************************************************************
NFE.CancelarNFe( cChaveNFe, cJustificativa )

Exemplo:
NFE.CANCELARNFE("35XXXXXXXXXXXXXXXX550010000000050000000058","Teste de Cancelamento")

Exemplo de Resposta:
OK: Cancelamento de NF-e homologado
[CANCELAMENTO]
Versao=1.07
Id=
TpAmb=2
VerAplic=SP_NFE_PL_005c
CStat=101
XMotivo=Cancelamento de NF-e homologado
CUF=35
ChNFe=350XXXXXXXXXXXXXXXXX550010000000220000000229
DhRecbto=2009-03-25T08:50:50
NProt=2009-03-25T08:50:50

ERRO: Informar uma Justificativa para cancelar a Nota Fiscal Eletronica


********************************************************************************
NFE.ImprimirDanfe	
Imprime o DANFe baseado num arquivo XML de NFe.

NFE.ImprimirDanfe( cArquivo )

Parâmetros
cArquivo - Caminho do arquivo a ser validado.

Exemplo:
NFE.IMPRIMIRDANFE("c:\35XXXXXXXXXXXXXXXX550010000000050000000058-nfe.xml")

Exemplo de Resposta:
OK:


********************************************************************************
NFE.InutilizarNFe	
Inutiliza uma faixa de numeração de NFe.

NFE.InutilizarNFe( cCNPJ, cJustificativa, nAno, nModelo, nSerie, nNumInicial, nNumFinal)

Parâmetros
cCNPJ - CNPJ do contribuinte
cJustificativa - Justificativa para inutilização
nAno - Ano que foi inutilizado a numeração
nModelo - Modelo da Nota Fiscal
nSerie - Série da Nota Fiscal
nNumInicial - Número Inicial a ser inutilizado
nNumFinal - Número Final a ser inutilizado

Exemplo:
NFE.INUTILIZARNFE( "XXXXXXXXXXXXX", "Teste de inutilizacao", 08, 55, 1, 1, 4)

Exemplo de Resposta:
OK: Inutilização de número homologado
[INUTILIZACAO]
Versao=1.07
Id=
TpAmb=2
VerAplic=SP_NFE_PL_005c
CStat=102
XMotivo=Inutilização de número homologado
CUF=35
DhRecbto=2009-03-25T08:59:31
NProt=13508000XXXXXXX

ERRO: Rejeição: Uma NF-e da faixa já está inutilizada na Base de dados da SEFAZ


********************************************************************************
NFE.EnviarNFe	
Envia NFe.

NFE.EnviarNFe( cArquivo, nLote,[ nAssina, nImprime ] )

Parâmetros
cArquivo -Caminho do arquivo a ser enviado.
nLote - Número do Lote
nAssina - Coloque 0 se não quiser que o componente assine o arquivo. - Parâmetro Opcional
nImprime - Coloque 1 se quiser que o DANFe seja impresso logo após a autorização - Parâmetro Opcional

Exemplo:
NFE.ENVIARNFE("c:\35XXXXXXXXXXXXXXXX550010000000050000000058-nfe.xml",1,1,1)

Exemplo de Resposta:
OK: Lote recebido com sucesso
[ENVIO]
Versao=1.10
TpAmb=2
VerAplic=SP_NFE_PL_005c
CStat=103
XMotivo=Lote recebido com sucesso
CUF=35
NRec=35000000XXXXXXX
DhRecbto=2009-03-25T09:25:04
TMed=1
Lote processado
[RETORNO]
Versao=1.10
TpAmb=2
VerAplic=SP_NFE_PL_005c
NRec=35000000XXXXXXX
CStat=104
XMotivo=Lote processado
CUF=35
[NFE28]
Versao=1.07
Id=
TpAmb=2
VerAplic=SP_NFE_PL_005c
CStat=100
XMotivo=Autorizado o uso da NF-e
CUF=35
ChNFe=350XXXXXXXXXXXXXXXXX550010000000280000000281
DhRecbto=2009-03-25T09:25:04
NProt=13509000XXXXXXX
DigVal=UNTpscTtknjN5UOBUHa9PZPHJnE=

ERRO: Rejeição: Falha no Schema XML da NFe


********************************************************************************
NFE.CriarNFe	
Cria XML da NFe baseado em um arquivo INI.

NFE.CriarNFe( cTextoIni,[ nRetornaXML])

Parâmetros
cTextoIni - Texto no formato de arquivo INI com informações da NFe.
nRetornaXML - Coloque o valor 1 se quiser que o ACBrNFeMonitor retorne além do Path de onde o arquivo foi criado, o XML gerado. Por default não retorna o XML.

O conteúdo do parâmetro cTextoIni, deve possuir o seguinte formato:

[Identificacao]
NaturezaOperacao=VENDA PRODUCAO DO ESTAB.
Modelo=55
Serie=1
Codigo=18
Numero=18
Serie=1
Emissao=24/03/2009
Saida=24/03/2009
Tipo=1
FormaPag=0
Finalidade=0
[Emitente]
CNPJ=
IE=
Razao=
Fantasia=
Fone=
CEP=
Logradouro=
Numero=
Complemento=
Bairro=
CidadeCod=
Cidade=
UF=
*PaisCod= 
*Pais=
[Destinatario]
CNPJ=
IE=
*ISUF=
NomeRazao=
Fone=
CEP=
Logradouro=
Numero=
Complemento=
Bairro=
CidadeCod=
Cidade=
UF=
*PaisCod=
*Pais=
[Produto001]
CFOP=
Codigo=
Descricao=
*EAN=
*NCM=
Unidade=
Quantidade=
ValorUnitario=
ValorTotal=
*ValorDesconto=
*NumeroDI=
*DataRegistroDI=
*LocalDesembaraco=
*UFDesembaraco=
*DataDesembaraco=
*CodigoExportador=
*[LADI001001]
*NumeroAdicao=
*CodigoFrabricante=
*DescontoADI
[ICMS001]
CST=00
*Origem=
*Modalidade=
*ValorBase=
*Aliquota=
*Valor=
*ModalidadeST=
*PercentualMargemST=
*PercentualReducaoST=
*ValorBaseST=
*AliquotaST=
*ValorST=
*PercentualReducao=
*[IPI001]
*CST=
*ClasseEnquadramento=
*CNPJProdutor=
*CodigoSeloIPI=
*QuantidadeSelos=
*CodigoEnquadramento=
*ValorBase=
*Quantidade=
*ValorUnidade=
*Aliquota=
*Valor
*[II001]
*ValorBase=
*ValorDespAduaneiras=
*ValorII=
*ValorIOF=
*[PIS001]
*CST=
*ValorBase=
*Aliquota=
*Valor=
*Quantidade=
*TipoCalculo=
*[PISST001]
*ValorBase=
*AliquotaPerc=
*Quantidade=
*AliquotaValor=
*ValorPISST=
*[COFINS001]
*CST=
*ValorBase=
*Aliquota=
*Valor=
*TipoCalculo=
*Quantidade=
*[COFINSST001]
*ValorBase=
*AliquotaPerc=
*Quantidade=
*AliquotaValor=
*ValorCOFINSST=
[Total]
BaseICMS=
ValorICMS=
ValorProduto=
*BaseICMSSubstituicao=
*ValorICMSSubstituicao=
*ValorFrete=
*ValorSeguro=
*ValorDesconto=
*ValorII=
*ValorIPI=
*ValorPIS=
*ValorCOFINS=
*ValorOutrasDespesas=
ValorNota=
*[Transportador]
*FretePorConta=
*CnpjCpf=
*NomeRazao=
*IE=
*Endereco=
*Cidade=
*UF=
*ValorServico=
*ValorBase=
*Aliquota=
*Valor=
*CFOP=
*CidadeCod=
*Placa=
*UFPlaca=
*RNTC=
*[Volume001]
*Quantidade=
*Especie=
*Marca=
*Numeracao=
*PesoLiquido=
*PesoBruto=
*[Fatura]
*Numero=
*ValorOriginal=
*ValorDesconto=
*ValorLiquido=
*[Duplicata001]
*Numero=
*DataVencimento=
*Valor=
*[DadosAdicionais]
*Complemento=
*[InfAdic001]
*Campo=
*Texto=

Observações
- Campos com * são opcionais 
- Algumas grupos podem ser repetidos. Ex: Para incluir dois produtos, existirão uma chave Produto001 e Produto002 e assim sucessivamente. As chaves de imposto (ICMS,IPI,COFINS, etc) devem ter o memo número do produto, ou seja, o ICMS da chave Produto0002 deve ser ICMS002. 
- Acentos podem causar problemas na criação do NFe. Ao tentar criar uma NFe, caso receba o erro "Unable to Parse" verifique se não existem caracteres acentuados nos campos.

Exemplo:
NFE.CriarNFe("[Identificacao]
NaturezaOperacao=VENDA PRODUCAO DO ESTAB.
Modelo=55
Serie=1
Codigo=19
Numero=19
Serie=1
Emissao=24/03/2009
Saida=24/03/2009
Tipo=1
FormaPag=0
[Emitente]
CNPJ=XXXXXXXXXXXXXX
IE=XXXXXXXXXXXX
Razao=RAZAO SOCIAL DO DESTINATARIO LTDA EPP
Fantasia=NOME FANTASIA
Fone=1532599600
CEP=18270000
Logradouro=Rua Onze de Agosto
Numero=1000
Complemento=
Bairro=Centro
CidadeCod=3554003
Cidade=Tatui
UF=SP
[Destinatario]
CNPJ=05481336000137
IE=687138770110
ISUF=
NomeRazao=D.J. COM. E LOCACAO DE SOFTWARES LTDA - ME
Fone=1532599600
CEP=18270410
Logradouro=Praca Anita Costa
Numero=0034
Complemento=
Bairro=Centro
CidadeCod=3554003
Cidade=Tatui
UF=SP
[Produto001]
CFOP=5101
Codigo=67
Descricao=ALHO 400 G
Unidade=KG
Quantidade=100
ValorUnitario=10
ValorTotal=100
[ICMS001]
CST=00
ValorBase=1000
Aliquota=18
Valor=180
[Total]
BaseICMS=1000
ValorICMS=180
ValorProduto=1000
ValorNota=1000" )

Exemplo de Resposta:
OK: NFe criada em: C:\ACBrNFeMonitor\logs\35XXXXXXXXXXXXXXXX550010000000190000000193-nfe.xml

NFE.CriarEnviarNFe	
Cria o XML da NFe e já envia para o fisco.

NFE.CriarEnviarNFe( cTextoIni, nNumLote,[ nImprimirDanfe ])

Parâmetros
cTextoIni - Texto no formato de arquivo INI com informações da NFe.
nImprimirDanfe - Coloque 1 se quiser que o DANFe seja impresso logo após a autorização - Parâmetro Opcional

Exemplo:
NFe.CriarEnviarNFe("[Identificacao]
NaturezaOperacao=VENDA PRODUCAO DO ESTAB.
Modelo=55
Serie=1
Codigo=21
Numero=21
Serie=1
Emissao=24/03/2009
Saida=24/03/2009
Tipo=1
FormaPag=0
[Emitente]
CNPJ=XXXXXXXXXXXXXX
IE=XXXXXXXXXXXX
Razao=RAZAO SOCIAL DO DESTINATARIO LTDA EPP
Fantasia=NOME FANTASIA
Fone=1532599600
CEP=18270000
Logradouro=Rua Onze de Agosto
Numero=1000
Complemento=
Bairro=Centro
CidadeCod=3554003
Cidade=TatuI
UF=SP
[Destinatario]
CNPJ=05481336000137
IE=687138770110
ISUF=
NomeRazao=D.J. COM. E LOCACAO DE SOFTWARES LTDA - ME
Fone=1532599600
CEP=18270410
Logradouro=Praca Anita Costa
Numero=0034
Complemento=
Bairro=Centro
CidadeCod=3554003
Cidade=TatuI
UF=SP
[Produto001]
CFOP=5101
Codigo=67
Descricao=ALHO 400 G
Unidade=KG
Quantidade=100
ValorUnitario=10
ValorTotal=100
[ICMS001]
CST=00
ValorBase=1000
Aliquota=18
Valor=180
[Total]
BaseICMS=1000
ValorICMS=180
ValorProduto=1000
ValorNota=1000"
,2,0)

Exemplo de Resposta:
OK: Lote recebido com sucesso
[ENVIO]
Versao=1.10
TpAmb=2
VerAplic=SP_NFE_PL_005c
CStat=103
XMotivo=Lote recebido com sucesso
CUF=35
NRec=35000000XXXXXXX
DhRecbto=2009-03-25T09:16:58
TMed=1
Lote processado
[RETORNO]
Versao=1.10
TpAmb=2
VerAplic=SP_NFE_PL_005c
NRec=35000000XXXXXXX
CStat=104
XMotivo=Lote processado
CUF=35
[NFE26]
Versao=1.07
Id=
TpAmb=2
VerAplic=SP_NFE_PL_005c
CStat=100
XMotivo=Autorizado o uso da NF-e
CUF=35
ChNFe=350XXXXXXXXXXXXXXXXX550010000000260000000260
DhRecbto=2009-03-25T09:16:59
NProt=13509000XXXXXXX
DigVal=CiHlzOOqJMNbnh8WGkY19pddhB8=

Observações
Será retornado uma chave NFE + o número da NFe enviada. O recebimento da reposta OK: Lote recebido com sucesso não significa que a nota foi autorizada, apenas que o lote foi recebido. Verifique os campos CStat e XMotivo da chave NFE para ter certeza que a nota foi autorizada


********************************************************************************
NFE.EnviarEmail	
Envia uma NFe por email. Além do XML é possível enviar o DANFe em formato PDF. O Assunto do email que será enviado e a mensagem deste email, deverá ser configurado no ACBrNFeMonitor

NFE.EnviarEmail( cPara, cArquivo, [ nEnviaDanfePDF ] )

Parâmetros
cPara - Email do destinatário. 
cArquivo - Caminho do arquivo a ser enviado.
nEnviaDanfePDF - Coloque 1 se quiser que o DANFe seja enviado em formato PDF- Parâmetro Opcional

Exemplo:
NFE.ENVIAREMAIL("andre@djsystem.com.br","c:\35XXXXXXXXXXXXXXXX550010000000050000000058-nfe.xml","1")

Exemplo de Resposta:
OK: Email enviado com sucesso
 
 
********************************************************************************
Adicionado o comando "ImprimirEventoPDF", segue o mesmo padrão do comando ImprimirEvento;
 
 
********************************************************************************
Adicionado o comando "EnviarEmailEvento" com a seguinte sintaxe: EnviarEmailEvento(cEmailDestino,cArqEvento,[cArqNFe],cEnviaPDF,[cAssunto],[cEmailsCopias]);
 
 
********************************************************************************
Adicionado o comando "DownloadNFe" com a seguinte sintaxe: DownloadNFe(cCNPJ,cChaveNFe) - por enquanto permite baixar apenas um XML por vez;
 
 
********************************************************************************
E adicionado o comando "ConsultaNFeDest" com a seguinte sintaxe: ConsultaNFeDest(cCNPJ,nIndicadorNFe,nIndicadorEmissor,cultimoNSU).
 
 
********************************************************************************
NFe.StatusServico
 
 
********************************************************************************
NFe.AssinarNFe(cArqXML)
 
 
********************************************************************************
NFe.ValidarNFe(cArqXML)
 
 
********************************************************************************
NFe.ConsultarNFe(cArqXML)
 
 
********************************************************************************
NFe.CancelarNFe(cChaveNFe,cJustificativa)
 
 
********************************************************************************
NFe.ImprimirDANFE(cArqXML,[NomeImpressora],[nCopias])
 
 
********************************************************************************
NomeImpressora - parâmetro opcional com o nome da impressora que deve ser impresso o DANFE.
nCopias - Parâmetro opcional com o número de cópias a serem impressas do DANFE.
 
 
********************************************************************************
NFe.ImprimirDANFEPDF(cArqXML)
 
 
********************************************************************************
NFe.InutilizarNFe(cCNPJ,cJustificativa,nAno,nModelo,nSérie,nNumInicial,nNumFinal)
 
 
********************************************************************************
NFe.EnviarNFe(cArqXML,nLote,[nAssina],[nImprime],[NomeImpressora])
nAssina - parâmetro opcional e caso seja passado 1 irá assinar o arquivo XML antes de enviar.
nImprime - parâmetro opcional e caso seja passado 1 irá imprimir o DANFE caso a nota seja enviada com sucesso.
 
 
********************************************************************************
NFe.ReciboNFe(nRecibo) //Consulta status do lote enviado pelo número do recibo
 
 
********************************************************************************
NFe.ConsultaCadastro(cUF,nDocumento,[nIE])
cUF - Sigla do estado do documento a ser consultado
nDocumento - Número do documento a ser consultado
nIE - parâmetro opcional e caso seja passado 1 irá consultar pelo documento Inscrição Estadual, caso contrário irá consultar pelo CPF ou CNPJ.
 
 
********************************************************************************
NFe.EnviarEmail(cEmailDestino,cArqXML,cEnviaPDF,[cAssunto],[cEmailsCopias])
cEnviaPDF - indica se deverá ser enviado PDF junto ao Arquivo XML da NFe no email. Deverá ser passado 1 para enviar e 0 para não enviar o PDF.
cAssunto - parâmetro opcional para mudar o assunto cadastrado no ACBrNFeMonitor.
cEmailsCopias - parâmetro opcional que poderá conter diversos emails separados por ; para enviar cópia do email enviado ao Email de Destino.
 
 
********************************************************************************
NFe.SetCertificado(cCertificado,cSenha) //Versão OpenSSL
 
 
********************************************************************************
NFe.SetCertificado(cNumCertificado) // Versão CAPICOM
 
 
********************************************************************************
NFe.SetAmbiente(nNumAmbiente)
nNumAmbiente - pode ser passado o valor 1 para Ambiente de Produção ou 2 para Ambiente de Homologação
 
 
********************************************************************************
NFe.SetFormaEmissao(nFormaEmissao)
nFormaEmissao - pode ser passado os seguintes valores:
1 para Normal, 2 para FS, 3 para SCAN, 4 para DPEC e 5 para FS-DA
 
 
********************************************************************************
NFe.LerNFe(cArqXML) - Irá ler o arquivo XML da NFe e retornar no formato INI usado no ACBrNFeMonitor
 
 
********************************************************************************
NFe.NFetoTXT(cArqXML,cNomeArqTXT) - Irá ler o arquivo XML da NFe e gerar o arquivo TXT com o nome passado no parâmetro cNomeArqTXT no formato do emissor do governo do SEFAZ de SP
 
 
********************************************************************************
NFe.SavetoFile(cNomeArq,cConteudoArq) - Salva um arquivo na máquina que está instalado o ACBrNFeMonitor com o nome passado em cNomeArq com o conteúdo passado em cConteudoArq. Útil para quem utiliza comunicação via Sockets e deseja salvar um arquivo na máquina que está instalado o ACBrNFeMonitor sem precisar mapear a unidade de rede.
 
 
********************************************************************************
NFe.LoadfromFile(cNomeArq,nSegundos) - Lê um arquivo na máquina que está instalados o ACBrNFeMonitor e tenta fazer esta leitura conforme o número de segundos que for passado no parâmetro nSegundos. Útil para quem utiliza comunicação via Sockets e deseja ler um arquivo na máquina que está instalado o ACBrNFeMonitor sem precisar mapear a unidade de rede.
 
 
********************************************************************************
NFe.LerIni - Le as informações do arquivo ACBrNFeMonitor.ini. Útil para quem muda as configurações do INI por fora da interface do ACBrNFeMonitor e quer que as configurações sejam lidas sem precisar fechar e abrir novamente o programa.
 
 
********************************************************************************
NFe.Restaurar - Restaura a tela do ACBrNFeMonitor
 
 
********************************************************************************
NFe.Ocultar - Oculta a tela do ACBrNFeMonitor
 
 
********************************************************************************
NFe.EncerrarMonitor - Termina a execução do ACBrNFeMonitor
 
 
 
 
********************************************************************************
NFe.Exit ou NFe.bye ou NFe.fim ou NFe.Sair - Fecha a conexão quanto utilizado via Sockets.
 
 
********************************************************************************
NFe.EnviarLoteNFe(nLote)
 
 
********************************************************************************
NFe.EnviarDPECNFe(nLote,nImprimeDANFE)
 
 
********************************************************************************
NFe.FileExists(cNomeArq) - Verifica se o arquivo passado através do parâmetro cNomeArq existe na máquina em que o ACBrNFeMonitor está instalado. Útil para quem utiliza comunicação via Sockets e deseja verificar a existência de um arquivo na máquina que está instalado o ACBrNFeMonitor sem precisar mapear a unidade de rede.
Abaixo os comandos para gerar a NFe que utilizam o formato INI descrito neste post: http://anfm.blogspot.com/2009/09/campos-para-criar-uma-nfe-usando-o.html
 
 
********************************************************************************
NFe.CriarNFe(cArqINI,nRetornaXML)
cArqINI - Pode ser passado o path para o arquivo ou o conteúdo do Arquivo INI.
nRetornaXML - Se passado como 1, irá retornar na resposta do ACBrNFeMonitor o XML gerado a partir do arquivo INI.
 
 
********************************************************************************
NFe.CriarEnviarNFe(cArqINI,nLote,nImprimeDANFE)
nLote - Número do Lote de envio da NFe.
nImprimeDANFE - Se passado como 1, irá imprimir o DANFE se a NFe for aprovada no SEFAZ.
 
 
********************************************************************************
NFe.AdicionarNFe(cArqINI,nLote)
Adiciona uma nota ao lote nLote para posterior envio com o comando NFe.EnviarLoteNFe ou NFe.EnviarDPECNFe
Abaixo os comandos para gerar a NFe que utilizam o formato do emissor do SEFAZ de SP.
 
********************************************************************************
NFe.CriarNFeSefaz(cArqTXT,nRetornaXML)
cArqTXT - Path para o arquivo TXT no formato do SEFAZ
 
********************************************************************************
NFe.CriarEnviarNFeSefaz(cArqTXT,nLote,nImprimeDANFE)
 
********************************************************************************
NFe.AdicionarNFeSefaz(cArqTXT,nLote)

 */
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
	
	public $urlpdf;
	
	public function __construct($model, $servidor = NULL, $porta = NULL)
	{
		$this->model = $model;
		$this->montaUrlPdf();
		
		if (isset($this->model->Filial))
			return parent::__construct($this->model->Filial->acbrnfemonitorip, $this->model->Filial->acbrnfemonitorporta);
		else
			return parent::__construct ();
		
	}
	
	public function montaUrlPdf()
	{
		$this->urlpdf = "{$this->model->Filial->acbrnfemonitorcaminhorede}/PDF/{$this->model->nfechave}.pdf";
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
		if (!in_array($this->model->codstatus, array(NotaFiscal::CODSTATUS_NAOAUTORIZADA, NotaFiscal::CODSTATUS_DIGITACAO)))
			return $this->gerarErro("Status da Nota Fiscal nao permite envio ao Sefaz!");
		
		if (!$this->model->emitida)
			return $this->gerarErro("Nota Fiscal nao e de nossa emissao!");
		
		if (sizeof($this->model->NotaFiscalProdutoBarras) <= 0)
			return $this->gerarErro("Nao existe nenhum produto na nota fiscal!");
		
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
					"EAN" => $nfpb->ProdutoBarra->barrasValido()?$nfpb->ProdutoBarra->barras:"",
					/*
					If Len(NumeroLimpo($nfpb->barras)) > 6 _
						And NumeroLimpo(Mid($nfpb->barras, 1, 6)) <> Format($nfpb->codproduto, "000000") _
						And NumeroLimpo(Mid($nfpb->barras, 1, 3)) <> "999" _
						And ValidaEan($nfpb->barras) Then
					End If
					 */ 
					"Descricao" => (empty($nfpb->descricaoalternativa))?$nfpb->ProdutoBarra->descricao:$nfpb->descricaoalternativa,
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
			if (empty($this->model->Pessoa->cnpj))
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
			
			if (!empty($this->model->Pessoa->ie))
				return $this->gerarErro ("Nao permitida emissao de NFC-e para Pessoas que tenham IE!");
			
			if ($this->model->codpessoa == Pessoa::CONSUMIDOR)
				unset($arr["Destinatario"]);
			else
			{
				$arr["Destinatario"]["indIedest"] = 9;
				unset($arr["Destinatario"]["IE"]);
			}
			
			
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
		$command = Yii::app()->db->createCommand("SELECT max(valoribpt) FROM vwIbptaxNotaFiscal WHERE codNotaFiscal = :codnotafiscal");
		$command->params = array(':codnotafiscal' => $this->model->codnotafiscal);
		if ($ibpt = $command->queryScalar())
		{
			$compl = str_replace("#IBPTVALOR#", Yii::app()->format->formatNumber($ibpt), $compl);
		}
		
		if ($this->model->modelo == NotaFiscal::MODELO_NFCE)
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
		$chave = str_replace($this->model->Filial->acbrnfemonitorcaminho, "", $chave);
		$chave = str_replace("\\Arquivos\\EnvioResp\\", "", $chave);
		$chave = str_replace("-nfe.xml", "", $chave);

		//grava chave da NFE
		$this->model->nfechave = $chave;
		$this->model->update();
		
		$this->montaUrlPdf();
		
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
		if (!in_array($this->model->codstatus, array(NotaFiscal::CODSTATUS_NAOAUTORIZADA, NotaFiscal::CODSTATUS_DIGITACAO)))
			return $this->gerarErro("Status da Nota Fiscal nao permite envio ao Sefaz!");
		
		if (!$this->model->emitida)
			return $this->gerarErro("Nota Fiscal nao e de nossa emissao!");

		//Monta Comando
		$cmd = "NFE.EnviarNFe(\"";
		$cmd .= $this->model->Filial->acbrnfemonitorcaminho . "\\Arquivos\\EnvioResp\\" . $this->model->nfechave . "-nfe.xml";
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
		if (!$this->model->emitida)
			return $this->gerarErro("Nota Fiscal nao e de nossa emissao!");

		//Monta Comando
		$cmd  = "NFE.ConsultarNFE(\"";
		$cmd .= $this->model->Filial->acbrnfemonitorcaminho . "\\Arquivos\\EnvioResp\\" . $this->model->nfechave . "-nfe.xml";
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
		if ($this->model->modelo != NotaFiscal::MODELO_NFCE)
			return false;
		
		$arquivo = "{$this->model->nfechave}.pdf";
		$impressora = Yii::app()->user->impressoraTermica;
		$cmd = "cd /tmp; rm -f $arquivo; wget {$this->urlpdf} ; lpr -P $impressora $arquivo;";
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
	
	public function consultaNfeDest($nsu = 0)
	{
		//Monta Comando
		$cnpj = str_pad($this->model->Filial->Pessoa->cnpj, 14, 0, STR_PAD_LEFT);
		$cmd = "NFE.ConsultaNFeDest(\"{$cnpj}\", 0, 0, {$nsu})\n.\n";
		
		if (!$this->enviaComando($cmd))
			return false;
		
		$this->processaRetorno();
		
		return true;
	}
	
	public function salvaRetorno($justificativa = "")
	{
		
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

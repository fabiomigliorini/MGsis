<?php

/*
 * Condensado: 137 Colunas
 * Normal:      80 Colunas
 * Large:       40 Colunas
 * 
 * @property Negocio $_model
 */

class MGEscPrintRomaneio extends MGEscPrint
{
	
	private $_model;
	
	/*
	 * @parameter Negocio $model
	 */
	
	function __construct($model, $impressora = null, $linhas = null) 
	{
		$this->_model = $model;
		parent::__construct($impressora, $linhas);
		
		$this->adicionaTexto("<Reset><6lpp><Draft><CondensedOn>", "cabecalho");
		
		//linha divisoria
		$this->adicionaLinha("", "cabecalho", 137, STR_PAD_RIGHT, "=");
		
		//$negocio = new Negocio::model()->findByPk($model->codnegocio);
		// TODO: Corrigir para nao buscar duplamente no banco de dados
		$model = Negocio::model()->findByPk($model->codnegocio);

		$filial = $model->Filial;
		
		// Fantasia e NUMERO do Negocio
		$this->adicionaTexto("<DblStrikeOn>", "cabecalho");
		$this->adicionaTexto($filial->Pessoa->fantasia . " " . $filial->Pessoa->telefone1, "cabecalho", 68);
		$this->adicionaTexto("Negocio:           " . Yii::app()->format->formataCodigo($model->codnegocio), "cabecalho", 69, STR_PAD_LEFT);
		$this->adicionaTexto("<DblStrikeOff>", "cabecalho");
		$this->adicionaLinha("", "cabecalho");

		
		// Usuario e Data
		$usuario = $model->Usuario->usuario;
		if (!empty($model->codpessoavendedor))
		{
			$usuario .= " / ";
			$usuario .= $model->PessoaVendedor->fantasia;
		}
		$this->adicionaTexto("Vendedor: " . $usuario, "cabecalho", 68);
		$this->adicionaTexto("Data...: " . $model->lancamento, "cabecalho", 69, STR_PAD_LEFT);
		$this->adicionaLinha("", "cabecalho");
		
		//linha divisoria
		$this->adicionaLinha("", "cabecalho", 137, STR_PAD_RIGHT, "=");
		
		//Rodape
		$this->adicionaTexto("", "rodape", 137, STR_PAD_RIGHT, "=");
		
		$this->adicionaTexto("<CondensedOff><DblStrikeOn>");
		
		$this->adicionaLinha(
				"Cliente: " 
				. Yii::app()->format->formataCodigo($model->codpessoa)
				. " "
				. $model->Pessoa->fantasia
				. " - "
				. $model->Pessoa->telefone1
				. " / "
				. $model->Pessoa->telefone2
				. " / "
				. $model->Pessoa->telefone3
				, "documento", 80);
		
		$this->adicionaTexto("<DblStrikeOff><CondensedOn>");
		
		$this->adicionaLinha(
				"Cnpj...: " 
				. Yii::app()->format->formataCnpjCpf($model->Pessoa->cnpj, $model->Pessoa->fisica)
				. " - "
				. $model->Pessoa->pessoa
				, "documento", 137);

		$endereco = 
			"End....: " 
			.$model->Pessoa->endereco 
			.", "
			.$model->Pessoa->numero
			." - ";
		
		if (!empty($model->Pessoa->complemento))
			$endereco .= 
				$model->Pessoa->complemento
				." - ";
		
		$endereco .=
			$model->Pessoa->bairro
			." - "
			.$model->Pessoa->Cidade->cidade
			."/"
			.$model->Pessoa->Cidade->Estado->sigla
			." - "
			.Yii::app()->format->formataCep($model->Pessoa->cep);

		
		$this->adicionaLinha($endereco, "documento", 137);
		
		$this->adicionaLinha("", "documento", 137, STR_PAD_LEFT, "-");
		$this->adicionaTexto("<DblStrikeOn>");
		$this->adicionaLinha("Vencimento(s): ");
		
		foreach ($model->NegocioFormaPagamentos as $nfp)
		{
			foreach ($nfp->Titulos as $titulo)
			{
				$vencimento = $titulo->vencimento;
				$vencimento = substr($vencimento, 0, 6) . substr($vencimento, 8, 2);
				$this->adicionaTexto($vencimento, "documento", 10);
				$this->adicionaLinha(Yii::app()->format->formatNumber($titulo->valor), "documento", 10, STR_PAD_LEFT);
				
			}
		}

		$this->adicionaTexto("<DblStrikeOff>");
		$this->adicionaLinha("", "documento", 137, STR_PAD_LEFT, "-");

		$this->adicionaTexto("Codigo", "documento", 20);
		$this->adicionaTexto("Descricao", "documento", 70);
		$this->adicionaTexto("UN", "documento", 7);
		$this->adicionaTexto("Quant", "documento", 10, STR_PAD_LEFT);
		$this->adicionaTexto("Preco", "documento", 15, STR_PAD_LEFT);
		$this->adicionaTexto("Total", "documento", 15, STR_PAD_LEFT);
		$this->adicionaLinha();
		
		$this->adicionaTexto("", "documento", 137, STR_PAD_LEFT, "-");
		$this->adicionaLinha();
		
		/*
		

		//titulo
		$this->adicionaTexto("<DblStrikeOn>");
		$this->adicionaTexto("R E C I B O    Valor R$ " . Yii::app()->format->formatNumber($model->credito), "documento", 40, STR_PAD_LEFT);
		$this->adicionaTexto("<DblStrikeOff>");
		$this->adicionaTexto("<LargeOff><CondensedOn>");
		$this->adicionaLinha("");

		// Texto Recibo
		$linhas = "Recebemos de " .
			$model->Pessoa->pessoa . 
			" (" .Yii::app()->format->formataCodigo($model->codpessoa) . "), " .
			(($model->Pessoa->fisica)?"CPF ":"CNPJ ") . 
			Yii::app()->format->formataCnpjCpf($model->Pessoa->cnpj, $model->Pessoa->fisica) .
			" a importancia de " . Yii::app()->format->formataValorPorExtenso($model->credito, true) . 
			", Referente ao pagamento dos titulos abaixo listados:";
		$linhas = str_split($linhas, 137);
		
		$this->adicionaTexto("<DblStrikeOn>");
		foreach ($linhas as $linha)
		{
			$this->adicionaTexto(trim($linha), "documento", 137);
			$this->adicionaLinha();
		}
		$this->adicionaTexto("<DblStrikeOff>");
		
		// Espaco
		$this->adicionaLinha();
		

		// Cabecalho Tabela Titulos
		$this->adicionaTexto("", "documento", 137, STR_PAD_LEFT, "-");
		$this->adicionaLinha();
		$this->adicionaTexto("Numero", "documento", 29);
		$this->adicionaTexto("Emissao", "documento", 12);
		$this->adicionaTexto("Vencimento", "documento", 12);
		$this->adicionaTexto("Valor Original", "documento", 20, STR_PAD_LEFT);
		$this->adicionaTexto("Pagamento", "documento", 20, STR_PAD_LEFT);
		$this->adicionaTexto("Juros", "documento", 12, STR_PAD_LEFT);
		$this->adicionaTexto("Desconto", "documento", 12, STR_PAD_LEFT);
		$this->adicionaTexto("Total", "documento", 20, STR_PAD_LEFT);
		$this->adicionaLinha();
		$this->adicionaTexto("", "documento", 137, STR_PAD_LEFT, "-");
		$this->adicionaLinha();
		
		//percorre todos os titulos 
		$resumo = $this->_model->getResumoTitulos();
		 * 
		 * 
		 */ 
		
		//percorre produtos
		foreach ($model->NegocioProdutoBarras as $npb)
		{
			$this->adicionaTexto($npb->ProdutoBarra->barras, "documento", 20);
			$this->adicionaTexto($npb->ProdutoBarra->descricao, "documento", 65);
			$this->adicionaTexto($npb->ProdutoBarra->UnidadeMedida->sigla, "documento", 7, STR_PAD_LEFT);
			$this->adicionaTexto(Yii::app()->format->formatNumber($npb->quantidade), "documento", 15, STR_PAD_LEFT);
			$this->adicionaTexto(Yii::app()->format->formatNumber($npb->valorunitario), "documento", 15, STR_PAD_LEFT);
			//$this->adicionaTexto($npb->valortotal, "documento", 15, STR_PAD_LEFT);
			$this->adicionaTexto(Yii::app()->format->formatNumber($npb->valortotal), "documento", 15, STR_PAD_LEFT);
			/*
			$this->adicionaTexto($titulo->emissao, "documento", 12);
			$this->adicionaTexto($titulo->vencimento, "documento", 12);
			$this->adicionaTexto(Yii::app()->format->formatNumber($titulo->valor), "documento", 20, STR_PAD_LEFT);
			$this->adicionaTexto(Yii::app()->format->formatNumber($valores["principal"]), "documento", 20, STR_PAD_LEFT);
			$this->adicionaTexto(Yii::app()->format->formatNumber($valores["juros"] + $valores["multa"]), "documento", 12, STR_PAD_LEFT);
			$this->adicionaTexto(Yii::app()->format->formatNumber($valores["desconto"]), "documento", 12, STR_PAD_LEFT);
			$this->adicionaTexto("<DblStrikeOn>");
			$this->adicionaTexto(Yii::app()->format->formatNumber($valores["total"]), "documento", 20, STR_PAD_LEFT);
			$this->adicionaTexto("<DblStrikeOff>");
			 * 
			 */
			$this->adicionaLinha();
		}
		$this->adicionaLinha("", "documento", 137, STR_PAD_LEFT, "-");
		
		$this->adicionaTexto("<DblStrikeOn>");
		$this->adicionaTexto("Subtotal:");
		$this->adicionaTexto(Yii::app()->format->formatNumber($model->valorprodutos), "documento", 20, STR_PAD_LEFT);
		$this->adicionaTexto("Desconto:", "documento", 35, STR_PAD_LEFT);
		$this->adicionaTexto(Yii::app()->format->formatNumber($model->valordesconto), "documento", 20, STR_PAD_LEFT);
		$this->adicionaTexto("Total...:", "documento", 35, STR_PAD_LEFT);
		$this->adicionaTexto(Yii::app()->format->formatNumber($model->valortotal), "documento", 18, STR_PAD_LEFT);
		
		$this->adicionaLinha("<DblStrikeOff>");
		
		if ($model->valoravista > 0)
		{
			$this->adicionaTexto("A Vista.:", "documento", 119, STR_PAD_LEFT);
			$this->adicionaTexto(Yii::app()->format->formatNumber($model->valoravista), "documento", 18, STR_PAD_LEFT);
			$this->adicionaLinha();
		}
				
		if ($model->valoraprazo > 0)
		{
			$this->adicionaTexto("A Prazo.:", "documento", 119, STR_PAD_LEFT);
			$this->adicionaTexto(Yii::app()->format->formatNumber($model->valoraprazo), "documento", 18, STR_PAD_LEFT);
			$this->adicionaLinha();
		}
		
		$this->adicionaLinha();
			
		// Texto da confissao de divida
		$this->adicionaLinha("Confissao de Divida: Confesso(amos) e me(nos) constituo(imos) devedor(es) do valor descrito nesse negocio, obrigando-me(nos) a pagar em");
		$this->adicionaTexto("moeda corrente do pais, conforme vencimento. Declaro(amos) ainda, ter recebido o servico e/ou produto aqui descrito, sem nada a reclamar.");
		$this->adicionaLinha();
		$this->adicionaLinha();
		$this->adicionaLinha("<DblStrikeOn>");
		
		$this->adicionaTexto("", "documento", 25);
		$this->adicionaLinha("", "documento", 80, STR_PAD_RIGHT, "_");
		
		$this->adicionaTexto("", "documento", 25);
		$this->adicionaTexto(
				$model->codnegocio
				." - "
				.$model->Pessoa->pessoa
				, "documento"
				, 80);
		$this->adicionaLinha("<DblStrikeOff>");
		

		/*
		// linha rodape tabela titulos
		$this->adicionaTexto("", "documento", 137, STR_PAD_LEFT, "-");
		$this->adicionaLinha();

		// Data por extenso
		$this->adicionaLinha();
		$this->adicionaTexto("", "documento", 67);
		$this->adicionaTexto(
			$filial->Pessoa->Cidade->cidade . 
			"/" . 
			$filial->Pessoa->Cidade->Estado->sigla . 
			", " . 
			Yii::app()->format->formataDataPorExtenso($model->transacao) . 
			".",
			"documento",
			70,
			STR_PAD_LEFT
			);
		$this->adicionaLinha();

		// Espaco
		$this->adicionaLinha();
		$this->adicionaLinha();
		$this->adicionaLinha();

		//Assinatura
		$this->adicionaTexto("", "documento", 67);
		$this->adicionaTexto("", "documento", 70, STR_PAD_LEFT, "_");
		$this->adicionaLinha();
		$this->adicionaTexto("", "documento", 67);
		$this->adicionaTexto($filial->Pessoa->pessoa . " " . Yii::app()->format->formataCnpjCpf($filial->Pessoa->cnpj, $filial->Pessoa->fisica), "documento", 70, STR_PAD_LEFT);
		$this->adicionaLinha();
		*/
	}
	
	
}

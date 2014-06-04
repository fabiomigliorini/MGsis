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
		$this->adicionaTexto("Usuario: " . $usuario, "cabecalho", 68);
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
		$this->adicionaLinha(
				"End....: " 
				.$model->Pessoa->endereco 
				."-"
				.$model->Pessoa->numero
				."-"
				.$model->Pessoa->complemento
				."-"
				.$model->Pessoa->bairro
				."-"
				.$model->Pessoa->Cidade->cidade
				."/   "
				.Yii::app()->format->formataCep($model->Pessoa->cep)
				, "documento", 137);
		
		$this->adicionaLinha("", "documento", 137, STR_PAD_LEFT, "-");
		
		$this->adicionaTexto("<CondensedOff><DblStrikeOn>");
		$this->adicionaLinha(
				"Vencimento(s) :");
		$this->adicionaTexto("<DblStrikeOff><CondensedOn>");
		$this->adicionaLinha("", "documento", 137, STR_PAD_LEFT, "-");
		$this->adicionaLinha();
		$this->adicionaTexto("Codigo", "documento", 20);
		$this->adicionaTexto("Descricao", "documento", 61);
		$this->adicionaTexto("UN", "documento", 7);
		$this->adicionaTexto("Quant", "documento", 15);
		$this->adicionaTexto("Preco", "documento", 14);
		$this->adicionaTexto("Total", "documento", 20);
		$this->adicionaLinha();
		$this->adicionaLinha("", "documento", 137, STR_PAD_LEFT, "-");
		
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
		foreach ($model->NegocioProdutoBarras as $npb)
		{
			$this->adicionaTexto($npb->ProdutoBarra->barras, "documento", 20);
			$this->adicionaTexto($npb->ProdutoBarra->descricao, "documento", 65);
			$this->adicionaTexto($npb->ProdutoBarra->UnidadeMedida->sigla, "documento", 7);
			$this->adicionaTexto($npb->quantidade, "documento", 15);
			$this->adicionaTexto($npb->valorunitario, "documento", 15);
			$this->adicionaTexto($npb->valortotal, "documento", 15);
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

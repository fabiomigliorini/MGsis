<?php

/*
 * Condensado: 137 Colunas
 * Normal:      80 Colunas
 * Large:       40 Colunas
 * 
 */

class MGEscPrintRecibo extends MGEscPrint
{
	
	private $_model;
	
	function __construct($model, $impressora = null, $linhas = null) 
	{
		$this->_model = $model;
		parent::__construct($impressora, $linhas);

		$this->adicionaTexto("<Reset><6lpp><Draft><CondensedOn>", "cabecalho");
		
		//linha divisoria
		$this->adicionaLinha("", "cabecalho", 137, STR_PAD_RIGHT, "=");
		
		$filial = $model->MovimentoTitulos[0]->Titulo->Filial;
		
		// Fantasia e NUMERO do Vale
		$this->adicionaTexto("<DblStrikeOn>", "cabecalho");
		$this->adicionaTexto($filial->Pessoa->fantasia . " " . $filial->Pessoa->telefone1, "cabecalho", 68);
		$this->adicionaTexto("Recibo:           " . Yii::app()->format->formataCodigo($model->codliquidacaotitulo), "cabecalho", 69, STR_PAD_LEFT);
		$this->adicionaTexto("<DblStrikeOff>", "cabecalho");
		$this->adicionaLinha("", "cabecalho");
		
		// Usuario e Data
		if (isset($model->codusuariocriacao))
			$usuario = $model->UsuarioCriacao->usuario;
		else
			$usuario = Yii::app()->user->name;
		$this->adicionaTexto("Usuario: " . $usuario, "cabecalho", 68);
		$this->adicionaTexto("Data..: " . $model->criacao, "cabecalho", 69, STR_PAD_LEFT);
		$this->adicionaLinha("", "cabecalho");
		
		//linha divisoria
		$this->adicionaLinha("", "cabecalho", 137, STR_PAD_RIGHT, "=");
		
		//Rodape
		$this->adicionaTexto("", "rodape", 137, STR_PAD_RIGHT, "=");

		//titulo
		$this->adicionaLinha("");
		$this->adicionaTexto("<CondensedOff><LargeOn>");
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
		foreach ($resumo as $codtitulo => $valores)
		{
			//pula titulos de credito liquidados
			if ($valores["total"] < 0)
				continue;
			
			$titulo = Titulo::model()->findByPk($codtitulo);
			$this->adicionaTexto($titulo->numero, "documento", 29);
			$this->adicionaTexto($titulo->emissao, "documento", 12);
			$this->adicionaTexto($titulo->vencimento, "documento", 12);
			$this->adicionaTexto(Yii::app()->format->formatNumber($titulo->valor), "documento", 20, STR_PAD_LEFT);
			$this->adicionaTexto(Yii::app()->format->formatNumber($valores["principal"]), "documento", 20, STR_PAD_LEFT);
			$this->adicionaTexto(Yii::app()->format->formatNumber($valores["juros"] + $valores["multa"]), "documento", 12, STR_PAD_LEFT);
			$this->adicionaTexto(Yii::app()->format->formatNumber($valores["desconto"]), "documento", 12, STR_PAD_LEFT);
			$this->adicionaTexto("<DblStrikeOn>");
			$this->adicionaTexto(Yii::app()->format->formatNumber($valores["total"]), "documento", 20, STR_PAD_LEFT);
			$this->adicionaTexto("<DblStrikeOff>");
			$this->adicionaLinha();
		}
		
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
		$this->adicionaTexto("", "documento", 70, STR_PAD_LEFT, "-");
		$this->adicionaLinha();
		$this->adicionaTexto("", "documento", 67);
		$this->adicionaTexto($filial->Pessoa->pessoa . " " . Yii::app()->format->formataCnpjCpf($filial->Pessoa->cnpj, $filial->Pessoa->fisica), "documento", 70, STR_PAD_LEFT);
		$this->adicionaLinha();
		
	}
	
	
}

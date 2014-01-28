<?php

/*
 * Condensado: 137 Colunas
 * Normal:      80 Colunas
 * Large:       40 Colunas
 * 
 */

class MGEscPrintVale extends MGEscPrint
{
	
	private $_model;
	
	function __construct($model, $impressora = null, $linhas = null) 
	{
		$this->_model = $model;
		parent::__construct($impressora, $linhas);

		//inicializa
		$this->adicionaTexto("<Reset><6lpp><Draft><CondensedOff>", "cabecalho");
		
		//linha divisoria
		$this->adicionaLinha("", "cabecalho", 80, STR_PAD_RIGHT, "=");
		
		// Fantasia e NUMERO do Vale
		$this->adicionaTexto("<DblStrikeOn>", "cabecalho");
		$this->adicionaTexto($model->Filial->Pessoa->fantasia . " " . $model->Filial->Pessoa->telefone1, "cabecalho", 56);
		$this->adicionaTexto("Titulo:        " . Yii::app()->format->formataCodigo($model->codtitulo), "cabecalho", 24);
		$this->adicionaTexto("<DblStrikeOff>", "cabecalho");
		$this->adicionaLinha("", "cabecalho");
		
		// Usuario e Data
		if (isset($model->codusuariocriacao))
			$usuario = $model->UsuarioCriacao->usuario;
		else
			$usuario = Yii::app()->user->name;
		$this->adicionaTexto("Usuario: " . $usuario, "cabecalho", 56);
		$this->adicionaTexto("Data..: " . $model->sistema, "cabecalho", 24);
		$this->adicionaLinha("", "cabecalho");
		
		//linha divisoria
		$this->adicionaLinha("", "cabecalho", 80, STR_PAD_RIGHT, "=");

		//forca impressao cabecalho primeira pagina
		//$this->cabecalho();

		//Rodape
		$this->adicionaTexto("", "rodape", 80, STR_PAD_RIGHT, "=");
		
		//titulo
		$this->adicionaLinha("");
		$this->adicionaTexto("<LargeOn>");
		$this->adicionaTexto("<DblStrikeOn>");
		$this->adicionaTexto("V A L E", "documento", 40, STR_PAD_BOTH);
		$this->adicionaTexto("<DblStrikeOff>");
		$this->adicionaTexto("<LargeOff>");
		$this->adicionaLinha("");

		//Numero titulo
		$this->adicionaTexto("Numero....:", "documento", 12);
		$this->adicionaTexto($model->numero, "documento", 68);
		$this->adicionaLinha();
		
		//Espaco
		$this->adicionaLinha();
		
		//Fantasia
		$this->adicionaTexto("<DblStrikeOn>");
		$this->adicionaTexto("Favorecido: ");
		$this->adicionaTexto($model->Pessoa->fantasia . " (" .Yii::app()->format->formataCodigo($model->codpessoa) . ")", "documento", 68);
		$this->adicionaTexto("<DblStrikeOff>");
		$this->adicionaLinha();

		//Telefone
		$this->adicionaTexto("", "documento", 12);
		$this->adicionaTexto("{$model->Pessoa->telefone1} / {$model->Pessoa->telefone2} / {$model->Pessoa->telefone3}", "documento", 68);
		$this->adicionaLinha();
		
		//Razao Social
		$this->adicionaTexto("", "documento", 12);
		$this->adicionaTexto($model->Pessoa->pessoa, "documento", 68);
		$this->adicionaLinha();
		
		//Cnpj
		$this->adicionaTexto("", "documento", 12);
		$this->adicionaTexto("CNPJ/CPF: " . Yii::app()->format->formataCnpjCpf($model->Pessoa->cnpj, $model->Pessoa->fisica), "documento", 29);
		if (!empty($model->Pessoa->ie))
			$this->adicionaTexto("- Inscricao Estadual: " .Yii::app()->format->formataInscricaoEstadual($model->Pessoa->ie, $model->Pessoa->Cidade->Estado->sigla), "documento", 38);
		$this->adicionaLinha();

		//Espaco
		$this->adicionaLinha();
		
		//Extenso
		$this->adicionaTexto("<DblStrikeOn>");
		$linhas = Yii::app()->format->formataValorPorExtenso($model->creditosaldo, true);
		$linhas = "R$ " . Yii::app()->format->formatNumber($model->creditosaldo) . " ($linhas)";
		$linhas = str_split($linhas, 68);
		$label = "Valor.....:";
		foreach ($linhas as $linha)
		{
			$this->adicionaTexto($label, "documento", 12);
			$this->adicionaTexto(trim($linha), "documento", 68);
			$this->adicionaLinha();
			$label = "";
		}
		$this->adicionaTexto("<DblStrikeOff>");
		
		// Espaco
		$this->adicionaLinha();
		
		//Observacao
		if (!empty($model->observacao))
		{
			$label = "Observacao:";
			$linhas = str_split($model->observacao, 68);
			foreach ($linhas as $linha)
			{
				$this->adicionaTexto($label, "documento", 12);
				$this->adicionaTexto(trim($linha), "documento", 68);
				$this->adicionaLinha();
				$label = "";
			}
			
			// Espaco
			$this->adicionaLinha();
		}
		

		// Data por extenso
		$this->adicionaTexto("", "documento", 12);
		$this->adicionaTexto($model->Filial->Pessoa->Cidade->cidade);
		$this->adicionaTexto("/");
		$this->adicionaTexto($model->Filial->Pessoa->Cidade->Estado->sigla);
		$this->adicionaTexto(", ");
		$this->adicionaTexto(Yii::app()->format->formataDataPorExtenso($model->emissao));
		$this->adicionaTexto(".");
		$this->adicionaLinha();

		// Espaco
		$this->adicionaLinha();
		$this->adicionaLinha();
		$this->adicionaLinha();

		//Assinatura
		$this->adicionaTexto("", "documento", 12);
		$this->adicionaTexto("", "documento", 50, STR_PAD_RIGHT, "-");
		$this->adicionaLinha();
		$this->adicionaTexto("", "documento", 12);
		$this->adicionaTexto($model->Filial->Pessoa->pessoa, "documento", 50);
		$this->adicionaLinha();
		
	}
	
	
}

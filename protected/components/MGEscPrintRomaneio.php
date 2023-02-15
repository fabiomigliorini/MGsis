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

	function __construct(Negocio $model, $impressora = null, $linhas = null)
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
		$this->adicionaTexto("<DblStrikeOn><CondensedOff>", "cabecalho");
		$this->adicionaTexto($filial->Pessoa->fantasia . " " . $filial->Pessoa->telefone1, "cabecalho", 62);
		$this->adicionaTexto("Negocio: " . Yii::app()->format->formataCodigo($model->codnegocio), "cabecalho", 18, STR_PAD_LEFT);
		$this->adicionaTexto("<CondensedOn><DblStrikeOff>", "cabecalho");
		//$this->adicionaLinha("", "cabecalho");


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

		$linha = 'Natureza: ' . $model->NaturezaOperacao->naturezaoperacao;
		//$linha = str_pad($linha, 80, " ", STR_PAD_BOTH);
		$this->adicionaLinha($linha, "documento", 80);
		//die($linha);

        if ($model->codpessoa != Pessoa::CONSUMIDOR)
        {

            $linha = "Cliente.: "
                    . Yii::app()->format->formataCodigo($model->codpessoa)
                    . " "
                    . $model->Pessoa->fantasia;

            if (!empty($model->Pessoa->telefone1))
                $linha .= " - " . trim($model->Pessoa->telefone1);

            if (!empty($model->Pessoa->telefone2))
                $linha .= " / " . trim($model->Pessoa->telefone2);

            if (!empty($model->Pessoa->telefone3))
                $linha .= " / " . trim($model->Pessoa->telefone3);

            $this->adicionaLinha(
                    $linha
                    , "documento", 80);

            $this->adicionaTexto("<DblStrikeOff><CondensedOn>");

            if ($model->Pessoa->fisica)
                $linha = "CPF....: ";
            else
                $linha = "CNPJ...: ";

            $linha .=
                    Yii::app()->format->formataCnpjCpf($model->Pessoa->cnpj, $model->Pessoa->fisica)
                    . " - "
                    . $model->Pessoa->pessoa;

            $this->adicionaLinha(
                    $linha
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
        }

        $this->adicionaTexto("<DblStrikeOff><CondensedOn>");

		if ($model->valoraprazo > 0 && $model->codnaturezaoperacao != NaturezaOperacao::DEVOLUCAO_VENDA)
		{
			$this->adicionaLinha("", "documento", 137, STR_PAD_LEFT, "-");
			$this->adicionaTexto("<DblStrikeOn>");

			$linha = 1;
			$i = 1;
			$vencimentos = array();

			foreach ($model->NegocioFormaPagamentos as $nfp)
			{
				foreach ($nfp->Titulos as $titulo)
				{
					/*
					$vencimento = substr($titulo->vencimento, 0, 6) . substr($titulo->vencimento, 8, 2);
					$this->adicionaTexto($vencimento, "documento", 10);
					$this->adicionaLinha(Yii::app()->format->formatNumber($titulo->valor), "documento", 10, STR_PAD_LEFT);
					*/
					$vencimentos[$linha][$i] = array(
						"vencimento" => substr($titulo->vencimento, 0, 6) . substr($titulo->vencimento, 8, 2),
						"valor" => Yii::app()->format->formatNumber($titulo->valor)
							);
					$i++;

					if ($i>6)
					{
						$i = 1;
						$linha++;
					}
				}
			}

			$labelVencimentos = "Vencimentos | ";

			foreach ($vencimentos as $linha)
			{
				$this->adicionaTexto($labelVencimentos);
				$labelVencimentos = "            | ";

				$i = 1;
				foreach ($linha as $coluna)
				{
					$this->adicionaTexto($coluna["vencimento"], "documento", 8);
					$this->adicionaTexto($coluna["valor"], "documento", 10, STR_PAD_LEFT);
					if ($i <= 5)
						$this->adicionaTexto(" | ", "documento", 3);
					$i++;
				}
				$this->adicionaLinha();

				$this->adicionaTexto($labelVencimentos);

				$i = 1;
				foreach ($linha as $coluna)
				{
					$this->adicionaTexto("", "documento", 18, STR_PAD_LEFT);
					if ($i <= 5)
						$this->adicionaTexto(" | ", "documento", 3);
					$i++;
				}
				$this->adicionaLinha();
			}

		}
		$this->adicionaTexto("<DblStrikeOff>");
		$this->adicionaLinha("", "documento", 137, STR_PAD_LEFT, "-");

		$this->adicionaTexto("<DblStrikeOn>");
		$this->adicionaTexto("Codigo", "documento", 20);
		$this->adicionaTexto("Descricao", "documento", 70);
		$this->adicionaTexto("UM", "documento", 7);
		$this->adicionaTexto("Quant", "documento", 10, STR_PAD_LEFT);
		$this->adicionaTexto("Preco", "documento", 15, STR_PAD_LEFT);
		$this->adicionaTexto("Total", "documento", 15, STR_PAD_LEFT);
		$this->adicionaTexto("<DblStrikeOff>");
		$this->adicionaLinha();

		//$this->adicionaTexto("", "documento", 137, STR_PAD_LEFT, "-");
		//$this->adicionaLinha();

		//percorre produtos
		foreach ($model->NegocioProdutoBarras as $npb)
		{
			$this->adicionaTexto($npb->ProdutoBarra->barras, "documento", 20);
			$this->adicionaTexto($npb->ProdutoBarra->descricao, "documento", 65);
			$this->adicionaTexto($npb->ProdutoBarra->UnidadeMedida->sigla, "documento", 7, STR_PAD_LEFT);
			$this->adicionaTexto(Yii::app()->format->formatNumber($npb->quantidade), "documento", 15, STR_PAD_LEFT);
			$this->adicionaTexto(Yii::app()->format->formatNumber($npb->valorunitario), "documento", 15, STR_PAD_LEFT);
			$this->adicionaTexto(Yii::app()->format->formatNumber($npb->valortotal), "documento", 15, STR_PAD_LEFT);
			$this->adicionaLinha();
		}

		//linha divisoria
		$this->adicionaLinha("", "documento", 137, STR_PAD_LEFT, "-");

		//linha com totais
		$this->adicionaTexto("<DblStrikeOn>");
		$this->adicionaTexto("Subtotal:");
		$this->adicionaTexto(Yii::app()->format->formatNumber($model->valorprodutos), "documento", 27, STR_PAD_LEFT);
		$this->adicionaTexto("Desconto:", "documento", 10, STR_PAD_LEFT);
		$this->adicionaTexto(Yii::app()->format->formatNumber($model->valordesconto), "documento", 27, STR_PAD_LEFT);
                $this->adicionaTexto("Frete...:", "documento", 10, STR_PAD_LEFT);
                $this->adicionaTexto(Yii::app()->format->formatNumber($model->valorfrete), "documento", 26, STR_PAD_LEFT);
		$this->adicionaTexto("Total...:", "documento", 10, STR_PAD_LEFT);
		$this->adicionaTexto(Yii::app()->format->formatNumber($model->valortotal), "documento", 18, STR_PAD_LEFT);
		$this->adicionaLinha("<DblStrikeOff>");

		//total a prazo
        if ($model->codnaturezaoperacao == NaturezaOperacao::VENDA)
        {

            //total a vista
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

                $this->adicionaLinha();

                // Texto da confissao de divida

                //$this->adicionaLinha("Observação");


                $this->adicionaLinha("Confissao de Divida: Confesso(amos) e me(nos) constituo(imos) devedor(es) do valor descrito nesse negocio, obrigando-me(nos) a pagar em");
                $this->adicionaTexto("moeda corrente do pais, conforme vencimento. Declaro(amos) ainda, ter recebido o servico e/ou produto aqui descrito, sem nada a reclamar.");
                $this->adicionaLinha();
                $this->adicionaLinha();
                $this->adicionaLinha();

                //linha da assinatura
                $this->adicionaTexto("", "documento", 25);
                $this->adicionaLinha("", "documento", 80, STR_PAD_RIGHT, "_");

                //nome pessoa
                $this->adicionaTexto("<DblStrikeOn>");
                $this->adicionaTexto("", "documento", 25);
                $this->adicionaTexto(
                        $model->codnegocio
                        ." - "
                        .$model->Pessoa->pessoa
                        , "documento"
                        , 80);
                $this->adicionaLinha("<DblStrikeOff>");
            }
        }

        if ($model->codnaturezaoperacao == NaturezaOperacao::DEVOLUCAO_VENDA && $model->codpessoa == Pessoa::CONSUMIDOR)
        {
            $this->adicionaLinha("", "documento");
            $this->adicionaTexto("<CondensedOff><DblStrikeOn>");
            $this->adicionaLinha("PREENCHER DADOS ABAIXO PARA EMISSAO DA NOTA FISCAL DE DEVOLUCAO", "documento", 80, STR_PAD_BOTH);
            $this->adicionaTexto("<CondensedOn><DblStrikeOff>");
            $this->adicionaLinha("", "documento");
            $this->adicionaLinha("", "documento");
            $this->adicionaLinha("Nome Cliente:", "documento", 137, STR_PAD_RIGHT, "_");
            $this->adicionaLinha("", "documento");
            $this->adicionaTexto("CPF/CNPJ....:", "documento", 95, STR_PAD_RIGHT, "_");
            $this->adicionaLinha("Telefone:", "documento", 42, STR_PAD_RIGHT, "_");
            $this->adicionaLinha("", "documento");
            $this->adicionaTexto("Endereco....:", "documento", 95, STR_PAD_RIGHT, "_");
            $this->adicionaLinha("Cidade..:", "documento", 42, STR_PAD_RIGHT, "_");
            $this->adicionaLinha("", "documento");
            $this->adicionaLinha("E-mail......:", "documento", 137, STR_PAD_RIGHT, "_");
            //$this->adicionaTexto(Yii::app()->format->formatNumber($model->valoraprazo), "documento", 18, STR_PAD_LEFT);
        }

		if (!empty($model->observacoes))
		{
			$this->adicionaLinha();
			$observacoes = "Observacoes: ";
			$observacoes .= $model->observacoes;
			$observacoes = str_split($observacoes, 137);
			foreach($observacoes as $linha)
			{
				$this->adicionaLinha($linha);
			}
		}

	}

}

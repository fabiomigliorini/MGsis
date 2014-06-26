<?php

/**
 * @property Negocio $_model 
 */

Yii::import('application.vendors.fpdf.*');

require_once('fpdf.php');

class MGRelatorioOrcamento extends FPDF
{
	private $_model;
	private $_fill = false;
	private $_totais = array();
	
	/**
	 * 
	 * @param Negocio $model
	 */
	public function __construct($model)
	{
		$this->_model = $model;
		return parent::__construct();
	}
	
	// Page header
	function Header()
	{
		// Logo
		$this->SetLineWidth(0.6);
		$this->SetTextColor(0, 0, 0);
		$this->SetDrawColor(0,0,0);
		$this->Image(Yii::app()->basePath . '/../images/MGPapelaria.jpg', 162, 10, 38);
		$this->SetFont('Arial','B',20);
		$this->Cell(10, 7, utf8_decode('Orçamento'));
		$this->Line(10, 8, 200, 8);
		$this->Line(10, 19, 200, 19);
		$this->Ln(12);
	}
	
	// Page footer
	function Footer()
	{
		$this->SetLineWidth(0.6);
		$this->SetDrawColor(0,0,0);
		// Position at 1.5 cm from bottom
		$this->SetY(-16);
		// Arial italic 8
		$this->SetFont('Arial','I',7);
		$this->Line(10, 280, 200, 280);
		// Page number
		$this->SetTextColor(100, 100, 100);
		$this->Cell(63,3, 'MGsis',"",0,'L');
		$this->Cell(64,3, utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
		$this->Cell(63,3, date('d/m/Y H:i:s'),"",0,'R');
	}	

	public function montaRelatorio()
	{
			
		$this->AddPage();
		
		$negocio = $this->_model;
		
		//Informações da empresa e do negocio
		$this->SetFont('Arial','',10);
		$this->Cell(20, 6, utf8_decode("Filial:"));
		$this->Cell(128, 6, utf8_decode($negocio->Filial->filial));

		$this->Cell(24, 6, utf8_decode("Negócio:"));
		$this->Cell(18, 6, utf8_decode(Yii::app()->format->formataCodigo(abs($negocio->codnegocio))),   '', 0, 'L', $this->_fill);
		
		$this->Ln();
		$this->Cell(20, 6, utf8_decode("Vendedor:"));
		if (isset($negocio->PessoaVendedor))
			$vendedor=$negocio->PessoaVendedor->fantasia;
		else 
			$vendedor="";
		
		$this->Cell(128, 6, utf8_decode($vendedor));
		
		$this->Cell(24, 6, utf8_decode("Data:"));
		$this->Cell(16, 6, utf8_decode(substr($negocio->lancamento, 0, 10)),   '', 0, 'L', $this->_fill);
		$this->ln();
		
		//Divisoria
		$this->SetLineWidth(0.6);
		$this->Cell(190, 4, "", "T");
		$this->ln();
		
		// fantasia cliente
		$telefones = array();
		if (!empty($this->_model->Pessoa->telefone1))
			$telefones[] = $this->_model->Pessoa->telefone1;
		if (!empty($this->_model->Pessoa->telefone2))
			$telefones[] = $this->_model->Pessoa->telefone2;
		$telefones = implode(" / ", $telefones);

		$this->SetTextColor(100, 100, 100);
		$this->SetFont('Arial','',10);
		$this->Cell(18, 5, utf8_decode("Cliente:"));
		$this->SetTextColor(0, 0, 0);
		$this->SetFont('Arial','B',15);		
		$this->Cell(172, 5, utf8_decode($negocio->Pessoa->fantasia  . " - " . $telefones), null ,1);
		$this->ln();

		
		// codigo / cnpj / ie / razao social / Endereço
		$this->SetTextColor(100, 100, 100);
		$this->SetFont('Arial','',9);
		$this->Cell(17, 0, utf8_decode("Cnpj/Cpf:"));
		
		$this->SetTextColor(100, 100, 100);
		$this->SetFont('Arial','',9);
		$this->Cell(10, 0, 
			utf8_decode(
				(($this->_model->Pessoa->fisica)?"CPF: ":"CNPJ: ") . 
				Yii::app()->format->formataCnpjCpf($this->_model->Pessoa->cnpj, $this->_model->Pessoa->fisica) .
				((!empty($this->_model->Pessoa->ie))?" - IE: " . Yii::app()->format->formataInscricaoEstadual($this->_model->Pessoa->ie, $this->_model->Pessoa->Cidade->Estado->sigla):"") .
				" - " . $this->_model->Pessoa->pessoa
			)
		);
		$this->ln();
		
		$this->Cell(18, 10, utf8_decode("Endereço:"));
		$this->Cell(18, 10, utf8_decode(
			$negocio->Pessoa->endereco
			." - "	
			.$negocio->Pessoa->bairro
			." - "
			.$negocio->Pessoa->Cidade->cidade
			."/"
			.$negocio->Pessoa->Cidade->Estado->sigla
			." - "
			.Yii::app()->format->formataCep($negocio->Pessoa->cep)));
		
		$this->ln();
		
		//Difvisoria
		$this->SetLineWidth(0.6);
		$this->Cell(190, 4, "", "T");
		$this->ln();

		//Cabeça dos Produtos
		$this->SetTextColor(0, 0, 0);
		$this->SetFont('Arial','B',9);		
		$this->Cell(23, 3, utf8_decode ("Código"),	    '', 0, 'L', $this->_fill);
		$this->Cell(100, 3, utf8_decode ("Descreição"),  '', 0, 'L', $this->_fill);
		$this->Cell(13, 3, utf8_decode ("UM"),			'', 0, 'L', $this->_fill);
		$this->Cell(18, 3, utf8_decode ("Quant"),		'', 0, 'R', $this->_fill);
		$this->Cell(18, 3, utf8_decode ("Preço"),		'', 0, 'R', $this->_fill);
		$this->Cell(18, 3, utf8_decode ("Total"),		'', 0, 'R', $this->_fill);
		
		//Divisoria
		$this->ln();
		$this->SetTextColor(100, 100, 100);
		$this->SetLineWidth(0.1);
		$this->Cell(190, 1, "", "T");
		$this->ln();

		
		//Produtos
		$this->SetFont('Arial','',9);
		foreach ($negocio->NegocioProdutoBarras as $npb)
		{
			$this->Cell(23, 6, utf8_decode($npb->ProdutoBarra->barras));
			$this->Cell(100, 6, utf8_decode($npb->ProdutoBarra->descricao));
			$this->Cell(13, 6, utf8_decode($npb->ProdutoBarra->UnidadeMedida->sigla));
			$this->Cell(18, 6, (Yii::app()->format->formatNumber(abs($npb->quantidade))), '', 0, 'R', $this->_fill);
			$this->Cell(18, 6, (Yii::app()->format->formatNumber(abs($npb->valorunitario))), '', 0, 'R', $this->_fill);
			$this->Cell(18, 6, (Yii::app()->format->formatNumber(abs($npb->valortotal))), '', 0, 'R', $this->_fill);
			$this->ln();

		}
		
		//Divisorias
		$this->ln();		
		$this->SetLineWidth(0.6);
		$this->Cell(190, 3, "", "T");
		$this->ln();
		
		//Totais
		$this->Cell(32, 2, ("Subtotal:"));
		$this->Cell(42, 2, (Yii::app()->format->formatNumber($negocio->valorprodutos)));
		$this->Cell(32, 2, ("Desconto:"));
		$this->Cell(41, 2, (Yii::app()->format->formatNumber($negocio->valordesconto)));
		$this->SetTextColor(0, 0, 0);
		$this->SetFont('Arial','B',9);
		$this->Cell(31, 2, ("Total.....:"));
		$this->Cell(12, 2, (Yii::app()->format->formatNumber($negocio->valortotal)), '', 0, 'R', $this->_fill);
		$this->ln();

		//Divisoria
		$this->ln();		
		$this->SetTextColor(100, 100, 100);
		$this->SetLineWidth(0.6);
		$this->Cell(190, 4, "", "T");
		$this->ln();	
		$this->ln();
		
		if (!empty($negocio->NegocioFormaPagamentos))
		{
			$this->Cell(30, 6, utf8_decode("Forma de Pagamento"));
			$this->ln();
			
		}
		
		foreach ($negocio->NegocioFormaPagamentos as $nfp)
		{
			$this->Cell(30, 6, utf8_decode($nfp->FormaPagamento->formapagamento));
			$this->Cell(15, 6, utf8_decode($nfp->valorpagamento));
			$this->ln();
		}
		
		//Observações
		if (!empty($negocio->observacoes))
		{
			$this->Cell(15, 6, utf8_decode("Observações:"));
			$this->Cell(18, 6, utf8_decode($negocio->observacoes));

		}
		$this->ln();
		$this->ln();
		$this->ln();
		$this->ln();
		$this->ln();
		$this->Cell(15, 6, utf8_decode("____________________________________________"));
		
		$this->ln();
		$this->Cell(18, 6, utf8_decode($negocio->Filial->Pessoa->pessoa));
		$this->ln();
		$this->Cell(10, 6, utf8_decode("Cnpj:"));	
		$this->Cell(18, 6, Yii::app()->format->formataCnpjCpf(utf8_decode($negocio->Filial->Pessoa->cnpj)));
		$this->ln();
		$this->Cell(10, 6, utf8_decode("Fone:"));	
		$this->Cell(18, 6, utf8_decode($negocio->Filial->Pessoa->telefone1));



		/*---------------------------------------------------------------------
		
		$titulos = $this->_model->Titulos;
		
		$telefones = array();
		if (!empty($this->_model->Pessoa->telefone1))
			$telefones[] = $this->_model->Pessoa->telefone1;
		if (!empty($this->_model->Pessoa->telefone2))
			$telefones[] = $this->_model->Pessoa->telefone2;
		if (!empty($this->_model->Pessoa->telefone3))
		if (!empty($this->_model->Pessoa->telefone3))
			$telefones[] = $this->_model->Pessoa->telefone3;
		$telefones = implode(" / ", $telefones);

		// fantasia cliente
		$this->SetTextColor(100, 100, 100);
		$this->SetFont('Arial','',8);
		$this->Cell(18, 6, utf8_decode("Cliente:"));
		$this->SetTextColor(0, 0, 0);
		$this->SetFont('Arial','B',12);		
		$this->Cell(172, 6, utf8_decode($this->_model->Pessoa->fantasia  . " - " . $telefones), null ,1);
		
		// codigo / cnpj / ie / razao social
		$this->SetTextColor(100, 100, 100);
		$this->SetFont('Arial','',8);
		$this->Cell(18, 4, '');
		$this->Cell(172, 4, 
			utf8_decode(
				Yii::app()->format->formataCodigo($this->_model->codpessoa) . " - " .
				(($this->_model->Pessoa->fisica)?"CPF: ":"CNPJ: ") . 
				Yii::app()->format->formataCnpjCpf($this->_model->Pessoa->cnpj, $this->_model->Pessoa->fisica) .
				((!empty($this->_model->Pessoa->ie))?" - IE: " . Yii::app()->format->formataInscricaoEstadual($this->_model->Pessoa->ie, $this->_model->Pessoa->Cidade->Estado->sigla):"") .
				" - " . $this->_model->Pessoa->pessoa
			)
		);
		$this->ln();
		
		// filial
		$this->Cell(18, 8, utf8_decode("Filial:"));
		$this->Cell(172, 8, 
			utf8_decode(
				$titulos[0]->Filial->Pessoa->fantasia . " (" .
				$titulos[0]->Filial->Pessoa->pessoa . " - " .
				Yii::app()->format->formataCnpjCpf($titulos[0]->Filial->Pessoa->cnpj, $titulos[0]->Filial->Pessoa->fisica) . ") - " .
				$titulos[0]->Filial->Pessoa->telefone1
			)
		);
		$this->ln();
		
		// linha divisoria entre cabecalho e vencimentos
		$this->SetLineWidth(0.6);
		$this->Cell(190, 4, "", "T");
		$this->ln();
		

		// Label Vencimentos do fechamento
		$this->SetTextColor(0, 0, 0);
		$this->SetFont('Arial','B',12);		
		$this->Cell(190, 10, utf8_decode("Vencimento(s) do Fechamento:"));
		$this->ln();
		
		// cabecalho Titulos
		$this->SetLineWidth(0.2);
		$this->SetFont('Arial','',8);
		$this->Cell(25, 6, utf8_decode("Número"), "B");
		$this->Cell(20, 6, utf8_decode("Emissão"), "B", 0, 'C');
		$this->Cell(20, 6, utf8_decode("Vencimento"), "B", 'C');
		$this->Cell(22, 6, utf8_decode("Valor"), "B", 0, 'R');
		$this->Cell( 5, 6, null, "B", 0, 'C');
		$this->Cell(38, 6, utf8_decode("Boleto"), "B", 0, "L");
		$this->Cell(30, 6, utf8_decode("Agendado Para"), "B", 0, "C");
		$this->Cell(30, 6, utf8_decode("Pago em"), "B", 0, "C");
		$this->ln();

		// linhas dos títulos
		$this->SetFillColor(240,240,240);
		$this->_fill = false;
		foreach ($titulos as $titulo)
		{
			$this->Cell(25, 10, utf8_decode($titulo->numero), null, 0, 'L', $this->_fill);
			$this->Cell(20, 10, utf8_decode($titulo->emissao), null, 0, 'C', $this->_fill);
			$this->Cell(20, 10, utf8_decode($titulo->vencimento), null, 0, 'C', $this->_fill);
			$this->Cell(22, 10, utf8_decode(Yii::app()->format->formatNumber(abs($titulo->valor))), null, 0, 'R', $this->_fill);
			$this->Cell( 5, 10, utf8_decode($titulo->operacao), null, 0, 'R', $this->_fill);
			$this->Cell(38, 10, 
				utf8_decode(
					(($titulo->boleto)?$titulo->Portador->portador . " - " . $titulo->nossonumero:"Não")
					), 
				null, 0, 'L', $this->_fill);
			$this->Cell(30, 10, "______/_____/_____", null, 0, 'C', $this->_fill);
			$this->Cell(30, 10, "______/_____/_____", null, 0, 'C', $this->_fill);
			$this->ln();
			$this->_fill = !$this->_fill;
		}
		
		// linha divisoria entre Titulos e Movimentos
		$this->SetLineWidth(0.6);
		$this->Cell(190, 4);
		$this->ln();
		

		// Label Vencimentos do fechamento
		$this->SetTextColor(0, 0, 0);
		$this->SetFont('Arial','B',12);		
		$this->Cell(190, 10, utf8_decode("Em substituição ao(s) seguinte(s) título(s):"));
		$this->ln();
		
		// cabecalho Movimentos
		$this->SetLineWidth(0.2);
		$this->SetFont('Arial','',8);
		$this->Cell(20, 6, utf8_decode("Filial"), "B");
		$this->Cell(25, 6, utf8_decode("Número"), "B");
		$this->Cell(20, 6, utf8_decode("Emissão"), "B", 0, 'C');
		$this->Cell(20, 6, utf8_decode("Vencimento"), "B", 'C');
		$this->Cell(22, 6, utf8_decode("Valor"), "B", 0, 'R');
		$this->Cell( 5, 6, null, "B", 0, 'C');
		$this->ln();

		// linhas dos movimentos
		$this->SetFillColor(240,240,240);
		$this->_fill = false;
		foreach ($this->_model->MovimentoTitulos as $mov)
		{
			if ($mov->codtipomovimentotitulo != TipoMovimentoTitulo::TIPO_AGRUPAMENTO)
				continue;
			
			$titulo = $mov->Titulo;
			
			$this->Cell(20, 6, utf8_decode($titulo->Filial->filial), null, 0, 'L', $this->_fill);
			$this->Cell(25, 6, utf8_decode($titulo->numero), null, 0, 'L', $this->_fill);
			$this->Cell(20, 6, utf8_decode($titulo->emissao), null, 0, 'C', $this->_fill);
			$this->Cell(20, 6, utf8_decode($titulo->vencimento), null, 0, 'C', $this->_fill);
			$this->Cell(22, 6, utf8_decode(Yii::app()->format->formatNumber(abs($mov->valor))), null, 0, 'R', $this->_fill);
			$this->Cell( 5, 6, utf8_decode(($mov->operacao=="CR")?"DB":"CR"), null, 0, 'R', $this->_fill);
			
			$this->ln();
			$this->_fill = !$this->_fill;
		}
		$this->ln();
		
		// linha divisoria entre cabecalho e vencimentos
		$this->SetLineWidth(0.6);
		$this->Cell(190, 4, "", "T");
		$this->ln();

		// declaracao de divida
		$this->SetFont('Arial', '', 10);		
		$this->MultiCell(
			190, 
			5, 
			utf8_decode(
				"Declaro(amos) ter conferido o(s) título(s) acima listado(s), que reconheço(emos) a exatidão da dívida de R$ " . 
				Yii::app()->format->formatNumber($this->_model->valor) . " (" .
				MGFormatter::formataValorPorExtenso($this->_model->valor, true) .
				") expressa neste relatório e que pagarei(emos) a importância à " .
				$titulos[0]->Filial->Pessoa->pessoa .
				", ou a sua ordem, no(s) vencimento(s) e/ou nos agendamento(s) acima indicado(s)."
			)
		);
		$this->ln();
		$this->ln();

		// local e data para preenchimento
		$this->Cell(190, 4, "________________________,____ de _________________ de ______.", null, null, "R");
		$this->ln();
		$this->ln();
		$this->ln();
		$this->ln();
		$this->Cell(75, 4, "");
		$this->Cell(115, 4, "__________________________________________________________", null, null, "C");
		
		// Razao Social
		$this->ln();
		$this->Cell(75, 6, "");
		$this->Cell(115, 6, utf8_decode($this->_model->Pessoa->pessoa), null, null, "C");
		
		// CNPJ
		$this->ln();
		$this->Cell(75, 4, "");
		$this->Cell(
			115, 
			4, 
			utf8_decode(
				(($this->_model->Pessoa->fisica)?"CPF: ":"CNPJ: ") . 
				Yii::app()->format->formataCnpjCpf($this->_model->Pessoa->cnpj, $this->_model->Pessoa->fisica)
			), 
			null, 
			null, 
			"C"
		);
		*/
		// numero de paginas do rodape
		$this->AliasNbPages();
		
	}

}
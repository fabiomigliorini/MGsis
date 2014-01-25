<?php

Yii::import('application.vendors.fpdf.*');

require_once('fpdf.php');

class MGRelatorioTitulos extends FPDF
{
	private $_titulos;
	private $_titulo;
	private $_fill = false;
	private $_totais = array();
	
	public function __construct($titulos)
	{
		$this->_titulos = $titulos;
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
		$this->Cell(10, 7, utf8_decode('Relatório de Títulos'));
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
	
	public function imprimeCabecalhoPessoa()
	{
		$this->SetTextColor(100, 100, 100);
		$this->SetFont('Arial','',8);
		$this->SetLineWidth(0.6);
		$this->Cell(18, 8, utf8_decode(Yii::app()->format->formataCodigo($this->_titulo->codpessoa)), 'B');
		$this->SetTextColor(0, 0, 0);
		$this->SetFont('Arial','B',12);		
		$this->Cell(172, 8, utf8_decode($this->_titulo->Pessoa->fantasia), 'B',1);
		$this->SetLineWidth(0.2);
		
		$this->SetFont('Arial','B',8);
		$this->Cell(37, 6, utf8_decode("Título"),   'B', 0, 'L');
		$this->Cell(15, 6, utf8_decode("Filial"),   'B', 0, 'L');
		$this->Cell(16, 6, utf8_decode("Emissão"),  'B', 0, 'C');
		$this->Cell(22, 6, utf8_decode("Original"), 'B', 0, 'R');
		$this->Cell(16, 6, utf8_decode("Venc"),     'B', 0, 'C');
		$this->Cell(22, 6, utf8_decode("Saldo"),    'B', 0, 'R');
		$this->Cell(16, 6, utf8_decode("Multa"),    'B', 0, 'R');
		$this->Cell(16, 6, utf8_decode("Juros"),    'B', 0, 'R');
		$this->Cell(22, 6, utf8_decode("Total"),    'B', 0, 'R');
		$this->Cell(8,  6, utf8_decode("OP"),       'B', 0, 'C');
		$this->Ln();
		$this->_fill = false;
		
		$this->_totais["original"][$this->_titulo->codpessoa]   = 0;
		$this->_totais["saldo"][$this->_titulo->codpessoa]      = 0;
		$this->_totais["valorMulta"][$this->_titulo->codpessoa] = 0;
		$this->_totais["valorJuros"][$this->_titulo->codpessoa] = 0;
		$this->_totais["valorTotal"][$this->_titulo->codpessoa] = 0;
		
		
	}
	
	public function imprimeLinhaTitulo()
	{
		
		$this->SetFillColor(240,240,240);
		$this->SetFont('Arial','',8);
		
		$this->SetTextColor(0, 0, 0);
		$this->Cell(37, 6, utf8_decode($this->_titulo->numero),   '', 0, 'L', $this->_fill);
		
		if ($this->_titulo->gerencial)
			$this->SetTextColor(255, 100, 0);
		else
			$this->SetTextColor(0, 150, 0);
		
		$this->Cell(15, 6, utf8_decode($this->_titulo->Filial->filial),   '', 0, 'L', $this->_fill);
		
		$this->SetTextColor(0, 0, 0);
		$this->Cell(16, 6, utf8_decode($this->_titulo->emissao),  '', 0, 'C', $this->_fill);
		$this->Cell(22, 6, utf8_decode(Yii::app()->format->formatNumber(abs($this->_titulo->debito - $this->_titulo->credito))), '', 0, 'R', $this->_fill);
		
		if ($this->_titulo->saldo == 0) 
			$this->SetTextColor(100, 100, 100);
		else
			if ($this->_titulo->Juros->diasAtraso > 0)
			{
				if ($this->_titulo->Juros->diasAtraso <= $this->_titulo->Juros->diasTolerancia) 
				{
					$this->SetTextColor(255, 100, 0);
				}
				else 
				{
					$this->SetTextColor(255, 0, 0);
				}
			}
			else
			{
				$css_vencimento = "text-success";
				$this->SetTextColor(0, 150, 0);
			}
			
		$this->SetFont('Arial','B',8);
		$this->Cell(16, 6, utf8_decode($this->_titulo->vencimento),     '', 0, 'C', $this->_fill);
		
		$this->SetFont('Arial','',8);
		$this->Cell(22, 6, utf8_decode(Yii::app()->format->formatNumber(abs($this->_titulo->saldo))), '', 0, 'R', $this->_fill);
		$this->Cell(16, 6, utf8_decode(Yii::app()->format->formatNumber(abs($this->_titulo->Juros->valorMulta))), '', 0, 'R', $this->_fill);
		$this->Cell(16, 6, utf8_decode(Yii::app()->format->formatNumber(abs($this->_titulo->Juros->valorJuros))), '', 0, 'R', $this->_fill);
		
		$this->SetFont('Arial','B',8);
		$this->Cell(22, 6, utf8_decode(Yii::app()->format->formatNumber(abs($this->_titulo->Juros->valorTotal))), '', 0, 'R', $this->_fill);
		
		$this->SetFont('Arial','',8);
		$this->Cell(8, 6, utf8_decode($this->_titulo->operacao), '', 0, 'C', $this->_fill);
		$this->Ln();
		$this->_fill = ! $this->_fill;
		
		$this->_totais["original"][$this->_titulo->codpessoa] += $this->_titulo->debito-$this->_titulo->credito;
		$this->_totais["saldo"][$this->_titulo->codpessoa] += $this->_titulo->saldo;
		$this->_totais["valorMulta"][$this->_titulo->codpessoa] += $this->_titulo->Juros->valorMulta;
		$this->_totais["valorJuros"][$this->_titulo->codpessoa] += $this->_titulo->Juros->valorJuros;
		$this->_totais["valorTotal"][$this->_titulo->codpessoa] += $this->_titulo->Juros->valorTotal;		
		
		$this->_totais["original"]["geral"] += $this->_titulo->debito-$this->_titulo->credito;
		$this->_totais["saldo"]["geral"] += $this->_titulo->saldo;
		$this->_totais["valorMulta"]["geral"] += $this->_titulo->Juros->valorMulta;
		$this->_totais["valorJuros"]["geral"] += $this->_titulo->Juros->valorJuros;
		$this->_totais["valorTotal"]["geral"] += $this->_titulo->Juros->valorTotal;		
	}

	public function imprimeTotais($codpessoa)
	{
		
		if ($codpessoa == "geral")
			$this->SetLineWidth (0.6);
		else
			$this->SetLineWidth (0.2);
			
		$this->SetFont('Arial','B',8);
		
		$this->SetTextColor(0, 0, 0);
		
		if ($codpessoa == "geral")
		{
			$this->Ln();
			$this->Cell(68, 6, utf8_decode("Total Geral"),   'T', 0, 'R');
		}
		else
			$this->Cell(68, 6, utf8_decode("Total"),   'T', 0, 'R');
			
		$this->Cell(22, 6, utf8_decode(Yii::app()->format->formatNumber(abs($this->_totais["original"][$codpessoa]))), 'T', 0, 'R');
		$this->Cell(16, 6, '',     'T', 0, 'C', false);
		$this->Cell(22, 6, utf8_decode(Yii::app()->format->formatNumber(abs($this->_totais["saldo"][$codpessoa]))), 'T', 0, 'R');
		$this->Cell(16, 6, utf8_decode(Yii::app()->format->formatNumber(abs($this->_totais["valorMulta"][$codpessoa]))), 'T', 0, 'R');
		$this->Cell(16, 6, utf8_decode(Yii::app()->format->formatNumber(abs($this->_totais["valorJuros"][$codpessoa]))), 'T', 0, 'R');
		$this->Cell(22, 6, utf8_decode(Yii::app()->format->formatNumber(abs($this->_totais["valorTotal"][$codpessoa]))), 'T', 0, 'R');
		$this->Cell(8, 6, utf8_decode(($this->_totais["valorTotal"][$codpessoa]<0)?"CR":"DB"), 'T', 0, 'C');
		$this->Ln();
		
	}
	
	public function montaRelatorio()
	{
		$this->_totais["original"]["geral"]   = 0;
		$this->_totais["saldo"]["geral"]      = 0;
		$this->_totais["valorMulta"]["geral"] = 0;
		$this->_totais["valorJuros"]["geral"] = 0;
		$this->_totais["valorTotal"]["geral"] = 0;
		
		$this->AddPage();
		$this->SetFont('Arial','',14);
		
		//$titulos = $this->_dataProvider->getData();

		$codpessoa = null;
		$linha = 0;

		foreach ($this->_titulos as $this->_titulo)
		{
			if ($codpessoa <> $this->_titulo->codpessoa)
			{
				if (!empty($codpessoa))
				{
					$this->imprimeTotais($codpessoa);
					$this->Ln();
				}
				$this->imprimeCabecalhoPessoa();
			}
			
			$codpessoa = $this->_titulo->codpessoa;
			$this->imprimeLinhaTitulo();
		}
		
		if (!empty($codpessoa))
			$this->imprimeTotais($codpessoa);
		
		$this->imprimeTotais("geral");
		
		$this->AliasNbPages();

	}

}
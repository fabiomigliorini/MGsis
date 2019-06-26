<?php

Yii::import('application.vendors.fpdf.*');

require_once('fpdf.php');

class MGRelatorioLiquidacaoTitulo extends FPDF
{
	private $_titulos;
	private $_titulo;
	private $_fill = false;
	private $_totais = array();
	
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
		$this->Cell(10, 7, utf8_decode('Relatório de Liquidações de Títulos'));
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
		
		// cabecalho
		$this->SetFont('Arial','B',8);
		$this->Cell(16, 5, utf8_decode("#"),   'B', 0, 'C');
		$this->Cell(40, 5, utf8_decode("Pessoa"),   'B', 0, 'L');
		$this->Cell(20, 5, utf8_decode("Total"),  'B', 0, 'R');
		$this->Cell( 6, 5, utf8_decode("OP"), 'B', 0, 'L');
		$this->Cell(25, 5, utf8_decode("Portador"),     'B', 0, 'L');
		$this->Cell(16, 5, utf8_decode("Transação"),    'B', 0, 'C');
		$this->Cell(28, 5, utf8_decode("Criação"),    'B', 0, 'C');
		$this->Cell(16, 5, utf8_decode("Estornado"),    'B', 0, 'C');
		$this->Cell(23, 5, utf8_decode("Usuário"),    'B', 0, 'L');
		$this->Ln();
		$this->_fill = false;
		
		$total = 0;
		
		// linhas das liquidacoes
		foreach ($this->_model as $liq)
		{
			$this->SetFillColor(240,240,240);
			$this->SetFont('Arial','',8);
			$this->SetTextColor(0, 0, 0);
			$this->Cell(16, 5, utf8_decode(Yii::app()->format->formataCodigo($liq->codliquidacaotitulo)),   '', 0, 'L', $this->_fill);
			$this->Cell(40, 5, utf8_decode(substr($liq->Pessoa->fantasia, 0, 30)),   '', 0, 'L', $this->_fill);
			
			if ($liq->operacao == 'CR') 
				$this->SetTextColor(255, 100, 0);
			else
				$this->SetTextColor(0, 150, 0);
			
			$this->Cell(20, 5, utf8_decode(Yii::app()->format->formatNumber($liq->valor)),   '', 0, 'R', $this->_fill);
			$this->Cell( 6, 5, utf8_decode($liq->operacao),   '', 0, 'L', $this->_fill);
			
			$this->SetTextColor(0, 0, 0);
			
			$this->Cell(25, 5, utf8_decode($liq->Portador->portador),   '', 0, 'L', $this->_fill);
			$this->Cell(16, 5, utf8_decode($liq->transacao),   '', 0, 'C', $this->_fill);
			$this->Cell(28, 5, utf8_decode($liq->criacao),   '', 0, 'C', $this->_fill);
			$this->Cell(16, 5, utf8_decode(substr($liq->estornado, 0, 10)),   '', 0, 'C', $this->_fill);
			$this->Cell(23, 5, utf8_decode($liq->UsuarioCriacao->usuario),   '', 0, 'L', $this->_fill);
			
			$total += $liq->debito - $liq->credito;

			$this->Ln();
			$this->_fill = ! $this->_fill;
			
		}
		
		// Totais
		$this->SetFont('Arial','B',8);			
		$this->Cell( 56, 6, utf8_decode("Total"),                                       'T', 0, 'R');
		$this->Cell( 20, 6, utf8_decode(Yii::app()->format->formatNumber(abs($total))), 'T', 0, 'R', false);
		$this->Cell(  6, 6, utf8_decode(($total<0)?"CR":"DB"),                          'T', 0, 'L', false);
		$this->Cell(108, 6, '',                                                         'T', 0, 'R', false);
		$this->Ln();
		
		// Alias total de paginas
		$this->AliasNbPages();
	}

}
<?php

Yii::import('application.vendors.fpdf.*');

require_once('fpdf.php');
/**
 * This is the model class for table "mgsis.tblnegocioprodutobarra".
 *
 * The followings are the available columns in table 'mgsis.tblnegocioprodutobarra':
 * @property boolean $_fill
 * @property array $_totais
 *
 * The followings are the available model relations:
 * @property Negocio[] $_negocios
 * @property Negocio $_negocio
 */
class MGRelatorioNegocios extends FPDF
{
	private $_negocios;
	private $_negocio;
	private $_fill = false;
	private $_totais = array();
	
	public function __construct($negocios)
	{
		$this->_negocios = $negocios;
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
		$this->Cell(10, 7, utf8_decode('Relatório de Negócios'));
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
	
	public function imprimeCabecalho()
	{
	
		$this->SetFillColor(240,240,240);
		$this->SetFont('Arial','B',7);
		
		$this->SetTextColor(0, 0, 0);
		
		$this->Cell(11, 5, utf8_decode("Filial"),   'B', 0, 'L', $this->_fill);		
		$this->Cell(12, 5, utf8_decode("Usuário"),   'B', 0, 'L', $this->_fill);		
		$this->Cell(9, 5, utf8_decode("Oper"),   'B', 0, 'L', $this->_fill);		
		$this->Cell(15, 5, utf8_decode("#"),   'B', 0, 'L', $this->_fill);		
		$this->Cell(11, 5, utf8_decode("Data"),   'B', 0, 'L', $this->_fill);		
		$this->Cell(18, 5, utf8_decode("À Prazo"),   'B', 0, 'R', $this->_fill);		
		$this->Cell(18, 5, utf8_decode("À Vista"),   'B', 0, 'R', $this->_fill);		
		$this->Cell(18, 5, utf8_decode("Total"),   'B', 0, 'R', $this->_fill);		
		$this->Cell(15, 5, utf8_decode("Status"),   'B', 0, 'C', $this->_fill);		
		$this->Cell(14, 5, utf8_decode("# Pessoa"),   'B', 0, 'R', $this->_fill);		
		$this->Cell(33, 5, utf8_decode("Fantasia"),   'B', 0, 'L', $this->_fill);		
		$this->Cell(16, 5, utf8_decode("Vendedor"),   'B', 0, 'L', $this->_fill);
		
		$this->Ln();

	}
	
	public function imprimeLinhaNegocio()
	{
		
		$this->SetFillColor(240,240,240);
		$this->SetFont('Arial','',7);
		
		switch ($this->_negocio->codnegociostatus)
		{
			case NegocioStatus::ABERTO:
				$this->SetTextColor(0, 150, 0); // Verde
				break;
			
			case NegocioStatus::FECHADO:
				$this->SetTextColor(0, 0, 0);  // Preto
				break;
			
			case NegocioStatus::CANCELADO:
				$this->SetTextColor(255, 100, 0); // Vermelho
				break;
		}
		

		$this->_fill = ! $this->_fill;
		$this->Cell(11, 5, utf8_decode($this->_negocio->Filial->filial),   '', 0, 'L', $this->_fill);	
		$this->Cell(12, 5, utf8_decode($this->_negocio->Usuario->usuario),   '', 0, 'L', $this->_fill);	
		$this->Cell(9, 5, utf8_decode($this->_negocio->Operacao->operacao),   '', 0, 'L', $this->_fill);	
		$this->Cell(15, 5, utf8_decode(Yii::app()->format->formataCodigo(abs($this->_negocio->codnegocio))),   '', 0, 'L', $this->_fill);	
		$data = $this->_negocio->lancamento;
		$data = substr($data, 0, 6) . substr($data, 8, 2);
		$this->Cell(11, 5, utf8_decode($data),   '', 0, 'L', $this->_fill);	
		$this->Cell(18, 5, utf8_decode(Yii::app()->format->formatNumber(abs($this->_negocio->valoraprazo))), '', 0, 'R', $this->_fill);
		$this->Cell(18, 5, utf8_decode(Yii::app()->format->formatNumber(abs($this->_negocio->valoravista))), '', 0, 'R', $this->_fill);
		$this->Cell(18, 5, utf8_decode(Yii::app()->format->formatNumber(abs($this->_negocio->valortotal))), '', 0, 'R', $this->_fill);
		$this->Cell(15, 5, utf8_decode($this->_negocio->NegocioStatus->negociostatus),   '', 0, 'C', $this->_fill);	
		$this->Cell(14, 5, utf8_decode(Yii::app()->format->formataCodigo(abs($this->_negocio->codpessoa))),   '', 0, 'R', $this->_fill);	
		
		if (isset($this->_negocio->Pessoa))
			$this->Cell(33, 5, utf8_decode(substr($this->_negocio->Pessoa->fantasia, 0, 27)),   '', 0, 'L', $this->_fill);	
		else
			$this->Cell(33, 5, utf8_decode(""),   '', 0, 'L', $this->_fill);	
		
		if (isset($this->_negocio->PessoaVendedor))
			$this->Cell(16, 5, utf8_decode(substr($this->_negocio->PessoaVendedor->fantasia, 0, 12)),   '', 0, 'L', $this->_fill);
		else {
			$this->Cell(16, 5, utf8_decode(""),   '', 0, 'L', $this->_fill);

		}
		
		$this->Ln();
		
		if (!isset($this->_totais["valoravista"][$this->_negocio->codnegociostatus]))
			$this->_totais["valoravista"][$this->_negocio->codnegociostatus] = 0;
		
		if (!isset($this->_totais["valoraprazo"][$this->_negocio->codnegociostatus]))
			$this->_totais["valoraprazo"][$this->_negocio->codnegociostatus] = 0;
		
		if (!isset($this->_totais["valortotal"][$this->_negocio->codnegociostatus]))
			$this->_totais["valortotal"][$this->_negocio->codnegociostatus] = 0;
		
		$this->_totais["valoravista"][$this->_negocio->codnegociostatus] += $this->_negocio->valoravista;
		$this->_totais["valoraprazo"][$this->_negocio->codnegociostatus] += $this->_negocio->valoraprazo;
		$this->_totais["valortotal"][$this->_negocio->codnegociostatus] += $this->_negocio->valortotal;
		
		$this->_totais["valoravista"]["geral"] += $this->_negocio->valoravista;
		$this->_totais["valoraprazo"]["geral"] += $this->_negocio->valoraprazo;
		$this->_totais["valortotal"]["geral"] += $this->_negocio->valortotal;
		
	}

	public function imprimeTotais($codnegociostatus)
	{
		
		$this->SetFillColor(240,240,240);
		$this->SetFont('Arial','',8);
		
		$this->SetTextColor(0, 0, 0);
		
		$this->Cell("aqui");
		
		if ($codnegociostatus == "geral")
			$this->SetLineWidth (0.6);
		else
			$this->SetLineWidth (0.2);
			
		$this->SetFont('Arial','B',8);
		
		$this->SetTextColor(0, 0, 0);
		
			$this->Ln();
		if ($codnegociostatus == "geral")
		{
			$this->Ln();
			$this->Cell(56, 6, utf8_decode("Total Geral"),   'T', 0, 'R');
		}
		else
			$this->Cell(56, 6, utf8_decode("Total"),   'T', 0, 'R');
			
		$this->Cell(20, 6, utf8_decode(Yii::app()->format->formatNumber(abs($this->_totais["valoraprazo"][$codnegociostatus]))), 'T', 0, 'R');
		$this->Cell(18, 6, utf8_decode(Yii::app()->format->formatNumber(abs($this->_totais["valoravista"][$codnegociostatus]))), 'T', 0, 'R');
		$this->Cell(18, 6, utf8_decode(Yii::app()->format->formatNumber(abs($this->_totais["valortotal"][$codnegociostatus]))), 'T', 0, 'R');
		$this->Cell(78, 6, utf8_decode(""),   'T', 0, 'R');
		/*
		$this->Cell(16, 6, '',     'T', 0, 'C', false);
		$this->Cell(22, 6, utf8_decode(Yii::app()->format->formatNumber(abs($this->_totais["saldo"][$codnegociostatus]))), 'T', 0, 'R');
		$this->Cell(16, 6, utf8_decode(Yii::app()->format->formatNumber(abs($this->_totais["valorMulta"][$codnegociostatus]))), 'T', 0, 'R');
		$this->Cell(16, 6, utf8_decode(Yii::app()->format->formatNumber(abs($this->_totais["valorJuros"][$codnegociostatus]))), 'T', 0, 'R');
		$this->Cell(22, 6, utf8_decode(Yii::app()->format->formatNumber(abs($this->_totais["valorTotal"][$codnegociostatus]))), 'T', 0, 'R');
		$this->Cell(8, 6, utf8_decode(($this->_totais["valorTotal"][$codnegociostatus]<0)?"CR":"DB"), 'T', 0, 'C');
		 * 
		 */
		$this->Ln();
	
		
		
	}
	
	public function montaRelatorio()
	{
		$this->AddPage();

		$this->_totais["valoravista"]["geral"]  = 0;
		$this->_totais["valoraprazo"]["geral"] = 0;
		$this->_totais["valortotal"]["geral"]  = 0;

		$codnegociostatus = null;
		$linha = 0;

		foreach ($this->_negocios as $this->_negocio)
		{
			
			if ($codnegociostatus <> $this->_negocio->codnegociostatus)
			{
				if (!empty($codnegociostatus))
				{
					$this->imprimeTotais($codnegociostatus);
					$this->Ln();
				}
				$this->imprimeCabecalho();
			}
			
			$codnegociostatus = $this->_negocio->codnegociostatus;

			$this->imprimeLinhaNegocio();
			
		}
		
		if (!empty($codnegociostatus))
			$this->imprimeTotais($codnegociostatus);
		
		$this->imprimeTotais("geral");
		
		$this->AliasNbPages();
		
		
		
		//$this->Ln();
		//$this->_fill = ! $this->_fill;

	}

}
<?php

Yii::import('application.vendors.fpdf.*');

require_once('fpdf.php');
/**
 * This is the model class for table "mgsis.tblnotaprodutobarra".
 *
 * The followings are the available columns in table 'mgsis.tblnotaprodutobarra':
 * @property boolean $_fill
 * @property array $_totais
 *
 * The followings are the available model relations:
 * @property Nota[] $_notas
 * @property Nota $_nota
 */
class MGRelatorioNotasFiscais extends FPDF
{
	private $_nostasfiscais;
	private $_notafiscal;
	private $_fill = false;
	private $_totais = array();
	
	public function __construct($notasfiscais)
	{
		$this->_nostasfiscais = $notasfiscais;
		return parent::__construct("L");
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
		$this->Cell(10, 7, utf8_decode('Relatório de Notas Fiscais'));
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
		$this->Line(10, 193, 287, 193);
		// Page number
		$this->SetTextColor(100, 100, 100);
		$this->Cell(63,3, 'MGsis',"",0,'L');
		$this->Cell(64,3, utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
		$this->Cell(63,3, date('d/m/Y H:i:s'),"",0,'R');
	}	
	
	public function imprimeCabecalho()
	{
	
		/*
		
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

		*/

	}
	
	public function imprimeLinhaNota()
	{
		/*
		
		$this->SetFillColor(240,240,240);
		$this->SetFont('Arial','',7);
		
		switch ($this->_nota->codnotastatus)
		{
			case NotaStatus::ABERTO:
				$this->SetTextColor(0, 150, 0); // Verde
				break;
			
			case NotaStatus::FECHADO:
				$this->SetTextColor(0, 0, 0);  // Preto
				break;
			
			case NotaStatus::CANCELADO:
				$this->SetTextColor(255, 100, 0); // Vermelho
				break;
		}
		

		$this->_fill = ! $this->_fill;
		$this->Cell(11, 5, utf8_decode($this->_nota->Filial->filial),   '', 0, 'L', $this->_fill);	
		$this->Cell(12, 5, utf8_decode($this->_nota->Usuario->usuario),   '', 0, 'L', $this->_fill);	
		$this->Cell(9, 5, utf8_decode($this->_nota->Operacao->operacao),   '', 0, 'L', $this->_fill);	
		$this->Cell(15, 5, utf8_decode(Yii::app()->format->formataCodigo(abs($this->_nota->codnota))),   '', 0, 'L', $this->_fill);	
		$data = $this->_nota->lancamento;
		$data = substr($data, 0, 6) . substr($data, 8, 2);
		$this->Cell(11, 5, utf8_decode($data),   '', 0, 'L', $this->_fill);	
		$this->Cell(18, 5, utf8_decode(Yii::app()->format->formatNumber(abs($this->_nota->valoraprazo))), '', 0, 'R', $this->_fill);
		$this->Cell(18, 5, utf8_decode(Yii::app()->format->formatNumber(abs($this->_nota->valoravista))), '', 0, 'R', $this->_fill);
		$this->Cell(18, 5, utf8_decode(Yii::app()->format->formatNumber(abs($this->_nota->valortotal))), '', 0, 'R', $this->_fill);
		$this->Cell(15, 5, utf8_decode($this->_nota->NotaStatus->notastatus),   '', 0, 'C', $this->_fill);	
		$this->Cell(14, 5, utf8_decode(Yii::app()->format->formataCodigo(abs($this->_nota->codpessoa))),   '', 0, 'R', $this->_fill);	
		
		if (isset($this->_nota->Pessoa))
			$this->Cell(33, 5, utf8_decode(substr($this->_nota->Pessoa->fantasia, 0, 27)),   '', 0, 'L', $this->_fill);	
		else
			$this->Cell(33, 5, utf8_decode(""),   '', 0, 'L', $this->_fill);	
		
		if (isset($this->_nota->PessoaVendedor))
			$this->Cell(16, 5, utf8_decode(substr($this->_nota->PessoaVendedor->fantasia, 0, 12)),   '', 0, 'L', $this->_fill);
		else {
			$this->Cell(16, 5, utf8_decode(""),   '', 0, 'L', $this->_fill);

		}
		
		$this->Ln();
		
		if (!isset($this->_totais["valoravista"][$this->_nota->codnotastatus]))
			$this->_totais["valoravista"][$this->_nota->codnotastatus] = 0;
		
		if (!isset($this->_totais["valoraprazo"][$this->_nota->codnotastatus]))
			$this->_totais["valoraprazo"][$this->_nota->codnotastatus] = 0;
		
		if (!isset($this->_totais["valortotal"][$this->_nota->codnotastatus]))
			$this->_totais["valortotal"][$this->_nota->codnotastatus] = 0;
		
		$this->_totais["valoravista"][$this->_nota->codnotastatus] += $this->_nota->valoravista;
		$this->_totais["valoraprazo"][$this->_nota->codnotastatus] += $this->_nota->valoraprazo;
		$this->_totais["valortotal"][$this->_nota->codnotastatus] += $this->_nota->valortotal;
		
		$this->_totais["valoravista"]["geral"] += $this->_nota->valoravista;
		$this->_totais["valoraprazo"]["geral"] += $this->_nota->valoraprazo;
		$this->_totais["valortotal"]["geral"] += $this->_nota->valortotal;
		 * 
		 */
		
	}

	public function imprimeTotais($codnotastatus)
	{
		/*
		$this->SetFillColor(240,240,240);
		$this->SetFont('Arial','',8);
		
		$this->SetTextColor(0, 0, 0);
		
		$this->Cell("aqui");
		
		if ($codnotastatus == "geral")
			$this->SetLineWidth (0.6);
		else
			$this->SetLineWidth (0.2);
			
		$this->SetFont('Arial','B',8);
		
		$this->SetTextColor(0, 0, 0);
		
			$this->Ln();
		if ($codnotastatus == "geral")
		{
			$this->Ln();
			$this->Cell(56, 6, utf8_decode("Total Geral"),   'T', 0, 'R');
		}
		else
			$this->Cell(56, 6, utf8_decode("Total"),   'T', 0, 'R');
			
		$this->Cell(20, 6, utf8_decode(Yii::app()->format->formatNumber(abs($this->_totais["valoraprazo"][$codnotastatus]))), 'T', 0, 'R');
		$this->Cell(18, 6, utf8_decode(Yii::app()->format->formatNumber(abs($this->_totais["valoravista"][$codnotastatus]))), 'T', 0, 'R');
		$this->Cell(18, 6, utf8_decode(Yii::app()->format->formatNumber(abs($this->_totais["valortotal"][$codnotastatus]))), 'T', 0, 'R');
		$this->Cell(78, 6, utf8_decode(""),   'T', 0, 'R');
		
		$this->Cell(16, 6, '',     'T', 0, 'C', false);
		$this->Cell(22, 6, utf8_decode(Yii::app()->format->formatNumber(abs($this->_totais["saldo"][$codnotastatus]))), 'T', 0, 'R');
		$this->Cell(16, 6, utf8_decode(Yii::app()->format->formatNumber(abs($this->_totais["valorMulta"][$codnotastatus]))), 'T', 0, 'R');
		$this->Cell(16, 6, utf8_decode(Yii::app()->format->formatNumber(abs($this->_totais["valorJuros"][$codnotastatus]))), 'T', 0, 'R');
		$this->Cell(22, 6, utf8_decode(Yii::app()->format->formatNumber(abs($this->_totais["valorTotal"][$codnotastatus]))), 'T', 0, 'R');
		$this->Cell(8, 6, utf8_decode(($this->_totais["valorTotal"][$codnotastatus]<0)?"CR":"DB"), 'T', 0, 'C');
		 * 
		 */
		$this->Ln();
	
		
		
	}
	
	public function montaRelatorio()
	{
		/*
		$this->AddPage();

		$this->_totais["valoravista"]["geral"]  = 0;
		$this->_totais["valoraprazo"]["geral"] = 0;
		$this->_totais["valortotal"]["geral"]  = 0;

		$codnotastatus = null;
		$linha = 0;

		foreach ($this->_notas as $this->_nota)
		{
			
			if ($codnotastatus <> $this->_nota->codnotastatus)
			{
				if (!empty($codnotastatus))
				{
					$this->imprimeTotais($codnotastatus);
					$this->Ln();
				}
				$this->imprimeCabecalho();
			}
			
			$codnotastatus = $this->_nota->codnotastatus;

			$this->imprimeLinhaNota();
			
		}
		
		if (!empty($codnotastatus))
			$this->imprimeTotais($codnotastatus);
		
		$this->imprimeTotais("geral");
		
		$this->AliasNbPages();
		
		
		
		//$this->Ln();
		//$this->_fill = ! $this->_fill;

		*/
	}

}
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
 * @property NotaFiscal[] $_notas
 * @property NotaFiscal $_nota
 */
class MGRelatorioNotasFiscais extends FPDF
{
	private $_notas;
	private $_nota;
	private $_fill = false;
	private $_totais = array();
	
	public function __construct($notas)
	{
		$this->_notas = $notas;
		return parent::__construct("L");
	}
	
	// Page header
	function Header()
	{
		// Logo
		$this->SetLineWidth(0.6);
		$this->SetTextColor(0, 0, 0);
		$this->SetDrawColor(0,0,0);
		$this->Image(Yii::app()->basePath . '/../images/MGPapelaria.jpg', 249, 10, 38);
		$this->SetFont('Arial','B',20);
		$this->Cell(10, 7, utf8_decode('Relatório de Notas Fiscais'));
		$this->Line(10, 8, 287, 8);
		$this->Line(10, 19, 287, 19);
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
	
		$this->SetFillColor(240,240,240);
		$this->SetFont('Arial','B',6);
		
		$this->_fill = ! $this->_fill;
		$this->Cell(15, 5, utf8_decode(Yii::app()->format->formataCodigo(abs($this->_nota->codnotafiscal))), '', 0, 'L', $this->_fill);	
		$this->Cell(5, 5, utf8_decode($this->_nota->serie),   '', 0, 'L', $this->_fill);	
		$this->Cell(15, 5, utf8_decode(Yii::app()->format->formatNumber(abs($this->_nota->numero))), '', 0, 'R', $this->_fill);		

		$data = $this->_nota->emissao;
		$data = substr($data, 0, 6) . substr($data, 8, 2);
		$this->Cell(11, 5, utf8_decode($data),   '', 0, 'L', $this->_fill);
		
		$data = $this->_nota->saida;
		$data = substr($data, 0, 6) . substr($data, 8, 2);
		$this->Cell(11, 5, utf8_decode($data),   '', 0, 'L', $this->_fill);
		
		if ($this->_nota->Pessoa->fisica)
			$linha = "CPF....: ";
		else
			$linha = "CNPJ...: ";
		$this->Cell(25, 5, utf8_decode(Yii::app()->format->formataCnpjCpf($this->_nota->Pessoa->cnpj, $this->_nota->Pessoa->fisica)), '', 0, 'R', $this->_fill);
		
		//$this->Cell(20, 5, utf8_decode($this->_nota->Pessoa->fantasia),   '', 0, 'L', $this->_fill);	
	
		if (isset($this->_nota->Pessoa))
			$this->Cell(32, 5, utf8_decode(substr($this->_nota->Pessoa->fantasia, 0, 23)),   '', 0, 'L', $this->_fill);	
		else
			$this->Cell(32, 5, utf8_decode(""),   '', 0, 'L', $this->_fill);
		
		$this->Cell(15, 5, utf8_decode(substr($this->_nota->Pessoa->Cidade->cidade, 0, 10)),   '', 0, 'L', $this->_fill);	
		$this->Cell(6, 5, utf8_decode($this->_nota->Pessoa->Cidade->Estado->sigla),   '', 0, 'L', $this->_fill);	
		$this->Cell(13, 5, utf8_decode(Yii::app()->format->formatNumber(abs($this->_nota->valorprodutos))),   '', 0, 'R', $this->_fill);	
		$this->Cell(13, 5, utf8_decode(Yii::app()->format->formatNumber(abs($this->_nota->icmsvalor))),   '', 0, 'R', $this->_fill);	
		$this->Cell(13, 5, utf8_decode(Yii::app()->format->formatNumber(abs($this->_nota->ipivalor))),   '', 0, 'R', $this->_fill);	
		$this->Cell(13, 5, utf8_decode(Yii::app()->format->formatNumber(abs($this->_nota->icmsstvalor))),   '', 0, 'R', $this->_fill);	
		$this->Cell(13, 5, utf8_decode(Yii::app()->format->formatNumber(abs($this->_nota->valorfrete))),   '', 0, 'R', $this->_fill);	
		$this->Cell(13, 5, utf8_decode(Yii::app()->format->formatNumber(abs($this->_nota->valorseguro))),   '', 0, 'R', $this->_fill);	
		$this->Cell(13, 5, utf8_decode(Yii::app()->format->formatNumber(abs($this->_nota->valordesconto))),   '', 0, 'R', $this->_fill);	
		$this->Cell(15, 5, utf8_decode($this->_nota->valoroutras),   '', 0, 'L', $this->_fill);	
		$this->Cell(15, 5, utf8_decode($this->_nota->valortotal),   '', 0, 'L', $this->_fill);	
		
		$data = $this->_nota->nfedataautorizacao;
		$data = substr($data, 0, 6) . substr($data, 8, 2);
		$this->Cell(11, 5, utf8_decode($data),   '', 0, 'L', $this->_fill);

		
		$this->Ln();
	
		
	
	}

	public function imprimeTotais()
	{
		
		
		
	}
	
	public function montaRelatorio()
	{
		
		$this->AddPage();
		
		foreach ($this->_notas as $this->_nota)
		{
			$this->imprimeLinhaNota();
		}
		
		$this->AliasNbPages();
		
		
		
		//$this->Ln();
		//$this->_fill = ! $this->_fill;

	
	}

}
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
		$this->Cell(10,3, 'MGsis',"",0,'L');
		$this->Cell(260,3, utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
		$this->Cell(8,3, date('d/m/Y H:i:s'),"",0,'R');
	}	
	
	public function imprimeCabecalho()
	{
		$this->SetFont('Arial', 'B', 16);
		$this->Cell(277, 10, utf8_decode($this->_nota->Filial->filial . " > " . $this->_nota->NaturezaOperacao->naturezaoperacao),   '', 0, 'L');
		$this->SetFont('Arial', 'B', 6);
		$this->Ln();
		
		//Cabeçalho
		$this->SetFillColor(240,240,240);
		$this->SetFont('Arial','B',7);
		
		$this->SetTextColor(0, 0, 0);
		
		$this->Cell(15, 5, utf8_decode ("#"),		   'B', 0, 'C');		
		$this->Cell(5,  5, utf8_decode ("S"),		   'B', 0, 'L');		
		$this->Cell(11, 5, utf8_decode ("Número"),     'B', 0, 'R');		
		$this->Cell(11, 5, utf8_decode ("Emissão"),    'B', 0, 'L');		
		$this->Cell(11, 5, utf8_decode ("Saida"),      'B', 0, 'C');		
		$this->Cell(25, 5, utf8_decode ("Cpf/Cnpj"),   'B', 0, 'L');		
		$this->Cell(25, 5, utf8_decode ("Fantasia"),   'B', 0, 'L');		
		$this->Cell(11, 5, utf8_decode ("Cidade"),     'B', 0, 'L');		
		$this->Cell(6,  5, utf8_decode ("UF"),		   'B', 0, 'L');		
		$this->Cell(13, 5, utf8_decode ("Produtos"),   'B', 0, 'R');		
		$this->Cell(13, 5, utf8_decode ("Icms"),	   'B', 0, 'R');		
		$this->Cell(13, 5, utf8_decode ("Ipi"),		   'B', 0, 'R');		
		$this->Cell(13, 5, utf8_decode ("ST"),		   'B', 0, 'R');		
		$this->Cell(13, 5, utf8_decode ("Frete"),      'B', 0, 'R');		
		$this->Cell(13, 5, utf8_decode ("Seguro"),     'B', 0, 'R');		
		$this->Cell(13, 5, utf8_decode ("Desc"),	   'B', 0, 'R');		
		$this->Cell(13, 5, utf8_decode ("Outra"),      'B', 0, 'R');		
		$this->Cell(13, 5, utf8_decode ("Total"),      'B', 0, 'R');		
		$this->Cell(12, 5, utf8_decode ("Autoriz"),    'B', 0, 'L');		
		$this->Cell(12, 5, utf8_decode ("Cancel"),     'B', 0, 'L');		
		$this->Cell(12, 5, utf8_decode ("Inutil"),     'B', 0, 'L');		
		$this->Cell(4,  5, utf8_decode ("M"),		   'B', 0, 'L');		
		
		$this->Ln();
		$this->_fill = false;
		

	}
	
	public function imprimeLinhaNota()
	{
		//Estrutura	
		$this->SetFillColor(240,240,240);
		$this->SetFont('Arial','',7);

		switch ($this->_nota->codstatus)
		{
			case NotaFiscal::CODSTATUS_NAOAUTORIZADA:
				$this->SetTextColor(130, 130, 130); // Cinza
				break;
			
			case NotaFiscal::CODSTATUS_DIGITACAO:
				$this->SetTextColor(255, 100, 0); // Laranja
				break;
				
			case NotaFiscal::CODSTATUS_INUTILIZADA:
			case NotaFiscal::CODSTATUS_CANCELADA:
			case NotaFiscal::CODSTATUS_DIGITACAO:
				$this->SetTextColor(255, 0, 0); // Vermelho
				break;
			
			default:
				$this->SetTextColor(0, 0, 0);  // Preto
				break;
			
		}
		
		
		$this->_fill = ! $this->_fill;
		$this->Cell(15, 5, utf8_decode(Yii::app()->format->formataCodigo(abs($this->_nota->codnotafiscal))), '', 0, 'R', $this->_fill);	
		$this->Cell(5, 5, utf8_decode($this->_nota->serie),   '', 0, 'L', $this->_fill);	
		$this->Cell(11, 5, utf8_decode(Yii::app()->format->formatNumber(abs($this->_nota->numero), 0)), '', 0, 'R', $this->_fill);		

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
		$this->Cell(25, 5, utf8_decode(Yii::app()->format->formataCnpjCpf($this->_nota->Pessoa->cnpj, $this->_nota->Pessoa->fisica)), '', 0, 'L', $this->_fill);
			
		if (isset($this->_nota->Pessoa))
			$this->Cell(25, 5, utf8_decode(substr($this->_nota->Pessoa->fantasia, 0, 17)),   '', 0, 'L', $this->_fill);	
		else
			$this->Cell(25, 5, utf8_decode(""),   '', 0, 'L', $this->_fill);
		
		$this->Cell(11, 5, utf8_decode(substr($this->_nota->Pessoa->Cidade->cidade, 0, 7)),   '', 0, 'L', $this->_fill);	
		$this->Cell(6, 5,  utf8_decode($this->_nota->Pessoa->Cidade->Estado->sigla),   '', 0, 'L', $this->_fill);	
		$this->Cell(13, 5, utf8_decode(Yii::app()->format->formatNumber(abs($this->_nota->valorprodutos))),   '', 0, 'R', $this->_fill);	
		$this->Cell(13, 5, utf8_decode(Yii::app()->format->formatNumber(abs($this->_nota->icmsvalor))),   '', 0, 'R', $this->_fill);	
		$this->Cell(13, 5, utf8_decode(Yii::app()->format->formatNumber(abs($this->_nota->ipivalor))),   '', 0, 'R', $this->_fill);	
		$this->Cell(13, 5, utf8_decode(Yii::app()->format->formatNumber(abs($this->_nota->icmsstvalor))),   '', 0, 'R', $this->_fill);	
		$this->Cell(13, 5, utf8_decode(Yii::app()->format->formatNumber(abs($this->_nota->valorfrete))),   '', 0, 'R', $this->_fill);	
		$this->Cell(13, 5, utf8_decode(Yii::app()->format->formatNumber(abs($this->_nota->valorseguro))),   '', 0, 'R', $this->_fill);	
		$this->Cell(13, 5, utf8_decode(Yii::app()->format->formatNumber(abs($this->_nota->valordesconto))),   '', 0, 'R', $this->_fill);	
		$this->Cell(13, 5, utf8_decode(Yii::app()->format->formatNumber(abs($this->_nota->valoroutras))),   '', 0, 'R', $this->_fill);	
		$this->Cell(13, 5, utf8_decode(Yii::app()->format->formatNumber(abs($this->_nota->valortotal))),   '', 0, 'R', $this->_fill);	
		
		$data = $this->_nota->nfedataautorizacao;
		$data = substr($data, 0, 6) . substr($data, 8, 2);
		$this->Cell(12, 5, utf8_decode($data),   '', 0, 'L', $this->_fill);

		$data = $this->_nota->nfedatacancelamento;
		$data = substr($data, 0, 6) . substr($data, 8, 2);
		$this->Cell(12, 5, utf8_decode($data),   '', 0, 'L', $this->_fill);

		$data = $this->_nota->nfedatainutilizacao;
		$data = substr($data, 0, 6) . substr($data, 8, 2);
		$this->Cell(12, 5, utf8_decode($data),   '', 0, 'L', $this->_fill);

		//$this->Cell(4, 5,  utf8_decode($this->_nota->emitida)?"S":"N",   '', 0, 'L', $this->_fill);	
		$this->Cell(4, 5,  utf8_decode($this->_nota->modelo),   '', 0, 'L', $this->_fill);	

		$this->Ln();
		if (!isset($this->_totais[$this->_nota->codfilial][$this->_nota->codnaturezaoperacao][$this->_nota->status]))
		{
			$this->_totais[$this->_nota->codfilial][$this->_nota->codnaturezaoperacao][$this->_nota->status]["valorprodutos"] = 0;
			$this->_totais[$this->_nota->codfilial][$this->_nota->codnaturezaoperacao][$this->_nota->status]["icmsvalor"] = 0;
			$this->_totais[$this->_nota->codfilial][$this->_nota->codnaturezaoperacao][$this->_nota->status]["ipivalor"] = 0;
			$this->_totais[$this->_nota->codfilial][$this->_nota->codnaturezaoperacao][$this->_nota->status]["icmsstvalor"] = 0;
			$this->_totais[$this->_nota->codfilial][$this->_nota->codnaturezaoperacao][$this->_nota->status]["valorfrete"] = 0;
			$this->_totais[$this->_nota->codfilial][$this->_nota->codnaturezaoperacao][$this->_nota->status]["valorseguro"] = 0;
			$this->_totais[$this->_nota->codfilial][$this->_nota->codnaturezaoperacao][$this->_nota->status]["valordesconto"] = 0;
			$this->_totais[$this->_nota->codfilial][$this->_nota->codnaturezaoperacao][$this->_nota->status]["valoroutras"] = 0;
			$this->_totais[$this->_nota->codfilial][$this->_nota->codnaturezaoperacao][$this->_nota->status]["valortotal"] = 0;
		}
		
		$this->_totais[$this->_nota->codfilial][$this->_nota->codnaturezaoperacao][$this->_nota->status]["valorprodutos"] += $this->_nota->valorprodutos;
		$this->_totais[$this->_nota->codfilial][$this->_nota->codnaturezaoperacao][$this->_nota->status]["icmsvalor"] += $this->_nota->icmsvalor;
		$this->_totais[$this->_nota->codfilial][$this->_nota->codnaturezaoperacao][$this->_nota->status]["ipivalor"] += $this->_nota->ipivalor;
		$this->_totais[$this->_nota->codfilial][$this->_nota->codnaturezaoperacao][$this->_nota->status]["icmsstvalor"] += $this->_nota->icmsstvalor;
		$this->_totais[$this->_nota->codfilial][$this->_nota->codnaturezaoperacao][$this->_nota->status]["valorfrete"] += $this->_nota->valorfrete;
		$this->_totais[$this->_nota->codfilial][$this->_nota->codnaturezaoperacao][$this->_nota->status]["valorseguro"] += $this->_nota->valorseguro;
		$this->_totais[$this->_nota->codfilial][$this->_nota->codnaturezaoperacao][$this->_nota->status]["valordesconto"] += $this->_nota->valordesconto;
		$this->_totais[$this->_nota->codfilial][$this->_nota->codnaturezaoperacao][$this->_nota->status]["valoroutras"] += $this->_nota->valoroutras;
		$this->_totais[$this->_nota->codfilial][$this->_nota->codnaturezaoperacao][$this->_nota->status]["valortotal"] += $this->_nota->valortotal;
	}

	public function imprimeTotais($codfilial, $codnaturezaoperacao)
	{
		
		$this->SetFillColor(240,240,240);
		$this->SetFont('Arial', 'B', 7);
		
		$this->SetTextColor(0, 0, 0);

		foreach ($this->_totais[$codfilial][$codnaturezaoperacao] as $status => $total)
		{
			$this->Cell(120, 5, utf8_decode($status),   'T', 0, 'R');	
			$this->Cell(13, 5, utf8_decode(Yii::app()->format->formatNumber(abs($total["valorprodutos"]))), 'T', 0, 'R');	
			$this->Cell(13, 5, utf8_decode(Yii::app()->format->formatNumber(abs($total["icmsvalor"]))), 'T', 0, 'R');	
			$this->Cell(13, 5, utf8_decode(Yii::app()->format->formatNumber(abs($total["ipivalor"]))), 'T', 0, 'R');	
			$this->Cell(13, 5, utf8_decode(Yii::app()->format->formatNumber(abs($total["icmsstvalor"]))), 'T', 0, 'R');	
			$this->Cell(13, 5, utf8_decode(Yii::app()->format->formatNumber(abs($total["valorfrete"]))), 'T', 0, 'R');	
			$this->Cell(13, 5, utf8_decode(Yii::app()->format->formatNumber(abs($total["valorseguro"]))), 'T', 0, 'R');	
			$this->Cell(13, 5, utf8_decode(Yii::app()->format->formatNumber(abs($total["valordesconto"]))), 'T', 0, 'R');	
			$this->Cell(13, 5, utf8_decode(Yii::app()->format->formatNumber(abs($total["valoroutras"]))), 'T', 0, 'R');	
			$this->Cell(13, 5, utf8_decode(Yii::app()->format->formatNumber(abs($total["valortotal"]))), 'T', 0, 'R');	
			$this->Cell(40, 5, '', 'T', 0, 'R');	
			$this->Ln();
		}
		$this->Ln();
		
	}
	
	public function montaRelatorio()
	{
		
		$this->AddPage();
		
		$this->_totais["valorprodutos"]["geral"]  = 0;

		$codnaturezaoperacao = null;
		$codfilial = NULL;
		$linha = 0;

		foreach ($this->_notas as $this->_nota)
		{
			
			if ($codfilial != $this->_nota->codfilial || $codnaturezaoperacao != $this->_nota->codnaturezaoperacao)
			{
				if (!empty($codnaturezaoperacao))
				{
					$this->imprimeTotais($codfilial, $codnaturezaoperacao);
				}
				$this->imprimeCabecalho();
			}
			
			$codfilial = $this->_nota->codfilial;
			$codnaturezaoperacao = $this->_nota->codnaturezaoperacao;

			$this->imprimeLinhaNota();
			
		}

		$this->imprimeTotais($codfilial, $codnaturezaoperacao);
		
		
		$this->AliasNbPages();
		
		
		
		//$this->Ln();
		//$this->_fill = ! $this->_fill;

	
	}

}
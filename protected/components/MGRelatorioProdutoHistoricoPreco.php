<?php

Yii::import('application.vendors.fpdf.*');

require_once('fpdf.php');
/**
 * @property boolean $_fill
 * @property array $_totais
 *
 * @property ProdutoHistoricoPreco $_model
 */

class MGRelatorioProdutoHistoricoPreco extends FPDF
{
	private $_model;
	private $_fill = false;
	private $_totais = array();
	
	/**
	 * @param ProdutoHistoricoPreco $model
	 * @return boolean
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
		$this->Cell(10, 7, utf8_decode('Historico de Preços'));
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
		$this->Cell(14, 5, utf8_decode("#"),   'B', 0, 'C');
		$this->Cell(46, 5, utf8_decode("Produto"),   'B', 0, 'L');
		$this->Cell(15, 5, utf8_decode("UM"),  'B', 0, 'C');
		$this->Cell(20, 5, utf8_decode("Referência"), 'B', 0, 'L');
		$this->Cell(15, 5, utf8_decode("Marca"),     'B', 0, 'L');
		$this->Cell(15, 5, utf8_decode("Atual"),    'B', 0, 'R');
		$this->Cell(15, 5, utf8_decode("Novo"),    'B', 0, 'R');
		$this->Cell(15, 5, utf8_decode("Antigo"),    'B', 0, 'R');
		$this->Cell(15, 5, utf8_decode("Usuário"),    'B', 0, 'L');
		$this->Cell(0, 5, utf8_decode("Data"),    'B', 0, 'L');
		$this->Ln();
		$this->_fill = false;
		
		$total = 0;
	
		// linhas das liquidacoes
		foreach ($this->_model as $model)
		{
			$this->SetFillColor(240,240,240);
			$this->SetFont('Arial','',7);
			$this->SetTextColor(0, 0, 0);
			
			if (isset($model->ProdutoEmbalagem))
			{
				$precoatual = $model->ProdutoEmbalagem->preco;
				if (empty($precoatual))
					$precoatual = $model->ProdutoEmbalagem->preco_calculado;
				$um = $model->ProdutoEmbalagem->UnidadeMedida->sigla;
				$um .= ' C/';
				$um .= Yii::app()->format->formatNumber($model->ProdutoEmbalagem->quantidade, 0);
			}
			else
			{
				$precoatual = $model->Produto->preco;
				$um = $model->Produto->UnidadeMedida->sigla;
			}
			
			$this->Cell(14, 5, utf8_decode(Yii::app()->format->formataCodigo($model->codproduto, 6)),   '', 0, 'L', $this->_fill);
			$this->Cell(46, 5, utf8_decode(substr($model->Produto->produto, 0, 40)),   '', 0, 'L', $this->_fill);
			$this->Cell(15, 5, utf8_decode($um),   '', 0, 'C', $this->_fill);
			$this->Cell(20, 5, utf8_decode(substr($model->Produto->referencia, 0, 15)),   '', 0, 'L', $this->_fill);
			$this->Cell(15, 5, utf8_decode(isset($model->Produto->Marca)?$model->Produto->Marca->marca:''),   '', 0, 'L', $this->_fill);
			
			$this->SetFont('Arial','B',8);
			$this->SetTextColor(0, 150, 0);
			$this->Cell(15, 5, utf8_decode(Yii::app()->format->formatNumber($precoatual)),   '', 0, 'R', $this->_fill);
			
			$this->SetTextColor(0, 0, 0);
			$this->SetFont('Arial','',7);
			$this->SetTextColor(255, 100, 0);
			$this->Cell(15, 5, utf8_decode(Yii::app()->format->formatNumber($model->preconovo)),   '', 0, 'R', $this->_fill);
			
			$this->SetFont('Arial','',7);			
			$this->SetTextColor(255, 0, 0);
			$this->Cell(15, 5, utf8_decode(Yii::app()->format->formatNumber($model->precoantigo)),   '', 0, 'R', $this->_fill);
			$this->SetX(150);
			$this->Cell(15, 5,"---------------", '', 0, 'R', false);
            $this->SetX(165);
			
			$this->SetTextColor(0, 0, 0);
			$this->Cell(15, 5, utf8_decode($model->UsuarioAlteracao->usuario),   '', 0, 'L', $this->_fill);
			$this->Cell(0, 5, utf8_decode(substr($model->alteracao, 0, 16)),   '', 0, 'L', $this->_fill);
			
			
			
			
			
			
			
			
			
			
			
		

			
			
			
			
			/*
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
			*/
			$this->Ln();
			$this->_fill = ! $this->_fill;
			
		}
		// Alias total de paginas
		$this->AliasNbPages();
	}

}
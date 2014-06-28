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
		$this->Ln(10);
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
		$this->Cell(20, 3, utf8_decode("Filial:"));
		$this->Cell(128, 3, utf8_decode($negocio->Filial->filial));

		$this->Cell(24, 3, utf8_decode("Negócio:"));
		$this->Cell(18, 3, utf8_decode(Yii::app()->format->formataCodigo(abs($negocio->codnegocio))),   '', 0, 'L', $this->_fill);
		
		$this->Ln();
		$this->Cell(20, 5, utf8_decode("Vendedor:"));
		if (isset($negocio->PessoaVendedor))
			$vendedor=$negocio->PessoaVendedor->fantasia;
		else 
			$vendedor="";
		
		$this->Cell(128, 5, utf8_decode($vendedor));
		
		$this->Cell(24, 5, utf8_decode("Data:"));
		$this->Cell(16, 5, utf8_decode(substr($negocio->lancamento, 0, 10)),   '', 0, 'L', $this->_fill);
		$this->ln();
		
		//Divisoria
		$this->SetLineWidth(0.6);
		$this->Cell(190, 2, "", "T");
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
		$this->Cell(172, 3, utf8_decode($negocio->Pessoa->fantasia  . " - " . $telefones), null ,1);
		$this->ln();

		
		// codigo / cnpj / ie / razao social / Endereço
		$this->SetTextColor(100, 100, 100);
		$this->SetFont('Arial','',9);
		$this->Cell(18, 3, utf8_decode(($this->_model->Pessoa->fisica)?"CPF: ":"CNPJ: "));
		
		$this->SetTextColor(100, 100, 100);
		$this->SetFont('Arial','',9);
		$this->Cell(10, 3, 
			utf8_decode(
				//(($this->_model->Pessoa->fisica)?"CPF: ":"CNPJ: ") . 
				Yii::app()->format->formataCnpjCpf($this->_model->Pessoa->cnpj, $this->_model->Pessoa->fisica) .
				((!empty($this->_model->Pessoa->ie))?" - IE: " . Yii::app()->format->formataInscricaoEstadual($this->_model->Pessoa->ie, $this->_model->Pessoa->Cidade->Estado->sigla):"") .
				" - " . $this->_model->Pessoa->pessoa
			)
		);
		$this->ln();
		
		$this->Cell(18, 7, utf8_decode("Endereço:"));
		$this->Cell(18, 7, utf8_decode(
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
		//Divisoria
		$this->SetLineWidth(0.3);		
		$this->Cell(190, 1, "", "T");
		
		$this->ln();
		//Cabeça dos Produtos
		$this->SetTextColor(0, 0, 0);
		$this->SetFont('Arial','B',9);		
		$this->Cell(27, 3, utf8_decode ("Código"),	    '', 0, 'L', $this->_fill);
		$this->Cell(96, 3, utf8_decode ("Descrição"),  '', 0, 'L', $this->_fill);
		$this->Cell(13, 3, utf8_decode ("UM"),			'', 0, 'L', $this->_fill);
		$this->Cell(18, 3, utf8_decode ("Quantidade"),		'', 0, 'R', $this->_fill);
		$this->Cell(18, 3, utf8_decode ("Preço"),		'', 0, 'R', $this->_fill);
		$this->Cell(18, 3, utf8_decode ("Total"),		'', 0, 'R', $this->_fill);
		$this->ln();		
		//Divisoria
		$this->Cell(190, 1, "", "B");
		$this->ln();

		
		//Produtos
		$this->SetTextColor(100, 100, 100);
		$this->SetFont('Arial','',9);
		foreach ($negocio->NegocioProdutoBarras as $npb)
		{
			$this->Cell(27, 6, utf8_decode($npb->ProdutoBarra->barras));
			$this->SetTextColor(0, 0, 0);
			$this->Cell(96, 6, utf8_decode($npb->ProdutoBarra->descricao));
			$this->SetTextColor(100, 100, 100);
			$this->Cell(13, 6, utf8_decode($npb->ProdutoBarra->UnidadeMedida->sigla));
			$this->Cell(18, 6, (Yii::app()->format->formatNumber(abs($npb->quantidade))), '', 0, 'R', $this->_fill);
			$this->Cell(18, 6, (Yii::app()->format->formatNumber(abs($npb->valorunitario))), '', 0, 'R', $this->_fill);
			$this->SetTextColor(0, 0, 0);
			$this->Cell(18, 6, (Yii::app()->format->formatNumber(abs($npb->valortotal))), '', 0, 'R', $this->_fill);
			$this->SetTextColor(100, 100, 100);
			$this->ln();

		}
		//Divisoria
		$this->Cell(190, 1, "", "T");
		$this->ln();
				
		//Totais
		$this->SetFont('Arial','B',8);
		$this->Cell(32, 3, ("Subtotal:"));
		$this->Cell(42, 3, (Yii::app()->format->formatNumber($negocio->valorprodutos)));
		$this->Cell(32, 3, ("Desconto:"));
		$this->Cell(41, 3, (Yii::app()->format->formatNumber($negocio->valordesconto)));
		$this->SetTextColor(0, 0, 0);
		$this->SetFont('Arial','B',10);
		$this->Cell(31, 3, ("Total:"));
		$this->Cell(12, 3, (Yii::app()->format->formatNumber($negocio->valortotal)), '', 0, 'R', $this->_fill);
		$this->ln();

		//Divisoria
		$this->Cell(190, 1, "", "B");
		$this->ln();		
		$this->ln();	
		$this->ln();

		$this->SetTextColor(0, 0, 0);
		$this->SetFont('Arial','B',9);
		
		if (!empty($negocio->NegocioFormaPagamentos))
		{
			$this->Cell(157, 2, utf8_decode("Forma de Pagamento"));
			$this->SetTextColor(100, 100, 100);
			$this->SetFont('Arial','I',7);
			$this->Cell(30, 3, utf8_decode("Orçamento válido por 7 dias."));
			$this->SetTextColor(0, 0, 0);
			$this->SetFont('Arial','B',9);
			$this->ln();
			
		}
		
		foreach ($negocio->NegocioFormaPagamentos as $nfp)
		{
			$this->Cell(20, 6, utf8_decode(Yii::app()->format->formatNumber($nfp->valorpagamento)));
			$this->Cell(15, 6, utf8_decode($nfp->FormaPagamento->formapagamento));
			$this->ln();
		}
		
		//Observações
		if (!empty($negocio->observacoes))
		{
			$this->SetTextColor(100, 100, 100);
			$this->SetFont('Arial','I',9);
			$this->Cell(23, 6, utf8_decode("Observações:"));
			$this->Cell(18, 6, utf8_decode($negocio->observacoes));

		}
		$this->ln();
		$this->ln();
		$this->ln();
		$this->Cell(15, 4, utf8_decode("____________________________________________"));
		
		$this->SetTextColor(100, 100, 100);
		$this->SetFont('Arial','B',9);
		$this->ln();
		$this->Cell(18, 4, utf8_decode($negocio->Filial->Pessoa->pessoa));
		$this->ln();
		$this->Cell(10, 4, utf8_decode("Cnpj:"));	
		$this->Cell(18, 4, Yii::app()->format->formataCnpjCpf(utf8_decode($negocio->Filial->Pessoa->cnpj)));
		$this->ln();
		$this->Cell(10, 4, utf8_decode("Fone:"));	
		$this->Cell(18, 4, utf8_decode($negocio->Filial->Pessoa->telefone1));

		// numero de paginas do rodape
		$this->AliasNbPages();
		
	}

}
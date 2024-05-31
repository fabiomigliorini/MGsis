<?php

Yii::import('application.vendors.fpdf.*');

require_once('fpdf.php');

class MGRelatorioTitulos extends FPDF
{
    private $_titulos;
    private $_titulo;
    private $_detalhado = false;
    private $_totais = array();
    private $_linha = 1;

    public function __construct($titulos, $detalhado = false)
    {
        $this->_titulos = $titulos;
        $this->_detalhado = $detalhado;
        return parent::__construct();
    }

    // Page header
    public function Header()
    {
        // Logo
        $this->SetLineWidth(0.6);
        $this->SetTextColor(0, 0, 0);
        $this->SetDrawColor(0, 0, 0);
        $this->Image(Yii::app()->basePath . '/../images/MGPapelaria.jpg', 162, 10, 38);
        $this->SetFont('Arial', 'B', 20);
        $this->Cell(10, 7, utf8_decode('Relatório de Títulos'));
        $this->Line(10, 8, 200, 8);
        $this->Line(10, 19, 200, 19);
        $this->Ln(12);
    }

    // Page footer
    public function Footer()
    {
        $this->SetLineWidth(0.6);
        $this->SetDrawColor(0, 0, 0);
        // Position at 1.5 cm from bottom
        $this->SetY(-16);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 7);
        $this->Line(10, 280, 200, 280);
        // Page number
        $this->SetTextColor(100, 100, 100);
        $this->Cell(63, 3, 'MGsis', "", 0, 'L');
        $this->Cell(64, 3, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C');
        $this->Cell(63, 3, date('d/m/Y H:i:s'), "", 0, 'R');
    }

    public function imprimeCabecalhoPessoa()
    {
        $this->SetTextColor(100, 100, 100);
        $this->SetFont('Arial', '', 7);
        $this->SetLineWidth(0.6);
        $this->Cell(18, 8, utf8_decode(Yii::app()->format->formataCodigo($this->_titulo->codpessoa)), 'B');
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(172, 8, utf8_decode($this->_titulo->Pessoa->fantasia), 'B', 1);
        $this->SetLineWidth(0.2);

        $this->SetFont('Arial', 'B', 7);
        $this->Cell(12, 6, utf8_decode("Filial"), 'B', 0, 'L');
        $this->Cell(17, 6, utf8_decode("Portador"), 'B', 0, 'L');
        $this->Cell(6, 6, utf8_decode("BOL"), 'B', 0, 'L');
        $this->Cell(27, 6, utf8_decode("Título"), 'B', 0, 'L');
        $this->Cell(24, 6, utf8_decode("Fatura"), 'B', 0, 'L');
        $this->Cell(11, 6, utf8_decode("Emissão"), 'B', 0, 'C');
        $this->Cell(18, 6, utf8_decode("Original"), 'B', 0, 'R');
        $this->Cell(10, 6, utf8_decode("Venc"), 'B', 0, 'C');
        $this->Cell(18, 6, utf8_decode("Saldo"), 'B', 0, 'R');

        $this->Cell(12, 6, utf8_decode("Multa"), 'B', 0, 'R');
        $this->Cell(12, 6, utf8_decode("Juros"), 'B', 0, 'R');
        $this->Cell(18, 6, utf8_decode("Total"), 'B', 0, 'R');
        $this->Cell(5, 6, utf8_decode("OP"), 'B', 0, 'C');
        $this->Ln();
        $this->_linha = 1;

        $this->_totais["original"][$this->_titulo->codpessoa]   = 0;
        $this->_totais["saldo"][$this->_titulo->codpessoa]      = 0;
        $this->_totais["valorMulta"][$this->_titulo->codpessoa] = 0;
        $this->_totais["valorJuros"][$this->_titulo->codpessoa] = 0;
        $this->_totais["valorTotal"][$this->_titulo->codpessoa] = 0;
    }

    public function imprimeLinhaRegistro()
    {

        if (($this->_linha % 2) == 0) {
            $this->SetFillColor(235, 235, 235); // cinza
        } else {
            $this->SetFillColor(255, 255, 255); // branco
        }
        $this->SetFont('Arial', '', 7);

        // FILIAL
        if ($this->_titulo->gerencial) {
            $this->SetTextColor(255, 100, 0);
        } else {
            $this->SetTextColor(0, 150, 0);
        }
        $this->Cell(12, 5, utf8_decode($this->_titulo->Filial->filial), '', 0, 'L', true);

        // PORTADOR
        $portador = $this->_titulo->codportador ? $this->_titulo->Portador->portador : null;
        $this->Cell(17, 5, utf8_decode($portador), '', 0, 'L', true);

        // BOLETO
        $bol = $this->_titulo->boleto ? 'BOL' : null;
        $this->Cell(6, 5, utf8_decode($bol), '', 0, 'L', true);

        // NUMERO
        $this->SetTextColor(0, 0, 0);
        $this->Cell(27, 5, utf8_decode($this->_titulo->numero), '', 0, 'L', true);

        // FATURA
        $this->SetFont('Arial', '', 7);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(24, 5, utf8_decode($this->_titulo->fatura), '', 0, 'L', true);


        // EMISSAO
        $this->SetTextColor(0, 0, 0);
        $emiss = DateTime::createFromFormat('d/m/Y', $this->_titulo->emissao)->format('d/m/y');
        $this->Cell(11, 5, utf8_decode($emiss), '', 0, 'C', true);

        // VALOR ORIGINAL
        $this->Cell(18, 5, utf8_decode(Yii::app()->format->formatNumber(abs($this->_titulo->debito - $this->_titulo->credito))), '', 0, 'R', true);

        // VENCIMENTO
        $this->SetFont('Arial', 'B', 7);
        if ($this->_titulo->saldo == 0) {
            $this->SetTextColor(100, 100, 100);
        } elseif ($this->_titulo->Juros->diasAtraso > 0) {
            if ($this->_titulo->Juros->diasAtraso <= $this->_titulo->Juros->diasTolerancia) {
                $this->SetTextColor(255, 100, 0);
            } else {
                $this->SetTextColor(255, 0, 0);
            }
        } else {
            $this->SetTextColor(0, 150, 0);
        }
        $vcto = DateTime::createFromFormat('d/m/Y', $this->_titulo->vencimento)->format('d/m/y');
        $this->Cell(10, 5, utf8_decode($vcto), '', 0, 'C', true);

        // SALDO
        if ($this->_titulo->operacao == 'CR') {
            $this->SetTextColor(255, 100, 0);
        } else {
            $this->SetTextColor(0, 150, 0);
        }
        $this->SetFont('Arial', '', 7);
        $this->Cell(18, 5, utf8_decode(Yii::app()->format->formatNumber(abs($this->_titulo->saldo))), '', 0, 'R', true);

        // MULTA
        $this->Cell(12, 5, utf8_decode(Yii::app()->format->formatNumber(abs($this->_titulo->Juros->valorMulta))), '', 0, 'R', true);

        // JUROS
        $this->Cell(12, 5, utf8_decode(Yii::app()->format->formatNumber(abs($this->_titulo->Juros->valorJuros))), '', 0, 'R', true);

        // VALOR TOTAL
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(18, 5, utf8_decode(Yii::app()->format->formatNumber(abs($this->_titulo->Juros->valorTotal))), '', 0, 'R', true);

        // OPERACAO
        $this->SetFont('Arial', '', 7);
        $this->Cell(5, 5, utf8_decode($this->_titulo->operacao), '', 0, 'C', true);
        $this->Ln();

        if ($this->_detalhado) {


            // TIPO
            $this->SetFont('Arial', '', 6);
            $this->SetTextColor(0, 0, 0);
            $this->Cell(35, 3, utf8_decode($this->_titulo->TipoTitulo->tipotitulo), '', 0, 'L', true);

            // CONTA CONTABIL
            $this->SetFont('Arial', '', 6);
            $this->SetTextColor(0, 0, 0);
            $this->Cell(51, 3, utf8_decode($this->_titulo->ContaContabil->contacontabil), '', 0, 'L', true);
            // $this->MultiCell(63, 3, utf8_decode($this->_titulo->ContaContabil->contacontabil), 0, 'L', true);

            // OBSERVACOES
            $this->SetFont('Arial', '', 6);
            $this->SetTextColor(0, 0, 0);
            $this->MultiCell(104, 3, utf8_decode($this->_titulo->observacao), 0, 'L', true);
            // $this->MultiCell(104, 3, 'Teste', 1, 'L', true);

            // $this->Cell(76, 3, utf8_decode($this->_titulo->observacao), '', 0, 'L', true);
            // $this->Ln();
        }

        // troca cor de fundo
        $this->_linha ++ ;

        // ACUMULA TOTAIS
        $this->_totais["original"][$this->_titulo->codpessoa] += $this->_titulo->debito - $this->_titulo->credito;
        $this->_totais["saldo"][$this->_titulo->codpessoa] += $this->_titulo->saldo;
        $this->_totais["valorMulta"][$this->_titulo->codpessoa] += $this->_titulo->Juros->valorMulta;
        $this->_totais["valorJuros"][$this->_titulo->codpessoa] += $this->_titulo->Juros->valorJuros;
        $this->_totais["valorTotal"][$this->_titulo->codpessoa] += $this->_titulo->Juros->valorTotal;

        $this->_totais["original"]["geral"] += $this->_titulo->debito - $this->_titulo->credito;
        $this->_totais["saldo"]["geral"] += $this->_titulo->saldo;
        $this->_totais["valorMulta"]["geral"] += $this->_titulo->Juros->valorMulta;
        $this->_totais["valorJuros"]["geral"] += $this->_titulo->Juros->valorJuros;
        $this->_totais["valorTotal"]["geral"] += $this->_titulo->Juros->valorTotal;
    }

    public function imprimeTotais($codpessoa)
    {

        if ($codpessoa == "geral") {
            $this->SetLineWidth(0.6);
        } else {
            $this->SetLineWidth(0.2);
        }

        $this->SetFont('Arial', 'B', 7);

        $this->SetTextColor(0, 0, 0);

        if ($codpessoa == "geral") {
            $this->Ln();
            $this->Cell(97, 6, utf8_decode("Total Geral"), 'T', 0, 'R');
        } else {
            $this->Cell(97, 6, utf8_decode("Total"), 'T', 0, 'R');
        }

        $this->Cell(18, 6, utf8_decode(Yii::app()->format->formatNumber(abs($this->_totais["original"][$codpessoa]))), 'T', 0, 'R');
        $this->Cell(10, 6, '', 'T', 0, 'C', false);
        $this->Cell(18, 6, utf8_decode(Yii::app()->format->formatNumber(abs($this->_totais["saldo"][$codpessoa]))), 'T', 0, 'R');
        $this->Cell(12, 6, utf8_decode(Yii::app()->format->formatNumber(abs($this->_totais["valorMulta"][$codpessoa]))), 'T', 0, 'R');
        $this->Cell(12, 6, utf8_decode(Yii::app()->format->formatNumber(abs($this->_totais["valorJuros"][$codpessoa]))), 'T', 0, 'R');
        $this->Cell(18, 6, utf8_decode(Yii::app()->format->formatNumber(abs($this->_totais["valorTotal"][$codpessoa]))), 'T', 0, 'R');
        $this->Cell(5, 6, utf8_decode(($this->_totais["valorTotal"][$codpessoa] < 0) ? "CR" : "DB"), 'T', 0, 'C');
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
        $this->SetFont('Arial', '', 14);

        //$titulos = $this->_dataProvider->getData();

        $codpessoa = null;
        $linha = 0;

        foreach ($this->_titulos as $this->_titulo) {
            if ($codpessoa <> $this->_titulo->codpessoa) {
                if (!empty($codpessoa)) {
                    $this->imprimeTotais($codpessoa);
                    $this->Ln();
                }
                $this->imprimeCabecalhoPessoa();
            }

            $codpessoa = $this->_titulo->codpessoa;
            $this->imprimeLinhaRegistro();
        }

        if (!empty($codpessoa)) {
            $this->imprimeTotais($codpessoa);
        }

        $this->imprimeTotais("geral");

        $this->AliasNbPages();
    }
}

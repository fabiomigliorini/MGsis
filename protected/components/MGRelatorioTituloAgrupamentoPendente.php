<?php

Yii::import('application.vendors.fpdf.*');

require_once('fpdf.php');

class MGRelatorioTituloAgrupamentoPendente extends FPDF
{
    private $_titulos;
    private $_titulo;
    private $_fill = false;
    private $_totais = array();

    public function __construct($regs)
    {
        $this->_regs = $regs;
        return parent::__construct();
    }

    // Page header
    function Header()
    {
        // Logo
        $this->SetLineWidth(0.6);
        $this->SetTextColor(0, 0, 0);
        $this->SetDrawColor(0, 0, 0);
        $this->Image(Yii::app()->basePath . '/../images/MGPapelaria.jpg', 162, 10, 38);
        $this->SetFont('Arial', 'B', 20);
        $this->Cell(10, 7, utf8_decode('Relatório de Fechamentos Pendentes'));
        $this->Line(10, 8, 200, 8);
        $this->Line(10, 19, 200, 19);
        $this->Ln(12);
    }

    // Page footer
    function Footer()
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

    public function montaRelatorio()
    {

        $this->AddPage();

        // cabecalho
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(25, 5, utf8_decode("Grupo Econom"), 'B', 0, 'L');
        $this->Cell(25, 5, utf8_decode("Grupo Cliente"), 'B', 0, 'L');
        $this->Cell(17, 5, utf8_decode("#"), 'B', 0, 'C');
        $this->Cell(58, 5, utf8_decode("Fantasia"), 'B', 0, 'L');
        $this->Cell(13, 5, utf8_decode("Vencimento"), 'B', 0, 'C');
        $this->Cell(20, 5, utf8_decode("Saldo"), 'B', 0, 'R');
        $this->Cell(32, 5, utf8_decode("Forma Padrão"), 'B', 0, 'L');
        $this->Ln();
        $this->_fill = false;

        $total = 0;

        // linhas das liquidacoes
        foreach ($this->_regs as $reg) {
            $this->SetFillColor(240, 240, 240);
            $this->SetFont('Arial', '', 8);
            $this->SetTextColor(0, 0, 0);
            $this->Cell(25, 5, utf8_decode(substr($reg['grupocliente'], 0, 15)), '', 0, 'L', $this->_fill);
            $this->Cell(25, 5, utf8_decode(substr($reg['grupoeconomico'], 0, 15)), '', 0, 'L', $this->_fill);
            $this->Cell(17, 5, utf8_decode(Yii::app()->format->formataCodigo($reg['codpessoa'])), '', 0, 'C', $this->_fill);
            $this->Cell(58, 5, utf8_decode(substr($reg['fantasia'], 0, 30)), '', 0, 'L', $this->_fill);
            $this->Cell(13, 5, utf8_decode(DateTime::createFromFormat('Y-m-d', $reg['vencimento'])->format('d/m/y')), '', 0, 'C', $this->_fill);
            $this->Cell(20, 5, utf8_decode(Yii::app()->format->formatNumber($reg['saldo'])), '', 0, 'R', $this->_fill);
            $this->Cell(32, 5, utf8_decode(substr($reg['formapagamento'], 0, 25)), '', 0, 'L', $this->_fill);
            $total += $reg['saldo'];
            $this->Ln();
            $this->_fill = ! $this->_fill;
        }

        // Totais
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(138, 6, utf8_decode("Total"), 'T', 0, 'R');
        $this->Cell(20, 6, utf8_decode(Yii::app()->format->formatNumber(abs($total))), 'T', 0, 'R', false);
        $this->Cell(32, 6, '', 'T', 0, 'R', false);
        $this->Ln();

        // Alias total de paginas
        $this->AliasNbPages();
    }
}

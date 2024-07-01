<?php

Yii::import('application.vendors.fpdf.*');

require_once('fpdf.php');

class MGRelatorioTituloAgrupamento extends FPDF
{
    private $_model;
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
        $this->SetDrawColor(0, 0, 0);
        $this->Image(Yii::app()->basePath . '/../images/MGPapelaria.jpg', 162, 10, 38);
        $this->SetFont('Arial', 'B', 20);
        $this->Cell(10, 7, utf8_decode('Relatório de Fechamento'));
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

        $titulos = $this->_model->Titulos;

        $telefones = array();
        if (!empty($this->_model->Pessoa->telefone1))
            $telefones[] = $this->_model->Pessoa->telefone1;
        if (!empty($this->_model->Pessoa->telefone2))
            $telefones[] = $this->_model->Pessoa->telefone2;
        if (!empty($this->_model->Pessoa->telefone3))
            $telefones[] = $this->_model->Pessoa->telefone3;
        $telefones = implode(" / ", $telefones);

        // fantasia cliente
        $this->SetTextColor(100, 100, 100);
        $this->SetFont('Arial', '', 8);
        $this->Cell(18, 6, utf8_decode("Cliente:"));
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(172, 6, utf8_decode($this->_model->Pessoa->fantasia  . " - " . $telefones), null, 1);

        // codigo / cnpj / ie / razao social
        $this->SetTextColor(100, 100, 100);
        $this->SetFont('Arial', '', 8);
        $this->Cell(18, 4, '');
        $this->Cell(
            172,
            4,
            utf8_decode(
                Yii::app()->format->formataCodigo($this->_model->codpessoa) . " - " .
                    (($this->_model->Pessoa->fisica) ? "CPF: " : "CNPJ: ") .
                    Yii::app()->format->formataCnpjCpf($this->_model->Pessoa->cnpj, $this->_model->Pessoa->fisica) .
                    ((!empty($this->_model->Pessoa->ie)) ? " - IE: " . Yii::app()->format->formataInscricaoEstadual($this->_model->Pessoa->ie, $this->_model->Pessoa->Cidade->Estado->sigla) : "") .
                    " - " . $this->_model->Pessoa->pessoa
            )
        );
        $this->ln();

        // filial
        $this->Cell(18, 8, utf8_decode("Filial:"));
        $this->Cell(
            172,
            8,
            utf8_decode(
                $titulos[0]->Filial->Pessoa->fantasia . " (" .
                    $titulos[0]->Filial->Pessoa->pessoa . " - " .
                    Yii::app()->format->formataCnpjCpf($titulos[0]->Filial->Pessoa->cnpj, $titulos[0]->Filial->Pessoa->fisica) . ") - " .
                    $titulos[0]->Filial->Pessoa->telefone1
            )
        );
        $this->ln();

        // linha divisoria entre cabecalho e vencimentos
        $this->SetLineWidth(0.6);
        $this->Cell(190, 4, "", "T");
        $this->ln();


        // Label Vencimentos do fechamento
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(190, 10, utf8_decode("Vencimento(s) do Fechamento:"));
        $this->ln();

        // cabecalho Titulos
        $this->SetLineWidth(0.2);
        $this->SetFont('Arial', '', 8);
        $this->Cell(25, 6, utf8_decode("Número"), "B");
        $this->Cell(20, 6, utf8_decode("Emissão"), "B", 0, 'C');
        $this->Cell(20, 6, utf8_decode("Vencimento"), "B", 'C');
        $this->Cell(22, 6, utf8_decode("Valor"), "B", 0, 'R');
        $this->Cell(5, 6, null, "B", 0, 'C');
        $this->Cell(38, 6, utf8_decode("Boleto"), "B", 0, "L");
        $this->Cell(30, 6, utf8_decode("Agendado Para"), "B", 0, "C");
        $this->Cell(30, 6, utf8_decode("Pago em"), "B", 0, "C");
        $this->ln();

        // linhas dos títulos
        $this->SetFillColor(240, 240, 240);
        $this->_fill = false;
        foreach ($titulos as $titulo) {
            $this->Cell(25, 10, utf8_decode($titulo->numero), null, 0, 'L', $this->_fill);
            $this->Cell(20, 10, utf8_decode($titulo->emissao), null, 0, 'C', $this->_fill);
            $this->Cell(20, 10, utf8_decode($titulo->vencimento), null, 0, 'C', $this->_fill);
            $this->Cell(22, 10, utf8_decode(Yii::app()->format->formatNumber(abs($titulo->valor))), null, 0, 'R', $this->_fill);
            $this->Cell(5, 10, utf8_decode($titulo->operacao), null, 0, 'R', $this->_fill);
            $this->Cell(
                38,
                10,
                utf8_decode(
                    (($titulo->boleto) ? $titulo->Portador->portador . " - " . $titulo->nossonumero : "Não")
                ),
                null,
                0,
                'L',
                $this->_fill
            );
            $this->Cell(30, 10, "______/_____/_____", null, 0, 'C', $this->_fill);
            $this->Cell(30, 10, "______/_____/_____", null, 0, 'C', $this->_fill);
            $this->ln();
            $this->_fill = !$this->_fill;
        }

        // linha divisoria entre Titulos e Movimentos
        $this->SetLineWidth(0.6);
        $this->Cell(190, 4);
        $this->ln();


        // Label Vencimentos do fechamento
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(190, 10, utf8_decode("Em substituição ao(s) seguinte(s) título(s):"));
        $this->ln();

        // cabecalho Movimentos
        $this->SetLineWidth(0.2);
        $this->SetFont('Arial', '', 8);
        $this->Cell(20, 6, utf8_decode("Filial"), "B");
        $this->Cell(25, 6, utf8_decode("Número"), "B");
        $this->Cell(20, 6, utf8_decode("Emissão"), "B", 0, 'C');
        $this->Cell(20, 6, utf8_decode("Vencimento"), "B", 'C');
        $this->Cell(22, 6, utf8_decode("Valor"), "B", 0, 'R');
        $this->Cell(5, 6, null, "B", 0, 'C');
        $this->ln();

        // linhas dos movimentos
        $this->SetFillColor(240, 240, 240);
        $this->_fill = false;
        foreach ($this->_model->MovimentoTitulos as $mov) {
            if ($mov->codtipomovimentotitulo != TipoMovimentoTitulo::TIPO_AGRUPAMENTO)
                continue;

            $titulo = $mov->Titulo;

            $this->Cell(20, 6, utf8_decode($titulo->Filial->filial), null, 0, 'L', $this->_fill);
            $this->Cell(25, 6, utf8_decode($titulo->numero), null, 0, 'L', $this->_fill);
            $this->Cell(20, 6, utf8_decode($titulo->emissao), null, 0, 'C', $this->_fill);
            $this->Cell(20, 6, utf8_decode($titulo->vencimento), null, 0, 'C', $this->_fill);
            $this->Cell(22, 6, utf8_decode(Yii::app()->format->formatNumber(abs($mov->valor))), null, 0, 'R', $this->_fill);
            $this->Cell(5, 6, utf8_decode(($mov->operacao == "CR") ? "DB" : "CR"), null, 0, 'R', $this->_fill);

            $this->ln();
            $this->_fill = !$this->_fill;
        }
        $this->ln();

        // linha divisoria entre cabecalho e vencimentos
        $this->SetLineWidth(0.6);
        $this->Cell(190, 4, "", "T");
        $this->ln();

        // declaracao de divida
        $this->SetFont('Arial', '', 10);
        $this->MultiCell(
            190,
            5,
            utf8_decode(
                "Declaro(amos) ter conferido o(s) título(s) acima listado(s), que reconheço(emos) a exatidão da dívida de R$ " .
                    Yii::app()->format->formatNumber($this->_model->valor) . " (" .
                    MGFormatter::formataValorPorExtenso($this->_model->valor, true) .
                    ") expressa neste relatório e que pagarei(emos) a importância à " .
                    $titulos[0]->Filial->Pessoa->pessoa .
                    ", ou a sua ordem, no(s) vencimento(s) e/ou nos agendamento(s) acima indicado(s)."
            )
        );

        $this->ln();
        $this->MultiCell(
            190,
            5,
            utf8_decode(
                "Assinale abaixo os numeros de WhatsApp e E-Mails que você deseja receber os documentos de fechamento:"
            )
        );
        $this->ln();

        $contatos = [];

        $tels = $this->_model->Pessoa->PessoaTelefones;
        foreach ($tels as $i => $tel) {
            if ($tel->tipo == 1) {
                $fmt = str_pad($tel->telefone, 8, ' ', STR_PAD_LEFT);
                $fmt = substr($fmt, 0, 4) . '-' . substr($fmt, 4);
            } else {
                $fmt = str_pad($tel->telefone, 9, ' ', STR_PAD_LEFT);
                $fmt = substr($fmt, 0, 1) . '-' . substr($fmt, 1, 4) . '-' . substr($fmt, 5);

            }
            $contatos[$i]['tel'] = "+{$tel->pais} ($tel->ddd) $fmt";
            # code...
        }

        $mails = $this->_model->Pessoa->PessoaEmails;
        foreach ($mails as $i => $mail) {
            $contatos[$i]['email'] = $mail->email;
            # code...
        }

        $this->SetFont('Arial', '', 10);
        foreach ($contatos as $i => $contato) {
            if (isset($contato['email'])) {
                $this->Cell(95, 8, "(    )   {$contato['email']}", null, null, "L");
            } else {
                $this->Cell(95, 8, "(    )   _________________________________________", null, null, "L");
            }
            if (isset($contato['tel'])) {
                $this->Cell(95, 8, "(    ) {$contato['tel']}", null, null, "L");
            } else {
                $this->Cell(95, 8, "(    )   _________________________________________", null, null, "L");
            }
            $this->ln();
        }
        $this->Cell(95, 8, "(    )   _________________________________________", null, null, "L");
        $this->Cell(95, 8, "(    )   _________________________________________", null, null, "L");


        // local e data para preenchimento
        $this->ln();
        $this->ln();
        $this->Cell(190, 4, "________________________,____ de _________________ de ______.", null, null, "R");
        $this->ln();
        $this->ln();
        $this->ln();
        $this->ln();
        $this->Cell(75, 4, "");
        $this->Cell(115, 4, "__________________________________________________________", null, null, "C");

        // Razao Social
        $this->ln();
        $this->Cell(75, 6, "");
        $this->Cell(115, 6, utf8_decode($this->_model->Pessoa->pessoa), null, null, "C");

        // CNPJ
        $this->ln();
        $this->Cell(75, 4, "");
        $this->Cell(
            115,
            4,
            utf8_decode(
                (($this->_model->Pessoa->fisica) ? "CPF: " : "CNPJ: ") .
                    Yii::app()->format->formataCnpjCpf($this->_model->Pessoa->cnpj, $this->_model->Pessoa->fisica)
            ),
            null,
            null,
            "C"
        );


        // numero de paginas do rodape
        $this->AliasNbPages();
    }
}

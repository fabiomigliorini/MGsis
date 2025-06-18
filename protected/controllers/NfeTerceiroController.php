<?php

class NfeTerceiroController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if (!$model->podeEditar())
            throw new CHttpException(409, 'Registro não permite edição.');

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['NfeTerceiro'])) {
            $model->attributes = $_POST['NfeTerceiro'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->codnfeterceiro));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {

        $model = new NfeTerceiro;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['NfeTerceiro'])) {
            $model->attributes = $_POST['NfeTerceiro'];
            $model->emitente = 'Nao Identificado';
            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->codnfeterceiro));
            }
        }

        $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionImportar($id)
    {
        $model = $this->loadModel($id);

        if ($model->importar()) {
            Yii::app()->user->setFlash("success", "NFe de Terceiro Importada com sucesso!");
            $this->redirect(array('view', 'id' => $model->codnfeterceiro));
            // $this->redirect(array('index'));
        } else {
            $erros = $model->getErrors();

            $msgs = array("Erro(s) ao Importar:");

            foreach ($erros as $campo => $mensagens)
                foreach ($mensagens as $msg)
                    $msgs[] = "[$campo] => $msg";

            $msgs = implode("<BR>", $msgs);

            Yii::app()->user->setFlash("error", $msgs);
            $this->redirect(array('view', 'id' => $model->codnfeterceiro));
        }
    }

    public function actionRevisao($id)
    {
        $model = $this->loadModel($id);
        if ($_GET['revisada'] == 'true') {
            $model->revisao = date('d/m/Y H:i:s');
            $model->codusuariorevisao = Yii::app()->user->id;
        } else {
            $model->revisao = null;
            $model->codusuariorevisao = null;
        }
        $model->save();
        header('Content-type: application/json');
        echo CJSON::encode([
            'codnfeterceiro' => $model->codnfeterceiro,
            'revisao' => $model->revisao,
            'codusuariorevisao' => $model->codusuariorevisao,
        ]);
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $model = new NfeTerceiro('search');

        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['NfeTerceiro']))
            Yii::app()->session['FiltroNfeTerceiroIndex'] = $_GET['NfeTerceiro'];

        if (isset(Yii::app()->session['FiltroNfeTerceiroIndex']))
            $model->attributes = Yii::app()->session['FiltroNfeTerceiroIndex'];
        else {
            //$model->indsituacao = NfeTerceiro::INDSITUACAO_AUTORIZADA;
            $model->codnotafiscal = 1;
        }

        $this->render('index', array(
            'dataProvider' => $model->search(),
            'model' => $model,
        ));
    }

    public function actionUpload()
    {
        /**
         * @var NfeTerceiro
         */
        $model = new NfeTerceiro;

        $this->render(
            'upload',
            array(
                'model' => $model,
            )
        );
    }

    /**
     * Efetua Download de uma NFE e Carrega os dados na tabela do sistema
     * @param bigint $id
     * @throws CHttpException
     */
    public function actionDownloadNfe($id)
    {
        /**
         * @var NfeTerceiro Description
         */
        //$model = $this->loadModel($id);
        $model = NfeTerceiro::model()->findByPk($id);
        $acbr = new MGAcbrNfeMonitor(null, $model);

        $res = $acbr->downloadNfe();

        echo CJSON::encode(
            array(
                'id' => $id,
                'resultado' => $res,
                'retornoMonitor' => $acbr->retornoMonitor["Mensagem"],
                'erroMonitor' => htmlentities($acbr->erroMonitor),
                'retorno' => htmlentities($acbr->retorno),
            )
        );
    }

    public function actionEnviarEventoManifestacao($id, $indManifestacao, $justificativa = "")
    {
        $model = $this->loadModel($id);
        $acbr = new MGAcbrNfeMonitor(null, $model);

        $res = $acbr->enviarEventoManifestacao($indManifestacao, $justificativa);

        echo CJSON::encode(
            array(
                'id' => $id,
                'resultado' => $res,
                'retornoMonitor' => $acbr->retornoMonitor["Mensagem"],
                'erroMonitor' => htmlentities($acbr->erroMonitor),
                'retorno' => htmlentities($acbr->retorno),
            )
        );
    }

    public function actionIcmsst($id)
    {
        $model = $this->loadModel($id);
        $sql = "
            with final as (
                with itens as (
                    select
                        nti.codnfeterceiroitem,
                        nti.nitem,
                        nti.cprod,
                        nti.xprod,
                        --nti.cean,
                        nti.ncm as ncmnota,
                        n.ncm as ncmproduto,
                        nti.cest as cestnota,
                        c.cest as cestproduto,
                        round(1 + (c.mva / 100), 4) as mva,
                        coalesce(vprod, 0) + coalesce(vfrete, 0) + coalesce(vseg, 0) + coalesce(voutro, 0) + coalesce(ipivipi, 0) - coalesce(vdesc, 0) as valor,
                        case when coalesce(n.bit, false) then
                            0.4117
                        else
                            1.0
                        end as reducao,
                        case when coalesce(picms, 0) > 7 then
                            (coalesce(vprod, 0) + coalesce(vfrete, 0) + coalesce(vseg, 0) + coalesce(voutro, 0) - coalesce(vdesc, 0)) * 0.07
                        else
                            case when coalesce(vicms, 0) = 0 then
                                case when p.importado then
                                    (coalesce(vprod, 0) + coalesce(vfrete, 0) + coalesce(vseg, 0) + coalesce(voutro, 0) - coalesce(vdesc, 0)) * 0.04
                                else
                                    (coalesce(vprod, 0) + coalesce(vfrete, 0) + coalesce(vseg, 0) + coalesce(voutro, 0) - coalesce(vdesc, 0)) * 0.07
                                end
                            else
                                coalesce(vicms, 0)
                            end
                        end as vicms,
                        vicmsst
                    from tblnfeterceiroitem nti
                    left join tblprodutobarra pb on (pb.codprodutobarra = nti.codprodutobarra)
                    left join tblproduto p on (p.codproduto = pb.codproduto)
                    left join tblncm n on (n.codncm = p.codncm)
                    left join tblcest c on (c.codcest = p.codcest)
                    where nti.codnfeterceiro = {$model->codnfeterceiro}
                    order by nti.ncm, nti.xprod
                )
                select *, round((valor * reducao * mva * 0.17) - (vicms * reducao), 2) as vicmsstcalculado from itens
            )
            select
                *,
                coalesce(vicmsstcalculado, 0) - coalesce(vicmsst, 0) as diferenca
            from final
        ";

        $command = Yii::app()->db->createCommand($sql);
        $itens = $command->queryAll();
        $this->render('icmsst', [
            'model' => $model,
            'itens' => $itens,
        ]);
    }


    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model = NfeTerceiro::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'nfe-terceiro-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionGerarGuiaSt($id, $valor, $vencimento)
    {

        // Validacao Valor
        $valor = floatval($valor);
        if ($valor <= 0.01) {
            throw new \Exception("Valor Não Informado!", 1);
        }

        // Carrega NFE Terceiro
        $model = $this->loadModel($id);

        // Variaveis para Requisicao
        //$periodoReferencia = DateTime::createFromFormat('d/m/Y H:i:s', $model->emissao)->format("m/Y");
        $periodoReferencia = date("m/Y");
        $numrDocumentoDestinatario = $model->Filial->Pessoa->ie;
        $numrNota1 = $model->nfechave;
        $numrInscEstadual = $model->Filial->Pessoa->ie;
        $numrDocumento = $model->Filial->Pessoa->cnpj;
        $valorFormatado = number_format($valor, 2, ",", ".");

        // CNAE
        $arrCodgCnae = [
            101 => '4761003',
            //102 => '',
            103 => '4761003',
            //104 => '',
            105 => '4751201'
        ];
        if (!isset($arrCodgCnae[$model->codfilial])) {
            throw new \Exception("Impossível determinar Cnae!", 1);
        }
        $codgCnae = $arrCodgCnae[$model->codfilial];

        // Numero do numrPessoaDestinatario
        // Um Por IE
        $arrNumrPessoaDestinatario = [
            101 => '611107',
            103 => '126206917',
            105 => '128413022',
        ];
        if (!isset($arrNumrPessoaDestinatario[$model->codfilial])) {
            throw new \Exception("Impossível determinar Número da pessoa Destinatario!", 1);
        }
        $numrPessoaDestinatario = $arrNumrPessoaDestinatario[$model->codfilial];

        // Numero do numrContribuinte
        $arrNumrContribuinte = [
            101 => '611107', // Com IE
            103 => '126206917',
            //101 => '4432657', (Sem IE)
            105 => '128413022'
        ];
        if (!isset($arrNumrContribuinte[$model->codfilial])) {
            throw new \Exception("Impossível determinar Número do Contribuinte!", 1);
        }
        $numrContribuinte = $arrNumrContribuinte[$model->codfilial];

        // Requisicao CURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.sefaz.mt.gov.br/arrecadacao/darlivre/pj/gerardar");

        // Ignorar Certificado Vencido
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, true);
        $data = [
            'periodoReferencia' => $periodoReferencia,
            'tipoVenda' => '2',
            'tributo' => '2817',
            'cnpjBeneficiario' => '',
            'numrDuimp' => '',
            'numrDocumentoDestinatario' => $numrDocumentoDestinatario,
            'txtCaminhoArquivo' => '(binary)',
            'isNFE1' => 'on',
            'numrNota1' => $numrNota1,
            'isNFE2' => 'on',
            'numrNota2' => '',
            'isNFE3' => 'on',
            'numrNota3' => '',
            'isNFE4' => 'on',
            'numrNota4' => '',
            'isNFE5' => 'on',
            'numrNota5' => '',
            'isNFE6' => 'on',
            'numrNota6' => '',
            'isNFE7' => 'on',
            'numrNota7' => '',
            'isNFE8' => 'on',
            'numrNota8' => '',
            'isNFE9' => 'on',
            'numrNota9' => '',
            'isNFE10' => 'on',
            'numrNota10' => '',
            'numrPessoaDestinatario' => $numrPessoaDestinatario,
            'statInscricaoEstadual' => 'Ativo',
            'notas' => '1',
            'nfeNota1' => '',
            'nfeNota2' => '',
            'nfeNota3' => '',
            'nfeNota4' => '',
            'nfeNota5' => '',
            'nfeNota6' => '',
            'nfeNota7' => '',
            'nfeNota8' => '',
            'nfeNota9' => '',
            'nfeNota10' => '',
            'numrParcela' => '',
            'totalParcela' => '',
            'numrNai' => '',
            'numrTad' => '',
            'multaCovid' => '',
            'numeroNob' => '',
            'codgConvDesc' => '',
            'dataVencimento' => $vencimento,
            'qtd' => '',
            'qtdUnMedida' => '',
            'valorUnitario' => '',
            'valorCampo' => $valorFormatado,
            'valorCorrecao' => '',
            'diasAtraso' => '',
            'juros' => '',
            'tipoDocumento' => '2',
            'nota1' => '',
            'nota2' => '',
            'nota3' => '',
            'nota4' => '',
            'nota5' => '',
            'nota6' => '',
            'nota7' => '',
            'nota8' => '',
            'nota9' => '',
            'nota10' => '',
            'informacaoPrevista' => '',
            'informacaoPrevista2' => '',
            'municipio' => '255009',
            'numrContribuinte' => $numrContribuinte,
            'pagn' => 'emitir',
            'numrDocumento' => $numrDocumento,
            'numrInscEstadual' => $numrInscEstadual,
            //'numrInscEstadual' => '0',
            'tipoContribuinte' => '1',
            //'tipoContribuinte' => '2',
            'codgCnae' => $codgCnae,
            //'codgCnae' => '',
            'tipoTributoH' => '',
            'codgOrgao' => '',
            'valor' => $valorFormatado,
            'valorPadrao' => '0',
            'valorMulta' => '',
            'tributoTad' => '2817',
            'tipoVendaX' => '',
            'tipoUniMedida' => '',
            'valorUnit' => '',
            'upfmtFethab' => '',
        ];
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_COOKIEJAR, '/tmp/cookies.txt');
        $output = curl_exec($ch);
        $info = curl_getinfo($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            throw new \Exception("Falha ao gerar PDF da DAR! - {$error}", 1);
        }

        /*
        echo "<pre>";
        print_r($info);
        echo "<hr>";
        print_r($error);
        echo "<hr>";
        print_r($output);
        echo "<hr>";
        //die();
        */

        if ($info['content_type'] == 'application/pdf') {
            $pdf = $output;
        } else {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://www.sefaz.mt.gov.br/arrecadacao/darlivre/impirmirdar?chavePix=true');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            $headers = array();
            $headers[] = 'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:107.0) Gecko/20100101 Firefox/107.0';
            $headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp;q=0.8';
            $headers[] = 'Accept-Language: pt-BR,pt;q=0.8,en-US;q=0.5,en;q=0.3';
            $headers[] = 'Accept-Encoding: gzip, deflate, br';
            $headers[] = 'Connection: keep-alive';
            $headers[] = 'Referer: https://www.sefaz.mt.gov.br/arrecadacao/darlivre/pj/gerardar';
            $headers[] = 'Upgrade-Insecure-Requests: 1';
            $headers[] = 'Sec-Fetch-Dest: iframe';
            $headers[] = 'Sec-Fetch-Mode: navigate';
            $headers[] = 'Sec-Fetch-Site: same-origin';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_COOKIEFILE, '/tmp/cookies.txt');
            $output = curl_exec($ch);
            $info = curl_getinfo($ch);
            $error = curl_error($ch);
            if ($error) {
                throw new \Exception("Falha ao gerar PDF da DAR! - {$error}", 1);
            }
            curl_close($ch);
            //$pdf = gzdecode($output);
            $pdf = $output;
        }

        // valida se veio um PDF
        if ($info['content_type'] != 'application/pdf') {
            @$doc = new DOMDocument();
            @$doc->loadHTML($output);
            $xpath = new DomXPath($doc);
            $nodeList = $xpath->query("//font[@class='SEFAZ-FONT-MensagemErro']");
            echo '<pre>';
            print_r($data);
            print_r($nodeList);
            print_r($error);
            print_r($info);
            print_r($output);
            echo '</pre>';
            if ($node = $nodeList->item(0)) {
                throw new \Exception(trim($node->nodeValue), 1);
            }
            throw new \Exception("Falha ao gerar PDF da DAR!", 1);
        }

        // Cria diretorio pra salvar o PDF
        $arquivo = "/opt/www/Arquivos/GuiaST/" . DateTime::createFromFormat('d/m/Y H:i:s', $model->emissao)->format("Y/m") . "/";
        if (!file_exists($arquivo)) {
            mkdir($arquivo, 0755, true);
        }

        // Reserva Codtitulo
        $codtitulo = Yii::app()->db->createCommand("SELECT NEXTVAL('tbltitulo_codtitulo_seq')")->queryScalar();

        // Cria o Titulo
        $titulo = new Titulo();
        $titulo->codtitulo = $codtitulo;
        $titulo->codfilial = $model->codfilial;
        $titulo->numero = "ICMS ST {$codtitulo}";
        $titulo->codtipotitulo = 928; // Boleto a Pagar
        $titulo->valor = $valor;
        $titulo->codpessoa = 3899; // sefaz
        $titulo->codcontacontabil = 147; // ICMS ST
        $titulo->transacao = date('d/m/Y');
        $titulo->emissao = date('d/m/Y');
        $titulo->vencimento = $vencimento;
        $titulo->vencimentooriginal = $vencimento;
        $titulo->observacao = "ICMS ST NFe {$model->numero} - {$model->Pessoa->fantasia}\n{$model->nfechave}";
        if (!$titulo->save()) {
            $errors = $titulo->getErrors();
            foreach ($errors as $error) {
                throw new \Exception($error[0], 1);
            }
        };

        // Salva PDF
        $arquivo .= "{$model->nfechave}-{$titulo->codtitulo}.pdf";
        // TODO: Fazer sistema guardar o arquivo compactado (sem o gzdecode)
        file_put_contents($arquivo, gzdecode($pdf));

        // Amarra titulo a NfeTerceiro
        $tituloNfeTerceiro = new TituloNfeTerceiro();
        $tituloNfeTerceiro->codtitulo = $titulo->codtitulo;
        $tituloNfeTerceiro->codnfeterceiro = $model->codnfeterceiro;
        if (!$tituloNfeTerceiro->save()) {
            $errors = $tituloNfeTerceiro->getErrors();
            foreach ($errors as $error) {
                throw new \Exception($error[0], 1);
            }
        };

        echo CJSON::encode(
            array(
                'id' => $id,
                'valor' => $valor,
                'vencimento' => $vencimento,
                'codtitulo' => $titulo->codtitulo,
                'codtitulonfeterceiro' => $tituloNfeTerceiro->codtitulonfeterceiro,
            )
        );
    }

    public function actionGuiaSt($codtitulonfeterceiro)
    {
        $tituloNfeTerceiro = TituloNfeTerceiro::model()->findByPk($codtitulonfeterceiro);
        if ($tituloNfeTerceiro === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        $arquivo = "/opt/www/Arquivos/GuiaST/" . DateTime::createFromFormat('d/m/Y H:i:s', $tituloNfeTerceiro->NfeTerceiro->emissao)->format("Y/m") . "/";
        $arquivo .= "{$tituloNfeTerceiro->NfeTerceiro->nfechave}-{$tituloNfeTerceiro->codtitulo}.pdf";
        if (!file_exists($arquivo)) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        header('Content-type: application/pdf');
        header('Content-Disposition: inline; filename="' . basename($arquivo) . '"');
        readfile($arquivo);
    }

    public function actionConferencia($id)
    {
        $model = $this->loadModel($id);
        if ($_GET['conferencia'] == 'true') {
            $model->conferencia = date('d/m/Y H:i:s');
            $model->codusuarioconferencia = Yii::app()->user->id;
        } else {
            $model->conferencia = null;
            $model->codusuarioconferencia = null;
        }
        $model->save();
        header('Content-type: application/json');
        echo CJSON::encode([
            'codnfeterceiro' => $model->codnfeterceiro,
            'conferencia' => $model->conferencia,
            'codusuarioconferencia' => $model->codusuarioconferencia,
        ]);
    }

    public function actionBuscarItem($id, $barras)
    {
        $sql = '
            select nti.codnfeterceiroitem, nti.cprod, nti.xprod, nti.cean, nti.ceantrib, nti.qcom, nti.vprod
            from tblnfeterceiroitem nti
            left join tblprodutobarra pb on (pb.codprodutobarra = nti.codprodutobarra)
            left join tblprodutobarra pbs on (pbs.codprodutovariacao = pb.codprodutovariacao)
            where nti.codnfeterceiro = :codnfeterceiro
            and pbs.barras = :barras
            union
            select nti.codnfeterceiroitem, nti.cprod, nti.xprod, nti.cean, nti.ceantrib, nti.qcom, nti.vprod
            from tblnfeterceiroitem nti
            left join tblprodutobarra pb on (pb.codprodutobarra = nti.codprodutobarra)
            where nti.codnfeterceiro = :codnfeterceiro
            and :barras in (nti.cean, nti.ceantrib)
            union
            select nti.codnfeterceiroitem, nti.cprod, nti.xprod, nti.cean, nti.ceantrib, nti.qcom, nti.vprod
            from tblnfeterceiroitem nti
            left join tblprodutobarra pb on (pb.codprodutobarra = nti.codprodutobarra)
            where nti.codnfeterceiro = :codnfeterceiro
            and cprod ilike :cprod
        ';
        $command = Yii::app()->db->createCommand($sql);
        $barras = trim($barras);
        $command->params = [
            'codnfeterceiro' => $id,
            'barras' => $barras,
            'cprod' => "%{$barras}%",
        ];
        $items = $command->queryAll();
        header('Content-type: application/json');
        echo CJSON::encode([
            'codnfeterceiro' => $id,
            'items' => $items
        ]);
    }

    public function actionInformaComplemento($id, $valor)
    {
        $model = $this->loadModel($id);
        if (!$model->podeEditar()) {
            header('Content-type: application/json');
            echo CJSON::encode([
                'codnfeterceiro' => $id,
                'erro' => 'Nota não permite edição!'
            ]);
        }
        $params = [
            'codnfeterceiro' => $id,
        ];
        if (empty($valor)) {
            $sql = '
                update tblnfeterceiroitem
                set complemento = null
                from tblnfeterceiro n
                where n.codnfeterceiro = tblnfeterceiroitem.codnfeterceiro
                and tblnfeterceiroitem.codnfeterceiro = :codnfeterceiro
                returning codnfeterceiroitem, complemento
            ';
        } else {
            $sql = '
                update tblnfeterceiroitem
                set complemento = round(( :complemento / n.valorprodutos) * vprod, 2)
                from tblnfeterceiro n
                where n.codnfeterceiro = tblnfeterceiroitem.codnfeterceiro
                and tblnfeterceiroitem.codnfeterceiro = :codnfeterceiro
                returning codnfeterceiroitem, complemento
            ';
            $params['complemento'] = $valor;
        }
        $command = Yii::app()->db->createCommand($sql);
        $command->params = $params;
        $result = $command->queryAll();
        header('Content-type: application/json');
        echo CJSON::encode([
            'codnfeterceiro' => $id,
            'result' => $result
        ]);
    }

    public function actionMarcarImobilizado($codnfeterceiro, $codtipoproduto)
    {
        $model = $this->loadModel($codnfeterceiro);
        if (!$model->podeEditar()) {
            header('Content-type: application/json');
            echo CJSON::encode([
                'codnfeterceiro' => $codnfeterceiro,
                'erro' => 'Nota não permite edição!'
            ]);
        }
        $sql = '
            update tblnfeterceiroitem
            set codprodutobarra = (
                    select min(pb.codprodutobarra)
                    from tblncm n
                    inner join tblproduto p on (p.codncm = n.codncm)
                    inner join tblprodutobarra pb on (pb.codproduto = p.codproduto)
                    where n.ncm = tblnfeterceiroitem.ncm
                    and p.codtipoproduto = :codtipoproduto
                ),
                complemento = null,
                margem = null
            where tblnfeterceiroitem.codnfeterceiro = :codnfeterceiro
            returning codnfeterceiroitem, codprodutobarra
        ';
        $command = Yii::app()->db->createCommand($sql);
        $command->params = [
            'codtipoproduto' => $codtipoproduto,
            'codnfeterceiro' => $codnfeterceiro
        ];
        $items = $command->queryAll();
        header('Content-type: application/json');
        echo CJSON::encode([
            'codnfeterceiro' => $codnfeterceiro,
            'items' => $items
        ]);
    }
}

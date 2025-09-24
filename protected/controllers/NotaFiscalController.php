<?php

class NotaFiscalController extends Controller
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
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate($duplicar = null, $inverter = null)
    {
        $model = new NotaFiscal;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        $model->emissao = date('d/m/Y H:i:s');
        $model->saida = date('d/m/Y H:i:s');
        $model->emitida = true;
        $model->numero = 0;
        $model->codfilial = Yii::app()->user->getState("codfilial");
        $model->serie = 1;
        if ($model->emitida && !empty($model->codfilial)) {
            $filial = Filial::model()->findByPk($model->codfilial);
            $model->serie = $filial->nfeserie;
        }
        if (sizeof($model->Filial->EstoqueLocals) > 0) {
            $model->codestoquelocal = $model->Filial->EstoqueLocals[0]->codestoquelocal;
        }
        $model->modelo = NotaFiscal::MODELO_NFE;

        if (isset($_POST['NotaFiscal'])) {
            $model->attributes = $_POST['NotaFiscal'];

            $transaction = Yii::app()->db->beginTransaction();
            $erro = false;

            if (!$model->save()) {
                $erro = true;
            }


            //duplica produtos
            if (!$erro && (!empty($duplicar) || !empty($inverter))) {
                if (!empty($duplicar)) {
                    $original = $this->loadModel($duplicar);
                }
                if (!empty($inverter)) {
                    $original = $this->loadModel($inverter);
                }

                foreach ($original->NotaFiscalProdutoBarras as $prod_orig) {
                    $prod_novo = new NotaFiscalProdutoBarra;
                    $prod_novo->attributes = $prod_orig->attributes;
                    $prod_novo->codnotafiscalprodutobarra = null;
                    $prod_novo->codnotafiscal = $model->codnotafiscal;

                    $prod_novo->codcfop = null;
                    $prod_novo->csosn = null;
                    $prod_novo->icmscst = null;
                    $prod_novo->ipicst = null;
                    $prod_novo->piscst = null;
                    $prod_novo->cofinscst = null;

                    if (!empty($inverter)) {
                        $prod_novo->codnotafiscalprodutobarraorigem = $prod_orig->codnotafiscalprodutobarra;
                    } else {
                        $prod_novo->icmsbase = null;
                        $prod_novo->icmsbasepercentual = null;
                        $prod_novo->icmspercentual = null;
                        $prod_novo->icmsvalor = null;

                        $prod_novo->icmsstbase = null;
                        $prod_novo->icmsstpercentual = null;
                        $prod_novo->icmsstvalor = null;

                        $prod_novo->ipibase = null;
                        $prod_novo->ipipercentual = null;
                        $prod_novo->ipivalor = null;

                        $prod_novo->pisbase = null;
                        $prod_novo->pispercentual = null;
                        $prod_novo->pisvalor = null;

                        $prod_novo->cofinsbase = null;
                        $prod_novo->cofinspercentual = null;
                        $prod_novo->cofinsvalor = null;

                        $prod_novo->csllbase = null;
                        $prod_novo->csllpercentual = null;
                        $prod_novo->csllvalor = null;

                        $prod_novo->irpjbase = null;
                        $prod_novo->irpjpercentual = null;
                        $prod_novo->irpjvalor = null;
                    }

                    $prod_novo->criacao = null;
                    $prod_novo->codusuariocriacao = null;
                    $prod_novo->alteracao = null;
                    $prod_novo->codusuarioalteracao = null;

                    if (!$prod_novo->save()) {
                        $erro = true;
                        $model->addError('codnotafiscal', 'Erro ao duplicar NotaFiscalProdutoBarra #' . $prod_orig->codnotafiscalprodutobarra);
                        $model->addErrors($prod_novo->getErrors());
                        break;
                    }
                }
            }

            //duplica duplicatas
            if (!$erro && (!empty($duplicar) || !empty($inverter))) {
                foreach ($original->NotaFiscalDuplicatass as $dupl_orig) {
                    $dupl_novo = new NotaFiscalDuplicatas;
                    $dupl_novo->attributes = $dupl_orig->attributes;
                    $dupl_novo->codnotafiscalduplicatas = null;
                    $dupl_novo->codnotafiscal = $model->codnotafiscal;
                    $dupl_novo->criacao = null;
                    $dupl_novo->codusuariocriacao = null;
                    $dupl_novo->alteracao = null;
                    $dupl_novo->codusuarioalteracao = null;
                    $dupl_novo->save();
                    if (!$dupl_novo->save()) {
                        $erro = true;
                        $model->addError('codnotafiscal', 'Erro ao duplicar NotaFiscalDuplicatas #' . $dupl_orig->codnotafiscalduplicatas);
                        $model->addErrors($dupl_novo->getErrors());
                        break;
                    }
                }
            }

            //duplica duplicatas
            if (!$erro && (!empty($duplicar) || !empty($inverter))) {
                foreach ($original->NotaFiscalPagamentos as $dupl_orig) {
                    $dupl_novo = new NotaFiscalPagamento();
                    $dupl_novo->attributes = $dupl_orig->attributes;
                    $dupl_novo->codnotafiscal = $model->codnotafiscal;
                    $dupl_novo->criacao = null;
                    $dupl_novo->codusuariocriacao = null;
                    $dupl_novo->alteracao = null;
                    $dupl_novo->codusuarioalteracao = null;
                    $dupl_novo->save();
                    if (!$dupl_novo->save()) {
                        $erro = true;
                        $model->addError('codnotafiscal', 'Erro ao duplicar NotaFiscalPagamentos #' . $dupl_orig->codnotafiscalpagamentos);
                        $model->addErrors($dupl_novo->getErrors());
                        break;
                    }
                }
            }

            //duplica Referenciadas
            if (!$erro && (!empty($duplicar) || !empty($inverter))) {
                foreach ($original->NotaFiscalReferenciadas as $ref_orig) {
                    $ref_novo = new NotaFiscalReferenciada;
                    $ref_novo->attributes = $ref_orig->attributes;
                    $ref_novo->codnotafiscalreferenciada = null;
                    $ref_novo->codnotafiscal = $model->codnotafiscal;
                    $ref_novo->criacao = null;
                    $ref_novo->codusuariocriacao = null;
                    $ref_novo->alteracao = null;
                    $ref_novo->codusuarioalteracao = null;
                    $ref_novo->save();
                    if (!$ref_novo->save()) {
                        $erro = true;
                        $model->addError('codnotafiscal', 'Erro ao duplicar NotaFiscalReferenciada #' . $ref_orig->codnotafiscalreferenciada);
                        $model->addErrors($ref_novo->getErrors());
                        break;
                    }
                }
            }

            if (!$erro) {
                $transaction->commit();
                $this->redirect(array('view', 'id' => $model->codnotafiscal));
            } else {
                $transaction->rollBack();
            }
        } else {
            if (!empty($duplicar)) {
                $original = $this->loadModel($duplicar);

                $model->attributes = $original->attributes;

                $model->codnotafiscal = null;
                $model->nfechave = null;
                $model->nfereciboenvio = null;
                $model->nfedataenvio = null;
                $model->nfeautorizacao = null;
                $model->nfedataautorizacao = null;
                $model->nfecancelamento = null;
                $model->nfedatacancelamento = null;
                $model->nfeinutilizacao = null;
                $model->nfedatainutilizacao = null;
                $model->justificativa = null;
                $model->codusuariocriacao = null;
                $model->criacao = null;
                $model->codusuarioalteracao = null;
                $model->alteracao = null;
                $model->emissao = date('d/m/Y H:i:s');
                $model->saida = date('d/m/Y H:i:s');
                $model->serie = 1;
                if ($model->emitida && !empty($model->codfilial)) {
                    $filial = Filial::model()->findByPk($model->codfilial);
                    $model->serie = $filial->nfeserie;
                }
                $model->numero = 0;

                $model->codstatus = NotaFiscal::CODSTATUS_NOVA;
            }

            if (!empty($inverter)) {
                $original = $this->loadModel($inverter);

                $model->attributes = $original->attributes;
                $model->codnotafiscal = null;
                if (isset($original->NaturezaOperacao)) {
                    $model->codnaturezaoperacao = $original->NaturezaOperacao->codnaturezaoperacaodevolucao;
                } else {
                    $model->codnaturezaoperacao = null;
                }

                $model->emitida = !$original->emitida;
                $model->codpessoa = null;
                if (isset($original->Filial)) {
                    $model->codpessoa = $original->Filial->codpessoa;
                }
                $model->codfilial = null;
                if (isset($original->Pessoa)) {
                    foreach ($original->Pessoa->Filials as $filial) {
                        $model->codfilial = $filial->codfilial;
                    }
                }
                if (isset($filial->EstoqueLocals[0])) {
                    $model->codestoquelocal = $filial->EstoqueLocals[0]->codestoquelocal;
                }
                $model->codoperacao = null;
                $model->nfereciboenvio = null;
                $model->nfedataenvio = null;
                $model->nfeautorizacao = null;
                $model->nfedataautorizacao = null;
                $model->nfecancelamento = null;
                $model->nfedatacancelamento = null;
                $model->nfeinutilizacao = null;
                $model->nfedatainutilizacao = null;
                $model->justificativa = null;
                $model->alteracao = null;
                $model->codusuarioalteracao = null;
                $model->criacao = null;
                $model->codusuariocriacao = null;
                switch ($model->frete) {
                    case NotaFiscal::FRETE_EMITENTE:
                        $model->frete = NotaFiscal::FRETE_DESTINATARIO;
                        break;
                    case NotaFiscal::FRETE_DESTINATARIO:
                        $model->frete = NotaFiscal::FRETE_EMITENTE;
                        break;
                }
                $model->codstatus = NotaFiscal::CODSTATUS_NOVA;
            }
        }

        $this->render('create', array(
            'model' => $model,
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

        if (!$model->podeEditar()) {
            throw new CHttpException(409, 'Nota Fiscal não permite edição!');
        }

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['NotaFiscal'])) {
            $model->attributes = $_POST['NotaFiscal'];
            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->codnotafiscal));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model = $this->loadModel($id);

                if (!$model->podeEditar()) {
                    throw new CHttpException(409, 'Nota Fiscal não permite exclusão!');
                }

                $model->nfechave = null;
                $model->save();

                foreach ($model->NotaFiscalDuplicatass as $dup) {
                    $dup->delete();
                }

                foreach ($model->NotaFiscalProdutoBarras as $prod) {
                    $prod->delete();
                }

                foreach ($model->NotaFiscalReferenciadas as $ref) {
                    $ref->delete();
                }

                foreach ($model->NfeTerceiros as $ter) {
                    $ter->codnotafiscal = null;
                    $ter->save();
                }

                $model->delete();
                $transaction->commit();
                // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
                if (!isset($_GET['ajax'])) {
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
                }
            } catch (CDbException $e) {
                $transaction->rollBack();
                // Cannot delete or update a parent row: a foreign key constraint fails
                if ($e->errorInfo[1] == 7) {
                    throw new CHttpException(409, 'Registro em uso, você não pode excluir.');
                } else {
                    throw $e;
                }
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    public function actionValorLiquido($id)
    {
        // we only allow deletion via POST request
        if (!Yii::app()->request->isPostRequest) {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }

        $model = $this->loadModel($id);
        if (!$model->emitida) {
            throw new CHttpException(409, 'Nota Fiscal não é de nossa emissão!');
        }

        if (!$model->podeEditar()) {
            throw new CHttpException(409, 'Nota Fiscal não permite edição!');
        }

        try {
            $transaction = Yii::app()->db->beginTransaction();

            $totalAntigo = $model->valortotal;
            $total = 0;
            foreach ($model->NotaFiscalProdutoBarras as $p) {
                $p->valorunitario = round(
                    (
                        $p->valortotal
                        + $p->valorfrete
                        + $p->valorseguro
                        - $p->valordesconto
                        + $p->valoroutras
                    ) / $p->quantidade,
                    2
                );

                $p->valortotal = round($p->valorunitario * $p->quantidade, 2);
                $p->valorfrete = null;
                $p->valorseguro = null;
                $p->valordesconto = null;
                $p->valoroutras = null;
                $p->recalculaTributacao();
                $p->save();

                $total += $p->valortotal;
            }

            if ($total != $totalAntigo) {
                $dif = round($totalAntigo - $total, 2);
                foreach ($model->NotaFiscalProdutoBarras as $p) {
                    if (($dif * 100) % $p->quantidade) {
                        continue;
                    }
                    $p->valorunitario = round(
                        (
                            $p->valortotal
                            + $dif
                        ) / $p->quantidade,
                        2
                    );
                    $p->valortotal = round($p->valorunitario * $p->quantidade, 2);
                    $p->valorfrete = null;
                    $p->valorseguro = null;
                    $p->valordesconto = null;
                    $p->valoroutras = null;
                    $p->recalculaTributacao();
                    $p->save();
                    $total += $dif;
                    break;
                }
            }

            $model->refresh();
            $model->valorprodutos = $total;
            $model->valortotal = $total;
            $model->valorfrete = null;
            $model->valorseguro = null;
            $model->valordesconto = null;
            $model->valoroutras = null;
            $model->save();

            $transaction->commit();
            $this->redirect(array('view', 'id' => $model->codnotafiscal));
        } catch (CDbException $e) {
            $transaction->rollBack();
            throw $e;
        }
    }


    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $model = new NotaFiscal('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['NotaFiscal'])) {
            Yii::app()->session['FiltroNotaFiscalIndex'] = $_GET['NotaFiscal'];
        }
        if (!isset(Yii::app()->session['FiltroNotaFiscalIndex'])) {
            Yii::app()->session['FiltroNotaFiscalIndex'] = array(
                'saida_de' => date('d/m/y', strtotime('-7 days')),
                'codfilial' => Yii::app()->user->codfilial,
            );
        }
        if (isset(Yii::app()->session['FiltroNotaFiscalIndex'])) {
            $model->attributes = Yii::app()->session['FiltroNotaFiscalIndex'];
        }
        $this->render('index', array(
            'dataProvider' => $model->search(),
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new NotaFiscal('search');

        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['NotaFiscal'])) {
            $model->attributes = $_GET['NotaFiscal'];
        }

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model = NotaFiscal::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'nota-fiscal-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /*
    public function actionRobo($codfilial)
    {

        $codnotafiscal = 0;

        if (isset(Yii::app()->session["NotaFiscalRobo$codfilial"]))
            $codnotafiscal = Yii::app()->session["NotaFiscalRobo$codfilial"];

        $model = NotaFiscal::model()->find(
                        array(
                                'order' => 'codnotafiscal',
                                'condition' => '
                                       t.emitida = true
                                        and t.numero > 0
                                        and t.nfeautorizacao is null
                                        and t.nfecancelamento is null
                                        and t.nfeinutilizacao is null
                                        and t.codfilial = :codfilial
                                        and t.codnotafiscal > :codnotafiscal
                                        and t.alteracao between current_date and (current_timestamp - interval \'30 seconds\')
                                ',
                                'params' =>
                                        array(
                                                ":codfilial" => $codfilial,
                                                ":codnotafiscal" => $codnotafiscal,
                                        ),
                        )
                );

        echo "<pre>";

        $res = false;

        if($model===null)
        {
            Yii::app()->session["NotaFiscalRobo$codfilial"] = 0;
            $reload = 30000; // 30 segundos
        }
        else
        {
            Yii::app()->session["NotaFiscalRobo$codfilial"] = $model->codnotafiscal;
            $reload = 1000; //1.0 segundos

            $acbr = new MGAcbrNfeMonitor($model);

            $res = false;

            //tenta consultar se ja tiver chave
            $retornoConsulta = '';
            $resConsulta = false;
            if (!empty($model->nfechave))
            {
                $resConsulta = $acbr->consultarNfe();
                $retornoConsulta = $acbr->retorno;
                //recarrega modelo
                $model = $this->loadModel($model->codnotafiscal);
                if ($model->codstatus == NotaFiscal::CODSTATUS_AUTORIZADA)
                    $resConsulta = true;
                else
                    $resConsulta = false;
            }

            //se na consulta nao retornou autorizada re-envia
            $retornoEnvio = '';
            $resEnvio = false;
            if ($model->codstatus != NotaFiscal::CODSTATUS_AUTORIZADA)
            {
                if ($acbr->criarNFe())
                    $resEnvio = $acbr->enviarNfe();
                $retornoEnvio = $acbr->retorno;
                //recarrega modelo
                $model = $this->loadModel($model->codnotafiscal);
                if ($model->codstatus == NotaFiscal::CODSTATUS_AUTORIZADA)
                    $resEnvio = true;
                else
                    $resEnvio = false;
            }

            //se esta autorizada
            $email = $model->Pessoa->emailnfe;
            $resEmail = false;
            $retornoEmail = '';
            if ($model->codstatus == NotaFiscal::CODSTATUS_AUTORIZADA)
            {
                //gera o PDF da DANFE
                $resPdf = $acbr->imprimirDanfePdf();

                //ENVIA o EMAIL
                if (empty($email))
                    $email = $model->Pessoa->email;
                if (empty($email))
                    $email = $model->Pessoa->emailcobranca;
                if (!empty($email))
                    $resEmail = $acbr->enviarEmail($email);
                $retornoEmail = $acbr->retorno;

                //Se for NFCe Imprime na termica
                if ($model->modelo == NotaFiscal::MODELO_NFCE)
                {
                    $impressora = $model->UsuarioCriacao->impressoratermica;
                    $this->imprimirDanfePdfTermica($model, $impressora);
                }
            }

            $arrRet = array(
                'id' => $model->codnotafiscal,
                'status' => $model->codstatus . ' - ' . $model->status,
                'modelo' => $model->modelo,

                'ResConsulta' => $resConsulta,
                'RetornoConsulta' => $retornoConsulta,

                'ResEnvio' => $resEnvio,
                'RetornoEnvio' => $retornoEnvio,

                'Email' => $email,
                'ResEmail' => $resEmail,
                'RetornoEmail' => $retornoEmail,

            );

            print_r($arrRet);
        }

        echo "</pre>";
        echo "<script>\n";
        echo "window.setTimeout('location.reload()', $reload); //reloads after 10 seconds\n";
        echo "</script>\n";

    }
     *
     */

    /*
    public function actionEnviarNfe($id)
    {
        $model = $this->loadModel($id);
        $acbr = new MGAcbrNfeMonitor($model);

        $res = false;

        if ($acbr->criarNFe())
            $res = $acbr->enviarNfe();

        $email = $model->Pessoa->emailnfe;
        $resEmail = false;

        if ($res)
        {
            $resPdf = $acbr->imprimirDanfePdf();

            if (empty($email))
                $email = $model->Pessoa->email;
            if (empty($email))
                $email = $model->Pessoa->emailcobranca;

            if (!empty($email))
                $resEmail = $acbr->enviarEmail($email);

            $impressora = Yii::app()->user->impressoraTermica;
            $this->imprimirDanfePdfTermica($model, $impressora);
        }


        echo CJSON::encode(
            array(
                'id' => $id,
                'resultado' => $res,
                'email' => $email,
                'resultadoEmail' => $resEmail,
                'modelo' => $model->modelo,
                'retornoMonitor' => (isset($acbr->retornoMonitor["Mensagem"])?$acbr->retornoMonitor["Mensagem"]:null),
                'erroMonitor' => htmlentities($acbr->erroMonitor, ENT_QUOTES, 'ISO-8859-1'),
                'retorno' => htmlentities($acbr->retorno, ENT_QUOTES, 'ISO-8859-1'),
                'urlpdf' => $acbr->urlpdf,
            )
        );

    }
     *
     */

    /*
    public function actionConsultarNfe($id)
    {
        $model = $this->loadModel($id);
        $acbr = new MGAcbrNfeMonitor($model);

        $res = $acbr->consultarNfe();

        echo CJSON::encode(
            array(
                'id' => $id,
                'resultado' => $res,
                'retornoMonitor' => (isset($acbr->retornoMonitor["Mensagem"])?$acbr->retornoMonitor["Mensagem"]:null),
                'erroMonitor' => htmlentities($acbr->erroMonitor, ENT_QUOTES, 'ISO-8859-1'),
                'retorno' => htmlentities($acbr->retorno, ENT_QUOTES, 'ISO-8859-1'),
            )
        );

    }
     *
     */

    /*
    public function actionEnviarEmail($id, $email, $alterarcadastro = false)
    {
        $model = $this->loadModel($id);
        $acbr = new MGAcbrNfeMonitor($model);


        $res = $acbr->imprimirDanfePdf();
        $res = $acbr->enviarEmail($email, $alterarcadastro);

        echo CJSON::encode(
            array(
                'id' => $id,
                'resultado' => $res,
                'retornoMonitor' => (isset($acbr->retornoMonitor["Mensagem"])?$acbr->retornoMonitor["Mensagem"]:null),
                'erroMonitor' => htmlentities($acbr->erroMonitor, ENT_QUOTES, 'ISO-8859-1'),
                'retorno' => htmlentities($acbr->retorno, ENT_QUOTES, 'ISO-8859-1'),
            )
        );

    }
     *
     */

    /*
    public function actionCancelarNfe($id, $justificativa)
    {
        $model = $this->loadModel($id);
        $acbr = new MGAcbrNfeMonitor($model);

        $res = $acbr->cancelarNfe($justificativa);

        echo CJSON::encode(
            array(
                'id' => $id,
                'resultado' => $res,
                'retornoMonitor' => (isset($acbr->retornoMonitor["Mensagem"])?$acbr->retornoMonitor["Mensagem"]:null),
                'erroMonitor' => htmlentities($acbr->erroMonitor, ENT_QUOTES, 'ISO-8859-1'),
                'retorno' => htmlentities($acbr->retorno, ENT_QUOTES, 'ISO-8859-1'),
            )
        );

    }
     *
     */

    /*
    public function actionInutilizarNfe($id, $justificativa)
    {
        $model = $this->loadModel($id);
        $acbr = new MGAcbrNfeMonitor($model);

        $res = $acbr->inutilizarNfe($justificativa);

        echo CJSON::encode(
            array(
                'id' => $id,
                'resultado' => $res,
                'retornoMonitor' => (isset($acbr->retornoMonitor["Mensagem"])?$acbr->retornoMonitor["Mensagem"]:null),
                'erroMonitor' => htmlentities($acbr->erroMonitor, ENT_QUOTES, 'ISO-8859-1'),
                'retorno' => htmlentities($acbr->retorno, ENT_QUOTES, 'ISO-8859-1'),
            )
        );

    }
     *
     */

    /*
    public function actionImprimirDanfePdf($id, $imprimir = false)
    {
        $model = $this->loadModel($id);
        $acbr = new MGAcbrNfeMonitor($model);

        $res = $acbr->imprimirDanfePdf();
        //$res = $acbr->imprimirDanfe();

        $impressora = Yii::app()->user->impressoraTermica;
        if ($res && $imprimir && $model->modelo == NotaFiscal::MODELO_NFCE)
            $this->imprimirDanfePdfTermica ($model, $impressora);

        echo CJSON::encode(
            array(
                'id' => $id,
                'resultado' => $res,
                'retornoMonitor' => (isset($acbr->retornoMonitor["Mensagem"])?$acbr->retornoMonitor["Mensagem"]:null),
                'erroMonitor' => htmlentities($acbr->erroMonitor, ENT_QUOTES, 'ISO-8859-1'),
                'retorno' => htmlentities($acbr->retorno, ENT_QUOTES, 'ISO-8859-1'),
                'urlpdf' => $acbr->urlpdf,
            )
        );

    }
     *
     */

    /*
    public function actionCartaCorrecao($id, $texto)
    {
        $model = $this->loadModel($id);
        $acbr = new MGAcbrNfeMonitor($model);

        $res = $acbr->cartaCorrecao($texto);

        echo CJSON::encode(
            array(
                'id' => $id,
                'resultado' => $res,
                'retornoMonitor' => (isset($acbr->retornoMonitor["Mensagem"])?$acbr->retornoMonitor["Mensagem"]:null),
                'erroMonitor' => htmlentities($acbr->erroMonitor, ENT_QUOTES, 'ISO-8859-1'),
                'retorno' => htmlentities($acbr->retorno, ENT_QUOTES, 'ISO-8859-1'),
            )
        );

    }
    */

    public function validarFiltro()
    {
        if (isset(Yii::app()->session['FiltroNotaFiscalIndex'])) {
            foreach (Yii::app()->session['FiltroNotaFiscalIndex'] as $key => $val) {
                if (!empty($val)) {
                    return;
                }
            }
        }
        die('Faça pelo menos um filtro!');
    }

    public function actionRelatorio()
    {
        // WORKAROUND: Cache Chrome salvando sempre o mesmo relatorio!
        // Ate mostrava em tela diferente, mas ao salvar, salvava a primeira versao emitida
        if (!isset($_GET['__pdfdate'])) {
            header('Location: ' . $_SERVER['REQUEST_URI'] . '&__pdfdate=' . date('c'));
        }

        $model = new NotaFiscal('search');

        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['NotaFiscal'])) {
            Yii::app()->session['FiltroNotaFiscalIndex'] = $_GET['NotaFiscal'];
        }

        $this->validarFiltro();

        if (isset(Yii::app()->session['FiltroNotaFiscalIndex'])) {
            $model->attributes = Yii::app()->session['FiltroNotaFiscalIndex'];
        }

        $notasfiscais = $model->search(false);

        $rel = new MGRelatorioNotasFiscais($notasfiscais);
        $rel->montaRelatorio();
        $rel->Output();
    }

    /**
     * @param NotaFiscal $nf
     */
    /*
    function imprimirDanfePdfTermica ($nf, $impressora)
    {
        if ($nf->modelo <> NotaFiscal::MODELO_NFCE)
            return false;

        if (empty($impressora))
            return false;

        //require_once('/var/www/NFePHP/101/libs/NFe/DanfeNFCeNFePHP.class.php');
        require_once('/var/www/NFePHP/' . $nf->codfilial . '/libs/NFe/DanfeNFCeNFePHP.class.php');

        //Baixa XML
        $urlxml = $nf->Filial->acbrnfemonitorcaminhorede . 'NFe/' . substr($nf->emissao, 6, 4) . substr($nf->emissao, 3, 2)  . '/' . $nf->nfechave . '-nfe.xml';
        $xml = file_get_contents($urlxml);

        //Monta Danfe
        $danfe = new DanfeNFCeNFePHP($xml, '/var/www/NFePHP/Imagens/MGPapelariaSeloPretoBranco.jpg', 0, $nf->Filial->nfcetokenid, $nf->Filial->nfcetoken);
        $id = $danfe->montaDANFE(true);

        //Imprime
        $arquivo = "{$nf->nfechave}.pdf";
        //$teste = $danfe->printDANFE('pdf', $arquivo, 'P', $impressora);
        $teste = $danfe->printDANFE('pdf', $arquivo, 'P', $impressora);

    }
    */
}

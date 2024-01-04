<?php

class NegocioController extends Controller
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
    public function actionView($id, $perguntarNota = false)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
            'perguntarNota' => $perguntarNota
        ));
    }

    /**
     * Verifica se já existe um negocio zerado e redireciona para ele
     * caso contrario redireciona pra tela de criacao
     */
    public function actionCreateOrEmpty()
    {
        $sql = '
            select codnegocio
            from tblnegocio
            where codnegociostatus = 1
            and valortotal = 0
            and codpessoa = 1
            and codusuario = :codusuario
            order by criacao
            limit 1
        ';
        $cmd = Yii::app()->db->createCommand($sql);
        $cmd->params = [
            'codusuario' => Yii::app()->user->id
        ];
        $res = $cmd->queryAll();
        if (isset($res[0])) {
            return $this->redirect(array('view', 'id' => $res[0]['codnegocio']));
        }
        return $this->redirect(array('create'));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate($duplicar = null)
    {
        $model = new Negocio;
        $itens = [];

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        $model->codusuario = Yii::app()->user->id;
        $model->lancamento = date('d/m/Y H:i:s');
        $model->codnegociostatus = NegocioStatus::ABERTO;
        $model->codfilial = Yii::app()->user->getState("codfilial");
        if (sizeof($model->Filial->EstoqueLocals) > 0) {
            $model->codestoquelocal = $model->Filial->EstoqueLocals[0]->codestoquelocal;
        }
        $model->codnaturezaoperacao = NaturezaOperacao::VENDA;
        $model->codpessoa = Pessoa::CONSUMIDOR;

        $codnegocioprodutobarraduplicar = [];
        if (isset($_POST['codnegocioprodutobarraduplicar'])) {
            $codnegocioprodutobarraduplicar = $_POST['codnegocioprodutobarraduplicar'];
        }

        if (isset($_POST['Negocio'])) {

            $transaction = Yii::app()->db->beginTransaction();

            $erro = false;
            $model->attributes = $_POST['Negocio'];
            if (!empty($model->NaturezaOperacao)) {
                $model->codoperacao = $model->NaturezaOperacao->codoperacao;
            }
            if (!$model->save()) {
                $erro = true;
            }

            if (!empty($duplicar)) {
                $original = $this->loadModel($duplicar);
            }

            if (!$erro && !empty($duplicar)) {


                //duplica produtos
                foreach ($original->NegocioProdutoBarras as $prod_orig) {
                    if (!isset($codnegocioprodutobarraduplicar[$prod_orig->codnegocioprodutobarra])) {
                        continue;
                    }
                    $prod_novo = new NegocioProdutoBarra;
                    $prod_novo->attributes = $prod_orig->attributes;
                    $prod_novo->codnegocioprodutobarra = null;
                    $prod_novo->codnegocio = $model->codnegocio;
                    $prod_novo->criacao = null;
                    $prod_novo->codusuariocriacao = null;
                    $prod_novo->alteracao = null;
                    $prod_novo->codusuarioalteracao = null;

                    if (!$prod_novo->save()) {
                        $model->addError('codnegocio', 'Erro ao duplicar NegocioProdutoBarra #' . $prod_orig->codnegocioprodutobarra);
                        $model->addErrors($prod_novo->getErrors());
                        $erro = true;
                        break;
                    }
                }

                $model->refresh();
                $model->valorfrete = $original->valorfrete;
                $model->codpessoatransportador = $original->codpessoatransportador;
                $model->valordesconto = $original->valordesconto;
                if (!$model->save()) {
                    $erro = true;
                }
            }

            if (!$erro) {
                $transaction->commit();
                $this->redirect(array('view', 'id' => $model->codnegocio));
            } else {
                $transaction->rollBack();
                if (isset($original)) {
                    $itens = $this->itensDuplicar($original);
                }
            }
        } else {
            if (!empty($duplicar)) {
                $original = $this->loadModel($duplicar);
                $model->attributes = $original->attributes;
                $model->codusuariocriacao = null;
                $model->criacao = null;
                $model->codusuarioalteracao = null;
                $model->alteracao = null;
                $model->codnegociostatus = NegocioStatus::ABERTO;
                $model->codusuario = Yii::app()->user->id;
                $model->lancamento = date('d/m/Y H:i:s');
                $model->observacoes = 'Duplicado de ' . Yii::app()->format->formataCodigo($duplicar, 8) . "\n" . $model->observacoes;
                $itens = $this->itensDuplicar($original);
                foreach ($itens as $item) {
                    $codnegocioprodutobarraduplicar[$item->codnegocioprodutobarra] = true;
                }
            }
        }

        $this->render('create', array(
            'model' => $model,
            'itens' => $itens,
            'codnegocioprodutobarraduplicar' => $codnegocioprodutobarraduplicar
        ));
    }

    public function actionAlterar($id)
    {

        $model = $this->loadModel($id);

        $itens = [];

        $this->performAjaxValidation($model);

        if ($model->codnegociostatus !== 2) {
            Yii::app()->user->setFlash("error", "Só é possivel alterar negócio fechado!");
            $this->redirect(array('view', 'id' => $model->codnegocio));
            return;
        }

        //$model->codusuario = Yii::app()->user->id;
        //$model->lancamento = date('d/m/Y H:i:s');
        //$model->codfilial = Yii::app()->user->getState("codfilial");
        //if (sizeof($model->Filial->EstoqueLocals) > 0) {
            //$model->codestoquelocal = $model->Filial->EstoqueLocals[0]->codestoquelocal;
        //}


        if (isset($_POST['Negocio'])) {
            $natNova = NaturezaOperacao::model()->findByPk($_POST['Negocio']['codnaturezaoperacao']);

            if ($model->NaturezaOperacao->codoperacao !== $natNova->codoperacao) {
                Yii::app()->user->setFlash("error", "Não é permitiro alterar uma operação de Saída para Entrada ou vice-versa!");
                $this->redirect(array('alterar', 'id' => $model->codnegocio));
                return;
            }

            $transaction = Yii::app()->db->beginTransaction();
           
            $model->attributes = $_POST['Negocio'];
            $salvo = $model->save();

            foreach ($model->NegocioFormaPagamentos as $nfp) {
                foreach ($nfp->Titulos as $titulo) {
                    $titulo->codpessoa = $model->codpessoa;
                    $titulo->codtipotitulo = $natNova->codtipotitulo;
                    $titulo->codcontacontabil = $natNova->codcontacontabil;
                    $titulo->save();
                }
            }

            if ($salvo) {
                // $model->movimentaEstoque();
                $transaction->commit();
                Yii::app()->user->setFlash("success", "Negócio Alterado!");
                $this->redirect(array('view', 'id' => $model->codnegocio));
            }else {
                $transaction->rollBack();
                Yii::app()->user->setFlash("error", "Erro ao alterar negócio!");
            }

        }

        $this->render('alterar', array(
            'model' => $model,
            'itens' => $itens
        ));
    }

    public function itensDuplicar($original)
    {
        $itens = [];
        foreach ($original->NegocioProdutoBarras as $npb) {
            $itens[] = (object) [
                'codnegocioprodutobarra' => $npb->codnegocioprodutobarra,
                'codprodutobarra' => $npb->codprodutobarra,
                'descricao' => $npb->ProdutoBarra->descricao,
                'barras' => $npb->ProdutoBarra->barras,
                'quantidade' => $npb->quantidade,
                'valorunitario' => $npb->valorunitario,
                'valortotal' => $npb->valortotal,
            ];
        }
        return $itens;
    }


    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        if (isset($_POST['Negocio']['percentualdesconto'])) {
            unset($_POST['Negocio']['percentualdesconto']);
        }
        $model = $this->loadModel($id);
        if ($model->codnegociostatus != 1) {
            $this->redirect(array('view', 'id' => $model->codnegocio));
        }

        $perguntarNota = false;
        $fechar = 0;
        if (isset($_POST["fechar"])) {
            $fechar = $_POST["fechar"];
        }

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Negocio'])) {
            $model->attributes = $_POST['Negocio'];
            $salvo = $model->save();

            if ($salvo && $fechar == 1) {
                $salvo = $model->fecharNegocio();
            }

            if ($salvo && $fechar == 1) {
                $perguntarNota = true;
            }

            if ($salvo) {
                $this->redirect(array('view', 'id' => $model->codnegocio, 'perguntarNota' => $perguntarNota));
            }
        }

        $this->render('update', array(
            'model' => $model,
            'itens' => [],
            'codnegocioprodutobarraduplicar' => []
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    /*
    public function actionDelete($id)
    {
        if(Yii::app()->request->isPostRequest)
        {
            // we only allow deletion via POST request
            try
            {
                $this->loadModel($id)->delete();
                // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
                if(!isset($_GET['ajax']))
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
            }
            catch(CDbException $e)
            {
                // Cannot delete or update a parent row: a foreign key constraint fails
                if($e->errorInfo[1] == 7)
                {
                    throw new CHttpException(409, 'Registro em uso, você não pode excluir.');
                }
                else
                    throw $e;
            }
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }
     *
     */

    public function actionCancelar($id)
    {
        if (Yii::app()->request->isPostRequest) {
            // we only allow Cancelar via POST request
            $model = $this->loadModel($id);
            if (!$model->cancelar()) {
                $erros = $model->getErrors();
                $erro = "Impossível estornar negócio!<br>";
                foreach ($erros as $campo => $mensagens) {
                    foreach ($mensagens as $mensagem) {
                        $erro .= "\n<br>- " . $mensagem;
                    }
                }
                Yii::app()->user->setFlash("error", $erro);
            } else {
                Yii::app()->user->setFlash("success", "Negócio Cancelado!");
            }

            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('view', 'id' => $model->codnegocio));
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }


    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $model = new Negocio('search');

        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['Negocio'])) {
            Yii::app()->session['FiltroNegocioIndex'] = $_GET['Negocio'];
        }

        if (!isset(Yii::app()->session['FiltroNegocioIndex'])) {
            Yii::app()->session['FiltroNegocioIndex'] = array(
                'codusuario' => Yii::app()->user->id,
                'lancamento_de' => date('d/m/y', strtotime('-7 days')) . ' 00:00',
            );
        }

        if (isset(Yii::app()->session['FiltroNegocioIndex'])) {
            $model->attributes = Yii::app()->session['FiltroNegocioIndex'];
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
        $model = new Negocio('search');

        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['Negocio'])) {
            $model->attributes = $_GET['Negocio'];
        }

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionImprimeRomaneio($id, $imprimir = false)
    {
        $model = $this->loadModel($id);

        if ($model->codnegociostatus <> NegocioStatus::FECHADO) {
            throw new CHttpException(400, 'O status do Negócio não permite impressão do Romaneio!');
        }

        $rel = new MGEscPrintRomaneio($model);
        $rel->prepara();

        if ($imprimir) {
            $rel->imprimir();
        }

        echo $rel->converteHtml();
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     * @return Negocio
     */
    public function loadModel($id)
    {
        $model = Negocio::model()->findByPk($id);
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
        if (!isset($_POST['ajax'])) {
            return;
        }
        if ($_POST['ajax'] !== 'negocio-form') {
            return;
        }
        echo CActiveForm::validate($model);
        // Gambiarra pra salvar os dados enquanto usuario edita
        if (!empty($model->codnegocio) && $model->codnegociostatus == 1) {
            $model->attributes = $_POST['Negocio'];
            $model->save();
        }
        Yii::app()->end();
    }

    public function actionAdicionaProduto($codnegocio, $barras, $quantidade = 1)
    {
        $model = $this->loadModel($codnegocio);

        $retorno = array("Adicionado" => true, "Mensagem" => "");

        if ($pb = ProdutoBarra::model()->findByBarras($barras)) {
            if ($npb = NegocioProdutoBarra::model()->find(
                "codnegocio=:codnegocio AND codprodutobarra=:codprodutobarra",
                array(
                    ":codnegocio" => $model->codnegocio,
                    ":codprodutobarra" => $pb->codprodutobarra
                )
            )) {
                $npb->quantidade += $quantidade;
            } else {
                $npb = new NegocioProdutoBarra;
                $npb->codnegocio = $model->codnegocio;
                $npb->codprodutobarra = $pb->codprodutobarra;
                $npb->quantidade = $quantidade;
                $npb->valorunitario = $pb->preco;
            }
            $npb->valortotal = $npb->quantidade * $npb->valorunitario;

            $n = $npb->Negocio;
            $n->lancamento = date('d/m/Y H:i:s');
            $n->save();

            if (!$npb->save()) {
                $retorno["Adicionado"] = false;
                $erros = $npb->getErrors();
                $erro = "Erro ao salvar registro de produto!<br>";
                foreach ($erros as $campo => $mensagens) {
                    foreach ($mensagens as $mensagem) {
                        $erro .= "\n<br>- " . $mensagem;
                    }
                }

                $retorno["Mensagem"] = $erro;
                $retorno["Erros"] = $erros;
            }
        } else {
            $retorno["Adicionado"] = false;
            $retorno["Mensagem"] = "Produto '$barras' não localizado!";
        }

        echo CJSON::encode($retorno);
    }

    public function actionAtualizaListagemProdutos($codnegocio)
    {
        $this->renderPartial('_view_produtos_listagem', array(
            'model' => $this->loadModel($codnegocio),
        ));
    }

    public function actionAtualizaListagemPagamentos($codnegocio)
    {
        $this->renderPartial('_view_pagamentos_listagem', array(
            'model' => $this->loadModel($codnegocio),
        ));
    }

    public function actionAtualizaListagemPixCob($codnegocio)
    {
        $this->renderPartial('_view_pix_cob_listagem', array(
            'model' => $this->loadModel($codnegocio),
        ));
    }

    public function actionAtualizaListagemStonePreTransacao($codnegocio)
    {
        $this->renderPartial('_view_stone_listagem', array(
            'model' => $this->loadModel($codnegocio),
        ));
    }

    public function actionAtualizaListagemPagarMePedido($codnegocio)
    {
        $this->renderPartial('_view_pagar_me_listagem', array(
            'model' => $this->loadModel($codnegocio),
        ));
    }

    public function actionAtualizaTotais($codnegocio)
    {
        $this->renderPartial('_view_totais', array(
            'model' => $this->loadModel($codnegocio),
        ));
    }

    public function actionAdicionaFormaPagamento($codnegocio, $codformapagamento, $valorpagamento)
    {
        $model = $this->loadModel($codnegocio);

        $retorno = array("Adicionado" => true, "Mensagem" => "");

        if ($valorpagamento <= 0) {
            $retorno["Adicionado"] = false;
            $retorno["Mensagem"] = "Valor Inválido!";
        } elseif ($fp = FormaPagamento::model()->findByPk($codformapagamento)) {
            if ($nfp = NegocioFormaPagamento::model()->find(
                "codnegocio=:codnegocio AND codformapagamento=:codformapagamento",
                array(
                    ":codnegocio" => $model->codnegocio,
                    ":codformapagamento" => $fp->codformapagamento
                )
            )) {
                $nfp->valorpagamento += $valorpagamento;
            } else {
                $nfp = new NegocioFormaPagamento;
                $nfp->codnegocio = $model->codnegocio;
                $nfp->codformapagamento = $fp->codformapagamento;
                $nfp->valorpagamento = $valorpagamento;
            }

            if (!$nfp->save()) {
                $retorno["Adicionado"] = false;
                $erros = $nfp->getErrors();
                $erro = "Erro ao salvar registro de produto!<br>";
                foreach ($erros as $campo => $mensagens) {
                    foreach ($mensagens as $mensagem) {
                        $erro .= "\n<br>- " . $mensagem;
                    }
                }

                $retorno["Mensagem"] = $erro;
                $retorno["Erros"] = $erros;
            }
        } else {
            $retorno["Adicionado"] = false;
            $retorno["Mensagem"] = "Forma de Pagamento '$codformapagamento' não localizada!";
        }

        echo CJSON::encode($retorno);
    }

    public function actionFecharNegocio($codnegocio)
    {
        $negocio = $this->loadModel($codnegocio);

        $retorno = array("Retorno" => true, "Mensagem" => "");

        if (!$negocio->fecharNegocio()) {
            $retorno["Retorno"] = false;
            $erros = $negocio->getErrors();
            $erro = "Erro ao Fechar Negócio!";
            foreach ($erros as $campo => $mensagens) {
                foreach ($mensagens as $mensagem) {
                    $erro .= " " . $mensagem;
                }
            }
            $retorno["Mensagem"] = $erro;
        }

        echo CJSON::encode($retorno);
    }

    public function actionGerarNotaFiscal($id, $modelo = null, $codnotafiscal = null)
    {
        $negocio = $this->loadModel($id);

        $retorno = array("Retorno" => 1, "Mensagem" => "", "codnotafiscal" => $codnotafiscal);

        $transaction = Yii::app()->db->beginTransaction();

        if (!$codnotafiscal = $negocio->gerarNotaFiscal($codnotafiscal, $modelo, true)) {
            $retorno["Retorno"] = 0;
            $erros = $negocio->getErrors();
            $erro = "Erro ao Gerar Nota Fiscal!";
            foreach ($erros as $campo => $mensagens) {
                foreach ($mensagens as $mensagem) {
                    $erro .= " " . $mensagem;
                }
            }
            $retorno["Mensagem"] = $erro;
            $transaction->rollBack();
        } else {
            $transaction->commit();
        }

        $retorno["codnotafiscal"] = $codnotafiscal;

        echo CJSON::encode($retorno);
    }

    public function validarFiltro()
    {
        if (isset(Yii::app()->session['FiltroNegocioIndex'])) {
            foreach (Yii::app()->session['FiltroNegocioIndex'] as $key => $val) {
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

        $model = new Negocio('search');

        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['Negocio'])) {
            Yii::app()->session['FiltroNegocioIndex'] = $_GET['Negocio'];
        }

        $this->validarFiltro();

        if (isset(Yii::app()->session['FiltroNegocioIndex'])) {
            $model->attributes = Yii::app()->session['FiltroNegocioIndex'];
        }

        $negocios = $model->search(false);

        $rel = new MGRelatorioNegocios($negocios);
        $rel->montaRelatorio();
        $rel->Output();
    }
    public function actionRelatorioOrcamento($id)
    {
        // WORKAROUND: Cache Chrome salvando sempre o mesmo relatorio!
        // Ate mostrava em tela diferente, mas ao salvar, salvava a primeira versao emitida
        if (!isset($_GET['__pdfdate'])) {
            header('Location: ' . $_SERVER['REQUEST_URI'] . '&__pdfdate=' . date('c'));
        }

        $model = $this->loadModel($id);
        $rel = new MGRelatorioOrcamento($model);
        $rel->montaRelatorio();
        $rel->Output();
    }

    public function actionDevolucao($id)
    {
        $model = $this->loadModel($id);

        if ($model->codnegociostatus != NegocioStatus::FECHADO) {
            throw new CHttpException(409, 'O Status do Negócio não permite Devolução!');
        }

        if ($model->codnaturezaoperacao != NaturezaOperacao::VENDA) {
            throw new CHttpException(409, 'Negócio não é uma venda!');
        }

        if (isset($_POST['quantidadedevolucao'])) {
            $codnegociodevolucao = $model->gerarDevolucao($_POST['quantidadedevolucao']);
            if ($codnegociodevolucao !== false) {
                $this->redirect(array('view', 'id' => $codnegociodevolucao));
            }
        }

        $this->render('devolucao', array(
            'model' => $model,
        ));
    }

    public function actionStatus($id)
    {
        $model = $this->loadModel($id);
        echo CJSON::encode([
            'codnegociostatus' => $model->codnegociostatus,
            'valorprodutos' => (float) $model->valorprodutos,
            'valorjuros' => (float) $model->valorjuros,
            'valorpagamento' => (float) $model->valorPagamento(),
        ]);
    }
}

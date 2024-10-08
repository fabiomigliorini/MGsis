<?php

class NotaFiscalPagamentoController extends Controller
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
    public function actionCreate($codnotafiscal)
    {
        $model = new NotaFiscalPagamento;

        $model->codnotafiscal = $codnotafiscal;

        if (!$model->NotaFiscal->podeEditar()) {
            throw new CHttpException(409, 'Nota Fiscal não permite edição!');
        }

        $this->performAjaxValidation($model);

        if (isset($_POST['NotaFiscalPagamento'])) {
            $model->attributes = $_POST['NotaFiscalPagamento'];
            if ($model->save()) {
                $this->redirect(array('notaFiscal/view', 'id' => $model->codnotafiscal));
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

        if (!$model->NotaFiscal->podeEditar()) {
            throw new CHttpException(409, 'Nota Fiscal não permite edição!');
        }

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['NotaFiscalPagamento'])) {
            $model->attributes = $_POST['NotaFiscalPagamento'];
            if ($model->save()) {
                $this->redirect(array('NotaFiscal/view', 'id' => $model->codnotafiscal));
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
            try {
                $model = $this->loadModel($id);
                if (!$model->NotaFiscal->podeEditar()) {
                    throw new CHttpException(409, 'Nota Fiscal não permite edição!');
                }
                $model->delete();
                // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
                if (!isset($_GET['ajax'])) {
                    // $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
                }
            } catch (CDbException $e) {
                // Cannot delete or update a parent row: a foreign key constraint fails
                if ($e->errorInfo[1] == 7) {
                    throw new CHttpException(409, 'Registro em uso, você não pode excluir.');
                } else
                    throw $e;
            }
        } else {

            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model = NotaFiscalPagamento::model()->findByPk($id);
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
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'nota-fiscal-pagamento-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}

<?php

class TributacaoController extends Controller
{
	/**
	* @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	* using two-column layout. See 'protected/views/layouts/column2.php'.
	*/
	public $layout='//layouts/column2';

	/**
	* Displays a particular model.
	* @param integer $id the ID of the model to be displayed
	*/
	public function actionView($id)
	{
        $this->redirect(APP_NOTAS_URL . '/tributacao-cadastro');
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			));
	}

	/**
	* Creates a new model.
	* If creation is successful, the browser will be redirected to the 'view' page.
	*/
	public function actionCreate()
	{
        $this->redirect(APP_NOTAS_URL . '/tributacao-cadastro');
		$model=new Tributacao;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Tributacao']))
		{
			$model->attributes=$_POST['Tributacao'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->codtributacao));
		}

		$this->render('create',array(
			'model'=>$model,
			));
	}

	/**
	* Updates a particular model.
	* If update is successful, the browser will be redirected to the 'view' page.
	* @param integer $id the ID of the model to be updated
	*/
	public function actionUpdate($id)
	{
        $this->redirect(APP_NOTAS_URL . '/tributacao-cadastro');
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Tributacao']))
		{
			$model->attributes=$_POST['Tributacao'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->codtributacao));
		}

		$this->render('update',array(
			'model'=>$model,
			));
	}

	/**
	* Deletes a particular model.
	* If deletion is successful, the browser will be redirected to the 'admin' page.
	* @param integer $id the ID of the model to be deleted
	*/
	public function actionDelete($id)
	{
        $this->redirect(APP_NOTAS_URL . '/tributacao-cadastro');
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

	/**
	* Lists all models.
	*/
	public function actionIndex()
	{
        $this->redirect(APP_NOTAS_URL . '/tributacao-cadastro');
		$model=new Tributacao('search');

		$model->unsetAttributes();  // clear any default values

		if(isset($_GET['Tributacao']))
			Yii::app()->session['FiltroTributacaoIndex'] = $_GET['Tributacao'];

		if (isset(Yii::app()->session['FiltroTributacaoIndex']))
			$model->attributes=Yii::app()->session['FiltroTributacaoIndex'];

		$this->render('index',array(
			'dataProvider'=>$model->search(),
			'model'=>$model,
			));
	}

	/**
	* Manages all models.
	*/
	public function actionAdmin()
	{
        $this->redirect(APP_NOTAS_URL . '/tributacao-cadastro');
		$model=new Tributacao('search');

		$model->unsetAttributes();  // clear any default values

		if(isset($_GET['Tributacao']))
			$model->attributes=$_GET['Tributacao'];

		$this->render('admin',array(
			'model'=>$model,
			));
	}

	/**
	* Returns the data model based on the primary key given in the GET variable.
	* If the data model is not found, an HTTP exception will be raised.
	* @param integer the ID of the model to be loaded
	*/
	public function loadModel($id)
	{
        $this->redirect(APP_NOTAS_URL . '/tributacao-cadastro');
		$model=Tributacao::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	* Performs the AJAX validation.
	* @param CModel the model to be validated
	*/
	protected function performAjaxValidation($model)
	{
        $this->redirect(APP_NOTAS_URL . '/tributacao-cadastro');
		if(isset($_POST['ajax']) && $_POST['ajax']==='tributacao-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

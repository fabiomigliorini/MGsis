<?php

class CertidaoEmissorController extends Controller
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
        $this->redirect(APP_PESSOAS_URL . '/certidao-emissor');
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
        $this->redirect(APP_PESSOAS_URL . '/certidao-emissor');
		$model=new CertidaoEmissor;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['CertidaoEmissor']))
		{
			$model->attributes=$_POST['CertidaoEmissor'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->codcertidaoemissor));
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
        $this->redirect(APP_PESSOAS_URL . '/certidao-emissor');
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['CertidaoEmissor']))
		{
			$model->attributes=$_POST['CertidaoEmissor'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->codcertidaoemissor));
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
        $this->redirect(APP_PESSOAS_URL . '/certidao-emissor');
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
        $this->redirect(APP_PESSOAS_URL . '/certidao-emissor');
		$model=new CertidaoEmissor('search');

		$model->unsetAttributes();  // clear any default values

		if(isset($_GET['CertidaoEmissor']))
			Yii::app()->session['FiltroCertidaoEmissorIndex'] = $_GET['CertidaoEmissor'];

		if (isset(Yii::app()->session['FiltroCertidaoEmissorIndex']))
			$model->attributes=Yii::app()->session['FiltroCertidaoEmissorIndex'];

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

        $this->redirect(APP_PESSOAS_URL . '/certidao-emissor');
		$model=new CertidaoEmissor('search');

		$model->unsetAttributes();  // clear any default values

		if(isset($_GET['CertidaoEmissor']))
			$model->attributes=$_GET['CertidaoEmissor'];

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
        $this->redirect(APP_PESSOAS_URL . '/certidao-emissor');
		$model=CertidaoEmissor::model()->findByPk($id);
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
        $this->redirect(APP_PESSOAS_URL . '/certidao-emissor');
		if(isset($_POST['ajax']) && $_POST['ajax']==='certidao-emissor-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

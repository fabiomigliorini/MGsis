<?php

class TributacaoNaturezaOperacaoController extends Controller
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
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			));
	}

	/**
	* Creates a new model.
	* If creation is successful, the browser will be redirected to the 'view' page.
	*/
	public function actionCreate($codnaturezaoperacao = null, $duplicar = null)
	{
		$model=new TributacaoNaturezaOperacao;
		
		$model->codnaturezaoperacao = $codnaturezaoperacao;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['TributacaoNaturezaOperacao']))
		{
			$model->attributes=$_POST['TributacaoNaturezaOperacao'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->codtributacaonaturezaoperacao));
		}
		else
		{
			
			if (!empty($duplicar))
			{
				$original = $this->loadModel($duplicar);
				
				$model->attributes = $original->attributes;
				
				$model->codtributacaonaturezaoperacao = null;
				$model->codusuariocriacao = null;
				$model->criacao = null;
				$model->codusuarioalteracao = null;
				$model->alteracao = null;
			}
			
			
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
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['TributacaoNaturezaOperacao']))
		{
			$model->attributes=$_POST['TributacaoNaturezaOperacao'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->codtributacaonaturezaoperacao));
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
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			try
			{
				$model = $this->loadModel($id);
				$codnaturezaoperacao = $model->codnaturezaoperacao;
				$model->delete();
				// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
				if(!isset($_GET['ajax']))
					$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('naturezaOperacao/view', 'id'=>$codnaturezaoperacao));
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
		$model=new TributacaoNaturezaOperacao('search');
		
		$model->unsetAttributes();  // clear any default values
		
		if(isset($_GET['TributacaoNaturezaOperacao']))
			Yii::app()->session['FiltroTributacaoNaturezaOperacaoIndex'] = $_GET['TributacaoNaturezaOperacao'];
		
		if (isset(Yii::app()->session['FiltroTributacaoNaturezaOperacaoIndex']))
			$model->attributes=Yii::app()->session['FiltroTributacaoNaturezaOperacaoIndex'];
		
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
	
		$model=new TributacaoNaturezaOperacao('search');
		
		$model->unsetAttributes();  // clear any default values
		
		if(isset($_GET['TributacaoNaturezaOperacao']))
			$model->attributes=$_GET['TributacaoNaturezaOperacao'];

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
		$model=TributacaoNaturezaOperacao::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='tributacao-natureza-operacao-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

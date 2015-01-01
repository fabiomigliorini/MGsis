<?php

class NaturezaOperacaoController extends Controller
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
	public function actionCreate()
	{
		$model=new NaturezaOperacao;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['NaturezaOperacao']))
		{
			$model->attributes=$_POST['NaturezaOperacao'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->codnaturezaoperacao));
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

		if(isset($_POST['NaturezaOperacao']))
		{
			$model->attributes=$_POST['NaturezaOperacao'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->codnaturezaoperacao));
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
		$model=new NaturezaOperacao('search');
		
		$model->unsetAttributes();  // clear any default values
		
		if(isset($_GET['NaturezaOperacao']))
			Yii::app()->session['FiltroNaturezaOperacaoIndex'] = $_GET['NaturezaOperacao'];
		
		if (isset(Yii::app()->session['FiltroNaturezaOperacaoIndex']))
			$model->attributes=Yii::app()->session['FiltroNaturezaOperacaoIndex'];
		
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
	
		$model=new NaturezaOperacao('search');
		
		$model->unsetAttributes();  // clear any default values
		
		if(isset($_GET['NaturezaOperacao']))
			$model->attributes=$_GET['NaturezaOperacao'];

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
		$model=NaturezaOperacao::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='natureza-operacao-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionBuscaObservacoesNf($id, $idantigo, $codfilial, $codfilialantigo)
	{

		$model = $this->loadModel($id);
		$arr["observacoesnf"] = $model->observacoesnf;
		
		$filial = Filial::model()->findByPk($codfilial);
		if ($filial->crt == Filial::CRT_REGIME_NORMAL)
			$arr["observacoesnf"] = null;
		
		$arr["mensagemprocom"] = $model->mensagemprocom;
		$arr["observacoesnfantigo"] = null;
		$arr["mensagemprocomantigo"] = null;
		
		if (!empty($idantigo))
		{
			$modelantigo = $this->loadModel($idantigo);
			$arr["observacoesnfantigo"] = $modelantigo->observacoesnf;
			$filial = Filial::model()->findByPk($codfilialantigo);
			if ($filial->crt == Filial::CRT_REGIME_NORMAL)
				$arr["observacoesnfantigo"] = null;
			$arr["mensagemprocomantigo"] = $modelantigo->mensagemprocom;
		}
		echo CJSON::encode($arr);
		
	}
	
}

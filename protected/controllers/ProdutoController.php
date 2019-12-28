<?php

class ProdutoController extends Controller
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
                $this->redirect(MGLARA_URL . "produto/$id");
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			));
	}

	/**
	* Creates a new model.
	* If creation is successful, the browser will be redirected to the 'view' page.
	*/
	public function actionCreate($barras = "")
	{
                $this->redirect(MGLARA_URL . "produto/create");
		$model=new Produto;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Produto']))
		{
			$model->attributes=$_POST['Produto'];
			if($model->save())
			{
				$model->criaBarras($barras);
				$this->redirect(array('view','id'=>$model->codproduto));
			}
		}
		else
		{
			$model->codtipoproduto = TipoProduto::MERCADORIA;
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
                $this->redirect(MGLARA_URL . "produto/{$id}/edit");
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Produto']))
		{
			$model->attributes=$_POST['Produto'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->codproduto));
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
                $this->redirect(MGLARA_URL . "produto/$id");
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

	public function actionJuntarBarras($id)
	{
                $this->redirect(MGLARA_URL . "produto/$id");
		$model=$this->loadModel($id);

		if(isset($_POST['Produto']))
		{
			$codprodutobarra = $_POST['Produto']['codprodutobarra'];
			$codprodutobarraeliminar = $_POST['Produto']['codprodutobarraeliminar'];

			if (empty($codprodutobarra) || empty($codprodutobarraeliminar))
			{
				$model->addError('codproduto', "Selectione ambos os códigos para prosseguir!");
			}
			elseif (!$pb = ProdutoBarra::model()->findByPk($codprodutobarra))
			{
				$model->addError('codproduto', "Produto Barras $codprodutobarra não localizado.");
			}
			else
			{
				if ($pb->juntarProdutoBarra($codprodutobarraeliminar))
					$this->redirect(array('view','id'=>$model->codproduto));
				else
					$model->addErrors($pb->getErrors());
			}

		}

		$this->render('juntar_barras',array(
			'model'=>$model,
			));

	}

	public function actionTransferirBarras($id)
	{
                $this->redirect(MGLARA_URL . "produto/$id");
		$model=$this->loadModel($id);

		if(isset($_POST['Produto']))
		{

			$codprodutobarra = $_POST['Produto']['codprodutobarra'];
			$codprodutobarranovo = $_POST['Produto']['codprodutobarranovo'];

			if (empty($codprodutobarra) || empty($codprodutobarranovo))
			{
				$model->addError('codproduto', "Selectione ambos os códigos para prosseguir!");
			}
			elseif (!$pb = ProdutoBarra::model()->findByPk($codprodutobarra))
			{
				$model->addError('codproduto', "Produto Barras $codprodutobarra não localizado.");
			}
			else
			{
				if ($pb->transferirProdutoBarra($codprodutobarranovo))
					$this->redirect(array('view','id'=>$model->codproduto));
				else
					$model->addErrors($pb->getErrors());
			}

		}

		$this->render('transferir_barras',array(
			'model'=>$model,
			));

	}

	/**
	* Lists all models.
	*/
	public function actionIndex()
	{
                $this->redirect(MGLARA_URL . 'produto/');

		$model=new Produto('search');

		$model->unsetAttributes();  // clear any default values

		if(isset($_GET['Produto']))
			Yii::app()->session['FiltroProdutoIndex'] = $_GET['Produto'];

		if (isset(Yii::app()->session['FiltroProdutoIndex']))
			$model->attributes=Yii::app()->session['FiltroProdutoIndex'];

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
                $this->redirect(MGLARA_URL . "produto/");

		$model=new Produto('search');

		$model->unsetAttributes();  // clear any default values

		if(isset($_GET['Produto']))
			$model->attributes=$_GET['Produto'];

		$this->render('admin',array(
			'model'=>$model,
			));
	}

	public function actionQuiosqueConsulta ($barras = null)
	{
		$this->redirect(MGLARA_URL . "produto/quiosque");

		if (!empty($barras))
			$model = ProdutoBarra::findByBarras($barras);
		else
			$model = null;

		$this->layout = '//layouts/quiosque';

		$this->render('quiosque_consulta',array(
			'model'=>$model,
			'barras'=>$barras,
			));

	}

	/**
	* Returns the data model based on the primary key given in the GET variable.
	* If the data model is not found, an HTTP exception will be raised.
	* @param integer the ID of the model to be loaded
	*/
	public function loadModel($id)
	{
		$model=Produto::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='produto-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

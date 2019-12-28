<?php

class MarcaController extends Controller
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
		$this->redirect(MGLARA_URL . "marca/$id");
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
		$this->redirect(MGLARA_URL . "marca/create");
		$model=new Marca;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Marca']))
		{
			$model->attributes=$_POST['Marca'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->codmarca));
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
		$this->redirect(MGLARA_URL . "marca/{$id}/edit");
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Marca']))
		{
			$model->attributes=$_POST['Marca'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->codmarca));
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
		$this->redirect(MGLARA_URL . "marca/$id");
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
		$this->redirect(MGLARA_URL . 'marca/');
		$model=new Marca('search');
		
		$model->unsetAttributes();  // clear any default values
		
		if(isset($_GET['Marca']))
			Yii::app()->session['FiltroMarcaIndex'] = $_GET['Marca'];
		
		if (isset(Yii::app()->session['FiltroMarcaIndex']))
			$model->attributes=Yii::app()->session['FiltroMarcaIndex'];
		
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
		$this->redirect(MGLARA_URL . "marca/");
		$model=new Marca('search');
		
		$model->unsetAttributes();  // clear any default values
		
		if(isset($_GET['Marca']))
			$model->attributes=$_GET['Marca'];

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
		$model=Marca::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='marca-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionAjaxBuscaMarca($texto, $limite=20, $pagina=1) 
	{

		
		// corrige pagina se veio sujeira
		if ($pagina < 1) $pagina = 1;

		// calcula de onde continuar a consulta
		$offset = ($pagina-1)*$limite;
		
		// inicializa array com resultados
		$resultados = array();

		// se o texto foi preenchido
		if (strlen($texto)>=1)
		{
			
			// busca pelos campos "fantasia" e "pessoa" 
			$condition = 'marca ILIKE :marca';
			$params = array(
				':marca'=>'%'.$texto.'%',
				);
			
			// busca pessoas
			$registros = Marca::model()->findAll(
					array(
						'select'=>'codmarca, marca', 
						'order'=>'marca', 
						'condition'=>$condition, 
						'params'=>$params,
						'limit'=>$limite,
						'offset'=>$offset,
						)
					);
			
			//monta array com resultados
			foreach ($registros as $registro) 
			{
				$resultados[] = array(
					'id' => $registro->codmarca,
					'marca' => $registro->marca,
					);
			}
			
		} 
		
		// transforma o array em JSON
		echo CJSON::encode(
				array(
					'mais' => count($resultados)==$limite?true:false, 
					'pagina' => (int) $pagina, 
					'itens' => $resultados
					)
				);
		
		// FIM
		Yii::app()->end();
	} 
	
	public function actionAjaxInicializaMarca($cod) 
	{
		$model = $this->loadModel($cod);
		echo CJSON::encode(
			array(
				'id' => $model->codmarca,
				'marca' => $model->marca
			)
		);
		Yii::app()->end();
	} 
	
}

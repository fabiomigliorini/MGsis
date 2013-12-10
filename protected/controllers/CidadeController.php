<?php

class CidadeController extends Controller
{
	/**
	* @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	* using two-column layout. See 'protected/views/layouts/column2.php'.
	*/
	public $layout='//layouts/column1';

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
		$model=new Cidade;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Cidade']))
		{
			$model->attributes=$_POST['Cidade'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->codcidade));
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

		if(isset($_POST['Cidade']))
		{
			$model->attributes=$_POST['Cidade'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->codcidade));
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
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	* Lists all models.
	*/
	public function actionIndex()
	{
		
		$model=new Cidade('search');
		
		$model->unsetAttributes();  // clear any default values
		
		if(isset($_GET['Cidade']))
			$model->attributes=$_GET['Cidade'];

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
	
		$model=new Cidade('search');
		
		$model->unsetAttributes();  // clear any default values
		
		if(isset($_GET['Cidade']))
			$model->attributes=$_GET['Cidade'];

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
		$model=Cidade::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='cidade-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionAjaxBuscaCidade() 
	{

		// variaveis _GET 
		$texto  = str_replace(' ', '%', trim(isset($_GET['texto'])?$_GET['texto']:''));
		$limite = isset($_GET['limite'])?$_GET['limite']:20;
		$pagina = isset($_GET['pagina'])?$_GET['pagina']:1;

		// corrige pagina se veio sujeira
		if ($pagina < 1) $pagina = 1;

		// calcula de onde continuar a consulta
		$offset = ($pagina-1)*$limite;
		
		// inicializa array com resultados
		$resultados = array();

		// se o texto foi preenchido
		if (strlen($texto)>=3)
		{
			
			// busca pelos campos "fantasia" e "pessoa" 
			$condition = 'cidade ILIKE :cidade';
			$params = array(
				':cidade'=>'%'.$texto.'%',
				);
			
			// busca pessoas
			$registros = Cidade::model()->findAll(
					array(
						'select'=>'codcidade, cidade', 
						'order'=>'cidade', 
						'condition'=>$condition, 
						'with'=>array("Estado"=>array("select"=>"sigla")),
						'params'=>$params,
						'limit'=>$limite,
						'offset'=>$offset,
						)
					);
			
			//monta array com resultados
			foreach ($registros as $registro) 
			{
				$resultados[] = array(
					'id' => $registro->codcidade,
					'cidade' => $registro->cidade,
					'uf' => $registro->Estado->sigla,
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
	
	public function actionAjaxInicializaCidade() 
	{
		if (isset($_GET['cod']))
		{
			$model = Cidade::model()->findByPk(
					$_GET['cod'],
					array(
						'select'=>'codcidade, cidade', 
						'with'=>'Estado',
						)
					);
			echo CJSON::encode(array('id' => $model->codcidade,'cidade' => $model->cidade,'uf' => $model->Estado->sigla));
		}
		Yii::app()->end();
	} 
	
}

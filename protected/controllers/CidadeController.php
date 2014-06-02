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
	public function actionCreate($codestado)
	{
		$model=new Cidade;
		
		$model->codestado = $codestado;

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
			try 
			{
				$model = $this->loadModel($id);
				$codestado = $model->codestado;
				$model->delete();
				// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
				if(!isset($_GET['ajax']))
					$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('estado/view', 'id'=>$codestado));
			} 
			catch (Exception $ex)
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
		$model=new Cidade('search');
		
		$model->unsetAttributes();  // clear any default values
		
		if(isset($_GET['Cidade']))
			Yii::app()->session['FiltroCidadeIndex'] = $_GET['Cidade'];
		
		if (isset(Yii::app()->session['FiltroCidadeIndex']))
			$model->attributes=Yii::app()->session['FiltroCidadeIndex'];

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
		$id = null;
		$cidade = null;
		$uf = null;
		
		if (isset($_GET['cod']))
		{
			try {
				$model = Cidade::model()->findByPk(
						$_GET['cod'],
						array(
							'select'=>'codcidade, cidade', 
							'with'=>'Estado',
							)
						);
				$id = $model->codcidade;
				$cidade = $model->cidade;
				$uf = $model->Estado->sigla;
			} catch (Exception $e) {
			}			
		}
		echo CJSON::encode(array('id' => $id,'cidade' => $cidade,'uf' => $uf));
		Yii::app()->end();
	} 

	public function actionAjaxBuscaPeloNome() 
	{
		$codcidade = null;
		if (isset($_GET['uf']) and isset($_GET['cidade']))
		{
			if ($estado = Estado::model()->find(array('select' => 'codestado', 'condition'=>'sigla ilike :uf', 'params'=>array(':uf'=>$_GET['uf']))))
			{
				$cidades = $estado->Cidades(array('select' => 'codcidade', 'condition'=>'cidade ilike :cidade', 'params'=>array(':cidade'=>MGFormatter::removeAcentos($_GET['cidade']))));
				if (isset($cidades[0]->codcidade))
					$codcidade = $cidades[0]->codcidade;
			}
		}
		echo CJSON::encode(array('codcidade' => $codcidade));
		Yii::app()->end();
	} 
	
}

<?php

class PessoaController extends Controller
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
		$model=new Pessoa;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Pessoa']))
		{
			$model->attributes=$_POST['Pessoa'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->codpessoa));
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

		if(isset($_POST['Pessoa']))
		{
			$model->attributes=$_POST['Pessoa'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->codpessoa));
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
		$model=new Pessoa('search');
		
		$model->unsetAttributes();  // clear any default values
		
		if(isset($_GET['Pessoa']))
			Yii::app()->session['FiltroPessoaIndex'] = $_GET['Pessoa'];
		
		if (isset(Yii::app()->session['FiltroPessoaIndex']))
			$model->attributes=Yii::app()->session['FiltroPessoaIndex'];
		
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
	
		$model=new Pessoa('search');
		
		$model->unsetAttributes();  // clear any default values
		
		if(isset($_GET['Pessoa']))
			$model->attributes=$_GET['Pessoa'];

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
		$model=Pessoa::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='pessoa-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionAjaxBuscaPessoa($texto, $limite=20, $pagina=1, $inativo = 0, $vendedor = 0) 
	{

		// variaveis _GET 
		//$texto  = str_replace(' ', '%', trim(isset($_GET['texto'])?$_GET['texto']:''));
		$texto  = str_replace(' ', '%', trim($texto));
		//$limite = isset($_GET['limite'])?$_GET['limite']:20;
		//$pagina = isset($_GET['pagina'])?$_GET['pagina']:1;

		// corrige pagina se veio sujeira
		if ($pagina < 1) $pagina = 1;

		// calcula de onde continuar a consulta
		$offset = ($pagina-1)*$limite;
		
		// inicializa array com resultados
		$resultados = array();

		// se o texto foi preenchido
		if (strlen($texto)>=3)
		{
			
			// somente pessoas ativas
			$condition = 'inativo is null and ';
			
			// se quiser inativas limpa o filtro de ativas
			if (isset($_GET['inativo']) && $_GET['inativo'])
					$condition = '';
			
			if (!empty($vendedor))
				$condition .= "vendedor = true AND ";
			
			// busca pelos campos "fantasia" e "pessoa" 			
			$condition .= '(fantasia ILIKE :fantasia OR pessoa ILIKE :pessoa ';
			
			$params = array(
				':fantasia'=>'%'.$texto.'%',
				':pessoa'=>'%'.$texto.'%',
				);
			
			// se o texto for um numero busca pelo "codpessoa" e "cnpj"
			$numero = (int)MGFormatter::numeroLimpo($texto);
			if ($numero > 0) 
			{
				$condition .= ' OR codpessoa = :codpessoa OR cast(Cnpj as char(20)) ILIKE :cnpj';
				$params = array_merge(
						$params, 
						array(
							':codpessoa'=>$numero,
							':cnpj'=>$numero.'%',
							)
						);
			}
			$condition .= ')';
			
			// busca pessoas
			$pessoas = Pessoa::model()->findAll(
					array(
						'select'=>'codpessoa, fantasia, pessoa, cnpj, inativo', 
						'order'=>'fantasia', 
						'condition'=>$condition, 
						'params'=>$params,
						'limit'=>$limite,
						'offset'=>$offset,
						)
					);
			
			//monta array com resultados
			foreach ($pessoas as $pessoa) 
			{
				$resultados[] = array(
					'id' => $pessoa->codpessoa,
					'fantasia' => $pessoa->fantasia,
					'pessoa' => $pessoa->pessoa,
					'cnpj' => $pessoa->cnpj,
					'inativo' => !empty($pessoa->inativo),
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
	
	public function actionAjaxInicializaPessoa() 
	{
		if (isset($_GET['cod']))
		{
			$pessoa = Pessoa::model()->findByPk(
					$_GET['cod'],
					array(
						'select'=>'codpessoa, fantasia', 
						'order'=>'fantasia', 
						)
					);
			echo CJSON::encode(array('id' => $pessoa->codpessoa,'fantasia' => $pessoa->fantasia));
		}
		Yii::app()->end();
	} 
	
	public function actionDetalhes($codpessoa)
	{
		$model = $this->loadModel($codpessoa);
		echo CJSON::encode($model->attributes);
	}
	
}

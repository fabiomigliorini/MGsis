<?php

class NcmController extends Controller
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
		$model=new Ncm;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Ncm']))
		{
			$model->attributes=$_POST['Ncm'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->codncm));
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

		if(isset($_POST['Ncm']))
		{
			$model->attributes=$_POST['Ncm'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->codncm));
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
	public function actionIndex($id = null)
	{
		if (isset($id))
			$ncm = $this->loadModel ($id);
		
		$caps = Ncm::model()->raiz()->findAll();
		
		$this->render('index',array(
			'ncm'=>isset($ncm)?$ncm:null,
			'caps'=>$caps,
			'id'=>$id,
			));
	}

	/**
	* Manages all models.
	*/
	public function actionAdmin()
	{
	
		$model=new Ncm('search');
		
		$model->unsetAttributes();  // clear any default values
		
		if(isset($_GET['Ncm']))
			$model->attributes=$_GET['Ncm'];

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
		$model=Ncm::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='ncm-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionAjaxBuscaNcm($texto, $limite=20, $pagina=1) 
	{

		$texto  = str_replace(' ', '%', trim($texto));

		// corrige pagina se veio sujeira
		if ($pagina < 1) $pagina = 1;

		// calcula de onde continuar a consulta
		$offset = ($pagina-1)*$limite;
		
		// inicializa array com resultados
		$resultados = array();

		// se o texto foi preenchido
		if (strlen($texto)>=2)
		{
			
			// busca pelos campos "descricao" e "ncm" 			
			$condition = '(descricao ILIKE :descricao OR ncm ILIKE :ncm)';
			
			$params = array(
				':descricao'=>'%'.$texto.'%',
				':ncm'=>$texto.'%',
				);
			
			
			// busca ncms
			$ncms = Ncm::model()->findAll(
					array(
						'select'=>'codncm, ncm, descricao', 
						'order'=>'ncm ASC', 
						'condition'=>$condition, 
						'params'=>$params,
						'limit'=>$limite,
						'offset'=>$offset,
						)
					);
			
			//monta array com resultados
			foreach ($ncms as $ncm) 
			{
				$resultados[] = array(
					'id' => $ncm->codncm,
					'ncm' => Yii::app()->format->formataNcm($ncm->ncm),
					'descricao' => $ncm->descricao,
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
	
	public function actionAjaxInicializaNcm() 
	{
		if (isset($_GET['cod']))
		{
			$ncm = Ncm::model()->findByPk(
					$_GET['cod'],
					array(
						'select'=>'codncm, ncm, descricao', 
						'order'=>'ncm', 
						)
					);
			echo CJSON::encode(array('id' => $ncm->codncm,'ncm' => Yii::app()->format->formataNcm($ncm->ncm), 'descricao' => $ncm->descricao));
		}
		Yii::app()->end();
	} 
	
}

<?php

class TituloController extends Controller
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
		$model=new Titulo;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Titulo']))
		{
			$model->attributes=$_POST['Titulo'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->codtitulo));
		}
		else
		{
			if (isset($_GET["duplicar"]))
			{
				$original = $this->loadModel($_GET["duplicar"]);
				//$model->attributes = $original->attributes;
				$model->codtitulo = null;
				$model->codnegocioformapagamento = null;
				$model->codtituloagrupamento = null;
				
				$model->codfilial = $original->codfilial;
				$model->codpessoa = $original->codpessoa;
				$model->numero = $original->numero;
				$model->fatura = $original->fatura;
				$model->codtipotitulo = $original->codtipotitulo;
				$model->valor = $original->valor;
				$model->boleto = $original->boleto;
				$model->vencimento = $original->vencimento;
				$model->vencimentooriginal = $original->vencimentooriginal;
				$model->emissao = $original->emissao;
				$model->transacao = $original->transacao;
				$model->gerencial = $original->gerencial;
				$model->codcontacontabil = $original->codcontacontabil;
				$model->observacao = $original->observacao;
				
			}
			else
			{
				$model->emissao = date('d/m/Y');
				$model->transacao = date('d/m/Y');
			}
		}

		$this->render('create',array('model'=>$model,));
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

		if(isset($_POST['Titulo']))
		{
			$model->attributes=$_POST['Titulo'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->codtitulo));
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
	/*
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
	 * 
	 */
	public function actionEstorna($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow estorna via POST request
			$model = $this->loadModel($id);
			if (!$model->estorna())
				Yii::app()->user->setFlash("error", "Impossível estornar Título!");
			else
				Yii::app()->user->setFlash("success", "Título estornado!");
			
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('view','id'=>$model->codtitulo));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	
	/**
	* Lists all models.
	*/
	public function actionIndex()
	{
		$model=new Titulo('search');
		
		$model->unsetAttributes();  // clear any default values
		
		if(isset($_GET['Titulo']))
			Yii::app()->session['FiltroTituloIndex'] = $_GET['Titulo'];
		
		if (isset(Yii::app()->session['FiltroTituloIndex']))
			$model->attributes=Yii::app()->session['FiltroTituloIndex'];
		
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
	
		$model=new Titulo('search');
		
		$model->unsetAttributes();  // clear any default values
		
		if(isset($_GET['Titulo']))
			$model->attributes=$_GET['Titulo'];

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
		$model=Titulo::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='titulo-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function geraBoleto($model)
	{
		
		if (!$model->boleto)
			throw new CHttpException(400,'Este título não é um boleto.');
		
		if ($model->saldo <= 0)
			throw new CHttpException(400,'Título sem saldo.');
		
		$boleto = new MGBoleto($model);
		
		echo $boleto->getOutput();
		
	}
	
	public function actionImprimeBoleto($id = null, $codtituloagrupamento = null)
	{	
		if (!empty($id))
		{
			$model = $this->loadModel($id);
			$this->geraBoleto($model);
		}
		elseif (!empty($codtituloagrupamento))
		{
			$ta = TituloAgrupamento::model()->findByPk($codtituloagrupamento);
			
			if($ta===null)
				throw new CHttpException(404,'The requested page does not exist.');
			
			foreach($ta->Titulos as $model)
				$this->geraBoleto($model);
		}
		
	}
	
	public function actionImprimeVale($id, $imprimir = false)
	{
		
		$model = $this->loadModel($id);
		
		if ($model->saldo >= 0)
			throw new CHttpException(400,'Título sem saldo.');
		
		$rel = new MGEscPrintVale($model);
		$rel->quebralaser =2;
		$rel->prepara();
		
		if ($imprimir)
			$rel->imprimir();
		
		echo $rel->converteHtml();
		
	}

	public function actionRelatorio()
	{
		
		$model=new Titulo('search');
		
		$model->unsetAttributes();  // clear any default values
		
		if(isset($_GET['Titulo']))
			Yii::app()->session['FiltroTituloIndex'] = $_GET['Titulo'];
		
		if (isset(Yii::app()->session['FiltroTituloIndex']))
			$model->attributes=Yii::app()->session['FiltroTituloIndex'];
		
		$titulos = $model->search(false);
		
		$rel = new MGRelatorioTitulos($titulos);
		$rel->montaRelatorio();
		$rel->Output();
		
	}
	
	public function actionBuscaOperacaoTipoTitulo ()
	{
		if (!empty($_GET["codtipotitulo"]))
			$codtipotitulo = $_GET["codtipotitulo"];
		else
			throw new CHttpException(400,'codtipotitulo não informado.');
		
		$model=TipoTitulo::model()->findByPk($codtipotitulo);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		
		if ($model->credito)
			$retorno = array("operacao" => "CR");
		else
			$retorno = array("operacao" => "DB");

		echo json_encode($retorno);
		
	}
	
	public function actionAjaxBuscaTitulo(
		$modelname = null,
		$campo = null,
		array $GridTitulos = null,
		$codpessoa=0
		) 
	{
		
		if (empty($GridTitulos))
			$GridTitulos = array();
		
		$this->widget('MGGridTitulos', array(
			'modelname'   => $modelname,
			'campo'		  => $campo,
			'GridTitulos' => $GridTitulos,
			'codpessoa'   => $codpessoa,
		));
		
	} 
	
}
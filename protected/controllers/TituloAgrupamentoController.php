<?php

class TituloAgrupamentoController extends Controller
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
		$model=new TituloAgrupamento;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['TituloAgrupamento']))
		{
			$model->attributes=$_POST['TituloAgrupamento'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->codtituloagrupamento));
			
		}
		else
		{
			$model->emissao  = date('d/m/Y');	
			$model->parcelas = 1;
			$model->primeira = 15;
			$model->demais   = 30;
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
	/*
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['TituloAgrupamento']))
		{
			$model->attributes=$_POST['TituloAgrupamento'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->codtituloagrupamento));
		}

		$this->render('update',array(
			'model'=>$model,
			));
	}
	 * 
	 */

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
	*/
	
	public function actionEstorna($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow estorna via POST request
			$model = $this->loadModel($id);
			if (!$model->estorna())
				Yii::app()->user->setFlash("error", "Erro ao estornar Agrupamento de Títulos!");
			else
				Yii::app()->user->setFlash("success", "Agrupamento de Títulos Estornado!");
			
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('view','id'=>$model->codtituloagrupamento));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	
	/**
	* Lists all models.
	*/
	public function actionIndex()
	{
		$model=new TituloAgrupamento('search');
		
		$model->unsetAttributes();  // clear any default values
		
		if(isset($_GET['TituloAgrupamento']))
			Yii::app()->session['FiltroTituloAgrupamentoIndex'] = $_GET['TituloAgrupamento'];
		
		if (isset(Yii::app()->session['FiltroTituloAgrupamentoIndex']))
			$model->attributes=Yii::app()->session['FiltroTituloAgrupamentoIndex'];
		
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
	
		$model=new TituloAgrupamento('search');
		
		$model->unsetAttributes();  // clear any default values
		
		if(isset($_GET['TituloAgrupamento']))
			$model->attributes=$_GET['TituloAgrupamento'];

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
		$model=TituloAgrupamento::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='titulo-agrupamento-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionRelatorio($id)
	{
		$model = $this->loadModel($id);
		$rel = new MGRelatorioTituloAgrupamento($model);
		$rel->montaRelatorio();
		$rel->Output();
	}
	
	public function actionGeraNotaFiscal($id, $modelo = null, $codnotafiscal = null)
	{

		$command = Yii::app()->db->createCommand(' 
			SELECT distinct nfp.codnegocio
			  FROM tbltituloagrupamento ta
			 INNER JOIN tblmovimentotitulo mt ON (mt.codtituloagrupamento = ta.codtituloagrupamento)
			 INNER JOIN tbltitulo t ON (t.codtitulo = mt.codtitulo)
			 INNER JOIN tblnegocioformapagamento nfp ON (nfp.codnegocioformapagamento = t.codnegocioformapagamento)
			 WHERE ta.codtituloagrupamento = :codtituloagrupamento
			');

		$command->params = array("codtituloagrupamento" => $id);

		$codnegocios = $command->queryAll();
		
		if (empty($codnegocios))
		{
			$retorno["Retorno"] = 0;
			$retorno["Mensagem"] = "Nao foi possível localizar nenhum negócio vinculado ao fechamento!";
			
		}

		foreach ($codnegocios as $codnegocio)
		{
			$negocio = Negocio::model()->findByPk($codnegocio);
			
			$retorno = array("Retorno"=>1, "Mensagem"=>"", "codnotafiscal" =>$codnotafiscal);

			if (!$codnotafiscal = $negocio->geraNotaFiscal($codnotafiscal, $modelo, false))
			{
				$retorno["Retorno"] = 0;
				$erros = $negocio->getErrors();
				$erro = "Erro ao Gerar Nota Fiscal!";
				foreach ($erros as $campo => $mensagens)
					foreach($mensagens as $mensagem)
						$erro .= " " . $mensagem;
				$retorno["Mensagem"] = $erro;
				
				break;

			}

			$retorno["codnotafiscal"] = $codnotafiscal;
		}
		
		/*
		$negocio = $this->loadModel($id);
		
		$retorno = array("Retorno"=>1, "Mensagem"=>"", "codnotafiscal" =>$codnotafiscal);
		
		if (!$codnotafiscal = $negocio->geraNotaFiscal($codnotafiscal, $modelo, true))
		{
			$retorno["Retorno"] = 0;
			$erros = $negocio->getErrors();
			$erro = "Erro ao Gerar Nota Fiscal!";
			foreach ($erros as $campo => $mensagens)
				foreach($mensagens as $mensagem)
					$erro .= " " . $mensagem;
			$retorno["Mensagem"] = $erro;
			
		}
		
		$retorno["codnotafiscal"] = $codnotafiscal;
		 * 
		 */
		
		echo CJSON::encode($retorno);
		
	}
	
}

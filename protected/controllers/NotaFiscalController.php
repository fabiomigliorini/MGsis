<?php

class NotaFiscalController extends Controller
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
		$model=new NotaFiscal;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);
		
		//$model->codusuario = Yii::app()->user->id;
		$model->emissao = date('d/m/Y');
		$model->saida = date('d/m/Y');
		$model->codfilial = Yii::app()->user->getState("codfilial");
		$model->serie = 1;
		$model->numero = 0;
		
		if(isset($_POST['NotaFiscal']))
		{
			$model->attributes=$_POST['NotaFiscal'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->codnotafiscal));
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
		
		if (!$model->podeEditar())
			throw new CHttpException(409, 'Nota Fiscal não permite edição!');


		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['NotaFiscal']))
		{
			$model->attributes=$_POST['NotaFiscal'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->codnotafiscal));
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
				
				if (!$model->podeEditar())
					throw new CHttpException(409, 'Nota Fiscal não permite exclusão!');
				
				$model->delete();
					
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
		$model=new NotaFiscal('search');
		
		$model->unsetAttributes();  // clear any default values
		
		if(isset($_GET['NotaFiscal']))
			Yii::app()->session['FiltroNotaFiscalIndex'] = $_GET['NotaFiscal'];
		
		if (isset(Yii::app()->session['FiltroNotaFiscalIndex']))
			$model->attributes=Yii::app()->session['FiltroNotaFiscalIndex'];
		
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
	
		$model=new NotaFiscal('search');
		
		$model->unsetAttributes();  // clear any default values
		
		if(isset($_GET['NotaFiscal']))
			$model->attributes=$_GET['NotaFiscal'];

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
		$model=NotaFiscal::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='nota-fiscal-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionEnviarNfe($id)
	{
		$model = $this->loadModel($id);
		$acbr = new MGAcbrNfeMonitor($model);
		
		$res = false;
		
		if ($acbr->criarNFe()) 
			$res = $acbr->enviarNfe();
		
		echo CJSON::encode(
			array(
				'id' => $id,
				'resultado' => $res,
				'retornoMonitor' => $acbr->retornoMonitor["Mensagem"],
				'erroMonitor' => htmlentities($acbr->erroMonitor),
				'retorno' => htmlentities($acbr->retorno),
			)
		);
		
	}

	public function actionConsultarNfe($id)
	{
		$model = $this->loadModel($id);
		$acbr = new MGAcbrNfeMonitor($model);
		
		$res = $acbr->consultarNfe();
		
		echo CJSON::encode(
			array(
				'id' => $id,
				'resultado' => $res,
				'retornoMonitor' => $acbr->retornoMonitor["Mensagem"],
				'erroMonitor' => htmlentities($acbr->erroMonitor),
				'retorno' => htmlentities($acbr->retorno),
			)
		);
		
	}

	public function actionEnviarEmail($id, $email, $alterarcadastro = false)
	{
		$model = $this->loadModel($id);
		$acbr = new MGAcbrNfeMonitor($model);
		
		$res = $acbr->enviarEmail($email, $alterarcadastro);
		
		echo CJSON::encode(
			array(
				'id' => $id,
				'resultado' => $res,
				'retornoMonitor' => $acbr->retornoMonitor["Mensagem"],
				'erroMonitor' => htmlentities($acbr->erroMonitor),
				'retorno' => htmlentities($acbr->retorno),
			)
		);
		
	}
	
	public function actionCancelarNfe($id, $justificativa)
	{
		$model = $this->loadModel($id);
		$acbr = new MGAcbrNfeMonitor($model);
		
		$res = $acbr->cancelarNfe($justificativa);
		
		echo CJSON::encode(
			array(
				'id' => $id,
				'resultado' => $res,
				'retornoMonitor' => $acbr->retornoMonitor["Mensagem"],
				'erroMonitor' => htmlentities($acbr->erroMonitor),
				'retorno' => htmlentities($acbr->retorno),
			)
		);
		
	}

	public function actionInutilizarNfe($id, $justificativa)
	{
		$model = $this->loadModel($id);
		$acbr = new MGAcbrNfeMonitor($model);
		
		$res = $acbr->inutilizarNfe($justificativa);
		
		echo CJSON::encode(
			array(
				'id' => $id,
				'resultado' => $res,
				'retornoMonitor' => $acbr->retornoMonitor["Mensagem"],
				'erroMonitor' => htmlentities($acbr->erroMonitor),
				'retorno' => htmlentities($acbr->retorno),
			)
		);
		
	}	
	
	public function actionImprimirDanfePdf($id, $imprimir = false)
	{
		$model = $this->loadModel($id);
		$acbr = new MGAcbrNfeMonitor($model);
		
		$res = $acbr->imprimirDanfePdf();
		//$res = $acbr->imprimirDanfe();
		
		if ($res && $imprimir && $model->modelo == NotaFiscal::MODELO_NFCE)
			$acbr->imprimirDanfePdfTermica ();
		
		echo CJSON::encode(
			array(
				'id' => $id,
				'resultado' => $res,
				'retornoMonitor' => $acbr->retornoMonitor["Mensagem"],
				'erroMonitor' => htmlentities($acbr->erroMonitor),
				'retorno' => htmlentities($acbr->retorno),
			)
		);
		
	}
	
	public function actionCartaCorrecao($id, $texto)
	{
		$model = $this->loadModel($id);
		$acbr = new MGAcbrNfeMonitor($model);
		
		$res = $acbr->cartaCorrecao($texto);
		
		echo CJSON::encode(
			array(
				'id' => $id,
				'resultado' => $res,
				'retornoMonitor' => $acbr->retornoMonitor["Mensagem"],
				'erroMonitor' => htmlentities($acbr->erroMonitor),
				'retorno' => htmlentities($acbr->retorno),
			)
		);
		
	}

	public function actionRelatorio()
	{
		
		$model=new NotaFiscal('search');
		
		$model->unsetAttributes();  // clear any default values
		
		if(isset($_GET['NotaFiscal']))
			Yii::app()->session['FiltroNotaFiscalIndex'] = $_GET['NotaFiscal'];
		
		if (isset(Yii::app()->session['FiltroNotaFiscalIndex']))
			$model->attributes=Yii::app()->session['FiltroNotaFiscalIndex'];
		
		$notasfiscais = $model->search(false);
		
		$rel = new MGRelatorioNotasFiscais($notasfiscais);
		$rel->montaRelatorio();
		$rel->Output();
		 
		
	}
	
}

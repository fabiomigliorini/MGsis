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
	public function actionCreate($duplicar = null)
	{
		$model=new NotaFiscal;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);
		
		
		$model->emissao = date('d/m/Y');
		$model->saida = date('d/m/Y');
		$model->serie = 1;
		$model->numero = 0;
		$model->codfilial = Yii::app()->user->getState("codfilial");
		$model->modelo = NotaFiscal::MODELO_NFE;
		
		if(isset($_POST['NotaFiscal']))
		{
			$model->attributes=$_POST['NotaFiscal'];
			if ($model->save())
			{
				if (!empty($duplicar))
				{
					$original = $this->loadModel($duplicar);
					
					//duplica produtos
					foreach ($original->NotaFiscalProdutoBarras as $prod_orig)
					{
						$prod_novo = new NotaFiscalProdutoBarra;
						$prod_novo->attributes = $prod_orig->attributes;
						$prod_novo->codnotafiscalprodutobarra = null;
						$prod_novo->codnotafiscal = $model->codnotafiscal;
						$prod_novo->codcfop = null;
						$prod_novo->csosn = null;
						$prod_novo->criacao = null;
						$prod_novo->codusuariocriacao = null;
						$prod_novo->alteracao = null;
						$prod_novo->codusuarioalteracao = null;
						$prod_novo->save();
					}

					//duplica produtos
					foreach ($original->NotaFiscalDuplicatass as $dupl_orig)
					{
						$dupl_novo = new NotaFiscalDuplicatas;
						$dupl_novo->attributes = $dupl_orig->attributes;
						$dupl_novo->codnotafiscalduplicatas = null;
						$dupl_novo->codnotafiscal = $model->codnotafiscal;
						$dupl_novo->criacao = null;
						$dupl_novo->codusuariocriacao = null;
						$dupl_novo->alteracao = null;
						$dupl_novo->codusuarioalteracao = null;
						$dupl_novo->save();
					}
					
				}
				$this->redirect(array('view','id'=>$model->codnotafiscal));
			}
		}
		else
		{
			
			if (!empty($duplicar))
			{
				$original = $this->loadModel($duplicar);
				
				$model->attributes = $original->attributes;
				
				$model->codnotafiscal = null;
				$model->nfechave = null;
				$model->nfereciboenvio = null;
				$model->nfedataenvio = null;
				$model->nfeautorizacao = null;
				$model->nfedataautorizacao = null;
				$model->nfecancelamento = null;
				$model->nfedatacancelamento = null;
				$model->nfeinutilizacao = null;
				$model->nfedatainutilizacao = null;
				$model->justificativa = null;
				$model->codusuariocriacao = null;
				$model->criacao = null;
				$model->codusuarioalteracao = null;
				$model->alteracao = null;
				$model->emissao = date('d/m/Y');
				$model->saida = date('d/m/Y');
				$model->serie = 1;
				$model->numero = 0;
				
				$model->codstatus = NotaFiscal::CODSTATUS_NOVA;
			}
			
			
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
				
				foreach ($model->NotaFiscalDuplicatass as $dup)
					$dup->delete();
				
				foreach ($model->NotaFiscalProdutoBarras as $prod)
					$prod->delete();
				
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
	
	public function actionRobo($codfilial)
	{
		
		$codnotafiscal = 0;
		
		if (isset(Yii::app()->session["NotaFiscalRobo$codfilial"]))
			$codnotafiscal = Yii::app()->session["NotaFiscalRobo$codfilial"];
		
		$model = NotaFiscal::model()->find(
			'  	t.emitida = true 
			and t.numero > 0 
			and t.nfeautorizacao is null 
			and t.nfecancelamento is null 
			and t.nfeinutilizacao is null
			and t.codfilial = :codfilial
			and t.codnotafiscal > :codnotafiscal
			',
			array(
				":codfilial" => $codfilial,
				":codnotafiscal" => $codnotafiscal,
			)
		);

		echo "<pre>";
		
		$res = false;
		
		if($model===null)
		{
			Yii::app()->session["NotaFiscalRobo$codfilial"] = 0;
		}
		else
		{
			Yii::app()->session["NotaFiscalRobo$codfilial"] = $model->codnotafiscal;
			
			$acbr = new MGAcbrNfeMonitor($model);

			$res = false;

			if ($acbr->criarNFe()) 
				$res = $acbr->enviarNfe();

			$email = $model->Pessoa->emailnfe;
			$resEmail = false;

			$retornoEnvio = null;
			
			if ($res)
			{
				$resPdf = $acbr->imprimirDanfePdf();

				if (empty($email))
					$email = $model->Pessoa->email;
				if (empty($email))
					$email = $model->Pessoa->emailcobranca;

				if (!empty($email))
					$resEmail = $acbr->enviarEmail($email);

			}
			else
			{
				$retornoEnvio = $acbr->retorno;
				$res = $acbr->consultarNfe();
			}
			
			
			$arrRet = array(
				'id' => $model->codnotafiscal,
				'resultado' => $res,
				'email' => $email,
				'resultadoEmail' => $resEmail,
				'modelo' => $model->modelo,
				'retornoMonitor' => $acbr->retornoMonitor["Mensagem"],
				'erroMonitor' => htmlentities($acbr->erroMonitor),
				'retorno' => htmlentities($acbr->retorno),
				'retornoEnvio' => $retornoEnvio,
				'urlpdf' => $acbr->urlpdf,
			);
			
			print_r($arrRet);
		}
		
		echo "</pre>";
		echo "<script>\n";
		echo "window.setTimeout('location.reload()', 10000); //reloads after 3 seconds\n";
		echo "</script>\n";
			
	}
	
	public function actionEnviarNfe($id)
	{
		$model = $this->loadModel($id);
		$acbr = new MGAcbrNfeMonitor($model);
		
		$res = false;
		
		if ($acbr->criarNFe()) 
			$res = $acbr->enviarNfe();
		
		$email = $model->Pessoa->emailnfe;
		$resEmail = false;
		
		if ($res)
		{
			$resPdf = $acbr->imprimirDanfePdf();
			
			if (empty($email))
				$email = $model->Pessoa->email;
			if (empty($email))
				$email = $model->Pessoa->emailcobranca;
			
			if (!empty($email))
				$resEmail = $acbr->enviarEmail($email);
			
			$acbr->imprimirDanfePdfTermica();
		}
		
		
		echo CJSON::encode(
			array(
				'id' => $id,
				'resultado' => $res,
				'email' => $email,
				'resultadoEmail' => $resEmail,
				'modelo' => $model->modelo,
				'retornoMonitor' => $acbr->retornoMonitor["Mensagem"],
				'erroMonitor' => htmlentities($acbr->erroMonitor),
				'retorno' => htmlentities($acbr->retorno),
				'urlpdf' => $acbr->urlpdf,
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
				'urlpdf' => $acbr->urlpdf,
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

<?php

class NfeTerceiroController extends Controller
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
	/*
	public function actionCreate()
	{
		$model=new NfeTerceiro;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['NfeTerceiro']))
		{
			$model->attributes=$_POST['NfeTerceiro'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->codnfeterceiro));
		}

		$this->render('create',array(
			'model'=>$model,
			));
	}
	*/

	/**
	* Updates a particular model.
	* If update is successful, the browser will be redirected to the 'view' page.
	* @param integer $id the ID of the model to be updated
	*/
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		
		if (!$model->podeEditar())
			throw new CHttpException(409, 'Registro não permite edição.');

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['NfeTerceiro']))
		{
			$model->attributes=$_POST['NfeTerceiro'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->codnfeterceiro));
		}

		$this->render('update',array(
			'model'=>$model,
			));
	}
	
	public function actionImportar($id)
	{
		$model=$this->loadModel($id);
		
		if ($model->importar())
		{
			Yii::app()->user->setFlash("success", "NFe de Terceiro Importada com sucesso!");
			$this->redirect(array('index'));
		}
		else
		{
			$erros = $model->getErrors();
			
			$msgs = array("Erro(s) ao Importar:");
			
			foreach ($erros as $campo => $mensagens)
				foreach ($mensagens as $msg)
					$msgs[] = "[$campo] => $msg";
			
			$msgs = implode("<BR>", $msgs);
			
			Yii::app()->user->setFlash("error", $msgs);
			$this->redirect(array('view','id'=>$model->codnfeterceiro));
		}
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

	/**
	* Lists all models.
	*/
	public function actionIndex()
	{
		$model=new NfeTerceiro('search');
		
		$model->unsetAttributes();  // clear any default values
		
		if(isset($_GET['NfeTerceiro']))
			Yii::app()->session['FiltroNfeTerceiroIndex'] = $_GET['NfeTerceiro'];
		
		if (isset(Yii::app()->session['FiltroNfeTerceiroIndex']))
			$model->attributes=Yii::app()->session['FiltroNfeTerceiroIndex'];
		else
		{
			//$model->indsituacao = NfeTerceiro::INDSITUACAO_AUTORIZADA;
			$model->codnotafiscal = 1;
		}
		
		$this->render('index',array(
			'dataProvider'=>$model->search(),
			'model'=>$model,
			));
	}

	/**
	* Manages all models.
	*/
	/*
	public function actionAdmin()
	{
	
		$model=new NfeTerceiro('search');
		
		$model->unsetAttributes();  // clear any default values
		
		if(isset($_GET['NfeTerceiro']))
			$model->attributes=$_GET['NfeTerceiro'];

		$this->render('admin',array(
			'model'=>$model,
			));
	}
	 * 
	 */
	
	public function actionUpload()
	{
		/**
		 * @var NfeTerceiro
		 */
		$model=new NfeTerceiro;

		if(isset($_POST['NfeTerceiro']))
		{
			$model->attributes=$_POST['NfeTerceiro'];
            $model->arquivoxml=CUploadedFile::getInstance($model,'arquivoxml');
			if ($model->importarXmlViaArquivo())
				$this->redirect(array('view','id'=>$model->codnfeterceiro));
		}

		$this->render(
			'upload',
			array(
				'model'=>$model,
			)
		);
	}
	
	public function actionPesquisarSefaz($codfilial = null, $nsu = null)
	{
		$model = new NfeTerceiro('search');

		$model->codfilial = $codfilial;
		$model->nsu = $nsu;
		
		if(isset($_POST['NfeTerceiro']))
		{
			$model->attributes=$_POST['NfeTerceiro'];
		}
		
		$nsu = $model->nsu;

		if (!empty($model->codfilial))
		{
			$acbr = new MGAcbrNfeMonitor(null, $model);
			
			$leituras = 0;
			
			$nsuinicial = $nsu;
			$fim = false;
			
			$importadas = array();
			
			do {
				
				$leituras++;
				
				if ($leituras > 100)
					break;
				
				//echo "<hr>Pesquisando $nsu <br>";
				
				if (!$acbr->consultaNfeDest($nsu))
				{
					//echo "<h1>Erro ao enviar comando</h1>";
				}
				usleep(500000);
				//echo "<pre>";
				//print_r($acbr->retorno);
				//echo "</pre>";
					

				//if ($acbr->retornoMonitor["Mensagem"][0] != "OK")
				//	break;

				for ($i=1; $i<1000; $i++)
				{
					$chave = "RESNFE" . str_pad($i, 3, 0, STR_PAD_LEFT);

					if (!isset($acbr->retornoMonitor[$chave]))
						break;

					$arr = $acbr->retornoMonitor[$chave];

					$nfe = NfeTerceiro::model()->find("nfechave = :nfechave", array("nfechave"=>$arr["chNFe"]));

					if ($nfe === null)
						$nfe = new NfeTerceiro();

					$nfe->codfilial = $model->codfilial;

					//[NSU] => 10220440943
					$nfe->nsu = $arr["NSU"];

					//[chNFe] => 51140628053619009644550010000146501273515829
					$nfe->nfechave = $arr["chNFe"];

					//[CNPJ] => 28053619009644
					$nfe->cnpj = $arr["CNPJ"];

					//[xNome] => Chocolates Garoto S.A.
					$nfe->emitente = MGFormatter::removeAcentos(utf8_encode($arr["xNome"]));
					
					//[IE] => 134342763
					$nfe->ie = $arr["IE"];

					//[dEmi] => 24/06/2014
					$nfe->emissao = $arr["dEmi"];

					//[tpNF] => 1
					$nfe->codoperacao = $arr["tpNF"]+1;

					//[vNF] => 222,84
					$nfe->valortotal = Yii::app()->format->unformatNumber($arr["vNF"]);

					//[digVal] => WAFS3wPj/69U7sJI412ygTDk7+I=
					//[dhRecbto] => 24/06/2014 07:25:09
					if (isset($arr["dhRecbto"]))
						$nfe->nfedataautorizacao = $arr["dhRecbto"];

					//[cSitNFe] => 1
					if (isset($arr["cSitNFe"]))
						$nfe->indsituacao = $arr["cSitNFe"];

					//[cSitConf] => 0		
					if (isset($arr["cSitConf"]))
						$nfe->indmanifestacao = $arr["cSitConf"];
					
					$importadas[] = $arr["chNFe"];

					$nfe->save();

				}

				//echo "</pre>";

				if (isset($acbr->retornoMonitor[""]["ultNSU"]))
				{
					if ($nsu == $acbr->retornoMonitor[""]["ultNSU"])
					{
						//echo "<h1>Repetiu ult nsu</h1>";
						break;
					}
					$nsu = $acbr->retornoMonitor[""]["ultNSU"];
				}
				else
				{
					//echo "<h1>Nao achou ult nsu</h1>";
					break;
				}
				
				
				if (isset($acbr->retornoMonitor[""]["indCont"]))
				{
					if ($acbr->retornoMonitor[""]["indCont"] != 1)
					{
						$fim = true;
						break;
					}
				}
				
			} while (true);
			
			$model->nsu = $nsu;
			
			$lidas = Yii::app()->format->formatNumber($model->nsu - $nsuinicial, 0);

			if ($acbr->retornoMonitor["Mensagem"][0] != "OK")
			{
				$class = "error";
				$mensagem = $acbr->retorno;
			}
			else
			{
				$mensagem = "Lidos {$lidas} NSU's ({$nsuinicial} ao {$model->nsu}).";

				$mensagem .= "<br>Importadas <b>" . sizeof($importadas) . "</b> Chaves (" . implode(", ", $importadas) . ")";

				if ($fim)
				{
					$mensagem .= "<br>Lidas todas as notas!";
					$class = "success";
				}
				else
				{
					$mensagem .= "<br>Existem mais registros para ler, <b>continue</b>!";
					$class = "info";
				}
			}
			Yii::app()->user->setFlash($class, $mensagem);
			
		}
		
		$this->render('pesquisar_sefaz',array(
			'model'=>$model,
			));
		
	}
	
	/**
	 * Efetua Download de uma NFE e Carrega os dados na tabela do sistema
	 * @param bigint $id
	 * @throws CHttpException
	 */
	public function actionDownloadNfe($id)
	{
		/**
		 * @var NfeTerceiro Description
		 */
		//$model = $this->loadModel($id);
		$model = NfeTerceiro::model()->findByPk($id);
		$acbr = new MGAcbrNfeMonitor(null, $model);
		
		$res = $acbr->downloadNfe();
		
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

	public function actionEnviarEventoManifestacao($id, $indManifestacao, $justificativa = "")
	{
		$model = $this->loadModel($id);
		$acbr = new MGAcbrNfeMonitor(null, $model);
		
		$res = $acbr->enviarEventoManifestacao($indManifestacao, $justificativa);
		
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


	/**
	* Returns the data model based on the primary key given in the GET variable.
	* If the data model is not found, an HTTP exception will be raised.
	* @param integer the ID of the model to be loaded
	*/
	public function loadModel($id)
	{
		$model=NfeTerceiro::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='nfe-terceiro-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

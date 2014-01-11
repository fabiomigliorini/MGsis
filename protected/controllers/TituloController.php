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
	
	public function actionImprimeBoleto($id)
	{
		
		$model = $this->loadModel($id);
		
		if (!$model->boleto)
			throw new CHttpException(400,'Este título não é um boleto.');
		
		if ($model->saldo <= 0)
			throw new CHttpException(400,'Título sem saldo.');
		
		$boleto = new MGBoleto($model);
		
		echo $boleto->getOutput();
		
		
	}
	
	public function actionImprimeVale($id)
	{
		
		$model = $this->loadModel($id);
		
		if ($model->saldo >= 0)
			throw new CHttpException(400,'Título sem saldo.');
		
		//inicializa
		$escp = new MGEscPrint();
		$escp->adicionaTexto("<Reset><6lpp><Draft><CondensedOff>", "cabecalho");
		
		//linha divisoria
		$escp->adicionaLinha("", "cabecalho", 80, STR_PAD_RIGHT, "=");
		
		// Fantasia e NUMERO do Vale
		$escp->adicionaTexto("<DblStrikeOn>", "cabecalho");
		$escp->adicionaTexto($model->Filial->Pessoa->fantasia . " " . $model->Filial->Pessoa->telefone1, "cabecalho", 56);
		$escp->adicionaTexto("Titulo:        " . Yii::app()->format->formataCodigo($model->codtitulo), "cabecalho", 24);
		$escp->adicionaTexto("<DblStrikeOff>", "cabecalho");
		$escp->adicionaLinha("", "cabecalho");
		
		// Usuario e Data
		if (isset($model->codusuariocriacao))
			$usuario = $model->UsuarioCriacao->usuario;
		else
			$usuario = Yii::app()->user->name;
		$escp->adicionaTexto("Usuario: " . $usuario, "cabecalho", 56);
		$escp->adicionaTexto("Data..: " . $model->sistema, "cabecalho", 24);
		$escp->adicionaLinha("", "cabecalho");
		
		//linha divisoria
		$escp->adicionaLinha("", "cabecalho", 80, STR_PAD_RIGHT, "=");

		//forca impressao cabecalho primeira pagina
		//$escp->cabecalho();

		//Rodape
		$escp->adicionaTexto("", "rodape", 80, STR_PAD_RIGHT, "=");
		
		//titulo
		$escp->adicionaLinha("");
		$escp->adicionaTexto("<LargeOn>");
		$escp->adicionaTexto("<DblStrikeOn>");
		$escp->adicionaTexto("V A L E", "documento", 40, STR_PAD_BOTH);
		$escp->adicionaTexto("<DblStrikeOff>");
		$escp->adicionaTexto("<LargeOff>");
		$escp->adicionaLinha("");

		//Numero titulo
		$escp->adicionaTexto("Numero....:", "documento", 12);
		$escp->adicionaTexto($model->numero, "documento", 68);
		$escp->adicionaLinha();
		
		//Espaco
		$escp->adicionaLinha();
		
		//Fantasia
		$escp->adicionaTexto("<DblStrikeOn>");
		$escp->adicionaTexto("Favorecido: ");
		$escp->adicionaTexto($model->Pessoa->fantasia . " (" .Yii::app()->format->formataCodigo($model->codpessoa) . ")", "documento", 68);
		$escp->adicionaTexto("<DblStrikeOff>");
		$escp->adicionaLinha();

		//Telefone
		$escp->adicionaTexto("", "documento", 12);
		$escp->adicionaTexto("{$model->Pessoa->telefone1} / {$model->Pessoa->telefone2} / {$model->Pessoa->telefone3}", "documento", 68);
		$escp->adicionaLinha();
		
		//Razao Social
		$escp->adicionaTexto("", "documento", 12);
		$escp->adicionaTexto($model->Pessoa->pessoa, "documento", 68);
		$escp->adicionaLinha();
		
		//Cnpj
		$escp->adicionaTexto("", "documento", 12);
		$escp->adicionaTexto("CNPJ/CPF: " . Yii::app()->format->formataCnpjCpf($model->Pessoa->cnpj, $model->Pessoa->fisica), "documento", 29);
		if (!empty($model->Pessoa->ie))
			$escp->adicionaTexto("- Inscricao Estadual: " .Yii::app()->format->formataInscricaoEstadual($model->Pessoa->ie, $model->Pessoa->Cidade->Estado->sigla), "documento", 38);
		$escp->adicionaLinha();

		//Espaco
		$escp->adicionaLinha();
		
		//Extenso
		$escp->adicionaTexto("<DblStrikeOn>");
		$linhas = Yii::app()->format->formataValorPorExtenso($model->creditosaldo, true);
		$linhas = "R$ " . Yii::app()->format->formatNumber($model->creditosaldo) . " ($linhas)";
		$linhas = str_split($linhas, 68);
		$label = "Valor.....:";
		foreach ($linhas as $linha)
		{
			$escp->adicionaTexto($label, "documento", 12);
			$escp->adicionaTexto(trim($linha), "documento", 68);
			$escp->adicionaLinha();
			$label = "";
		}
		$escp->adicionaTexto("<DblStrikeOff>");
		
		// Espaco
		$escp->adicionaLinha();

		//Observacao
		if (!empty($model->observacao))
		{
			$label = "Observacao:";
			$linhas = str_split($model->observacao, 68);
			foreach ($linhas as $linha)
			{
				$escp->adicionaTexto($label, "documento", 12);
				$escp->adicionaTexto(trim($linha), "documento", 68);
				$escp->adicionaLinha();
				$label = "";
			}
			
			// Espaco
			$escp->adicionaLinha();
		}
		

		// Data por extenso
		$escp->adicionaTexto("", "documento", 12);
		$escp->adicionaTexto($model->Filial->Pessoa->Cidade->cidade);
		$escp->adicionaTexto("/");
		$escp->adicionaTexto($model->Filial->Pessoa->Cidade->Estado->sigla);
		$escp->adicionaTexto(", ");
		$escp->adicionaTexto(Yii::app()->format->formataDataPorExtenso($model->emissao));
		$escp->adicionaTexto(".");
		$escp->adicionaLinha();

		// Espaco
		$escp->adicionaLinha();
		$escp->adicionaLinha();
		$escp->adicionaLinha();

		//Assinatura
		$escp->adicionaTexto("", "documento", 12);
		$escp->adicionaTexto("", "documento", 50, STR_PAD_RIGHT, "-");
		$escp->adicionaLinha();
		$escp->adicionaTexto("", "documento", 12);
		$escp->adicionaTexto($model->Filial->Pessoa->pessoa, "documento", 50);
		$escp->adicionaLinha();
		
		$escp->prepara();
		
		if (!empty($_GET["imprimir"]))
		{
			echo $escp->imprimir();
			echo "<script>alert('Documento enviado para a Impressora: {$escp->impressora}');</script>";
		}
		
		echo "<pre>";
		echo $escp->converteHtml();
		echo "</pre>";
	}

	public function actionRelatorio()
	{
		
		$this->layout='//layouts/relatorio';
		
		$model=new Titulo('search');
		
		$model->unsetAttributes();  // clear any default values
		
		if(isset($_GET['Titulo']))
			Yii::app()->session['FiltroTituloIndex'] = $_GET['Titulo'];
		
		if (isset(Yii::app()->session['FiltroTituloIndex']))
			$model->attributes=Yii::app()->session['FiltroTituloIndex'];
		
		$rel = new MGRelatorioTitulos($model->search(false));
		$rel->montaRelatorio();
		$rel->Output();
		
	}
}
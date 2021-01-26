<?php

class LiquidacaoTituloController extends Controller
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
		$model=new LiquidacaoTitulo;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['LiquidacaoTitulo']))
		{
			$model->attributes=$_POST['LiquidacaoTitulo'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->codliquidacaotitulo));
		}
		else
		{
			$model->transacao = date('d/m/Y');
			if (!empty(Yii::app()->user->codportador))
				$model->codportador = Yii::app()->user->codportador;
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

		if(isset($_POST['LiquidacaoTitulo']))
		{
			$model->attributes=$_POST['LiquidacaoTitulo'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->codliquidacaotitulo));
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
	 *
	 */

	public function actionEstorna($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow estorna via POST request
			$model = $this->loadModel($id);
			if (!$model->estorna())
				Yii::app()->user->setFlash("error", "Erro ao estornar Liquidação de Títulos!");
			else
				Yii::app()->user->setFlash("success", "Liquidação de Títulos Estornada!");

			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('view','id'=>$model->codliquidacaotitulo));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	* Lists all models.
	*/
	public function actionIndex()
	{
		$model=new LiquidacaoTitulo('search');

		$model->unsetAttributes();  // clear any default values

		if (isset($_GET['LiquidacaoTitulo'])) {
			Yii::app()->session['FiltroLiquidacaoTituloIndex'] = $_GET['LiquidacaoTitulo'];
		}

		if (!isset(Yii::app()->session['FiltroLiquidacaoTituloIndex'])) {
			Yii::app()->session['FiltroLiquidacaoTituloIndex'] = array(
				'codusuariocriacao' => Yii::app()->user->id,
				'criacao_de' => date('d/m/y', strtotime('-7 days')),
			);
		}

		if (isset(Yii::app()->session['FiltroLiquidacaoTituloIndex'])) {
			$model->attributes=Yii::app()->session['FiltroLiquidacaoTituloIndex'];
		}

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

		$model=new LiquidacaoTitulo('search');

		$model->unsetAttributes();  // clear any default values

		if(isset($_GET['LiquidacaoTitulo']))
			$model->attributes=$_GET['LiquidacaoTitulo'];

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
		$model=LiquidacaoTitulo::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='liquidacao-titulo-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionImprimeRecibo($id, $imprimir = false)
	{

		$model = $this->loadModel($id);

		if (!empty($model->estornado))
			throw new CHttpException(400,'Liquidação de Títulos estornada!');

		$rel = new MGEscPrintRecibo($model);
		$rel->prepara();

		if ($imprimir)
			$rel->imprimir();

		echo $rel->converteHtml();

	}

	public function validarFiltro()
	{
		if (isset(Yii::app()->session['FiltroLiquidacaoTituloIndex'])) {
			foreach (Yii::app()->session['FiltroLiquidacaoTituloIndex'] as $key => $val) {
				if (!empty($val)) {
					return;
				}
			}
		}
		die ('Faça pelo menos um filtro!');
	}

	public function actionRelatorio()
	{
		// WORKAROUND: Cache Chrome salvando sempre o mesmo relatorio!
		// Ate mostrava em tela diferente, mas ao salvar, salvava a primeira versao emitida
		if (!isset($_GET['__pdfdate'])) {
				header('Location: ' . $_SERVER['REQUEST_URI'] . '&__pdfdate=' . date('c'));
		}

		$model=new LiquidacaoTitulo('search');

		$model->unsetAttributes();  // clear any default values

		if(isset($_GET['LiquidacaoTitulo']))
			Yii::app()->session['FiltroLiquidacaoTituloIndex'] = $_GET['LiquidacaoTitulo'];

		$this->validarFiltro();

		if (isset(Yii::app()->session['FiltroLiquidacaoTituloIndex']))
			$model->attributes=Yii::app()->session['FiltroLiquidacaoTituloIndex'];

		$liqs = $model->search(false);

		$rel = new MGRelatorioLiquidacaoTitulo($liqs);
		$rel->montaRelatorio();
		$rel->Output();

	}


}

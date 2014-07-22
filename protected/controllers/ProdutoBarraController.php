<?php

class ProdutoBarraController extends Controller
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
	public function actionCreate($codproduto)
	{
		$model=new ProdutoBarra;
		$model->codproduto = $codproduto;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['ProdutoBarra']))
		{
			$model->attributes=$_POST['ProdutoBarra'];
			if($model->save())
				$this->redirect(array('produto/view','id'=>$model->codproduto));
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

		if(isset($_POST['ProdutoBarra']))
		{
			$model->attributes=$_POST['ProdutoBarra'];
			if($model->save())
				$this->redirect(array('produto/view','id'=>$model->codproduto));
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
		$model=new ProdutoBarra('search');
		
		$model->unsetAttributes();  // clear any default values
		
		if(isset($_GET['ProdutoBarra']))
			Yii::app()->session['FiltroProdutoBarraIndex'] = $_GET['ProdutoBarra'];
		
		if (isset(Yii::app()->session['FiltroProdutoBarraIndex']))
			$model->attributes=Yii::app()->session['FiltroProdutoBarraIndex'];
		
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
	
		$model=new ProdutoBarra('search');
		
		$model->unsetAttributes();  // clear any default values
		
		if(isset($_GET['ProdutoBarra']))
			$model->attributes=$_GET['ProdutoBarra'];

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
		$model=ProdutoBarra::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='produto-barra-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionAjaxBuscaProdutoBarra($texto, $inativo = false, $limite = 20, $pagina = 1) 
	{

		// limpa texto
		$ordem = (strstr($texto, '$'))?'preco, descricao':'descricao';
		$texto = str_replace('$', '', $texto);
		$texto  = str_replace(' ', '%', trim($texto));

		// corrige pagina se veio sujeira
		if ($pagina < 1) $pagina = 1;

		// calcula de onde continuar a consulta
		$offset = ($pagina-1)*$limite;
		
		// inicializa array com resultados
		$resultados = array();

		// se o texto foi preenchido
		if (strlen($texto)>=3)
		{
    
			$sql = "SELECT codprodutobarra as id, codproduto, barras, descricao, sigla, preco, marca, referencia 
				      FROM vwProdutoBarra 
				     WHERE codProdutoBarra is not null ";
			
			if (!$inativo) 
				$sql .= "AND Inativo is null ";
				
			$sql .= " AND (";

			// Verifica se foi digitado um valor e procura pelo preco
			If ((Yii::app()->format->formatNumber(Yii::app()->format->unformatNumber($texto)) == $texto)
				&& (strpos($texto, ",") != 0)
				&& ((strlen($texto) - strpos($texto, ",")) == 3)) 
			{
				$sql .= "preco = :preco";
				$params = array(
					':preco'=>Yii::app()->format->unformatNumber($texto),
					);
			}
			//senao procura por barras, descricao, marca e referencia
			else
			{
				$sql .= "barras ilike :texto ";
				$sql .= "OR descricao ilike :texto ";
				$sql .= "OR marca ilike :texto ";
				$sql .= "OR referencia ilike :texto ";
				$params = array(
					':texto'=>'%'.$texto.'%',
					);
			}

			//ordena
			$sql .= ") ORDER BY $ordem LIMIT $limite OFFSET $offset";
			
			$command = Yii::app()->db->createCommand($sql);
			$command->params = $params;
			
			$resultados = $command->queryAll();
			
			for ($i=0; $i<sizeof($resultados);$i++)
			{
				$resultados[$i]["codproduto"] = Yii::app()->format->formataCodigo($resultados[$i]["codproduto"], 6);
				$resultados[$i]["preco"] = Yii::app()->format->formatNumber($resultados[$i]["preco"]);
				if (empty($resultados[$i]["referencia"]))
					$resultados[$i]["referencia"] = "-";
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
	
	public function actionAjaxInicializaProdutoBarra($codprodutobarra) 
	{
		
		if (!is_numeric($codprodutobarra))
			throw new CHttpException(404,'The requested page does not exist.');			

		$sql = "SELECT codprodutobarra as id, codproduto, barras, descricao, sigla, preco, marca, referencia 
				  FROM vwProdutoBarra 
				 WHERE codProdutoBarra = $codprodutobarra ";

		$command = Yii::app()->db->createCommand($sql);
		$resultados = $command->queryAll();

		if (empty($resultados))
			throw new CHttpException(404,'The requested page does not exist.');
		
		$i = 0;
		
		$resultados[$i]["codproduto"] = Yii::app()->format->formataCodigo($resultados[$i]["codproduto"], 6);
		$resultados[$i]["preco"] = Yii::app()->format->formatNumber($resultados[$i]["preco"]);
		if (empty($resultados[$i]["referencia"]))
			$resultados[$i]["referencia"] = "-";
		
		
		echo CJSON::encode($resultados[0]);
		Yii::app()->end();
		
	} 

	
}

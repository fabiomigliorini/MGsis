<?php

class NegocioController extends Controller
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
		$model=new Negocio;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);
		
		$model->codusuario = Yii::app()->user->id;
		$model->lancamento = date('d/m/Y H:i:s');
		$model->codnegociostatus = 1;
		$model->codfilial = Yii::app()->user->getState("codfilial");
		$model->codnaturezaoperacao = NaturezaOperacao::VENDA;
		$model->codpessoa = Pessoa::CONSUMIDOR;

		if(isset($_POST['Negocio']))
		{
			$model->attributes=$_POST['Negocio'];
			if (!empty($model->NaturezaOperacao))
				$model->codoperacao = $model->NaturezaOperacao->codoperacao;
			if($model->save())
				$this->redirect(array('view','id'=>$model->codnegocio));
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
	public function actionUpdate($id, $fechar = null)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Negocio']))
		{
			$model->attributes=$_POST['Negocio'];
			$salvo = $model->save();
			
			if($salvo && $fechar == 1)
				$salvo = $model->fechaNegocio();
			
			if ($salvo)
				$this->redirect(array('view','id'=>$model->codnegocio));
				
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
		$model=new Negocio('search');
		
		$model->unsetAttributes();  // clear any default values
		
		if(isset($_GET['Negocio']))
			Yii::app()->session['FiltroNegocioIndex'] = $_GET['Negocio'];
		
		if (isset(Yii::app()->session['FiltroNegocioIndex']))
			$model->attributes=Yii::app()->session['FiltroNegocioIndex'];
		else
		{
			$model->codusuario = Yii::app()->user->id;
			$model->lancamento_de = date("d/m/y", strtotime( '-30 days' ) );
			$model->horario_de = "00:00";
			$model->codnegociostatus = NegocioStatus::ABERTO; //Aberto
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
	
		$model=new Negocio('search');
		
		$model->unsetAttributes();  // clear any default values
		
		if(isset($_GET['Negocio']))
			$model->attributes=$_GET['Negocio'];

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
		$model=Negocio::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='negocio-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionAdicionaProduto($codnegocio, $barras, $quantidade=1)
	{
		$model=$this->loadModel($codnegocio);
		
		$retorno = array("Adicionado"=>true, "Mensagem"=>"");

		if ($pb = ProdutoBarra::model()->findByBarras($barras))
		{
			if ($npb = NegocioProdutoBarra::model()->find(
				"codnegocio=:codnegocio AND codprodutobarra=:codprodutobarra", 
				array(
					":codnegocio" => $model->codnegocio,
					":codprodutobarra" => $pb->codprodutobarra
					)
				))
			{
				$npb->quantidade += $quantidade;
			}
			else
			{
				$npb = new NegocioProdutoBarra;
				$npb->codnegocio = $model->codnegocio;
				$npb->codprodutobarra = $pb->codprodutobarra;
				$npb->quantidade = $quantidade;
				$npb->valorunitario = $pb->preco;
			}
			$npb->valortotal = $npb->quantidade * $npb->valorunitario;
			
			if (!$npb->save())
			{
				$retorno["Adicionado"] = false;
				$erros = $npb->getErrors();
				$erro = "Erro ao salvar registro de produto!<br>";
				foreach ($erros as $campo => $mensagens)
					foreach($mensagens as $mensagem)
						$erro .= "\n<br>- " . $mensagem;
					
				$retorno["Mensagem"] = $erro;
				$retorno["Erros"] = $erros;
			}
			
			
		}
		else
		{
			$retorno["Adicionado"] = false;
			$retorno["Mensagem"] = "Produto '$barras' não localizado!";
		}
		
		echo CJSON::encode($retorno);
		
	}
	
	public function actionAtualizaListagemProdutos($codnegocio)
	{
		$this->renderPartial('_view_produtos_listagem',array(
			'model'=>$this->loadModel($codnegocio),
			));		
	}
	
	public function actionAtualizaListagemPagamentos($codnegocio)
	{
		$this->renderPartial('_view_pagamentos_listagem',array(
			'model'=>$this->loadModel($codnegocio),
			));		
	}
	
	public function actionAtualizaTotais($codnegocio)
	{
		$this->renderPartial('_view_totais',array(
			'model'=>$this->loadModel($codnegocio),
			));		
	}
	
	public function actionAdicionaFormaPagamento($codnegocio, $codformapagamento, $valorpagamento)
	{
		$model=$this->loadModel($codnegocio);
		
		$retorno = array("Adicionado"=>true, "Mensagem"=>"");
		
		if ($valorpagamento <= 0)
		{
			$retorno["Adicionado"] = false;
			$retorno["Mensagem"] = "Valor Inválido!";
		}
		elseif ($fp = FormaPagamento::model()->findByPk($codformapagamento))
		{
			if ($nfp = NegocioFormaPagamento::model()->find(
				"codnegocio=:codnegocio AND codformapagamento=:codformapagamento", 
				array(
					":codnegocio" => $model->codnegocio,
					":codformapagamento" => $fp->codformapagamento
					)
				))
			{
				$nfp->valorpagamento += $valorpagamento;
			}
			else
			{
				$nfp = new NegocioFormaPagamento;
				$nfp->codnegocio = $model->codnegocio;
				$nfp->codformapagamento = $fp->codformapagamento;
				$nfp->valorpagamento = $valorpagamento;
			}
			
			if (!$nfp->save())
			{
				$retorno["Adicionado"] = false;
				$erros = $nfp->getErrors();
				$erro = "Erro ao salvar registro de produto!<br>";
				foreach ($erros as $campo => $mensagens)
					foreach($mensagens as $mensagem)
						$erro .= "\n<br>- " . $mensagem;
					
				$retorno["Mensagem"] = $erro;
				$retorno["Erros"] = $erros;
			}
			
			
		}
		else
		{
			$retorno["Adicionado"] = false;
			$retorno["Mensagem"] = "Forma de Pagamento '$codformapagamento' não localizada!";
		}
		
		echo CJSON::encode($retorno);
		
	}

	public function actionFechaNegocio($codnegocio)
	{
		
		$negocio = $this->loadModel($codnegocio);
		
		$retorno = array("Retorno"=>true, "Mensagem"=>"");
		
		if (!$negocio->fechaNegocio())
		{
			$retorno["Retorno"] = false;
			$erros = $negocio->getErrors();
			$erro = "Erro ao Fechar Negócio!";
			foreach ($erros as $campo => $mensagens)
				foreach($mensagens as $mensagem)
					$erro .= " " . $mensagem;
			$retorno["Mensagem"] = $erro;
			
		}
		
		echo CJSON::encode($retorno);
		
	}

	public function actionGeraNotaFiscal($codnegocio, $codnotafiscal = null)
	{
		
		$negocio = $this->loadModel($codnegocio);
		
		$retorno = array("Retorno"=>true, "Mensagem"=>"");
		
		if (!$negocio->geraNotaFiscal($codnotafiscal, true))
		{
			$retorno["Retorno"] = false;
			$erros = $negocio->getErrors();
			$erro = "Erro ao Gerar Nota Fiscal!";
			foreach ($erros as $campo => $mensagens)
				foreach($mensagens as $mensagem)
					$erro .= " " . $mensagem;
			$retorno["Mensagem"] = $erro;
			
		}
		
		echo CJSON::encode($retorno);
		
	}
	
}
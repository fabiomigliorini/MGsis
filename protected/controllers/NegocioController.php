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
	public function actionCreate($duplicar = null)
	{
		$model=new Negocio;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		$model->codusuario = Yii::app()->user->id;
		$model->lancamento = date('d/m/Y H:i:s');
		$model->codnegociostatus = NegocioStatus::ABERTO;
		$model->codfilial = Yii::app()->user->getState("codfilial");
		if (sizeof($model->Filial->EstoqueLocals) > 0)
			$model->codestoquelocal = $model->Filial->EstoqueLocals[0]->codestoquelocal;
		$model->codnaturezaoperacao = NaturezaOperacao::VENDA;
		$model->codpessoa = Pessoa::CONSUMIDOR;

		if (isset($_POST['Negocio']))
		{
			$transaction = Yii::app()->db->beginTransaction();

			$erro = false;
			$model->attributes=$_POST['Negocio'];
			if (!empty($model->NaturezaOperacao))
				$model->codoperacao = $model->NaturezaOperacao->codoperacao;
			if(!$model->save())
			{
				$erro = true;
			}

			if (!$erro && !empty($duplicar))
			{
				$original = $this->loadModel($duplicar);

				//duplica produtos
				foreach ($original->NegocioProdutoBarras as $prod_orig)
				{
					$prod_novo = new NegocioProdutoBarra;
					$prod_novo->attributes = $prod_orig->attributes;
					$prod_novo->codnegocioprodutobarra = null;
					$prod_novo->codnegocio = $model->codnegocio;
					$prod_novo->criacao = null;
					$prod_novo->codusuariocriacao = null;
					$prod_novo->alteracao = null;
					$prod_novo->codusuarioalteracao = null;

					if (!$prod_novo->save())
					{
						$model->addError('codnegocio', 'Erro ao duplicar NegocioProdutoBarra #' . $prod_orig->codnegocioprodutobarra);
						$model->addErrors($prod_novo->getErrors());
						$erro = true;
						break;
					}
				}

			}

			if (!$erro)
			{
				$transaction->commit();
				$this->redirect(array('view','id'=>$model->codnegocio));
			}
			else
			{
				$transaction->rollBack();
			}
		}
		else
		{
			if (!empty($duplicar))
			{
				$original = $this->loadModel($duplicar);

				$model->attributes = $original->attributes;

				$model->codusuariocriacao = null;
				$model->criacao = null;
				$model->codusuarioalteracao = null;
				$model->alteracao = null;
				$model->codnegociostatus = NegocioStatus::ABERTO;
				$model->codusuario = Yii::app()->user->id;
				$model->lancamento = date('d/m/Y H:i:s');

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

		$fechar = 0;
		if (isset($_POST["fechar"]))
			$fechar = $_POST["fechar"];

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Negocio']))
		{
			$model->attributes=$_POST['Negocio'];
			$salvo = $model->save();

			if($salvo && $fechar == 1)
				$salvo = $model->fecharNegocio();

			if($salvo && $fechar == 1)
				Yii::app()->session['UltimoCodNegocioFechado'] = $model->codnegocio;

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

	public function actionCancelar($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow Cancelar via POST request
			$model = $this->loadModel($id);
			if (!$model->cancelar())
			{
				$erros = $model->getErrors();
				$erro = "Impossível estornar negócio!<br>";
				foreach ($erros as $campo => $mensagens)
					foreach($mensagens as $mensagem)
						$erro .= "\n<br>- " . $mensagem;
				Yii::app()->user->setFlash("error", $erro);
			}
			else
				Yii::app()->user->setFlash("success", "Negócio Cancelado!");

			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('view','id'=>$model->codnegocio));
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
			//$model->lancamento_de = date("d/m/y", strtotime( '-30 days' ) );
			//$model->horario_de = "00:00";
			//$model->codnegociostatus = NegocioStatus::ABERTO; //Aberto
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

	public function actionImprimeRomaneio($id, $imprimir = false)
	{

		$model = $this->loadModel($id);

		if ($model->codnegociostatus <> NegocioStatus::FECHADO)
			throw new CHttpException(400,'O status do Negócio não permite impressão do Romaneio!');

		$rel = new MGEscPrintRomaneio($model);
		$rel->prepara();

		if ($imprimir)
			$rel->imprimir();

		echo $rel->converteHtml();

	}

	/**
	* Returns the data model based on the primary key given in the GET variable.
	* If the data model is not found, an HTTP exception will be raised.
	* @param integer the ID of the model to be loaded
    * @return Negocio
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
		if(!isset($_POST['ajax'])) {
			return;
		}
		if($_POST['ajax']!=='negocio-form') {
			return;
		}
		echo CActiveForm::validate($model);
		// Gambiarra pra salvar os dados enquanto usuario edita
		if ($model->codnegociostatus == 1) {
			$model->attributes=$_POST['Negocio'];
			$model->save();
		}
		Yii::app()->end();
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

	public function actionFecharNegocio($codnegocio)
	{

		$negocio = $this->loadModel($codnegocio);

		$retorno = array("Retorno"=>true, "Mensagem"=>"");

		if (!$negocio->fecharNegocio())
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

	public function actionGerarNotaFiscal($id, $modelo = null, $codnotafiscal = null)
	{

		$negocio = $this->loadModel($id);

		$retorno = array("Retorno"=>1, "Mensagem"=>"", "codnotafiscal" =>$codnotafiscal);

		$transaction = Yii::app()->db->beginTransaction();

		if (!$codnotafiscal = $negocio->gerarNotaFiscal($codnotafiscal, $modelo, true))
		{
			$retorno["Retorno"] = 0;
			$erros = $negocio->getErrors();
			$erro = "Erro ao Gerar Nota Fiscal!";
			foreach ($erros as $campo => $mensagens)
				foreach($mensagens as $mensagem)
					$erro .= " " . $mensagem;
			$retorno["Mensagem"] = $erro;
			$transaction->rollBack();
		}
        else
            $transaction->commit();

		$retorno["codnotafiscal"] = $codnotafiscal;

		echo CJSON::encode($retorno);

	}

	public function actionRelatorio()
	{

		$model=new Negocio('search');

		$model->unsetAttributes();  // clear any default values

		if(isset($_GET['Negocio']))
			Yii::app()->session['FiltroNegocioIndex'] = $_GET['Negocio'];

		if (isset(Yii::app()->session['FiltroNegocioIndex']))
			$model->attributes=Yii::app()->session['FiltroNegocioIndex'];

		$negocios = $model->search(false);

		$rel = new MGRelatorioNegocios($negocios);
		$rel->montaRelatorio();
		$rel->Output();


	}
	public function actionRelatorioOrcamento($id)
	{
		$model = $this->loadModel($id);
		$rel = new MGRelatorioOrcamento($model);
		$rel->montaRelatorio();
		$rel->Output();
	}

	public function actionDevolucao($id)
	{
		$model = $this->loadModel($id);

		if($model->codnegociostatus != NegocioStatus::FECHADO)
			throw new CHttpException(409, 'O Status do Negócio não permite Devolução!');

		if($model->codnaturezaoperacao != NaturezaOperacao::VENDA)
			throw new CHttpException(409, 'Negócio não é uma venda!');

		if (isset($_POST['quantidadedevolucao']))
		{
			$codnegociodevolucao = $model->gerarDevolucao($_POST['quantidadedevolucao']);
			if ($codnegociodevolucao !== false)
				$this->redirect(array('view','id'=>$codnegociodevolucao));

		}

		$this->render('devolucao',array(
			'model'=>$model,
			));
	}


}

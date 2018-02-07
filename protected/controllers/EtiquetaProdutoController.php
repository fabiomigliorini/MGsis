<?php

class EtiquetaProdutoController extends Controller
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
	/*
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			));
	}
	 * 
	 */

	/**
	* Creates a new model.
	* If creation is successful, the browser will be redirected to the 'view' page.
	*/
	/*
	public function actionCreate($barras = "")
	{
		$model=new Produto;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Produto']))
		{
			$model->attributes=$_POST['Produto'];
			if($model->save())
			{
				$model->criaBarras($barras);
				$this->redirect(array('view','id'=>$model->codproduto));
			}
		}
		else
		{
			$model->codtipoproduto = TipoProduto::MERCADORIA;
		}

		$this->render('create',array(
			'model'=>$model,
			));
	}
	 *
	 */

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

		if(isset($_POST['Produto']))
		{
			$model->attributes=$_POST['Produto'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->codproduto));
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
	public function actionDelete($id)
	{
		
		if ($id == 'todos')
			Yii::app()->session['EtiquetaProduto'] = array();
		else
		{
			if (!isset(Yii::app()->session['EtiquetaProduto']))
				throw new CHttpException(404, 'A etiqueta selecionada não existe!');

			$etiquetaProduto = Yii::app()->session['EtiquetaProduto'];

			if (!isset($etiquetaProduto[$id]))
				throw new CHttpException(404, 'A etiqueta selecionada não existe!');

			unset ($etiquetaProduto[$id]);

			$etiquetaProdutoNovo = array();

			foreach ($etiquetaProduto as $item)
			{
				$etiquetaProdutoNovo[] = $item;
			}

			Yii::app()->session['EtiquetaProduto'] = $etiquetaProdutoNovo;
		}
		
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		
	}

	public function actionImprimir($modelo, $impressora)
	{
		$retorno = array('Impresso'=>true, 'Mensagem'=>'');
		
		$etiquetaProduto = Yii::app()->session['EtiquetaProduto'];
		
		$quant = 0;
		
		foreach ($etiquetaProduto as $etiqueta)
		{
			$quant += $etiqueta['quantidade'];
		}
		
		if ($quant == 0)
		{
			$retorno['Impresso'] = false;
			$retorno['Mensagem'] = 'Nenhuma etiqueta selecionada!';
		}
		elseif (($modelo == '3colunas' || $modelo == '3colunas_sempreco') && $quant % 3 != 0)
		{
			$retorno['Impresso'] = false;
			$retorno['Mensagem'] = 'Você precisa selecionar um múltiplo de 3 etiquetas!<br><br>Por exemplo, 3, 6, 9, 12...';
		}
		elseif (($modelo == '2colunas' || $modelo == '2colunas_sempreco') && $quant % 2 != 0)
		{
			$retorno['Impresso'] = false;
			$retorno['Mensagem'] = 'Você precisa selecionar um múltiplo de 2 etiquetas!<br><br>Por exemplo, 2, 4, 6, 8...';
		}
		else
		{
		
			
			switch ($modelo)
			{
				case '2colunas':
				case '2colunas_sempreco':
					$colunas = 2;
					$tamanhoDescricao = 32;
					break;

				case '3colunas':
				case '3colunas_sempreco':
					$colunas = 3;
					$tamanhoDescricao = 28;
					break;
				
				default:
					$colunas = 1;
					$tamanhoDescricao = 45;
					break;
			}

			$layout = Yii::app()->basePath . "/../layoutEtiquetas/{$modelo}.txt";

			$coluna = 1;
			$linha = 1;

			foreach ($etiquetaProduto as $etiqueta)
			{
				$pb = ProdutoBarra::model()->findByPk($etiqueta['codprodutobarra']);


				for ($i=0; $i<$etiqueta['quantidade']; $i++)
				{
					$linhas[$linha][$coluna]['DescricaoLinha1'] = trim(substr($pb->descricao, 0, $tamanhoDescricao));
					$linhas[$linha][$coluna]['DescricaoLinha2'] = trim(substr($pb->descricao, $tamanhoDescricao, $tamanhoDescricao));
					$linhas[$linha][$coluna]['Codigo'] = Yii::app()->format->formataCodigo($pb->codproduto, 6);
					$linhas[$linha][$coluna]['UnidadeMedida'] = $pb->UnidadeMedida->sigla;
					if (isset($pb->ProdutoEmbalagem))
						$linhas[$linha][$coluna]['UnidadeMedida'] .= ' ' .$pb->ProdutoEmbalagem->descricao; 
					$linhas[$linha][$coluna]['Preco'] = Yii::app()->format->formatNumber($pb->preco);
					
					if (strlen($linhas[$linha][$coluna]['Preco']) < 6)
						$linhas[$linha][$coluna]['Preco'] = str_pad ($linhas[$linha][$coluna]['Preco'], 6, ' ', STR_PAD_LEFT);
					
					$linhas[$linha][$coluna]['Preco'] = str_replace(' ', '  ', $linhas[$linha][$coluna]['Preco']);

					/* Decide o tipo de codigo de barras
					 * f42 - Ean13
					 * g63 - Ean8
					 * e63 subtipo A
					 * e63 subtipo C - Code128 somente números Par
					 * o42 - Code93 - nao le codigo "100182-8" no leitor metrologic - nao utilizar
					 * a42 - Code3 of 9
					 */
					
					$linhas[$linha][$coluna]['Barras'] = $pb->barras;
					$linhas[$linha][$coluna]['NumeroBarras'] = $pb->barras;
					
					if ($pb->barrasEan13Valido())
					{
						$linhas[$linha][$coluna]['ModeloBarras'] = 'f42';
						$linhas[$linha][$coluna]['SubsetBarras'] = '';
					}
					elseif ($pb->barrasEan8Valido())
					{
						$linhas[$linha][$coluna]['ModeloBarras'] = 'g63';
						$linhas[$linha][$coluna]['SubsetBarras'] = '';
					}
					elseif ($pb->barrasCode128CValido())
					{
						if (strlen($linhas[$linha][$coluna]['Barras']) <= 10)
							$linhas[$linha][$coluna]['ModeloBarras'] = 'e63';
						else
							$linhas[$linha][$coluna]['ModeloBarras'] = 'e42';
						$linhas[$linha][$coluna]['SubsetBarras'] = 'C';
					}
					else
					{
						$linhas[$linha][$coluna]['ModeloBarras'] = 'e42';
						$linhas[$linha][$coluna]['SubsetBarras'] = 'A';
						//$linhas[$linha][$coluna]['ModeloBarras'] = 'o42';
						//$linhas[$linha][$coluna]['SubsetBarras'] = '';
					}
					
					
					if (isset($pb->Produto->Marca))
						$linhas[$linha][$coluna]['Marca'] = $pb->Produto->Marca->marca;
					else
						$linhas[$linha][$coluna]['Marca'] = '';
					
					if (isset($pb->referencia))
						$linhas[$linha][$coluna]['Referencia'] = $pb->referencia;
					else
						$linhas[$linha][$coluna]['Referencia'] = $pb->Produto->referencia;
					
					
					$linhas[$linha][$coluna]['Data'] = date('d/m/y');

					$coluna++;
					if ($coluna>$colunas)
					{
						$coluna = 1;
						$linha++;
					}

				}

			}

			/*
			echo '<pre>';
			print_r($linhas);
			print_r($etiqueta);
			echo '</pre>';
			
			die();
			 * 
			 */
			
			//die(Yii::app()->basePath . "/../layoutEtiquetas/{$layout}.txt");

			$template = file_get_contents($layout);

			foreach ($linhas as $linha)
			{
				$conteudo = $template;

				$icoluna = 1;
				foreach ($linha as $coluna)
				{
					foreach ($coluna as $chave => $valor)
					{
						$conteudo = str_replace("<{$chave}Coluna{$icoluna}>", $valor, $conteudo);
					}
					$icoluna++;
				}

				$arquivo = tempnam(sys_get_temp_dir(), "MGEtiqueta");
				$handle = fopen($arquivo, "w");
				fwrite($handle, $conteudo);
				fclose($handle);
				exec("lpr -l -P {$impressora} {$arquivo}");
				/*
				echo "Imprimiu";
				echo "<pre>";
				echo CHtml::encode(file_get_contents($arquivo));
				echo "</pre>";
				 * 
				 */
				unlink($arquivo);

			}


			/*
			 * 
			 * 
			1911A0600700005<DescricaoLinha1Etiqueta1>
			1911A0600610005<DescricaoLinha2Etiqueta1>
			1911A0600520005<CodigoEtiqueta1>
			1911A0600430005<UnidadeMedidaEtiqueta1>
			1911A0600480065R$
			1911A0800480076<PrecoEtiqueta1>
			1e4203200110005C<BarrasEtiqueta1>
			1911A0600010005<NumeroBarrasEtiqueta1>

			 */
		}
		
		//$retorno['Mensagem'] .= '<pre>' . print_r($_POST, true) . '</pre>';
		
		
		/*
		if ($pb = ProdutoBarra::model()->findByBarras($barras))
		{
			
			if (!isset(Yii::app()->session['EtiquetaProduto']))
				Yii::app()->session['EtiquetaProduto'] = array();
			
			$etiquetaProduto = Yii::app()->session['EtiquetaProduto'];
				
			$etiquetaProduto[] = 
				array(
					"codprodutobarra" => $pb->codprodutobarra, 
					"quantidade" => $quantidade, 
					);
			
			Yii::app()->session['EtiquetaProduto'] = $etiquetaProduto;
			
		}
		else
		{
			$retorno["Adicionado"] = false;
			$retorno["Mensagem"] = "Produto '$barras' não localizado!";
		}
		*/
		
		echo CJSON::encode($retorno);
		
	}
	
	/*
	public function actionJuntarBarras($id)
	{
		$model=$this->loadModel($id);

		if(isset($_POST['Produto']))
		{
			$codprodutobarra = $_POST['Produto']['codprodutobarra'];
			$codprodutobarraeliminar = $_POST['Produto']['codprodutobarraeliminar'];
			
			if (empty($codprodutobarra) || empty($codprodutobarraeliminar))
			{
				$model->addError('codproduto', "Selectione ambos os códigos para prosseguir!");
			}
			elseif (!$pb = ProdutoBarra::model()->findByPk($codprodutobarra))
			{
				$model->addError('codproduto', "Produto Barras $codprodutobarra não localizado.");
			}
			else
			{
				if ($pb->juntarProdutoBarra($codprodutobarraeliminar))
					$this->redirect(array('view','id'=>$model->codproduto));
				else
					$model->addErrors($pb->getErrors());
			}
				
		}
		
		$this->render('juntar_barras',array(
			'model'=>$model,
			));
		
	}
	 * 
	 */
	
	/*
	public function actionTransferirBarras($id)
	{
		$model=$this->loadModel($id);

		if(isset($_POST['Produto']))
		{
			
			$codprodutobarra = $_POST['Produto']['codprodutobarra'];
			$codprodutobarranovo = $_POST['Produto']['codprodutobarranovo'];
			
			if (empty($codprodutobarra) || empty($codprodutobarranovo))
			{
				$model->addError('codproduto', "Selectione ambos os códigos para prosseguir!");
			}
			elseif (!$pb = ProdutoBarra::model()->findByPk($codprodutobarra))
			{
				$model->addError('codproduto', "Produto Barras $codprodutobarra não localizado.");
			}
			else
			{
				if ($pb->transferirProdutoBarra($codprodutobarranovo))
					$this->redirect(array('view','id'=>$model->codproduto));
				else
					$model->addErrors($pb->getErrors());
			}
				
		}
		
		$this->render('transferir_barras',array(
			'model'=>$model,
			));
		
	}
	 * 
	 */
	
	/**
	* Lists all models.
	*/
	public function actionIndex()
	{
		$model=new Produto('search');
		
		$model->unsetAttributes();  // clear any default values
		
		if(isset($_GET['Produto']))
			Yii::app()->session['FiltroProdutoIndex'] = $_GET['Produto'];
		
		if (isset(Yii::app()->session['FiltroProdutoIndex']))
			$model->attributes=Yii::app()->session['FiltroProdutoIndex'];
		
		$this->render('index',array(
			'dataProvider'=>$model->search(),
			'model'=>$model,
			));
	}

	public function actionAdicionarProduto($barras, $quantidade=1)
	{
		
		$retorno = array("Adicionado"=>true, "Mensagem"=>"");

		if ($pb = ProdutoBarra::model()->findByBarras($barras))
		{
			
			if (!isset(Yii::app()->session['EtiquetaProduto']))
				Yii::app()->session['EtiquetaProduto'] = array();
			
			$etiquetaProduto = Yii::app()->session['EtiquetaProduto'];
				
			$etiquetaProduto[] = 
				array(
					"codprodutobarra" => $pb->codprodutobarra, 
					"quantidade" => $quantidade, 
					);
			
			Yii::app()->session['EtiquetaProduto'] = $etiquetaProduto;
			
		}
		else
		{
			$retorno["Adicionado"] = false;
			$retorno["Mensagem"] = "Produto '$barras' não localizado!";
		}
		
		echo CJSON::encode($retorno);
		
	}
	
	/**
	* Manages all models.
	*/
	/*
	public function actionAdmin()
	{
	
		$model=new Produto('search');
		
		$model->unsetAttributes();  // clear any default values
		
		if(isset($_GET['Produto']))
			$model->attributes=$_GET['Produto'];

		$this->render('admin',array(
			'model'=>$model,
			));
	}
	
	public function actionQuiosqueConsulta ($barras = null)
	{
		
		if (!empty($barras))
			$model = ProdutoBarra::findByBarras($barras);
		else
			$model = null;
		
		$this->layout = '//layouts/quiosque';
		
		$this->render('quiosque_consulta',array(
			'model'=>$model,
			'barras'=>$barras,
			));
		
	}
	*/
	/**
	* Returns the data model based on the primary key given in the GET variable.
	* If the data model is not found, an HTTP exception will be raised.
	* @param integer the ID of the model to be loaded
	*/
	/*
	public function loadModel($id)
	{
		$model=Produto::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	 * 
	 */

	/**
	* Performs the AJAX validation.
	* @param CModel the model to be validated
	*/
	/*
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='produto-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	 * 
	 */
}

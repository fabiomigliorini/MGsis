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

	// public function actionImprimir($modelo, $impressora)
	// {
	// 	$retorno = array('Impresso'=>true, 'Mensagem'=>'');
	//
	// 	$etiquetaProduto = Yii::app()->session['EtiquetaProduto'];
	//
	// 	$quant = 0;
	//
	// 	foreach ($etiquetaProduto as $etiqueta)
	// 	{
	// 		$quant += $etiqueta['quantidade'];
	// 	}
	//
	// 	if ($quant == 0)
	// 	{
	// 		$retorno['Impresso'] = false;
	// 		$retorno['Mensagem'] = 'Nenhuma etiqueta selecionada!';
	// 	}
	// 	elseif (($modelo == '3colunas' || $modelo == '3colunas_sempreco') && $quant % 3 != 0)
	// 	{
	// 		$retorno['Impresso'] = false;
	// 		$retorno['Mensagem'] = 'Você precisa selecionar um múltiplo de 3 etiquetas!<br><br>Por exemplo, 3, 6, 9, 12...';
	// 	}
	// 	elseif (($modelo == '2colunas' || $modelo == '2colunas_sempreco') && $quant % 2 != 0)
	// 	{
	// 		$retorno['Impresso'] = false;
	// 		$retorno['Mensagem'] = 'Você precisa selecionar um múltiplo de 2 etiquetas!<br><br>Por exemplo, 2, 4, 6, 8...';
	// 	}
	// 	else
	// 	{
	//
	//
	// 		switch ($modelo)
	// 		{
	// 			case '2colunas':
	// 			case '2colunas_sempreco':
	// 				$colunas = 2;
	// 				$tamanhoDescricao = 32;
	// 				break;
	//
	// 			case '3colunas':
	// 			case '3colunas_sempreco':
	// 				$colunas = 3;
	// 				$tamanhoDescricao = 28;
	// 				break;
	//
	// 			default:
	// 				$colunas = 1;
	// 				$tamanhoDescricao = 45;
	// 				break;
	// 		}
	//
	// 		$layout = Yii::app()->basePath . "/../layoutEtiquetas/{$modelo}.txt";
	//
	// 		$coluna = 1;
	// 		$linha = 1;
	//
	// 		foreach ($etiquetaProduto as $etiqueta)
	// 		{
	// 			$pb = ProdutoBarra::model()->findByPk($etiqueta['codprodutobarra']);
	//
	//
	// 			for ($i=0; $i<$etiqueta['quantidade']; $i++)
	// 			{
	// 				$linhas[$linha][$coluna]['DescricaoLinha1'] = trim(substr($pb->descricao, 0, $tamanhoDescricao));
	// 				$linhas[$linha][$coluna]['DescricaoLinha2'] = trim(substr($pb->descricao, $tamanhoDescricao, $tamanhoDescricao));
	// 				$linhas[$linha][$coluna]['Codigo'] = Yii::app()->format->formataCodigo($pb->codproduto, 6);
	// 				$linhas[$linha][$coluna]['UnidadeMedida'] = $pb->UnidadeMedida->sigla;
	// 				if (isset($pb->ProdutoEmbalagem))
	// 					$linhas[$linha][$coluna]['UnidadeMedida'] .= ' ' .$pb->ProdutoEmbalagem->descricao;
	// 				$linhas[$linha][$coluna]['Preco'] = Yii::app()->format->formatNumber($pb->preco);
	//
	// 				if (strlen($linhas[$linha][$coluna]['Preco']) < 6)
	// 					$linhas[$linha][$coluna]['Preco'] = str_pad ($linhas[$linha][$coluna]['Preco'], 6, ' ', STR_PAD_LEFT);
	//
	// 				$linhas[$linha][$coluna]['Preco'] = str_replace(' ', '  ', $linhas[$linha][$coluna]['Preco']);
	//
	// 				/* Decide o tipo de codigo de barras
	// 				 * f42 - Ean13
	// 				 * g63 - Ean8
	// 				 * e63 subtipo A
	// 				 * e63 subtipo C - Code128 somente números Par
	// 				 * o42 - Code93 - nao le codigo "100182-8" no leitor metrologic - nao utilizar
	// 				 * a42 - Code3 of 9
	// 				 */
	//
	// 				$linhas[$linha][$coluna]['Barras'] = $pb->barras;
	// 				$linhas[$linha][$coluna]['NumeroBarras'] = $pb->barras;
	//
	// 				if ($pb->barrasEan13Valido())
	// 				{
	// 					$linhas[$linha][$coluna]['ModeloBarras'] = 'f42';
	// 					$linhas[$linha][$coluna]['SubsetBarras'] = '';
	// 				}
	// 				elseif ($pb->barrasEan8Valido())
	// 				{
	// 					$linhas[$linha][$coluna]['ModeloBarras'] = 'g63';
	// 					$linhas[$linha][$coluna]['SubsetBarras'] = '';
	// 				}
	// 				elseif ($pb->barrasCode128CValido())
	// 				{
	// 					if (strlen($linhas[$linha][$coluna]['Barras']) <= 10)
	// 						$linhas[$linha][$coluna]['ModeloBarras'] = 'e63';
	// 					else
	// 						$linhas[$linha][$coluna]['ModeloBarras'] = 'e42';
	// 					$linhas[$linha][$coluna]['SubsetBarras'] = 'C';
	// 				}
	// 				else
	// 				{
	// 					$linhas[$linha][$coluna]['ModeloBarras'] = 'e42';
	// 					$linhas[$linha][$coluna]['SubsetBarras'] = 'A';
	// 					//$linhas[$linha][$coluna]['ModeloBarras'] = 'o42';
	// 					//$linhas[$linha][$coluna]['SubsetBarras'] = '';
	// 				}
	//
	//
	// 				if (isset($pb->Produto->Marca))
	// 					$linhas[$linha][$coluna]['Marca'] = $pb->Produto->Marca->marca;
	// 				else
	// 					$linhas[$linha][$coluna]['Marca'] = '';
	//
	// 				if (isset($pb->referencia))
	// 					$linhas[$linha][$coluna]['Referencia'] = $pb->referencia;
	// 				else
	// 					$linhas[$linha][$coluna]['Referencia'] = $pb->Produto->referencia;
	//
	//
	// 				$linhas[$linha][$coluna]['Data'] = date('d/m/y');
	//
	// 				$coluna++;
	// 				if ($coluna>$colunas)
	// 				{
	// 					$coluna = 1;
	// 					$linha++;
	// 				}
	//
	// 			}
	//
	// 		}
	//
	// 		/*
	// 		echo '<pre>';
	// 		print_r($linhas);
	// 		print_r($etiqueta);
	// 		echo '</pre>';
	//
	// 		die();
	// 		 *
	// 		 */
	//
	// 		//die(Yii::app()->basePath . "/../layoutEtiquetas/{$layout}.txt");
	//
	// 		$template = file_get_contents($layout);
	//
	// 		foreach ($linhas as $linha)
	// 		{
	// 			$conteudo = $template;
	//
	// 			$icoluna = 1;
	// 			foreach ($linha as $coluna)
	// 			{
	// 				foreach ($coluna as $chave => $valor)
	// 				{
	// 					$conteudo = str_replace("<{$chave}Coluna{$icoluna}>", $valor, $conteudo);
	// 				}
	// 				$icoluna++;
	// 			}
	//
	// 			$arquivo = tempnam(sys_get_temp_dir(), "MGEtiqueta");
	// 			$handle = fopen($arquivo, "w");
	// 			fwrite($handle, $conteudo);
	// 			fclose($handle);
	// 			exec("lpr -l -P {$impressora} {$arquivo}");
	// 			/*
	// 			echo "Imprimiu";
	// 			echo "<pre>";
	// 			echo CHtml::encode(file_get_contents($arquivo));
	// 			echo "</pre>";
	// 			 *
	// 			 */
	// 			unlink($arquivo);
	//
	// 		}
	//
	//
	// 		/*
	// 		 *
	// 		 *
	// 		1911A0600700005<DescricaoLinha1Etiqueta1>
	// 		1911A0600610005<DescricaoLinha2Etiqueta1>
	// 		1911A0600520005<CodigoEtiqueta1>
	// 		1911A0600430005<UnidadeMedidaEtiqueta1>
	// 		1911A0600480065R$
	// 		1911A0800480076<PrecoEtiqueta1>
	// 		1e4203200110005C<BarrasEtiqueta1>
	// 		1911A0600010005<NumeroBarrasEtiqueta1>
	//
	// 		 */
	// 	}
	//
	// 	//$retorno['Mensagem'] .= '<pre>' . print_r($_POST, true) . '</pre>';
	//
	//
	// 	/*
	// 	if ($pb = ProdutoBarra::model()->findByBarras($barras))
	// 	{
	//
	// 		if (!isset(Yii::app()->session['EtiquetaProduto']))
	// 			Yii::app()->session['EtiquetaProduto'] = array();
	//
	// 		$etiquetaProduto = Yii::app()->session['EtiquetaProduto'];
	//
	// 		$etiquetaProduto[] =
	// 			array(
	// 				"codprodutobarra" => $pb->codprodutobarra,
	// 				"quantidade" => $quantidade,
	// 				);
	//
	// 		Yii::app()->session['EtiquetaProduto'] = $etiquetaProduto;
	//
	// 	}
	// 	else
	// 	{
	// 		$retorno["Adicionado"] = false;
	// 		$retorno["Mensagem"] = "Produto '$barras' não localizado!";
	// 	}
	// 	*/
	//
	// 	echo CJSON::encode($retorno);
	//
	// }


	/**
	* Lists all models.
	*/
	public function actionIndex()
	{
		$this->redirect(MGSPA_URL . "etiqueta");
		// $model=new Produto('search');
		//
		// $model->unsetAttributes();  // clear any default values
		//
		// if(isset($_GET['Produto']))
		// 	Yii::app()->session['FiltroProdutoIndex'] = $_GET['Produto'];
		//
		// if (isset(Yii::app()->session['FiltroProdutoIndex']))
		// 	$model->attributes=Yii::app()->session['FiltroProdutoIndex'];
		//
		// $this->render('index',array(
		// 	'dataProvider'=>$model->search(),
		// 	'model'=>$model,
		// 	));
	}

	// public function actionAdicionarProduto($barras, $quantidade=1)
	// {
	//
	// 	$retorno = array("Adicionado"=>true, "Mensagem"=>"");
	//
	// 	if ($pb = ProdutoBarra::model()->findByBarras($barras))
	// 	{
	//
	// 		if (!isset(Yii::app()->session['EtiquetaProduto']))
	// 			Yii::app()->session['EtiquetaProduto'] = array();
	//
	// 		$etiquetaProduto = Yii::app()->session['EtiquetaProduto'];
	//
	// 		$etiquetaProduto[] =
	// 			array(
	// 				"codprodutobarra" => $pb->codprodutobarra,
	// 				"quantidade" => $quantidade,
	// 				);
	//
	// 		Yii::app()->session['EtiquetaProduto'] = $etiquetaProduto;
	//
	// 	}
	// 	else
	// 	{
	// 		$retorno["Adicionado"] = false;
	// 		$retorno["Mensagem"] = "Produto '$barras' não localizado!";
	// 	}
	//
	// 	echo CJSON::encode($retorno);
	//
	// }

}

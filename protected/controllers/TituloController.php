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
	
	public function actionImprimeVale($id)
	{
		
		$model = $this->loadModel($id);
		
		//inicializa
		$teste = new MGEscPrint();
		$teste->adicionaTexto("<Reset><6lpp><Draft><CondensedOff>", "cabecalho");
		
		//linha divisoria
		$teste->adicionaLinha("", "cabecalho", 80, STR_PAD_RIGHT, "=");
		
		// Fantasia e NUMERO do Vale
		$teste->adicionaTexto("<DblStrikeOn>", "cabecalho");
		$teste->adicionaTexto($model->Filial->Pessoa->fantasia . " " . $model->Filial->Pessoa->telefone1, "cabecalho", 56);
		$teste->adicionaTexto("Titulo:        " . Yii::app()->format->formataCodigo($model->codtitulo), "cabecalho", 24);
		$teste->adicionaTexto("<DblStrikeOff>", "cabecalho");
		$teste->adicionaLinha("", "cabecalho");
		
		// Usuario e Data
		if (isset($model->codusuariocriacao))
			$usuario = $model->UsuarioCriacao->usuario;
		else
			$usuario = Yii::app()->user->name;
		$teste->adicionaTexto("Usuario: " . $usuario, "cabecalho", 56);
		$teste->adicionaTexto("Data..: " . $model->sistema, "cabecalho", 24);
		$teste->adicionaLinha("", "cabecalho");
		
		//linha divisoria
		$teste->adicionaLinha("", "cabecalho", 80, STR_PAD_RIGHT, "=");

		//forca impressao cabecalho primeira pagina
		//$teste->cabecalho();

		//Rodape
		$teste->adicionaTexto("", "rodape", 80, STR_PAD_RIGHT, "=");
		
		//titulo
		$teste->adicionaLinha("");
		$teste->adicionaTexto("<LargeOn>");
		$teste->adicionaTexto("<DblStrikeOn>");
		$teste->adicionaTexto("V A L E", "documento", 40, STR_PAD_BOTH);
		$teste->adicionaTexto("<DblStrikeOff>");
		$teste->adicionaTexto("<LargeOff>");
		$teste->adicionaLinha("");

		//Numero titulo
		$teste->adicionaTexto("Numero....:", "documento", 12);
		$teste->adicionaTexto($model->numero, "documento", 68);
		$teste->adicionaLinha();
		
		//Espaco
		$teste->adicionaLinha();
		
		//Fantasia
		$teste->adicionaTexto("<DblStrikeOn>");
		$teste->adicionaTexto("Favorecido: ");
		$teste->adicionaTexto($model->Pessoa->fantasia . " (" .Yii::app()->format->formataCodigo($model->codpessoa) . ")", "documento", 68);
		$teste->adicionaTexto("<DblStrikeOff>");
		$teste->adicionaLinha();

		//Telefone
		$teste->adicionaTexto("", "documento", 12);
		$teste->adicionaTexto("{$model->Pessoa->telefone1} / {$model->Pessoa->telefone2} / {$model->Pessoa->telefone3}", "documento", 68);
		$teste->adicionaLinha();
		
		//Razao Social
		$teste->adicionaTexto("", "documento", 12);
		$teste->adicionaTexto($model->Pessoa->pessoa, "documento", 68);
		$teste->adicionaLinha();
		
		//Cnpj
		$teste->adicionaTexto("", "documento", 12);
		$teste->adicionaTexto("CNPJ/CPF: " . Yii::app()->format->formataCnpjCpf($model->Pessoa->cnpj, $model->Pessoa->fisica), "documento", 29);
		if (!empty($model->Pessoa->ie))
			$teste->adicionaTexto("- Inscricao Estadual: " .Yii::app()->format->formataInscricaoEstadual($model->Pessoa->ie, $model->Pessoa->Cidade->Estado->sigla), "documento", 38);
		$teste->adicionaLinha();

		//Espaco
		$teste->adicionaLinha();
		
		//Extenso
		$teste->adicionaTexto("<DblStrikeOn>");
		$linhas = Yii::app()->format->formataValorPorExtenso($model->creditosaldo, true);
		$linhas = "R$ " . Yii::app()->format->formatNumber($model->creditosaldo) . " ($linhas)";
		$linhas = str_split($linhas, 68);
		$label = "Valor.....:";
		foreach ($linhas as $linha)
		{
			$teste->adicionaTexto($label, "documento", 12);
			$teste->adicionaTexto(trim($linha), "documento", 68);
			$teste->adicionaLinha();
			$label = "";
		}
		$teste->adicionaTexto("<DblStrikeOff>");
		
		// Espaco
		$teste->adicionaLinha();

		//Observacao
		if (!empty($model->observacao))
		{
			$label = "Observacao:";
			$linhas = str_split($model->observacao, 68);
			foreach ($linhas as $linha)
			{
				$teste->adicionaTexto($label, "documento", 12);
				$teste->adicionaTexto(trim($linha), "documento", 68);
				$teste->adicionaLinha();
				$label = "";
			}
			
			// Espaco
			$teste->adicionaLinha();
		}
		

		// Data por extenso
		$teste->adicionaTexto("", "documento", 12);
		$teste->adicionaTexto($model->Filial->Pessoa->Cidade->cidade);
		$teste->adicionaTexto("/");
		$teste->adicionaTexto($model->Filial->Pessoa->Cidade->Estado->sigla);
		$teste->adicionaTexto(", ");
		$teste->adicionaTexto(Yii::app()->format->formataDataPorExtenso($model->emissao));
		$teste->adicionaTexto(".");
		$teste->adicionaLinha();

		// Espaco
		$teste->adicionaLinha();
		$teste->adicionaLinha();
		$teste->adicionaLinha();

		//Assinatura
		$teste->adicionaTexto("", "documento", 12);
		$teste->adicionaTexto("", "documento", 50, STR_PAD_RIGHT, "-");
		$teste->adicionaLinha();
		$teste->adicionaTexto("", "documento", 12);
		$teste->adicionaTexto($model->Filial->Pessoa->pessoa, "documento", 50);
		$teste->adicionaLinha();
		
		$teste->prepara();
		//echo $teste->imprimir();
		echo "<pre>";
		echo $teste->converteHtml();
		echo "</pre>";
	}
	
}

/*
 *               1          1          1          1          1          1          1          1          1          1          1          1
 * 2x0=========================================================================================================================================
E
MG PAPELARIA CENTRO - Fone (66) 3531-1045                   Vale:      #10007463
12345678901234567890123456789012345678901234567890123456789012345678901234567890
         1         2         3         4         5         6         7         8
Usuario: escmig98                                           Data: 01/08/13 11:59
=========================================================================================================================================

W1E         RECIBO        Valor R$ 3.184,28FW0

Recebemos de #860 EESCRITEC ESCRITORIO TECNICO CONTABIL S/CF, CNPJ 37.500.204/
0001-00, a importancia de Tres Mil Cento e Ointenta e Quatro Reais e Vinte e Oit
o Centavos referente ao pagamento dos titulos abaixo listados:                  

-----------------------------------------------------------------------------------------------------------------------------------------
Numero                  Emissao         Vencimento           Valor Original          Pagamento       Juros    Desconto              Total
-----------------------------------------------------------------------------------------------------------------------------------------
N30187239-1/1           03/04/13        03/05/13                       3,45               3,45        0,00        0,00G               3,45H
N10110203-1/1           04/04/13        04/05/13                     285,00             285,00        0,00        0,00G             285,00H
N30191150-1/3           12/04/13        12/05/13                      73,00              73,00        0,00        0,00G              73,00H
N10112991-1/1           18/04/13        18/05/13                       1,60               1,60        0,00        0,00G               1,60H
N10113536-1/1           20/04/13        20/05/13                     119,40             119,40        0,00        0,00G             119,40H
N10114483-1/1           25/04/13        25/05/13                      12,25              12,25        0,00        0,00G              12,25H
N10114380-1/1           25/04/13        25/05/13                     354,39             354,39        0,00        0,00G             354,39H
N10114635-1/1           26/04/13        26/05/13                      31,50              31,50        0,00        0,00G              31,50H
N30197587-1/1           30/04/13        30/05/13                      12,85              12,85        0,00        0,00G              12,85H
N10115954-1/1           04/05/13        03/06/13                      85,15              85,15        0,00        0,00G              85,15H
N10116248-1/1           06/05/13        05/06/13                       7,05               7,05        0,00        0,00G               7,05H
N30199689-1/1           06/05/13        05/06/13                      65,00              65,00        0,00        0,00G              65,00H
N10116890-1/1           08/05/13        07/06/13                      13,50              13,50        0,00        0,00G              13,50H
N30200504-1/1           08/05/13        07/06/13                      28,30              28,30        0,00        0,00G              28,30H
N30201423-1/1           09/05/13        08/06/13                      12,25              12,25        0,00        0,00G              12,25H
N30191150-2/3           12/04/13        11/06/13                      73,00              73,00        0,00        0,00G              73,00H
N30203325-1/1           14/05/13        13/06/13                      19,00              19,00        0,00        0,00G              19,00H
N30203346-1/1           14/05/13        13/06/13                      28,20              28,20        0,00        0,00G              28,20H
N30204041-1/1           15/05/13        14/06/13                     158,00             158,00        0,00        0,00G             158,00H
N30204625-1/1           16/05/13        15/06/13                       9,00               9,00        0,00        0,00G               9,00H
N30204408-1/1           16/05/13        15/06/13                     266,00             266,00        0,00        0,00G             266,00H
N10120295-1/1           24/05/13        23/06/13                      21,70              21,70        0,00        0,00G              21,70H
N10120440-1/1           25/05/13        24/06/13                      74,35              74,35        0,00        0,00G              74,35H
N30209212-1/1           28/05/13        27/06/13                     130,05             130,05        0,00        0,00G             130,05H
N30210202-1/1           31/05/13        30/06/13                      21,80              21,80        0,00        0,00G              21,80H
N10122110-1/1           04/06/13        04/07/13                     269,70             269,70        0,00        0,00G             269,70H
N10123019-1/1           08/06/13        08/07/13                      13,50              13,50        0,00        0,00G              13,50H
N30191150-3/3           12/04/13        11/07/13                      73,90              73,90        0,00        0,00G              73,90H
N30215814-1/1           12/06/13        12/07/13                      40,25              40,25        0,00        0,00G              40,25H
N10124651-1/1           18/06/13        18/07/13                      56,00              56,00        0,00        0,00G              56,00H
N10124788-1/1           18/06/13        18/07/13                      74,00              74,00        0,00        0,00G              74,00H
N10125386-1/1           21/06/13        21/07/13                     369,59             369,59        0,00        0,00G             369,59H
N10126158-1/1           25/06/13        25/07/13                      40,35              40,35        0,00        0,00G              40,35H
N10126084-1/1           25/06/13        25/07/13                      86,00              86,00        0,00        0,00G              86,00H
N10126378-1/1           26/06/13        26/07/13                      16,40              16,40        0,00        0,00G              16,40H
N10126990-1/1           28/06/13        28/07/13                       9,25               9,25        0,00        0,00G               9,25H
N10127089-1/1           28/06/13        28/07/13                      62,60              62,60        0,00        0,00G              62,60H
N10127415-1/1           01/07/13        31/07/13                     166,95             166,95        0,00        0,00G             166,95H
-----------------------------------------------------------------------------------------------------------------------------------------

                                                  Sinop/MT, 1 de Agosto de 2013.



F                                                                    ---------------------------------------------------------------------
                                                                                     Sinopel Papelaria Ltda Epp (Cnpj 14.382.639/0001-93)
                                                                                 Av das Sibipirunas, 3411 - Centro - Sinop/MT - 78550-230

 */

<?php

class NfeTerceiroItemController extends Controller
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

	public function actionDividir($id)
	{
		$this->render('dividir',array(
			'model'=>$this->loadModel($id),
			));
	}

	public function actionDividirSalvar($id)
	{
		$model = $this->loadModel($id);

		// Multiplica por 100 nitem caso seja nova "dividida"
		$command = Yii::app()->db->createCommand("select max(nitem) as max, count(*) as qtd from tblnfeterceiroitem where codnfeterceiro = {$model->codnfeterceiro}");
		$itens = $command->queryAll();
		if ($itens[0]['max'] == $itens[0]['qtd']) {
			Yii::app()->db
					->createCommand("update tblnfeterceiroitem set nitem = nitem * 100 where codnfeterceiro = {$model->codnfeterceiro}")
					->execute();
			$model = $this->loadModel($id);
		}

		// define percentuais
		$parcelas = intval($_POST['NfeTerceiroItem_parcelas']);
		switch ($parcelas) {
			case 2:
				$percentuais = [55, 45];
				break;

			case 3:
				$percentuais = [39, 33, 28];
				break;

			case 4:
				$percentuais = [30, 27, 23, 20];
				break;

			case 5:
				$percentuais = [26, 23, 20, 17, 14];
				break;

			case 6:
				$percentuais = [24, 20, 17, 15, 13, 11];
				break;

			case 10:
				$percentuais = [15, 14, 13, 12, 11, 9, 8, 7, 6, 5];
				break;

			default:
				$this->redirect(array('view','id'=>$model->codnfeterceiroitem));
				break;
		}

		echo '<pre>';
		$vuncom = 0;
		$vprod = 0;
		$vbc = 0;
		$vicms = 0;
		$vbcst = 0;
		$vicmsst = 0;
		$ipivbc = 0;
		$ipivipi = 0;
		$complemento = 0;
		$vdesc = 0;
		for ($i=$parcelas-1; $i >= 0; $i--) {

			$nitem = $model->nitem + ($i);
			$percentual = $percentuais[$i] / 100;
			$sufixo = ' ' . str_pad($i+1, 2, '0', STR_PAD_LEFT) . '/' . str_pad($parcelas, 2, '0', STR_PAD_LEFT);
			// die();

			if ($i == 0) {
				$model->nitem = $nitem;
				$model->cprod .= $sufixo;
				$model->xprod .= $sufixo;
				$model->vuncom -= $vuncom;
				$model->vprod -= $vprod;
				$model->vbc -= $vbc;
				$model->vicms -= $vicms;
				$model->vbcst -= $vbcst;
				$model->vicmsst -= $vicmsst;
				$model->ipivbc -= $ipivbc;
				$model->ipivipi -= $ipivipi;
				$model->complemento -= $complemento;
				$model->vdesc -= $vdesc;
				// print_r($model);
				$model->save();
			} else {

				$novo = new NfeTerceiroItem;
				$novo->attributes = $model->attributes;
				$novo->nitem = $nitem;
				$novo->cprod .= $sufixo;
				$novo->xprod .= $sufixo;
				$novo->vuncom = round($model->vuncom * $percentual, 6);
				$vuncom += $novo->vuncom;
				$novo->vprod = round($novo->vuncom * $novo->qcom, 2);
				$vprod += $novo->vprod;
				$novo->vbc = round($model->vbc * $percentual, 2);
				$vbc += $novo->vbc;
				$novo->vicms = round($model->vicms * $percentual, 2);
				$vicms += $novo->vicms;
				$novo->vbcst = round($model->vbcst * $percentual, 2);
				$vbcst += $novo->vbcst;
				$novo->vicmsst = round($model->vicmsst * $percentual, 2);
				$vicmsst += $novo->vicmsst;
				$novo->ipivbc = round($model->ipivbc * $percentual, 2);
				$ipivbc += $novo->ipivbc;
				$novo->ipivipi = round($model->ipivipi * $percentual, 2);
				$ipivipi += $novo->ipivipi;
				$novo->complemento = round($model->complemento * $percentual, 2);
				$complemento += $novo->complemento;
				$novo->vdesc = round($model->vdesc * $percentual, 2);
				$vdesc += $novo->vdesc;
				$novo->codprodutobarra = null;
				// print_r($novo);
				$novo->save();
			}
		}

		$this->redirect(array('view','id'=>$model->codnfeterceiroitem));
	}

	/**
	* Creates a new model.
	* If creation is successful, the browser will be redirected to the 'view' page.
	*/
	/*
	public function actionCreate()
	{
		$model=new NfeTerceiroItem;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['NfeTerceiroItem']))
		{
			$model->attributes=$_POST['NfeTerceiroItem'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->codnfeterceiroitem));
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
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		if (!$model->podeEditar())
			throw new CHttpException(409, 'Registro não permite edição.');

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['NfeTerceiroItem']))
		{
			$model->attributes=$_POST['NfeTerceiroItem'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->codnfeterceiroitem));
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

	/**
	* Lists all models.
	*/
	public function actionIndex()
	{
		$model=new NfeTerceiroItem('search');

		$model->unsetAttributes();  // clear any default values

		if(isset($_GET['NfeTerceiroItem']))
			Yii::app()->session['FiltroNfeTerceiroItemIndex'] = $_GET['NfeTerceiroItem'];

		if (isset(Yii::app()->session['FiltroNfeTerceiroItemIndex']))
			$model->attributes=Yii::app()->session['FiltroNfeTerceiroItemIndex'];

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

		$model=new NfeTerceiroItem('search');

		$model->unsetAttributes();  // clear any default values

		if(isset($_GET['NfeTerceiroItem']))
			$model->attributes=$_GET['NfeTerceiroItem'];

		$this->render('admin',array(
			'model'=>$model,
			));
	}
	 *
	 */

	/**
	* Returns the data model based on the primary key given in the GET variable.
	* If the data model is not found, an HTTP exception will be raised.
	* @param integer the ID of the model to be loaded
	*/
	public function loadModel($id)
	{
		$model=NfeTerceiroItem::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='nfe-terceiro-item-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionConferencia($id)
    {
        $model = $this->loadModel($id);
        if ($_GET['conferencia'] == 'true') {
            $model->conferencia = date('d/m/Y H:i:s');
            $model->codusuarioconferencia = Yii::app()->user->id;
        } else {
            $model->conferencia = null;
            $model->codusuarioconferencia = null;
        }
        $model->save();
        $sql = '
            select count(*) as count
            from tblnfeterceiroitem
            where codnfeterceiro = :codnfeterceiro
            and conferencia is null
        ';
        $cmd = Yii::app()->db->createCommand($sql);
        $cmd->params = [
            'codnfeterceiro' => $model->codnfeterceiro
        ];
        $res = $cmd->queryAll();
        if ($res[0]['count'] == 0) {
            $model->NfeTerceiro->conferencia = date('d/m/Y H:i:s');
            $model->NfeTerceiro->codusuarioconferencia = Yii::app()->user->id;
            $model->NfeTerceiro->save();
        }
        header('Content-type: application/json');
        echo CJSON::encode([
            'codnfeterceiroitem' => $model->codnfeterceiroitem,
            'conferencia' => $model->conferencia,
            'codusuarioconferencia' => $model->codusuarioconferencia,
            'res' => $res,
        ]);
    }

}

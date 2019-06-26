<?php

class CestController extends Controller
{
	/**
	* Returns the data model based on the primary key given in the GET variable.
	* If the data model is not found, an HTTP exception will be raised.
	* @param integer the ID of the model to be loaded
	*/
	public function loadModelNcm($id)
	{
		$model=Ncm::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	
	public function actionAjaxBuscaCest($codncm=0) 
	{

		$ncm = $this->loadModelNcm($codncm);
		$cests = $ncm->cestsDisponiveis();
		$resultados = array();
		foreach($cests as $cest)
		{
			$resultados[] = array(
				'id' => $cest->codcest,
				'ncm' => Yii::app()->format->formataNcm($cest->Ncm->ncm),
				'cest' => Yii::app()->format->formataCest($cest->cest),
				'descricao' => $cest->descricao,
				);
			
		}
		
		// transforma o array em JSON
		echo CJSON::encode(
				array(
					'mais' => false, 
					'pagina' => 1, 
					'itens' => $resultados
					)
				);
		
		// FIM
		Yii::app()->end();
	} 
	
	public function actionAjaxInicializaCest() 
	{
		if (isset($_GET['cod']))
		{
			$cest = Cest::model()->findByPk($_GET['cod']	);
			echo CJSON::encode(
				array(
					'id' => $cest->codcest,
					'ncm' => Yii::app()->format->formataNcm($cest->Ncm->ncm),
					'cest' => Yii::app()->format->formataCest($cest->cest), 
					'descricao' => $cest->descricao
				)
			);
		}
		Yii::app()->end();
	} 
	
}

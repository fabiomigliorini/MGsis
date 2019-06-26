<?php

//Yii::import('/var/www/NFePHP/101/libs/NFe/*');



class NFePHPController extends Controller
{
	/**
	* Gera um arquivo PDF com a Danfe
	* @param integer $codnotafiscal o codigo da Nota Fiscal
	* @param boolean $imprimir o codigo da Nota Fiscal
	*/
	public function actionDanfe($codnotafiscal, $imprimir = false)
	{
		
		/* 
		 * @var NotaFiscal $nf
		 */
		$nf = $this->loadModelNotaFiscal($codnotafiscal);
		
		//require_once('/var/www/NFePHP/101/libs/NFe/DanfeNFCeNFePHP.class.php');
		require_once('/var/www/NFePHP/' . $nf->codfilial . '/libs/NFe/DanfeNFCeNFePHP.class.php');

		//Baixa XML
		$urlxml = $nf->Filial->acbrnfemonitorcaminhorede . 'NFe/' . substr($nf->emissao, 6, 4) . substr($nf->emissao, 3, 2)  . '/' . $nf->nfechave . '-nfe.xml';
		$xml = file_get_contents($urlxml);
		
		//Monta Danfe
		$danfe = new DanfeNFCeNFePHP($xml, '/var/www/NFePHP/Imagens/MGPapelariaSeloPretoBranco.jpg', 0, $nf->Filial->nfcetokenid, $nf->Filial->nfcetoken);
		$id = $danfe->montaDANFE(true);
		
		//Decide Impressora
		$impressora = null;
		if ($imprimir == 1)
			$impressora = Yii::app()->user->impressoraTermica;
		
		//Imprime
		$arquivo = "{$nf->nfechave}.pdf";
		$teste = $danfe->printDANFE('pdf', $arquivo, 'I', $impressora);
		
	}
	
	/**
	* Carrega o Model de Nota Fiscal
	* @param integer $codnotafiscal o codigo da Nota Fiscal
	* @return NotaFiscal
	*/
	public function loadModelNotaFiscal($codnotafiscal)
	{
		$model = NotaFiscal::model()->findByPk($codnotafiscal);
		if($model === null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	
}
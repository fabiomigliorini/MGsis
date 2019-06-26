<?php

/**
 * @property NotaFiscal $model
 */

class MGNotaFiscalBotoes extends CWidget
{
	
	public $model = null;
	
	
	public function js ()
	{
		static $incluirJS = true;
		if (!$incluirJS)
			return;
		$this->controller->renderPartial('application.components.MGNotaFiscalBotoes._javascript'); 
		$this->controller->renderPartial('application.components.MGNotaFiscalBotoes._modal_danfe'); 
		$incluirJS = false;
		
	}
	
	public function run()
	{
		$this->js();
		if (!empty($this->model))
			$this->controller->renderPartial('application.components.MGNotaFiscalBotoes._botoes', array('model'=>$this->model)); 
	}
	
}
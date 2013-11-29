<?php

Yii::import("bootstrap.widgets.TbActiveForm");

class MGActiveForm extends TbActiveForm
{
	public function init()
	{
		
		$this->type = 'horizontal';
		$this->enableAjaxValidation = true;
		
		return parent::init();
		
	}
	
	public function select2PessoaRow($model, $attribute, $htmlOptions = array())
	{
		$widget = $this->widget(
			'MGSelect2Pessoa',
			array(
				'model' => $model,
				'attribute' => $attribute,
				'htmlOptions' => $htmlOptions,
			),
			true);		

		return $this->customRow($model, 'codpessoa', $widget);
		
		//return $this->inputRow('MGSelect2Pessoa', $model, $attribute, null, $htmlOptions);
		//return $this->inputRow(MGInputWidget::TYPE_SELECT2PESSOA, $model, $attribute, null, $htmlOptions);		
	}
	
}
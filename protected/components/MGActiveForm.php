<?php

Yii::import("bootstrap.widgets.TbActiveForm");

class MGActiveForm extends TbActiveForm
{
	public $type = 'horizontal';
	public $enableAjaxValidation = true;
	
	public function select2PessoaRow($model, $attribute, $htmlOptions = array())
	{
		$widget = $this->select2Pessoa($model, $attribute, $htmlOptions);
		return $this->customRow($model, 'codpessoa', $widget);
	}

	public function select2Pessoa($model, $attribute, $htmlOptions = array())
	{
		$widget = $this->widget(
			'MGSelect2Pessoa',
			array(
				'model' => $model,
				'attribute' => $attribute,
				'htmlOptions' => $htmlOptions,
			),
			true);		
		return $widget;
	}

	public function select2CidadeRow($model, $attribute, $htmlOptions = array())
	{
		$widget = $this->select2Cidade($model, $attribute, $htmlOptions);
		return $this->customRow($model, 'codcidade', $widget);
	}

	public function select2Cidade($model, $attribute, $htmlOptions = array())
	{
		$widget = $this->widget(
			'MGSelect2Cidade',
			array(
				'model' => $model,
				'attribute' => $attribute,
				'htmlOptions' => $htmlOptions,
			),
			true);		
		return $widget;
	}

}
<?php

Yii::import("bootstrap.widgets.TbActiveForm");

class MGActiveForm extends TbActiveForm
{
	public $type = 'horizontal';
	public $enableAjaxValidation = true;

	public function select2Row($model, $attribute, $data, $htmlOptions = array())
	{
		$widget = $this->select2Marca($model, $attribute, $htmlOptions);
		return $this->customRow($model, 'codmarca', $widget);
	}

	public function select2($model, $attribute, $data, $htmlOptions = array())
	{
		$htmlOptions["prompt"] = "";
		$widget = $this->widget(
			'bootstrap.widgets.TbSelect2',
			array(
				'model' => $model,
				'attribute' => $attribute,
				'data' => $data,
				'options'=>array(
					'allowClear'=>true,
				),
				'htmlOptions'=>$htmlOptions
			),
			true
		);
		return $widget;
	}
	
	
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

	public function select2MarcaRow($model, $attribute, $htmlOptions = array())
	{
		$widget = $this->select2Marca($model, $attribute, $htmlOptions);
		return $this->customRow($model, 'codmarca', $widget);
	}

	public function select2Marca($model, $attribute, $htmlOptions = array())
	{
		$widget = $this->widget(
			'MGSelect2Marca',
			array(
				'model' => $model,
				'attribute' => $attribute,
				'htmlOptions' => $htmlOptions,
			),
			true);		
		return $widget;
	}
	
}
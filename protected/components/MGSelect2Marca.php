<?php

Yii::import("bootstrap.widgets.TbSelect2");

class MGSelect2Marca extends TbSelect2
{

	
	public function init()
	{
		
		$this->asDropDownList = false;

		if (!isset($this->htmlOptions['class'])) 
			$this->htmlOptions['class'] = 'input-medium';
		
		if (!isset($this->htmlOptions['placeholder'])) 
			$this->htmlOptions['placeholder'] = 'Marca';
		
		$this->options = array(
					'minimumInputLength'=>1,
					'allowClear' => true,
					'closeOnSelect' => true,
					'placeholder' => 'Marca',
					'formatResult' => 'js:function(item) 
						{
							var markup = "<div class=\'row-fluid\'>";
							markup    += item.marca;
							markup    += "</div>";
							return markup;
						}',
					'formatSelection' => 'js:function(item) { return item.marca; }',
					'ajax' => array(
						'url' =>  Yii::app()->createUrl('marca/ajaxbuscamarca'),
						'dataType' => 'json',
						'quietMillis' => 500,
						'data' => 'js:function(term,page) { return {texto: term, limite: 20, pagina: page}; }',
						'results' => 'js:function(data,page) 
							{
								var more = (page * 20) < data.total;
								return {results: data.itens, more: data.mais};
							}',						
						),
					'initSelection'=>'js:function (element, callback) {
							$.ajax({
								type: "GET",
								url: "'. Yii::app()->createUrl('marca/ajaxinicializamarca') .'",
								data: "cod='. $this->model->{$this->attribute} .'",
								dataType: "json",
								success: function(result) { callback(result); }
								});
							}',
					);

		return parent::init();
		
	}
		
}
<?php

Yii::import("bootstrap.widgets.TbSelect2");

class MGSelect2Cidade extends TbSelect2
{

	
	public function init()
	{
		
		$this->asDropDownList = false;

		if (!isset($this->htmlOptions['class'])) 
			$this->htmlOptions['class'] = 'input-xlarge';
		
		if (!isset($this->htmlOptions['placeholder'])) 
			$this->htmlOptions['placeholder'] = 'Cidade';
		
		$this->options = array(
					'minimumInputLength'=>3,
					'allowClear' => true,
					'closeOnSelect' => true,
					'placeholder' => 'Cidade',
					'formatResult' => 'js:function(item) 
						{
							var markup = "<div class=\'row-fluid\'>";
							markup    += "<b>" + item.cidade + "</b>";
							markup    += "<span style=\'width:25px\' class=\'pull-right\'>" + item.uf + "</span>";
							markup    += "</div>";
							return markup;
						}',
					'formatSelection' => 'js:function(item) { return item.cidade + "/" + item.uf; }',
					'ajax' => array(
						'url' =>  Yii::app()->createUrl('cidade/ajaxbuscacidade'),
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
								url: "'. Yii::app()->createUrl('cidade/ajaxinicializacidade') .'",
								data: "cod='. $this->model->{$this->attribute} .'",
								dataType: "json",
								success: function(result) { callback(result); }
								});
							}',
					);

		return parent::init();
		
	}
		
}
<?php

Yii::import("bootstrap.widgets.TbSelect2");

class MGSelect2Pessoa extends TbSelect2
{

	public function init()
	{
		
		$this->asDropDownList = false;

		if (!isset($this->htmlOptions['class'])) 
			$this->htmlOptions['class'] = 'span6';
		
		if (!isset($this->htmlOptions['placeholder'])) 
			$this->htmlOptions['placeholder'] = ' ';
		
		$this->options = array(
					'minimumInputLength'=>3,
					'allowClear' => true,
					'closeOnSelect' => true,
					'placeholder' => 'Pessoa',
					'formatResult' => 'js:function(item) 
						{
							var markup = "<div class=\'div-combo-pessoa\'>";
							markup    += "<div class=\'div-combo-pessoa-fantasia\'>" + item.fantasia             + "</div>";
							markup    += "<div class=\'div-combo-pessoa-codigo\'>#"  + formataCodigo(item.id)    + "</div>";
							markup    += "<div class=\'div-combo-pessoa-pessoa\'>"   + item.pessoa               + "</div>";
							markup    += "<div class=\'div-combo-pessoa-cnpj\'>"     + formataCnpjCpf(item.cnpj) + "</div>";
							markup    += "</div>";
							markup    += "</div>";
							return markup;
						}',
					'formatSelection' => 'js:function(item) { return item.fantasia; }',
					'ajax' => array(
						'url' =>  Yii::app()->createUrl('pessoa/ajaxbuscapessoa'),
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
								url: "'. Yii::app()->createUrl('pessoa/ajaxinicializapessoa') .'",
								data: "cod='. $this->model->codpessoa .'",
								dataType: "json",
								success: function(result) { callback(result); }
								});
							}',
					);

		return parent::init();
		
	}
		
}
<?php

Yii::import("bootstrap.widgets.TbSelect2");

class MGSelect2Ncm extends TbSelect2
{

	public function init()
	{
		
		$this->asDropDownList = false;

		if (!isset($this->htmlOptions['class'])) 
			$this->htmlOptions['class'] = 'input-xxlarge';
		
		if (!isset($this->htmlOptions['placeholder'])) 
			$this->htmlOptions['placeholder'] = 'NCM';
		
		if (!empty($this->htmlOptions["inativo"]))
			$inativo = 1;
		else 
			$inativo = 0;

		if (!empty($this->htmlOptions["vendedor"]))
			$vendedor = 1;
		else 
			$vendedor = 0;
		
		$this->options = array(
					'minimumInputLength'=>2,
					'allowClear' => true,
					'closeOnSelect' => true,
					'placeholder' => 'NCM',
					'formatResult' => 'js:function(item) 
						{
							var markup = "";
							markup    += "<b>" + item.ncm + "</b>&nbsp;";
							markup    += "<span>" + item.descricao + "</span>";
							return markup;
						}',
					'formatSelection' => 'js:function(item) { return item.ncm + "&nbsp;" + item.descricao; }',
					'ajax' => array(
						'url' =>  Yii::app()->createUrl('ncm/ajaxbuscancm', array("inativo"=>$inativo, "vendedor"=>$vendedor)),
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
								url: "'. Yii::app()->createUrl('ncm/ajaxinicializancm') .'",
								data: "cod='. $this->model->{$this->attribute} .'",
								dataType: "json",
								success: function(result) { callback(result); }
								});
							}',
					);

		return parent::init();
		
	}
		
}
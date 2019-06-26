<?php

Yii::import("bootstrap.widgets.TbSelect2");

class MGSelect2Pessoa extends TbSelect2
{

	public function init()
	{
		
		$this->asDropDownList = false;

		if (!isset($this->htmlOptions['class'])) 
			$this->htmlOptions['class'] = 'input-xxlarge';
		
		if (!isset($this->htmlOptions['placeholder'])) 
			$this->htmlOptions['placeholder'] = 'Pessoa';
		
		if (!empty($this->htmlOptions["inativo"]))
			$inativo = 1;
		else 
			$inativo = 0;

		if (!empty($this->htmlOptions["vendedor"]))
			$vendedor = 1;
		else 
			$vendedor = 0;
		
		$this->options = array(
					'minimumInputLength'=>3,
					'allowClear' => true,
					'closeOnSelect' => true,
					'placeholder' => 'Pessoa',
					'formatResult' => 'js:function(item) 
						{
						
							var css = "div-combo-pessoa";
							if (item.inativo)
								var css = "text-error";
								
							var css_titulo = "";
							var css_detalhes = "muted";
							if (item.inativo)
							{
								css_titulo = "text-error";
								css_detalhes = "text-error";
							}
							
							var nome = item.fantasia;
							
							if (item.inclusaoSpc != 0)
								nome += "&nbsp<span class=\"label label-warning\">" + item.inclusaoSpc + "</span>";
							
							var markup = "";
							markup    += "<strong class=\'" + css_titulo + "\'>" + nome + "</strong>";
							markup    += "<small class=\'pull-right " + css_detalhes + "\'>#" + formataCodigo(item.id) + "</small>";
							markup    += "<br>";
							markup    += "<small class=\'" + css_detalhes + "\'>" + item.pessoa + "</small>";
							markup    += "<small class=\'pull-right " + css_detalhes + "\'>" + formataCnpjCpf(item.cnpj) + "</small>";
							return markup;
						}',
					'formatSelection' => 'js:function(item) { return item.fantasia; }',
					'ajax' => array(
						'url' =>  Yii::app()->createUrl('pessoa/ajaxbuscapessoa', array("inativo"=>$inativo, "vendedor"=>$vendedor)),
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
								data: "cod='. $this->model->{$this->attribute} .'",
								dataType: "json",
								success: function(result) { callback(result); }
								});
							}',
					);

		return parent::init();
		
	}
		
}
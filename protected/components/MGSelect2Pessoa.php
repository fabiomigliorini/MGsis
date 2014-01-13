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
		
		if (isset($this->htmlOptions["inativo"]) && $this->htmlOptions["inativo"])
			$inativo = 1;
		else 
			$inativo = 0;
		
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
							/*	
							var markup = "<div class=\'" + css + " row-fluid\'>";
							markup    += "<small class=\'" + css + "\'>" + item.fantasia             + "</small>";
							markup    += "<small class=\'" + css + " pull-right\'>#"  + formataCodigo(item.id)    + "</small>";
							markup    += "<div class=\'" + css + " pull-left\'>"   + item.pessoa               + "</div>";
							markup    += "<div class=\'" + css + " pull-right\'>"     + formataCnpjCpf(item.cnpj) + "</div>";
							markup    += "</div>";
							var markup = "";
							markup    += "<div style=\'border:1px solid blue\' class=\'row-fluid muted\'>";
							markup    += "<small style=\'border:1px solid green\' class=\'\'>" + item.fantasia + "</small>";
							markup    += "<small style=\'border:1px solid green\' class=\'pull-right\'>#" + formataCodigo(item.id) + "</small>";
							markup    += "</div>";
							markup    += "<div style=\'border:1px solid blue\' class=\'row-fluid muted\'>";
							markup    += "<small style=\'border:1px solid green\' class=\'\'>" + item.pessoa + "</small>";
							markup    += "<small style=\'border:1px solid green\' class=\'pull-right\'>" + formataCnpjCpf(item.cnpj) + "</small>";
							markup    += "</div>";
							*/

							var css_titulo = "";
							var css_detalhes = "muted";
							if (item.inativo)
							{
								css_titulo = "text-error";
								css_detalhes = "text-error";
							}
							
							var markup = "";
							markup    += "<strong class=\'" + css_titulo + "\'>" + item.fantasia + "</strong>";
							markup    += "<small class=\'pull-right " + css_detalhes + "\'>#" + formataCodigo(item.id) + "</small>";
							markup    += "<br>";
							markup    += "<small class=\'" + css_detalhes + "\'>" + item.pessoa + "</small>";
							markup    += "<small class=\'pull-right " + css_detalhes + "\'>" + formataCnpjCpf(item.cnpj) + "</small>";
							return markup;
						}',
					'formatSelection' => 'js:function(item) { return item.fantasia; }',
					'ajax' => array(
						'url' =>  Yii::app()->createUrl('pessoa/ajaxbuscapessoa', array("inativo"=>$inativo)),
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
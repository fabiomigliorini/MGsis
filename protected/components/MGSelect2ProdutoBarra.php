<?php

Yii::import("bootstrap.widgets.TbSelect2");

class MGSelect2ProdutoBarra extends TbSelect2
{

	
	public function init()
	{
		$codprodutobarra = null;
		
		if (!empty($this->model))
			if (!empty($this->model->codprodutobarra))
				$codprodutobarra = $this->model->codprodutobarra;
			
		$this->asDropDownList = false;

		if (!isset($this->htmlOptions['class'])) 
			$this->htmlOptions['class'] = 'input-xxlarge';
		
		if (!isset($this->htmlOptions['placeholder'])) 
			$this->htmlOptions['placeholder'] = 'Produto';
		
		$this->options = array(
					'minimumInputLength'=>3,
					'allowClear' => true,
					'closeOnSelect' => true,
					'placeholder' => 'Produto',
					'formatResult' => 'js:function(item) 
						{
							var markup = "<div class=\'row-fluid\'>";
							markup    += "<small class=\'muted span2\'><small>" + item.barras + "<br>" + item.codproduto + "</small></small>";
							markup    += "<div class=\'span8\'>" + item.descricao + "<small class=\'muted text-right pull-right\'>" + item.referencia + "</small></div>";
							markup    += "<div class=\'span2 text-right pull-right\'><small class=\'span1 muted\'>" + item.sigla + "</small>" + item.preco + "";
							markup    += "</div>";
							markup    += "</div>";
							return markup;
						}',
					'formatSelection' => 'js:function(item) { return item.barras + " - " + item.descricao + " - " + item.preco; }',
					'ajax' => array(
						'url' =>  Yii::app()->createUrl('produtoBarra/ajaxbuscaprodutobarra'),
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
								url: "'. Yii::app()->createUrl('produtoBarra/ajaxinicializaprodutobarra') .'",
								data: "codprodutobarra='. $codprodutobarra .'",
								dataType: "json",
								success: function(result) { callback(result); }
								});
							}',
					);

		return parent::init();
		
	}
		
}
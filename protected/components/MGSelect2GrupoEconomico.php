<?php

Yii::import("bootstrap.widgets.TbSelect2");

class MGSelect2GrupoEconomico extends TbSelect2
{

    public function init()
    {
        $this->asDropDownList = false;

        if (!isset($this->htmlOptions['class'])) {
            $this->htmlOptions['class'] = 'input-xxlarge';
        }

        if (!isset($this->htmlOptions['placeholder'])) {
            $this->htmlOptions['placeholder'] = 'Grupo Econômico';
        }

        if (!empty($this->htmlOptions["inativo"])) {
            $inativo = 1;
        } else {
            $inativo = 0;
        }

        $this->options = array(
            'minimumInputLength' => 1,
            'allowClear' => true,
            'closeOnSelect' => true,
            'formatResult' => 'js:function(item)
						{

							var css = "div-combo-grupo-economico";
							if (item.inativo) {
								var css = "text-error";
                            }

							var css_titulo = "";
							var css_detalhes = "muted";
							if (item.inativo) {
								css_titulo = "text-error";
								css_detalhes = "text-error";
							}

							var markup = "";
							markup    += "<strong class=\'" + css_titulo + "\'>" + item.grupoeconomico + "</strong>";
							markup    += "<small class=\'pull-right " + css_detalhes + "\'>#" + formataCodigo(item.id) + "</small>";
							return markup;
						}',
            'formatSelection' => 'js:function(item) { return item.grupoeconomico; }',
            'ajax' => array(
                'url' =>  Yii::app()->createUrl('grupoEconomico/ajaxbuscagrupoeconomico', array("inativo" => $inativo)),
                'dataType' => 'json',
                'quietMillis' => 500,
                'data' => 'js:function(term,page) { return {texto: term, limite: 20, pagina: page}; }',
                'results' => 'js:function(data,page)
							{
								var more = (page * 20) < data.total;
								return {results: data.itens, more: data.mais};
							}',
            ),
            'initSelection' => 'js:function (element, callback) {
							$.ajax({
								type: "GET",
								url: "' . Yii::app()->createUrl('grupoEconomico/ajaxinicializagrupoeconomico') . '",
								data: "cod=' . $this->model->{$this->attribute} . '",
								dataType: "json",
								success: function(result) { callback(result); }
								});
							}',
        );

        return parent::init();
    }
}

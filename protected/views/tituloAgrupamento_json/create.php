<?php
$this->pagetitle = Yii::app()->name . ' - Novo Agrupamento de Títulos';
$this->breadcrumbs=array(
	'Agrupamento de Títulos'=>array('index'),
	'Novo',
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);
?>
<h1>Novo Agrupamento de Títulos</h1>
<?php 

$form=$this->beginWidget('MGActiveForm',array(
	'id'=>'titulo-agrupamento-form',
));

?>
<?php echo $form->errorSummary($model); ?>
<fieldset>
<div class="row-fluid"><b class="span2">Total Selecionado:</b><b class="span2 text-right" id="total"></b></div>

<?php

$this->widget('bootstrap.widgets.TbWizard', array(
        'type' => 'tabs',
        'tabs' => array(
                array('label' => 'Títulos', 'content' => $this->renderPartial('_form_titulos', array('model'=>$model, 'form'=>$form), true), 'active' => true),
                array('label' => 'Vencimentos', 'content' => $this->renderPartial('_form_vencimentos', array('model'=>$model, 'form'=>$form), true), 'active' => false),
                array('label' => 'Finalizar', 'content' => $this->renderPartial('_form_finalizar', array('model'=>$model, 'form'=>$form), true), 'active' => false),
        ),
		'pagerContent' => '<ul class="pager wizard">
                                <li class="previous first" style="display:none;"><a href="#">Primeiro</a></li>
                                <li class="previous"><a href="#">Anterior</a></li>
                                <li class="next last" style="display:none;"><a href="#">Último</a></li>
                                <li class="next"><a href="#">Próximo</a></li>
                        </ul>',
));

$this->endWidget();
?>
</fieldset>
	
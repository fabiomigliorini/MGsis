<?php
$this->pagetitle = Yii::app()->name . ' - Detalhes da Empresa';
$this->breadcrumbs=array(
	'Empresas'=>array('index'),
	$model->empresa,
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
array('label'=>'Nova', 'icon'=>'icon-plus', 'url'=>array('create')),
array('label'=>'Alterar', 'icon'=>'icon-pencil', 'url'=>array('update','id'=>$model->codempresa)),
array('label'=>'Excluir', 'icon'=>'icon-trash', 'url'=>'#', 'linkOptions'=>	array('id'=>'btnExcluir')),
//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);

Yii::app()->clientScript->registerCoreScript('yii');

?>
<script type="text/javascript">
/*<![CDATA[*/
$(document).ready(function(){
	jQuery('body').on('click','#btnExcluir',function() {
		bootbox.confirm("Excluir este registro?", function(result) {
			if (result)
				jQuery.yii.submitForm(document.body.childNodes[0], "<?php echo Yii::app()->createUrl('empresa/delete', array('id' => $model->codempresa))?>",{});
		});
	});
});
/*]]>*/
</script>

<h1><?php echo $model->empresa; ?></h1>

<?php 
$this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
			array(
				'name'=>'codempresa',
				'value'=>Yii::app()->format->formataCodigo($model->codempresa),
				),
			'empresa',
		),
	)); 

	$this->widget('UsuarioCriacao', array('model'=>$model));

?>

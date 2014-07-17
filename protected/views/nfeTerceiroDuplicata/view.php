<?php
$this->pagetitle = Yii::app()->name . ' - Detalhes Nfe Terceiro Duplicata';
$this->breadcrumbs=array(
	'Nfe Terceiro Duplicata'=>array('index'),
	$model->codnfeterceiroduplicata,
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
array('label'=>'Alterar', 'icon'=>'icon-pencil', 'url'=>array('update','id'=>$model->codnfeterceiroduplicata)),
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
				jQuery.yii.submitForm(document.body.childNodes[0], "<?php echo Yii::app()->createUrl('nfe-terceiro-duplicata/delete', array('id' => $model->codnfeterceiroduplicata))?>",{});
		});
	});
});
/*]]>*/
</script>

<h1><?php echo $model->codnfeterceiroduplicata; ?></h1>

<?php 
$this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
			'codnfeterceiroduplicata',
		'codnfeterceiro',
		'codtitulo',
		'ndup',
		'dvenc',
		'vdup',
		),
	)); 

	$this->widget('UsuarioCriacao', array('model'=>$model));

?>

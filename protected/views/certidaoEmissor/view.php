<?php
$this->pagetitle = Yii::app()->name . ' - Detalhes Certidao Emissor';
$this->breadcrumbs=array(
	'Certidao Emissor'=>array('index'),
	Yii::app()->format->formataCodigo($model->codcertidaoemissor),
);

$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
	array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	array('label'=>'Alterar', 'icon'=>'icon-pencil', 'url'=>array('update','id'=>$model->codcertidaoemissor)),
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
				jQuery.yii.submitForm(document.body.childNodes[0], "<?php echo Yii::app()->createUrl('certidaoEmissor/delete', array('id' => $model->codcertidaoemissor))?>",{});
		});
	});
});
/*]]>*/
</script>


<h1><?php echo CHtml::encode(Yii::app()->format->formataCodigo($model->codcertidaoemissor)); ?></h1>

<?php
$this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'certidaoemissor',
		'inativo',
		),
	));

	$this->widget('UsuarioCriacao', array('model'=>$model));

?>

<?php
$this->pagetitle = Yii::app()->name . ' - Detalhes Portador';
$this->breadcrumbs=array(
	'Portador'=>array('index'),
	$model->codportador,
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
array('label'=>'Alterar', 'icon'=>'icon-pencil', 'url'=>array('update','id'=>$model->codportador)),
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
				jQuery.yii.submitForm(document.body.childNodes[0], "<?php echo Yii::app()->createUrl('portador/delete', array('id' => $model->codportador))?>",{});
		});
	});
});
/*]]>*/
</script>

<h1><?php echo $model->codportador; ?></h1>

<?php 
$this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
			'codportador',
		'portador',
		'codbanco',
		'agencia',
		'agenciadigito',
		'conta',
		'contadigito',
		'emiteboleto',
		'codfilial',
		'convenio',
		'diretorioremessa',
		'diretorioretorno',
		'carteira',
		),
	)); 

	$this->widget('UsuarioCriacao', array('model'=>$model));

?>

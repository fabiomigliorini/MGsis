<?php
$this->pagetitle = Yii::app()->name . ' - Detalhes da Cidade';
$this->breadcrumbs=array(
	'Países'=>array('pais/index'),
	$model->Estado->Pais->pais=>array('pais/view', "id"=>$model->Estado->codpais),
	$model->Estado->estado=>array('estado/view', "id"=>$model->codestado),
	$model->cidade,
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('estado/view', 'id'=>$model->codestado)),
array('label'=>'Nova', 'icon'=>'icon-plus', 'url'=>array('create', 'codestado'=>$model->codestado)),
array('label'=>'Alterar', 'icon'=>'icon-pencil', 'url'=>array('update','id'=>$model->codcidade)),
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
				jQuery.yii.submitForm(document.body.childNodes[0], "<?php echo Yii::app()->createUrl('cidade/delete', array('id' => $model->codcidade))?>",{});
		});
	});
});
/*]]>*/
</script>

<h1>Detalhes da Cidade #<?php echo $model->codcidade; ?></h1>

<?php 
$this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'codcidade',
		//'codestado',
		array(
					'name'=>'codestado',
					'value'=>(isset($model->codestado))?CHtml::link(CHtml::encode($model->Estado->estado),array('estado/view','id'=>$model->codestado)):null,
					'type'=>'raw',
					),
		'cidade',
		'sigla',
		'codigooficial',
		),
	)); 

	$this->widget('UsuarioCriacao', array('model'=>$model));
	
	

?>

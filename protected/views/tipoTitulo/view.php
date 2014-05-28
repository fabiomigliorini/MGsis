<?php
$this->pagetitle = Yii::app()->name . ' - Detalhes Tipo Título';
$this->breadcrumbs=array(
	'Tipo Título'=>array('index'),
	$model->tipotitulo,
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
array('label'=>'Alterar', 'icon'=>'icon-pencil', 'url'=>array('update','id'=>$model->codtipotitulo)),
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
				jQuery.yii.submitForm(document.body.childNodes[0], "<?php echo Yii::app()->createUrl('tipoTitulo/delete', array('id' => $model->codtipotitulo))?>",{});
		});
	});
});
/*]]>*/
</script>

<h1><?php echo $model->tipotitulo; ?></h1>

<?php 
$this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'codtipotitulo',
		'tipotitulo',
		array(
			'name'=>'pagar',
			'value'=>($model->pagar)?'Sim':'Não',
			),
		array(
			'name'=>'receber',
			'value'=>($model->receber)?'Sim':'Não',
			),
		'observacoes',
		//'codtipomovimentotitulo',
		array(
			'name'=>'codtipomovimentotitulo',
			'value'=>(isset($model->codtipomovimentotitulo))?CHtml::link(CHtml::encode($model->TipoMovimentoTitulo->tipomovimentotitulo),array('tipoMovimentoTitulo/view','id'=>$model->codtipomovimentotitulo)):null,
			'type'=>'raw',
			),
		array(
			'name'=>'debito',
			'value'=>($model->debito)?'Sim':'Não',
			),
		array(
			'name'=>'credito',
			'value'=>($model->credito)?'Sim':'Não',
			),
		),
	)); 

	$this->widget('UsuarioCriacao', array('model'=>$model));

?>

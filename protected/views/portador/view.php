<?php
$this->pagetitle = Yii::app()->name . ' - Detalhes do Portador';
$this->breadcrumbs=array(
	'Portadores'=>array('index'),
	$model->portador,
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

<h1><?php echo $model->portador; ?></h1>

<?php
$this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		//'codportador',
		array(
			'name'=>'codportador',
			'value'=>Yii::app()->format->formataCodigo($model->codportador),
			),
		'portador',
		//'codbanco',
		array(
			'name'=>'codbanco',
			'value'=>(isset($model->Banco))?CHtml::link(CHtml::encode($model->Banco->banco),array('banco/view','id'=>$model->codbanco)):null,
			'type'=>'raw',
			),
		'agencia',
		'agenciadigito',
		'conta',
		'contadigito',
		//'emiteboleto',
		array(
			'name'=>'emiteboleto',
			'value'=>($model->emiteboleto)?'Sim':'Não',
			),
		//'codfilial',
		array(
			'name'=>'codfilial',
			'value'=>(isset($model->Filial))?CHtml::link(CHtml::encode($model->Filial->filial),array('filial/view','id'=>$model->codfilial)):null,
			'type'=>'raw',
			),
		'convenio',
		'carteira',
		'carteiravariacao',
		),
	));

	$this->widget('UsuarioCriacao', array('model'=>$model));

?>

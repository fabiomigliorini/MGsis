<?php
$this->pagetitle = Yii::app()->name . ' - Detalhes Sub Grupos de Produtos';
$this->breadcrumbs=array(
	'Grupo de Produtos'=>array('grupoProduto/index'),
	$model->GrupoProduto->grupoproduto=>array('grupoProduto/view', "id"=>$model->codgrupoproduto),
	$model->subgrupoproduto,
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('grupoProduto/view', 'id'=>$model->codgrupoproduto)),
array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create', 'codgrupoproduto'=>$model->codgrupoproduto)),
array('label'=>'Alterar', 'icon'=>'icon-pencil', 'url'=>array('update','id'=>$model->codsubgrupoproduto)),
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
				jQuery.yii.submitForm(document.body.childNodes[0], "<?php echo Yii::app()->createUrl('subGrupoProduto/delete', array('id' => $model->codsubgrupoproduto))?>",{});
		});
	});
});
/*]]>*/
</script>

<h1><?php echo $model->subgrupoproduto; ?></h1>

<?php 
$this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'codsubgrupoproduto',
		//'codgrupoproduto',
		array(
					'name'=>'codgrupoproduto',
					'value'=>(isset($model->codgrupoproduto))?CHtml::link(CHtml::encode($model->GrupoProduto->grupoproduto),array('grupoProduto/view','id'=>$model->codgrupoproduto)):null,
					'type'=>'raw',
					),
		'subgrupoproduto',
		),
	)); 

	$this->widget('UsuarioCriacao', array('model'=>$model));

?>

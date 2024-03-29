<?php
$this->pagetitle = Yii::app()->name . ' - Detalhes Grupo de Produtos';
$this->breadcrumbs=array(
	'Grupos de Produtos'=>array('index'),
	$model->grupoproduto,
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
array('label'=>'Alterar', 'icon'=>'icon-pencil', 'url'=>array('update','id'=>$model->codgrupoproduto)),
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
				jQuery.yii.submitForm(document.body.childNodes[0], "<?php echo Yii::app()->createUrl('grupoProduto/delete', array('id' => $model->codgrupoproduto))?>",{});
		});
	});
});
/*]]>*/
</script>

<h1><?php echo $model->grupoproduto; ?></h1>

<?php 
$this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		//'codgrupoproduto',
		array(
			'name'=>'codgrupoproduto',
			'value'=>Yii::app()->format->formataCodigo($model->codgrupoproduto),
			),
		'grupoproduto',
		),
	)); 

	$this->widget('UsuarioCriacao', array('model'=>$model));
	
	$subgrupoproduto=new SubGrupoProduto('search');

	$subgrupoproduto->unsetAttributes();  // clear any default values

	if(isset($_GET['SubGrupoProduto']))
		Yii::app()->session['FiltroSubGrupoProdutoIndex'] = $_GET['SubGrupoProduto'];

	if (isset(Yii::app()->session['FiltroSubGrupoProdutoIndex']))
		$subgrupoproduto->attributes=Yii::app()->session['FiltroSubGrupoProdutoIndex'];

	$subgrupoproduto->codgrupoproduto = $model->codgrupoproduto;

	$this->renderPartial('/subGrupoProduto/index',array(
		'dataProvider'=>$subgrupoproduto->search(),
		'model'=>$subgrupoproduto,
		));
?>

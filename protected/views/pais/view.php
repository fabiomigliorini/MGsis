<?php
$this->pagetitle = Yii::app()->name . ' - Detalhes do País';
$this->breadcrumbs=array(
	'Países'=>array('index'),
	$model->pais,
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
array('label'=>'Alterar', 'icon'=>'icon-pencil', 'url'=>array('update','id'=>$model->codpais)),
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
				jQuery.yii.submitForm(document.body.childNodes[0], "<?php echo Yii::app()->createUrl('pais/delete', array('id' => $model->codpais))?>",{});
		});
	});
});
/*]]>*/
</script>

<h1><?php echo $model->pais; ?></h1>

<?php 
$this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
			'codpais',
		'pais',
		'sigla',
		),
	)); 

$this->widget('UsuarioCriacao', array('model'=>$model));

$estado=new Estado('search');

$estado->unsetAttributes();  // clear any default values

if(isset($_GET['Estado']))
	Yii::app()->session['FiltroEstadoIndex'] = $_GET['Estado'];

if (isset(Yii::app()->session['FiltroEstadoIndex']))
	$estado->attributes=Yii::app()->session['FiltroEstadoIndex'];

$estado->codpais = $model->codpais;

$this->renderPartial('/estado/index',array(
	'dataProvider'=>$estado->search(),
	'model'=>$estado,
	));
?>

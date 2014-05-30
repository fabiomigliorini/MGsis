<?php
$this->pagetitle = Yii::app()->name . ' - Detalhes do Estado';
$this->breadcrumbs=array(
	'Países'=>array('pais/index'),
	$model->Pais->pais=>array('pais/view', "id"=>$model->codpais),
	$model->estado,
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('pais/view', 'id'=>$model->codpais)),
array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create', 'codpais'=>$model->codpais)),
array('label'=>'Alterar', 'icon'=>'icon-pencil', 'url'=>array('update','id'=>$model->codestado)),
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
				jQuery.yii.submitForm(document.body.childNodes[0], "<?php echo Yii::app()->createUrl('estado/delete', array('id' => $model->codestado))?>",{});
		});
	});
});
/*]]>*/
</script>

<h1><?php echo $model->estado; ?></h1>

<?php 
$this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'codestado',
		//'codpais',
		array(
			'name'=>'codpais',
			'value'=>(isset($model->Pais))?CHtml::link(CHtml::encode($model->Pais->pais),array('pais/view','id'=>$model->codpais)):null,
			'type'=>'raw',
			),
		'estado',
		'sigla',
		'codigooficial',
		),
	)); 

	$this->widget('UsuarioCriacao', array('model'=>$model));
	
	$cidade=new Cidade('search');
		
		$cidade->unsetAttributes();  // clear any default values
		
		if(isset($_GET['Cidade']))
			Yii::app()->session['FiltroCidadeIndex'] = $_GET['Cidade'];
		
		if (isset(Yii::app()->session['FiltroCidadeIndex']))
			$cidade->attributes=Yii::app()->session['FiltroCidadeIndex'];
		
		$this->render('index',array(
			'dataProvider'=>$model->search(),
			'model'=>$model,
			));

?>

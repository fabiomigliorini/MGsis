<?php
$this->pagetitle = Yii::app()->name . ' - Detalhes Filial';
$this->breadcrumbs=array(
	'Empresas'=>array('empresa/index'),
	$model->Empresa->empresa=>array('empresa/view', "id"=>$model->codempresa),
	$model->filial,
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('empresa/view', 'id'=>$model->codempresa)),
array('label'=>'Nova', 'icon'=>'icon-plus', 'url'=>array('create', 'codempresa'=>$model->codempresa)),
array('label'=>'Alterar', 'icon'=>'icon-pencil', 'url'=>array('update','id'=>$model->codfilial)),
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
				jQuery.yii.submitForm(document.body.childNodes[0], "<?php echo Yii::app()->createUrl('filial/delete', array('id' => $model->codfilial))?>",{});
		});
	});
});
/*]]>*/
</script>

<h1><?php echo $model->filial; ?></h1>

<?php 
$this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		//'codfilial',
		array(
			'name'=>'codfilial',
			'value'=>Yii::app()->format->formataCodigo($model->codfilial),
			),
		//'codempresa',
		array(
					'name'=>'codempresa',
					'value'=>(isset($model->Empresa))?CHtml::link(CHtml::encode($model->Empresa->empresa),array('empresa/view','id'=>$model->codempresa)):null,
					'type'=>'raw',
					),
		//'codpessoa',
		array(
					'name'=>'codpessoa',
					'value'=>(isset($model->Pessoa))?CHtml::link(CHtml::encode($model->Pessoa->fantasia),array('pessoa/view','id'=>$model->codpessoa)):null,
					'type'=>'raw',
					),
		'filial',
		'crt',
		'nfcetoken',
		'nfcetokenid',
		'acbrnfemonitorcaminho',
		'acbrnfemonitorcaminhorede',
		//'acbrnfemonitorbloqueado',
		//'acbrnfemonitorcodusuario',
		'empresadominio',
		'acbrnfemonitorip',
		'acbrnfemonitorporta',
		//'odbcnumeronotafiscal',
		),
	)); 

	$this->widget('UsuarioCriacao', array('model'=>$model));

?>

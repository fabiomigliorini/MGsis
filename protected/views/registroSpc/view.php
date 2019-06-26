<?php
$this->pagetitle = Yii::app()->name . ' - Detalhes Registro SPC';
$this->breadcrumbs=array(
	'Pessoas'=>array('pessoa/index'),
	$model->Pessoa->pessoa=>array('pessoa/view', "id"=>$model->codpessoa),
	"Registro SPC {$model->inclusao}",
);

$this->menu=array(
//array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('pessoa/view', 'id'=>$model->codpessoa)),
//array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
array('label'=>'Nova', 'icon'=>'icon-plus', 'url'=>array('create', 'codpessoa'=>$model->codpessoa)),
array('label'=>'Alterar', 'icon'=>'icon-pencil', 'url'=>array('update','id'=>$model->codregistrospc)),
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
				jQuery.yii.submitForm(document.body.childNodes[0], "<?php echo Yii::app()->createUrl('registroSpc/delete', array('id' => $model->codregistrospc))?>",{});
		});
	});
});
/*]]>*/
</script>

<h1>Registro SPC <?php echo $model->inclusao; ?></h1>

<?php 
$this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'codregistrospc',
		//'codpessoa',
		
		array(
			'name'=>'codpessoa',
			'value'=>isset($model->Pessoa)?$model->Pessoa->pessoa:null,
			),
		
		'inclusao',
		'baixa',
		//'valor',
		
		array(
			'name'=>'valor',
			'cssClass'=>'text-error',
			'value'=>Yii::app()->format->formatNumber($model->valor),
		),
		array(
			'name'=>'observacoes',
			'value'=>nl2br(CHtml::encode($model->observacoes)),
			'type'=>'raw',
		),
		
	),
	)); 

	$this->widget('UsuarioCriacao', array('model'=>$model));

?>

<?php
$this->pagetitle = Yii::app()->name . ' - Detalhes Histórico de CObrança';
$this->breadcrumbs=array(
	'Pessoas'=>array('pessoa/index'),
	$model->Pessoa->pessoa=>array('pessoa/view', "id"=>$model->codpessoa),
	'Histórico de Cobrança',
	
);

$this->menu=array(
//array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('pessoa/view', 'id'=>$model->codpessoa)),
//array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create', 'codpessoa'=>$model->codpessoa)),
array('label'=>'Alterar', 'icon'=>'icon-pencil', 'url'=>array('update','id'=>$model->codcobrancahistorico)),
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
				jQuery.yii.submitForm(document.body.childNodes[0], "<?php echo Yii::app()->createUrl('cobrancaHistorico/delete', array('id' => $model->codcobrancahistorico))?>",{});
		});
	});
});
/*]]>*/
</script>

<h1>Histórico de Cobrança</h1>

<?php 
$this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		//'codcobrancahistorico',
		array(
			'name'=>'codcobrancahistorico',
			'value'=>Yii::app()->format->formataCodigo($model->codcobrancahistorico),
			),
		
		//'codpessoa',
		array(
					'name'=>'codpessoa',
					'value'=>(isset($model->codpessoa))?CHtml::link(CHtml::encode($model->Pessoa->pessoa),array('pessoa/view','id'=>$model->codpessoa)):null,
					'type'=>'raw',
					),
		
		//'codusuario',
		//'historico',
		array(
			'name'=>'historico',
			'value'=>nl2br(CHtml::encode($model->historico)),
			'type'=>'raw',
			),
		
		//'emailautomatico',
		array(
			'name'=>'emailautomatico',
			'value'=>($model->emailautomatico)?'Sim':'Não',
			),
		
		),
	)); 

	$this->widget('UsuarioCriacao', array('model'=>$model));

?>

<?php
$this->pagetitle = Yii::app()->name . ' - Detalhes Tipo Movimento Título';
$this->breadcrumbs=array(
	'Tipo Movimento Títulos'=>array('index'),
	$model->tipomovimentotitulo,
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
array('label'=>'Alterar', 'icon'=>'icon-pencil', 'url'=>array('update','id'=>$model->codtipomovimentotitulo)),
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
				jQuery.yii.submitForm(document.body.childNodes[0], "<?php echo Yii::app()->createUrl('tipoMovimentoTitulo/delete', array('id' => $model->codtipomovimentotitulo))?>",{});
		});
	});
});
/*]]>*/
</script>

<h1><?php echo $model->tipomovimentotitulo; ?></h1>

<?php 
$this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		//'codtipomovimentotitulo',
		array(
			'name'=>'codtipomovimentotitulo',
			'value'=>Yii::app()->format->formataCodigo($model->codtipomovimentotitulo),
			),
		'tipomovimentotitulo',
		//'implantacao',
		array(
			'name'=>'implantacao',
			'value'=>($model->implantacao)?'Sim':'Não',
			),
		////'ajuste',
		array(
			'name'=>'ajuste',
			'value'=>($model->ajuste)?'Sim':'Não',
			),
		//'armotizacao',
		array(
			'name'=>'armotizacao',
			'value'=>($model->armotizacao)?'Sim':'Não',
			),
		//'juros',
		array(
			'name'=>'juros',
			'value'=>($model->juros)?'Sim':'Não',
			),
		//'desconto',
		array(
			'name'=>'desconto',
			'value'=>($model->desconto)?'Sim':'Não',
			),
		//'pagamento',
		array(
			'name'=>'pagamento',
			'value'=>($model->pagamento)?'Sim':'Não',
			),
		//'estorno',
		array(
			'name'=>'estorno',
			'value'=>($model->estorno)?'Sim':'Não',
			),
		array(
			'name'=>'observacao',
			'value'=>nl2br(CHtml::encode($model->observacao)),
			'type'=>'raw',
			),
		),
	)); 

	$this->widget('UsuarioCriacao', array('model'=>$model));

?>

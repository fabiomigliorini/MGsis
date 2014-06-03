<?php
$this->pagetitle = Yii::app()->name . ' - Detalhes Natureza da Operação';
$this->breadcrumbs=array(
	'Natureza da Operação'=>array('index'),
	$model->naturezaoperacao,
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
array('label'=>'Nova', 'icon'=>'icon-plus', 'url'=>array('create')),
array('label'=>'Alterar', 'icon'=>'icon-pencil', 'url'=>array('update','id'=>$model->codnaturezaoperacao)),
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
				jQuery.yii.submitForm(document.body.childNodes[0], "<?php echo Yii::app()->createUrl('naturezaOperacao/delete', array('id' => $model->codnaturezaoperacao))?>",{});
		});
	});
});
/*]]>*/
</script>

<h1><?php echo $model->naturezaoperacao; ?></h1>

<?php 
$this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		//'codnaturezaoperacao',
		array(
			'name'=>'codnaturezaoperacao',
			'value'=>Yii::app()->format->formataCodigo($model->codnaturezaoperacao),
			),
		'naturezaoperacao',
		//'codoperacao',
		array(
			'name'=>'codoperacao',
			'value'=>($model->codoperacao)?'Entrada':'Saída',
			),
		//'emitida',
		array(
			'name'=>'emitida',
			'value'=>($model->emitida)?'Sim':'Não',
			),
		//'observacoesnf',
		array(
			'name'=>'observacoesnf',
			'value'=>nl2br(CHtml::encode($model->observacoesnf)),
			'type'=>'raw',
			),
		),
	)); 

	$this->widget('UsuarioCriacao', array('model'=>$model));

	$tributacaonaturezaoperacao=new TributacaoNaturezaOperacao('search');

	$tributacaonaturezaoperacao->unsetAttributes();  // clear any default values

	if(isset($_GET['TributacaoNaturezaOperacao']))
		Yii::app()->session['FiltroTributacaoNaturezaOperacaoIndex'] = $_GET['TributacaoNaturezaOperacao'];

	if (isset(Yii::app()->session['FiltroTributacaoNaturezaOperacaoIndex']))
		$tributacaonaturezaoperacao->attributes=Yii::app()->session['FiltroTributacaoNaturezaOperacaoIndex'];

	$tributacaonaturezaoperacao->codnaturezaoperacao = $model->codnaturezaoperacao;

	$this->renderPartial('/tributacaoNaturezaOperacao/index',array(
	'dataProvider'=>$tributacaonaturezaoperacao->search(),
	'model'=>$tributacaonaturezaoperacao,
	));
?>

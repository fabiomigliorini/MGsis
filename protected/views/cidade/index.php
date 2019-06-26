<?php
/*
$this->pagetitle = Yii::app()->name . ' - Cidade';
$this->breadcrumbs=array(
	'Cidade',
);

$this->menu=array(
	array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);
 * 
 */
?>

<script type='text/javascript'>

$(document).ready(function(){
	$('#search-form').change(function(){
		var ajaxRequest = $("#search-form").serialize();
		$.fn.yiiListView.update(
			// this is the id of the CListView
			'Listagem',
			{data: ajaxRequest}
		);
    });
});

</script>

<h2>
	Cidades
	<small>
		<?php echo CHtml::link("<i class=\"icon-plus\"></i> Nova", array("cidade/create", "codestado" => $model->codestado)); ?>
	</small>
</h2>

<br>

<?php $form=$this->beginWidget('MGActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'id' => 'search-form',
	'type' => 'inline',
	'method'=>'get',
)); 

?>
<div class="well well-small">
	<input type="hidden" value="<?php echo $model->codestado ?>" name="id">
	<?php echo $form->textField($model, 'codcidade', array('placeholder' => '#', 'class'=>'input-mini')); ?>
	<?php echo $form->textField($model, 'cidade', array('placeholder' => 'Cidade', 'class'=>'input-large')); ?>
	<?php echo $form->textField($model, 'codigooficial', array('placeholder' => 'Código Oficial', 'class'=>'input-large')); ?>
	<?php //echo $form->textField($model, 'codestado', array('placeholder' => '#', 'class'=>'input-mini')); ?>
	<?php
	$this->widget('bootstrap.widgets.TbButton'
		, array(
			'buttonType' => 'submit',
			'icon'=>'icon-search',
			//'label'=>'',
			'htmlOptions' => array('class'=>'pull-right btn btn-info')
			)
		); 
	?>
</div>

<?php $this->endWidget(); ?>


<?php
 
$this->widget(
	'zii.widgets.CListView', 
	array(
		'id' => 'Listagem',
		'dataProvider' => $dataProvider,
		'itemView' => '/cidade/_view',
		'template' => '{items} {pager}',
		'pager' => array(
			'class' => 'ext.infiniteScroll.IasPager', 
			'rowSelector'=>'.registro', 
			'listViewId' => 'Listagem', 
			'header' => '',
			'loaderText'=>'Carregando...',
			'options' => array('history' => false, 'triggerPageTreshold' => 10, 'trigger'=>'Carregar mais registros'),
		)
	)
);
?>

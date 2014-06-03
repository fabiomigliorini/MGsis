<?php
/*
$this->pagetitle = Yii::app()->name . ' - Estado';
$this->breadcrumbs=array(
	'Estado',
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
	Estados 
	<small>
		<?php echo CHtml::link("<i class=\"icon-plus\"></i> Novo", array("estado/create", "codpais" => $model->codpais)); ?>
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
	<input type ="hidden" name="id" value="<?php echo $model->codpais;?>">
	<?php echo $form->textField($model, 'codestado', array('placeholder' => '#', 'class'=>'input-mini')); ?>
	<?php echo $form->textField($model, 'estado', array('placeholder' => 'Estado', 'class'=>'input-medium')); ?>
	<?php echo $form->textField($model, 'sigla', array('placeholder' => 'Sigla', 'class'=>'input-mini')); ?>
	<?php echo $form->textField($model, 'codigooficial', array('placeholder' => 'Código Oficial', 'class'=>'input-small')); ?>
	<?php
		/*
		echo $form->select2(
			$model, 
			'codpais', 
			Pais::getListaCombo(), 
			array(
				'placeholder'=>'Países',
				'class' => 'input-medium'
			)
		);
		 * 
		 */
	?>
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
		'itemView' => '/estado/_view',
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

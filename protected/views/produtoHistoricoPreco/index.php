<?php
$this->pagetitle = Yii::app()->name . ' - Historico Preço';
$this->breadcrumbs=array(
	'Historico Preço',
);

$this->menu=array(
	//array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	array('label'=>'Relatorio', 'icon'=>'XXXX', 'url'=>array('relatorio')),
	);
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

<h1>Historico de Preço</h1>

<br>

<?php $form=$this->beginWidget('MGActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'id' => 'search-form',
	'type' => 'inline',
	'method'=>'get',
)); 

?>
<div class="well well-small">
	<input type ="hidden" name="id" value="<?php echo $model->codproduto;?>">
	<?php echo $form->textField($model, 'codproduto', array('placeholder' => '#', 'class'=>'input-mini')); ?>
	<?php echo $form->textField($model, 'produto', array('placeholder' => 'Produto', 'class'=>'input-xlarge')); ?>
	<?php echo $form->textField($model, 'referencia', array('placeholder' => 'Referencia', 'class'=>'input-large')); ?>
	<?php //echo $form->textField($model, 'codusuariocriacao', array('placeholder' => 'Usuário', 'class'=>'input-large')); ?>
	<?php 
		echo $form->datepickerRow(
			$model,
			'alteracao_de',
			array(
				'class' => 'input-mini text-center', 
				'options' => array(
					'format' => 'dd/mm/yy'
				),
				'placeholder' => 'Alteração',
				'prepend' => 'De',
			)
		); 	
	?>
	<?php 
		echo $form->datepickerRow(
			$model,
			'alteracao_ate',
			array(
				'class' => 'input-mini text-center', 
				'options' => array(
					'format' => 'dd/mm/yy'
				),
				'placeholder' => 'Alteração',
				'prepend' => 'Até',
			)
		); 	
	?>
	<?php echo $form->select2Marca($model, 'codmarca');?>
	<?php echo $form->select2($model, 'codusuariocriacao', Usuario::getListaCombo(), array('placeholder'=>'Usuário', 'class' => 'input-medium')); ?>	
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
		'itemView' => '_view',
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

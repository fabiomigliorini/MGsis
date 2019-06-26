<?php
$this->pagetitle = Yii::app()->name . ' - Produto';
$this->breadcrumbs=array(
	'Produtos',
);

$this->menu=array(
	array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);
?>

<script type='text/javascript'>

$(document).ready(function(){
	//$("#Produto_preco_de").autonumeric();
	$('#Produto_preco_de').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#Produto_preco_ate').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	
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

<h1>Produtos</h1>

<br>

<?php $form=$this->beginWidget('MGActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'id' => 'search-form',
	'type' => 'inline',
	'method'=>'get',
)); 

?>
<div class="well well-small">
	<?php echo $form->textField($model, 'codproduto', array('placeholder' => '#', 'class'=>'input-small text-right')); ?>
	<?php echo $form->textField($model, 'barras', array('placeholder' => 'Barras', 'class'=>'input-medium')); ?>
	<?php echo $form->textField($model, 'produto', array('placeholder' => 'Descrição', 'class'=>'input-medium')); ?>
	<?php echo $form->select2Marca($model, 'codmarca');?>
	<?php echo $form->textField($model, 'referencia', array('placeholder' => 'Referencia', 'class'=>'input-small')); ?>
	<?php
		echo $form->select2(
			$model, 
			'inativo', 
			array('0'=>'Ativos', '1'=>'Inativos', '9'=>'Todos'), 
			array(
				'placeholder'=>'Ativos',
				'class' => 'input-medium'
			)
		);
	?>
	<?php
		echo $form->select2(
			$model, 
			'codtributacao', 
			Tributacao::getListaCombo(), 
			array(
				'placeholder'=>'Tributação',
				'class' => 'input-medium'
			)
		);
	?>
	<?php
		echo $form->select2(
			$model, 
			'site', 
			array(1=>'No Site', 2=>'Fora do Site'), 
			array(
				'placeholder'=>'Site',
				'class' => 'input-medium'
			)
		);
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
	<?php echo $form->select2Ncm($model, 'codncm'); ?>
	<?php echo $form->textField($model, 'preco_de', array('placeholder' => 'Preço de', 'class'=>'input-mini text-right')); ?>
	<?php echo $form->textField($model, 'preco_ate', array('placeholder' => 'Preço Até', 'class'=>'input-mini text-right')); ?>
	<?php 
		echo $form->datepickerRow(
			$model,
			'criacao_de',
			array(
				'class' => 'input-mini text-center', 
				'options' => array(
					'format' => 'dd/mm/yy'
				),
				'placeholder' => 'Criação',
				'prepend' => 'De',
			)
		); 	
	?>
	<?php 
		echo $form->datepickerRow(
			$model,
			'criacao_ate',
			array(
				'class' => 'input-mini text-center', 
				'options' => array(
					'format' => 'dd/mm/yy'
				),
				'placeholder' => 'Criação',
				'prepend' => 'Até',
			)
		); 	
	?>
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

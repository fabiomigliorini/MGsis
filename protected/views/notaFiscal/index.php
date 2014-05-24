<?php
$this->pagetitle = Yii::app()->name . ' - Notas Fiscais';
$this->breadcrumbs=array(
	'Notas Fiscais',
);

$this->menu=array(
	array('label'=>'Nova', 'icon'=>'icon-plus', 'url'=>array('create')),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
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

<h1>Notas Fiscais</h1>

<br>

<?php $form=$this->beginWidget('MGActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'id' => 'search-form',
	'type' => 'inline',
	'method'=>'get',
)); 

?>
<div class="well well-small">
	<?php echo $form->textField($model, 'codnotafiscal', array('placeholder' => '#', 'class'=>'input-mini')); ?>
	<?php echo $form->textField($model, 'numero', array('placeholder' => 'Número', 'class'=>'input-mini')); ?>
	<?php echo $form->select2Pessoa($model, 'codpessoa', array('placeholder' => 'Pessoa', 'class'=>'input-xxlarge')); ?>
	<?php echo $form->select2($model, 'codfilial', Filial::getListaCombo(), array('placeholder' => 'Filial', 'class'=>'input-medium')); ?>
	<?php echo $form->select2($model, 'codnaturezaoperacao', NaturezaOperacao::getListaCombo(), array('placeholder' => 'Natureza de Operação', 'class'=>'input-large')); ?>
	<?php echo $form->select2($model, 'codstatus', NotaFiscal::getStatusListaCombo(), array('placeholder' => 'Status', 'class'=>'input-medium')); ?>
	<?php echo $form->select2($model, 'codoperacao', Operacao::getListaCombo(), array('placeholder' => 'Operacao', 'class'=>'input-medium')); ?>
		<?php 
			echo $form->datepickerRow(
					$model,
					'emissao_de',
					array(
						'class' => 'input-mini text-center', 
						'options' => array(
							'format' => 'dd/mm/yy'
							),
						'placeholder' => 'Emissão',
						'prepend' => 'De',
						)
					); 	
		?>
		<?php 
			echo $form->datepickerRow(
					$model,
					'emissao_ate',
					array(
						'class' => 'input-mini text-center', 
						'options' => array(
							'format' => 'dd/mm/yy'
							),
						'placeholder' => 'Emissão',
						'prepend' => 'Até',
						)
					); 	
		?>
		<?php 
			echo $form->datepickerRow(
					$model,
					'saida_de',
					array(
						'class' => 'input-mini text-center', 
						'options' => array(
							'format' => 'dd/mm/yy'
							),
						'placeholder' => 'Saída/Entrada',
						'prepend' => 'De',
						)
					); 	
		?>
		<?php 
			echo $form->datepickerRow(
					$model,
					'saida_ate',
					array(
						'class' => 'input-mini text-center', 
						'options' => array(
							'format' => 'dd/mm/yy'
							),
						'placeholder' => 'Saída/Entrada',
						'prepend' => 'Até',
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

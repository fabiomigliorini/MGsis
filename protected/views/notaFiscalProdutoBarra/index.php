<?php
/*
$this->pagetitle = Yii::app()->name . ' - Nota Fiscal Produto Barra';
$this->breadcrumbs=array(
	'Nota Fiscal Produto Barra',
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
	$('#search-form-nfpb').change(function(){
		var ajaxRequest = $("#search-form-nfpb").serialize();
		$.fn.yiiListView.update(
			// this is the id of the CListView
			'ListagemNota',
			{data: ajaxRequest}
		);
    });
});

</script>

<h3>Notas Fiscais</h3>

<?php $form=$this->beginWidget('MGActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'id' => 'search-form-nfpb',
	'type' => 'inline',
	'method'=>'get',
)); 

?>
<div class="well well-small">
	
	<?php //echo $form->textField($model, 'codproduto', array('placeholder' => '#', 'class'=>'input-mini')); ?>
	<input type ="hidden" name="id" value="<?php echo $model->codproduto;?>">
	
	<?php 
		echo $form->datepickerRow(
				$model,
				'saida_de',
				array(
					'class' => 'input-mini text-center', 
					'options' => array(
						'format' => 'dd/mm/yy'
						),
					'placeholder' => 'Saída',
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
					'placeholder' => 'Saída',
					'prepend' => 'Até',
					)
				); 	
	?>
		
	<?php
		echo $form->select2(
				$model,
				'codfilial',
				Filial::getListaCombo(),
				array(
					'prompt'=>'', 
					'placeholder'=>'Filial', 
					'class'=>'input-medium'
					)
				);	
	?>
	<?php echo $form->select2($model,'codnaturezaoperacao', NaturezaOperacao::getListaCombo() , array(
					'prompt'=>'', 
					'placeholder'=>'Natureza', 
					'class'=>'input-xmedium'));?>

	<?php echo $form->select2Pessoa($model, 'codpessoa', array(
					'placeholder' => 'Pessoa', 
					'class' => 'input-xxlarge', 
					'inativo'=>true));?>
	
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
		'id' => 'ListagemNota',
		'dataProvider' => $dataProvider,
		'itemView' => '/notaFiscalProdutoBarra/_view',
		'template' => '{pager}<br>{items}',
		/*
		'pager' => array(
			'class' => 'ext.infiniteScroll.IasPager', 
			'rowSelector'=>'.registro', 
			'listViewId' => 'ListagemNota', 
			'header' => '',
			'loaderText'=>'Carregando...',
			'options' => array('history' => false, 'triggerPageTreshold' => 1, 'trigger'=>'Carregar mais registros'),
		)
		 * 
		 */
	)
);
?>

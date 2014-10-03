<?php
/*
$this->pagetitle = Yii::app()->name . ' - Negocio Produto Barra';
$this->breadcrumbs=array(
	'Negocio Produto Barra',
);

$this->menu=array(
	array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);
*/
?>

<script type='text/javascript'>

$(document).ready(function(){
	$('#search-form-npb').change(function(){
		var ajaxRequest = $("#search-form-npb").serialize();
		$.fn.yiiListView.update(
			// this is the id of the CListView
			'ListagemNegocio',
			{data: ajaxRequest}
		);
    });
});

</script>

<h3>Negócios</h3>

<br>

<?php $form=$this->beginWidget('MGActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'id' => 'search-form-npb',
	'type' => 'inline',
	'method'=>'get',
)); 

?>
<div class="well well-small">
	<input type ="hidden" name="id" value="<?php echo $model->codproduto;?>">

	<?php 
		echo $form->datepickerRow(
				$model,
				'lancamento_de',
				array(
					'class' => 'input-mini text-center', 
					'options' => array(
						'format' => 'dd/mm/yy'
						),
					'placeholder' => 'Data',
					'prepend' => 'De',
					)
				); 	
	?>
	
	<?php 
		echo $form->datepickerRow(
				$model,
				'lancamento_ate',
				array(
					'class' => 'input-mini text-center', 
					'options' => array(
						'format' => 'dd/mm/yy'
						),
					'placeholder' => 'Data',
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
		'id' => 'ListagemNegocio',
		'dataProvider' => $dataProvider,
		'itemView' => '/negocioProdutoBarra/_view',
		'template' => '{pager}<br>{items}',

		/*
		'pager' => array(
			'class' => 'ext.infiniteScroll.IasPager', 
			'rowSelector'=>'.registro', 
			'listViewId' => 'ListagemNegocio', 
			'header' => '',
			'loaderText'=>'Carregando...',
			'options' => array('history' => false, 'triggerPageTreshold' => 1, 'trigger'=>'Carregar mais registros'),
		)
		 * 
		 */
	)
);
?>

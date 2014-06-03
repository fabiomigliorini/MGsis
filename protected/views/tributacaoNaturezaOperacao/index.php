<?php
/*
$this->pagetitle = Yii::app()->name . ' - Tributação Natureza Operação';
$this->breadcrumbs=array(
	'Tributação Natureza Operação',
);

$this->menu=array(
	array('label'=>'Nova', 'icon'=>'icon-plus', 'url'=>array('create')),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);
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
	Tributações da Natureza de Operação
	<small>
		<?php echo CHtml::link("<i class=\"icon-plus\"></i> Nova", array("tributacaoNaturezaOperacao/create", "codnaturezaoperacao" => $model->codnaturezaoperacao)); ?>
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
	<input type ="hidden" name="id" value="<?php echo $model->codnaturezaoperacao;?>">

	<?php echo $form->textField($model, 'codtributacaonaturezaoperacao', array('placeholder' => 'Código', 'class'=>'input-mini')); ?>
	
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
			'codtipoproduto', 
			TipoProduto::getListaCombo(), 
			array(
				'placeholder'=>'Tipo Produto',
				'class' => 'input-xmedium'
			)
		);
	?>
	<?php
		echo $form->select2(
			$model, 
			'codestado', 
			Estado::getListaCombo(), 
			array(
				'placeholder'=>'Estado',
				'class' => 'input-small'
			)
		);
	?>
	<?php echo $form->textField($model, 'codcfop', array('placeholder' => 'Código CFOP', 'class'=>'input-Xmini')); ?>

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
		'itemView' => '/tributacaoNaturezaOperacao/_view',
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

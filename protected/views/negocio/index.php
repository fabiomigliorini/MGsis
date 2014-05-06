<?php
$this->pagetitle = Yii::app()->name . ' - Negócios';
$this->breadcrumbs=array(
	'Negócios',
);

$this->menu=array(
	array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);
?>

<script type='text/javascript'>
	/*
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
	*/
</script>

<h1>Negócios</h1>

<br>

<?php $form=$this->beginWidget('MGActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'id' => 'search-form',
	'type' => 'inline',
	'method'=>'get',
)); 

?>
<div class="well well-small">
	<?php echo $form->textField($model, 'codnegocio', array('placeholder' => '#', 'class'=>'input-mini')); ?>
	
	<span>
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
		$this->widget(
			'bootstrap.widgets.TbTimePicker',
			array(
				'model' => $model,
				'attribute' => 'horario_de',
				'htmlOptions' => array(
					'class' => 'input-mini text-center', 
					),
				'options' => array(
					'TbActiveForm' => $form,
					'showMeridian' => false,
					'showSeconds' => false,
					'defaultTime' => "00:00",
				)
			)
		);	
		
		?>
	</span>
	<span>
		<?
		
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
		$this->widget(
			'bootstrap.widgets.TbTimePicker',
			array(
				'model' => $model,
				'attribute' => 'horario_ate',
				'htmlOptions' => array(
					'class' => 'input-mini text-center', 
					),
				'options' => array(
					'TbActiveForm' => $form,
					'showMeridian' => false,
					'showSeconds' => false,
					'defaultTime' => "23:59",
				)
			)
		);	
		?>
	</span>
	<?php echo $form->select2Pessoa($model, 'codpessoa', array('class' => 'input-xlarge', 'inativo'=>true));?>
	<?php echo $form->select2($model, 'codnaturezaoperacao', NaturezaOperacao::getListaCombo(), array('placeholder'=>'Natureza', 'class' => 'input-xlarge')); ?>
	<?php echo $form->select2($model, 'codfilial', Filial::getListaCombo(), array('placeholder'=>'Filial', 'class' => 'input-medium')); ?>
	<?php echo $form->select2($model, 'codnegociostatus', NegocioStatus::getListaCombo(), array('placeholder'=>'Status', 'class' => 'input-medium')); ?>
	<?php echo $form->select2($model, 'codusuario', Usuario::getListaCombo(), array('placeholder'=>'Usuario', 'class' => 'input-medium')); ?>
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

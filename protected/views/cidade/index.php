<?php
$this->pagetitle = Yii::app()->name . ' - Cidade';
$this->breadcrumbs=array(
	'Cidade',
);

$this->menu=array(
	array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);
?>

<h1>Cidade</h1>

<br>

<?php $form=$this->beginWidget('MGActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'type' => 'search',
	'method'=>'get',
)); 

?>
<div class="controls-row well well-small">
	<div class="span11">
	<?php echo $form->textField($model, 'cidade', array('placeholder' => 'Cidade', 'class'=>'input-large')); ?>
	<?php
		echo $form->select2(
			$model, 
			'codestado', 
			Estado::getListaCombo(), 
			array(
				'placeholder'=>'Estado',
				'class' => 'input-medium'
			)
		);
	?>
	<?php echo $form->textField($model, 'codigooficial', array('placeholder' => 'Código Oficial', 'class'=>'input-large')); ?>
	</div>
	<div class="span1 right">
	<?php

	$this->widget('bootstrap.widgets.TbButton'
		, array(
			'buttonType' => 'submit',
			'icon'=>'icon-search',
			//'label'=>'',
			'htmlOptions' => array('class'=>'btn btn-info')
			)
		); 
	
	?>
	</div>
		
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

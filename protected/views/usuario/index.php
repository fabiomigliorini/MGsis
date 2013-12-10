<?php
$this->pagetitle = Yii::app()->name . ' - Usuario';
$this->breadcrumbs=array(
	'Usuario',
);

$this->menu=array(
	array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);
?>

<h1>Usuario</h1>

<br>

<?php $form=$this->beginWidget('MGActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'type' => 'search',
	'method'=>'get',
)); 

?>

<div class="well well-small">
	<?php echo $form->textField($model, 'codusuario', array('placeholder' => '#', 'class'=>'input-mini')); ?>
	<?php echo $form->textField($model, 'usuario', array('class' => 'input-large', 'placeholder' => 'usuario'));  ?>
	<?php echo $form->select2Pessoa(
				$model, 
				'codpessoa',
				array('class' => 'input-xxlarge')
				); 
	?>
	<?php echo $form->dropDownList(
				$model,
				'codfilial',
				Filial::getListaCombo(),
				array('prompt'=>'', 'class' => 'input-small', 'placeholder' => 'Filial')
				);	

	?>
	<?php $this->widget('bootstrap.widgets.TbButton'
				, array(
					'buttonType' => 'submit',
					'icon'=>'icon-search',
					//'label'=>'',
					'htmlOptions' => array('class'=>'btn btn-info pull-right')
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
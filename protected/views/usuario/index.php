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

<div class="controls-row well well-small">
	<div class="span11">
	<?php
		echo $form->textField($model, 'codusuario', array('placeholder' => '#', 'class'=>'span1')); 

		echo $form->textField($model, 'usuario', array('class' => 'span2', 'placeholder' => 'usuario')); 

		echo $form->select2Pessoa(
				$model, 
				'codpessoa',
				array('class' => 'span4')
				);

		echo $form->dropDownList(
				$model,
				'codfilial',
				Filial::getListaCombo(),
				array('prompt'=>'', 'class' => 'span2', 'placeholder' => 'Filial')
				);	

	?>
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
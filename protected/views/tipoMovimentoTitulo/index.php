<?php
$this->pagetitle = Yii::app()->name . ' - Tipo Movimento Títulos';
$this->breadcrumbs=array(
	'Tipo Movimento Títulos',
);

$this->menu=array(
	array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
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

<h1>Tipos de Movimentos de Títulos</h1>

<br>

<?php $form=$this->beginWidget('MGActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'id' => 'search-form',
	'type' => 'inline',
	'method'=>'get',
)); 

?>
<div class="well well-small">
	<?php echo $form->textField($model, 'codtipomovimentotitulo', array('placeholder' => '#', 'class'=>'input-mini')); ?>
	<?php echo $form->textField($model, 'tipomovimentotitulo', array('placeholder' => 'Descrição', 'class'=>'input-large')); ?>
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

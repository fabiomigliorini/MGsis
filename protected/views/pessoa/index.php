<?php
$this->pagetitle = Yii::app()->name . ' - Pessoa';
$this->breadcrumbs=array(
	'Pessoa',
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

<h1>Pessoas</h1>

<br>

<?php $form=$this->beginWidget('MGActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'id' => 'search-form',
	'type' => 'inline',
	'method'=>'get',
)); 

?>

<div class="well well-small">
	<?php echo $form->textField($model, 'codpessoa', array('placeholder' => '#', 'class'=>'input-mini')); ?>
	<?php echo $form->textField($model, 'fantasia', array('placeholder' => 'Nome', 'class'=>'input-large')); ?>
	<?php echo $form->textField($model, 'cnpj', array('placeholder' => 'Cnpj/Cpf', 'class'=>'input-small')); ?>
	<?php echo $form->textField($model, 'email', array('placeholder' => 'Email', 'class'=>'input-small')); ?>
	<?php echo $form->textField($model, 'telefone1', array('placeholder' => 'Fone', 'class'=>'input-small')); ?>
	<?php echo $form->dropDownList($model, 'inativo', array('' => 'Ativos', 1 => 'Inativos', 9 => 'Todos'), array('placeholder' => 'Inativo', 'class'=>'input-small')); ?>
	<?php echo $form->select2Cidade($model, 'codcidade', array('class' => 'input-large') );?>
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

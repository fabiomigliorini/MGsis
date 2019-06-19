<?php
/*
$this->pagetitle = Yii::app()->name . ' - Pessoa Certidao';
$this->breadcrumbs=array(
	'Pessoa Certidao',
);

$this->menu=array(
	array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
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
	Certidões
	<small>
		<?php echo CHtml::link("<i class=\"icon-plus\"></i> Nova", array("pessoaCertidao/create", "codpessoa" => $model->codpessoa)); ?>
	</small>
</h2>

<?php

$this->widget(
	'zii.widgets.CListView',
	array(
		'id' => 'Listagem',
		'dataProvider' => $dataProvider,
		'itemView' => '/pessoaCertidao/_view',
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

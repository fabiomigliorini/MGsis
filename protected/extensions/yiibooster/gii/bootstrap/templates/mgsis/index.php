<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php
echo "<?php\n";
$label = $this->class2name($this->modelClass);

echo "\$this->pagetitle = Yii::app()->name . ' - $label';\n";

echo "\$this->breadcrumbs=array(
	'$label',
);\n";
?>

$this->menu=array(
	array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);
?>

<h1><?php echo $label; ?></h1>

<br>

<?php echo "<?php \$form=\$this->beginWidget('MGActiveForm',array(\n"; ?>
	'action'=>Yii::app()->createUrl($this->route),
	'type' => 'search',
	'method'=>'get',
)); 

<?php echo "?>"; ?>

<div class="controls-row well well-small">
	<div class="span11">
	<?php echo "<?php\n"; ?>
		echo $form->textField($model, 'codusuariocriacao', array('placeholder' => '#', 'class'=>'span1')); 
	<?php echo "?>\n"; ?>
	</div>
	<div class="span1 right">
	<?php echo "<?php\n"; ?>

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

<?php echo "<?php \$this->endWidget(); ?>\n";?>


<?php echo "<?php\n"; ?> 
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

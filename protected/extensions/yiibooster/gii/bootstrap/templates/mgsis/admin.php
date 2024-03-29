<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php
echo "<?php\n";
$label = $this->class2name($this->modelClass);

echo "\$this->pagetitle = Yii::app()->name . ' - Gerenciar $label';\n";

echo "\$this->breadcrumbs=array(
	'$label'=>array('index'),
	'Gerenciar',
);\n";
?>

$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
	array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	);

Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
	$('.search-form').toggle();
		return false;
		});
	$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('<?php echo $this->class2id($this->modelClass); ?>-grid', {
			data: $(this).serialize()
		});
		return false;
		});
");
?>

<h1>Gerenciar <?php echo $this->class2name($this->modelClass); ?></h1>


<?php echo "<?php echo CHtml::link('Busca Avançada','#',array('class'=>'search-button btn')); ?>"; ?>

<div class="search-form" style="display:none">
	<?php echo "<?php \$this->renderPartial('_search',array(
	'model'=>\$model,
)); ?>\n"; ?>
</div><!-- search-form -->

<?php echo "<?php"; ?> 
$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'<?php echo $this->class2id($this->modelClass); ?>-grid',
	'dataProvider'=>$model->search(),
	'type'=>'striped condensed hover bordered',
	'filter'=>$model,
	'template'=>'{items} {pager}',
	'columns'=>array(
<?php
$count = 0;
foreach ($this->tableSchema->columns as $column) {
	if (in_array($column->name, array('alteracao', 'codusuarioalteracao', 'criacao', 'codusuariocriacao')))
			continue;
	if (++$count == 7) {
		echo "\t\t/*\n";
	}
	?>
		array(
			'name'=>'<?php echo $column->name ?>',
			'htmlOptions'=> array('class'=>'span1'),
			),	
	<?
	//echo "\t\t'" . $column->name . "',\n";
}
if ($count >= 7) {
	echo "\t\t*/\n";
}
?>
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'htmlOptions'=> array('class'=>'span1'),
			),
		),
	)); 
?>

<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php
echo "<?php\n";
$nameColumn = $this->guessNameColumn($this->tableSchema->columns);
$label = $this->class2name($this->modelClass);

echo "\$this->pagetitle = Yii::app()->name . ' - Alterar $label';\n";

echo "\$this->breadcrumbs=array(
	'$label'=>array('index'),
	\$model->{$nameColumn}=>array('view','id'=>\$model->{$this->tableSchema->primaryKey}),
	'Alterar',
);\n";
?>

	$this->menu=array(
	array('label'=>'Lista', 'icon'=>'icon-list-alt', 'url'=>array('index')),
	array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	array('label'=>'Detalhes', 'icon'=>'icon-eye-open', 'url'=>array('view','id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>)),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);
	?>

	<h1>Alterar <?php echo $this->modelClass . " #<?php echo \$model->{$this->tableSchema->primaryKey}; ?>"; ?></h1>

<?php echo "\t<?php echo \$this->renderPartial('_form',array('model'=>\$model)); ?>"; ?>
	
<?php echo "\t<?php \$this->widget('UsuarioCriacao', array('model'=>\$model)); ?>"; ?>
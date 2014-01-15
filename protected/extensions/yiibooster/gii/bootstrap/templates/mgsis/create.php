<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php
echo "<?php\n";

$label = $this->class2name($this->modelClass);

echo "\$this->pagetitle = Yii::app()->name . ' - Novo $label';\n";

echo "\$this->breadcrumbs=array(
	'$label'=>array('index'),
	'Novo',
);\n";
?>

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);
?>

<h1>Novo <?php echo $this->modelClass; ?></h1>

<?php echo "<?php echo \$this->renderPartial('_form', array('model'=>\$model)); ?>"; ?>

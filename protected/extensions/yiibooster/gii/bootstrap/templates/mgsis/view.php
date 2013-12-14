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

echo "\$this->pagetitle = Yii::app()->name . ' - Detalhes $label';\n";

echo "\$this->breadcrumbs=array(
	'$label'=>array('index'),
	\$model->{$nameColumn},
);\n";
?>

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
array('label'=>'Alterar', 'icon'=>'icon-pencil', 'url'=>array('update','id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>)),
array('label'=>'Excluir', 'icon'=>'icon-trash', 'url'=>'#', 'linkOptions'=>	array('id'=>'btnExcluir')),
//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);

Yii::app()->clientScript->registerCoreScript('yii');

?>
<script type="text/javascript">
/*<![CDATA[*/
$(document).ready(function(){
	jQuery('body').on('click','#btnExcluir',function() {
		bootbox.confirm("Excluir este registro?", function(result) {
			if (result)
				jQuery.yii.submitForm(document.body.childNodes[0], "<?php echo "<?php";?> echo Yii::app()->createUrl('<?php echo $this->class2id($this->modelClass); ?>/delete', array('id' => $model-><?php echo $nameColumn; ?>))?>",{});
		});
	});
});
/*]]>*/
</script>

<h1><?php echo "<?php echo \$model->{$this->tableSchema->primaryKey}; ?>"; ?></h1>

<?php echo "<?php"; ?> 
$this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
	<?php
	foreach ($this->tableSchema->columns as $column) {
		if (in_array($column->name, array('codusuarioalteracao', 'alteracao', 'codusuariocriacao', 'criacao')))
			continue;
		echo "\t\t'" . $column->name . "',\n";
	}
	?>
		),
	)); 

	$this->widget('UsuarioCriacao', array('model'=>$model));

?>

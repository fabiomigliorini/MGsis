<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<div class="registro row-fluid">
	<b class="span2">
	<?php
	echo "\t<?php echo CHtml::encode(\$data->getAttributeLabel('{$this->tableSchema->primaryKey}')); ?>:\n";
	echo "\t\t<?php echo CHtml::link(CHtml::encode(Yii::app()->format->formataCodigo(\$data->{$this->tableSchema->primaryKey})),array('view','id'=>\$data->{$this->tableSchema->primaryKey})); ?>\n";
	?>
	</b>
	<?php
	echo "\n";
	$count = 0;
	foreach ($this->tableSchema->columns as $column) {
		if (($column->isPrimaryKey) 
                || (in_array($column->name, array('alteracao', 'codusuarioalteracao', 'criacao', 'codusuariocriacao')))
				)
		{
			continue;
		}
		if (++$count == 7) {
			echo "\t\t<?php /*\n";
		}
		echo "\t\t<small class=\"span2 muted\"><?php echo CHtml::encode(\$data->{$column->name}); ?></small>\n\n";
	}
	if ($count >= 7) {
		echo "\t\t*/ ?>\n";
	}
	?>
</div>
<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<div class="registro">
	<div class="row-fluid">
	<div class="span2 codigo">
	<?php
	echo "\t<?php echo CHtml::encode(\$data->getAttributeLabel('{$this->tableSchema->primaryKey}')); ?>:\n";
	echo "\t\t<?php echo CHtml::link(CHtml::encode(Yii::app()->format->formataCodigo(\$data->{$this->tableSchema->primaryKey})),array('view','id'=>\$data->{$this->tableSchema->primaryKey})); ?>\n";
	?>
	</div>
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
		echo "\t\t<div class=\"span2 detalhes\"><?php echo CHtml::encode(\$data->{$column->name}); ?></div>\n\n";
	}
	if ($count >= 7) {
		echo "\t\t*/ ?>\n";
	}
	?>
	</div>
</div>
<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php echo "<?php \$form=\$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'" . $this->class2id($this->modelClass) . "-form',
	'type' => 'horizontal',
	'enableAjaxValidation'=>true,
)); ?>\n"; ?>

<?php echo "<?php echo \$form->errorSummary(\$model); ?>\n"; ?>

<?php
foreach ($this->tableSchema->columns as $column) {
	if (($column->autoIncrement) 
                || (($column->isPrimaryKey) && ($column->dbType == 'bigint')) 
                || (in_array($column->name, array('alteracao', 'codusuarioalteracao', 'criacao', 'codusuariocriacao')))
                ) {
		continue;
	}
	?>
	<?php echo "<?php echo " . $this->generateActiveRow($this->modelClass, $column) . "; ?>\n"; ?>

<?php
}
?>
<div class="form-actions">
    
    <?php echo "
    <?php 
	

        \$this->widget(
            'bootstrap.widgets.TbButton',
            array(
                'buttonType' => 'submit',
                'type' => 'primary',
                'label' => 'Salvar',
                'icon' => 'icon-ok',
                )
            ); 
	?>
	<?php
        \$this->widget(
            'bootstrap.widgets.TbButton',
            array(
                'buttonType' => 'reset',
                'label' => 'Limpar',
                'icon' => 'icon-refresh'
                )
            );
    ?>
    "; ?>
</div>

<?php echo "<?php \$this->endWidget(); ?>\n"; ?>

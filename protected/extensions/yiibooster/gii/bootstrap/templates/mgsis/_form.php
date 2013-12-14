<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php echo "<?php \$form=\$this->beginWidget('MGActiveForm',array(
	'id'=>'" . $this->class2id($this->modelClass) . "-form',
)); ?>\n"; ?>

<?php echo "<?php echo \$form->errorSummary(\$model); ?>\n"; ?>

<fieldset>
	<?php echo "<?php "; ?>
	
<?php
foreach ($this->tableSchema->columns as $column) {
	if (($column->autoIncrement) 
                || (($column->isPrimaryKey) && ($column->dbType == 'bigint')) 
                || (in_array($column->name, array('alteracao', 'codusuarioalteracao', 'criacao', 'codusuariocriacao')))
                ) {
		continue;
	}
	?>
		<?php echo "echo " . $this->generateActiveRow($this->modelClass, $column) . ";"; ?>

<?php
}
?>
	<?php echo "?>"; ?>

</fieldset>
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

<script type='text/javascript'>
	
$(document).ready(function() {

	//$("#Pessoa_fantasia").Setcase();

	$('#<?php echo $this->class2id($this->modelClass); ?>-form').submit(function(e) {
        var currentForm = this;
        e.preventDefault();
        bootbox.confirm("Tem certeza que deseja salvar?", function(result) {
            if (result) {
                currentForm.submit();
            }
        });
    });
	
});

</script>
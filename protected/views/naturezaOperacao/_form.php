<?php $form=$this->beginWidget('MGActiveForm',array(
	'id'=>'natureza-operacao-form',
)); ?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
	<?php 	
		echo $form->textFieldRow($model,'naturezaoperacao',array('class'=>'medum','maxlength'=>50));
		echo $form->select2Row($model, 'codoperacao', Operacao::getListaCombo(), array('class' => 'input-medium'));
		//echo $form->checkBoxRow($model,'emitida');
		echo $form->toggleButtonRow($model,'emitida', array('options' => array('enabledLabel' => 'Sim', 'disabledLabel' => 'Não')));
		echo $form->textFieldRow($model,'observacoesnf',array('class'=>'span5','maxlength'=>500));
	?>
</fieldset>
<div class="form-actions">

    
    <?php 
	

        $this->widget(
            'bootstrap.widgets.TbButton',
            array(
                'buttonType' => 'submit',
                'type' => 'primary',
                'label' => 'Salvar',
                'icon' => 'icon-ok',
                )
            ); 
	?>
    
</div>

<?php $this->endWidget(); ?>

<script type='text/javascript'>
	
$(document).ready(function() {

	$("#NaturezaOperacao_naturezaoperacao").Setcase();

	$('#natureza-operacao-form').submit(function(e) {
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
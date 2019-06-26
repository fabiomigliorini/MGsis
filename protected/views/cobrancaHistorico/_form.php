<?php $form=$this->beginWidget('MGActiveForm',array(
	'id'=>'cobranca-historico-form',
)); ?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
	<?php 	
		//echo $form->textFieldRow($model,'historico',array('class'=>'span5','maxlength'=>255));
		echo $form->textAreaRow($model,'historico',array('class'=>'span5', 'rows'=>'5','maxlength'=>300));
		//echo $form->checkBoxRow($model,'emailautomatico');
		//echo $form->toggleButtonRow($model,'emailautomatico', array('options' => array('enabledLabel' => 'Sim', 'disabledLabel' => 'Não')));

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

	//$("#Pessoa_fantasia").Setcase();

	$('#cobranca-historico-form').submit(function(e) {
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
<?php $form=$this->beginWidget('MGActiveForm',array(
	'id'=>'banco-form',
)); ?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
	<?php 	
		echo $form->textFieldRow($model,'banco',array('class'=>'input-large','maxlength'=>50));
		echo $form->textFieldRow($model,'sigla',array('class'=>'input-mini','maxlength'=>3));
		echo $form->textFieldRow($model,'numerobanco',array('class'=>'input-mini text-right'));
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

	$("#Banco_banco").Setcase();

	$('#banco-form').submit(function(e) {
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
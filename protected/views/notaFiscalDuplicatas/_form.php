<?php $form=$this->beginWidget('MGActiveForm',array(
	'id'=>'nota-fiscal-duplicatas-form',
)); ?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
	<?php 	
		echo $form->textFieldRow($model,'codnotafiscal',array('class'=>'span5'));
		echo $form->textFieldRow($model,'fatura',array('class'=>'span5','maxlength'=>20));
		echo $form->textFieldRow($model,'vencimento',array('class'=>'span5'));
		echo $form->textFieldRow($model,'valor',array('class'=>'span5','maxlength'=>14));
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

	$('#nota-fiscal-duplicatas-form').submit(function(e) {
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
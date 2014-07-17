<?php $form=$this->beginWidget('MGActiveForm',array(
	'id'=>'nfe-terceiro-duplicata-form',
)); ?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
	<?php 	
		echo $form->textFieldRow($model,'codnfeterceiro',array('class'=>'span5'));
		echo $form->textFieldRow($model,'codtitulo',array('class'=>'span5'));
		echo $form->textFieldRow($model,'ndup',array('class'=>'span5','maxlength'=>50));
		echo $form->textFieldRow($model,'dvenc',array('class'=>'span5'));
		echo $form->textFieldRow($model,'vdup',array('class'=>'span5','maxlength'=>14));
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

	$('#nfe-terceiro-duplicata-form').submit(function(e) {
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
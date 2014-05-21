<?php $form=$this->beginWidget('MGActiveForm',array(
	'id'=>'cfop-form',
)); ?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
	<?php
		if ($model->isNewRecord)
			echo $form->textFieldRow($model,'codcfop',array('class'=>'span5','maxlength'=>100));
		
		echo $form->textFieldRow($model,'cfop',array('class'=>'span5','maxlength'=>100));
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

	$("#Cfop_cfop").Setcase();

	$('#cfop-form').submit(function(e) {
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
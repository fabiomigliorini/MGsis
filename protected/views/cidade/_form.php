<?php $form=$this->beginWidget('MGActiveForm',array(
	'id'=>'cidade-form',
)); ?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
	<?php 	
		//echo $form->textFieldRow($model,'codestado',array('class'=>'input-xmini'));
		//echo $form->select2Row($model, 'codestado', Estado::getListaCombo(), array('class' => 'input-medium'));
		echo $form->textFieldRow($model,'cidade',array('class'=>'input-xlarge','maxlength'=>50));
		echo $form->textFieldRow($model,'sigla',array('class'=>'input-mini','maxlength'=>3));
		echo $form->textFieldRow($model,'codigooficial',array('class'=>'input-mini'));
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

	$("#Cidade_cidade").Setcase();

	$('#estado-form').submit(function(e) {
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
<?php $form=$this->beginWidget('MGActiveForm',array(
	'id'=>'estado-form',
)); ?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
	<?php 	
		//echo $form->textFieldRow($model,'codpais',array('class'=>'span5'));
		//echo $form->select2Row($model, 'codpais', Pais::getListaCombo(), array('class' => 'input-medium'));
		echo $form->textFieldRow($model,'estado',array('class'=>'input-medium','maxlength'=>50));
		echo $form->textFieldRow($model,'sigla',array('class'=>'input-mini','maxlength'=>2));
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

	$("#Estado_estado").Setcase();

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
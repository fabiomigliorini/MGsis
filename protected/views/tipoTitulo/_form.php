<?php $form=$this->beginWidget('MGActiveForm',array(
	'id'=>'tipo-titulo-form',
)); ?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
	<?php 	
		echo $form->textFieldRow($model,'tipotitulo',array('class' => 'imput-mini','maxlength'=>20));
		echo $form->toggleButtonRow($model,'pagar', array('options' => array('enabledLabel' => 'Sim', 'disabledLabel' => 'Não')));
		echo $form->toggleButtonRow($model,'receber', array('options' => array('enabledLabel' => 'Sim', 'disabledLabel' => 'Não')));
		echo $form->textFieldRow($model,'observacoes',array('class'=>'imput-mini','maxlength'=>255));
		echo $form->textFieldRow($model,'codtipomovimentotitulo',array('class'=>'span5'));
		//echo $form->select2Row($model, 'codtipomovimentotitulo', Usuario::getListaCombo(), array('class' => 'input-medium'));
		echo $form->toggleButtonRow($model,'debito', array('options' => array('enabledLabel' => 'Sim', 'disabledLabel' => 'Não')));
		echo $form->toggleButtonRow($model,'credito', array('options' => array('enabledLabel' => 'Sim', 'disabledLabel' => 'Não')));
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

	$("#TipoTitulo_tipotitulo").Setcase();

	$('#tipo-titulo-form').submit(function(e) {
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
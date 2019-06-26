<?php $form=$this->beginWidget('MGActiveForm',array(
	'id'=>'tipo-movimento-titulo-form',
)); ?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
	<?php 	
		echo $form->textFieldRow($model,'tipomovimentotitulo',array('class'=>'input-xlarge','maxlength'=>20));
		echo $form->toggleButtonRow($model,'implantacao', array('options' => array('enabledLabel' => 'Sim', 'disabledLabel' => 'Não')));
		echo $form->toggleButtonRow($model,'ajuste', array('options' => array('enabledLabel' => 'Sim', 'disabledLabel' => 'Não')));
		echo $form->toggleButtonRow($model,'armotizacao', array('options' => array('enabledLabel' => 'Sim', 'disabledLabel' => 'Não')));
		echo $form->toggleButtonRow($model,'juros', array('options' => array('enabledLabel' => 'Sim', 'disabledLabel' => 'Não')));
		echo $form->toggleButtonRow($model,'desconto', array('options' => array('enabledLabel' => 'Sim', 'disabledLabel' => 'Não')));
		echo $form->toggleButtonRow($model,'pagamento', array('options' => array('enabledLabel' => 'Sim', 'disabledLabel' => 'Não')));
		echo $form->toggleButtonRow($model,'estorno', array('options' => array('enabledLabel' => 'Sim', 'disabledLabel' => 'Não')));
		echo $form->textAreaRow($model,'observacao',array('class'=>'input-xlarge', 'rows'=>'5','maxlength'=>255));
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

	$("#TipoMovimentoTitulo_tipomovimentotitulo").Setcase();

	$('#tipo-movimento-titulo-form').submit(function(e) {
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
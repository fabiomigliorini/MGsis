<?php $form=$this->beginWidget('MGActiveForm',array(
	'id'=>'forma-pagamento-form',
)); ?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
	<?php 	
		echo $form->textFieldRow($model,'formapagamento',array('class'=>'input-large','maxlength'=>50));
		//echo $form->checkBoxRow($model,'boleto');
		echo $form->toggleButtonRow($model,'boleto', array('options' => array('enabledLabel' => 'Sim', 'disabledLabel' => 'Não')));
		//echo $form->checkBoxRow($model,'fechamento');
		echo $form->toggleButtonRow($model,'fechamento', array('options' => array('enabledLabel' => 'Sim', 'disabledLabel' => 'Não')));
		//echo $form->checkBoxRow($model,'notafiscal');
		echo $form->toggleButtonRow($model,'notafiscal', array('options' => array('enabledLabel' => 'Sim', 'disabledLabel' => 'Não')));
		echo $form->textFieldRow($model,'parcelas',array('class'=>'input-mini'));
		echo $form->textFieldRow($model,'diasentreparcelas',array('class'=>'input-mini'));
		//echo $form->checkBoxRow($model,'avista');
		echo $form->toggleButtonRow($model,'avista', array('options' => array('enabledLabel' => 'Sim', 'disabledLabel' => 'Não')));
		echo $form->textFieldRow($model,'formapagamentoecf',array('class'=>'input-mini','maxlength'=>5));
		//echo $form->checkBoxRow($model,'entrega');
		echo $form->toggleButtonRow($model,'entrega', array('options' => array('enabledLabel' => 'Sim', 'disabledLabel' => 'Não')));
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

	$("#FormaPagamento_formapagamento").Setcase();

	$('#forma-pagamento-form').submit(function(e) {
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
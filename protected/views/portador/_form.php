<?php $form=$this->beginWidget('MGActiveForm',array(
	'id'=>'portador-form',
)); ?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
	<?php 	
		echo $form->textFieldRow($model,'portador',array('class'=>'input-large','maxlength'=>50));
		//echo $form->textFieldRow($model,'codbanco',array('class'=>'span5'));
		echo $form->select2Row($model, 'codbanco', Banco::getListaCombo(), array('prompt' => '', 'class' => 'input-large'));
		echo $form->textFieldRow($model,'agencia',array('class'=>'input-mini text-right'));
		echo $form->textFieldRow($model,'agenciadigito',array('class'=>'input-mini text-right'));
		echo $form->textFieldRow($model,'conta',array('class'=>'input-mini text-right'));
		echo $form->textFieldRow($model,'contadigito',array('class'=>'input-mini text-right'));
		//echo $form->checkBoxRow($model,'emiteboleto');
		echo $form->toggleButtonRow($model,'emiteboleto', array('options' => array('enabledLabel' => 'Sim', 'disabledLabel' => 'Não')));
		//echo $form->textFieldRow($model,'codfilial',array('class'=>'span5'));
		echo $form->select2Row($model, 'codfilial', Filial::getListaCombo(), array('prompt' => '', 'class' => 'input-large'));
		echo $form->textFieldRow($model,'convenio',array('class'=>'input-large','maxlength'=>20));
		echo $form->textFieldRow($model,'diretorioremessa',array('class'=>'input-large','maxlength'=>100));
		echo $form->textFieldRow($model,'diretorioretorno',array('class'=>'input-large','maxlength'=>100));
		echo $form->textFieldRow($model,'carteira',array('class'=>'input-large'));
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

	$("#Portador_portador").Setcase();

	$('#portador-form').submit(function(e) {
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
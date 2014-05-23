<?php $form=$this->beginWidget('MGActiveForm',array(
	'id'=>'cheque-form',
)); ?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
	<?php 	
		echo $form->textFieldRow($model,'cmc7',array('class'=>'span5','maxlength'=>50));
		echo $form->textFieldRow($model,'codbanco',array('class'=>'span5'));
		echo $form->textFieldRow($model,'agencia',array('class'=>'span5','maxlength'=>10));
		echo $form->textFieldRow($model,'contacorrente',array('class'=>'span5','maxlength'=>15));
		echo $form->textFieldRow($model,'emitente',array('class'=>'span5','maxlength'=>100));
		echo $form->textFieldRow($model,'numero',array('class'=>'span5','maxlength'=>15));
		echo $form->textFieldRow($model,'emissao',array('class'=>'span5'));
		echo $form->textFieldRow($model,'vencimento',array('class'=>'span5'));
		echo $form->textFieldRow($model,'repasse',array('class'=>'span5'));
		echo $form->textFieldRow($model,'destino',array('class'=>'span5','maxlength'=>50));
		echo $form->textFieldRow($model,'devolucao',array('class'=>'span5'));
		echo $form->textFieldRow($model,'motivodevolucao',array('class'=>'span5','maxlength'=>50));
		echo $form->textFieldRow($model,'observacao',array('class'=>'span5','maxlength'=>200));
		echo $form->textFieldRow($model,'lancamento',array('class'=>'span5'));
		echo $form->textFieldRow($model,'cancelamento',array('class'=>'span5'));
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

	$('#cheque-form').submit(function(e) {
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
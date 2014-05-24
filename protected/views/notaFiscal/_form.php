<?php $form=$this->beginWidget('MGActiveForm',array(
	'id'=>'nota-fiscal-form',
)); ?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
	<?php 	
		echo $form->textFieldRow($model,'codnaturezaoperacao',array('class'=>'span5'));
		echo $form->checkBoxRow($model,'emitida');
		echo $form->textFieldRow($model,'nfechave',array('class'=>'span5','maxlength'=>100));
		echo $form->checkBoxRow($model,'nfeimpressa');
		echo $form->textFieldRow($model,'serie',array('class'=>'span5'));
		echo $form->textFieldRow($model,'numero',array('class'=>'span5'));
		echo $form->textFieldRow($model,'emissao',array('class'=>'span5'));
		echo $form->textFieldRow($model,'saida',array('class'=>'span5'));
		echo $form->textFieldRow($model,'codfilial',array('class'=>'span5'));
		echo $form->textFieldRow($model,'codpessoa',array('class'=>'span5'));
		echo $form->textFieldRow($model,'observacoes',array('class'=>'span5','maxlength'=>500));
		echo $form->textFieldRow($model,'volumes',array('class'=>'span5'));
		echo $form->checkBoxRow($model,'fretepagar');
		echo $form->textFieldRow($model,'codoperacao',array('class'=>'span5'));
		echo $form->textFieldRow($model,'nfereciboenvio',array('class'=>'span5','maxlength'=>100));
		echo $form->textFieldRow($model,'nfedataenvio',array('class'=>'span5'));
		echo $form->textFieldRow($model,'nfeautorizacao',array('class'=>'span5','maxlength'=>100));
		echo $form->textFieldRow($model,'nfedataautorizacao',array('class'=>'span5'));
		echo $form->textFieldRow($model,'valorfrete',array('class'=>'span5','maxlength'=>14));
		echo $form->textFieldRow($model,'valorseguro',array('class'=>'span5','maxlength'=>14));
		echo $form->textFieldRow($model,'valordesconto',array('class'=>'span5','maxlength'=>14));
		echo $form->textFieldRow($model,'valoroutras',array('class'=>'span5','maxlength'=>14));
		echo $form->textFieldRow($model,'nfecancelamento',array('class'=>'span5','maxlength'=>100));
		echo $form->textFieldRow($model,'nfedatacancelamento',array('class'=>'span5'));
		echo $form->textFieldRow($model,'nfeinutilizacao',array('class'=>'span5','maxlength'=>100));
		echo $form->textFieldRow($model,'nfedatainutilizacao',array('class'=>'span5'));
		echo $form->textFieldRow($model,'justificativa',array('class'=>'span5','maxlength'=>200));
		echo $form->textFieldRow($model,'valorprodutos',array('class'=>'span5','maxlength'=>14));
		echo $form->textFieldRow($model,'valortotal',array('class'=>'span5','maxlength'=>14));
		echo $form->textFieldRow($model,'icmsbase',array('class'=>'span5','maxlength'=>14));
		echo $form->textFieldRow($model,'icmsvalor',array('class'=>'span5','maxlength'=>14));
		echo $form->textFieldRow($model,'icmsstbase',array('class'=>'span5','maxlength'=>14));
		echo $form->textFieldRow($model,'icmsstvalor',array('class'=>'span5','maxlength'=>14));
		echo $form->textFieldRow($model,'ipibase',array('class'=>'span5','maxlength'=>14));
		echo $form->textFieldRow($model,'ipivalor',array('class'=>'span5','maxlength'=>14));
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

	$('#nota-fiscal-form').submit(function(e) {
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
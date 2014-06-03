<?php $form=$this->beginWidget('MGActiveForm',array(
	'id'=>'tributacao-natureza-operacao-form',
)); ?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
	<?php 	
		//echo $form->textFieldRow($model,'codtributacao',array('class'=>'span5'));
		echo $form->select2Row($model, 'codtributacao', Tributacao::getListaCombo(), array('prompt' => '', 'class' => 'input-large'));
		//echo $form->textFieldRow($model,'codnaturezaoperacao',array('class'=>'span5'));
		//echo $form->select2Row($model, 'codnaturezaoperacao', NaturezaOperacao::getListaCombo(), array('prompt' => '', 'class' => 'input-large'));
		//echo $form->textFieldRow($model,'codcfop',array('class'=>'span5'));
		echo $form->select2Row($model, 'codcfop', Cfop::getListaCombo(), array('prompt' => '', 'class' => 'input-xxlarge'));
		echo $form->textFieldRow($model,'icmsbase',array('class'=>'input-mini','maxlength'=>14));
		echo $form->textFieldRow($model,'icmspercentual',array('class'=>'input-mini','maxlength'=>14));
		//echo $form->textFieldRow($model,'codestado',array('class'=>'span5'));
		echo $form->select2Row($model, 'codestado', Estado::getListaCombo(), array('prompt' => '', 'class' => 'input-medium'));
		echo $form->textFieldRow($model,'csosn',array('class'=>'input-xmini','maxlength'=>4));
		//echo $form->textFieldRow($model,'codtipoproduto',array('class'=>'span5'));
		echo $form->select2Row($model, 'codtipoproduto', TipoProduto::getListaCombo(), array('prompt' => '', 'class' => 'input-large'));
		echo $form->textFieldRow($model,'acumuladordominiovista',array('class'=>'input-mini'));
		echo $form->textFieldRow($model,'acumuladordominioprazo',array('class'=>'input-mini'));
		echo $form->textFieldRow($model,'historicodominio',array('class'=>'input-xmini','maxlength'=>512));
		//echo $form->checkBoxRow($model,'movimentacaofisica');
		//echo $form->checkBoxRow($model,'movimentacaocontabil');
		echo $form->toggleButtonRow($model,'movimentacaofisica', array('options' => array('enabledLabel' => 'Sim', 'disabledLabel' => 'Não')));
		echo $form->toggleButtonRow($model,'movimentacaocontabil', array('options' => array('enabledLabel' => 'Sim', 'disabledLabel' => 'Não')));
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

	$('#tributacao-natureza-operacao-form').submit(function(e) {
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
<?php $form=$this->beginWidget('MGActiveForm',array(
	'id'=>'produto-embalagem-form',
)); ?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
	<?php 	
		//echo $form->textFieldRow($model,'codproduto',array('class'=>'span5'));
		//echo $form->textFieldRow($model,'codunidademedida',array('class'=>'span5'));
		echo $form->dropDownListRow($model, 'codunidademedida', UnidadeMedida::getListaCombo(), array('prompt' => '', 'class' => 'input-mini'));
		echo $form->textFieldRow($model,'quantidade',array('class'=>'input-small text-right','maxlength'=>14));
		echo $form->textFieldRow($model,'preco',array('class'=>'input-small text-right','maxlength'=>14));
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

	$('#ProdutoEmbalagem_preco').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#ProdutoEmbalagem_quantidade').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });

	$('#produto-embalagem-form').submit(function(e) {
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
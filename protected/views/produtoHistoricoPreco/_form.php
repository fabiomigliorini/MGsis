<?php $form=$this->beginWidget('MGActiveForm',array(
	'id'=>'produto-historico-preco-form',
)); ?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
	<?php 	
		echo $form->textFieldRow($model,'codproduto',array('class'=>'span5'));
		echo $form->textFieldRow($model,'codprodutoembalagem',array('class'=>'span5'));
		echo $form->textFieldRow($model,'codusuario',array('class'=>'span5'));
		echo $form->textFieldRow($model,'precoantigo',array('class'=>'span5','maxlength'=>14));
		echo $form->textFieldRow($model,'preconovo',array('class'=>'span5','maxlength'=>14));
		echo $form->textFieldRow($model,'data',array('class'=>'span5'));
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

	$('#produto-historico-preco-form').submit(function(e) {
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
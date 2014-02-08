<?php $form=$this->beginWidget('MGActiveForm',array(
	'id'=>'produto-form',
)); ?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
	<?php 	
		echo $form->textFieldRow($model,'produto',array('class'=>'span5','maxlength'=>100));
		echo $form->textFieldRow($model,'referencia',array('class'=>'span5','maxlength'=>50));
		echo $form->textFieldRow($model,'codunidademedida',array('class'=>'span5'));
		echo $form->textFieldRow($model,'codsubgrupoproduto',array('class'=>'span5'));
		echo $form->textFieldRow($model,'codmarca',array('class'=>'span5'));
		echo $form->textFieldRow($model,'preco',array('class'=>'span5','maxlength'=>14));
		echo $form->checkBoxRow($model,'importado');
		echo $form->textFieldRow($model,'ncm',array('class'=>'span5'));
		echo $form->textFieldRow($model,'codtributacao',array('class'=>'span5'));
		echo $form->textFieldRow($model,'inativo',array('class'=>'span5'));
		echo $form->textFieldRow($model,'codtipoproduto',array('class'=>'span5'));
		echo $form->checkBoxRow($model,'site');
		echo $form->textFieldRow($model,'descricaosite',array('class'=>'span5','maxlength'=>1024));
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

	$('#produto-form').submit(function(e) {
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
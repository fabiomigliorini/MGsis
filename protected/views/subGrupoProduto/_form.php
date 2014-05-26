<?php $form=$this->beginWidget('MGActiveForm',array(
	'id'=>'sub-grupo-produto-form',
)); ?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
	<?php 	
		//echo $form->textFieldRow($model,'codgrupoproduto',array('class'=>'span5'));
		echo $form->select2Row($model, 'codgrupoproduto', GrupoProduto::getListaCombo(), array('prompt' => '', 'class' => 'input-xlarge'));
		echo $form->textFieldRow($model,'subgrupoproduto',array('class'=>'input-xlarge','maxlength'=>50));
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

	$("#SubGrupoProduto_subgrupoproduto").Setcase();

	$('#sub-grupo-produto-form').submit(function(e) {
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
<?php $form=$this->beginWidget('MGActiveForm',array(
	'id'=>'marca-form',
)); ?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
	<?php 	
		echo $form->textFieldRow($model,'marca',array('class'=>'span5','maxlength'=>50));
		echo $form->checkBoxRow($model,'site');
//		echo $form->textFieldRow($model,'descricaosite',array('class'=>'span5','maxlength'=>1024));
		echo $form->textAreaRow($model,'descricaosite',array('class'=>'span5','maxlength'=>1024,'rows'=>5));
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

	$('#marca-form').submit(function(e) {
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
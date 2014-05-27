<?php $form=$this->beginWidget('MGActiveForm',array(
	'id'=>'unidade-medida-form',
)); ?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
	<?php 	
		echo $form->textFieldRow($model,'unidademedida',array('class'=>'input-medium','maxlength'=>15));
		echo $form->textFieldRow($model,'sigla',array('class'=>'input-mini','maxlength'=>3));
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

	$("#UnidadeMedida_unidademedida").Setcase();

	$('#unidade-medida-form').submit(function(e) {
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
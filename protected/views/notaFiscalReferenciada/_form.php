<?php $form=$this->beginWidget('MGActiveForm',array(
	'id'=>'nota-fiscal-referenciada-form',
)); ?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
	<?php 	
		echo $form->textFieldRow($model,'nfechave',array('class'=>'span5','maxlength'=>100));
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

	$('#NotaFiscalReferenciada_nfechave').change(function(e){ 
		$(this).val($(this).val().replace(/\s+/g, ''));
	});

	$('#nota-fiscal-referenciada-form').submit(function(e) {
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
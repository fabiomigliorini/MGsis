<?php $form=$this->beginWidget('MGActiveForm',array(
	'id'=>'empresa-form',
)); ?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
	<?php 	
		echo $form->textFieldRow($model,'empresa',array('class'=>'medum','maxlength'=>50));
		echo $form->select2Row($model,'modoemissaonfce', Empresa::getModoEmissaoNFCeListaCombo() , array('class'=>'input-large'));
		echo $form->datetimepickerRow($model, 'contingenciadata',
				array(
					'class' => 'input-medium text-center', 
					'options' => array(
						'format' => 'dd/mm/yyyy hh:ii:ss',
					),
				)
			);

		echo $form->textAreaRow($model,'contingenciajustificativa',array('class'=>'input-xxlarge', 'rows'=>'6','maxlength'=>500, 'tabindex'=>-1));
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

	$("#Empresa_empresa").Setcase();

	$('#empresa-form').submit(function(e) {
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
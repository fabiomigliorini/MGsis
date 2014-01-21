<?php
/*
<?php echo $form->errorSummary($model); ?>

<fieldset>
	<?php 	
		echo $form->datePickerRow($model,'emissao',
			array(
				'class' => 'input-small text-center', 
				'options' => array(
					'language' => 'pt',
					'format' => 'dd/mm/yyyy'
				),
				'prepend' => '<i class="icon-calendar"></i>',
			)
			
		);
		//echo $form->textFieldRow($model,'cancelamento',array('class'=>'span5'));
		echo $form->textAreaRow($model,'observacao',array('class'=>'span5','maxlength'=>200, 'rows'=>3));
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
	<?php
        $this->widget(
            'bootstrap.widgets.TbButton',
            array(
                'buttonType' => 'reset',
                'label' => 'Limpar',
                'icon' => 'icon-refresh'
                )
            );
    ?>
    
</div>


<script type='text/javascript'>
	
$(document).ready(function() {

	//$("#Pessoa_fantasia").Setcase();

	$('#titulo-agrupamento-form').submit(function(e) {
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
 * 
 */
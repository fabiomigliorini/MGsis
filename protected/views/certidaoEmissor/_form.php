<?php $form=$this->beginWidget('MGActiveForm',array(
	'id'=>'certidao-emissor-form',
)); ?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
	<?php
		echo $form->textFieldRow($model,'certidaoemissor',array('class'=>'span5','maxlength'=>30));
		echo $form->datetimepickerRow(
				$model,
				'inativo',
				array(
					'class' => 'input-medium text-center',
					'options' => array(
						'language' => 'pt',
						'format' => 'dd/mm/yyyy hh:ii:ss',
						),
					//'prepend' => '<i class="icon-calendar"></i>',
					)
				);

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

	$("#CertidaoEmissor_certidaoemissor").Setcase();

	$('#certidao-emissor-form').submit(function(e) {
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

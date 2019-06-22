<?php $form=$this->beginWidget('MGActiveForm', array(
    'id'=>'pessoa-certidao-form',
    'enableAjaxValidation'=>true,
)); ?>


<?php echo $form->errorSummary($model); ?>
<fieldset>
	<?php
        echo $form->textFieldRow($model, 'numero', array('class'=>'input-large','maxlength'=>20, 'autofocus'=>true));
        echo $form->textFieldRow($model, 'autenticacao', array('class'=>'input-large','maxlength'=>20));
        echo $form->datepickerRow(
                $model,
                'validade',
                array(
                    'class' => 'input-small text-center',
                    'options' => array(
                        'language' => 'pt',
                        'format' => 'dd/mm/yyyy'
                        ),
                    'prepend' => '<i class="icon-calendar"></i>',
                    )
                );


			echo $form->select2Row($model, 'codcertidaotipo', CertidaoTipo::getListaCombo(), array('class'=>'input-xlarge'));
      echo $form->select2Row($model, 'codcertidaoemissor', CertidaoEmissor::getListaCombo(), array('class'=>'input-medium'));

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

	//$("#Pessoa_fantasia").Setcase();

	$('#pessoa-certidao-form').submit(function(e) {
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

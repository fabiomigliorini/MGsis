<?php $form=$this->beginWidget('MGActiveForm',array(
	'id'=>'natureza-operacao-form',
)); ?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
	<?php
		echo $form->textFieldRow($model,'naturezaoperacao',array('class'=>'medum','maxlength'=>50));
		echo $form->select2Row($model, 'codoperacao', Operacao::getListaCombo(), array('class' => 'input-medium'));
		//echo $form->checkBoxRow($model,'emitida');
		echo $form->toggleButtonRow($model,'emitida', array('options' => array('enabledLabel' => 'Sim', 'disabledLabel' => 'Não')));
		//echo $form->textFieldRow($model,'observacoesnf',array('class'=>'span5','maxlength'=>500));
		echo $form->select2Row($model, 'codtipotitulo', TipoTitulo::getListaCombo(), array('class' => 'input-xlarge'));
		echo $form->select2Row($model, 'codcontacontabil', ContaContabil::getListaCombo(), array('class' => 'input-xlarge'));
		echo $form->select2Row($model, 'codestoquemovimentotipo', EstoqueMovimentoTipo::getListaCombo(), array('class' => 'input-xlarge'));
		echo $form->textAreaRow($model,'observacoesnf',array('class'=>'input-xlarge', 'rows'=>'5','maxlength'=>500));
		echo $form->textAreaRow($model,'mensagemprocom',array('class'=>'input-xlarge', 'rows'=>'5','maxlength'=>300));
		echo $form->select2Row($model, 'codnaturezaoperacaodevolucao', NaturezaOperacao::getListaCombo(), array('class' => 'input-xxlarge'));
		echo $form->select2Row($model, 'finnfe', NaturezaOperacao::getFinNfeListaCombo(), array('class' => 'input-large'));
		echo $form->toggleButtonRow($model,'ibpt', array('options' => array('width' => 150,  'enabledLabel' => 'Sim', 'disabledLabel' => 'Não')));
		echo $form->toggleButtonRow($model,'estoque', array('options' => array('width' => 150,  'enabledLabel' => 'Sim', 'disabledLabel' => 'Não')));
		echo $form->toggleButtonRow($model,'financeiro', array('options' => array('width' => 150,  'enabledLabel' => 'Sim', 'disabledLabel' => 'Não')));
		echo $form->toggleButtonRow($model,'compra', array('options' => array('width' => 150,  'enabledLabel' => 'Sim', 'disabledLabel' => 'Não')));
		echo $form->toggleButtonRow($model,'venda', array('options' => array('width' => 150,  'enabledLabel' => 'Sim', 'disabledLabel' => 'Não')));
		echo $form->toggleButtonRow($model,'vendadevolucao', array('options' => array('width' => 150,  'enabledLabel' => 'Sim', 'disabledLabel' => 'Não')));
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

	$("#NaturezaOperacao_naturezaoperacao").Setcase();

	$('#natureza-operacao-form').submit(function(e) {
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

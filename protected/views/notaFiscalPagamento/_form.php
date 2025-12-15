<?php $form = $this->beginWidget('MGActiveForm', array(
    'id' => 'nota-fiscal-pagamento-form',
    'enableAjaxValidation' => false,
)); ?>

<?php echo $form->errorSummary($model); ?>

<?php
// echo $form->textFieldRow($model,'codnotafiscal',array('class'=>'span5'));
echo $form->toggleButtonRow($model, 'avista', array('options' => array('enabledLabel' => 'Vista', 'disabledLabel' => 'Prazo')));

echo $form->select2Row($model, 'tipo', NotaFiscalPagamento::TIPO, array('class' => 'input-xlarge'));

echo $form->select2Row($model, 'bandeira', NotaFiscalPagamento::BANDEIRA, array('class' => 'input-large'));

echo $form->toggleButtonRow($model, 'integracao', array('options' => array('enabledLabel' => 'Integrado', 'disabledLabel' => 'Manual')));

echo $form->select2PessoaRow($model, 'codpessoa', array('class' => 'input-xxlarge'));

echo $form->textFieldRow($model, 'autorizacao', array('class' => 'input-xlarge text-left', 'maxlength' => 40));

echo $form->textFieldRow($model, 'valorpagamento', array('class' => 'input-small text-right', 'maxlength' => 14));

echo $form->textFieldRow($model, 'troco', array('class' => 'input-small text-right', 'maxlength' => 14));

?>

<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => 'Salvar',
    )); ?>
</div>

<script type='text/javascript'>
    $(document).ready(function() {
        $('#NotaFiscalPagamento_valorpagamento').autoNumeric('init', {
            aSep: '.',
            aDec: ',',
            altDec: '.'
        });

        $('#NotaFiscalPagamento_troco').autoNumeric('init', {
            aSep: '.',
            aDec: ',',
            altDec: '.'
        });

        $('#nota-fiscal-pagamento-form').submit(function(e) {
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
<?php $this->endWidget(); ?>
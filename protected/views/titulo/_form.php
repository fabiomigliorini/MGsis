<?php
$form = $this->beginWidget('MGActiveForm', array(
    'id' => 'titulo-form',
));
?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
    <div class="row">
        <div class="span6">


            <?php

            // codfilial
            $op = array('prompt' => '', 'class' => 'input-medium');
            if ($model->gerado_automaticamente)
                $op = array_merge($op, array("readOnly" => true));
            echo $form->select2Row($model, 'codfilial', Filial::getListaCombo(), $op);

            // codpessoa
            echo $form->select2PessoaRow(
                $model,
                'codpessoa',
                array('class' => 'span4')
            );

            // numero
            $op = array('class' => 'input-medium', 'maxlength' => 20);
            if ($model->gerado_automaticamente) {
                $op = array_merge($op, array("readOnly" => true));
            }
            echo $form->textFieldRow($model, 'numero', $op);

            // fatura
            echo $form->textFieldRow($model, 'fatura', array('class' => 'input-medium', 'maxlength' => 50));


            // codtipotitulo
            $op = array('prompt' => '', 'class' => 'input-large');
            if (!empty($model->codnegocioformapagamento))
                $op = array_merge($op, array("readOnly" => true));
            echo $form->select2Row($model, 'codtipotitulo', TipoTitulo::getListaCombo(), $op);

            //valor
            $operacao = "??";
            if (!empty($model->codtipotitulo))
                if (isset($model->TipoTitulo))
                    $operacao = ($model->TipoTitulo->credito) ? "CR" : "DB";
            $op = array('prepend' => 'R$', 'append' => $operacao, 'appendOptions' => array('id' => 'operacao'), 'class' => 'input-small text-right', 'maxlength' => 14);
            if (($model->saldo == 0 and !$model->isNewRecord) || $model->gerado_automaticamente)
                $op = array_merge($op, array("readOnly" => true));
            echo $form->textFieldRow($model, 'valor', $op);

            $opCodportador = [
                'prompt' => '',
                'class' => 'input-large',
            ];
            $opBoleto = [
                'options' => [
                    'enabledLabel' => 'Sim',
                    'disabledLabel' => 'Não',
                ]
            ];
            if (!empty($model->codportador)) {
                if ($model->Portador->codbanco == 1 && !empty($model->nossonumero)) {
                    $opCodportador['readOnly'] = true;
                    $opBoleto['readOnly'] = true;
                }
            }

            if (!isset($opCodportador['readOnly'])) {
                // codportador
                echo $form->select2Row(
                    $model,
                    'codportador',
                    Portador::getListaCombo(),
                    $opCodportador
                );

                // boleto
                echo $form->toggleButtonRow(
                    $model,
                    'boleto',
                    $opBoleto
                );
            }


            ?>
        </div>
        <div class="span6">
            <?php
            // vencimento
            $op =
                array(
                    'class' => 'input-small text-center',
                    'options' => array(
                        'language' => 'pt',
                        'format' => 'dd/mm/yyyy'
                    ),
                    'prepend' => '<i class="icon-calendar"></i>',
                );
            if ($model->saldo == 0 and !$model->isNewRecord)
                $op = array_merge($op, array("readOnly" => true));
            echo $form->datepickerRow($model, 'vencimento', $op);

            // vencimento original
            $op =
                array(
                    'class' => 'input-small text-center',
                    'options' => array(
                        'language' => 'pt',
                        'format' => 'dd/mm/yyyy'
                    ),
                    'prepend' => '<i class="icon-calendar"></i>',
                );
            if ($model->gerado_automaticamente || ($model->saldo == 0 and !$model->isNewRecord))
                $op = array_merge($op, array("readOnly" => true));
            echo $form->datepickerRow($model, 'vencimentooriginal', $op);

            // emissao
            $op = array(
                'class' => 'input-small  text-center',
                'options' => array(
                    'language' => 'pt',
                    'format' => 'dd/mm/yyyy'
                ),
                'prepend' => '<i class="icon-calendar"></i>',
            );
            if ($model->gerado_automaticamente || ($model->saldo == 0 and !$model->isNewRecord))
                $op = array_merge($op, array("readOnly" => true));
            echo $form->datepickerRow($model, 'emissao', $op);

            // transacao
            $op =
                array(
                    'class' => 'input-small text-center',
                    'options' => array(
                        'language' => 'pt',
                        'format' => 'dd/mm/yyyy'
                    ),
                    'prepend' => '<i class="icon-calendar"></i>',
                );
            if ($model->gerado_automaticamente || ($model->saldo == 0 and !$model->isNewRecord))
                $op = array_merge($op, array("readOnly" => true));
            echo $form->datepickerRow($model, 'transacao', $op);

            // gerencial
            echo $form->toggleButtonRow($model, 'gerencial', array('options' => array('enabledLabel' => 'Sim', 'disabledLabel' => 'Não')));

            // codcontacontabil
            echo $form->select2Row($model, 'codcontacontabil', ContaContabil::getListaCombo(), array('prompt' => '', 'class' => 'input-xxlarge'));

            // observacao
            echo $form->textAreaRow($model, 'observacao', array('class' => 'input-xxlarge', 'rows' => '5', 'maxlength' => 500));

            ?>


        </div>
    </div>

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

        $('#Titulo_valor').autoNumeric('init', {
            aSep: '.',
            aDec: ',',
            altDec: '.'
        });

        $('#titulo-form').submit(function(e) {
            var currentForm = this;
            e.preventDefault();
            bootbox.confirm("Tem certeza que deseja salvar?", function(result) {
                if (result) {
                    currentForm.submit();
                }
            });
        });

    });

    $('#Titulo_codtipotitulo').change(function() {
        if ($('#Titulo_codtipotitulo').val() != 0) {
            $.ajax({
                url: "<?php echo Yii::app()->createUrl('titulo/buscaoperacaotipotitulo') ?>&codtipotitulo=" + $('#Titulo_codtipotitulo').val(),
                dataType: "text",
                success: function(data) {
                    var retorno = $.parseJSON(data);
                    $('#operacao').text(retorno.operacao);
                }
            });
        } else
            $('#operacao').text("??");

    });

    altera_vencimentooriginal = <?php echo ($model->vencimento == $model->vencimentooriginal && $model->isNewRecord) ? "true" : "false"; ?>;
    altera_transacao = <?php echo ($model->emissao == $model->transacao && $model->isNewRecord) ? "true" : "false"; ?>;

    $('#Titulo_vencimento').change(function() {
        if (altera_vencimentooriginal)
            $('#Titulo_vencimentooriginal').val($('#Titulo_vencimento').val());
    });

    $('#Titulo_emissao').change(function() {
        if (altera_transacao)
            $('#Titulo_transacao').val($('#Titulo_emissao').val());
    });
</script>
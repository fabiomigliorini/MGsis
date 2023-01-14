<?php $form=$this->beginWidget('MGActiveForm', array(
    'id'=>'nfe-terceiro-form',
)); ?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
<div class="row">
    <div class="span6">
        <?php
            //echo $form->textFieldRow($model,'nsu',array('class'=>'span5','maxlength'=>20));
            //echo $form->textFieldRow($model,'nfechave',array('class'=>'span5','maxlength'=>100));
            //echo $form->textFieldRow($model,'cnpj',array('class'=>'span5','maxlength'=>14));
            //echo $form->textFieldRow($model,'ie',array('class'=>'span5','maxlength'=>20));
            //echo $form->textFieldRow($model,'emitente',array('class'=>'span5','maxlength'=>100));
            //echo $form->textFieldRow($model,'codpessoa',array('class'=>'span5'));
            //echo $form->textFieldRow($model,'emissao',array('class'=>'span5'));
            //echo $form->textFieldRow($model,'nfedataautorizacao',array('class'=>'span5'));
            //echo $form->textFieldRow($model,'codoperacao',array('class'=>'span5'));
            //echo $form->textFieldRow($model,'valortotal',array('class'=>'span5','maxlength'=>14));
            echo $form->select2Row($model, 'codfilial', Filial::getListaCombo(), array('class'=>'input-medium'));
            echo $form->select2PessoaRow($model, 'codpessoa', array('class'=>'input-xlarge'));
            echo $form->textFieldRow($model,'natureza',array('class'=>'span5','maxlength'=>14, 'disabled'=>true));
            echo $form->select2Row($model, 'codnaturezaoperacao', NaturezaOperacao::getListaCombo(), array('class'=>'input-xlarge'));

            echo $form->datetimepickerRow(
                $model,
                'entrada',
                [
                        'class' => 'input-medium text-center',
                        'options' => [
                            'language' => 'pt',
                            'format' => 'dd/mm/yyyy hh:ii:ss',
                        ],
                        'prepend' => '<i class="icon-calendar"></i>',
                        'append' => '<i class="icon-repeat" style="cursor: pointer;" id="btnCopiarEmissao"></i>',
                ]
            );
            //echo $form->textFieldRow($model,'indmanifestacao',array('class'=>'span5'));
        ?>
    </div>
    <div class="span6">
        <?php
        echo $form->select2Row($model, 'indsituacao', NfeTerceiro::getIndSituacaoListaCombo(), array('class'=>'input-medium'));
        echo $form->toggleButtonRow($model, 'ignorada', array('options' => array('width' => 150,  'enabledLabel' => 'Ignorada', 'disabledLabel' => 'Não')));
        echo $form->textAreaRow($model, 'observacoes', array('class'=>'span6', 'rows'=>'6','maxlength'=>500, 'tabindex'=>-1));
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

	//$("#Pessoa_fantasia").Setcase();
    $('#btnCopiarEmissao').click(function(e) {
        e.preventDefault();
        $('#NfeTerceiro_entrada').val('<?php echo $model->emissao; ?>');
    });

	$('#nfe-terceiro-form').submit(function(e) {
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

<?php $form=$this->beginWidget('MGActiveForm', array(
    'id'=>'nfe-terceiro-form',
)); ?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
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
        echo $form->select2Row($model, 'indsituacao', NfeTerceiro::getIndSituacaoListaCombo(), array('class'=>'input-medium'));
        echo $form->select2Row($model, 'codnaturezaoperacao', NaturezaOperacao::getListaCombo(), array('class'=>'input-xlarge'));
        echo $form->toggleButtonRow($model, 'ignorada', array('options' => array('width' => 150,  'enabledLabel' => 'Ignorada', 'disabledLabel' => 'Não')));

        echo $form->datetimepickerRow(
            $model,
            'entrada',
            array(
                    'class' => 'input-medium text-center',
                    'options' => array(
                        'language' => 'pt',
                        'format' => 'dd/mm/yyyy hh:ii:ss',
                        ),
                    'prepend' => '<i class="icon-calendar"></i>',
                    )
        );

        //echo $form->textFieldRow($model,'indmanifestacao',array('class'=>'span5'));
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

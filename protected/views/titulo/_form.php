<?php $form=$this->beginWidget('MGActiveForm',array(
	'id'=>'titulo-form',
)); ?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
	<?php 	
		echo $form->textFieldRow($model,'codtipotitulo',array('class'=>'span5'));
		echo $form->textFieldRow($model,'codfilial',array('class'=>'span5'));
		echo $form->textFieldRow($model,'codportador',array('class'=>'span5'));
		echo $form->textFieldRow($model,'codpessoa',array('class'=>'span5'));
		echo $form->textFieldRow($model,'codcontacontabil',array('class'=>'span5'));
		echo $form->textFieldRow($model,'numero',array('class'=>'span5','maxlength'=>20));
		echo $form->textFieldRow($model,'fatura',array('class'=>'span5','maxlength'=>50));
		echo $form->textFieldRow($model,'transacao',array('class'=>'span5'));
		echo $form->textFieldRow($model,'sistema',array('class'=>'span5'));
		echo $form->textFieldRow($model,'emissao',array('class'=>'span5'));
		echo $form->textFieldRow($model,'vencimento',array('class'=>'span5'));
		echo $form->textFieldRow($model,'vencimentooriginal',array('class'=>'span5'));
		echo $form->textFieldRow($model,'debito',array('class'=>'span5','maxlength'=>14));
		echo $form->textFieldRow($model,'credito',array('class'=>'span5','maxlength'=>14));
		echo $form->checkBoxRow($model,'gerencial');
		echo $form->textFieldRow($model,'observacao',array('class'=>'span5','maxlength'=>255));
		echo $form->checkBoxRow($model,'boleto');
		echo $form->textFieldRow($model,'nossonumero',array('class'=>'span5','maxlength'=>20));
		echo $form->textFieldRow($model,'debitototal',array('class'=>'span5','maxlength'=>14));
		echo $form->textFieldRow($model,'creditototal',array('class'=>'span5','maxlength'=>14));
		echo $form->textFieldRow($model,'saldo',array('class'=>'span5','maxlength'=>14));
		echo $form->textFieldRow($model,'debitosaldo',array('class'=>'span5','maxlength'=>14));
		echo $form->textFieldRow($model,'creditosaldo',array('class'=>'span5','maxlength'=>14));
		echo $form->textFieldRow($model,'transacaoliquidacao',array('class'=>'span5'));
		echo $form->textFieldRow($model,'codnegocioformapagamento',array('class'=>'span5'));
		echo $form->textFieldRow($model,'codtituloagrupamento',array('class'=>'span5'));
		echo $form->textFieldRow($model,'remessa',array('class'=>'span5'));
		echo $form->textFieldRow($model,'estornado',array('class'=>'span5'));
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

<?php $this->endWidget(); ?>

<script type='text/javascript'>
	
$(document).ready(function() {

	//$("#Pessoa_fantasia").Setcase();

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

</script>
<?php $form=$this->beginWidget('MGActiveForm',array(
	'id'=>'pessoa-form',
)); ?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
	<?php 	
		echo $form->textFieldRow($model,'pessoa',array('class'=>'span5','maxlength'=>100));
		echo $form->textFieldRow($model,'fantasia',array('class'=>'span5','maxlength'=>50));
		echo $form->textFieldRow($model,'cadastro',array('class'=>'span5'));
		echo $form->textFieldRow($model,'inativo',array('class'=>'span5'));
		echo $form->checkBoxRow($model,'cliente');
		echo $form->checkBoxRow($model,'fornecedor');
		echo $form->checkBoxRow($model,'fisica');
		echo $form->textFieldRow($model,'codsexo',array('class'=>'span5'));
		echo $form->textFieldRow($model,'cnpj',array('class'=>'span5','maxlength'=>14));
		echo $form->textFieldRow($model,'ie',array('class'=>'span5','maxlength'=>20));
		echo $form->checkBoxRow($model,'consumidor');
		echo $form->textFieldRow($model,'contato',array('class'=>'span5','maxlength'=>100));
		echo $form->textFieldRow($model,'codestadocivil',array('class'=>'span5'));
		echo $form->textFieldRow($model,'conjuge',array('class'=>'span5','maxlength'=>100));
		echo $form->textFieldRow($model,'endereco',array('class'=>'span5','maxlength'=>100));
		echo $form->textFieldRow($model,'numero',array('class'=>'span5','maxlength'=>10));
		echo $form->textFieldRow($model,'complemento',array('class'=>'span5','maxlength'=>50));
		echo $form->textFieldRow($model,'codcidade',array('class'=>'span5'));
		echo $form->textFieldRow($model,'bairro',array('class'=>'span5','maxlength'=>50));
		echo $form->textFieldRow($model,'cep',array('class'=>'span5','maxlength'=>8));
		echo $form->textFieldRow($model,'enderecocobranca',array('class'=>'span5','maxlength'=>100));
		echo $form->textFieldRow($model,'numerocobranca',array('class'=>'span5','maxlength'=>10));
		echo $form->textFieldRow($model,'complementocobranca',array('class'=>'span5','maxlength'=>50));
		echo $form->textFieldRow($model,'codcidadecobranca',array('class'=>'span5'));
		echo $form->textFieldRow($model,'bairrocobranca',array('class'=>'span5','maxlength'=>50));
		echo $form->textFieldRow($model,'cepcobranca',array('class'=>'span5','maxlength'=>8));
		echo $form->textFieldRow($model,'telefone1',array('class'=>'span5','maxlength'=>50));
		echo $form->textFieldRow($model,'telefone2',array('class'=>'span5','maxlength'=>50));
		echo $form->textFieldRow($model,'telefone3',array('class'=>'span5','maxlength'=>50));
		echo $form->textFieldRow($model,'email',array('class'=>'span5','maxlength'=>100));
		echo $form->textFieldRow($model,'emailnfe',array('class'=>'span5','maxlength'=>100));
		echo $form->textFieldRow($model,'emailcobranca',array('class'=>'span5','maxlength'=>100));
		echo $form->textFieldRow($model,'codformapagamento',array('class'=>'span5'));
		echo $form->textFieldRow($model,'credito',array('class'=>'span5','maxlength'=>14));
		echo $form->checkBoxRow($model,'creditobloqueado');
		echo $form->textFieldRow($model,'observacoes',array('class'=>'span5','maxlength'=>255));
		echo $form->textFieldRow($model,'mensagemvenda',array('class'=>'span5','maxlength'=>500));
		echo $form->checkBoxRow($model,'vendedor');
		echo $form->textFieldRow($model,'rg',array('class'=>'span5','maxlength'=>30));
		echo $form->textFieldRow($model,'desconto',array('class'=>'span5','maxlength'=>4));
		echo $form->textFieldRow($model,'notafiscal',array('class'=>'span5'));
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

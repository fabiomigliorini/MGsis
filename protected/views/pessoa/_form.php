<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'pessoa-form',
	'type' => 'horizontal',
	'enableAjaxValidation'=>true,
)); ?>

<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'pessoa',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'fantasia',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'cadastro',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'inativo',array('class'=>'span5')); ?>

	<?php echo $form->checkBoxRow($model,'cliente'); ?>

	<?php echo $form->checkBoxRow($model,'fornecedor'); ?>

	<?php echo $form->checkBoxRow($model,'fisica'); ?>

	<?php echo $form->textFieldRow($model,'codsexo',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'cnpj',array('class'=>'span5','maxlength'=>14)); ?>

	<?php echo $form->textFieldRow($model,'ie',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->checkBoxRow($model,'consumidor'); ?>

	<?php echo $form->textFieldRow($model,'contato',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'codestadocivil',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'conjuge',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'endereco',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'numero',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'complemento',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'codcidade',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'bairro',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'cep',array('class'=>'span5','maxlength'=>8)); ?>

	<?php echo $form->textFieldRow($model,'enderecocobranca',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'numerocobranca',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'complementocobranca',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'codcidadecobranca',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'bairrocobranca',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'cepcobranca',array('class'=>'span5','maxlength'=>8)); ?>

	<?php echo $form->textFieldRow($model,'telefone1',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'telefone2',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'telefone3',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'email',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'emailnfe',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'emailcobranca',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'codformapagamento',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'credito',array('class'=>'span5','maxlength'=>14)); ?>

	<?php echo $form->checkBoxRow($model,'creditobloqueado'); ?>

	<?php echo $form->textFieldRow($model,'observacoes',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'mensagemvenda',array('class'=>'span5','maxlength'=>500)); ?>

	<?php echo $form->checkBoxRow($model,'vendedor'); ?>

	<?php echo $form->textFieldRow($model,'rg',array('class'=>'span5','maxlength'=>30)); ?>

	<?php echo $form->textFieldRow($model,'desconto',array('class'=>'span5','maxlength'=>4)); ?>

	<?php echo $form->textFieldRow($model,'notafiscal',array('class'=>'span5')); ?>

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

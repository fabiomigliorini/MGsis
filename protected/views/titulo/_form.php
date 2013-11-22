<?php
/* @var $this TituloController */
/* @var $model Titulo */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'titulo-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'codtipotitulo'); ?>
		<?php echo $form->textField($model,'codtipotitulo'); ?>
		<?php echo $form->error($model,'codtipotitulo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'codfilial'); ?>
		<?php echo $form->textField($model,'codfilial'); ?>
		<?php echo $form->error($model,'codfilial'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'codportador'); ?>
		<?php echo $form->textField($model,'codportador'); ?>
		<?php echo $form->error($model,'codportador'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'codpessoa'); ?>
		<?php echo $form->textField($model,'codpessoa'); ?>
		<?php echo $form->error($model,'codpessoa'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'codcontacontabil'); ?>
		<?php echo $form->textField($model,'codcontacontabil'); ?>
		<?php echo $form->error($model,'codcontacontabil'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'numero'); ?>
		<?php echo $form->textField($model,'numero',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'numero'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fatura'); ?>
		<?php echo $form->textField($model,'fatura',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'fatura'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'transacao'); ?>
		<?php echo $form->textField($model,'transacao'); ?>
		<?php echo $form->error($model,'transacao'); ?>
	</div>
	<?
	print_r($model->sistema);
	?>

	<div class="row">
		<?php echo $form->labelEx($model,'sistema'); ?>
		<?php echo $form->textField($model,'sistema'); ?>
		<?php echo $form->error($model,'sistema'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'emissao'); ?>
		<?php echo $form->textField($model,'emissao'); ?>
		<?php echo $form->error($model,'emissao'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'vencimento'); ?>
		<?php echo $form->textField($model,'vencimento'); ?>
		<?php echo $form->error($model,'vencimento'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'vencimentooriginal'); ?>
		<?php echo $form->textField($model,'vencimentooriginal'); ?>
		<?php echo $form->error($model,'vencimentooriginal'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'debito'); ?>
		<?php echo $form->textField($model,'debito',array('size'=>14,'maxlength'=>14)); ?>
		<?php echo $form->error($model,'debito'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'credito'); ?>
		<?php echo $form->textField($model,'credito',array('size'=>14,'maxlength'=>14)); ?>
		<?php echo $form->error($model,'credito'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'gerencial'); ?>
		<?php echo $form->checkBox($model,'gerencial'); ?>
		<?php echo $form->error($model,'gerencial'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'observacao'); ?>
		<?php echo $form->textField($model,'observacao',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'observacao'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'boleto'); ?>
		<?php echo $form->checkBox($model,'boleto'); ?>
		<?php echo $form->error($model,'boleto'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nossonumero'); ?>
		<?php echo $form->textField($model,'nossonumero',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'nossonumero'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'debitototal'); ?>
		<?php echo $form->textField($model,'debitototal',array('size'=>14,'maxlength'=>14)); ?>
		<?php echo $form->error($model,'debitototal'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'creditototal'); ?>
		<?php echo $form->textField($model,'creditototal',array('size'=>14,'maxlength'=>14)); ?>
		<?php echo $form->error($model,'creditototal'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'saldo'); ?>
		<?php echo $form->textField($model,'saldo',array('size'=>14,'maxlength'=>14)); ?>
		<?php echo $form->error($model,'saldo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'debitosaldo'); ?>
		<?php echo $form->textField($model,'debitosaldo',array('size'=>14,'maxlength'=>14)); ?>
		<?php echo $form->error($model,'debitosaldo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'creditosaldo'); ?>
		<?php echo $form->textField($model,'creditosaldo',array('size'=>14,'maxlength'=>14)); ?>
		<?php echo $form->error($model,'creditosaldo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'transacaoliquidacao'); ?>
		<?php echo $form->textField($model,'transacaoliquidacao'); ?>
		<?php echo $form->error($model,'transacaoliquidacao'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'codnegocioformapagamento'); ?>
		<?php echo $form->textField($model,'codnegocioformapagamento'); ?>
		<?php echo $form->error($model,'codnegocioformapagamento'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'codtituloagrupamento'); ?>
		<?php echo $form->textField($model,'codtituloagrupamento'); ?>
		<?php echo $form->error($model,'codtituloagrupamento'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'remessa'); ?>
		<?php echo $form->textField($model,'remessa'); ?>
		<?php echo $form->error($model,'remessa'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'estornado'); ?>
		<?php echo $form->textField($model,'estornado'); ?>
		<?php echo $form->error($model,'estornado'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Salvar Novo' : 'Salvar Alterações'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

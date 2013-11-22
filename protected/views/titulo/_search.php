<?php
/* @var $this TituloController */
/* @var $model Titulo */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'codtitulo'); ?>
		<?php echo $form->textField($model,'codtitulo'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'codtipotitulo'); ?>
		<?php echo $form->textField($model,'codtipotitulo'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'codfilial'); ?>
		<?php echo $form->textField($model,'codfilial'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'codportador'); ?>
		<?php echo $form->textField($model,'codportador'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'codpessoa'); ?>
		<?php echo $form->textField($model,'codpessoa'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'codcontacontabil'); ?>
		<?php echo $form->textField($model,'codcontacontabil'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'numero'); ?>
		<?php echo $form->textField($model,'numero',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fatura'); ?>
		<?php echo $form->textField($model,'fatura',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'transacao'); ?>
		<?php echo $form->textField($model,'transacao'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sistema'); ?>
		<?php echo $form->textField($model,'sistema'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'emissao'); ?>
		<?php echo $form->textField($model,'emissao'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'vencimento'); ?>
		<?php echo $form->textField($model,'vencimento'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'vencimentooriginal'); ?>
		<?php echo $form->textField($model,'vencimentooriginal'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'debito'); ?>
		<?php echo $form->textField($model,'debito',array('size'=>14,'maxlength'=>14)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'credito'); ?>
		<?php echo $form->textField($model,'credito',array('size'=>14,'maxlength'=>14)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'gerencial'); ?>
		<?php echo $form->checkBox($model,'gerencial'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'observacao'); ?>
		<?php echo $form->textField($model,'observacao',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'boleto'); ?>
		<?php echo $form->checkBox($model,'boleto'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nossonumero'); ?>
		<?php echo $form->textField($model,'nossonumero',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'debitototal'); ?>
		<?php echo $form->textField($model,'debitototal',array('size'=>14,'maxlength'=>14)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'creditototal'); ?>
		<?php echo $form->textField($model,'creditototal',array('size'=>14,'maxlength'=>14)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'saldo'); ?>
		<?php echo $form->textField($model,'saldo',array('size'=>14,'maxlength'=>14)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'debitosaldo'); ?>
		<?php echo $form->textField($model,'debitosaldo',array('size'=>14,'maxlength'=>14)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'creditosaldo'); ?>
		<?php echo $form->textField($model,'creditosaldo',array('size'=>14,'maxlength'=>14)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'transacaoliquidacao'); ?>
		<?php echo $form->textField($model,'transacaoliquidacao'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'codnegocioformapagamento'); ?>
		<?php echo $form->textField($model,'codnegocioformapagamento'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'codtituloagrupamento'); ?>
		<?php echo $form->textField($model,'codtituloagrupamento'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'remessa'); ?>
		<?php echo $form->textField($model,'remessa'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'estornado'); ?>
		<?php echo $form->textField($model,'estornado'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'alteracao'); ?>
		<?php echo $form->textField($model,'alteracao'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'codusuarioalteracao'); ?>
		<?php echo $form->textField($model,'codusuarioalteracao'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'criacao'); ?>
		<?php echo $form->textField($model,'criacao'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'codusuariocriacao'); ?>
		<?php echo $form->textField($model,'codusuariocriacao'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
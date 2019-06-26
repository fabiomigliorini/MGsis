<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'type' => 'horizontal',
	'method'=>'get',
)); ?>

<hr>

		<?php echo $form->textFieldRow($model,'codtitulo',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'codtipotitulo',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'codfilial',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'codportador',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'codpessoa',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'codcontacontabil',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'numero',array('class'=>'span5','maxlength'=>20)); ?>

		<?php echo $form->textFieldRow($model,'fatura',array('class'=>'span5','maxlength'=>50)); ?>

		<?php echo $form->textFieldRow($model,'transacao',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'sistema',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'emissao',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'vencimento',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'vencimentooriginal',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'debito',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->textFieldRow($model,'credito',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->checkBoxRow($model,'gerencial'); ?>

		<?php echo $form->textFieldRow($model,'observacao',array('class'=>'span5','maxlength'=>255)); ?>

		<?php echo $form->checkBoxRow($model,'boleto'); ?>

		<?php echo $form->textFieldRow($model,'nossonumero',array('class'=>'span5','maxlength'=>20)); ?>

		<?php echo $form->textFieldRow($model,'debitototal',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->textFieldRow($model,'creditototal',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->textFieldRow($model,'saldo',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->textFieldRow($model,'debitosaldo',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->textFieldRow($model,'creditosaldo',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->textFieldRow($model,'transacaoliquidacao',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'codnegocioformapagamento',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'codtituloagrupamento',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'remessa',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'estornado',array('class'=>'span5')); ?>

					<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'icon'=>'icon-search',
			'label'=>'Buscar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

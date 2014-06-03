<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'type' => 'horizontal',
	'method'=>'get',
)); ?>

<hr>

		<?php echo $form->textFieldRow($model,'codformapagamento',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'formapagamento',array('class'=>'span5','maxlength'=>50)); ?>

		<?php echo $form->checkBoxRow($model,'boleto'); ?>

		<?php echo $form->checkBoxRow($model,'fechamento'); ?>

		<?php echo $form->checkBoxRow($model,'notafiscal'); ?>

		<?php echo $form->textFieldRow($model,'parcelas',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'diasentreparcelas',array('class'=>'span5')); ?>

		<?php echo $form->checkBoxRow($model,'avista'); ?>

		<?php echo $form->textFieldRow($model,'formapagamentoecf',array('class'=>'span5','maxlength'=>5)); ?>

		<?php echo $form->checkBoxRow($model,'entrega'); ?>

					<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'icon'=>'icon-search',
			'label'=>'Buscar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

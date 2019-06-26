<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'type' => 'horizontal',
	'method'=>'get',
)); ?>

<hr>

		<?php echo $form->textFieldRow($model,'codnotafiscalduplicatas',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'codnotafiscal',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'fatura',array('class'=>'span5','maxlength'=>20)); ?>

		<?php echo $form->textFieldRow($model,'vencimento',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'valor',array('class'=>'span5','maxlength'=>14)); ?>

					<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'icon'=>'icon-search',
			'label'=>'Buscar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

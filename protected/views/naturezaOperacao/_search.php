<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'type' => 'horizontal',
	'method'=>'get',
)); ?>

<hr>

		<?php echo $form->textFieldRow($model,'codnaturezaoperacao',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'naturezaoperacao',array('class'=>'span5','maxlength'=>50)); ?>

		<?php echo $form->textFieldRow($model,'codoperacao',array('class'=>'span5')); ?>

		<?php echo $form->checkBoxRow($model,'emitida'); ?>

		<?php echo $form->textFieldRow($model,'observacoesnf',array('class'=>'span5','maxlength'=>500)); ?>

					<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'icon'=>'icon-search',
			'label'=>'Buscar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

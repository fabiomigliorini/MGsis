<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'type' => 'horizontal',
	'method'=>'get',
)); ?>

<hr>

		<?php echo $form->textFieldRow($model,'codtipotitulo',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'tipotitulo',array('class'=>'span5','maxlength'=>20)); ?>

		<?php echo $form->checkBoxRow($model,'pagar'); ?>

		<?php echo $form->checkBoxRow($model,'receber'); ?>

		<?php echo $form->textFieldRow($model,'observacoes',array('class'=>'span5','maxlength'=>255)); ?>

		<?php echo $form->textFieldRow($model,'codtipomovimentotitulo',array('class'=>'span5')); ?>

		<?php echo $form->checkBoxRow($model,'debito'); ?>

		<?php echo $form->checkBoxRow($model,'credito'); ?>

					<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'icon'=>'icon-search',
			'label'=>'Buscar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

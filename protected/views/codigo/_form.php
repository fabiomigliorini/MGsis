<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'codigo-form',
	'enableAjaxValidation'=>false,
)); ?>

<p class="help-block">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'tabela',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'codproximo',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'alteracao',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'codusuarioalteracao',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'criacao',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'codusuariocriacao',array('class'=>'span5')); ?>

<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
</div>

<?php $this->endWidget(); ?>

<?php
/* @var $this CodigoController */
/* @var $model Codigo */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'codigo-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'tabela'); ?>
		<?php echo $form->textField($model,'tabela',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'tabela'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'codproximo'); ?>
		<?php echo $form->textField($model,'codproximo'); ?>
		<?php echo $form->error($model,'codproximo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'alteracao'); ?>
		<?php echo $form->textField($model,'alteracao'); ?>
		<?php echo $form->error($model,'alteracao'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'codusuarioalteracao'); ?>
		<?php echo $form->textField($model,'codusuarioalteracao'); ?>
		<?php echo $form->error($model,'codusuarioalteracao'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'criacao'); ?>
		<?php echo $form->textField($model,'criacao'); ?>
		<?php echo $form->error($model,'criacao'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'codusuariocriacao'); ?>
		<?php echo $form->textField($model,'codusuariocriacao'); ?>
		<?php echo $form->error($model,'codusuariocriacao'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
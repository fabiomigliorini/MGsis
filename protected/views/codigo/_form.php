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

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'codproximo'); ?>
		<?php echo $form->textField($model,'codproximo'); ?>
		<?php echo $form->error($model,'codproximo'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Salvar Novo' : 'Salvar Alterações'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

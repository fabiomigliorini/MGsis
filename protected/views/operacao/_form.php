<?php
/* @var $this OperacaoController */
/* @var $model Operacao */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'operacao-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'operacao'); ?>
		<?php echo $form->textField($model,'operacao',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'operacao'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Salvar Novo' : 'Salvar Alterações'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

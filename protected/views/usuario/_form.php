<?php
/* @var $this UsuarioController */
/* @var $model Usuario */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'usuario-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'usuario'); ?>
		<?php echo $form->textField($model,'usuario',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'usuario'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'senha'); ?>
		<?php echo $form->textField($model,'senha',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'senha'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'codecf'); ?>
		<?php echo $form->textField($model,'codecf'); ?>
		<?php echo $form->error($model,'codecf'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'codfilial'); ?>
		<?php echo $form->textField($model,'codfilial'); ?>
		<?php echo $form->error($model,'codfilial'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'codoperacao'); ?>
		<?php echo $form->textField($model,'codoperacao'); ?>
		<?php echo $form->error($model,'codoperacao'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'codpessoa'); ?>
		<?php echo $form->textField($model,'codpessoa'); ?>
		<?php echo $form->error($model,'codpessoa'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'impressoratelanegocio'); ?>
		<?php echo $form->textField($model,'impressoratelanegocio',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'impressoratelanegocio'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'codportador'); ?>
		<?php echo $form->textField($model,'codportador'); ?>
		<?php echo $form->error($model,'codportador'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Salvar Novo' : 'Salvar Alterações'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

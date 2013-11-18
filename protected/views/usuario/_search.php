<?php
/* @var $this UsuarioController */
/* @var $model Usuario */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'codusuario'); ?>
		<?php echo $form->textField($model,'codusuario'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'usuario'); ?>
		<?php echo $form->textField($model,'usuario',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'senha'); ?>
		<?php echo $form->textField($model,'senha',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'codecf'); ?>
		<?php echo $form->textField($model,'codecf'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'codfilial'); ?>
		<?php echo $form->textField($model,'codfilial'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'codoperacao'); ?>
		<?php echo $form->textField($model,'codoperacao'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'codpessoa'); ?>
		<?php echo $form->textField($model,'codpessoa'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'impressoratelanegocio'); ?>
		<?php echo $form->textField($model,'impressoratelanegocio',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'codportador'); ?>
		<?php echo $form->textField($model,'codportador'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
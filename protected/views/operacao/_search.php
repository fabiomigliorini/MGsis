<?php
/* @var $this OperacaoController */
/* @var $model Operacao */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'codoperacao'); ?>
		<?php echo $form->textField($model,'codoperacao'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'operacao'); ?>
		<?php echo $form->textField($model,'operacao',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'alteracao'); ?>
		<?php echo $form->textField($model,'alteracao'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'codusuarioalteracao'); ?>
		<?php echo $form->textField($model,'codusuarioalteracao'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'criacao'); ?>
		<?php echo $form->textField($model,'criacao'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'codusuariocriacao'); ?>
		<?php echo $form->textField($model,'codusuariocriacao'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
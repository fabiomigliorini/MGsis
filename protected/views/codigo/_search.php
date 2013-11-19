<?php
/* @var $this CodigoController */
/* @var $model Codigo */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'tabela'); ?>
		<?php echo $form->textField($model,'tabela',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'codproximo'); ?>
		<?php echo $form->textField($model,'codproximo'); ?>
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
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

		<?php echo $form->textFieldRow($model,'codnotafiscalpagamento',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'codnotafiscal',array('class'=>'span5')); ?>

		<?php echo $form->checkBoxRow($model,'avista'); ?>

		<?php echo $form->textFieldRow($model,'tipo',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'valorpagamento',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->textFieldRow($model,'troco',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->checkBoxRow($model,'integracao'); ?>

		<?php echo $form->textFieldRow($model,'codpessoa',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'bandeira',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'autorizacao',array('class'=>'span5','maxlength'=>20)); ?>

		<?php echo $form->textFieldRow($model,'criacao',array('class'=>'span5','maxlength'=>0)); ?>

		<?php echo $form->textFieldRow($model,'codusuariocriacao',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'alteracao',array('class'=>'span5','maxlength'=>0)); ?>

		<?php echo $form->textFieldRow($model,'codusuarioalteracao',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

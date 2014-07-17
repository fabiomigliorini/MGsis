<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'type' => 'horizontal',
	'method'=>'get',
)); ?>

<hr>

		<?php echo $form->textFieldRow($model,'codcobrancahistorico',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'codpessoa',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'historico',array('class'=>'span5','maxlength'=>255)); ?>

		<?php echo $form->checkBoxRow($model,'emailautomatico'); ?>

					<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'icon'=>'icon-search',
			'label'=>'Buscar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

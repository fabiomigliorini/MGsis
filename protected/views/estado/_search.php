<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'type' => 'horizontal',
	'method'=>'get',
)); ?>

<hr>

		<?php echo $form->textFieldRow($model,'codestado',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'codpais',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'estado',array('class'=>'span5','maxlength'=>50)); ?>

		<?php echo $form->textFieldRow($model,'sigla',array('class'=>'span5','maxlength'=>2)); ?>

		<?php echo $form->textFieldRow($model,'codigooficial',array('class'=>'span5')); ?>

					<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'icon'=>'icon-search',
			'label'=>'Buscar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

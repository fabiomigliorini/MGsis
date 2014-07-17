<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'type' => 'horizontal',
	'method'=>'get',
)); ?>

<hr>

		<?php echo $form->textFieldRow($model,'codnfeterceiroduplicata',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'codnfeterceiro',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'codtitulo',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'ndup',array('class'=>'span5','maxlength'=>50)); ?>

		<?php echo $form->textFieldRow($model,'dvenc',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'vdup',array('class'=>'span5','maxlength'=>14)); ?>

					<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'icon'=>'icon-search',
			'label'=>'Buscar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'type' => 'horizontal',
	'method'=>'get',
)); ?>

<hr>

		<?php echo $form->textFieldRow($model,'codcontacontabil',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'contacontabil',array('class'=>'span5','maxlength'=>50)); ?>

		<?php echo $form->textFieldRow($model,'numero',array('class'=>'span5','maxlength'=>15)); ?>

		<?php echo $form->textFieldRow($model,'inativo',array('class'=>'span5')); ?>

					<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'icon'=>'icon-search',
			'label'=>'Buscar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

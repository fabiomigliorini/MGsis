<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'type' => 'horizontal',
	'method'=>'get',
)); ?>

<hr>

		<?php echo $form->textFieldRow($model,'codncm',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'ncm',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'descricao',array('class'=>'span5','maxlength'=>1500)); ?>

					<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'icon'=>'icon-search',
			'label'=>'Buscar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

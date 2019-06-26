<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'type' => 'horizontal',
	'method'=>'get',
)); ?>

<hr>

		<?php echo $form->textFieldRow($model,'codunidademedida',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'unidademedida',array('class'=>'span5','maxlength'=>15)); ?>

		<?php echo $form->textFieldRow($model,'sigla',array('class'=>'span5','maxlength'=>3)); ?>

					<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'icon'=>'icon-search',
			'label'=>'Buscar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

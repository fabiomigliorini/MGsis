<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'type' => 'horizontal',
	'method'=>'get',
)); ?>

<hr>

		<?php echo $form->textFieldRow($model,'codtituloagrupamento',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'emissao',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'cancelamento',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'observacao',array('class'=>'span5','maxlength'=>200)); ?>

					<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'icon'=>'icon-search',
			'label'=>'Buscar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

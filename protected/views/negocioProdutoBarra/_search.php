<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'type' => 'horizontal',
	'method'=>'get',
)); ?>

<hr>

		<?php echo $form->textFieldRow($model,'codnegocioprodutobarra',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'codnegocio',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'quantidade',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->textFieldRow($model,'valorunitario',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->textFieldRow($model,'valortotal',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->textFieldRow($model,'codprodutobarra',array('class'=>'span5')); ?>

					<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'icon'=>'icon-search',
			'label'=>'Buscar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

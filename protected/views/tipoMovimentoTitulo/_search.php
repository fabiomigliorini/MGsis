<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'type' => 'horizontal',
	'method'=>'get',
)); ?>

<hr>

		<?php echo $form->textFieldRow($model,'codtipomovimentotitulo',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'tipomovimentotitulo',array('class'=>'span5','maxlength'=>20)); ?>

		<?php echo $form->checkBoxRow($model,'implantacao'); ?>

		<?php echo $form->checkBoxRow($model,'ajuste'); ?>

		<?php echo $form->checkBoxRow($model,'armotizacao'); ?>

		<?php echo $form->checkBoxRow($model,'juros'); ?>

		<?php echo $form->checkBoxRow($model,'desconto'); ?>

		<?php echo $form->checkBoxRow($model,'pagamento'); ?>

		<?php echo $form->checkBoxRow($model,'estorno'); ?>

		<?php echo $form->textFieldRow($model,'observacao',array('class'=>'span5','maxlength'=>255)); ?>

					<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'icon'=>'icon-search',
			'label'=>'Buscar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'type' => 'horizontal',
	'method'=>'get',
)); ?>

<hr>

		<?php echo $form->textFieldRow($model,'codpessoacertidao',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'codpessoa',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'codcertidaoemissor',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'numero',array('class'=>'span5','maxlength'=>20)); ?>

		<?php echo $form->textFieldRow($model,'autenticacao',array('class'=>'span5','maxlength'=>20)); ?>

		<?php echo $form->textFieldRow($model,'validade',array('class'=>'span5')); ?>

						<?php echo $form->textFieldRow($model,'inativo',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'codcertidaotipo',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'icon'=>'icon-search',
			'label'=>'Buscar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

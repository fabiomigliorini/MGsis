<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'type' => 'horizontal',
	'method'=>'get',
)); ?>

<hr>

		<?php echo $form->textFieldRow($model,'codliquidacaotitulo',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'transacao',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'sistema',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'codportador',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'observacao',array('class'=>'span5','maxlength'=>200)); ?>

		<?php echo $form->textFieldRow($model,'codusuario',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'estornado',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'codusuarioestorno',array('class'=>'span5')); ?>

						<?php echo $form->textFieldRow($model,'debito',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->textFieldRow($model,'credito',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->textFieldRow($model,'codpessoa',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'icon'=>'icon-search',
			'label'=>'Buscar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

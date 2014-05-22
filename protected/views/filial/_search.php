<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'type' => 'horizontal',
	'method'=>'get',
)); ?>

<hr>

		<?php echo $form->textFieldRow($model,'codfilial',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'codempresa',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'codpessoa',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'filial',array('class'=>'span5','maxlength'=>20)); ?>

		<?php echo $form->checkBoxRow($model,'emitenfe'); ?>

		<?php echo $form->textFieldRow($model,'acbrnfemonitorcaminho',array('class'=>'span5','maxlength'=>100)); ?>

		<?php echo $form->textFieldRow($model,'acbrnfemonitorcaminhorede',array('class'=>'span5','maxlength'=>100)); ?>

		<?php echo $form->textFieldRow($model,'acbrnfemonitorbloqueado',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'acbrnfemonitorcodusuario',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'empresadominio',array('class'=>'span5','maxlength'=>7)); ?>

		<?php echo $form->textFieldRow($model,'acbrnfemonitorip',array('class'=>'span5','maxlength'=>20)); ?>

		<?php echo $form->textFieldRow($model,'acbrnfemonitorporta',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'odbcnumeronotafiscal',array('class'=>'span5','maxlength'=>500)); ?>

					<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'icon'=>'icon-search',
			'label'=>'Buscar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

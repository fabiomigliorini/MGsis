<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'type' => 'horizontal',
	'method'=>'get',
)); ?>

<hr>

		<?php echo $form->textFieldRow($model,'codportador',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'portador',array('class'=>'span5','maxlength'=>50)); ?>

		<?php echo $form->textFieldRow($model,'codbanco',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'agencia',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'agenciadigito',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'conta',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'contadigito',array('class'=>'span5')); ?>

		<?php echo $form->checkBoxRow($model,'emiteboleto'); ?>

		<?php echo $form->textFieldRow($model,'codfilial',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'convenio',array('class'=>'span5','maxlength'=>20)); ?>

		<?php echo $form->textFieldRow($model,'diretorioremessa',array('class'=>'span5','maxlength'=>100)); ?>

		<?php echo $form->textFieldRow($model,'diretorioretorno',array('class'=>'span5','maxlength'=>100)); ?>

		<?php echo $form->textFieldRow($model,'carteira',array('class'=>'span5')); ?>

					<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'icon'=>'icon-search',
			'label'=>'Buscar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

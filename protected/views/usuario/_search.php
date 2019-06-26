<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'type' => 'horizontal',
	'method'=>'get',
)); ?>

<hr>

		<?php echo $form->textFieldRow($model,'codusuario',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'usuario',array('class'=>'span5','maxlength'=>50)); ?>

		<?php echo $form->textFieldRow($model,'senha',array('class'=>'span5','maxlength'=>100)); ?>

		<?php echo $form->textFieldRow($model,'codecf',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'codfilial',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'codoperacao',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'codpessoa',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'impressoramatricial',array('class'=>'span5','maxlength'=>100)); ?>

		<?php echo $form->textFieldRow($model,'codportador',array('class'=>'span5')); ?>

					<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'icon'=>'icon-search',
			'label'=>'Buscar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

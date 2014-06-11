<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'type' => 'horizontal',
	'method'=>'get',
)); ?>

<hr>

		<?php echo $form->textFieldRow($model,'codnotafiscalcartacorrecao',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'codnotafiscal',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'lote',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'data',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'sequencia',array('class'=>'span5')); ?>

		<?php echo $form->textAreaRow($model,'texto',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

		<?php echo $form->textFieldRow($model,'protocolo',array('class'=>'span5','maxlength'=>100)); ?>

		<?php echo $form->textFieldRow($model,'protocolodata',array('class'=>'span5')); ?>

					<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'icon'=>'icon-search',
			'label'=>'Buscar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

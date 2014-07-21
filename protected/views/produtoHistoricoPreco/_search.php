<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'type' => 'horizontal',
	'method'=>'get',
)); ?>

<hr>

		<?php echo $form->textFieldRow($model,'codprodutohistoricopreco',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'codproduto',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'codprodutoembalagem',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'codusuario',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'precoantigo',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->textFieldRow($model,'preconovo',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->textFieldRow($model,'data',array('class'=>'span5')); ?>

					<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'icon'=>'icon-search',
			'label'=>'Buscar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

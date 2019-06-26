<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'type' => 'horizontal',
	'method'=>'get',
)); ?>

<hr>

		<?php echo $form->textFieldRow($model,'codprodutobarra',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'codproduto',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'variacao',array('class'=>'span5','maxlength'=>100)); ?>

		<?php echo $form->textFieldRow($model,'barras',array('class'=>'span5','maxlength'=>50)); ?>

		<?php echo $form->textFieldRow($model,'referencia',array('class'=>'span5','maxlength'=>50)); ?>

		<?php echo $form->textFieldRow($model,'codmarca',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'codprodutoembalagem',array('class'=>'span5')); ?>

					<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'icon'=>'icon-search',
			'label'=>'Buscar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'type' => 'horizontal',
	'method'=>'get',
)); ?>

<hr>

		<?php echo $form->textFieldRow($model,'codtributacaonaturezaoperacao',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'codtributacao',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'codnaturezaoperacao',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'codcfop',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'icmsbase',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->textFieldRow($model,'icmspercentual',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->textFieldRow($model,'codestado',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'csosn',array('class'=>'span5','maxlength'=>4)); ?>

		<?php echo $form->textFieldRow($model,'codtipoproduto',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'acumuladordominiovista',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'acumuladordominioprazo',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'historicodominio',array('class'=>'span5','maxlength'=>512)); ?>

		<?php echo $form->checkBoxRow($model,'movimentacaofisica'); ?>

		<?php echo $form->checkBoxRow($model,'movimentacaocontabil'); ?>

					<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'icon'=>'icon-search',
			'label'=>'Buscar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

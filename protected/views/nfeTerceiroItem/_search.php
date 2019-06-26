<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'type' => 'horizontal',
	'method'=>'get',
)); ?>

<hr>

		<?php echo $form->textFieldRow($model,'codnfeterceiroitem',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'codnfeterceiro',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'nitem',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'cprod',array('class'=>'span5','maxlength'=>30)); ?>

		<?php echo $form->textFieldRow($model,'xprod',array('class'=>'span5','maxlength'=>100)); ?>

		<?php echo $form->textFieldRow($model,'cean',array('class'=>'span5','maxlength'=>30)); ?>

		<?php echo $form->textFieldRow($model,'ncm',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'cfop',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'ucom',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'qcom',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->textFieldRow($model,'vuncom',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->textFieldRow($model,'vprod',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->textFieldRow($model,'ceantrib',array('class'=>'span5','maxlength'=>30)); ?>

		<?php echo $form->textFieldRow($model,'utrib',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->textFieldRow($model,'qtrib',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->textFieldRow($model,'vuntrib',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->textFieldRow($model,'cst',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'csosn',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'vbc',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->textFieldRow($model,'picms',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->textFieldRow($model,'vicms',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->textFieldRow($model,'vbcst',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->textFieldRow($model,'picmsst',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->textFieldRow($model,'vicmsst',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->textFieldRow($model,'ipivbc',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->textFieldRow($model,'ipipipi',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->textFieldRow($model,'ipivipi',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->textFieldRow($model,'codprodutobarra',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'margem',array('class'=>'span5','maxlength'=>6)); ?>

		<?php echo $form->textFieldRow($model,'complemento',array('class'=>'span5','maxlength'=>14)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'icon'=>'icon-search',
			'label'=>'Buscar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'type' => 'horizontal',
	'method'=>'get',
)); ?>

<hr>

		<?php echo $form->textFieldRow($model,'codnotafiscalprodutobarra',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'codnotafiscal',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'codprodutobarra',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'codcfop',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'descricaoalternativa',array('class'=>'span5','maxlength'=>100)); ?>

		<?php echo $form->textFieldRow($model,'quantidade',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->textFieldRow($model,'valorunitario',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->textFieldRow($model,'valortotal',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->textFieldRow($model,'icmsbase',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->textFieldRow($model,'icmspercentual',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->textFieldRow($model,'icmsvalor',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->textFieldRow($model,'ipibase',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->textFieldRow($model,'ipipercentual',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->textFieldRow($model,'ipivalor',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->textFieldRow($model,'icmsstbase',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->textFieldRow($model,'icmsstpercentual',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->textFieldRow($model,'icmsstvalor',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->textFieldRow($model,'csosn',array('class'=>'span5','maxlength'=>4)); ?>

		<?php echo $form->textFieldRow($model,'codnegocioprodutobarra',array('class'=>'span5')); ?>

					<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'icon'=>'icon-search',
			'label'=>'Buscar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

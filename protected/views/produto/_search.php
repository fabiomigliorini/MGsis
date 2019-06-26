<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'type' => 'horizontal',
	'method'=>'get',
)); ?>

<hr>

		<?php echo $form->textFieldRow($model,'codproduto',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'produto',array('class'=>'span5','maxlength'=>100)); ?>

		<?php echo $form->textFieldRow($model,'referencia',array('class'=>'span5','maxlength'=>50)); ?>

		<?php echo $form->textFieldRow($model,'codunidademedida',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'codsubgrupoproduto',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'codmarca',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'preco',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->checkBoxRow($model,'importado'); ?>

		<?php echo $form->textFieldRow($model,'ncm',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'codtributacao',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'inativo',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'codtipoproduto',array('class'=>'span5')); ?>

		<?php echo $form->checkBoxRow($model,'site'); ?>

		<?php echo $form->textFieldRow($model,'descricaosite',array('class'=>'span5','maxlength'=>1024)); ?>

					<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'icon'=>'icon-search',
			'label'=>'Buscar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

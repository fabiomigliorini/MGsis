<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'type' => 'horizontal',
	'method'=>'get',
)); ?>

<hr>

		<?php echo $form->textFieldRow($model,'codnegocio',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'codpessoa',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'codfilial',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'lancamento',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'codpessoavendedor',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'codoperacao',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'codnegociostatus',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'observacoes',array('class'=>'span5','maxlength'=>500)); ?>

		<?php echo $form->textFieldRow($model,'codusuario',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'valordesconto',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->checkBoxRow($model,'entrega'); ?>

		<?php echo $form->textFieldRow($model,'acertoentrega',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'codusuarioacertoentrega',array('class'=>'span5')); ?>

						<?php echo $form->textFieldRow($model,'codnaturezaoperacao',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'valorprodutos',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->textFieldRow($model,'valortotal',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->textFieldRow($model,'valoraprazo',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->textFieldRow($model,'valoravista',array('class'=>'span5','maxlength'=>14)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'icon'=>'icon-search',
			'label'=>'Buscar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

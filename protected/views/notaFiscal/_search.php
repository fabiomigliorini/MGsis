<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'type' => 'horizontal',
	'method'=>'get',
)); ?>

<hr>

		<?php echo $form->textFieldRow($model,'codnotafiscal',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'codnaturezaoperacao',array('class'=>'span5')); ?>

		<?php echo $form->checkBoxRow($model,'emitida'); ?>

		<?php echo $form->textFieldRow($model,'nfechave',array('class'=>'span5','maxlength'=>100)); ?>

		<?php echo $form->checkBoxRow($model,'nfeimpressa'); ?>

		<?php echo $form->textFieldRow($model,'serie',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'numero',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'emissao',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'saida',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'codfilial',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'codpessoa',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'observacoes',array('class'=>'span5','maxlength'=>500)); ?>

		<?php echo $form->textFieldRow($model,'volumes',array('class'=>'span5')); ?>

		<?php echo $form->select2Row($model,'codnaturezaoperacao', NaturezaOperacao::getListaCombo() , array('class'=>'input-xlarge')); ?>

		<?php echo $form->textFieldRow($model,'codoperacao',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'nfereciboenvio',array('class'=>'span5','maxlength'=>100)); ?>

		<?php echo $form->textFieldRow($model,'nfedataenvio',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'nfeautorizacao',array('class'=>'span5','maxlength'=>100)); ?>

		<?php echo $form->textFieldRow($model,'nfedataautorizacao',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'valorfrete',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->textFieldRow($model,'valorseguro',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->textFieldRow($model,'valordesconto',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->textFieldRow($model,'valoroutras',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->textFieldRow($model,'nfecancelamento',array('class'=>'span5','maxlength'=>100)); ?>

		<?php echo $form->textFieldRow($model,'nfedatacancelamento',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'nfeinutilizacao',array('class'=>'span5','maxlength'=>100)); ?>

		<?php echo $form->textFieldRow($model,'nfedatainutilizacao',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'justificativa',array('class'=>'span5','maxlength'=>200)); ?>

						<?php echo $form->textFieldRow($model,'valorprodutos',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->textFieldRow($model,'valortotal',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->textFieldRow($model,'icmsbase',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->textFieldRow($model,'icmsvalor',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->textFieldRow($model,'icmsstbase',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->textFieldRow($model,'icmsstvalor',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->textFieldRow($model,'ipibase',array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->textFieldRow($model,'ipivalor',array('class'=>'span5','maxlength'=>14)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'icon'=>'icon-search',
			'label'=>'Buscar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'action'=>Yii::app()->createUrl($this->route),
    'type' => 'horizontal',
    'method'=>'get',
)); ?>

<hr>

		<?php echo $form->textFieldRow($model, 'codnfeterceiro', array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model, 'nsu', array('class'=>'span5','maxlength'=>20)); ?>

		<?php echo $form->textFieldRow($model, 'nfechave', array('class'=>'span5','maxlength'=>100)); ?>

		<?php echo $form->textFieldRow($model, 'cnpj', array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->textFieldRow($model, 'ie', array('class'=>'span5','maxlength'=>20)); ?>

		<?php echo $form->textFieldRow($model, 'emitente', array('class'=>'span5','maxlength'=>100)); ?>

		<?php echo $form->textFieldRow($model, 'codpessoa', array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model, 'emissao', array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model, 'nfedataautorizacao', array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model, 'codoperacao', array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model, 'valortotal', array('class'=>'span5','maxlength'=>14)); ?>

		<?php echo $form->textFieldRow($model, 'indsituacao', array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model, 'indmanifestacao', array('class'=>'span5')); ?>

					<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType' => 'submit',
            'type'=>'primary',
            'icon'=>'icon-search',
            'label'=>'Buscar',
        )); ?>
	</div>

<?php $this->endWidget(); ?>

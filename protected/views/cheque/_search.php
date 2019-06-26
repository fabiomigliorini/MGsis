<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'type' => 'horizontal',
	'method'=>'get',
)); ?>

<hr>

		<?php echo $form->textFieldRow($model,'codcheque',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'cmc7',array('class'=>'span5','maxlength'=>50)); ?>

		<?php echo $form->textFieldRow($model,'codbanco',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'agencia',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'contacorrente',array('class'=>'span5','maxlength'=>15)); ?>

		<?php echo $form->textFieldRow($model,'emitente',array('class'=>'span5','maxlength'=>100)); ?>

		<?php echo $form->textFieldRow($model,'numero',array('class'=>'span5','maxlength'=>15)); ?>

		<?php echo $form->textFieldRow($model,'emissao',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'vencimento',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'repasse',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'destino',array('class'=>'span5','maxlength'=>50)); ?>

		<?php echo $form->textFieldRow($model,'devolucao',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'motivodevolucao',array('class'=>'span5','maxlength'=>50)); ?>

		<?php echo $form->textFieldRow($model,'observacao',array('class'=>'span5','maxlength'=>200)); ?>

		<?php echo $form->textFieldRow($model,'lancamento',array('class'=>'span5')); ?>

			<?php echo $form->textFieldRow($model,'cancelamento',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'valor',array('class'=>'span5','maxlength'=>14)); ?>

				<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'icon'=>'icon-search',
			'label'=>'Buscar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

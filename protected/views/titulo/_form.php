<?php
/* @var $this TituloController */
/* @var $model Titulo */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'titulo-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array(
		'class'=>'form-horizontal'
	),
)); ?>

	<?php echo $form->errorSummary($model); ?>
	<div class="control-group">
		<?php echo $form->labelEx($model,'sistema', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php
				$this->widget('CMaskedTextField',array(
					'model'=>$model,
					'attribute'=>'sistema',
					'mask'=>'99/99/9999\ 99:99:99',
					'htmlOptions'=>array(
						'class'=>'timestamp'
					),
				));
				?>
			<?php echo $form->error($model,'sistema'); ?>
		</div>
	</div>
		
	<div class="control-group">
		<?php echo $form->labelEx($model,'emissao', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php
				$this->widget('zii.widgets.jui.CJuiDatePicker',array(
					'model'=>$model,
					'attribute'=>'emissao',
					'language'=>'pt-BR',
					'htmlOptions'=>array(
						'class'=>'date',
						),
				));		
			?>
			<?php echo $form->error($model,'emissao'); ?>
		</div>
	</div>
	
	<div class="control-group">
		<?php echo $form->labelEx($model,'vencimento', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php
				$this->widget('zii.widgets.jui.CJuiDatePicker',array(
					'model'=>$model,
					'attribute'=>'vencimento',
					'language'=>'pt-BR',
					'htmlOptions'=>array(
						'class'=>'date',
						),
				));		
			?>
			<?php echo $form->error($model,'vencimento'); ?>
		</div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'debito', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'debito',array('class'=>'money')); ?>
			<?php echo $form->error($model,'debito'); ?>
		</div>
	</div>

	<div class="controls">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Salvar Novo' : 'Salvar Alterações'); ?>
	</div>

<?php $this->endWidget(); ?>

<input type="text" name="demoEuro" id="demoEuro2" class="demo">

<script type="text/javascript">
	$(document).ready(
		function()
			{
				$('#Titulo_debito').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });

			}
		);
</script>

</div><!-- form -->

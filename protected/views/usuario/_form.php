<?php
/* @var $this UsuarioController */
/* @var $model Usuario */
/* @var $form CActiveForm */
?>

<div class="form">

<?php
/*
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'usuario-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
));
 * 
 */
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id' => 'usuario-form',
        'type' => 'horizontal',
		'enableAjaxValidation'=>true,
    )
); 
?>
   
	<?php echo $form->errorSummary($model); ?>
	
	<fieldset>
		<?php 
			echo $form->textFieldRow(
				$model,
				'usuario',
				array('hint' => 'Preencha o nome do usuário')
				); 

			echo $form->passwordFieldRow($model, 'senha_tela');
			
			echo $form->passwordFieldRow($model, 'senha_tela_repeat');
			
			echo $form->select2Row(
				$model,
				'codecf',
				array(
					'asDropDownList' => false,
					'options' => array(
						'data' => CHtml::listData(Filial::model()->findAll(), 'codfilial', 'filial'),
						'placeholder' => 'type clever, or is, or just type!',
						'width' => '40%',
						)
					)
				);		
			
		?>
	</fieldset>
		
	
	<div class="row">
		<?php //echo $form->labelEx($model,'codecf'); ?>
		<?
		/*
			$this->widget('ext.select2.ESelect2', array(
				'model' => $model,
 ,				'attribute' => 'codecf',
				'options' => array('allowClear'=>true),
				'htmlOptions' => array('style' => 'width:200px;'),
			));
		 * 
		 */
		?>
		<?php //echo $form->error($model,'codecf'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'codfilial'); ?>
		<?
		/*
			$this->widget('ext.select2.ESelect2', array(
				'model' => $model,
				'attribute' => 'codfilial',
				'data' => CHtml::listData(Filial::model()->findAll(), 'codfilial', 'filial'),
				'options' => array('allowClear'=>true),
				'htmlOptions' => array('style' => 'width:200px;'),
			));
		 * 
		 */
		?>
		<?php echo $form->error($model,'codfilial'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'codoperacao'); ?>
		<?
			/*
			$this->widget('ext.select2.ESelect2', array(
				'model' => $model,
				'attribute' => 'codoperacao',
				'data' => CHtml::listData(Operacao::model()->findAll(), 'codoperacao', 'operacao'),
				'options' => array('allowClear'=>true),
				'htmlOptions' => array('style' => 'width:200px;'),
			));
			 * 
			 */
		?>
		<?php echo $form->error($model,'codoperacao'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'codpessoa'); ?>
		<?php echo $form->textField($model,'codpessoa'); ?>
		<?php echo $form->error($model,'codpessoa'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'impressoratelanegocio'); ?>
		<?php echo $form->textField($model,'impressoratelanegocio',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'impressoratelanegocio'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'codportador'); ?>
		<?
		/*
			$this->widget('ext.select2.ESelect2', array(
				'model' => $model,
				'attribute' => 'codportador',
				'data' => CHtml::listData(Portador::model()->findAll(), 'codportador', 'portador'),
				'options' => array('allowClear'=>true),
				'htmlOptions' => array('style' => 'width:200px;'),
			));
		 * 
		 */
		?>
		<?php echo $form->error($model,'codportador'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Salvar Novo' : 'Salvar Alterações'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
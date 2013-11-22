<?php
/* @var $this CodigoController */
/* @var $data Codigo */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('tabela')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->tabela), array('view', 'id'=>$data->tabela)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('codproximo')); ?>:</b>
	<?php echo CHtml::encode($data->codproximo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('alteracao')); ?>:</b>
	<?php echo CHtml::encode($data->alteracao); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('codusuarioalteracao')); ?>:</b>
	<?php echo CHtml::encode($data->codusuarioalteracao); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('criacao')); ?>:</b>
	<?php echo CHtml::encode($data->criacao); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('codusuariocriacao')); ?>:</b>
	<?php echo CHtml::encode($data->codusuariocriacao); ?>
	<br />


</div>

<?php
/* @var $this OperacaoController */
/* @var $data Operacao */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('codoperacao')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->codoperacao), array('view', 'id'=>$data->codoperacao)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('operacao')); ?>:</b>
	<?php echo CHtml::encode($data->operacao); ?>
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

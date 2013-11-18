<?php
/* @var $this UsuarioController */
/* @var $data Usuario */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('codusuario')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->codusuario), array('view', 'id'=>$data->codusuario)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('usuario')); ?>:</b>
	<?php echo CHtml::encode($data->usuario); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('senha')); ?>:</b>
	<?php echo CHtml::encode($data->senha); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('codecf')); ?>:</b>
	<?php echo CHtml::encode($data->codecf); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('codfilial')); ?>:</b>
	<?php echo CHtml::encode($data->codfilial); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('codoperacao')); ?>:</b>
	<?php echo CHtml::encode($data->codoperacao); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('codpessoa')); ?>:</b>
	<?php echo CHtml::encode($data->codpessoa); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('impressoratelanegocio')); ?>:</b>
	<?php echo CHtml::encode($data->impressoratelanegocio); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('codportador')); ?>:</b>
	<?php echo CHtml::encode($data->codportador); ?>
	<br />

	*/ ?>

</div>
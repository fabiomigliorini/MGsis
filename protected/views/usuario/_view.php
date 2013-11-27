<?php
/* @var $this UsuarioController */
/* @var $data Usuario */
?>

<li>

	<b><?php echo CHtml::encode($data->getAttributeLabel('usuario')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->usuario), array('view', 'id'=>$data->codusuario)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('codfilial')); ?>:</b>
	<?php echo isset($data->codfilial)?CHtml::encode($data->Filial->filial):Null; ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('codpessoa')); ?>:</b>
	<?php echo isset($data->codpessoa)?CHtml::encode($data->Pessoa->fantasia):Null; ?>
	<br />

</li>

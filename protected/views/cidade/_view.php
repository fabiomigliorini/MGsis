<div class="registro">

	<div class="codigo">
		<?php echo CHtml::encode($data->getAttributeLabel('codcidade')); ?>:
		<?php echo CHtml::link(CHtml::encode($data->codcidade),array('view','id'=>$data->codcidade)); ?>
	</div>
	<div class="detalhes">
	
		<?php echo CHtml::encode($data->getAttributeLabel('codestado')); ?>:
		<b><?php echo CHtml::encode($data->codestado); ?></b>

		<?php echo CHtml::encode($data->getAttributeLabel('cidade')); ?>:
		<b><?php echo CHtml::encode($data->cidade); ?></b>

		<?php echo CHtml::encode($data->getAttributeLabel('sigla')); ?>:
		<b><?php echo CHtml::encode($data->sigla); ?></b>

		<?php echo CHtml::encode($data->getAttributeLabel('codigooficial')); ?>:
		<b><?php echo CHtml::encode($data->codigooficial); ?></b>

	</div>
</div>
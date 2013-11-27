<div class="registro">

	<div class="codigo">
		<?php echo CHtml::encode($data->getAttributeLabel('tabela')); ?>:
	<?php echo CHtml::link(CHtml::encode($data->tabela),array('view','id'=>$data->tabela)); ?>
	<br />

	</div>
	<div class="detalhes">
		<b><?php echo CHtml::encode($data->getAttributeLabel('codproximo')); ?>:</b>
	<?php echo CHtml::encode($data->codproximo); ?>
	<br />

	</div>
</div>
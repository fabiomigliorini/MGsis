<div class="registro">
	<div class="codigo">
		<?php echo CHtml::link(CHtml::encode($data->usuario),array('view','id'=>$data->codusuario)); ?>
	</div>
	<div class="detalhes">
		<b><?php echo isset($data->codfilial)?CHtml::encode($data->Filial->filial):'&nbsp;'; ?></b>
		<b><?php echo isset($data->codpessoa)?'&ndash; ' . CHtml::encode($data->Pessoa->fantasia):'&nbsp;'; ?></b>
	</div>
</div>
<div class="registro">
	<div class="row-fluid">
		<b class="span2">
			<?php echo CHtml::link(CHtml::encode($data->usuario),array('view','id'=>$data->codusuario)); ?>
		</b>
		<small class="muted span2">
			<b><?php echo isset($data->codfilial)?CHtml::encode($data->Filial->filial):'&nbsp;'; ?></b>
		</small>
		<small class="muted span2">
			<b><?php echo isset($data->Pessoa)?CHtml::encode($data->Pessoa->fantasia):'&nbsp;'; ?></b>
		</small>
	</div>
</div>
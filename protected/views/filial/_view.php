<div class="registro row-fluid">
	<small class="span1 muted">
		<?php echo CHtml::encode(Yii::app()->format->formataCodigo($data->codfilial)); ?>
	</small>
	
		<b class="span1"><?php echo CHtml::link(CHtml::encode($data->filial),array('view','id'=>$data->codfilial)); ?></b>
	
		<small class="span3"><?php echo CHtml::encode($data->Empresa->empresa); ?></small>

		<small class="span7"><?php echo CHtml::encode($data->Pessoa->fantasia); ?></small>




		<?php /*
		<small class="span1"><?php echo CHtml::encode($data->emitenfe); ?></small>
		<small class="span1"><?php echo CHtml::encode($data->acbrnfemonitorcaminho); ?></small>
		<small class="span1"><?php echo CHtml::encode($data->acbrnfemonitorcaminhorede); ?></small>
		<small class="span2 muted"><?php echo CHtml::encode($data->acbrnfemonitorbloqueado); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->acbrnfemonitorcodusuario); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->empresadominio); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->acbrnfemonitorip); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->acbrnfemonitorporta); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->odbcnumeronotafiscal); ?></small>

		*/ ?>
</div>
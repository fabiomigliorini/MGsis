<div class="registro row-fluid">
	<small class="span1 muted">
		<?php echo CHtml::encode(Yii::app()->format->formataCodigo($data->codtipotitulo)); ?>
	</small>
	
		<b class="span2 muted"><?php echo CHtml::link(CHtml::encode($data->tipotitulo),array('view','id'=>$data->codtipotitulo)); ?></b>

		<small class="span2 muted">
			<?php echo ($data->pagar)?"Pagar":""; ?>
			<?php echo ($data->receber)?"Receber":""; ?>
		</small>
		<small class="span1 muted">
			<?php echo ($data->debito)?"Débito":""; ?> 
			<?php echo ($data->credito)?"Crédito":""; ?>
		</small>

		<small class="span1 muted"><?php echo CHtml::encode($data->observacoes); ?></small>

		<small class="span5 muted"><?php echo CHtml::encode($data->TipoMovimentoTitulo->tipomovimentotitulo); ?></small>

</div>
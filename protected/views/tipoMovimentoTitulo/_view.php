<div class="registro row-fluid">
		<small class="span1 muted"><?php echo CHtml::encode(Yii::app()->format->formataCodigo($data->codtipomovimentotitulo)); ?></small>
	
		<b class="span2"><?php echo CHtml::link(CHtml::encode($data->tipomovimentotitulo),array('view','id'=>$data->codtipomovimentotitulo)); ?></b>

		<small class="span3 muted">
			<?php echo ($data->implantacao)?"Implantação":""; ?>

			<?php echo CHtml::encode($data->ajuste)?"Ajuste":""; ?>

			<?php echo CHtml::encode($data->armotizacao)?"Armoização":""; ?>

			<?php echo CHtml::encode($data->juros)?"Juros":""; ?>

			<?php echo CHtml::encode($data->desconto)?"Desconto":""; ?>

			<?php echo CHtml::encode($data->pagamento)?"Pagamento":""; ?>

			<?php echo CHtml::encode($data->estorno)?"Estorno":""; ?>
		</small>

		<small class="span6 muted"><?php echo nl2br(CHtml::encode($data->observacao)); ?></small>

	
</div>
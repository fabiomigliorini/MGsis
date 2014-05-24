<div class="registro row-fluid">
	<b class="span2">
		<?php echo CHtml::encode($data->getAttributeLabel('codnotafiscalprodutobarra')); ?>:
		<?php echo CHtml::link(CHtml::encode(Yii::app()->format->formataCodigo($data->codnotafiscalprodutobarra)),array('view','id'=>$data->codnotafiscalprodutobarra)); ?>
	</b>
	
		<small class="span2 muted"><?php echo CHtml::encode($data->codnotafiscal); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->codprodutobarra); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->codcfop); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->descricaoalternativa); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->quantidade); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->valorunitario); ?></small>

		<?php /*
		<small class="span2 muted"><?php echo CHtml::encode($data->valortotal); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->icmsbase); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->icmspercentual); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->icmsvalor); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->ipibase); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->ipipercentual); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->ipivalor); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->icmsstbase); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->icmsstpercentual); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->icmsstvalor); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->csosn); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->codnegocioprodutobarra); ?></small>

		*/ ?>
</div>
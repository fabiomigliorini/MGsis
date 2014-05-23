<div class="registro row-fluid">
	<small class="span1 muted">
		<?php echo CHtml::encode(Yii::app()->format->formataCodigo($data->codcheque)); ?>
	</small>
	
		<small class="span3 muted"><?php echo CHtml::encode($data->cmc7); ?></small>

		<small class="span1 muted"><?php echo CHtml::encode($data->codbanco); ?></small>

		<small class="span1 muted"><?php echo CHtml::encode($data->agencia); ?></small>

		<small class="span1 muted"><?php echo CHtml::encode($data->contacorrente); ?></small>

		<small class="span3 muted"><?php echo CHtml::encode($data->emitente); ?></small>

		<small class="span1 muted"><?php echo CHtml::encode($data->numero); ?></small>

		<?php /*
		<small class="span2 muted"><?php echo CHtml::encode($data->emissao); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->vencimento); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->repasse); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->destino); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->devolucao); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->motivodevolucao); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->observacao); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->lancamento); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->cancelamento); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->valor); ?></small>

		*/ ?>
</div>
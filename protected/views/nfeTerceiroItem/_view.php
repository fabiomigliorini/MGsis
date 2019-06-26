<div class="registro row-fluid">
	<b class="span2">
		<?php echo CHtml::encode($data->getAttributeLabel('codnfeterceiroitem')); ?>:
		<?php echo CHtml::link(CHtml::encode(Yii::app()->format->formataCodigo($data->codnfeterceiroitem)),array('view','id'=>$data->codnfeterceiroitem)); ?>
	</b>
	
		<small class="span2 muted"><?php echo CHtml::encode($data->codnfeterceiro); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->nitem); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->cprod); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->xprod); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->cean); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->ncm); ?></small>

		<?php /*
		<small class="span2 muted"><?php echo CHtml::encode($data->cfop); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->ucom); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->qcom); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->vuncom); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->vprod); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->ceantrib); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->utrib); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->qtrib); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->vuntrib); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->cst); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->csosn); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->vbc); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->picms); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->vicms); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->vbcst); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->picmsst); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->vicmsst); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->ipivbc); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->ipipipi); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->ipivipi); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->codprodutobarra); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->margem); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->complemento); ?></small>

		*/ ?>
</div>
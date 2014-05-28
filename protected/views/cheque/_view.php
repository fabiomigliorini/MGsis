<div class="registro row-fluid">
		
		<b class="span1 muted"><?php echo CHtml::link(CHtml::encode(Yii::app()->format->formataCodigo($data->codcheque)),array('view','id'=>$data->codcheque)); ?></b>

		<b class="span3"><?php echo CHtml::encode($data->emitente); ?></b>
		
		<small class="span1 muted"><?php echo CHtml::encode($data->Banco->banco); ?></small>

		<b class="span1 text-right"><?php echo CHtml::encode(Yii::app()->format->formatNumber(abs($data->valor))); ?>	</b>
		
		<small class="span1 muted"><?php echo CHtml::encode($data->vencimento); ?></small>
		
		<small class="span5 muted"><?php echo CHtml::encode($data->observacao); ?></small>
		<?php /*
		  
		<small class="span1 muted"><?php echo CHtml::encode($data->agencia); ?></small>

		<small class="span1 muted"><?php echo CHtml::encode($data->contacorrente); ?></small>

		<small class="span1 muted"><?php echo CHtml::encode($data->numero); ?></small>
	 
		<small class="span3 muted"><?php echo CHtml::encode($data->cmc7); ?></small> 

		<small class="span2 muted"><?php echo CHtml::encode($data->repasse); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->devolucao); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->motivodevolucao); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->lancamento); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->cancelamento); ?></small>

		*/ ?>
</div>
<div class="registro">
	<div class="row-fluid">
	<div class="span2 codigo">
		<?php echo CHtml::encode($data->getAttributeLabel('codtitulo')); ?>:
		<?php echo CHtml::link(CHtml::encode(Yii::app()->format->formataCodigo($data->codtitulo)),array('view','id'=>$data->codtitulo)); ?>
	</div>
	
		<div class="span2 detalhes"><?php echo CHtml::encode($data->codtipotitulo); ?></div>

		<div class="span2 detalhes"><?php echo CHtml::encode($data->codfilial); ?></div>

		<div class="span2 detalhes"><?php echo CHtml::encode($data->codportador); ?></div>

		<div class="span2 detalhes"><?php echo CHtml::encode($data->codpessoa); ?></div>

		<div class="span2 detalhes"><?php echo CHtml::encode($data->codcontacontabil); ?></div>

		<div class="span2 detalhes"><?php echo CHtml::encode($data->numero); ?></div>

		<?php /*
		<div class="span2 detalhes"><?php echo CHtml::encode($data->fatura); ?></div>

		<div class="span2 detalhes"><?php echo CHtml::encode($data->transacao); ?></div>

		<div class="span2 detalhes"><?php echo CHtml::encode($data->sistema); ?></div>

		<div class="span2 detalhes"><?php echo CHtml::encode($data->emissao); ?></div>

		<div class="span2 detalhes"><?php echo CHtml::encode($data->vencimento); ?></div>

		<div class="span2 detalhes"><?php echo CHtml::encode($data->vencimentooriginal); ?></div>

		<div class="span2 detalhes"><?php echo CHtml::encode($data->debito); ?></div>

		<div class="span2 detalhes"><?php echo CHtml::encode($data->credito); ?></div>

		<div class="span2 detalhes"><?php echo CHtml::encode($data->gerencial); ?></div>

		<div class="span2 detalhes"><?php echo CHtml::encode($data->observacao); ?></div>

		<div class="span2 detalhes"><?php echo CHtml::encode($data->boleto); ?></div>

		<div class="span2 detalhes"><?php echo CHtml::encode($data->nossonumero); ?></div>

		<div class="span2 detalhes"><?php echo CHtml::encode($data->debitototal); ?></div>

		<div class="span2 detalhes"><?php echo CHtml::encode($data->creditototal); ?></div>

		<div class="span2 detalhes"><?php echo CHtml::encode($data->saldo); ?></div>

		<div class="span2 detalhes"><?php echo CHtml::encode($data->debitosaldo); ?></div>

		<div class="span2 detalhes"><?php echo CHtml::encode($data->creditosaldo); ?></div>

		<div class="span2 detalhes"><?php echo CHtml::encode($data->transacaoliquidacao); ?></div>

		<div class="span2 detalhes"><?php echo CHtml::encode($data->codnegocioformapagamento); ?></div>

		<div class="span2 detalhes"><?php echo CHtml::encode($data->codtituloagrupamento); ?></div>

		<div class="span2 detalhes"><?php echo CHtml::encode($data->remessa); ?></div>

		<div class="span2 detalhes"><?php echo CHtml::encode($data->estornado); ?></div>

		*/ ?>
	</div>
</div>
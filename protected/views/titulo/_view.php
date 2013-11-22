<?php
/* @var $this TituloController */
/* @var $data Titulo */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('codtitulo')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->codtitulo), array('view', 'id'=>$data->codtitulo)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('codtipotitulo')); ?>:</b>
	<?php echo CHtml::encode($data->codtipotitulo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('codfilial')); ?>:</b>
	<?php echo CHtml::encode($data->codfilial); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('codportador')); ?>:</b>
	<?php echo CHtml::encode($data->codportador); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('codpessoa')); ?>:</b>
	<?php echo CHtml::encode($data->codpessoa); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('codcontacontabil')); ?>:</b>
	<?php echo CHtml::encode($data->codcontacontabil); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('numero')); ?>:</b>
	<?php echo CHtml::encode($data->numero); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('fatura')); ?>:</b>
	<?php echo CHtml::encode($data->fatura); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('transacao')); ?>:</b>
	<?php echo CHtml::encode($data->transacao); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sistema')); ?>:</b>
	<?php echo CHtml::encode($data->sistema); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('emissao')); ?>:</b>
	<?php echo CHtml::encode($data->emissao); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('vencimento')); ?>:</b>
	<?php echo CHtml::encode($data->vencimento); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('vencimentooriginal')); ?>:</b>
	<?php echo CHtml::encode($data->vencimentooriginal); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('debito')); ?>:</b>
	<?php echo CHtml::encode($data->debito); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('credito')); ?>:</b>
	<?php echo CHtml::encode($data->credito); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('gerencial')); ?>:</b>
	<?php echo CHtml::encode($data->gerencial); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('observacao')); ?>:</b>
	<?php echo CHtml::encode($data->observacao); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('boleto')); ?>:</b>
	<?php echo CHtml::encode($data->boleto); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nossonumero')); ?>:</b>
	<?php echo CHtml::encode($data->nossonumero); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('debitototal')); ?>:</b>
	<?php echo CHtml::encode($data->debitototal); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('creditototal')); ?>:</b>
	<?php echo CHtml::encode($data->creditototal); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('saldo')); ?>:</b>
	<?php echo CHtml::encode($data->saldo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('debitosaldo')); ?>:</b>
	<?php echo CHtml::encode($data->debitosaldo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('creditosaldo')); ?>:</b>
	<?php echo CHtml::encode($data->creditosaldo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('transacaoliquidacao')); ?>:</b>
	<?php echo CHtml::encode($data->transacaoliquidacao); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('codnegocioformapagamento')); ?>:</b>
	<?php echo CHtml::encode($data->codnegocioformapagamento); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('codtituloagrupamento')); ?>:</b>
	<?php echo CHtml::encode($data->codtituloagrupamento); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('remessa')); ?>:</b>
	<?php echo CHtml::encode($data->remessa); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('estornado')); ?>:</b>
	<?php echo CHtml::encode($data->estornado); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('alteracao')); ?>:</b>
	<?php echo CHtml::encode($data->alteracao); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('codusuarioalteracao')); ?>:</b>
	<?php echo CHtml::encode($data->codusuarioalteracao); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('criacao')); ?>:</b>
	<?php echo CHtml::encode($data->criacao); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('codusuariocriacao')); ?>:</b>
	<?php echo CHtml::encode($data->codusuariocriacao); ?>
	<br />

	*/ ?>

</div>

<?php
if (!empty($data->pagamento))
	$css_valor = "text-success";
elseif (!empty($data->protesto))
	$css_valor = "text-error";
else
	$css_valor = "text-warning";
?>


<li>
	<div class="row-fluid">
		<span class="span1">
			<?php echo $data->dataretorno; ?>
		</span>
		<b class="span11 <?php echo $css_valor; ?>">
			<?php echo (!empty($data->valor))?"Valor: " . Yii::app()->format->formatNumber($data->valor):""; ?>
			<?php echo (!empty($data->pagamento))?"Pagamento: " . Yii::app()->format->formatNumber($data->pagamento):""; ?>
			<?php echo (!empty($data->despesas))?"Despesas: " . Yii::app()->format->formatNumber($data->despesas):""; ?>
			<?php echo (!empty($data->outrasdespesas))?"Outras Despesas: " . Yii::app()->format->formatNumber($data->outrasdespesas):""; ?>
			<?php echo (!empty($data->jurosatraso))?"Juros Atraso: " . Yii::app()->format->formatNumber($data->jurosatraso):""; ?>
			<?php echo (!empty($data->jurosmora))?"Juros Mora: " . Yii::app()->format->formatNumber($data->jurosmora):""; ?>
			<?php echo (!empty($data->desconto))?"Desconto: " . Yii::app()->format->formatNumber($data->desconto):""; ?>
			<?php echo (!empty($data->abatimento))?"Abatimento: " . Yii::app()->format->formatNumber($data->abatimento):""; ?>
			<?php echo (!empty($data->protesto))?"Protesto: " . $data->protesto:""; ?>
		</b>
	</div>
	<div class="row-fluid">
		<small class="span4 muted">
			<?php echo (isset($data->BoletoMotivoOcorrencia->BoletoTipoOcorrencia))?$data->BoletoMotivoOcorrencia->BoletoTipoOcorrencia->ocorrencia:null; ?>
			>
			<?php echo (isset($data->BoletoMotivoOcorrencia))?$data->BoletoMotivoOcorrencia->motivo:null; ?>
		</small>

		<small class="span1 muted">
			<?php echo (isset($data->Portador))?$data->Portador->portador:null; ?>
		</small>
		<small class="span1 muted">
			<?php echo $data->nossonumero; ?>
		</small>
		<small class="span2 muted">
			<?php echo $data->arquivo; ?>:L<?php echo $data->linha; ?>
		</small>
		<small class="span2 muted">
			<?php echo $data->numero; ?>
		</small>
		<small class="span2 muted">
			Bco <?php echo $data->codbancocobrador; ?>
			Ag <?php echo $data->agenciacobradora; ?>
		</small>
	</div>
	<?php if(isset($data->UsuarioCriacao) || isset($data->UsuarioAlteracao)): ?>
	<div class="row-fluid">
		<small class="muted">
			<?php
				if (isset($data->UsuarioCriacao))
					echo CHtml::link(CHtml::encode($data->UsuarioCriacao->usuario),array('usuario/view','id'=>$data->codusuariocriacao));
			?> 
			<?php echo $data->criacao; ?> 
			/
			<?php
				if (isset($data->UsuarioAlteracao))
					echo CHtml::link(CHtml::encode($data->UsuarioAlteracao->usuario),array('usuario/view','id'=>$data->codusuarioalteracao));
			?>		
			<?php echo $data->alteracao; ?> 
		</small>
	</div>
	<?php endif; ?>
</li>
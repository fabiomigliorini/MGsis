<?php
if (!empty($data->pagamento))
	$css_valor = "text-success";
elseif (!empty($data->protesto))
	$css_valor = "text-error";
else
	$css_valor = "text-warning";
?>


<li class="registro">
	<small class="row-fluid">
		<span class="span1">
			<?php echo $data->dataretorno; ?>
		</span>
		<b class="span8 <?php echo $css_valor; ?>">
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
		<div class="span3 pull-right">
			<?php
				$this->widget('UsuarioCriacao', array('model'=>$data));
			?>
		</div>		
	</small>
	<small class="row-fluid">
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
	</small>
</li>
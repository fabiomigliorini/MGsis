<?

//decide o css pra utilizar nos campos de vencimento e valor
//baseado no saldo e atraso

if ($data->saldo == 0) 
	$css_vencimento = "muted";
else
	if ($data->Juros->diasAtraso > 0)
	{
		if ($data->Juros->diasAtraso <= $data->Juros->diasTolerancia) 
		{
			$css_vencimento = "text-warning";
		}
		else 
		{
			$css_vencimento = "text-error";
		}
	}
	else
	{
		$css_vencimento = "text-success";
	}

if ($data->gerencial)
	$css_filial = "text-warning";
else
	$css_filial = "text-success";

?>
<div class="registro <?php echo (!empty($data->estornado))?"alert-danger":""; ?>" id="<?php echo $data->codtitulo; ?>">
	<small class="row-fluid">
		<div class="span2">
			<small>
				<?php echo CHtml::link(CHtml::encode($data->numero),array('view','id'=>$data->codtitulo)); ?> 
			</small>
			<div class="pull-right <?php echo $css_vencimento?> ">
				<?php echo CHtml::encode($data->vencimento); ?>
			</div>
		</div>
		<span class="span7 text-right <?php echo ($data->operacao == "CR")?"text-warning":"text-success"; ?>">
			<b class="span2 text-right">
				<div class="span10">
				<?php echo CHtml::encode(Yii::app()->format->formatNumber(abs($data->saldo))); ?>
					&nbsp;
					<?php echo CHtml::encode($data->operacao); ?>
				</div>
			</b>
			<div class="span2">
				<input 
					type="hidden" 
					value="<?php echo $data->operacao; ?>" 
					name="TituloAgrupamento[operacao][<?php echo $data->codtitulo; ?>]" 
					id="TituloAgrupamento_operacao_<?php echo $data->codtitulo; ?>" 
					>
				<input 
					type="text" 
					value="<?php echo (isset($saldo[$data->codtitulo]))?$saldo[$data->codtitulo]:abs($data->saldo); ?>" 
					data-calculado="<?php echo abs($data->saldo); ?>" 
					name="TituloAgrupamento[saldo][<?php echo $data->codtitulo; ?>]" 
					id="TituloAgrupamento_saldo_<?php echo $data->codtitulo; ?>" 
					class="span12 text-right numero saldo" 
					style="font-size: 0.9em"
					>
			</div>
			<div class="span2">
				<input 
					type="text" 
					value="<?php echo (isset($multa[$data->codtitulo]))?$multa[$data->codtitulo]:abs($data->Juros->valorMulta); ?>" 
					data-calculado="<?php echo abs($data->Juros->valorMulta); ?>" 
					name="TituloAgrupamento[multa][<?php echo $data->codtitulo; ?>]" 
					id="TituloAgrupamento_multa_<?php echo $data->codtitulo; ?>" 
					class="span12 text-right numero multa" 
					style="font-size: 0.9em"
					>
			</div>
			<div class="span2">
				<input 
					type="text" 
					value="<?php echo (isset($juros[$data->codtitulo]))?$juros[$data->codtitulo]:abs($data->Juros->valorJuros); ?>" 
					data-calculado="<?php echo abs($data->Juros->valorJuros); ?>" 
					name="TituloAgrupamento[juros][<?php echo $data->codtitulo; ?>]" 
					id="TituloAgrupamento_juros_<?php echo $data->codtitulo; ?>" 
					class="span12 text-right numero juros" 
					style="font-size: 0.9em"
					>
			</div>
			<div class="span2">
				<input 
					type="text" 
					value="<?php echo (isset($desconto[$data->codtitulo]))?$desconto[$data->codtitulo]:0; ?>" 
					data-calculado="0" 
					name="TituloAgrupamento[desconto][<?php echo $data->codtitulo; ?>]" 
					id="TituloAgrupamento_desconto_<?php echo $data->codtitulo; ?>" 
					class="span12 text-right numero desconto" 
					style="font-size: 0.9em"
					>
			</div>
			<div class="span2">
				<input 
					type="text" 
					value="<?php echo (isset($total[$data->codtitulo]))?$total[$data->codtitulo]:abs($data->Juros->valorTotal); ?>" 
					data-calculado="<?php echo abs($data->Juros->valorTotal); ?>" 
					name="TituloAgrupamento[total][<?php echo $data->codtitulo; ?>]" 
					id="TituloAgrupamento_total_<?php echo $data->codtitulo; ?>" 
					class="span12 text-right numero total" 
					style="font-size: 0.9em"
					>
			</div>
		</span>
		<small class="span3 muted">
			<div class="span1">
				<input 
					type="checkbox" 
					class="codtitulo" 
					name="TituloAgrupamento[codtitulos][]" 
					id="TituloAgrupamento_codtitulo_<?php echo $data->codtitulo; ?>" 
					value="<?php echo $data->codtitulo; ?>"
					<?php echo (in_array($data->codtitulo, $codtitulos))?"checked":""; ?>
				>
			</div>
			<div class="span3 <?php echo $css_filial; ?>">
				<?php echo CHtml::encode($data->Filial->filial); ?>
				<?php echo ($data->boleto)?"Boleto":""; ?>
			</div>
			<b class="span8">
				<?php echo CHtml::link(CHtml::encode($data->Pessoa->fantasia),array('pessoa/view','id'=>$data->codpessoa)); ?> 
			</b>
		</small>
	</small>
</div>

<?php
$css_valor = ($data->operacao == "DB")?"text-success":"text-warning";	
?>
<div class="registro <?php echo (isset($selecionado) && $selecionado == true)?"alert-success":""; ?>" id="registro_<?php echo $data->codtitulo; ?>">
	<small class="row-fluid">
		<span class="span1 <?php echo ($data->gerencial)?"text-warning":"text-success"; ?>">
			<?php echo CHtml::encode($data->Filial->filial); ?> 
		</span>
		<span class="span2 muted">
			<?php if (isset($selecionado)): ?>
				<input type="checkbox" name="TituloAgrupamento[codtitulos][]" id="TituloAgrupamento_codtitulos_<?php echo $data->codtitulo; ?>" class="codtitulos" value="<?php echo $data->codtitulo; ?>" <?php echo ($selecionado)?"checked":""; ?>>
				<input type="hidden" name="saldo_<?php echo $data->codtitulo; ?>" id="saldo_<?php echo $data->codtitulo; ?>" value="<?php echo $data->saldo; ?>">
				&nbsp;
			<?php endif; ?>
			<?php echo CHtml::link(CHtml::encode($data->numero),array('titulo/view','id'=>$data->codtitulo)); ?> 
		</span>
		<b class="span2 text-right <?php echo $css_valor; ?>">
			<?php echo Yii::app()->format->formatNumber($data->valor); ?>
			<?php echo $data->operacao; ?>
		</b>
		<b class="span1">
			<?php echo $data->vencimento; ?>
		</b>
		<span class="span3 muted">
			<?php echo CHtml::link($data->Pessoa->fantasia,array('pessoa/view','id'=>$data->codpessoa)); ?> 
		</span>
		<span class="span1">
			<?php echo (isset($data->Portador))?CHtml::encode($data->Portador->portador):""; ?>
		</span>
		<span class="span2">
			<?php echo ($data->boleto)?"Boleto " . CHtml::encode($data->nossonumero):""; ?>
		</span>
	</small>
</div>
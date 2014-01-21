<?php
$css_valor = ($titulo->operacao == "DB")?"text-success":"text-warning";	
?>
<div class="registro <?php echo (isset($selecionado) && $selecionado == true)?"alert-success":""; ?>" id="registro_<?php echo $titulo->codtitulo; ?>">
	<small class="row-fluid">
		<span class="span1 <?php echo ($titulo->gerencial)?"text-warning":"text-success"; ?>">
			<?php echo CHtml::encode($titulo->Filial->filial); ?> 
		</span>
		<span class="span2 muted">
			<?php if (isset($selecionado)): ?>
				<input type="checkbox" name="TituloAgrupamento[codtitulos][]" id="TituloAgrupamento_codtitulos_<?php echo $titulo->codtitulo; ?>" class="codtitulos" value="<?php echo $titulo->codtitulo; ?>" <?php echo ($selecionado)?"checked":""; ?>>
				<input type="hidden" name="saldo_<?php echo $titulo->codtitulo; ?>" id="saldo_<?php echo $titulo->codtitulo; ?>" value="<?php echo $titulo->saldo; ?>">
				&nbsp;
			<?php endif; ?>
			<?php echo CHtml::link(CHtml::encode($titulo->numero),array('titulo/view','id'=>$titulo->codtitulo)); ?> 
		</span>
		<b class="span2 text-right <?php echo $css_valor; ?>">
			<?php echo Yii::app()->format->formatNumber($titulo->valor); ?>
			<?php echo $titulo->operacao; ?>
		</b>
		<b class="span1">
			<?php echo $titulo->vencimento; ?>
		</b>
		<span class="span3 muted">
			<?php echo CHtml::link($titulo->Pessoa->fantasia,array('pessoa/view','id'=>$titulo->codpessoa)); ?> 
		</span>
		<span class="span1">
			<?php echo (isset($titulo->Portador))?CHtml::encode($titulo->Portador->portador):""; ?>
		</span>
		<span class="span2">
			<?php echo ($titulo->boleto)?"Boleto " . CHtml::encode($titulo->nossonumero):""; ?>
		</span>
	</small>
</div>
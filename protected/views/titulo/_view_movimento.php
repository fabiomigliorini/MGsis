<?php
$css_valor = ($data->operacao <> $data->Titulo->operacao)?"text-success":"text-warning";
?>
<li class="registro">
	<small class="row-fluid">
		<span class="span1">
			<?php echo $data->transacao; ?>
		</span>
		<b class="span2 text-right <?php echo $css_valor; ?>">
			<?php echo Yii::app()->format->formatNumber($data->valor); ?> <?php echo $data->operacao; ?>
		</b>
		<span class="span6 muted">
			<span class="span4">
				<?php echo (isset($data->TipoMovimentoTitulo))?$data->TipoMovimentoTitulo->tipomovimentotitulo:null; ?>
			</span>
			<span class="span4">
				<?php echo (isset($data->Portador))?$data->Portador->portador:null; ?>
			</span>
			<span class="span4">
				<?php echo (!empty($data->codboletoretorno)) ? "Retorno Boleto" :""?>
				<?php echo (!empty($data->codcobranca)) ? "Cobranca" :""?>
				<?php echo (!empty($data->codliquidacaotitulo)) ? "Liquidação" :""?>
				<?php echo (!empty($data->codtituloagrupamento)) ? "Agrupamento" :""?>
			</span>
		</span>
		<div class="span3 pull-right">
			<?php
				$this->widget('UsuarioCriacao', array('model'=>$data));
			?>
		</div>
	</small>
</li>
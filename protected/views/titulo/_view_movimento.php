<?php

if ($data->debito > $data->credito)
{
	$sigla = "DB";
	$valor = $data->debito - $data->credito;
}
else
{
	$sigla = "CR";
	$valor = $data->credito - $data->debito;
}

if ($data->Titulo->debito > $data->Titulo->credito)
	$sigla_titulo = "DB";
else
	$sigla_titulo = "CR";


if ($sigla <> $sigla_titulo)
{
	$css_valor = "text-success";
} 
else
{
	$css_valor = "text-warning";
}

?>
<li>
	<div class="row-fluid">
		<span class="span1">
			<?php echo $data->transacao; ?>
		</span>
		<b class="span2 <?php echo $css_valor; ?>" style="text-align:right">
			<?php echo Yii::app()->format->formatNumber($valor); ?> <?php echo $sigla; ?>
		</b>
		<span class="span3">
			<?php echo (isset($data->TipoMovimentoTitulo))?$data->TipoMovimentoTitulo->tipomovimentotitulo:null; ?>
		</span>
	</div>
	<div class="row-fluid">
		<small class="span3 muted">
			<?php echo (isset($data->Portador))?$data->Portador->portador:null; ?>
		</small>
		<small class="span2 muted"> 
			<?php echo (!empty($data->codboletoretorno)) ? "Retorno Boleto" :""?>
			<?php echo (!empty($data->codcobranca)) ? "Cobranca" :""?>
			<?php echo (!empty($data->codliquidacaotitulo)) ? "Liquidação" :""?>
			<?php echo (!empty($data->codtituloagrupamento)) ? "Agrupamento" :""?>
		</small>
		<small class="span2 muted">
			<?php echo (!empty($data->criacao))?$data->criacao:$data->sistema; ?>
			<?php
				if (isset($data->UsuarioCriacao))
					echo CHtml::link(CHtml::encode($data->UsuarioCriacao->usuario),array('usuario/view','id'=>$data->codusuariocriacao));
				else if (isset($data->UsuarioAlteracao))
					echo CHtml::link(CHtml::encode($data->UsuarioAlteracao->usuario),array('usuario/view','id'=>$data->codusuarioalteracao));
			?>
		</small>
	</div>
</li>
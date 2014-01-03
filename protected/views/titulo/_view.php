<?

/*
if ($data->saldo > 0)
{
	if ($data->vencimento > date())
	{
		$css = "text-success";
	}
	else
	{
		$css = "text-error";
	}
}
else
{
	$css = "muted";
}
*/
echo(Yii::app()->locale->getDateFormat('medium'));
echo($data->vencimento);
//die(CDateTimeParser::parse(, ));
//$dStart = new DateTime(CDateTimeParser::parse($data->vencimento, Yii::app()->locale->getDateFormat('medium')));
$date = "01/01/2011";
echo $date."\n";
$vencimento = DateTime::createFromFormat("d/m/Y",$data->vencimento);
$hoje  = new DateTime();
echo $vencimento->format("Y-m-d");
$dDiff = $hoje->diff($vencimento);
//echo $dDiff->format('%R'); // use for point out relation: smaller/greater
echo $dDiff->days;

//$dStart = DateTime::createFromFormat("d/m/y", $data->vencimento);
//echo "$dStart = dStart";
//$dDiff = $dEnd->diff($dStart);
/*
$dStart = new DateTime(CDateTimeParser::parse($data->vencimento, Yii::app()->locale->getDateFormat('medium')));
 * 
 */
   $css = "muted";
?>
<div class="row-fluid registro">
	<div class="row-fluid detalhes">
		<div class="span2">
			<?php echo CHtml::link(CHtml::encode($data->numero),array('view','id'=>$data->codtitulo)); ?>
		</div>
		<div class="span4">
			<?php echo CHtml::link(CHtml::encode($data->Pessoa->fantasia),array('pessoa/view','id'=>$data->codpessoa)); ?>
		</div>
		<div class="span1"><?php echo CHtml::encode($data->emissao); ?></div>
		<div class="span1" style="text-align: right"><?php echo CHtml::encode(Yii::app()->format->formatNumber($data->debito - $data->credito)); ?></div>
		<div class="span1 codigo <?php echo $css; ?>"><?php echo CHtml::encode($data->vencimento); ?></div>
		<div class="span1 codigo" style="text-align: right"><?php echo CHtml::encode(Yii::app()->format->formatNumber($data->saldo)); ?></div>
	</div>
	<div class="row-fluid detalhes">
		<div class="span1 detalhes">
			<?php echo CHtml::link(CHtml::encode(Yii::app()->format->formataCodigo($data->codtitulo)),array('view','id'=>$data->codtitulo)); ?>
		</div>
		<div class="span1"><?php echo CHtml::encode($data->Filial->filial); ?></div>
		<div class="span1">
			sss
			<?php 
			if (isset($data->Portador))
				echo CHtml::encode($data->Portador->portador); 
			?>
			<?php echo CHtml::encode($data->nossonumero); ?>
		</div>
		


		<?php /*
		<div class="span1"></div>
		<div class="span2 detalhes"><?php echo CHtml::encode($data->codtipotitulo); ?></div>




		<div class="span2 detalhes"><?php echo CHtml::encode($data->codcontacontabil); ?></div>
		 * 
		<div class="span2 detalhes"><?php echo CHtml::encode($data->fatura); ?></div>

		<div class="span2 detalhes"><?php echo CHtml::encode($data->transacao); ?></div>

		<div class="span2 detalhes"><?php echo CHtml::encode($data->sistema); ?></div>



		<div class="span2 detalhes"><?php echo CHtml::encode($data->vencimentooriginal); ?></div>


		<div class="span2 detalhes"><?php echo CHtml::encode($data->gerencial); ?></div>

		<div class="span2 detalhes"><?php echo CHtml::encode($data->observacao); ?></div>

		<div class="span2 detalhes"><?php echo CHtml::encode($data->boleto); ?></div>


		<div class="span2 detalhes"><?php echo CHtml::encode($data->debitototal); ?></div>

		<div class="span2 detalhes"><?php echo CHtml::encode($data->creditototal); ?></div>


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
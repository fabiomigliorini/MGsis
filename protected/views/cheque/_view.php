<?php 

$css_label = "";
$staus = "&nbsp";

switch ($data->codstatus)
{
	case Cheque::CODSTATUS_ABERTO;
		$css_label = "label-success";
		$staus = "A";
		break;

	case Cheque::CODSTATUS_REPASSADO;
		$css_label = "label-info";
		$staus = "R";
		break;

	case Cheque::CODSTATUS_DEVOLVIDO;
		$css_label = "label-important";
		$staus = "D";
		break;

	case Cheque::CODSTATUS_CANCELADO;
		$staus = "C";
		break;
	
}

?>
<div class="registro row-fluid">
		
	<small class='row-fluid'>
		
		<small class="span1 muted"><?php echo CHtml::encode(Yii::app()->format->formataCodigo($data->codcheque)); ?></small>

		<b class="span3"><?php echo CHtml::link(CHtml::encode($data->emitente),array('view','id'=>$data->codcheque)); ?></b>
		
		
		<b class="span2 text-right">
			<?php echo CHtml::encode(Yii::app()->format->formatNumber(abs($data->valor))); ?>
			<small class="label <?php echo $css_label; ?>">
				<?php echo $staus; ?>
			</small>
		</b>

		<div class="span1 muted"><?php echo CHtml::encode($data->emissao); ?></div>			
		
		<b class="span1"><?php echo CHtml::encode($data->vencimento); ?></b>

		<div class="span1 text-info"><?php echo CHtml::encode($data->repasse); ?></div>
		
		<div class="span3 text-info"><?php echo CHtml::encode($data->destino); ?></div>
	
	</small>
	
	<small class="row-fuid">	
		
		<div class="span1 muted"><?php echo CHtml::encode($data->Banco->banco); ?></div>
		
		<div class="span1 muted"><?php echo CHtml::encode($data->agencia); ?></div>
		
		<div class="span1 muted"><?php echo CHtml::encode($data->contacorrente); ?></div>
		
		<div class="span1 muted"><?php echo CHtml::encode($data->numero); ?></div>

		<div class="span4 muted"><?php echo nl2br(CHtml::encode($data->observacao)); ?></div>						
		
		<div class="span1 text-error"><?php echo CHtml::encode($data->devolucao); ?></div>
		
		<div class="span2 text-error"><?php echo CHtml::encode($data->motivodevolucao); ?></div>		
		
	</small>	
		<?php /*
		<div class="span2 text-error"><?php echo CHtml::encode($data->cmc7); ?></div>		
	 
		*/ ?>
</div>
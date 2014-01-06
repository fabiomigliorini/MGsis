<?

//calcula atraso
$vencimento = DateTime::createFromFormat("d/m/Y",$data->vencimento);
$atraso = $vencimento->diff(new DateTime());

//decide o css pra utilizar nos campos de vencimento e valor
//baseado no saldo e atraso
if ($data->saldo == 0) 
	$css_vencimento = "muted";
else
	if ($atraso->days <= 3) 
		$css_vencimento = "text-warning";
	else if (!$atraso->invert)
		$css_vencimento = "text-error";
	else
		$css_vencimento = "text-success";

if ($data->gerencial)
	$css_filial = "text-warning";
else
	$css_filial = "text-success";
	
?>
<div class="row-fluid registro">
	<div class="row-fluid">
		<div class="span2">
			<div class="row-fluid">
				<?php echo CHtml::link(CHtml::encode($data->numero),array('view','id'=>$data->codtitulo)); ?>
			</div>
			<small class="span6 muted">
				<?php echo CHtml::link(CHtml::encode(Yii::app()->format->formataCodigo($data->codtitulo)),array('view','id'=>$data->codtitulo)); ?>
			</small>
			<small class="span5 <?php echo $css_filial; ?>"><?php echo CHtml::encode($data->Filial->filial); ?></small>
		</div>
		<div class="span6">
			<div class="row-fluid">
				<?php echo CHtml::link(CHtml::encode($data->Pessoa->fantasia),array('pessoa/view','id'=>$data->codpessoa)); ?>
			</div>
			<small class="row-fluid muted">
				<div class="span5">
					<?php 
					if (isset($data->ContaContabil))
						echo CHtml::encode($data->ContaContabil->contacontabil); 
					?> -
					<?php 
					if (isset($data->TipoTitulo))
						echo CHtml::encode($data->TipoTitulo->tipotitulo); 
					?>
				</div>				
				<div class="span5">
					<?php 
					if (isset($data->Portador))
						echo CHtml::encode($data->Portador->portador); 
					?>
					<?php echo CHtml::encode($data->nossonumero); ?>
				</div>
				<div class="span2">
					<?php 
					if (isset($data->UsuarioCriacao))
						echo CHtml::link(CHtml::encode($data->UsuarioCriacao->usuario),array('usuario/view','id'=>$data->codusuariocriacao));
					else if (isset($data->UsuarioAlteracao))
						echo CHtml::link(CHtml::encode($data->UsuarioAlteracao->usuario),array('usuario/view','id'=>$data->codusuarioalteracao));
					?>
				</div>
			</small>
		</div>
		<div class="span4 pull-right">
			<div class="row-fluid">
				<b class="span2 <?php echo $css_vencimento; ?>">
					<?php echo CHtml::encode($data->vencimento); ?>
				</b>
				<b class="span5 <?php echo $css_vencimento; ?>" style="text-align: right">
					<?php echo CHtml::encode(Yii::app()->format->formatNumber($data->saldo)); ?>
				</b>
				<small class="span2 muted">
					<?php echo CHtml::encode($data->emissao); ?>
				</small>
				<small class="span3 muted" style="text-align: right">
					<?php echo CHtml::encode(Yii::app()->format->formatNumber($data->debito - $data->credito)); ?>
				</small>
			</div>
		</div>
	</div>
</div>


<!--



			<small class="row-fluid muted">
			</small>


-->
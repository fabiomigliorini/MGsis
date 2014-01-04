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
			<?php echo CHtml::link(CHtml::encode($data->numero),array('view','id'=>$data->codtitulo)); ?>
		</div>
		<div class="span6">
			<?php echo CHtml::link(CHtml::encode($data->Pessoa->fantasia),array('pessoa/view','id'=>$data->codpessoa)); ?>
		</div>
		<div class="span2 muted" style="text-align: right">
			<div class="span3">
				<?php echo CHtml::encode($data->emissao); ?>
			</div>
			<div class="span9">
				<?php echo CHtml::encode(Yii::app()->format->formatNumber($data->debito - $data->credito)); ?>
			</div>
		</div>
		<div class="span2 codigo <?php echo $css_vencimento; ?>" style="text-align: right">
			<div class="span3">
				<?php echo CHtml::encode($data->vencimento); ?>
			</div>
			<div class="span9">
				<?php echo CHtml::encode(Yii::app()->format->formatNumber($data->saldo)); ?>
			</div>
		</div>
	</div>
	<div class="row-fluid detalhes">
		<div class="span2">
			<?php echo CHtml::link(CHtml::encode(Yii::app()->format->formataCodigo($data->codtitulo)),array('view','id'=>$data->codtitulo)); ?>
		</div>
		<div class="span1 <?php echo $css_filial; ?>"><?php echo CHtml::encode($data->Filial->filial); ?></div>
		<div class="span2">
			<?php 
			if (isset($data->Portador))
				echo CHtml::encode($data->Portador->portador); 
			?>
		</div>
		<div class="span1"><?php echo CHtml::encode($data->nossonumero); ?></div>
		<div class="span2">
			<?php 
			if (isset($data->UsuarioCriacao))
				echo CHtml::link(CHtml::encode($data->UsuarioCriacao->usuario),array('usuario/view','id'=>$data->codusuariocriacao));
			else if (isset($data->UsuarioAlteracao))
				echo CHtml::link(CHtml::encode($data->UsuarioAlteracao->usuario),array('usuario/view','id'=>$data->codusuarioalteracao));
			?>
		</div>
		<div class="span2">
			<?php 
			if (isset($data->ContaContabil))
				echo CHtml::encode($data->ContaContabil->contacontabil); 
			?>
		</div>
		<div class="span2">
			<?php 
			if (isset($data->TipoTitulo))
				echo CHtml::encode($data->TipoTitulo->tipotitulo); 
			?>
		</div>
	</div>
</div>
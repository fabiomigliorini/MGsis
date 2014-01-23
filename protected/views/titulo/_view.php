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
<div class="registro <?php echo (!empty($data->estornado))?"alert-danger":""; ?>">
	<div class="row-fluid">
		<b class="span2">
			<?php echo CHtml::link(CHtml::encode($data->numero),array('view','id'=>$data->codtitulo)); ?> 
		</b>
		<b class="span5">
			<?php echo CHtml::link(CHtml::encode($data->Pessoa->fantasia),array('pessoa/view','id'=>$data->codpessoa)); ?> 
		</b>
		<small class="span1 muted">
			<?php echo CHtml::encode($data->emissao); ?>
		</small>
		<small class="span1 text-right muted">
			<?php echo CHtml::encode(Yii::app()->format->formatNumber(abs($data->debito - $data->credito))); ?>		
		</small>
		<b class="span3">
			<span class="span4 <?php echo $css_vencimento?>">
				<?php echo CHtml::encode($data->vencimento); ?>
			</span>
			<span class="span2 text-right <?php echo $css_vencimento?>">
				<?php echo $data->Juros->diasAtraso; ?>
			</span>
			<span class="span6 text-right <?php echo ($data->operacao == "CR")?"text-warning":"text-success"; ?>">
				<?php echo CHtml::encode(Yii::app()->format->formatNumber(abs($data->Juros->valorTotal))); ?>
				<span class="pull-right">
					&nbsp;<?php echo CHtml::encode($data->operacao); ?>
				</span>
			</span>
		</b>
	</div>
	<div class="row-fluid">
		<small class="span1 muted">
			<?php echo CHtml::link(CHtml::encode(Yii::app()->format->formataCodigo($data->codtitulo)),array('view','id'=>$data->codtitulo)); ?>
		</small>
		<small class="span1 <?php echo $css_filial; ?>">
			<?php echo CHtml::encode($data->Filial->filial); ?>
		</small>
		<small class="span3 muted">
			<?php 
			if (isset($data->ContaContabil))
				echo CHtml::encode($data->ContaContabil->contacontabil); 
			?> 
			&HorizontalLine;
			<?php 
			if (isset($data->TipoTitulo))
				echo CHtml::encode($data->TipoTitulo->tipotitulo); 
			?>
		</small>
		<small class="span2 muted">
			<?php 
			if (isset($data->Portador))
				echo CHtml::encode($data->Portador->portador); 
			?>
			<?php echo CHtml::encode($data->nossonumero); ?>
		</small>
		<small class="span1 muted">
			<?php 
			if (isset($data->UsuarioCriacao))
				echo CHtml::link(CHtml::encode($data->UsuarioCriacao->usuario),array('usuario/view','id'=>$data->codusuariocriacao));
			else if (isset($data->UsuarioAlteracao))
				echo CHtml::link(CHtml::encode($data->UsuarioAlteracao->usuario),array('usuario/view','id'=>$data->codusuarioalteracao));
			?>
		</small>

		<small class="span4 text-right <?php echo $css_vencimento; ?>">
				<?php if ($data->Juros->valorTotal <> $data->saldo): ?>
					Saldo: <?php echo CHtml::encode(Yii::app()->format->formatNumber(abs($data->saldo))); ?>
				<?php endif; ?>
				<?php if ($data->Juros->valorMulta > 0): ?>
					+ <?php echo CHtml::encode(Yii::app()->format->formatNumber($data->Juros->valorMulta)); ?> Multa
				<?php endif; ?>

				<?php if ($data->Juros->valorJuros > 0): ?>
					+ <?php echo CHtml::encode(Yii::app()->format->formatNumber($data->Juros->valorJuros)); ?> Juros
				<?php endif; ?>
		</small>
	</div>
</div>

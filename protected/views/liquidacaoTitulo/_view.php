<?php 
$css_valor = ($data->operacao == 'CR')?"text-warning":"text-success"; 
?>
<div class="registro <?php echo (!empty($data->estornado))?"alert-danger":""; ?>">
	<div class="row-fluid">
		<b class="span1">
			<?php echo CHtml::link(CHtml::encode(Yii::app()->format->formataCodigo($data->codliquidacaotitulo)),array('view','id'=>$data->codliquidacaotitulo)); ?>
		</b>
		<small class="span2 muted"><?php echo CHtml::encode($data->criacao); ?></small>
		<small class="span1 muted"><?php echo CHtml::encode($data->transacao); ?></small>
		<small class="span1 muted">
			<?php 
			if (!empty($data->codusuariocriacao))
				echo CHtml::link(CHtml::encode($data->UsuarioCriacao->usuario),array('usuario/view','id'=>$data->codusuariocriacao)); 
			?>
		</small>
		<small class="span3 muted"><?php echo CHtml::link(CHtml::encode($data->Pessoa->fantasia),array('pessoa/view','id'=>$data->codpessoa)); ?></small>
		<b class="span2 text-right <?php echo $css_valor; ?>">
			<?php echo CHtml::encode(Yii::app()->format->formatNumber($data->valor)); ?>
			&nbsp;
			<?php echo $data->operacao ?>
		</b>
		<small class="span2 muted"><?php echo CHtml::encode($data->Portador->portador); ?></small>
	</div>
</div>
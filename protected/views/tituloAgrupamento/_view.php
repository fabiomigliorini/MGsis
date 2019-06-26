<?php 
$css_valor = ($data->operacao == 'CR')?"text-warning":"text-success"; 
?>
<div class="registro <?php echo (!empty($data->cancelamento))?"alert-danger":""; ?>">
	<div class="row-fluid">
		<small class="span1">
			<?php echo CHtml::link(CHtml::encode(Yii::app()->format->formataCodigo($data->codtituloagrupamento)),array('view','id'=>$data->codtituloagrupamento)); ?>
		</small>
		<small class="span1 muted"><?php echo CHtml::encode($data->emissao); ?></small>
		<b class="span4">
			<?php echo CHtml::link(CHtml::encode($data->Pessoa->fantasia),array('pessoa/view','id'=>$data->codpessoa)); ?>
		</b>
		<b class="span2 text-right <?php echo $css_valor; ?>">
			<?php echo CHtml::encode(Yii::app()->format->formatNumber($data->valor)); ?>
			&nbsp;
			<?php echo $data->operacao ?>
		</b>
		<small class="span4 muted"><?php echo CHtml::encode($data->observacao); ?></small>
	</div>
</div>
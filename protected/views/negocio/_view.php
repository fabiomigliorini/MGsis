<?php

switch ($data->codnegociostatus)
{
	case 3:
		$css = 'alert-danger';
		break;

	case 2:
		$css = '';
		break;
	
	default:
		$css = 'alert-success';
		break;
}

?>
<div class="registro row-fluid <?php echo $css; ?> ">
	
	<b class="span1">
		<?php echo CHtml::link(CHtml::encode(Yii::app()->format->formataCodigo($data->codnegocio)),array('view','id'=>$data->codnegocio)); ?>
	</b>
	
	<small class="span3">
		<?php echo CHtml::encode($data->lancamento);?>
		<span class="pull-right"><?php echo CHtml::encode($data->NaturezaOperacao->naturezaoperacao); ?></span>
	</small>
	
	<b class="span1 text-right">
		<?php echo CHtml::link(CHtml::encode(Yii::app()->format->formatNumber($data->valortotal)),array('view','id'=>$data->codnegocio)); ?>
	</b>
	
	<span class="span3">
		<?php echo (isset($data->Pessoa))?CHtml::link(CHtml::encode($data->Pessoa->fantasia),array('pessoa/view','id'=>$data->codpessoa)):"";?>
	</span>
	
	<small class="span4 muted">
		<small class="span2"><?php echo CHtml::encode($data->Filial->filial);?></small>
		<small class="span2"><?php echo CHtml::encode($data->Usuario->usuario); ?></small>
		<small class="span2"><?php echo CHtml::encode($data->NegocioStatus->negociostatus); ?></small>
		<small class="span6"><?php echo (isset($data->PessoaVendedor))?CHtml::link(CHtml::encode($data->PessoaVendedor->fantasia),array('pessoa/view','id'=>$data->codpessoavendedor)):"";?></small>
	</small>

</div>
<div class="registro row-fluid">
		
	<div class="span5">
		<small class="span3 muted"><?php echo CHtml::encode($data->Negocio->lancamento); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->Negocio->Filial->filial); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->Negocio->NaturezaOperacao->naturezaoperacao); ?></small>	
			
		<small class="span5">
			<?php echo CHtml::link(CHtml::encode($data->Negocio->Pessoa->fantasia), array('pessoa/view','id'=>$data->Negocio->Pessoa->codpessoa)); ?>
		</small>	

	</div>
	
	<div class="span3">
		
		<small class="span2 text-right"><?php echo CHtml::encode(Yii::app()->format->formatNumber($data->quantidade)); ?></small>

		<small class="span3 muted">
			<?php
				$precounitario = ($data->valortotal)/$data->quantidade;
				//$ipi = $data->ipivalor/$data->valortotal;
				//$icmsst = $data->icmsstvalor/$data->valortotal;
				echo $data->ProdutoBarra->UnidadeMedida->sigla;
				if (isset($data->ProdutoBarra->ProdutoEmbalagem))
				{
					echo " C/" . Yii::app()->format->formatNumber($data->ProdutoBarra->ProdutoEmbalagem->quantidade, 0);
					$precounitario /=$data->ProdutoBarra->ProdutoEmbalagem->quantidade;
				}
			?>
		</small>

		<small class="span3 text-right muted">
			<?php echo CHtml::encode(Yii::app()->format->formatNumber($data->valorunitario)); ?>
		</small>

		<small class="span3 text-right"><?php echo CHtml::encode(Yii::app()->format->formatNumber($precounitario)); ?></small>

	</div>
	
	
	
	
		<small class="span1 muted"><?php echo CHtml::encode($data->codprodutobarra); ?></small>
		<small class="span1 muted"><?php echo CHtml::encode($data->ProdutoBarra->barras); ?></small>
		
		<small class="span1 muted"><?php echo CHtml::link(Yii::app()->format->formataCodigo(CHtml::encode($data->Negocio->codnegocio)), array('negocio/view','id'=>$data->Negocio->codnegocio)); ?></small>
		
		

</div>
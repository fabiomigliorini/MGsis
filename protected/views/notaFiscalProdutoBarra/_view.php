<div class="registro row-fluid">
		<small class="span4 muted">

			<div class="span2"><?php echo CHtml::encode($data->NotaFiscal->saida); ?></div>

			<div class="span2"><?php echo CHtml::encode($data->NotaFiscal->Filial->filial); ?></div>

			<div class="span2"><?php echo CHtml::encode($data->NotaFiscal->NaturezaOperacao->naturezaoperacao); ?></div>

			<div class="span6">
				<?php echo CHtml::link(CHtml::encode($data->NotaFiscal->Pessoa->fantasia), array('pessoa/view','id'=>$data->NotaFiscal->Pessoa->codpessoa)); ?>
			</div>	
		</small>

		<div class="span5">
		
			<small class="span2 text-right"><?php echo CHtml::encode(Yii::app()->format->formatNumber($data->quantidade)); ?></small>

			<small class="span2 muted">
				<?php
					$precounitario = ($data->valortotal + $data->icmsstvalor + $data->ipivalor);
					if ($data->quantidade > 0)
						$precounitario = $precounitario/$data->quantidade;
					$ipi = '';
					$icmsst = '';
					if ($data->valortotal > 0)
					{
						$ipi = $data->ipivalor/$data->valortotal;
						$icmsst = $data->icmsstvalor/$data->valortotal;
					}
					echo $data->ProdutoBarra->UnidadeMedida->sigla;
					if (isset($data->ProdutoBarra->ProdutoEmbalagem))
					{
						echo " C/" . Yii::app()->format->formatNumber($data->ProdutoBarra->ProdutoEmbalagem->quantidade, 0);
						$precounitario /=$data->ProdutoBarra->ProdutoEmbalagem->quantidade;
					}
				?>
			</small>

			<small class="span2 text-right muted">
				<?php echo CHtml::encode(Yii::app()->format->formatNumber($data->valorunitario)); ?>
			</small>
			<small class="span2 text-right muted">
				<?php 
				if ($ipi>0)
					echo CHtml::encode(Yii::app()->format->formatNumber($ipi*100, 0)) . ' % IPI'; 
				?>
			</small>
			<small class="span2 text-right muted">
				<?php 
				if ($icmsst>0)
					echo CHtml::encode(Yii::app()->format->formatNumber($icmsst*100, 0)) . ' % ST'; 
				?>
			</small>
			
			<small class="span2 text-right"><?php echo CHtml::encode(Yii::app()->format->formatNumber($precounitario)); ?></small>
			
		</div>	
			
		<div class="span3">
			<small class="span6">
					<?php echo CHtml::link(CHtml::encode(Yii::app()->format->formataNumeroNota($data->NotaFiscal->emitida, $data->NotaFiscal->serie, $data->NotaFiscal->numero, $data->NotaFiscal->modelo)),array('notaFiscal/view','id'=>$data->NotaFiscal->codnotafiscal)); ?>			
			</small>

			<small class="span2 muted"><?php echo CHtml::encode($data->ProdutoBarra->barras); ?></small>
		</div>

		<?php /*
		 * 
		 * 
		
		<small class="span1 muted text-right"><?php echo CHtml::encode($data->ProdutoBarra->ProdutoEmbalagem->UnidadeMedida->sigla); ?></small>
		
		
		<small class="span1 muted text-right"><?php echo CHtml::encode($data->NotaFiscal->serie); ?></small>
		
		<small class="span1 muted "><?php echo CHtml::encode($data->NotaFiscal->numero); ?></small>
		
		<small class="span1 muted "><?php echo CHtml::encode($data->ProdutoBarra->barras); ?></small>
		 * 
		 * 
		 * 
		 * 
		 * 
		 * 
		 * 
		 * 
		 * 
		 * 
 		<small class="span1 muted"><?php echo CHtml::encode($data->codnotafiscal); ?></small>
 
		<small class="span2 muted"><?php echo CHtml::encode($data->codprodutobarra); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->codcfop); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->descricaoalternativa); ?></small>


		<small class="span2 muted"><?php echo CHtml::encode($data->valorunitario); ?></small>
		 
		<small class="span2 muted"><?php echo CHtml::encode($data->valortotal); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->icmsbase); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->icmspercentual); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->icmsvalor); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->ipibase); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->ipipercentual); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->ipivalor); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->icmsstbase); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->icmsstpercentual); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->icmsstvalor); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->csosn); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->codnegocioprodutobarra); ?></small>

		*/ ?>
</div>

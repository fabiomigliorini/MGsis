<div class="registro row-fluid">
	<b class="span1">
		<?php echo CHtml::link(CHtml::encode(Yii::app()->format->formataCodigo($data->codnotafiscalprodutobarra)),array('view','id'=>$data->codnotafiscalprodutobarra)); ?>
	</b>
		<small class="span1"><?php echo CHtml::encode($data->NotaFiscal->emissao); ?></small>
				
		<b class="span1"><?php echo CHtml::encode($data->NotaFiscal->Filial->filial); ?></b>
		
		<small class="span1"><?php echo CHtml::encode($data->NotaFiscal->NaturezaOperacao->naturezaoperacao); ?></small>
		
		<b class="span4"><?php echo CHtml::encode($data->NotaFiscal->Pessoa->pessoa); ?></b>

		<small class="span1 text-right"><?php echo CHtml::encode(Yii::app()->format->formatNumber($data->quantidade)); ?></small>

		<small class="span1 text-right"><?php echo CHtml::encode(Yii::app()->format->formatNumber($data->valortotal)); ?></small>
		
		<small class="span1 text-right">
			<?php
				echo $data->ProdutoBarra->UnidadeMedida->sigla;
				if (isset($data->ProdutoBarra->ProdutoEmbalagem))
					echo " C/" . Yii::app()->format->formatNumber($data->ProdutoBarra->ProdutoEmbalagem->quantidade, 0);
			?>
		</small>

		<small class="span1 text-right"><?php echo CHtml::encode(Yii::app()->format->formatNumber($data->valorunitario)); ?></small>
		<div>
		<b class="span2">
				<?php echo CHtml::link(CHtml::encode(Yii::app()->format->formataNumeroNota($data->NotaFiscal->emitida, $data->NotaFiscal->serie, $data->NotaFiscal->numero, $data->NotaFiscal->modelo)),array('notaFiscal/view','id'=>$data->NotaFiscal->codnotafiscal)); ?>			
		</b>
		
		<small class="span1"><?php echo CHtml::encode($data->ProdutoBarra->barras); ?></small>
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
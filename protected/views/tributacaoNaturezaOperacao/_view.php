<div class="registro row-fluid">
	
		<small class="span1"><?php echo CHtml::link(CHtml::encode(Yii::app()->format->formataCodigo($data->codtributacaonaturezaoperacao)),array('tributacaoNaturezaOperacao/view','id'=>$data->codtributacaonaturezaoperacao)); ?></small>
	
		
		<b class="span1"><?php echo CHtml::link(CHtml::encode($data->Tributacao->tributacao),array('tributacao/view','id'=>$data->codtributacao)); ?></b>
	
		<b class="span2"><?php echo CHtml::encode($data->TipoProduto->tipoproduto); ?></b>

		<b class="span1"><?php echo CHtml::encode((isset($data->Estado)?$data->Estado->sigla:"")); ?></b>
		
		<small class="span4">
			<?php echo CHtml::encode($data->codcfop); ?> -
			<?php echo CHtml::encode($data->Cfop->cfop); ?>
		</small>

		<small class="span1"><?php echo CHtml::encode($data->csosn); ?></small>

		<?php /*
 
 		<b class="span2 muted"><?php echo CHtml::link(CHtml::encode($data->NaturezaOperacao->naturezaoperacao),array('naturezaOperacao/view','id'=>$data->codnaturezaoperacao)); ?></b>

		<small class="span1 muted"><?php echo CHtml::encode($data->acumuladordominiovista); ?></small>
		
		<small class="span1 muted"><?php echo CHtml::encode($data->acumuladordominioprazo); ?></small>
				
		<small class="span1 muted"><?php echo CHtml::encode($data->icmsbase); ?></small>

		<small class="span1 muted"><?php echo CHtml::encode($data->icmspercentual); ?></small>		

		<small class="span2 muted"><?php echo CHtml::encode($data->historicodominio); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->movimentacaofisica); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->movimentacaocontabil); ?></small>

		*/ ?>
</div>
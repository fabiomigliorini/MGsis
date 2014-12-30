<div class="registro row-fluid">
	
	<div class="span4">
		<small class="span2">
			<?php echo CHtml::link(CHtml::encode(Yii::app()->format->formataCodigo($data->codtributacaonaturezaoperacao)),array('tributacaoNaturezaOperacao/view','id'=>$data->codtributacaonaturezaoperacao)); ?>
		</small>
		<b class="span3">
			<?php echo CHtml::encode($data->Tributacao->tributacao); ?>
		</b>
		<b class="span3">
			<?php echo CHtml::encode($data->TipoProduto->tipoproduto); ?>
		</b>
		<b class="span1">
			<?php echo CHtml::encode((isset($data->Estado)?$data->Estado->sigla:"")); ?>
		</b>
		<b class="span3">
			<?php echo CHtml::encode($data->ncm); ?>
		</b>
	</div>
	
	<div class="span3">
		<b class="span2">
			<?php echo CHtml::link(CHtml::encode(Yii::app()->format->formatNumber($data->codcfop, 0)),array('cfop/view','id'=>$data->codcfop)); ?>
		</b>
		<small class="span10 muted">
			<?php echo CHtml::encode($data->Cfop->cfop); ?>
		</small>
	</div>


	<small class="span5">
		<div class="row-fluid">
			<div class="span2">
				<b class="pull-left">
					Simples:
				</b>
				<div class="pull-right text-right">
					<?php echo CHtml::encode($data->csosn); ?><br>
					<?php echo CHtml::encode($data->icmsbase); ?><br>
					<?php echo CHtml::encode($data->icmspercentual); ?>
				</div>
			</div>
			<div class="span2">
				<b class="pull-left">
					ICMS:
				</b>
				<div class="pull-right text-right">
					<?php echo CHtml::encode($data->icmscst); ?><br>
					<?php echo CHtml::encode($data->icmslpbase); ?><br>
					<?php echo CHtml::encode($data->icmslppercentual); ?>
				</div>
			</div>
			<div class="span2">
				<b class="pull-left">
					PIS:
				</b>
				<div class="pull-right text-right">
					<?php echo CHtml::encode($data->piscst); ?><br>
					<?php echo CHtml::encode($data->pispercentual); ?>
				</div>
			</div>
			<div class="span2">
				<b class="pull-left">
					Cofins:
				</b>
				<div class="pull-right text-right">
					<?php echo CHtml::encode($data->cofinscst); ?><br>
					<?php echo CHtml::encode($data->cofinspercentual); ?>
				</div>
			</div>
			<div class="span2">
				<b class="pull-left">
					IPI:<br>
					CSLL:<br>
					IRPJ:
				</b>
				<div class="pull-right text-right">
					<?php echo CHtml::encode($data->ipicst); ?><br>
				<?php echo CHtml::encode($data->csllpercentual); ?><br>
				<?php echo CHtml::encode($data->irpjpercentual); ?>
				</div>
			</div>
		</div>
	</small>

		<?php /*
					<?php echo CHtml::encode($data->icmscst); ?>
 
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
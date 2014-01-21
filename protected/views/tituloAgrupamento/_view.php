<div class="registro <?php echo (!empty($data->cancelamento))?"alert-danger":""; ?>">
	<div class="row-fluid">
		<small class="span1">
			<?php echo CHtml::link(CHtml::encode(Yii::app()->format->formataCodigo($data->codtituloagrupamento)),array('view','id'=>$data->codtituloagrupamento)); ?>
		</small>
		<small class="span1 muted"><?php echo CHtml::encode($data->emissao); ?></small>
		<b class="span4">
			<?php
			if (isset($data->Titulos[0]))
			{
				echo CHtml::link(CHtml::encode($data->Titulos[0]->Pessoa->fantasia),array('pessoa/view','id'=>$data->Titulos[0]->codpessoa));
			}
			?>
		</b>
		<b class="span2 text-right">
			<?php 
			$total = Yii::app()->format->formatNumber($data->calculaTotal());
			echo CHtml::encode($total);
			?>
		</b>
		<small class="span1 muted">
			<?php 
			echo ($total<0)?"CR":"DB";
			?>
		</small>
		<small class="span3 muted"><?php echo CHtml::encode($data->observacao); ?></small>
	</div>
</div>
<div class="registro row-fluid">
	<b class="span1">
		<?php echo CHtml::link(CHtml::encode(Yii::app()->format->formataCodigo($data->codsubgrupoproduto)),array('subGrupoProduto/view','id'=>$data->codsubgrupoproduto)); ?>
	</b>
	
		<small class="span2"><?php echo CHtml::encode($data->subgrupoproduto); ?></small>

		<small class="span9 muted"><?php echo CHtml::encode($data->GrupoProduto->grupoproduto); ?></small>

</div>
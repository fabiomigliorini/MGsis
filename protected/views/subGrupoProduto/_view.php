<div class="registro row-fluid">
	<small class="span1 muted"><?php echo CHtml::encode(Yii::app()->format->formataCodigo($data->codsubgrupoproduto)); ?></small>
		
	<b class="span11"><?php echo CHtml::link(CHtml::encode($data->subgrupoproduto),array('subGrupoProduto/view','id'=>$data->codsubgrupoproduto)); ?> </b>
		
</div>
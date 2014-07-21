<div class="registro row-fluid">
	<b class="span2">
		<?php echo CHtml::encode($data->getAttributeLabel('codprodutohistoricopreco')); ?>:
		<?php echo CHtml::link(CHtml::encode(Yii::app()->format->formataCodigo($data->codprodutohistoricopreco)),array('view','id'=>$data->codprodutohistoricopreco)); ?>
	</b>
	
		<small class="span2 muted"><?php echo CHtml::encode($data->codproduto); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->codprodutoembalagem); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->codusuario); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->precoantigo); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->preconovo); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->data); ?></small>

</div>
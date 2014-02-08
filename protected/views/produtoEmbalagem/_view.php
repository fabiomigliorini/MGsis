<div class="registro row-fluid">
	<div class="span4">
		<?php echo Chtml::encode($data->descricao) ?>
	</div>
	<div class="span4 text-right">
		<?php echo Chtml::encode(Yii::app()->format->formatNumber($data->preco)) ?>
	</div>
	<div class="span4 text-right">
		<a href="<?php echo Yii::app()->createUrl('produtoEmbalagem/update', array('id'=>$data->codprodutoembalagem)); ?>"><i class="icon-pencil"></i></a>
		<a class="delete-embalagem" href="<?php echo Yii::app()->createUrl('produtoEmbalagem/delete', array('id'=>$data->codprodutoembalagem)); ?>"><i class="icon-trash"></i></a>
	</div>
</div>
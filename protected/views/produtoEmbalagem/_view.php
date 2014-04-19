<div class="registro row-fluid">
	<div class="span4">
		<?php echo Chtml::encode($data->descricao) ?>
	</div>
	<?php if (empty($data->preco)): ?>
		<div class="span4 text-right muted">
			<?php echo Chtml::encode(Yii::app()->format->formatNumber($produto->preco * $data->quantidade)); ?>
		</div>
	<?php else: ?>
		<div class="span4 text-right text-success">
			<?php echo Chtml::encode(Yii::app()->format->formatNumber($data->preco)); ?>
		</div>	
	<?php endif; ?>
	<div class="span4 text-right">
		<a href="<?php echo Yii::app()->createUrl('produtoEmbalagem/update', array('id'=>$data->codprodutoembalagem)); ?>"><i class="icon-pencil"></i></a>
		<a class="delete-embalagem" href="<?php echo Yii::app()->createUrl('produtoEmbalagem/delete', array('id'=>$data->codprodutoembalagem)); ?>"><i class="icon-trash"></i></a>
	</div>
</div>
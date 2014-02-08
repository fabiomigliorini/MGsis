<div class="registro row-fluid">
	<div class="span2">
		<?php if (isset($data->ProdutoEmbalagem)): ?>
			<?php echo Chtml::encode($data->ProdutoEmbalagem->descricao) ?>
		<?php else: ?>
			<?php echo Chtml::encode($produto->UnidadeMedida->sigla) ?>
		<?php endif; ?>
	</div>
	<div class="span2">
		<?php echo Chtml::encode($data->barras) ?> 
	</div>
	<div class="span3">
		<?php echo Chtml::encode($data->variacao) ?> 
	</div>
	<div class="span2">
		<?php echo Chtml::encode($data->referencia) ?> 
	</div>
	<div class="span2">
		<?php echo isset($data->Marca)?Chtml::encode($data->Marca->marca):""; ?> 
	</div>
	<div class="span1 text-right">
		<a href="<?php echo Yii::app()->createUrl('produtoBarra/update', array('id'=>$data->codprodutobarra)); ?>"><i class="icon-pencil"></i></a>
		<a class="delete-barra" href="<?php echo Yii::app()->createUrl('produtoBarra/delete', array('id'=>$data->codprodutobarra)); ?>"><i class="icon-trash"></i></a>
	</div>
</div>

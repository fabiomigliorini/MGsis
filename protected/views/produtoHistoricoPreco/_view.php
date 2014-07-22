<div class="registro row-fluid">

		<div class="span4">
	
			<small class="span2 muted"><?php echo CHtml::encode(Yii::app()->format->formataCodigo($data->codproduto, 6)); ?></small>

			<small class="span10"><b><?php echo CHtml::link(CHtml::encode($data->Produto->produto),array('produto/view','id'=>$data->codproduto)); ?></b></small>
		
		</div>
		
		<div class="span4">
			<small class="span3 text-center">
				<?php
					if (isset($data->ProdutoEmbalagem))
					{
						echo $data->ProdutoEmbalagem->UnidadeMedida->sigla;
						echo " C/" . Yii::app()->format->formatNumber($data->ProdutoEmbalagem->quantidade, 0);
					}
					else
					{
						echo $data->Produto->UnidadeMedida->sigla;
					}
				?>
			</small>

			<small class="span6 muted"><?php echo CHtml::encode($data->Produto->referencia); ?></small>

			<small class="span3 muted"><?php echo CHtml::link(CHtml::encode($data->Produto->Marca->marca), array('marca/view','id'=>$data->codmarca)); ?></small>
		
		</div>	
			
		<div class="span2 text-right">
			<b class="span4 text-success">
				<?php
					if (isset($data->ProdutoEmbalagem))
					{
						$data->ProdutoEmbalagem->preco;
					}
					else
					{
						echo (Yii::app()->format->formatNumber($data->Produto->preco));
					}
				?>
			</b>

			<small class="span4 text-warning"><?php echo CHtml::encode(Yii::app()->format->formatNumber($data->preconovo)); ?></small>

			<small class="span4 muted text-error" style="text-decoration: line-through"><?php echo CHtml::encode(Yii::app()->format->formatNumber($data->precoantigo)); ?></small>
		
		</div>
		
		<div class="span2">
		
			<small class="span4 muted"><?php echo CHtml::link(CHtml::encode($data->UsuarioCriacao->usuario),array('usuario/view','id'=>$data->codusuariocriacao)); ?></small>

			<small class="span8 muted"><?php echo CHtml::encode($data->alteracao); ?></small>
		
		</div>	

</div>
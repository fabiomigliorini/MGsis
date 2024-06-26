<div class="registro <?php echo (!empty($data->inativo))?"alert-danger":""; ?>">
	<div class="row-fluid">
		<div class="span1">
			<b><?php echo CHtml::link(CHtml::encode(Yii::app()->format->formataCodigo($data->codproduto, 6)),array('view','id'=>$data->codproduto)); ?></b>
			<small class="muted">
				<?php 
				if (isset($data->codncm))
					echo CHtml::link(CHtml::encode(Yii::app()->format->formataNcm($data->Ncm->ncm)),array('ncm/view','id'=>$data->codncm)); 
				?>
			</small>
			<small class="muted"><?php echo CHtml::encode($data->Tributacao->tributacao); ?></small>
		</div>
	
		<div class="span4">
			<b><?php echo CHtml::link(CHtml::encode($data->produto),array('view','id'=>$data->codproduto)); ?></b>
				<?php if (!empty($data->inativo)): ?>
					<span class="label label-important pull-right">Inativado em <?php echo CHtml::encode($data->inativo); ?></span>
				<?php endif; ?>
			
			<br>
			<small class="muted">
				<b><?php echo CHtml::encode((!empty($data->codsubgrupoproduto))?$data->SubGrupoProduto->GrupoProduto->grupoproduto . " > ". $data->SubGrupoProduto->subgrupoproduto:""); ?></b><br>
				<b><?php echo CHtml::link(CHtml::encode((!empty($data->codmarca))?$data->Marca->marca:""), array('marca/view','id'=>$data->codmarca)); ?></b>
				<?php echo CHtml::encode($data->referencia); ?>
			</small>			
		</div>
		<div class="span7">
			<?php 
			$this->renderPartial('_view_produtoembalagem', array('data'=>$data));
			foreach ($data->ProdutoEmbalagems as $pe)
			{
				$this->renderPartial('_view_produtoembalagem', array('data'=>$data, 'pe'=>$pe));
			}
			?>
		</div>

		<?php /*
		<small class="span2 muted"><?php echo CHtml::encode($data->importado); ?></small>
		<small class="span2 muted"><?php echo CHtml::encode($data->codtipoproduto); ?></small>
		<small class="span2 muted"><?php echo CHtml::encode($data->site); ?></small>
		<small class="span2 muted"><?php echo CHtml::encode($data->descricaosite); ?></small>

		*/ ?>
	</div>
</div>
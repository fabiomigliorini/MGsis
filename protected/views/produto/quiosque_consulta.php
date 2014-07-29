<?php
$this->breadcrumbs=array(
	'Consulta de Produtos',
);
?>

<script>

function pesquisaProduto()
{
	$('#produto-form').submit();
}
	
$(document).ready(function() {

	$("#barras").focus();
	
    $("#btnOK").click(function(e){ 
		e.preventDefault();
		pesquisaProduto (); 
	});
	
	$('#codprodutobarra').change(function(e) { 
		if ($("#codprodutobarra").select2('data') != null)
		{
			$("#barras").val($("#codprodutobarra").select2('data').barras);
			window.setTimeout(function(){$('#barras').focus();}, 0);
			$('#codprodutobarra').select2('data', null);
			pesquisaProduto ();
		}
	});
});
	
</script>

<?php $form=$this->beginWidget('MGActiveForm',array(
	'id'=>'produto-form',
	//'method'=>'get',
)); ?>
	<div class="row-fluid">
		<div class="span3">
			<div class="input-append">
				<input class="input-large text-right" name="barras" id="barras" type="text">
				<button class="btn" type="submit" id="btnOK" tabindex="-1">OK</button>
			</div>
		</div>
		<div class="span9">
			<?php
			$this->widget('MGSelect2ProdutoBarra', 
				array(
					'name' => 'codprodutobarra', 
					'htmlOptions' => array(
						'class' => 'span12', 
						'placeholder' => 'Pesquisa de Produtos ($ ordena por preço)'
						),
					)
				); 
			?>
		</div>
	</div>
<?php $this->endWidget(); ?>
<?php if ($model): ?>
	<div>
		<div class="span6">
			<h2>
				<?php echo CHtml::encode($model->descricao) ?>
			</h2>
			<h3 class="row-fluid">
				<div class="span4">
					<small class="muted">Marca:</small><br>
					<?php if (isset($model->Produto->Marca)): ?>
						<?php echo CHtml::encode($model->Produto->Marca->marca) ?>
					<?php endif; ?>
				</div>
				<div class="span8">
					<small class="muted">Referência:</small><br>
					<?php echo CHtml::encode($model->Produto->referencia) ?>
				</div>
			</h3>
			<div>
			<?php
				$this->renderPartial(
					'_view_imagens',
					array(
						'model'=>$model->Produto,
					)
				);

			?>
			</div>
		</div>
		<div class="span5">
			<div class="alert alert-success text-right">
				<div class="row-fluid">
					<div class="span1">
						<?php echo CHtml::encode($model->UnidadeMedida->sigla) ?>
					</div>
					<b class="span11" style="font-size: 700%; line-height: 100%">
						<?php echo CHtml::encode(Yii::app()->format->formatNumber($model->preco)) ?>
					</b>
				</div>
			</div>
			
			<div class="well well-small">
				
				<div class="row-fluid">
					<div class='span5'>
						<div class='row-fluid'>
							<div class="pull-left">
								<?php echo CHtml::encode($model->Produto->UnidadeMedida->unidademedida) ?>
							</div>
							<div class="pull-right">
								<small class='muted'>R$</small> 
								<b><?php echo CHtml::encode(Yii::app()->format->formatNumber($model->Produto->preco)) ?></b>
							</div>
							
						</div>
					</div>
					
					<div class="span7">
						<?php
						foreach ($model->Produto->ProdutoBarras as $pb)
						{
							if (!empty($pb->codprodutoembalagem))
								continue;
							?>
							<div class="row-fluid">
								<div class='pull-left muted'>
									<?php echo CHtml::encode($pb->barras); ?>
								</div>
								<div class='pull-right'>
									<?php echo CHtml::encode($pb->variacao); ?>
								</div>
							</div>
							<?php
						}
						?>
					</div>
				</div>
				
				<br>
				<?php
				foreach ($model->Produto->ProdutoEmbalagems as $pe)
				{
					?>
					<div class="row-fluid">
						<b class="span3">
							<?php echo CHtml::encode($pe->UnidadeMedida->unidademedida) ?>
							com
							<?php echo CHtml::encode(Yii::app()->format->formatNumber($pe->quantidade, 0)) ?>
						</b>
						<b class="span2 text-right">
							R$ <?php echo CHtml::encode(Yii::app()->format->formatNumber((empty($pe->preco))?$pe->preco_calculado:$pe->preco)) ?>
						</b>
						<div class="span7">
							<?php
							foreach ($pe->ProdutoBarras as $pb)
							{
								?>
								<div class="row-fluid">
									<div class='pull-left muted'>
										<?php echo CHtml::encode($pb->barras); ?>
									</div>
									<div class='pull-right'>
										<?php echo CHtml::encode($pb->variacao); ?>
									</div>
								</div>
								<?php
							}
							?>
						</div>
					</div>
					<?
				}
				?>
			</div>
		</div>

	</div>
<?php else: ?>
	<div>Produto <?php echo CHtml::encode($barras); ?> não localizado!</div>
<?php endif; ?>


	

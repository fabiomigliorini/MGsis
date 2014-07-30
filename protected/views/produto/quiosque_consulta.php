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
	
	$("#barras").blur(function() {
		if (!$("#codprodutobarra").select2("isFocused"))
			$("#barras").focus();
	});
	
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

<style>
	div {
		border: 1px dotted blue;
	}
</style>

<div class='row-fluid'>
	<div class='row-fluid'>
		<div class='span5'>
			campo1
		</div>
		<div class='span7'>
			campo2
		</div>
	</div>
	<div class='row-fluid'>
		<div class='span6'>
			Detalhes
		</div>
		<div class='span6'>
			Preço
		</div>
	</div>
</div>

<hr>
<hr>
<hr>
<hr>


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
						'class' => 'span10 pull-right', 
						'placeholder' => 'Pesquisa de Produtos ($ ordena por preço)'
						),
					)
				); 
			?>
		</div>
	</div>
<?php $this->endWidget(); ?>
<?php if ($model): ?>
<div class="">
		<div class="span6">
			<h2 class="text-error">
				<?php echo CHtml::encode($model->descricao) ?>
				<small><?php echo CHtml::encode($model->UnidadeMedida->sigla) ?></small>
			</h2>
			<div class="row-fluid" style="border-top: 1px solid lightgray; border-bottom: 1px solid lightgray">
				<div class="span2">
					<small class="muted">Código:</small><br>
					<?php echo CHtml::link(CHtml::encode(Yii::app()->format->formataCodigo($model->codproduto, 6)), array('produto/view', 'id'=>$model->codproduto));?>
				</div>
				<?php if (isset($model->Produto->Marca)): ?>
					<div class="span4">
						<small class="muted">Marca:</small><br>
							<?php echo CHtml::encode($model->Produto->Marca->marca); ?>
					</div>
				<?php endif; ?>
				<?php if (isset($model->Produto->referencia)): ?>
					<div class="span6">
						<small class="muted">Referência:</small><br>
						<?php echo CHtml::encode($model->Produto->referencia) ?>
					</div>
				<?php endif; ?>
			</div>
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
		<div class="span6 ">
			<div class="text-right alert alert-success">
				<div class="row-fluid">
					<div class="span12">
						<div class="span1 muted" style="font-size: 250%; line-height: 100%">
							<br>
							R$
						</div>
						<b class="span11" style="font-size: 700%; line-height: 100%">
							<?php echo CHtml::encode(Yii::app()->format->formatNumber($model->preco)) ?>
						</b>
					</div>	
				</div>
			</div>
			
			<div class="alert alert-info">
				<div class="row-fluid">
					<small class="span3 muted">
						<?php echo CHtml::encode($model->Produto->UnidadeMedida->unidademedida) ?>
					</small>
					<div class="span3">
						<small class='muted pull-left'>R$</small> 
						<b class='pull-right'><?php echo CHtml::encode(Yii::app()->format->formatNumber($model->Produto->preco)) ?></b>
					</div>
					<div class="span6">
						<?php
						foreach ($model->Produto->ProdutoBarras as $pb)
						{
							if (!empty($pb->codprodutoembalagem))
								continue;
							?>
							<small class="row-fluid">
								<div class='pull-left muted'>
									<?php echo CHtml::encode($pb->barras); ?>
								</div>
								<div class='pull-right'>
									<?php echo CHtml::encode($pb->variacao); ?>
								</div>
							</small>
							<?php
						}
						?>
					</div>
				</div>
				
				<?php
				foreach ($model->Produto->ProdutoEmbalagems as $pe)
				{
					?>
					<div class="row-fluid" style="border-top: 1px solid lightgray">
						<small class="span3 muted">
							<?php echo CHtml::encode($pe->UnidadeMedida->unidademedida) ?>
							<?php echo CHtml::encode($pe->descricao) ?>
						</small>
						<div class="span3">
							<small class='muted pull-left'>R$</small> 
							<b class='pull-right'><?php echo CHtml::encode(Yii::app()->format->formatNumber((empty($pe->preco))?$pe->preco_calculado:$pe->preco)) ?></b>
						</div>
						<div class="span6">
							<?php
							foreach ($pe->ProdutoBarras as $pb)
							{
								?>
								<div class="row-fluid">
									<small class='pull-left muted'>
										<?php echo CHtml::encode($pb->barras); ?>
									</small>
									<small class='pull-right'>
										<?php echo CHtml::encode($pb->variacao); ?>
									</small>
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
	<br>
	<br>
	<br>
	<br>
	<br>
	<div class="span11 alert alert-error text-center">
		<br>
		<br>
		<br>
		<br>
		<br>
		<h1>
			Produto <?php echo CHtml::encode($barras); ?> não localizado!
		</h1>
		<br>
		<br>
		<br>
		<br>
		<br>
	</div>
<?php endif; ?>


	

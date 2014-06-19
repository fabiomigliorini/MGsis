<?php
/*
 * @var Titulo $titulo
 */

if (!empty($model->NegocioFormaPagamentos))
{
	/*
	?>
	<div class="alert">Nenhum Pagamento foi informado para este negócio!</div>
	<?php
	 * 
	 */
	?>
	<h3>Forma de Pagamento</h3>
	<?php
}

foreach ($model->NegocioFormaPagamentos as $nfp)
{
	?>
	<div class="registro">
		<span class="row-fluid">
			<div class="span2 text-right">
				<?php echo Yii::app()->format->formatNumber($nfp->valorpagamento); ?> 
			</div>
			<b class="span4">
				<?php echo CHtml::encode($nfp->FormaPagamento->formapagamento); ?> 
			</b>
			<small class="span6">
				<?php 
				
				foreach ($nfp->Titulos as $titulo)
				{
					?>
					<div class="row-fluid">
						<div class="span4">
							<?php 
								echo CHtml::link(
									CHtml::encode($titulo->numero)
									, array('titulo/view', 'id'=> $titulo->codtitulo)); 
							?>
						</div>
						<b class="span2">
							<?php echo CHtml::encode($titulo->vencimento); ?>
						</b>
						<b class="span3 text-right">
							<?php echo Yii::app()->format->formatNumber($titulo->valor); ?> 
						</b>
						<div class="span3 text-right">
							<?php echo Yii::app()->format->formatNumber($titulo->saldo); ?> 
						</div>
					</div>
					<?php
				}
				?> 
			</small>
		</span>
	</div>
	<?
}


?> 

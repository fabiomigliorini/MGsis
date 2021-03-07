<div class="well">
	<div class="muted">
		<div class="span5">
			Produtos
			<div class="badge pull-right">
				<?php
				$qtd =  Yii::app()->db->createCommand("SELECT sum(quantidade) FROM tblnegocioprodutobarra WHERE codnegocio = '$model->codnegocio'")->queryScalar();
				if (!empty($qtd))
					echo Yii::app()->format->formatNumber($qtd, 0);
				else
					echo "0";
				?>
			</div>
		</div>
		<strong class="span7 text-right <?php echo ($model->valorprodutos != $model->valortotal)?"text-warning":"text-success"; ?>" style="font-size: <?php echo ($model->valorprodutos != $model->valortotal)?"x-large":"xx-large"; ?>">
			R$
			<?php echo Yii::app()->format->formatNumber($model->valorprodutos); ?>
		</strong>
	</div>
	<?php
	if ($model->valorprodutos > 0 && $model->valordesconto >0):
	?>
	<div class=" muted">
		<div class="span5">
			Desconto
			<div class="badge pull-right">
				<?php echo Yii::app()->format->formatNumber($model->percentualdesconto, 1);	?>
				%
			</div>
		</div>
		<strong class="span7 text-right" style="font-size: x-large">
			R$
			- <?php echo Yii::app()->format->formatNumber($model->valordesconto); ?>
		</strong>
	</div>
	<?php
	endif;
	?>	
        <?php
        if ($model->valorfrete > 0):
        ?>
        <div class=" muted">
                <div class="span5">
                        Frete
			<?php
			if (!empty($model->codpessoatransportador)):
			?>
			<div class="badge pull-right" style="max-width: 50%; text-overflow: ellipsis; overflow: hidden;">
                                <?php echo $model->PessoaTransportador->fantasia;     ?>
                        </div>
			<?php
			endif;
			?>
                </div>
                <strong class="span7 text-right" style="font-size: x-large">
                        R$
                        <?php echo Yii::app()->format->formatNumber($model->valorfrete); ?>
                </strong>
        </div>
        <?php
        endif;
        ?>
	<?php
	if ($model->valorprodutos != $model->valortotal):
	?>
	<hr>
	<div class="row-fluid muted">
		Total
		<strong class="pull-right text-success" style="font-size: xx-large">
			R$ <?php echo Yii::app()->format->formatNumber($model->valortotal); ?>
		</strong>
	</div>
	<?php
	endif;
	?>	
</div>

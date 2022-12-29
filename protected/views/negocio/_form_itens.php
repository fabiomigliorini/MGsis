<?php if(count($itens) > 0): ?>
	<br />
	<h5>Itens que serão copiados:</h5>
<?php endif; ?>

<?php
foreach ($itens as $item)
{
	?>
	<div class="registro row-fluid">
			<label>
				<small class="span1">
					<input
                        type="checkbox"
                        id="codnegocioprodutobarraduplicar_<?echo $item->codnegocioprodutobarra?>"
                        name="codnegocioprodutobarraduplicar[<?echo $item->codnegocioprodutobarra?>]"
                        <?php echo (isset($codnegocioprodutobarraduplicar[$item->codnegocioprodutobarra]))?'checked':''; ?>
                    >
				</small>
                <div class="span7" style="text-overflow: ellipsis;">
                    <small class="text-muted">
                        <?php echo CHtml::encode($item->barras) ?>
                    </small>
                    -
					<?php echo CHtml::encode($item->descricao) ?>
				</div>
				<div class="span2 text-right">
					<?php echo Yii::app()->format->formatNumber($item->quantidade, 0); ?>
				</div>
				<div class="span2 text-right">
					<b><?php echo Yii::app()->format->formatNumber($item->valorunitario); ?></b>
				</div>
			</label>
	</div>
	<?
}

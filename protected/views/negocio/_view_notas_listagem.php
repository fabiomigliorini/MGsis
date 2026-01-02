<?php

$command = Yii::app()->db->createCommand('
	SELECT DISTINCT nfpb.codnotafiscal
	  FROM tblNegocioProdutoBarra npb
	 INNER JOIN tblNotaFiscalProdutoBarra nfpb ON (nfpb.codnegocioprodutobarra = npb.codnegocioprodutobarra)
	 WHERE npb.codnegocio = :codnegocio
	 ORDER BY nfpb.codnotafiscal
	');

$command->params = array("codnegocio" => $model->codnegocio);

$codnotas = $command->queryAll();

if (!empty($codnotas))
{
	/*
	?>
	<div class="alert">Nenhuma Nota Fiscal foi gerada para este negócio!</div>
	<?php
	 *
	 */
	?>
	<h3>Nota Fiscal</h3>
	<?php
}

foreach ($codnotas as $codnota)
{
	$nota = NotaFiscal::model()->findByPk($codnota);

	$css_label = "";
	$staus = "&nbsp";
	$css = "";

	switch ($nota->status)
	{
		case 'DIG': // Em Digitação
			$css_label = "label-warning";
			break;

		case 'AUT': // Autorizada
			$css_label = "label-success";
			break;

		case 'LAN': // Lançada
			$css_label = "label-info";
			break;

		case 'ERR': // Não Autorizada
			$css = "alert-info";
			break;

		case 'INU': // Inutilizada
			$css = "alert-danger";
			$css_label = "label-important";
			break;

		case 'CAN': // Cancelada
			$css = "alert-danger";
			$css_label = "label-important";
			break;

	}

	$staus = $nota->getStatusDescricao();
	?>
	<div class="registro <?php echo $css; ?>">
		<span class="row-fluid">
			<small class="span1 muted">
				<?php echo CHtml::encode($nota->Filial->filial); ?>
			</small>
			<div class="span2">
				<?php echo CHtml::link(CHtml::encode(Yii::app()->format->formataNumeroNota($nota->emitida, $nota->serie, $nota->numero, $nota->modelo)),array('notaFiscal/view','id'=>$nota->codnotafiscal)); ?>
				<small class="muted"><?php echo CHtml::encode($nota->emissao); ?></small>
			</div>
			<div class="span4">
				<?php echo CHtml::link(
					CHtml::encode($nota->Pessoa->fantasia)
					, array('pessoa/view', 'id'=> $nota->codpessoa));
				?><br>
				<small class="muted">
					<?php echo CHtml::encode($nota->NaturezaOperacao->naturezaoperacao); ?>
				</small>
			</div>
			<div class="span1 text-right muted">
				<?php echo Yii::app()->format->formatNumber($nota->valortotal); ?>
			</div>
			<div class="span2">
				<div class="label <?php echo $css_label; ?> pull-right">
					<?php echo $staus; ?>
				</div>
			</div>
			<div class="span2">
				<?php $this->widget('MGNotaFiscalBotoes', array('model'=>$nota)); ?>
			</div>
		</span>
	</div>
	<?
}


?>

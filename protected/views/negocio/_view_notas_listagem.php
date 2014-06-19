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

	switch ($nota->codstatus)
	{
		case NotaFiscal::CODSTATUS_DIGITACAO;
			$css_label = "label-warning";
			$staus = "D";
			break;

		case NotaFiscal::CODSTATUS_AUTORIZADA;
			$css_label = "label-success";
			$staus = "A";
			break;

		case NotaFiscal::CODSTATUS_LANCADA;
			$css_label = "label-info";
			$staus = "L";
			break;

		case NotaFiscal::CODSTATUS_NAOAUTORIZADA;
			$css = "alert-info";
			$staus = "E";
			break;

		case NotaFiscal::CODSTATUS_INUTILIZADA;
			$css = "alert-danger";
			$css_label = "label-important";
			$staus = "I";
			break;

		case NotaFiscal::CODSTATUS_CANCELADA;
			$css = "alert-danger";
			$css_label = "label-important";
			$staus = "C";
			break;

	}	
	?>
	<div class="registro <?php echo $css; ?>">
		<span class="row-fluid">
			<small class="span1 muted">
				<?php echo CHtml::encode($nota->Filial->filial); ?> 
			</small>
			<div class="span3">
				<?php echo CHtml::link(CHtml::encode(Yii::app()->format->formataNumeroNota($nota->emitida, $nota->serie, $nota->numero, $nota->modelo)),array('notaFiscal/view','id'=>$nota->codnotafiscal)); ?>
			</div>
			<small class="span3 muted">
				<?php echo CHtml::encode($nota->emissao); ?> &nbsp;&nbsp;
				<?php echo CHtml::encode($nota->NaturezaOperacao->naturezaoperacao); ?> 
			</small>
			<small class="span3">
				<?php echo CHtml::link(
					CHtml::encode($nota->Pessoa->fantasia)
					, array('pessoa/view', 'id'=> $nota->codpessoa)); 
				?> 
				<small class="label <?php echo $css_label; ?> pull-right">
					<?php echo $nota->status; ?>
				</small>
			</small>
			<div class="span2">
				<?php $this->widget('MGNotaFiscalBotoes', array('model'=>$nota)); ?>		
			</div>
		</span>
	</div>
	<?
}


?> 

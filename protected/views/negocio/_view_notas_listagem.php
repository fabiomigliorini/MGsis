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

if (empty($codnotas))
{
	?>
	<div class="alert">Nenhuma Nota Fiscal foi gerada para este negócio!</div>
	<?php
}

foreach ($codnotas as $codnota)
{
	$nota = NotaFiscal::model()->findByPk($codnota);
	?>
	<div class="registro">
		<span class="row-fluid">
			<small class="span1 muted">
				<?php echo Chtml::encode($nota->Filial->filial); ?> 
			</small>
			<small class="span3">
				<?php echo CHtml::link(
					Yii::app()->format->formataNumeroNota($nota->emitida, $nota->serie, $nota->numero)
					, array('notaFiscal/view', 'id'=> $nota->codnotafiscal)); 
				?> 
				<?php echo Chtml::encode($nota->emissao); ?> 
			</small>
			<small class="span3 muted">
				<?php echo Chtml::encode($nota->NaturezaOperacao->naturezaoperacao); ?> 
			</small>
			<small class="span2">
				<?php echo CHtml::link(
					CHtml::encode($nota->Pessoa->fantasia)
					, array('pessoa/view', 'id'=> $nota->codpessoa)); 
				?> 
			</small>
			<small class="span2 muted">
				<?php echo Chtml::encode($nota->status); ?> 
			</small>
		</span>
	</div>
	<?
}


?> 

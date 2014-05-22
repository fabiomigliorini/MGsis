<?php

$command = Yii::app()->db->createCommand(' 
	SELECT DISTINCT cfpb.codcupomfiscal
	  FROM tblNegocioProdutoBarra npb 
	 INNER JOIN tblCupomFiscalProdutoBarra cfpb ON (cfpb.codnegocioprodutobarra = npb.codnegocioprodutobarra)
	 WHERE npb.codnegocio = :codnegocio
	 ORDER BY cfpb.codcupomfiscal
	');

$command->params = array("codnegocio" => $model->codnegocio);

$cudcupoms = $command->queryAll();

if (empty($codcupoms))
{
	?>
	<div class="alert">Nenhum Cupom Fiscal foi gerada para este negócio!</div>
	<?php
}

foreach ($cudcupoms as $codcupom)
{
	$cupom = CupomFiscal::model()->findByPk($codcupom);
	?>
	<div class="registro">
		<span class="row-fluid">
			<small class="span1 muted">
				<?php echo Chtml::encode($cupom->Ecf->Filial->filial); ?> 
			</small>
			<small class="span2 muted">
				<?php echo Chtml::encode($cupom->Ecf->ecf); ?> 
			</small>
			<small class="span1 text-right">
				<?php echo Chtml::encode($cupom->numero); ?> 
			</small>
			<small class="span1 text-right">
				<?php echo Chtml::encode($cupom->datamovimento); ?> 
			</small>
			<small class="span2">
				<?php 
				echo CHtml::link(
					CHtml::encode($cupom->Pessoa->fantasia)
					, array('pessoa/view', 'id'=> $cupom->codpessoa)); 
				?> 
			</small>
			<small class="span2 muted">
				<?php echo ($cupom->cancelado)?"Cancelado":""; ?> 
			</small>
		</span>
	</div>
	<?
}


?> 

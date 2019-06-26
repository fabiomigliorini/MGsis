<?php 
$css_label = "";
$staus = "&nbsp";
$css = "";

switch ($data->codstatus)
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

$modelo = NotaFiscal::getModeloListaCombo();
if (isset($modelo[$data->modelo]))
	$modelo = $modelo[$data->modelo];
else 
	$modelo = $data->modelo;


?>
<div class="registro <?php echo $css; ?>">
	<small class="row-fluid">
		<div class="span3">
			<small class="muted span3">
				<?php echo CHtml::encode(Yii::app()->format->formataCodigo($data->codnotafiscal)); ?>
			</small>
			<b class="span3">
				<?php echo CHtml::encode($data->Filial->filial); ?>
			</b>
			<b class="span6">
				<?php echo CHtml::link(CHtml::encode(Yii::app()->format->formataNumeroNota($data->emitida, $data->serie, $data->numero, $data->modelo)),array('view','id'=>$data->codnotafiscal)); ?>
				
				<small class="label <?php echo $css_label; ?> pull-right">
					<?php echo $staus; ?>
				</small>
			</b>
		</div>
		<div class="span4">
			<b>
				<?php echo CHtml::link(CHtml::encode($data->Pessoa->fantasia),array('pessoa/view','id'=>$data->codpessoa)); ?>
			</b>
			<small class="muted pull-right">
				<?php echo CHtml::encode($data->Pessoa->Cidade->cidade); ?> -
				<?php echo CHtml::encode($data->Pessoa->Cidade->Estado->sigla); ?>
			</small>
		</div>
		<b class="span1 text-right">
			<?php echo CHtml::encode(Yii::app()->format->formatNumber($data->valortotal)); ?>
		</b>
		<div class="span2">
			<small class="muted span6 text-center">
				<?php echo CHtml::encode($data->emissao); ?> 
			</small>
			<b class="span6 text-center">
				<?php echo CHtml::encode(substr($data->saida, 0, 10)); ?>
			</b>
		</div>
		<small class="span2">
			<?php echo CHtml::encode($data->NaturezaOperacao->naturezaoperacao); ?> 		
		</small>

			<?php /*

			<small class="span2 muted"><?php echo CHtml::encode($data->nfechave); ?></small>

			<small class="span2 muted"><?php echo CHtml::encode($data->nfeimpressa); ?></small>

			<small class="span2 muted"><?php echo CHtml::encode($data->serie); ?></small>

			<small class="span2 muted"><?php echo CHtml::encode($data->numero); ?></small>
			 * 
			<small class="span2 muted"><?php echo CHtml::encode($data->emissao); ?></small>

			<small class="span2 muted"><?php echo CHtml::encode($data->saida); ?></small>

			<small class="span2 muted"><?php echo CHtml::encode($data->codfilial); ?></small>

			<small class="span2 muted"><?php echo CHtml::encode($data->codpessoa); ?></small>

			<small class="span2 muted"><?php echo CHtml::encode($data->observacoes); ?></small>

			<small class="span2 muted"><?php echo CHtml::encode($data->volumes); ?></small>

			<small class="span2 muted"><?php echo CHtml::encode($data->frete); ?></small>

			<small class="span2 muted"><?php echo CHtml::encode($data->codoperacao); ?></small>

			<small class="span2 muted"><?php echo CHtml::encode($data->nfereciboenvio); ?></small>

			<small class="span2 muted"><?php echo CHtml::encode($data->nfedataenvio); ?></small>

			<small class="span2 muted"><?php echo CHtml::encode($data->nfeautorizacao); ?></small>

			<small class="span2 muted"><?php echo CHtml::encode($data->nfedataautorizacao); ?></small>

			<small class="span2 muted"><?php echo CHtml::encode($data->valorfrete); ?></small>

			<small class="span2 muted"><?php echo CHtml::encode($data->valorseguro); ?></small>

			<small class="span2 muted"><?php echo CHtml::encode($data->valordesconto); ?></small>

			<small class="span2 muted"><?php echo CHtml::encode($data->valoroutras); ?></small>

			<small class="span2 muted"><?php echo CHtml::encode($data->nfecancelamento); ?></small>

			<small class="span2 muted"><?php echo CHtml::encode($data->nfedatacancelamento); ?></small>

			<small class="span2 muted"><?php echo CHtml::encode($data->nfeinutilizacao); ?></small>

			<small class="span2 muted"><?php echo CHtml::encode($data->nfedatainutilizacao); ?></small>

			<small class="span2 muted"><?php echo CHtml::encode($data->justificativa); ?></small>

			<small class="span2 muted"><?php echo CHtml::encode($data->valorprodutos); ?></small>

			<small class="span2 muted"><?php echo CHtml::encode($data->valortotal); ?></small>

			<small class="span2 muted"><?php echo CHtml::encode($data->icmsbase); ?></small>

			<small class="span2 muted"><?php echo CHtml::encode($data->icmsvalor); ?></small>

			<small class="span2 muted"><?php echo CHtml::encode($data->icmsstbase); ?></small>

			<small class="span2 muted"><?php echo CHtml::encode($data->icmsstvalor); ?></small>

			<small class="span2 muted"><?php echo CHtml::encode($data->ipibase); ?></small>

			<small class="span2 muted"><?php echo CHtml::encode($data->ipivalor); ?></small>

			*/ ?>
	</small>
</div>
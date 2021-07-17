<?php
/**
 * @var NfeTerceiro $data
 */

$css = '';
if (
    in_array($data->indmanifestacao, array(NfeTerceiro::INDMANIFESTACAO_NAOREALIZADA, NfeTerceiro::INDMANIFESTACAO_DESCONHECIDA))
    || in_array($data->indsituacao, array(NfeTerceiro::INDSITUACAO_CANCELADA, NfeTerceiro::INDSITUACAO_CANCELADA))
    ) {
    $css = 'alert-danger';
}


$cssmanif = '';
$labelmanif = 'S';
switch ($data->indmanifestacao) {
    case NfeTerceiro::INDMANIFESTACAO_CIENCIA:
        $cssmanif = 'badge-warning';
        $labelmanif = 'C';
        break;
    case NfeTerceiro::INDMANIFESTACAO_REALIZADA:
        $cssmanif = 'badge-success';
        $labelmanif = 'R';
        break;
    case NfeTerceiro::INDMANIFESTACAO_DESCONHECIDA:
        $cssmanif = 'badge-important';
        $labelmanif = 'D';
        break;

    case NfeTerceiro::INDMANIFESTACAO_NAOREALIZADA:
        $cssmanif = 'badge-important';
        $labelmanif = 'N';
        break;
}


?>

<div class="row-fluid registro <?php echo $css; ?>">
	<div class="span1">
		<b>
			<?php echo CHtml::encode($data->Filial->filial); ?>
		</b>
		<small class="muted">
			<?php echo CHtml::encode(Yii::app()->format->formataCodigo($data->codnfeterceiro)); ?>
		</small>
	</div>
	<div class="span5">

    <!-- Chave -->
    <small class="muted">
		    <?php echo CHtml::link(CHtml::encode(Yii::app()->format->formataChaveNfe($data->nfechave)), array('view','id'=>$data->codnfeterceiro)); ?>
    </small>

    <!-- Manifestacao -->
		<span class='badge <?php echo $cssmanif; ?>'><?php echo $labelmanif ?></span>

    <!-- Revisao -->
    <?php if (empty($data->revisao)): ?>
		    <span class='badge badge-warning'>?</span>
    <?php else: ?>
        <span class='badge badge-success'>&#10004;</span>
    <?php endif; ?>

    <!-- Link Nota Fiscal -->
		<div class="pull-right">
			<?php
          if (isset($data->NotaFiscal)) {
              echo CHtml::link(CHtml::encode(Yii::app()->format->formataNumeroNota($data->NotaFiscal->emitida, $data->NotaFiscal->serie, $data->NotaFiscal->numero, $data->NotaFiscal->modelo)), array('notaFiscal/view','id'=>$data->codnotafiscal));
          }
      ?>
		</div>
		<br>
		NSU: <?php echo CHtml::encode($data->nsu); ?> |
		<?php echo CHtml::encode($data->getIndSituacaoDescricao()); ?> |
		<?php echo CHtml::encode($data->getIndManifestacaoDescricao()); ?>
	</div>
	<div class="span3">
		<b>
			<?php if (isset($data->Pessoa)): ?>
				<?php echo CHtml::link(CHtml::encode($data->Pessoa->fantasia), array('pessoa/view','id'=>$data->codpessoa)); ?>
			<?php else: ?>
				<?php echo CHtml::encode($data->emitente); ?>
			<?php endif; ?>
		</b><br>
		<small class="muted">
			<?php echo CHtml::encode(Yii::app()->format->formataCnpjCpf($data->cnpj)); ?> |
			<?php echo CHtml::encode($data->ie); ?>
		</small>

	</div>

	<div class="span1 text-right">
		<b>
			<?php echo CHtml::encode(Yii::app()->format->formatNumber($data->valortotal)); ?>
		</b>
		<br>
		<small class="muted">
			<?php
            if (isset($data->Operacao)) {
                echo CHtml::encode($data->Operacao->operacao);
            }
            ?>
		</small>
	</div>

	<div class="span2">
		<b>
			<?php echo CHtml::encode($data->emissao); ?>
		</b><br>
		<small class="muted">
			<?php echo CHtml::encode($data->nfedataautorizacao); ?>
		</small>
	</div>

	<?php /*

    <small class="span2 muted"><?php echo CHtml::encode($data->indsituacao); ?></small>

    <small class="span2 muted"><?php echo CHtml::encode($data->indmanifestacao); ?></small>

    <small class="span2 muted"><?php echo CHtml::encode($data->codpessoa); ?></small>

    */ ?>
</div>

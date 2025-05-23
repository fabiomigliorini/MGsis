<?
//decide o css pra utilizar nos campos de vencimento e valor
//baseado no saldo e atraso

if ($data->saldo == 0)
    $css_vencimento = "muted";
else
	if ($data->Juros->diasAtraso > 0) {
    if ($data->Juros->diasAtraso <= $data->Juros->diasTolerancia)
        $css_vencimento = "text-warning";
    else
        $css_vencimento = "text-error";
} else
    $css_vencimento = "text-success";

if ($data->gerencial)
    $css_filial = "text-warning";
else
    $css_filial = "text-success";

?>
<div class="registro <?php echo (!empty($data->estornado)) ? "alert-danger" : ""; ?>" id="<?php echo $data->codtitulo; ?>">
    <small class="row-fluid">

        <div class="span4">

            <div class="row-fluid">

                <div class="span6">
                    <small>
                        <?php echo CHtml::link(CHtml::encode($data->numero), array('titulo/view', 'id' => $data->codtitulo), array("tabindex" => -1)); ?>
                        <?php echo CHtml::encode($data->fatura); ?>
                    </small>
                </div>

                <div class="span2 <?php echo $css_vencimento ?> text-center ">
                    <?php echo CHtml::encode($data->vencimento); ?>
                </div>

                <div class="span4 text-right">
                    <b>
                        <?php echo CHtml::encode(Yii::app()->format->formatNumber(abs($data->saldo))); ?>
                        <?php echo CHtml::encode($data->operacao); ?>
                    </b>
                </div>
            </div>

        </div>

        <div class="span5">
            <div class="row-fluid">

                <div class="span3">
                    <input
                        type="hidden"
                        value="<?php echo $data->operacao; ?>"
                        name="<?php echo $namePrefix; ?>[operacao][<?php echo $data->codtitulo; ?>]"
                        id="<?php echo $idPrefix; ?>_operacao_<?php echo $data->codtitulo; ?>">
                    <input
                        type="text"
                        value="<?php echo (isset($GridTitulos["saldo"][$data->codtitulo])) ? $GridTitulos["saldo"][$data->codtitulo] : abs($data->saldo); ?>"
                        data-calculado="<?php echo abs($data->saldo); ?>"
                        name="<?php echo $namePrefix; ?>[saldo][<?php echo $data->codtitulo; ?>]"
                        id="<?php echo $idPrefix; ?>_saldo_<?php echo $data->codtitulo; ?>"
                        class="span12 text-right numero saldo"
                        style="font-size: 0.9em">
                </div>
                <div class="span2">
                    <input
                        type="text"
                        value="<?php echo (isset($GridTitulos["multa"][$data->codtitulo])) ? $GridTitulos["multa"][$data->codtitulo] : abs($data->Juros->valorMulta); ?>"
                        data-calculado="<?php echo abs($data->Juros->valorMulta); ?>"
                        name="<?php echo $namePrefix; ?>[multa][<?php echo $data->codtitulo; ?>]"
                        id="<?php echo $idPrefix; ?>_multa_<?php echo $data->codtitulo; ?>"
                        class="span12 text-right numero multa"
                        style="font-size: 0.9em">
                </div>
                <div class="span2">
                    <input
                        type="text"
                        value="<?php echo (isset($GridTitulos["juros"][$data->codtitulo])) ? $GridTitulos["juros"][$data->codtitulo] : abs($data->Juros->valorJuros); ?>"
                        data-calculado="<?php echo abs($data->Juros->valorJuros); ?>"
                        name="<?php echo $namePrefix; ?>[juros][<?php echo $data->codtitulo; ?>]"
                        id="<?php echo $idPrefix; ?>_juros_<?php echo $data->codtitulo; ?>"
                        class="span12 text-right numero juros"
                        style="font-size: 0.9em">
                </div>
                <div class="span2">
                    <input
                        type="text"
                        value="<?php echo (isset($GridTitulos["desconto"][$data->codtitulo])) ? $GridTitulos["desconto"][$data->codtitulo] : 0; ?>"
                        data-calculado="0"
                        name="<?php echo $namePrefix; ?>[desconto][<?php echo $data->codtitulo; ?>]"
                        id="<?php echo $idPrefix; ?>_desconto_<?php echo $data->codtitulo; ?>"
                        class="span12 text-right numero desconto"
                        style="font-size: 0.9em"
                        tabindex="-1">
                </div>
                <div class="span3">
                    <input
                        type="text"
                        value="<?php echo (isset($GridTitulos["total"][$data->codtitulo])) ? $GridTitulos["total"][$data->codtitulo] : abs($data->Juros->valorTotal); ?>"
                        data-calculado="<?php echo abs($data->Juros->valorTotal); ?>"
                        name="<?php echo $namePrefix; ?>[total][<?php echo $data->codtitulo; ?>]"
                        id="<?php echo $idPrefix; ?>_total_<?php echo $data->codtitulo; ?>"
                        class="span12 text-right numero total"
                        style="font-size: 0.9em">
                </div>

            </div>
        </div>

        <div class="span3">

            <div class="row-fluid">
                <div class="span1">
                    <input
                        type="checkbox"
                        class="codtitulo"
                        name="<?php echo $namePrefix; ?>[codtitulo][]"
                        id="<?php echo $idPrefix; ?>_codtitulo_<?php echo $data->codtitulo; ?>"
                        value="<?php echo $data->codtitulo; ?>"
                        <?php echo (in_array($data->codtitulo, $GridTitulos['codtitulo'])) ? "checked" : ""; ?>>
                </div>

                <div class="span11">
                    <div class="row-fluid">
                        <div class="span3 <?php echo $css_filial; ?>">
                            <?php echo CHtml::encode($data->Filial->filial); ?>
                            <?php echo ($data->boleto) ? "C/Boleto" : ""; ?>
                        </div>
                        <b class="span8">
                            <?php echo CHtml::link(CHtml::encode($data->Pessoa->fantasia), array('pessoa/view', 'id' => $data->codpessoa), array("tabindex" => -1)); ?>
                            <?php if (isset($data->NegocioFormaPagamento->Negocio)): ?>
                                <?php if (empty($data->NegocioFormaPagamento->Negocio->confissao)): ?>
                                    <span class="text-error">
                                        <br>S/Confiss
                                        <?php echo CHtml::encode($data->NegocioFormaPagamento->Negocio->confissao); ?>
                                    </span>
                                <?php endif; ?>
                            <?php endif; ?>
                        </b>
                    </div>

                </div>
            </div>

        </div>
</div>

</small>

<table class="table table-hover table-bordered table-striped">
    <thead>
        <tr>
            <th>Vencimento</th>
            <th>Valor</th>
            <th>Cliente</th>
            <th>Título</th>
            <th>Portador</th>
            <th>Nosso Número</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($boletos as $i => $boleto) {
        ?>
            <tr>
                <td>
                    <b><?php echo DateTime::createFromFormat('Y-m-d', $boleto['vencimento'])->format('d/m/Y') ?></b>
                </td>
                <td>
                    <div class="text-right">
                        <b><?php echo Yii::app()->format->number($boleto['valoratual'], 2); ?></b>
                    </div>
                </td>
                <td>
                    <a class="btn pull-right" href="<?php echo Yii::app()->createUrl('titulo/index', ['Titulo[status]' => 'A', 'Titulo[codpessoa]' => $boleto['codpessoa']]); ?>">
                        <i class="icon-list"></i>
                    </a>
                    <?php echo CHtml::link(CHtml::encode($boleto['fantasia']), array('pessoa/view', 'id' => $boleto['codpessoa'])); ?>
                    <?php if ($boleto['valoratual'] != $boleto['saldo']): ?>
                        <div class="text-error">
                            * Valor do boleto diverge do saldo do título R$
                            <b><?php echo Yii::app()->format->number($boleto['saldo'], 2); ?></b>
                        </div>
                    <?php endif; ?>
                </td>
                <td>
                    <?php echo CHtml::link(CHtml::encode($boleto['numero']), array('titulo/view', 'id' => $boleto['codtitulo'])); ?>
                </td>
                <td class="muted">
                    <?php echo CHtml::encode($boleto['portador']); ?>
                </td>
                <td class="muted">
                    <?php echo CHtml::encode($boleto['nossonumero']); ?>
                </td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>
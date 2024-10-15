<small>
    <table class="table table-hover table-bordered table-striped">
        <thead>
            <tr>
                <th>Receb</th>
                <th>Valor</th>
                <th>Juros</th>
                <th>Multa</th>
                <th>Outro</th>
                <th>Pago</th>
                <th>Cliente</th>
                <th>Título</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($boletos as $i => $boleto) {
            ?>
                <tr>
                    <td>
                        <b><?php echo DateTime::createFromFormat('Y-m-d', $boleto['datarecebimento'])->format('d/m/Y') ?></b>
                    </td>
                    <td>
                        <div class="text-right">
                            <?php echo Yii::app()->format->number($boleto['valoratual'], 2); ?>
                        </div>
                    </td>
                    <td>
                        <div class="text-right">
                            <?php echo Yii::app()->format->number($boleto['valorjuromora'], 2); ?>
                        </div>
                    </td>
                    <td>
                        <div class="text-right">
                            <?php echo Yii::app()->format->number($boleto['valormulta'], 2); ?>
                        </div>
                    </td>
                    <td>
                        <div class="text-right">
                            <?php echo Yii::app()->format->number($boleto['valoroutro'], 2); ?>
                        </div>
                    </td>
                    <td>
                        <div class="text-right">
                            <b><?php echo Yii::app()->format->number($boleto['valorpago'], 2); ?></b>
                        </div>
                    </td>
                    <td>
                        <a class="btn pull-right" href="<?php echo Yii::app()->createUrl('titulo/index', ['Titulo[status]' => 'A', 'Titulo[codpessoa]' => $boleto['codpessoa']]); ?>">
                            <i class="icon-list"></i>
                        </a>
                        <?php echo CHtml::link(CHtml::encode($boleto['fantasia']), array('pessoa/view', 'id' => $boleto['codpessoa'])); ?>
                        <?php if ($boleto['saldo'] > 0): ?>
                            <div class="text-error">
                                * O título ainda tem um saldo de R$
                                <b><?php echo Yii::app()->format->number($boleto['saldo'], 2); ?></b>
                            </div>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php echo CHtml::link(CHtml::encode($boleto['numero']), array('titulo/view', 'id' => $boleto['codtitulo'])); ?>
                    </td>
                    <td class="muted">
                        <?php echo CHtml::encode(TituloBoleto::ESTADO[$boleto['estadotitulocobranca']]); ?>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</small>
<style>

    table {
        width: 100%;
    }

    td {
        /* max-width: 0; */
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
</style>
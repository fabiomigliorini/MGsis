<?php

$this->pagetitle = Yii::app()->name . ' - Boletos Liquidados';
$this->breadcrumbs = array(
    'Boletos Liquidados',
);

$this->menu = array(
    array('label' => 'Abertos', 'icon' => 'icon-fire', 'url' => array('index')),
    array('label' => 'Liquidados', 'icon' => 'icon-ok', 'url' => array('liquidados')),
    array('label' => 'Baixados', 'icon' => 'icon-remove', 'url' => array('baixados')),
);

?>
<h1>Boletos Liquidados </h1>
<p class="muted">Boletos <b>liquidados</b> por data de crédito e portador.</p>
<br>

<ul class="nav nav-tabs" >
    <?php foreach ($anos as $ano): ?>
        <li class="<?php echo ($ano == $dia->format('Y')) ? 'active' : ''; ?>">
            <a href="<?php echo Yii::app()->createUrl($this->route, array('dia' => "{$ano}-01-01")) ?>">
                <?php echo CHtml::encode($ano); ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>

<!-- MESES  -->
<small>
    <ul class="nav nav-tabs">
        <?php foreach ($meses as $i => $mes): ?>
            <li class="<?php echo ($i == $dia->format('m')) ? 'active' : ''; ?>">
                <a href="<?php echo Yii::app()->createUrl($this->route, array('dia' => "{$dia->format("Y")}-{$mes->mes}-01")) ?>">
                    <?php echo CHtml::encode($mes->label); ?>
                    <span class="badge pull-right">
                        <?php echo Yii::app()->format->number($mes->quantidade, 0); ?>
                    </span>
                    <?php if ($mes->valorpago > 0): ?>
                        <br>
                        <small>R$ <?php echo Yii::app()->format->number($mes->valorpago); ?></small>
                    <?php endif; ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</small>
<div class="tabbable tabs-left">



    <!-- DIAS -->
    <ul class="nav nav-tabs">
        <?php foreach ($dias as $i => $d): ?>
            <li class="<?php echo ($i == $dia->format('d')) ? 'active' : ''; ?>">
                <a href="<?php echo Yii::app()->createUrl($this->route, array('dia' => "{$dia->format("Y")}-{$dia->format("m")}-{$d->dia}")) ?>">
                    <?php echo CHtml::encode($d->dia); ?>
                    | R$ <?php echo Yii::app()->format->number($d->valorpago); ?>
                    <span class="badge pull-right">
                        <?php echo Yii::app()->format->number($d->quantidade, 0); ?>
                    </span>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>

    <!-- PORTADORES -->
    <ul class="nav nav-tabs">
        <?php foreach ($portadores as $i => $p): ?>
            <li class="<?php echo ($i == $codportador) ? 'active' : ''; ?> text-left">
                <a href="<?php echo Yii::app()->createUrl($this->route, array('dia' => $dia->format("Y-m-d"), 'codportador' => $i)) ?>">
                    <?php echo CHtml::encode($p->conta); ?>
                    | R$ <?php echo Yii::app()->format->number($p->valorpago); ?>
                    <span class="badge pull-right">
                        <?php echo Yii::app()->format->number($p->quantidade, 0); ?>
                    </span>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>

    <div class="tab-content">
        <?php if (sizeof($boletos) > 0): ?>
            <div class="tab-pane active" id="listagem">
                <?php
                $this->renderPartial('_listagem_boletos_liquidados', array(
                    'boletos' => $boletos,
                ));
                ?>
            </div>
        <?php endif; ?>
    </div>

</div>

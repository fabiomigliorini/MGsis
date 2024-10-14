<?php

$this->pagetitle = Yii::app()->name . ' - Boletos em Aberto';
$this->breadcrumbs = array(
    'Boletos em Aberto',
);

$this->menu = array(
    array('label' => 'Abertos', 'icon' => 'icon-fire', 'url' => array('index')),
    array('label' => 'Liquidados', 'icon' => 'icon-ok', 'url' => array('liquidados')),
);

function label($tipoItem)
{
    switch ($tipoItem) {
        case 'vencidos':
            return 'Vencidos';
            break;
        case 'vencer7':
            return 'Vencer em 7 Dias';
            break;
        case 'vencer30':
            return 'Vencer em 30 Dias';
            break;
        case 'vencer60':
            return 'Vencer em 60 Dias';
            break;
        case 'vencermais60':
            return 'Vencer mais de 60 Dias';
            break;
        default:
            return $tipo;
            break;
    }
}


?>
<h1>Boletos em Aberto</h1>
<br>

<ul class="nav nav-tabs" id="myTab">
    <?php foreach ($abertos as $item): ?>
        <li class="<?php echo ($item['tipo'] == $tipo)?'active':''; ?>">
            <a href="<?php echo Yii::app()->createUrl($this->route, array('tipo' => $item['tipo']))?>">
                <?php echo label($item['tipo']) ?> |
                R$ <?php echo Yii::app()->format->number($item['valoratual']); ?>
                <span class="badge">
                    <?php echo Yii::app()->format->number($item['quantidade'], 0); ?>
                </span>
            </a>
        </li>
    <?php endforeach; ?>
</ul>


<div class="tab-content">
    <div class="tab-pane active" id="listagem">
        <?php
        $this->renderPartial('_listagem_boletos_abertos', array(
            'boletos' => $boletos,
        ));
        ?>
    </div>
</div>

<script>
    $(document).ready(function() {

    });
</script>
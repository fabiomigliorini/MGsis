<?php
$this->pagetitle = Yii::app()->name . ' - Usuario';
$this->breadcrumbs=array(
	'Usuario',
);

$this->menu=array(
	array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);
?>

<h1>Usuario</h1>

<?php 
/*
$this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
    'itemsTagName'=>'table',
	'template'=>'{sorter} {items} {pager}',
	)); 
 * 
 * 
 */

$this->widget('zii.widgets.CListView', array(
       'id' => 'Listagem',
       'dataProvider' => $dataProvider,
       'itemView' => '_view',
       'template' => '{items} {pager}',
		/* scroll infinito */
       'pager' => array(
                    'class' => 'ext.infiniteScroll.IasPager', 
                    'rowSelector'=>'.registro', 
                    'listViewId' => 'Listagem', 
                    'header' => '?????',
                    'loaderText'=>'Carregando...',
                    'options' => array('history' => false, 'triggerPageTreshold' => 100, 'trigger'=>'Carregar mais registros'),
                  )
            )
       );
?>
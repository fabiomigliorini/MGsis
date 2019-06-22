<?php
$this->pagetitle = Yii::app()->name . ' - Novo Órgão Emissor de Certidão';
$this->breadcrumbs=array(
	'Órgão Emissor de Certidão'=>array('index'),
	'Novo',
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);
?>

<h1>Novo Órgão Emissor de Certidão</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

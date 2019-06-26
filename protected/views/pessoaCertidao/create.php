<?php
$this->pagetitle = Yii::app()->name . ' - Nova Certidão';

$this->breadcrumbs=array(
	'Pessoas'=>array('pessoa/index'),
	$model->Pessoa->pessoa=>array('pessoa/view', "id"=>$model->codpessoa),
	'Certidões'=>array('pessoa/view', "id"=>$model->codpessoa),
	'Nova',
);

$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('pessoa/view', 'id'=>$model->codpessoa)),
);
?>

<h1>Nova Certidão</h1>
<br />
<br />

<?php $this->renderPartial('_form', array('model'=>$model)); ?>

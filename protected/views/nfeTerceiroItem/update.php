<?php
$this->pagetitle = Yii::app()->name . ' - Alterar Item NFe de Terceiros';
$this->breadcrumbs=array(
	'NFe de Terceiros'=>array('nfeTerceiro/index'),
	$model->NfeTerceiro->nfechave=>array('nfeTerceiro/view', 'id' => $model->codnfeterceiro),
	$model->xprod=>array('nfeTerceiroItem/view', 'id' => $model->codnfeterceiroitem),
	'Alterar'
);


$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('nfeTerceiro/view', 'id'=>$model->codnfeterceiro)),
	//array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	array('label'=>'Detalhes', 'icon'=>'icon-eye-open', 'url'=>array('view','id'=>$model->codnfeterceiroitem)),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);
?>

<h1>Alterar <?php echo $model->xprod; ?></h1>
<br>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>	
<?php $this->widget('UsuarioCriacao', array('model'=>$model)); ?>
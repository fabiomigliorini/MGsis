<?php
$this->pagetitle = Yii::app()->name . ' - Alterar Negócio';
$this->breadcrumbs=array(
	'Negócios'=>array('index'),
	$model->codnegocio=>array('view','id'=>$model->codnegocio),
	'Alterar',
);

$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
	array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	array('label'=>'Detalhes', 'icon'=>'icon-eye-open', 'url'=>array('view','id'=>$model->codnegocio)),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);
?>

<h1>Alterar Negócio <?php echo CHtml::encode(Yii::app()->format->formataCodigo($model->codnegocio)); ?></h1>
<br>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>	
<?php $this->widget('UsuarioCriacao', array('model'=>$model)); ?>
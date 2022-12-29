<?php
$this->pagetitle = Yii::app()->name . ' - Informar Detalhes';
// $this->breadcrumbs=array(
// 	'Negócios'=>array('index'),
// 	$model->codnegocio=>array('view','id'=>$model->codnegocio),
// 	'Informar Detalhes',
// );

$this->menu=array(
	//array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
	//array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	array('label'=>'Detalhes (F4)', 'icon'=>'icon-eye-open', 'url'=>array('view','id'=>$model->codnegocio), 'linkOptions'=> array('id'=>'btnDetalhes')),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);

$this->renderPartial('_hotkeys');

?>

<h1>Detalhes Negócio <?php echo CHtml::encode(Yii::app()->format->formataCodigo($model->codnegocio)); ?></h1>
<br>

<?php echo $this->renderPartial('_form',array('model'=>$model, 'itens'=>$itens, 'codnegocioprodutobarraduplicar'=>$codnegocioprodutobarraduplicar)); ?>
<?php $this->widget('UsuarioCriacao', array('model'=>$model)); ?>

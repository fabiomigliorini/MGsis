<?php
$this->pagetitle = Yii::app()->name . ' - Alterar Registro SPC';
$this->breadcrumbs=array(
	'Pessoas'=>array('pessoa/index'),
	$model->Pessoa->pessoa=>array('pessoa/view', "id"=>$model->codpessoa),
	"Registro SPC {$model->inclusao}"=>array('view','id'=>$model->codregistrospc),
	'Alterar',
);

	$this->menu=array(
	//array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('pessoa/view', 'id'=>$model->codpessoa)),
	//array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	array('label'=>'Nova', 'icon'=>'icon-plus', 'url'=>array('create', 'codpessoa'=>$model->codpessoa)),
	array('label'=>'Detalhes', 'icon'=>'icon-eye-open', 'url'=>array('view','id'=>$model->codregistrospc)),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);
	?>

	<h1>Alterar Registro SPC <?php echo $model->inclusao; ?></h1>
	<br>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>	
	<?php $this->widget('UsuarioCriacao', array('model'=>$model)); ?>
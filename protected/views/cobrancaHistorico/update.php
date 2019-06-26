<?php
$this->pagetitle = Yii::app()->name . ' - Alterar Histórico de Cobrança';
$this->breadcrumbs=array(
	'Pessoas'=>array('pessoa/index'),
	$model->Pessoa->pessoa=>array('pessoa/view', "id"=>$model->codpessoa),
	'Histórico Cobrança'=>array('view','id'=>$model->codcobrancahistorico),
	'Alterar',
);

	$this->menu=array(
	//array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('pessoa/view', 'id'=>$model->codpessoa)),
	//array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create', 'codpessoa'=>$model->codpessoa)),
	array('label'=>'Detalhes', 'icon'=>'icon-eye-open', 'url'=>array('view','id'=>$model->codcobrancahistorico)),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);
	?>

	<h1>Alterar Histórico de Cobrança <?php //echo CHtml::encode($model->Pessoa->pessoa); ?></h1>
	<br>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>	
	<?php $this->widget('UsuarioCriacao', array('model'=>$model)); ?>
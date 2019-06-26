<?php
$this->pagetitle = Yii::app()->name . ' - Alterar Certidão';
$codpessoacertidao = Yii::app()->format->formataCodigo($model->codpessoacertidao);
$this->breadcrumbs=array(
	'Pessoas'=>array('pessoa/index'),
	$model->Pessoa->pessoa=>array('pessoa/view', "id"=>$model->codpessoa),
	"Certidão {$codpessoacertidao}"=>array('pessoa/view', "id"=>$model->codpessoa),
	'Alterar',
);

$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('pessoa/view', 'id'=>$model->codpessoa)),
	array('label'=>'Nova', 'icon'=>'icon-plus', 'url'=>array('pessoaCertidao/create', 'codpessoa'=>$model->codpessoacertidao)),
	array('label'=>'Detalhes', 'icon'=>'icon-eye-open', 'url'=>array('pessoaCertidao/view','id'=>$model->codpessoacertidao)),
);
?>

<h1>Alterar Certidão <?php echo CHtml::encode($codpessoacertidao); ?></h1>
<br />
<br />

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>
<?php $this->widget('UsuarioCriacao', array('model'=>$model)); ?>

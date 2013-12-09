<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Erro';
$this->breadcrumbs=array(
	'Erro',
);
?>

<h2>Erro <?php echo $error["code"]; ?> - <?php echo $error["title"]; ?></h2>

<div class="error">
<?php echo CHtml::encode($error["message"]); ?>
</div>
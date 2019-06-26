<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array('Login');

$this->layout = "//layouts/main"
?>


<h1>Identifique-se</h1>
<br>

<?php $form=$this->beginWidget('MGActiveForm',array(
	'id'=>'usuario-form',
)); ?>

<fieldset>
	<?php 
	echo $form->errorSummary($model); 

	echo $form->textFieldRow(
			$model,
			'username',
			array('class' => 'span2')
			); 

	echo $form->passwordFieldRow($model, 'password', array('class' => 'span2'));
	
	echo $form->checkBoxRow($model, 'rememberMe')
	?>

	</fieldset>
	<div class="form-actions">
	
    <?php 
        $this->widget(
            'bootstrap.widgets.TbButton',
            array(
                'buttonType' => 'submit',
                'type' => 'primary',
                'label' => 'Entrar',
                'icon' => 'icon-ok',
                )
            ); 
	?>
	<?php
		$this->widget(
            'bootstrap.widgets.TbButton',
            array(
                'buttonType' => 'reset',
                'label' => 'Limpar',
                'icon' => 'icon-refresh'
                )
            );
    ?>

	</div><!-- form -->
	<?php $this->endWidget(); ?>

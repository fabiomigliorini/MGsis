<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-BR" lang="pt-BR">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="pt-BR" />
	<link rel="shortcut icon" href="<?php echo Yii::app()->baseUrl;?>/images/icones/mgsis.ico">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/mgsis.css" />
	<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl.'/js/autoNumeric.js'); ?>
	<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl.'/js/mgsis.js'); ?>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body style>
	
<?php
	$this->widget(
		'bootstrap.widgets.TbNavbar',
		array(
			'brand' => 'MGsis',
			'brandUrl' => Yii::app()->createUrl('site/index'),
			'brandOptions' => array('style' => 'width:auto;margin-left: 0px;'),
			'collapse' => true,
			'fixed' => 'top',
			'items' => array(
				array(
					'class' => 'bootstrap.widgets.TbMenu',
					/*
					'items' => array(
						array('label' => 'Usuarios', 'url' => Yii::app()->createUrl('usuario')),
						array('label' => 'Titulos', 'url' => Yii::app()->createUrl('titulo')),
						array('label' => 'Codigos', 'url' => Yii::app()->createUrl('codigo')),
						array('label' => Yii::app()->user->name.' (sair)', 'url' => Yii::app()->createUrl('/site/logout'), 'visible' => !Yii::app()->user->isGuest),
						array('label' => 'Entrar', 'url' => Yii::app()->createUrl('/site/login'), 'visible' => Yii::app()->user->isGuest),
						)
					 * 
					 */
					'items' => array_merge(
							$this->menu, 
							array(
								array('label' => Yii::app()->user->name.' (sair)', 'url' => Yii::app()->createUrl('/site/logout'), 'visible' => !Yii::app()->user->isGuest),
								array('label' => 'Entrar', 'url' => Yii::app()->createUrl('/site/login'), 'visible' => Yii::app()->user->isGuest),
								)
							),
					)
				)
			)
		);
?>
<div class="container-fluid">
    <?php echo $content; ?>
</div>
	
</body>
</html>

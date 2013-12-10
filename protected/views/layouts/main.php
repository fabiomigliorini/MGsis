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

	/*
	if (Yii::app()->user->isGuest) 
	{
		$usuario = '
			<form class="navbar-form pull-right" id="usuario-form" action="/MGsis/index.php?r=site/login" method="post" style="padding-left:15px;padding-right:15px;">
				<input name="LoginForm[username]" type="text" class="input-small" placeholder="Usuário">
				<input name="LoginForm[password]" type="password" class="input-small" placeholder="Senha">
				<button type="submit" class="btn btn-primary">OK</button>
			</form>';
	}
	else
	 * 
	 */
	if (!Yii::app()->user->isGuest) 
	{
		$usuario = '
				<ul class="nav pull-right">
                   <li class="divider-vertical"></li>
                   <li><a href="' . Yii::app()->createUrl('/usuario/view', array('id'=>Yii::app()->user->id)) . '">Conectado como ' . Yii::app()->user->name . '</a></li>
                   <li class="divider-vertical"></li>
                   <li><a href="' . Yii::app()->createUrl('/site/logout') . '">Sair</a></li>
               </ul>';
	}
	else
	{
		$usuario = '';
	}
	
	$logo  = '<div class="nav">' . CHtml::image(Yii::app()->getBaseUrl().'/images/icones/mgsis.ico', 'MGsis', array('width'=>'20px')) . '</div>';
	$logo .= '<div class="nav">MGsis</div>';
	
	$this->widget(
		'bootstrap.widgets.TbNavbar',
		array(
			//'brand' => 'MGsis',
			//'brand' => CHtml::image(Yii::app()->getBaseUrl().'/images/icones/mgsis.ico', 'MGsis', array('width'=>'20px')) . "MGsis",
			'brand' => $logo,			
			'brandUrl' => Yii::app()->createUrl('site/index'),
			'brandOptions' => array('style' => 'width:100px;margin-left: 0px;'),
			'collapse' => true,
			'fixed' => 'top',
			'items' => array(
				'<ul class="nav">
                   <li class="divider-vertical"></li>
               </ul>',
				array(
					'class' => 'bootstrap.widgets.TbMenu',
					'items' => array(
						array('label' => 'Pessoas', 'url' => Yii::app()->createUrl('pessoa')),
						array('label' => 'Titulos', 'url' => Yii::app()->createUrl('titulo')),
						array('label' => 'Codigos', 'url' => Yii::app()->createUrl('codigo')),
						)
					),
				$usuario,
				)
			)
		);
	
?>
<div class="container-fluid">
    <?php echo $content; ?>
</div>
	
</body>
</html>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title><?php echo CHtml::encode($this->pageTitle); ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<?php
			$baseUrl = Yii::app()->theme->baseUrl; 
			$cs = Yii::app()->getClientScript();
			Yii::app()->clientScript->registerCoreScript('jquery');
		?>
		<!-- Fav and Touch and touch icons -->
		<link rel="shortcut icon" href="<?php echo Yii::app()->baseUrl;?>/images/icones/mgsis.ico">
		<?php  
			$cs->registerCssFile($baseUrl.'/css/bootstrap.min.css');
			$cs->registerCssFile($baseUrl.'/css/bootstrap-responsive.min.css');
			$cs->registerCssFile($baseUrl.'/css/abound.css');
			$cs->registerCssFile($baseUrl.'/css/style-blue.css');
			$cs->registerCssFile($baseUrl.'/css/form.css');
			$cs->registerScriptFile($baseUrl.'/js/bootstrap.min.js');
			$cs->registerScriptFile($baseUrl.'/js/plugins/autoNumeric.js');
		?>
	</head>
<body>

<section id="navigation-main">   
	<div class="navbar navbar-inverse navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>

				<?php echo CHtml::link(Yii::app()->name, array('/site'), array('class'=>'brand')); //echo CHtml::encode(Yii::app()->name); ?>

				<div class="nav-collapse">
					<?php $this->widget('zii.widgets.CMenu',array(
							'htmlOptions'=>array('class'=>'pull-right nav'),
							'itemCssClass'=>'item-test',
							'submenuHtmlOptions'=>array('class'=>'dropdown-menu'),
							'encodeLabel'=>false,
							'items'=>array(
									array('label'=>CHtml::image(Yii::app()->baseUrl.'/images/icones/inicio.png'), 'url'=>array('/site')),
									array('label'=>CHtml::image(Yii::app()->baseUrl.'/images/icones/configuracoes.png'), 
											'url'=>'#',
											'itemOptions'=>array('class'=>'dropdown','tabindex'=>"-1"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"), 
											'items'=>array(
												array('label'=>'Usuario', 'url'=>array('/usuario')),
												array('label'=>'Codigos', 'url'=>array('/codigo')),
											)),
									array('label'=>CHtml::image(Yii::app()->baseUrl.'/images/icones/usuario.png') . " " . (Yii::app()->user->isGuest ? '?' : Yii::app()->user->name), 
											'url'=>'#',
											'itemOptions'=>array('class'=>'dropdown','tabindex'=>"-1"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"), 
											'items'=>array(
												array('label'=>'Entrar', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
												array('label'=>'Conectado como "' . Yii::app()->user->name.'" (Clique para desconectar)', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
											)),
									),
								)
							); 
					?>
				</div>
			</div>
		</div>
	</div>
</section><!-- /#navigation-main -->
    
<section class="main-body">
	<div class="container-fluid">
		<?php echo $content; ?>
	</div>
</section>

</body>
</html>
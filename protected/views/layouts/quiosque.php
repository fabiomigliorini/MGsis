<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-BR" lang="pt-BR">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="pt-BR" />
	<link rel="shortcut icon" href="<?php echo Yii::app()->baseUrl;?>/images/icones/mgsis.ico">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/mgsis.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ytLoad.jquery.css" >
		
	<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl.'/js/autoNumeric.js'); ?>
	<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.number.min.js'); ?>
	<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl.'/js/mgsis.js'); ?>
	<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl.'/js/setCase.js'); ?>
	<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.transit.js'); ?>
	<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl.'/js/ytLoad.jquery.js'); ?>
		
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

	<script type="text/javascript">

		$(document).ready(function() {
			
			$.ytLoad();
			
			$("li.dropdown a").click(function(e){
				$(this).next('ul.dropdown-menu').css("display", "block");
				e.stopPropagation();
			});
			
		});

	</script>	
	<style>
		body {
			padding-top: 20px;
			padding-bottom: 60px;
			//background: lightgray;
		}		
		@media print {
			a[href]:after {
			  content: none;
			}
		  }
		html {
			   overflow-y: scroll;
		}		  
	</style>
</head>
<body>

<div class="affix" style="right: 0px; bottom:0px;">
	<?php
	
	if (isset($this->breadcrumbs))
	{
		$this->widget(
			'bootstrap.widgets.TbBreadcrumbs',
			array(
				'homeLink'=>CHtml::link('Início', array('site/index')),
				'links'=>$this->breadcrumbs,
			)
		);	
	}

	
	?>
</div>	
<div class="container-fluid">
	<?php $this->widget('bootstrap.widgets.TbAlert', array('userComponentId' => 'user')); ?>
    <?php echo $content; ?>
</div>
</body>
</html>

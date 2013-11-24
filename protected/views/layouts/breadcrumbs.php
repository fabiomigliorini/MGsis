<?php 
	if(isset($this->breadcrumbs))
	{
		$this->widget(
			'bootstrap.widgets.TbBreadcrumbs',
			array(
				'homeLink'=>CHtml::link('Início', array('site/index')),
				'links'=>$this->breadcrumbs,
			)
		);			
	}
<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="row-fluid">
<div class="span10">
	<?php require 'breadcrumbs.php'; ?>
	<?php echo $content; ?>
</div>
<div class="span2">
	<?php
		$box = $this->beginWidget('bootstrap.widgets.TbBox',
				array(
					'title' => 'Operações',
					/*'headerIcon' => 'icon-th-list',*/
					'htmlOptions' => array('class' => 'bootstrap-widget-table')
					)
				);
		
		$this->widget(
			'bootstrap.widgets.TbMenu',
			array(
				'type' => 'list',
				'items'=>$this->menu,
			)
		);	
		$this->endWidget();
	?>
</div>
    </div>
<?php $this->endContent(); ?>
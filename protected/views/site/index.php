<?php
/* @var $this SiteController */

Yii::import('bootstrap.helpers.TbHtml');

$this->pageTitle = Yii::app()->name;

$this->widget('bootstrap.widgets.TbAlert', array('userComponentId' => 'user'));

$menu_financeiro = TbHtml::thumbnails(
		array(
			array(
				'image' => Yii::app()->request->baseUrl . '/images/icones/pessoa.png', 
				'url' => Yii::app()->createUrl('pessoa'), 
				'span' => '2', 
				'caption' => '<small>Pessoas</small>'),
			array(
				'image' => Yii::app()->request->baseUrl . '/images/icones/titulo.png', 
				'url' => Yii::app()->createUrl('titulo'), 
				'span' => '1', 
				'caption' => '<small>Títulos</small>'),
		),
		array('class' => 'menuthumbnails')
	);

$menu_admin = TbHtml::thumbnails(
		array(
			array(
				'image' => Yii::app()->request->baseUrl . '/images/icones/usuario.png', 
				'url' => Yii::app()->createUrl('usuario'), 
				'span' => '2', 
				'caption' => '<small>Usuários</small>'),
			array(
				'image' => Yii::app()->request->baseUrl . '/images/icones/roles.png', 
				'url' => Yii::app()->createUrl('srbac/authitem/frontpage'), 
				'span' => '2', 
				'caption' => '<small>Perm</small>'),
			array(
				'image' => Yii::app()->request->baseUrl . '/images/icones/cidade.png', 
				'url' => Yii::app()->createUrl('cidade'), 
				'span' => '1', 
				'caption' => '<small>Cidades</small>'),
			array(
				'image' => Yii::app()->request->baseUrl . '/images/icones/portador.png', 
				'url' => Yii::app()->createUrl('codigo'), 
				'span' => '1', 
				'caption' => '<small>Códigos</small>'),
		),
		array('class' => 'menuthumbnails')
	);

?>

<?php $collapse = $this->beginWidget('bootstrap.widgets.TbCollapse'); ?>
<div class="accordion" id="accordion2">
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
        Financeiro
      </a>
    </div>
    <div id="collapseOne" class="accordion-body collapse in">
      <div class="accordion-inner">
		<?php echo $menu_financeiro; ?>
      </div>
    </div>
  </div>
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
        Administração
      </a>
    </div>
    <div id="collapseTwo" class="accordion-body collapse">
      <div class="accordion-inner">
		<?php echo $menu_admin; ?>
      </div>
    </div>
  </div>
</div>
<?php $this->endWidget(); ?>
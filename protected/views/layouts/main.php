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
			padding-top: 100px;
			padding-bottom: 60px;
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
<?php

	
	$logo  = '<div class="nav">' . CHtml::image(Yii::app()->getBaseUrl().'/images/icones/mgsis-20px.ico', 'MGsis', array('width'=>'20px')) . '</div>';
	$logo .= '<div class="nav">MGsis</div>';
	
	$menu = 
		array(
			
			array(
				'label' => 'Comercial', 
				'url'=>'#', 
				'items'=>array(
					array('label' => 'Negócios', 'url' => Yii::app()->createUrl('negocio')),
					array('label' => 'Notas Fiscais', 'url' => Yii::app()->createUrl('notaFiscal')),
					array('label' => htmlentities("NFe de Terceiros"), 'url' => Yii::app()->createUrl('nfeTerceiro')),
				)
			),
			
			array(
				'label' => 'Financeiro', 
				'url'=>'#', 
				'items'=>array(
					array('label' => 'Pessoas', 'url' => Yii::app()->createUrl('pessoa')),
					'---',
					array('label' => 'Liquidações', 'url' => Yii::app()->createUrl('liquidacaoTitulo')),
					array('label' => 'Titulos', 'url' => Yii::app()->createUrl('titulo')),				
					array('label' => 'Agrupamentos', 'url' => Yii::app()->createUrl('tituloAgrupamento')),
					'---',
					array('label' => 'Bancos', 'url' => Yii::app()->createUrl('banco')),					
					array('label' => 'Cheques', 'url' => Yii::app()->createUrl('cheque')),			
					array('label' => 'Formas de Pagamento', 'url' => Yii::app()->createUrl('formaPagamento')),					
					array('label' => 'Grupos de Cliente', 'url' => Yii::app()->createUrl('grupoCliente')),					
					array('label' => 'Portadores', 'url' => Yii::app()->createUrl('portador')),
					array('label' => 'Tipo Movimento Títulos', 'url' => Yii::app()->createUrl('tipoMovimentoTitulo')),				
					array('label' => 'Tipo Títulos', 'url' => Yii::app()->createUrl('tipoTitulo')),
				)
			),

			array(
				'label' => 'Estoque', 
				'url'=>'#', 
				'items'=>array(
					array('label' => 'Consulta de Preço', 'url' => Yii::app()->createUrl('produto/quiosqueConsulta')),
					array('label' => 'Produtos', 'url' => Yii::app()->createUrl('produto')),
					'---',
					array('label' => 'Etiquetas de Produto', 'url' => Yii::app()->createUrl('etiquetaProduto')),
					'---',
					array('label' => 'Histórico de Preços', 'url' => Yii::app()->createUrl('produtoHistoricoPreco')),
					'---',
					array('label' => 'Grupos de Produtos', 'url' => Yii::app()->createUrl('grupoProduto')),
					array('label' => 'Marcas', 'url' => Yii::app()->createUrl('marca')),
					array('label' => 'NCM', 'url' => Yii::app()->createUrl('ncm')),
					array('label' => 'Tipos de Produtos', 'url' => Yii::app()->createUrl('tipoProduto')),
					array('label' => 'Unidades de Medida', 'url' => Yii::app()->createUrl('unidadeMedida')),
				)
			),
			
			//Fiscal
			array(
				'label' => 'Fiscal', 
				'url'=>'#', 
				'items'=>array(
					array('label' => 'CFOP', 'url' => Yii::app()->createUrl('cfop')),
					array('label' => 'Contas Contábeis', 'url' => Yii::app()->createUrl('contaContabil')),
					array('label' => 'Empresas', 'url' => Yii::app()->createUrl('empresa')),
					array('label' => 'Naturezas de Operação', 'url' => Yii::app()->createUrl('naturezaOperacao')),
					array('label' => 'Países, Estados e Cidades', 'url' => Yii::app()->createUrl('pais')),
					array('label' => 'Tributações', 'url' => Yii::app()->createUrl('tributacao')),

				)
			),
						// Admin
			array(
				'label' => 'Admin', 
				'url'=>'#', 
				'items'=>array(
					array('label' => 'Usuários', 'url' => Yii::app()->createUrl('usuario')),
					array('label' => 'Permissões', 'url' => Yii::app()->createUrl('srbac/authitem/frontpage')),
					'---',
					array('label' => 'Códigos', 'url' => Yii::app()->createUrl('codigo')),
				)
			),

		);
	
	$this->widget('bootstrap.widgets.TbNavbar', array(
		'type'=>'inverse', // null or 'inverse'
		'brand' => $logo,
		'brandUrl'=>Yii::app()->createUrl('site/index'),
		'brandOptions' => array('style' => 'width:100px;margin-left: 0px;'),
		'htmlOptions' => array('class' => 'hidden-print'),
		'fixed' => 'top',
		'collapse'=>true,
		'items'=>array(
			array(
				'class'=>'bootstrap.widgets.TbMenu',
				'items'=>$menu
			),
			array(
				'class'=>'bootstrap.widgets.TbMenu',
				'htmlOptions'=>array('class'=>'pull-right'),
				'items'=>array(
					array(
						'label'=> Yii::app()->user->name, 
						'url'=>'#', 
						'icon'=>'icon-user icon-white', 
						'visible'=>!Yii::app()->user->isGuest,
						'items'=>
							array(
								array('label'=>'Perfil', 'url'=>array('usuario/view', 'id'=>Yii::app()->user->id)),
								array('label'=>'Sair', 'url'=>array('site/logout')),
							)
					),
				),
			),
		),
	)); 	
	
	if (!empty($this->menu))
	{
		$this->widget(
			'bootstrap.widgets.TbNavbar',
			array(
				'brand' => '',
				'brandOptions' => array('style' => 'width:0px;margin:0px;padding:0px;'),
				'collapse' => true,
				'htmlOptions' => array('class' => 'hidden-print subnav'),
				'fixed' => 'top',
				'items' => array(
					array(
						'class' => 'bootstrap.widgets.TbMenu',
						'items' => $this->menu
						),
					),
				)
			);
	}
	
?>
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
    <?php if (! in_array($_SERVER['SERVER_NAME'], ['10.0.1.4', 'mgsis.mgpapelaria.com.br', 'mgsis.mgpapelaria.com']) ): ?>
        <h4 class="row-fluid alert alert-error">
            <center>
                <blink>
                BASE DE TESTES - <?php echo $_SERVER['SERVER_NAME']; ?><?php echo $_SERVER["REQUEST_URI"]; ?>
                </blink>
            </center>
        </h4>
        <script type="text/javascript">

            function blink() 
            {
                var blinks = document.getElementsByTagName('blink');
                for (var i = blinks.length - 1; i >= 0; i--) 
                {
                    var s = blinks[i];
                    s.style.visibility = (s.style.visibility === 'visible') ? 'hidden' : 'visible';
                }
                window.setTimeout(blink, 1000);
            }
            
            if (document.addEventListener) 
                document.addEventListener("DOMContentLoaded", blink, false);
            else if (window.addEventListener) 
                window.addEventListener("load", blink, false);
            else if (window.attachEvent) 
                window.attachEvent("onload", blink);
            else 
                window.onload = blink;

        </script>
    <?php endif; ?>
	<?php $this->widget('bootstrap.widgets.TbAlert', array('userComponentId' => 'user')); ?>
    <?php echo $content; ?>
</div>
</body>
</html>

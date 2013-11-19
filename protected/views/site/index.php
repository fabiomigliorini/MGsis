<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;

$menuitems = array(
		array('imagem'=>'negocio.png', 'link'=>'index', 'titulo'=>'Negócios'),
		array('imagem'=>'nfe.png', 'link'=>'index', 'titulo'=>'Notas Fiscais'),
		array('imagem'=>'liquidacao.png', 'link'=>'index', 'titulo'=>'Liquidação de Títulos'),

		array('imagem'=>'produto.png', 'link'=>'index', 'titulo'=>'Produtos'),
		array('imagem'=>'etiquetas.png', 'link'=>'index', 'titulo'=>'Etiquetas de Preço'),
		array('imagem'=>'grupoproduto.png', 'link'=>'index', 'titulo'=>'Grupos de Produto'),
		array('imagem'=>'marca.png', 'link'=>'index', 'titulo'=>'Marca'),
		array('imagem'=>'medida.png', 'link'=>'index', 'titulo'=>'Unidades de Medida'),
		array('imagem'=>'preco.png', 'link'=>'index', 'titulo'=>'Alterações de Preco'),

		array('imagem'=>'pessoas.png', 'link'=>'index', 'titulo'=>'Pessoas'),
		array('imagem'=>'titulo.png', 'link'=>'index', 'titulo'=>'Título'),
		array('imagem'=>'cobranca.png', 'link'=>'index', 'titulo'=>'Cobranca'),
		array('imagem'=>'atrasados.png', 'link'=>'index', 'titulo'=>'Títulos Atrasados'),
		array('imagem'=>'bradesco.png', 'link'=>'index', 'titulo'=>'Transmissão de Boletos'),
		array('imagem'=>'fechamentos.png', 'link'=>'index', 'titulo'=>'Fechamentos'),
		array('imagem'=>'cheque.png', 'link'=>'index', 'titulo'=>'Cheques'),

		array('imagem'=>'contabilidade.png', 'link'=>'index', 'titulo'=>'Exportação Contabilidade'),
		array('imagem'=>'tributacao.png', 'link'=>'index', 'titulo'=>'Tipos de Tributacao'),
		array('imagem'=>'ecf.png', 'link'=>'index', 'titulo'=>'Máquinas ECF'),
		array('imagem'=>'cidade.png', 'link'=>'estado/index', 'titulo'=>'Cidades'),
		array('imagem'=>'empresa.png', 'link'=>'empresa/index', 'titulo'=>'Empresas'),
		array('imagem'=>'natureza.png', 'link'=>'index', 'titulo'=>'Natureza de Operação'),
		array('imagem'=>'pagamento.png', 'link'=>'index', 'titulo'=>'Formas de Pagamento'),
		array('imagem'=>'portador.png', 'link'=>'index', 'titulo'=>'Portadores'),


		array('imagem'=>'usuario.png', 'link'=>'usuario/index', 'titulo'=>'Usuários'),
	);

foreach ($menuitems as $menuitem)
{
?>
	
	<?php echo CHtml::link('<div class="menuicones">
					<img src="' . Yii::app()->request->baseUrl .'/images/icones/' . $menuitem['imagem'] . '" alt="' . $menuitem['titulo'] . '"/>
					<br/>
					' . $menuitem['titulo'] . '
				</div>', array($menuitem['link'])); ?>
	
<?php
}


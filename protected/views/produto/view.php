<?php
$this->pagetitle = Yii::app()->name . ' - Detalhes Produto';
$this->breadcrumbs=array(
	'Produtos'=>array('index'),
	$model->produto,
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
array('label'=>'MGLara', 'icon'=>'icon-pencil', 'url'=>"/MGLara/produto/{$model->codproduto}"),
    /*
array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
array('label'=>'Alterar', 'icon'=>'icon-pencil', 'url'=>array('update','id'=>$model->codproduto)),
array('label'=>'Juntar Códigos de Barras', 'icon'=>'icon-resize-small', 'url'=>array('juntarBarras','id'=>$model->codproduto)),
array('label'=>'Transferir Código de Barras', 'icon'=>' icon-share-alt', 'url'=>array('transferirBarras','id'=>$model->codproduto)),
array('label'=>'Excluir', 'icon'=>'icon-trash', 'url'=>'#', 'linkOptions'=>	array('id'=>'btnExcluir')),
//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
     * 
     */
);

Yii::app()->clientScript->registerCoreScript('yii');

?>
<script type="text/javascript">
	
	<?php
CHtml::ajax(array(
  'type'=>'POST',
  'url'=>'',// copy from point 1 above
))	
	?>
/*<![CDATA[*/
$(document).ready(function(){
	jQuery('body').on('click','#btnExcluir',function() {
		bootbox.confirm("Excluir este registro?", function(result) {
			if (result)
				jQuery.yii.submitForm(document.body.childNodes[0], "<?php echo Yii::app()->createUrl('produto/delete', array('id' => $model->codproduto))?>",{});
		});
	});
	
	// botão delete da embalagem
	jQuery(document).on('click','a.delete-embalagem',function(e) {
	
		//evita redirecionamento da pagina
		e.preventDefault();
		
		// pega url para delete
		var url = jQuery(this).attr('href');
		
		//pede confirmacao
		bootbox.confirm("Excluir esta embalagem?", function(result) {
			
			// se confirmou
			if (result) {
				
				//faz post
				jQuery.ajax({
					type: 'POST',
					url: url,
					
					//se sucesso, atualiza listagem de embalagens
					success: function(){
						$.fn.yiiListView.update('ListagemEmbalagem');				
					},
					
					//caso contrário mostra mensagem com erro
					error: function (XHR, textStatus) {
						var err;
						if (XHR.readyState === 0 || XHR.status === 0) {
							return;
						}
						//tipos de erro
						switch (textStatus) {
							case 'timeout':
								err = 'O servidor não responde (timed out)!';
								break;
							case 'parsererror':
								err = 'Erro de parâmetros (Parser error)!';
								break;
							case 'error':
								if (XHR.status && !/^\s*$/.test(XHR.status)) {
									err = 'Erro ' + XHR.status;
								} else {
									err = 'Erro';
								}
								if (XHR.responseText && !/^\s*$/.test(XHR.responseText)) {
									err = err + ': ' + XHR.responseText;
								}
								break;
						}
						//abre janela do bootbox com a mensagem de erro
						if (err) {
							bootbox.alert(err);
						}
					}
				});
			}	
		});
	});	
	
	
	// botão delete da embalagem
	jQuery(document).on('click','a.delete-barra',function(e) {
	
		//evita redirecionamento da pagina
		e.preventDefault();
		
		// pega url para delete
		var url = jQuery(this).attr('href');
		
		//pede confirmacao
		bootbox.confirm("Excluir este Código de Barras?", function(result) {
			
			// se confirmou
			if (result) {
				
				//faz post
				jQuery.ajax({
					type: 'POST',
					url: url,
					
					//se sucesso, atualiza listagem de embalagens
					success: function(){
						$.fn.yiiListView.update('ListagemBarra');				
					},
					
					//caso contrário mostra mensagem com erro
					error: function (XHR, textStatus) {
						var err;
						if (XHR.readyState === 0 || XHR.status === 0) {
							return;
						}
						//tipos de erro
						switch (textStatus) {
							case 'timeout':
								err = 'O servidor não responde (timed out)!';
								break;
							case 'parsererror':
								err = 'Erro de parâmetros (Parser error)!';
								break;
							case 'error':
								if (XHR.status && !/^\s*$/.test(XHR.status)) {
									err = 'Erro ' + XHR.status;
								} else {
									err = 'Erro';
								}
								if (XHR.responseText && !/^\s*$/.test(XHR.responseText)) {
									err = err + ': ' + XHR.responseText;
								}
								break;
						}
						//abre janela do bootbox com a mensagem de erro
						if (err) {
							bootbox.alert(err);
						}
					}
				});
			}	
		});
	});	
	
});
/*]]>*/
</script>

<h1><?php echo $model->produto; ?></h1>

<?php if (!empty($model->inativo)): ?>
	<div class="alert alert-danger">
		<b>Inativado em <?php echo CHtml::encode($model->inativo); ?> </b>
	</div>
<?php endif; ?>

<div class="row-fluid">

<div class="span4">

<?php 

$attributes = array(
	array(
		'name'=>'codproduto',
		'value'=>Yii::app()->format->formataCodigo($model->codproduto, 6),
	),
	array(
		'name'=>'codmarca',
		'value'=>isset($model->Marca)?CHtml::encode($model->Marca->marca . ' '):null,
	),
	'referencia',
	array(
		'label'=>'Grupo',
		'value'=>isset($model->SubGrupoProduto)?$model->SubGrupoProduto->GrupoProduto->grupoproduto:null,
	),
	array(
		'label'=>'Sub-Grupo',
		'value'=>isset($model->SubGrupoProduto)?$model->SubGrupoProduto->subgrupoproduto:null,
	),
	array(
		'name'=>'importado',
		'value'=>empty($model->importado)?"Não":"Sim",
	),
);

/* monta link com tooltip da descricao do ncm */
$this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>$attributes
	)
);
?>
</div>

<div class="span8">
<?php 
$this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name'=>'preco',
			'cssClass'=>'text-success',
			'value'=>isset($model->preco)?Yii::app()->format->formatNumber($model->preco):null,
			),
		array(
			'name'=>'codunidademedida',
			'value'=>isset($model->UnidadeMedida)?$model->UnidadeMedida->sigla:null,
		),		
		array(
			'name'=>'codtributacao',
			'value'=>isset($model->Tributacao)?$model->Tributacao->tributacao:null,
			),
		array(
			'name'=>'codtipoproduto',
			'value'=>isset($model->TipoProduto)?$model->TipoProduto->tipoproduto:null,
			),
		array(
			'name'=>'site',
			'value'=>empty($model->site)?"Não":"Sim",
			),
		array(
			'name'=>'descricaosite',
			'value'=>nl2br(CHtml::encode($model->descricaosite)),
			'type'=>'raw',
			),
		),
	)); 


?>
</div>
</div>

<?php  
$this->widget('UsuarioCriacao', array('model'=>$model));

?>

<small class="row-fluid">
	<div class="span9">
		<h3>
			Códigos de Barras
			<small class=""><a href="<?php echo Yii::app()->createUrl('produtoBarra/create', array('codproduto'=>$model->codproduto)); ?>"><i class="icon-plus"></i>Novo</a></small>
		</h3>
		<?php
			$this->widget(
				'zii.widgets.CListView', 
				array(
					'id' => 'ListagemBarra',
					'dataProvider' => new CActiveDataProvider('ProdutoBarra', array(
						'sort'=>array(
							'defaultOrder'=>'"ProdutoEmbalagem".quantidade ASC NULLS FIRST, variacao ASC NULLS FIRST, barras',
						),
						'pagination'=>false,
						'criteria'=>array(
							'condition'=>'t.codproduto = :codproduto',
							'with'=>array('ProdutoEmbalagem'),
							'params'=>array(':codproduto' => $model->codproduto),
							))),
					'itemView' => '/produtoBarra/_view',
					'template' => '{items} {pager}',
					'viewData' => array('produto' => $model),
				)
			);

		?>		
	</div>
	<div class="span3">
		<h3>
			Embalagens 
			<small class=""><a href="<?php echo Yii::app()->createUrl('produtoEmbalagem/create', array('codproduto'=>$model->codproduto)); ?>"><i class="icon-plus"></i>Nova</a></small>
		</h3>
		<?php
			$this->widget(
				'zii.widgets.CListView', 
				array(
					'id' => 'ListagemEmbalagem',
					'dataProvider' => new CActiveDataProvider('ProdutoEmbalagem', array(
						'sort'=>array(
							'defaultOrder'=>'quantidade asc',
						),
						'pagination'=>false,
						'criteria'=>array(
							'condition'=>'codproduto = :codproduto',
							'params'=>array(':codproduto' => $model->codproduto),
							))),
					'itemView' => '/produtoEmbalagem/_view',
					'template' => '{items} {pager}',
					'viewData' => array('produto' => $model),
				)
			);
		
		?>		
	</div>
</small>

<br>
<br>
<?php

$abaFiscal = $this->renderPartial(
	'_view_fiscal',
	array(
		'model'=>$model,
	),
	true
);

$abaImagens = $this->renderPartial(
	'_view_imagens',
	array(
		'model'=>$model,
	),
	true
);

$nfpb=new NotaFiscalProdutoBarra('search');

$nfpb->unsetAttributes();  // clear any default values

if(isset($_GET['NotaFiscalProdutoBarra']))
	Yii::app()->session['FiltroNotaFiscalProdutoBarraIndex'] = $_GET['NotaFiscalProdutoBarra'];

if (isset(Yii::app()->session['FiltroNotaFiscalProdutoBarraIndex']))
	$nfpb->attributes=Yii::app()->session['FiltroNotaFiscalProdutoBarraIndex'];

$nfpb->codproduto = $model->codproduto;

$abaNfpb = $this->renderPartial(
	'/notaFiscalProdutoBarra/index',
	array(
		'dataProvider'=>$nfpb->search(),
		'model'=>$nfpb,
	),
	true
);

$npb=new NegocioProdutoBarra('search');

$npb->unsetAttributes();  // clear any default values

if(isset($_GET['NegocioProdutoBarra']))
	Yii::app()->session['FiltroNegocioProdutoBarraIndex'] = $_GET['NegocioProdutoBarra'];

if (isset(Yii::app()->session['FiltroNegocioProdutoBarraIndex']))
	$npb->attributes=Yii::app()->session['FiltroNegocioProdutoBarraIndex'];

$npb->codproduto = $model->codproduto;
$npb->codnegociostatus = NegocioStatus::FECHADO;

$abaNpb = $this->renderPartial(
	'/negocioProdutoBarra/index',
	array(
		'dataProvider'=>$npb->search(),
		'model'=>$npb,
	),
	true
);

$this->widget('bootstrap.widgets.TbTabs', 
	array(
		'type' => 'tabs',
		'tabs' => 
			array(
				array('label' => 'Fiscal', 'content' => $abaFiscal, 'active' => true),
				array('label' => 'Imagens', 'content' => $abaImagens, 'active' => false),
				array('label' => 'Notas Fiscais', 'content' => $abaNfpb, 'active' => false),
				array('label' => 'Negócios', 'content' => $abaNpb, 'active' => false),
			)
	)
);

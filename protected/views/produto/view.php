<?php
$this->pagetitle = Yii::app()->name . ' - Detalhes Produto';
$this->breadcrumbs=array(
	'Produtos'=>array('index'),
	$model->produto,
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
array('label'=>'Alterar', 'icon'=>'icon-pencil', 'url'=>array('update','id'=>$model->codproduto)),
array('label'=>'Excluir', 'icon'=>'icon-trash', 'url'=>'#', 'linkOptions'=>	array('id'=>'btnExcluir')),
//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
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

<div class="span5">

<?php 

/* monta link com tooltip da descricao do ncm */
$ncm_descricao = "";
for ($i=1; $i<=strlen($model->ncm); $i++)
{
	$ncm_parte = substr($model->ncm, 0, $i);
	if ($ncm = Ncm::model()->find("ncm = :ncm_parte", array('ncm_parte'=>$ncm_parte)))
	{
		if (!empty($ncm_descricao))
			$ncm_descricao .= "\n\n";
		$ncm_descricao .= CHtml::encode(Yii::app()->format->formataNCM($ncm->ncm) . " - " . str_replace("'", "\"", $ncm->descricao));
	}
}
$ncm_descricao = "<a href='#' rel='tooltip' title='$ncm_descricao'>" . CHtml::encode(Yii::app()->format->formataNCM($model->ncm)) . "</a>";

$this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name'=>'codproduto',
			'value'=>Yii::app()->format->formataCodigo($model->codproduto, 6),
			),
		array(
			'name'=>'codmarca',
			'value'=>isset($model->Marca)?$model->Marca->marca:null,
			),
		'referencia',
		array(
			'name'=>'codunidademedida',
			'value'=>isset($model->UnidadeMedida)?$model->UnidadeMedida->sigla:null,
			),
		array(
			'name'=>'codsubgrupoproduto',
			'value'=>isset($model->SubGrupoProduto)?$model->SubGrupoProduto->GrupoProduto->grupoproduto . ' > ' . $model->SubGrupoProduto->subgrupoproduto:null,
			),
		array(
			'name'=>'importado',
			'value'=>empty($model->importado)?"Não":"Sim",
			),
		array(
			'name'=>'ncm',
			'value'=>$ncm_descricao,
			'type'=>'raw',
			),
		),
	)); 

?>
</div>

<div class="span7">
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

	$this->widget('UsuarioCriacao', array('model'=>$model));

?>
</div>
</div>

<?php $this->widget('UsuarioCriacao', array('model'=>$model)); ?>

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

<?php
$imgs = $model->getImagens();

if (sizeof($imgs) > 0)
{
	?>
		<h3>Imagens</h3>
		<div id="myCarousel" class="carousel slide">
			<!-- Carousel items -->
			<div class="carousel-inner">
				<?php
				$i=0;
				foreach ($imgs as $img)
				{
					?>
					<div class="item <?php echo ($i==0)?"active":""; ?> span12 text-center">
						<center>
							<a href="<?php echo Yii::app()->baseUrl . $img ?>" target="_blank">
								<?php //echo CHtml::image( Yii::app()->baseUrl . $img, '', array('style' => 'min-height: 60%')); ?>
								<?php echo CHtml::image( Yii::app()->baseUrl . $img, '', array('style' => 'max-height: 60%')); ?>
							</a>
						</center>
					</div>
					<?
					$i++;
				}
				?>

			</div>
			<ol class="carousel-indicators alert alert-info" >
				<?php
				for ($i = 0; $i<sizeof($imgs); $i++)
				{
					?>
						<li data-target="#myCarousel" data-slide-to="<?php echo $i; ?>" class="<?php echo ($i==0)?"active":""; ?>"></li>
					<?
				}
				?>
			</ol>
			<!-- Carousel nav -->
			<a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
			<a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
		</div>
	<?php
}


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

echo $abaNfpb;
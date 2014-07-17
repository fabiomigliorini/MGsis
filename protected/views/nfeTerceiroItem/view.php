<?php
$this->pagetitle = Yii::app()->name . ' - Item NFe de Terceiros';
$this->breadcrumbs=array(
	'NFe de Terceiros'=>array('nfeTerceiro/index'),
	$model->NfeTerceiro->nfechave=>array('nfeTerceiro/view', 'id' => $model->codnfeterceiro),
	$model->xprod,
);

$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('nfeTerceiro/view', 'id'=>$model->codnfeterceiro)),
	//array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	array('label'=>'Informar Detalhes', 'icon'=>'icon-pencil', 'url'=>array('update','id'=>$model->codnfeterceiroitem), 'visible'=>$model->podeEditar()),
	//array('label'=>'Excluir', 'icon'=>'icon-trash', 'url'=>'#', 'linkOptions'=>	array('id'=>'btnExcluir')),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);

Yii::app()->clientScript->registerCoreScript('yii');

?>
<script type="text/javascript">
/*<![CDATA[*/
$(document).ready(function(){
	jQuery('body').on('click','#btnExcluir',function() {
		bootbox.confirm("Excluir este registro?", function(result) {
			if (result)
				jQuery.yii.submitForm(document.body.childNodes[0], "<?php echo Yii::app()->createUrl('nfe-terceiro-item/delete', array('id' => $model->codnfeterceiroitem))?>",{});
		});
	});
});
/*]]>*/
</script>

<h1><?php echo $model->xprod; ?></h1>

<div class="row-fluid">
	<div class="span5">
	<?php 
	
		$attr = 
			array(
				array(
					'name'=>'vprod',
					'label'=>'Custo Produto',
					'value'=>Yii::app()->format->formatNumber($model->vprod),
				)
			);
		
		if (!empty($model->ipivipi))
			$attr[] = 
				array(
					'name'=>'ipivipi',
					'label'=>'IPI',
					'value'=>Yii::app()->format->formatNumber($model->ipivipi),
				);
		
		if (!empty($model->vicmsst))
			$attr[] = 
				array(
					'name'=>'vicmsst',
					'label'=>'ICMS ST',
					'value'=>Yii::app()->format->formatNumber($model->vicmsst),
				);
		
		if (!empty($model->vicmscomplementar))
			$attr[] =
				array(
					'name'=>'vicmscomplementar',
					'value'=>Yii::app()->format->formatNumber($model->vicmscomplementar),
				);
		
		if (!empty($model->complemento))
			$attr[] = 
				array(
					'name'=>'complemento',
					'value'=>Yii::app()->format->formatNumber($model->complemento),
				);
		
		if (!empty($model->vcusto))
			$attr[] = 
				array(
					'name'=>'vcusto',
					'value'=>Yii::app()->format->formatNumber($model->vcusto),
				);

		if (!empty($model->quantidade))
		{
			$quantidade = Yii::app()->format->formatNumber($model->quantidade, 3);
			if (isset($model->ProdutoBarra->ProdutoEmbalagem))
				$quantidade .= 
					' ('
					. Yii::app()->format->formatNumber($model->qcom, 3)
					. " {$model->ProdutoBarra->ProdutoEmbalagem->UnidadeMedida->sigla} * " 
					. Yii::app()->format->formatNumber($model->ProdutoBarra->ProdutoEmbalagem->quantidade, 3) 
					. ' )';
		
			$attr[] = 
				array(
					'name'=>'quantidade',
					'value'=>$quantidade,
				);
		}
		
		if (!empty($model->vcustounitario))
		$attr[] = 
			array(
				'name'=>'vcustounitario',
				'value'=>Yii::app()->format->formatNumber($model->vcustounitario),
			);
		
		if (!empty($model->vsugestaovenda))
		{
			$attr[]=
				array(
					'name'=>'codprodutobarra',
					'value'=>CHtml::link(CHtml::encode($model->ProdutoBarra->Produto->produto), array('produto/view', 'id'=>$model->ProdutoBarra->codproduto)),
					'type'=>'raw',
				);		
			$attr[]=
				array(
					'name'=>'margem',
					'value'=>Yii::app()->format->formatNumber($model->margem) . '%',
				);
			
			$venda = 0;
			if (isset($model->ProdutoBarra))
				$venda = $model->ProdutoBarra->Produto->preco;

			$cssVenda = 'text-success';

			if ($venda <= $model->vsugestaovenda * 0.97)
				$cssVenda = 'text-error';

			if ($venda >= $model->vsugestaovenda * 1.05)
				$cssVenda = 'text-warning';
			
			$attr[]=
				array(
					'label'=>'Venda',
					'value'=>Yii::app()->format->formatNumber($venda),
					'cssClass'=>$cssVenda,
				);
			$attr[]=
				array(
					'name'=>'vsugestaovenda',
					'value'=>Yii::app()->format->formatNumber($model->vsugestaovenda),
				);
			
			foreach ($model->ProdutoBarra->Produto->ProdutoEmbalagems as $pe)
			{
				if (!empty($pe->preco))
					$venda = $pe->preco;
				else 
					$venda = $model->ProdutoBarra->Produto->preco * $pe->quantidade;
				
				$sugestao = $model->vsugestaovenda * $pe->quantidade;
				$cssVenda = 'text-success';
				if ($venda <= $sugestao * 0.97)
					$cssVenda = 'text-error';

				if ($venda >= $sugestao * 1.05)
					$cssVenda = 'text-warning';

				$attr[]=
					array(
						'label'=>$pe->UnidadeMedida->sigla . ' ' . $pe->descricao,
						'value'=>Yii::app()->format->formatNumber($venda),
						'cssClass'=>$cssVenda,
					);
				$attr[]=
					array(
						'label'=>'Sugestão',
						'value'=>Yii::app()->format->formatNumber($sugestao),
					);
			}
		}
		
		$this->widget('bootstrap.widgets.TbDetailView',array(
			'data'=>$model,
			'attributes'=>$attr,
		)); 


		?>
	</div>
	<small class="span4">
	<?php 
	
		$ncm = CHtml::encode(Yii::app()->format->formataNCM($model->ncm));
		$cssNcm = 'text-success';
		
		if (isset($model->ProdutoBarra))
		{
			if ($model->ncm <> $model->ProdutoBarra->Produto->ncm)
			{
				$ncm .= '&nbspNota<br>' . CHtml::encode(Yii::app()->format->formataNCM($model->ProdutoBarra->Produto->ncm)) . '&nbspCadastro&nbspProduto';
				$cssNcm = 'text-error';
			}
		}
		else
		{
			$cssNcm = '';
		}
		
		$this->widget('bootstrap.widgets.TbDetailView',array(
			'data'=>$model,
			'attributes'=>array(
				'codnfeterceiroitem',
				'nitem',
				'cprod',
				'cean',
				'ceantrib',
				array(
					'name'=>'ncm',
					'value'=>$ncm,
					'cssClass'=>$cssNcm,
					'type'=>'raw',
				),
				array(
					'name'=>'qcom',
					'value'=>Yii::app()->format->formatNumber($model->qcom, 3) . ' ' . $model->ucom,
					'cssClass'=>'text-success',
				),
				array(
					'name'=>'vuncom',
					'value'=>Yii::app()->format->formatNumber($model->vuncom),
					'cssClass'=>'text-success',
				),
				array(
					'name'=>'vprod',
					'value'=>Yii::app()->format->formatNumber($model->vprod),
				),
				array(
					'name'=>'qtrib',
					'value'=>Yii::app()->format->formatNumber($model->qtrib, 3) . ' ' . $model->utrib,
				),
				array(
					'name'=>'vuntrib',
					'value'=>Yii::app()->format->formatNumber($model->vuntrib),
				),
				array(
					'name'=>'cfop',
					'value'=>CHtml::link(CHtml::encode($model->cfop), array('cfop/view', 'id'=>$model->cfop)),
					'type'=>'raw',
				),
				'cst',
				'csosn',
			),
		)); 



		?>
	</small>
	<small class="span3">
		<?php 
		$this->widget('bootstrap.widgets.TbDetailView',array(
			'data'=>$model,
			'attributes'=>array(
				array(
					'name'=>'vbc',
					'value'=>Yii::app()->format->formatNumber($model->vbc),
				),
				array(
					'name'=>'picms',
					'value'=>Yii::app()->format->formatNumber($model->picms),
				),
				array(
					'name'=>'vicms',
					'value'=>Yii::app()->format->formatNumber($model->vicms),
				),
				array(
					'name'=>'vbcst',
					'value'=>Yii::app()->format->formatNumber($model->vbcst),
				),
				array(
					'name'=>'picmsst',
					'value'=>Yii::app()->format->formatNumber($model->picmsst),
				),
				array(
					'name'=>'vicmsst',
					'value'=>Yii::app()->format->formatNumber($model->vicmsst),
				),
				array(
					'name'=>'ipivbc',
					'value'=>Yii::app()->format->formatNumber($model->ipivbc),
				),
				array(
					'name'=>'ipipipi',
					'value'=>Yii::app()->format->formatNumber($model->ipipipi),
				),
				array(
					'name'=>'ipivipi',
					'value'=>Yii::app()->format->formatNumber($model->ipivipi),
				),
			),
		)); 

		?>
	</small>
</div>

<?php
$this->widget('UsuarioCriacao', array('model'=>$model));
?>
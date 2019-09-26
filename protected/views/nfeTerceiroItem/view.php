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
<?php if (!empty($model->ProdutoBarra)) { ?>
	<h2>
		<?php
		switch ($model->ProdutoBarra->Produto->abc) {
			case 'A':
				$badge = 'badge-success';
				break;
			case 'B':
				$badge = 'badge-warning';
				break;
			default:
				$badge = 'badge-important';
				break;
		}
		$produto = '<B>' . CHtml::link(CHtml::encode($model->ProdutoBarra->Produto->produto), array('produto/view', 'id'=>$model->ProdutoBarra->codproduto));
		$produto .= " <span class='badge {$badge}'>{$model->ProdutoBarra->Produto->abc}</span>";


		if (!empty($model->ProdutoBarra->ProdutoVariacao->variacao)) {
				$produto .= ' | ' . $model->ProdutoBarra->ProdutoVariacao->variacao . '</B>';
		} else {
				$produto .= ' | { Sem Variação }</B>';
		}



		if (!empty($model->ProdutoBarra->Produto->inativo))
		{
			$produto .= "
				<span class='label label-important pull-center'>
				Inativado em {$model->ProdutoBarra->Produto->inativo}
				</span>
				";
		}
		echo $produto;
		?>
	</h2>
<?php } ?>
<?php if (!empty($model->infadprod)) { ?>
	<p class="lead">
		<?php echo CHtml::encode($model->infadprod); ?>
	</p>
<?php } ?>


<div class="row-fluid">
	<div class="span5">
	<?php

		$attr = [];
		// if (isset($model->ProdutoBarra))
		// {
		// 	switch ($model->ProdutoBarra->Produto->abc) {
		// 		case 'A':
		// 			$badge = 'badge-success';
		// 			break;
		// 		case 'B':
		// 			$badge = 'badge-warning';
		// 			break;
		// 		default:
		// 			$badge = 'badge-important';
		// 			break;
		// 	}
		// 	$produto = '<B>' . CHtml::link(CHtml::encode($model->ProdutoBarra->Produto->produto), array('produto/view', 'id'=>$model->ProdutoBarra->codproduto));
		// 	$produto .= " <span class='badge {$badge}'>{$model->ProdutoBarra->Produto->abc}</span>";
		//
		//
		// 	if (!empty($model->ProdutoBarra->ProdutoVariacao->variacao)) {
		// 			$produto .= '<BR>' . $model->ProdutoBarra->ProdutoVariacao->variacao . '</B>';
		// 	} else {
		// 			$produto .= '<BR>{ Sem Variação }</B>';
		// 	}
		//
		//
		//
		// 	if (!empty($model->ProdutoBarra->Produto->inativo))
		// 	{
		// 		$produto .= "
		// 			<span class='label label-important pull-center'>
		// 			Inativado em {$model->ProdutoBarra->Produto->inativo}
		// 			</span>
		// 			";
		// 	}
		//
		// 	$attr[]=
		// 		array(
		// 			'name'=>'codprodutobarra',
		// 			'value'=>$produto,
		// 			'type'=>'raw',
		// 		);
		//
		// }

		$attr[] =
			array(
				'name'=>'vprod',
				'label'=>'Custo Produto',
				'value'=>Yii::app()->format->formatNumber($model->vprod) . ' (' . Yii::app()->format->formatNumber($model->vprod/$model->quantidade) . ')',
			);

		if (!empty($model->ipivipi))
			$attr[] =
				array(
					'name'=>'ipivipi',
					'label'=>'IPI',
					'value'=>Yii::app()->format->formatNumber($model->ipivipi) . ' (' . Yii::app()->format->formatNumber($model->ipivipi/$model->quantidade) . ')',
				);

		if (!empty($model->vicmsstutilizado))
			$attr[] =
				array(
					'name'=>'vicmsstutilizado',
					'label'=>'ICMS ST',
					'value'=>Yii::app()->format->formatNumber($model->vicmsstutilizado) . ' (' . Yii::app()->format->formatNumber($model->vicmsstutilizado/$model->quantidade) . ')',
				);

		if (!empty($model->vicmsgarantido))
			$attr[] =
				array(
					'name'=>'vicmsgarantido',
					'value'=>Yii::app()->format->formatNumber($model->vicmsgarantido) . ' (' . Yii::app()->format->formatNumber($model->vicmsgarantido/$model->quantidade) . ')',
				);

		if ($model->complemento != 0)
			$attr[] =
				array(
					'name'=>'complemento',
					'value'=>Yii::app()->format->formatNumber($model->complemento) . ' (' . Yii::app()->format->formatNumber($model->complemento/$model->quantidade) . ')',
				);

		if (!empty($model->vdesc)) {
			$attr[] = [
				'name'=>'vdesc',
				'label'=>'Desconto',
				'value'=>'-' . Yii::app()->format->formatNumber($model->vdesc) . ' (-' . Yii::app()->format->formatNumber($model->vdesc/$model->quantidade) . ')',
			];
		}

		if (!empty($model->vicmscredito)) {
			$attr[] = [
				'name'=>'vicmscredito',
				'label'=>'Credito ICMS',
				'value'=>'-' . Yii::app()->format->formatNumber($model->vicmscredito) . ' (-' . Yii::app()->format->formatNumber($model->vicmscredito/$model->quantidade) . ')',
			];
		}

		if (!empty($model->vcusto)) {
			$attr[] = [
				'name'=>'vcusto',
				'value'=>Yii::app()->format->formatNumber($model->vcusto) . ' (' . Yii::app()->format->formatNumber($model->vcusto/$model->quantidade) . ')',
			];
		}

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

		if (!empty($model->vicmsvenda)) {
			$attr[] = [
				'label'=>'ICMS Venda',
				'value'=>Yii::app()->format->formatNumber($model->vicmsvenda) . ' (' . Yii::app()->format->formatNumber($model->picmsvenda, 0) . '%)',
			];
		}

		if (!empty($model->vmargem)) {
			$attr[] = [
				'label'=>'Margem',
				'value'=>Yii::app()->format->formatNumber($model->vmargem) . ' (' . Yii::app()->format->formatNumber($model->margem, 0) . '%)',
			];
		}


		if (!empty($model->vsugestaovenda))
		{

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
					'name'=>'vsugestaovenda',
					'value'=>Yii::app()->format->formatNumber($model->vsugestaovenda),
				);
			$attr[]=
				array(
					'label'=>'Venda',
					'value'=>Yii::app()->format->formatNumber($venda),
					'cssClass'=>$cssVenda,
				);

			if (isset($model->ProdutoBarra))
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
								'label'=>'Sugestão',
								'value'=>Yii::app()->format->formatNumber($sugestao),
							);
					$attr[]=
						array(
							'label'=>$pe->UnidadeMedida->sigla . ' ' . $pe->descricao,
							'value'=>Yii::app()->format->formatNumber($venda),
							'cssClass'=>$cssVenda,
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
			if ($model->ncm <> $model->ProdutoBarra->Produto->Ncm->ncm)
			{
				$ncm .= '&nbspNota<br>' . CHtml::encode(Yii::app()->format->formataNCM($model->ProdutoBarra->Produto->Ncm->ncm)) . '&nbspCadastro&nbspProduto';
				$cssNcm = 'text-error';
			}
		}
		else
		{
			$cssNcm = '';
		}

		$attr = [
			'codnfeterceiroitem',
			'nitem',
			'cprod',
		];

		$css = '';
		if (!empty($model->codprodutobarra)) {
			$css = $model->ProdutoBarra->ProdutoVariacao->barrasCadastrado($model->cean)?'text-success':'text-error';
		}
		$attr[] =	[
			'name'=>'cean',
			'value'=>$model->cean,
			'cssClass'=>$css,
			'type'=>'raw',
		];
		$css = '';
		if (!empty($model->codprodutobarra)) {
			$css = $model->ProdutoBarra->ProdutoVariacao->barrasCadastrado($model->ceantrib)?'text-success':'text-error';
		}
		$attr[] =	[
			'name'=>'ceantrib',
			'value'=>$model->ceantrib,
			'cssClass'=>$css,
			'type'=>'raw',
		];
		$attr[] =	[
			'name'=>'ncm',
			'value'=>$ncm,
			'cssClass'=>$cssNcm,
			'type'=>'raw',
		];
		$css = '';
		$value = [(empty($model->cest)?'Vazio':$model->cest) . " Nota"];
		if (!empty($model->codprodutobarra)) {
			$css = 'text-error';
			if (!empty($model->ProdutoBarra->Produto->codcest)) {
				echo 'entyrou';
				if ($model->ProdutoBarra->Produto->Cest->cest == $model->cest) {
					$css = 'text-success';
				} elseif (empty($model->cest)) {
					$value[] = $model->ProdutoBarra->Produto->Cest->cest . " Produto";
				}
			} elseif (empty($model->cest)) {
				$css = 'text-success';
			}
		}
		$value = implode('<BR />', $value);
		$attr[] =	[
			'name'=>'cest',
			'value'=>$value,
			'cssClass'=>$css,
			'type'=>'raw',
		];
		$attr[] =	[
			'name'=>'qcom',
			'value'=>Yii::app()->format->formatNumber($model->qcom, 3) . ' ' . $model->ucom,
			// 'cssClass'=>'text-success',
		];
		$attr[] =	[
			'name'=>'vuncom',
			'value'=>Yii::app()->format->formatNumber($model->vuncom),
			// 'cssClass'=>'text-success',
		];
		$attr[] =	[
			'name'=>'vprod',
			'value'=>Yii::app()->format->formatNumber($model->vprod),
		];
		$attr[] =	[
			'name'=>'qtrib',
			'value'=>Yii::app()->format->formatNumber($model->qtrib, 3) . ' ' . $model->utrib,
		];
		$attr[] =	[
			'name'=>'vuntrib',
			'value'=>Yii::app()->format->formatNumber($model->vuntrib),
		];
		$attr[] =	[
			'name'=>'cfop',
			'value'=>CHtml::link(CHtml::encode($model->cfop), array('cfop/view', 'id'=>$model->cfop)),
			'type'=>'raw',
		];
		$cst = $model->cst;
		$cst .= $model->csosn;
		$badge = '';
		if (!empty($model->codprodutobarra)) {
			$badge = 'badge-important';
			if ($model->ProdutoBarra->Produto->codtributacao == $model->codtributacao) {
				$badge = 'badge-success';
			}
		}
		if (!empty($model->codtributacao)) {
			$cst .= " <span class='badge {$badge}'>{$model->Tributacao->tributacao}</span>";
		}
		$attr[] =	[
			'name'=>'cst',
			'value'=>$cst,
			'type'=>'raw',
		];

		$this->widget('bootstrap.widgets.TbDetailView',array(
			'data'=>$model,
			'attributes'=>$attr,
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

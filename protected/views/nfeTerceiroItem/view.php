<?php
$this->pagetitle = Yii::app()->name . ' - Item NFe de Terceiros';
$this->breadcrumbs=array(
    'NFe de Terceiros'=>array('nfeTerceiro/index'),
    $model->NfeTerceiro->nfechave=>array('nfeTerceiro/view', 'id' => $model->codnfeterceiro),
    $model->xprod,
);

$this->menu=array(
    array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('nfeTerceiro/view', 'id'=>$model->codnfeterceiro)),
    array('label'=>'Abrir Kit', 'icon'=>'icon-plus', 'url'=>array('dividir', 'id'=>$model->codnfeterceiroitem)),
    array('label'=>'Informar Detalhes', 'icon'=>'icon-pencil', 'url'=>array('update','id'=>$model->codnfeterceiroitem), 'visible'=>$model->podeEditar()),
    //array('label'=>'Excluir', 'icon'=>'icon-trash', 'url'=>'#', 'linkOptions'=>	array('id'=>'btnExcluir')),
    //array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);

Yii::app()->clientScript->registerCoreScript('yii');

$quantidade = $model->quantidade;
if ($quantidade == 0) {
    $quantidade = 1;
}

$embs = [];
if (!empty($model->codprodutobarra)) {
    foreach ($model->ProdutoBarra->ProdutoVariacao->ProdutoBarraS as $pb) {
        if (empty($pb->codprodutoembalagem)) {
            $emb = 1;
            $sigla = $pb->Produto->UnidadeMedida->sigla;
            $preco = floatval($pb->Produto->preco);
        } else {
            $emb = floatval($pb->ProdutoEmbalagem->quantidade);
            $sigla = $pb->ProdutoEmbalagem->UnidadeMedida->sigla;
            $preco = floatval($pb->ProdutoEmbalagem->preco);
            if (empty($preco)) {
                $preco = floatval($pb->Produto->preco) * $emb;
            }
        }
        if (!isset($embs[$emb])) {
            $cssVenda = 'success';
            $sugestao = floatval($model->vsugestaovenda) * $emb;
            if ($preco <= $sugestao * 0.97) {
                $cssVenda = 'error';
            }
            if ($preco >= $sugestao * 1.05) {
                $cssVenda = 'warning';
            }
            $embs[$emb] = (object)[
                'quantidade' => $quantidade / $emb,
                'embalagem' => $emb,
                'sigla' => $sigla,
                'vsugestaovenda' => $sugestao,
                'preco' => $preco,
                'css' => $cssVenda,
                'barras' => []
            ];
        }
        $embs[$emb]->barras[] = $pb->barras;
    }
}
ksort($embs);

?>
<!-- <pre>
    <?php print_r($embs); ?>
</pre> -->

<script type="text/javascript">
/*<![CDATA[*/
function btnConferenciaClick(conferencia) {
  bootbox.confirm("Tem Certeza?", function(result) {
    if (!result) {
      return;
    }
    $.ajax({
      url: "<?php echo Yii::app()->createUrl('nfeTerceiroItem/conferencia')?>",
      data: {
        id: <?php echo $model->codnfeterceiroitem ?>,
        conferencia: conferencia
      },
    }).done(function(resp) {
      location.reload();
    }).fail(function( jqxhr, textStatus, error ) {
      $.notify("Erro ao marcar item como conferido!", { position:"right bottom", className:"error", autoHideDelay: 15000 });
    });
  });
}

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
<?php if (!empty($model->ProdutoBarra)) {
    ?>
	<h3>
        <?php
            switch ($model->ProdutoBarra->Produto->abc) {
                case 'A':
                    $label = 'label-success';
                    break;
                case 'B':
                    $label = 'label-warning';
                    break;
                case 'C':
                    $label = 'label-info';
                    break;
                default:
                    $label = 'label-important';
                    break;
            }
            $produto = '<B>' . CHtml::link(CHtml::encode($model->ProdutoBarra->Produto->produto), array('produto/view', 'id'=>$model->ProdutoBarra->codproduto));
            if (!empty($model->ProdutoBarra->ProdutoVariacao->variacao)) {
                $produto .= ' | ' . $model->ProdutoBarra->ProdutoVariacao->variacao;
            }
            $produto .= "</B> <span class='label {$label}'>{$model->ProdutoBarra->Produto->abc}</span>";



            if (!empty($model->ProdutoBarra->Produto->inativo)) {
                $produto .= "
        				<span class='label label-important pull-center'>
        				Inativado em {$model->ProdutoBarra->Produto->inativo}
        				</span>
        				";
            }
            echo $produto;
        ?>
	</h3>
<?php
} ?>
<?php if (!empty($model->infadprod)) : ?>
    <p class="lead">
		<?php echo CHtml::encode($model->infadprod); ?>
	</p>
<?php endif; ?>
<div style="margin-bottom: 15px">
    <div class="btn-group">
        <a class="btn dropdown-toggle <?php echo (empty($model->conferencia)?'btn-warning':'btn-success') ?>" data-toggle="dropdown" href="#">
            <?php echo (empty($model->conferencia)?'Não Conferido':'Conferido'); ?>
            <?php if (!empty($model->codusuarioconferencia)): ?>
                por <?php echo $model->UsuarioConferencia->usuario; ?>
            <?php endif; ?>
            <?php if (!empty($model->conferencia)): ?>
                em <?php echo $model->conferencia; ?>
            <?php endif; ?>
            <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            <?php if (empty($model->conferencia)): ?>
                <li>
                    <a href='#' class='' id="btnConferenciaTrue" onclick="btnConferenciaClick(true)">
                        <span class='badge badge-success'>&#10004;</span>
                        Marcar como Conferido
                    </a>
                </li>
            <?php else: ?>
                <li>
                    <a href='#' class='' id="btnConferenciaFalse" onclick="btnConferenciaClick(false)">
                        <span class='badge badge-warning'>?</span>
                        Marcar como não conferido
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</div>


<div class="row-fluid">

    <div class="span4">

        <table class="table table-hover table-condensed">
            <tr>
                <th style="text-align: right">
                    Quantidade
                </th>
                <th style="text-align: center">
                    Embalagem
                </th>
                <th>
                    Barras
                </th>
                <th style="text-align: right">
                    Venda
                </th>
                <th style="text-align: right">
                    Sugestão
                </th>
            </tr>
            <?php foreach ($embs as $emb): ?>
                <tr class="<?php echo $emb->css ?>">
                    <td style="text-align: right">
                        <b>
                            <?php echo Yii::app()->format->formatNumber($emb->quantidade, 1) ?>
                        </b>
                    </td>
                    <td style="text-align: center">
                        <?php echo $emb->sigla; ?>
                        <b>
                            <?php if ($emb->embalagem > 1): ?>
                                C/<?php echo $emb->embalagem; ?>
                            <?php endif; ?>
                        </b>
                    </td>
                    <td>
                        <?php foreach ($emb->barras as $barras): ?>
                            <?php if (substr($barras, 0, 3) == '234'): ?>
                                <b class="text-error">
                                    <?php echo $barras ?>
                                </b>
                            <?php else: ?>
                                <b class="text-success">
                                    <?php echo $barras ?>
                                </b>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </td>
                    <td style="text-align: right">
                        <b>
                            <?php echo Yii::app()->format->formatNumber($emb->preco, 2) ?>
                        </b>
                    </td>
                    <td style="text-align: right" class="muted">
                        <?php echo Yii::app()->format->formatNumber($emb->vsugestaovenda, 2) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <?php if (!empty($model->observacoes)): ?>
            <div class="span12">
                <b>Observações</b><br />
                <?php echo nl2br($model->observacoes); ?>
            </div>
        <?php endif; ?>


    </div>
	<div class="span3">
	<?php

        $attr = [];

        if ($model->quantidade > 0) {
            $attr[] = array(
                'name'=>'vprod',
                'label'=>'Custo Produto',
                'value'=>Yii::app()->format->formatNumber($model->vprod) . ' (' . Yii::app()->format->formatNumber($model->vprod/$quantidade) . ')',
            );
        }

        if (!empty($model->ipivipi)) {
            $attr[] = array(
                'name'=>'ipivipi',
                'label'=>'IPI',
                'value'=>Yii::app()->format->formatNumber($model->ipivipi) . ' (' . Yii::app()->format->formatNumber($model->ipivipi/$quantidade) . ')',
            );
        }

        if (!empty($model->vicmsstutilizado)) {
            $cssSt = '';
            if ($model->vicmsst != $model->vicmsstutilizado) {
                $cssSt = 'text-error';
            }
            $str = Yii::app()->format->formatNumber($model->vicmsstutilizado) . ' (' . Yii::app()->format->formatNumber($model->vicmsstutilizado/$quantidade) . ')';
            if (!empty($model->mva)) {
                $str .= ' - MVA ' . Yii::app()->format->formatNumber($model->mva) . '% @ ' . Yii::app()->format->formatNumber($model->picmsbasereducao * 100, 2) . '%';
            }
            $attr[] =
                array(
                    'name'=>'vicmsstutilizado',
                    'label'=>'ICMS ST',
                    'value'=>$str,
                    'cssClass'=>$cssSt,
                );
        }

        if (!empty($model->vicmsgarantido)) {
            $attr[] =
                array(
                    'name'=>'vicmsgarantido',
                    'value'=>Yii::app()->format->formatNumber($model->vicmsgarantido) . ' (' . Yii::app()->format->formatNumber($model->vicmsgarantido/$quantidade) . ')',
                );
        }

        if ($model->complemento != 0) {
            $attr[] =
                array(
                    'name'=>'complemento',
                    'value'=>Yii::app()->format->formatNumber($model->complemento) . ' (' . Yii::app()->format->formatNumber($model->complemento/$quantidade) . ')',
                );
        }

        if (!empty($model->vdesc)) {
            $attr[] = [
                'name'=>'vdesc',
                'label'=>'Desconto',
                'value'=>'-' . Yii::app()->format->formatNumber($model->vdesc) . ' (-' . Yii::app()->format->formatNumber($model->vdesc/$quantidade) . ')',
            ];
        }

        if (!empty($model->vfrete)) {
            $attr[] = [
                'name'=>'vfrete',
                'label'=>'Frete',
                'value'=>Yii::app()->format->formatNumber($model->vfrete) . ' (' . Yii::app()->format->formatNumber($model->vfrete/$quantidade) . ')',
            ];
        }

        if (!empty($model->vseg)) {
            $attr[] = [
                'name'=>'vseg',
                'label'=>'Seguro',
                'value'=>Yii::app()->format->formatNumber($model->vseg) . ' (' . Yii::app()->format->formatNumber($model->vseg/$quantidade) . ')',
            ];
        }

        if (!empty($model->voutro)) {
            $attr[] = [
                'name'=>'voutro',
                'label'=>'Outro',
                'value'=>Yii::app()->format->formatNumber($model->voutro) . ' (' . Yii::app()->format->formatNumber($model->voutro/$quantidade) . ')',
            ];
        }

        if (!empty($model->vicmscredito) && empty($model->vicmsstutilizado)) {
            $attr[] = [
                'name'=>'vicmscredito',
                'label'=>'Credito ICMS',
                'value'=>'-' . Yii::app()->format->formatNumber($model->vicmscredito) . ' (-' . Yii::app()->format->formatNumber($model->vicmscredito/$quantidade) . ') @ ' . Yii::app()->format->formatNumber($model->picmsbasereducao * 100, 2) . '%',
            ];
        }

        if (!empty($model->vcusto)) {
            $attr[] = [
                'name'=>'vcusto',
                'value'=>Yii::app()->format->formatNumber($model->vcusto) . ' (' . Yii::app()->format->formatNumber($model->vcusto/$quantidade) . ')',
            ];
        }

        if (!empty($model->quantidade)) {
            $quantidade = Yii::app()->format->formatNumber($model->quantidade, 3);
            if (isset($model->ProdutoBarra->ProdutoEmbalagem)) {
                $quantidade .=
                    ' ('
                    . Yii::app()->format->formatNumber($model->qcom, 3)
                    . " {$model->ProdutoBarra->ProdutoEmbalagem->UnidadeMedida->sigla} * "
                    . Yii::app()->format->formatNumber($model->ProdutoBarra->ProdutoEmbalagem->quantidade, 3)
                    . ' )';
            }

            $attr[] =
                array(
                    'name'=>'quantidade',
                    'value'=>$quantidade,
                );
        }

        if (!empty($model->vcustounitario)) {
            $attr[] =
            array(
                'name'=>'vcustounitario',
                'value'=>Yii::app()->format->formatNumber($model->vcustounitario),
            );
        }

        if (!empty($model->vicmsvenda) && empty($model->vicmsstutilizado)) {
            $attr[] = [
                'label'=>'ICMS Venda',
                'value'=>Yii::app()->format->formatNumber($model->vicmsvenda) . ' (' . Yii::app()->format->formatNumber($model->picmsvenda, 2) . '% @ ' . Yii::app()->format->formatNumber($model->picmsbasereducao * 100, 2) . '%)',
            ];
        }

        if (!empty($model->vmargem)) {
            $attr[] = [
                'label'=>'Margem',
                'value'=>Yii::app()->format->formatNumber($model->vmargem) . ' (' . Yii::app()->format->formatNumber($model->margem, 2) . '%)',
            ];
        }


        if (!empty($model->vsugestaovenda)) {
            $venda = 0;
            if (isset($model->ProdutoBarra)) {
                $venda = $model->ProdutoBarra->Produto->preco;
            }

            $cssVenda = 'text-success';

            if ($venda <= $model->vsugestaovenda * 0.97) {
                $cssVenda = 'text-error';
            }

            if ($venda >= $model->vsugestaovenda * 1.05) {
                $cssVenda = 'text-warning';
            }

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

            if (isset($model->ProdutoBarra)) {
                foreach ($model->ProdutoBarra->Produto->ProdutoEmbalagems as $pe) {
                    if (!empty($pe->preco)) {
                        $venda = $pe->preco;
                    } else {
                        $venda = $model->ProdutoBarra->Produto->preco * $pe->quantidade;
                    }

                    $sugestao = $model->vsugestaovenda * $pe->quantidade;
                    $cssVenda = 'text-success';
                    if ($venda <= $sugestao * 0.97) {
                        $cssVenda = 'text-error';
                    }

                    if ($venda >= $sugestao * 1.05) {
                        $cssVenda = 'text-warning';
                    }

                    $str = Yii::app()->format->formatNumber($sugestao);
                    //$str .= ' (' . Yii::app()->format->formatNumber($sugestao / $pe->quantidade, 2) . ')';
                    $attr[]=
                            array(
                                'label'=>'Sugestão',
                                'value'=>$str,
                            );

                    $str = Yii::app()->format->formatNumber($venda);
                    $str .= ' (' . Yii::app()->format->formatNumber($venda / $pe->quantidade, 2) . ')';
                    $attr[]=
                        array(
                            'label'=>$pe->UnidadeMedida->sigla . ' ' . $pe->descricao,
                            'value'=>$str,
                            'cssClass'=>$cssVenda,
                        );
                }
            }
        }

        $this->widget('bootstrap.widgets.TbDetailView', array(
            'data'=>$model,
            'attributes'=>$attr,
        ));


        ?>
	</div>
	<small class="span3">
	<?php

        $ncm = CHtml::encode(Yii::app()->format->formataNCM($model->ncm));
        $cssNcm = 'text-success';

        if (isset($model->ProdutoBarra)) {
            if ($model->ncm <> $model->ProdutoBarra->Produto->Ncm->ncm) {
                $ncm .= '&nbspNota<br>' . CHtml::encode(Yii::app()->format->formataNCM($model->ProdutoBarra->Produto->Ncm->ncm)) . '&nbspCadastro&nbspProduto';
                $cssNcm = 'text-error';
            }
        } else {
            $cssNcm = '';
        }

        $attr = [
            'codnfeterceiroitem',
            'nitem',
            'cprod',
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

        if ($model->orig !== null) {
          $arrOrig = [
            0	=> 'Nacional, exceto as indicadas nos códigos 3, 4, 5 e 8.',
            1 => 'Estrangeira – Importação direta, exceto a indicada no código 6',
            2 => 'Estrangeira – Adquirida no mercado interno, exceto a indicada no código 7.',
            3 => 'Nacional, mercadoria ou bem com Conteúdo de Importação superior a 40% (quarenta por cento) e inferior ou igual a 70% (setenta por cento).',
            4 => 'Nacional, cuja produção tenha sido feita em conformidade com os processos produtivos básicos (PPB) de que tratam o Decreto-Lei nº 288/1967, e as Leis nºs 8.248/1991, 8.387/1991, 10.176/2001 e 11.484/2007.',
            5 => 'Nacional, mercadoria ou bem com Conteúdo de Importação inferior ou igual a 40% (quarenta por cento).',
            6 => 'Estrangeira – Importação direta, sem similar nacional, constante em lista de Resolução CAMEX e gás natural.',
            7 => 'Estrangeira – Adquirida no mercado interno, sem similar nacional, constante em lista de Resolução CAMEX e gás natural.',
            8 => 'Nacional, mercadoria ou bem com Conteúdo de Importação superior a 70% (setenta por cento).',
          ];

          $orig = isset($arrOrig[$model->orig])?$arrOrig[$model->orig]:'';
          $orig = "{$model->orig} - {$orig}";

          $css = '';
          if (!empty($model->codprodutobarra)) {
            $importado = false;
            if (in_array($model->orig, [1, 2, 6, 7])) {
              $importado = true;
            }
            $css = 'text-error';
            if ($importado == $model->ProdutoBarra->Produto->importado) {
              $css = 'text-success';
            }
          }

          $attr[] =	[
            'name'=>'orig',
            'value'=>$orig,
            'cssClass'=>$css,
            'type'=>'raw',
          ];
        }


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
        $value = [(empty($model->cest)?'Vazio':Yii::app()->format->formataCest($model->cest)) . " Nota"];
        if (!empty($model->codprodutobarra)) {
            $css = 'text-error';
            if (!empty($model->ProdutoBarra->Produto->codcest)) {
                if ($model->ProdutoBarra->Produto->Cest->cest == $model->cest) {
                    $css = 'text-success';
                } elseif (empty($model->cest)) {
                    $value[] = Yii::app()->format->formataCest($model->ProdutoBarra->Produto->Cest->cest) . " Produto";
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

        $this->widget('bootstrap.widgets.TbDetailView', array(
            'data'=>$model,
            'attributes'=>$attr,
        ));

        ?>
	</small>
	<small class="span2">
    <?php
        $this->widget('bootstrap.widgets.TbDetailView', array(
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

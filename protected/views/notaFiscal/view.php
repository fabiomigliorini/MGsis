<?php
$this->pagetitle = Yii::app()->name . ' - Detalhes Nota Fiscal';
$this->breadcrumbs=array(
	'Notas Fiscais'=>array('index'),
	Yii::app()->format->formataNumeroNota($model->emitida, $model->serie, $model->numero),
);

if (
	$model->codstatus == NotaFiscal::CODSTATUS_AUTORIZADA
	|| $model->codstatus == NotaFiscal::CODSTATUS_INUTILIZADA
	|| $model->codstatus == NotaFiscal::CODSTATUS_CANCELADA
	)
	$bloqueado = true;
else
	$bloqueado = false;

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
array('label'=>'Nova', 'icon'=>'icon-plus', 'url'=>array('create')),
array('label'=>'Alterar', 'icon'=>'icon-pencil', 'url'=>array('update','id'=>$model->codnotafiscal), 'visible' => !$bloqueado),
array('label'=>'Excluir', 'icon'=>'icon-trash', 'url'=>'#', 'linkOptions'=>	array('id'=>'btnExcluir'), 'visible' => !$bloqueado),
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
				jQuery.yii.submitForm(document.body.childNodes[0], "<?php echo Yii::app()->createUrl('notaFiscal/delete', array('id' => $model->codnotafiscal))?>",{});
		});
	});
	
	// botão delete da embalagem
	jQuery(document).on('click','a.delete-barra',function(e) {
	
		//evita redirecionamento da pagina
		e.preventDefault();
		
		// pega url para delete
		var url = jQuery(this).attr('href');
		
		//pede confirmacao
		bootbox.confirm("Excluir este Item?", function(result) {
			
			// se confirmou
			if (result) {
				
				//faz post
				jQuery.ajax({
					type: 'POST',
					url: url,
					
					//se sucesso, atualiza listagem de embalagens
					success: function(){
						location.reload();
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

<h1><?php echo CHtml::encode(Yii::app()->format->formataCodigo($model->codnotafiscal)); ?> - <?php echo CHtml::encode(Yii::app()->format->formataNumeroNota($model->emitida, $model->serie, $model->numero)); ?></h1>


<div class="row-fluid">
	<div class="span2">
	<?php 
	$this->widget('bootstrap.widgets.TbDetailView',array(
		'data'=>$model,
		'attributes'=>array(
			array(
				'name'=>'codnotafiscal',
				'value'=>Yii::app()->format->formataCodigo($model->codnotafiscal),
				),
			'serie',
			array(
				'name'=>'numero',
				'value'=>Yii::app()->format->formataPorMascara($model->numero, "########"),
				),
			'emissao',
			array(
				'name' => 'saida',
				'value' => substr($model->saida, 0, 10),
				),
			),
	)); 
	?>
	</div>
	<div class="span4">
	<?php 
	$this->widget('bootstrap.widgets.TbDetailView',array(
		'data'=>$model,
		'attributes'=>array(
			array(
				'name'=>'codfilial',
				'value'=>CHtml::link(CHtml::encode($model->Filial->filial), array("filial/view", "id"=>$model->codfilial)),
				'type'=>'raw',
				),
			array(
				'name'=>'codnaturezaoperacao',
				'value'=>
					((isset($model->Operacao))?$model->Operacao->operacao:null)
					. " - " .
					((isset($model->NaturezaOperacao))?$model->NaturezaOperacao->naturezaoperacao:null),
				),
			array(
				'name'=>'fretepagar',
				'value'=>($model->fretepagar)?"Destinatário":"Remetente",
				),
			'volumes',
			array(
				'name'=>'codpessoa',
				'value'=>CHtml::link(CHtml::encode($model->Pessoa->fantasia), array("pessoa/view", "id"=>$model->codpessoa)),
				'type'=>"raw",
			),
			
			),
	)); 
	?>
	</div>
	<div class="span6">
	<?php 
	$css_label = "";
	$staus = "&nbsp";
	$css = "";

	switch ($model->codstatus)
	{
		case NotaFiscal::CODSTATUS_DIGITACAO;
			$css_label = "label-warning";
			break;

		case NotaFiscal::CODSTATUS_AUTORIZADA;
			$css_label = "label-success";
			break;

		case NotaFiscal::CODSTATUS_LANCADA;
			$css_label = "label-info";
			break;

		case NotaFiscal::CODSTATUS_NAOAUTORIZADA;
			break;

		case NotaFiscal::CODSTATUS_INUTILIZADA;
		case NotaFiscal::CODSTATUS_CANCELADA;
			$css_label = "label-important";
			break;
	}
	
	$attr = array(
		array(
			'name'=>'emitida',
			'value'=>($model->emitida)?"Pela Filial":"Pela Contraparte",
			'type'=>"raw",
		),
		array(
			'label'=>'Status',
			'value'=>"<small class='label $css_label'>$model->status</small>",
			'type'=>'raw',
		),
	);

	if (!empty($model->nfechave))
		$attr[] = 
			array(
				'name' => 'nfechave',
				'value' => '<a href="http://www.nfe.fazenda.gov.br/portal/consulta.aspx?tipoConsulta=completa" target="_blank">'
							. str_replace(" ", "&nbsp;", CHtml::encode(Yii::app()->format->formataChaveNfe($model->nfechave)))
							. '</a>',
				'type' => 'raw',
			);
	
	if (!empty($model->nfereciboenvio) || !empty($model->nfedataenvio))
		$attr[] = 
			array(
				'name' => 'nfereciboenvio',
				'value' => $model->nfereciboenvio . " - " . $model->nfedataenvio,
				'type' => 'raw',
			);
	
	if (!empty($model->nfeautorizacao) || !empty($model->nfedataautorizacao))
		$attr[] = 
			array(
				'name' => 'nfeautorizacao',
				'value' => $model->nfeautorizacao . " - " . $model->nfedataautorizacao,
				'type' => 'raw',
			);
	
	if (!empty($model->nfecancelamento) || !empty($model->nfedatacancelamento))
		$attr[] = 
			array(
				'name' => 'nfecancelamento',
				'value' => $model->nfecancelamento . " - " . $model->nfedatacancelamento,
				'type' => 'raw',
			);
	
	if (!empty($model->nfeinutilizacao) || !empty($model->nfedatainutilizacao))
		$attr[] = 
			array(
				'name' => 'nfeinutilizacao',
				'value' => $model->nfeinutilizacao . " - " . $model->nfedatainutilizacao,
				'type' => 'raw',
			);
	
	if (!empty($model->justificativa))
		$attr[] = 'justificativa';
	
	$this->widget('bootstrap.widgets.TbDetailView',array(
		'data'=>$model,
		'attributes'=> $attr,
	)); 

	?>
	</div>
</div>
<div class="row-fluid">
	<div class="span2">
	<?php 
	$this->widget('bootstrap.widgets.TbDetailView',array(
		'data'=>$model,
		'attributes'=>array(
			array(
				'name'=>'valorprodutos',
				'value'=>Yii::app()->format->formatNumber($model->valorprodutos),
				),
			array(
				'name'=>'valortotal',
				'value'=>Yii::app()->format->formatNumber($model->valortotal),
				),
			),
	)); 
	?>
	</div>
	<small class="span2">
	<?php 
	$this->widget('bootstrap.widgets.TbDetailView',array(
		'data'=>$model,
		'attributes'=>array(
			array(
				'name'=>'valordesconto',
				'value'=>Yii::app()->format->formatNumber($model->valordesconto),
				),
			array(
				'name'=>'valoroutras',
				'value'=>Yii::app()->format->formatNumber($model->valoroutras),
				),
			),
	)); 
	?>
	</small>
	<small class="span2">
	<?php 
	$this->widget('bootstrap.widgets.TbDetailView',array(
		'data'=>$model,
		'attributes'=>array(
			array(
				'name'=>'valorfrete',
				'value'=>Yii::app()->format->formatNumber($model->valorfrete),
				),
			array(
				'name'=>'valorseguro',
				'value'=>Yii::app()->format->formatNumber($model->valorseguro),
				),
			),
	)); 
	?>
	</small>
	<small class="span2">
	<?php 
	$this->widget('bootstrap.widgets.TbDetailView',array(
		'data'=>$model,
		'attributes'=>array(
			array(
				'name'=>'icmsbase',
				'value'=>Yii::app()->format->formatNumber($model->icmsbase),
				),
			array(
				'name'=>'icmsvalor',
				'value'=>Yii::app()->format->formatNumber($model->icmsvalor),
				),
			),
	)); 
	?>
	</small>
	<small class="span2">
	<?php 
	$this->widget('bootstrap.widgets.TbDetailView',array(
		'data'=>$model,
		'attributes'=>array(
			array(
				'name'=>'icmsstbase',
				'value'=>Yii::app()->format->formatNumber($model->icmsstbase),
				),
			array(
				'name'=>'icmsstvalor',
				'value'=>Yii::app()->format->formatNumber($model->icmsstvalor),
				),
			),
	)); 
	?>
	</small>
	<small class="span2">
	<?php 
	$this->widget('bootstrap.widgets.TbDetailView',array(
		'data'=>$model,
		'attributes'=>array(
			array(
				'name'=>'ipibase',
				'value'=>Yii::app()->format->formatNumber($model->ipibase),
				),
			array(
				'name'=>'ipivalor',
				'value'=>Yii::app()->format->formatNumber($model->ipivalor),
				),
			),
	)); 
	?>
	</small>
</div>
<br>
<h2>
	Produtos
	<small>
		<?php echo CHtml::link("<i class=\"icon-plus\"></i> Novo", array("notaFiscalProdutoBarra/create", "codnotafiscal" => $model->codnotafiscal)); ?>
	</small>	
</h2>
<?php
foreach ($model->NotaFiscalProdutoBarras as $prod)
{
	?>
	<div class="registro">
		<small class="row-fluid">
			<div class="muted span1">
				<?php echo CHtml::encode($prod->ProdutoBarra->barras, 6); ?>
			</div>
			<b class="span3">
				<?php echo CHtml::link(CHtml::encode($prod->ProdutoBarra->descricao), array("produto/view", "id"=>$prod->ProdutoBarra->codproduto)); ?>
				<span class="text-success">
					<?php echo CHtml::encode($prod->descricaoalternativa); ?>
				</span>
			</b>
			<div class="span1">
				<?php echo CHtml::link(CHtml::encode($prod->codcfop), array("cfop/view", "id"=>$prod->codcfop)); ?>
				<?php echo CHtml::encode($prod->csosn); ?>
				<?php echo CHtml::encode(Yii::app()->format->formataNcm($prod->ProdutoBarra->Produto->ncm)); ?>
			</div>
			<div class="span1 text-right">
				<b>
					<?php echo CHtml::encode(Yii::app()->format->formatNumber($prod->quantidade)); ?>
				</b>
				<div class="pull-right">
					&nbsp;<?php echo CHtml::encode($prod->ProdutoBarra->UnidadeMedida->sigla); ?>
				</div>
			</div>
			<b class="span1 text-right">
				<?php echo CHtml::encode(Yii::app()->format->formatNumber($prod->valorunitario)); ?>
			</b>
			<b class="span1 text-right">
				<?php echo CHtml::encode(Yii::app()->format->formatNumber($prod->valortotal)); ?>
			</b>
			<div class="span3">
				<?php
				if (($prod->icmsbase>0) || ($prod->icmspercentual>0) || ($prod->icmsvalor>0))
				{
					?>
					<div>
						<div class="span3 muted">
							ICMS
						</div>
						<div class="span3 text-right">
							<?php echo CHtml::encode(Yii::app()->format->formatNumber($prod->icmsbase)); ?>
						</div>
						<div class="span3 text-right">
							<?php echo CHtml::encode(Yii::app()->format->formatNumber($prod->icmspercentual)); ?>%
						</div>
						<div class="span3 text-right">
							<?php echo CHtml::encode(Yii::app()->format->formatNumber($prod->icmsvalor)); ?>
						</div>
					</div>
					<?php
				}
				
				if (($prod->icmsstbase>0) || ($prod->icmsstpercentual>0) || ($prod->icmsstvalor>0))
				{
					?>
					<div>
						<div class="span3 muted">
							ICMS ST
						</div>
						<div class="span3 text-right">
							<?php echo CHtml::encode(Yii::app()->format->formatNumber($prod->icmsstbase)); ?>
						</div>
						<div class="span3 text-right">
							<?php echo CHtml::encode(Yii::app()->format->formatNumber($prod->icmsstpercentual)); ?>%
						</div>
						<div class="span3 text-right">
							<?php echo CHtml::encode(Yii::app()->format->formatNumber($prod->icmsstvalor)); ?>
						</div>
					</div>
					<?php
				}
				
				if (($prod->ipibase>0) || ($prod->ipipercentual>0) || ($prod->ipivalor>0))
				{
					?>
					<div>
						<div class="span3 muted">
							IPI
						</div>
						<div class="span3 text-right">
							<?php echo CHtml::encode(Yii::app()->format->formatNumber($prod->ipibase)); ?>
						</div>
						<div class="span3 text-right">
							<?php echo CHtml::encode(Yii::app()->format->formatNumber($prod->ipipercentual)); ?>%
						</div>
						<div class="span3 text-right">
							<?php echo CHtml::encode(Yii::app()->format->formatNumber($prod->ipivalor)); ?>
						</div>
					</div>
					<?php
				}
				
				?>
			</div>
			<div class="span1">
				<?php 
				if (isset($prod->NegocioProdutoBarra))
					echo CHtml::link(CHtml::encode(Yii::app()->format->formataCodigo($prod->NegocioProdutoBarra->codnegocio))
						, array("negocio/view", "id"=>$prod->NegocioProdutoBarra->codnegocio));
				?>
			</div>
			<div class="pull-right">
				<a href="<?php echo Yii::app()->createUrl('notaFiscalProdutoBarra/update', array('id'=>$prod->codnotafiscalprodutobarra)); ?>"><i class="icon-pencil"></i></a>
				<a class="delete-barra" href="<?php echo Yii::app()->createUrl('notaFiscalProdutoBarra/delete', array('id'=>$prod->codnotafiscalprodutobarra)); ?>"><i class="icon-trash"></i></a>
			</div>
		</small>
	</div>
	<?php
}
?>
<br>
<h2>Duplicatas</h2>
<div class="row-fluid">
	<?php 
	$total = 0;
	$ultima = 0;
	foreach ($model->NotaFiscalDuplicatass as $dup)
	{
		$total += $dup->valor;
		$ultima = $dup->valor;
		?>
		<small class="span2 text-center">
			<?php echo CHtml::encode($dup->fatura); ?><br>
			<b><?php echo CHtml::encode($dup->vencimento); ?></b><br>
			<b><?php echo CHtml::encode(Yii::app()->format->formatNumber($dup->valor)); ?></b>
		</small>
		<?php
	}

	if ($total != $ultima)
	{
		?>
		<small class="span2 text-center">
			<b>Total <br> Duplicatas </b><br>
			<b><?php echo CHtml::encode(Yii::app()->format->formatNumber($total)); ?></b>
		</small>
		<?php
	}
	?>
</div>
<br>
<h2>Observações</h2>
<?php echo nl2br(CHtml::encode($model->observacoes)); ?>
<br>
<br>
<?php $this->widget('UsuarioCriacao', array('model'=>$model)); ?>
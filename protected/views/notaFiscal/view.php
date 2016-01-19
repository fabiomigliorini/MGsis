<?php
$this->pagetitle = Yii::app()->name . ' - Detalhes Nota Fiscal';
$this->breadcrumbs=array(
	'Notas Fiscais'=>array('index'),
	Yii::app()->format->formataNumeroNota($model->emitida, $model->serie, $model->numero, $model->modelo),
);

$bloqueado = !$model->podeEditar();

$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
	array('label'=>'Nova', 'icon'=>'icon-plus', 'url'=>array('create')),
	array('label'=>'Alterar', 'icon'=>'icon-pencil', 'url'=>array('update','id'=>$model->codnotafiscal), 'visible' => !$bloqueado),
	array('label'=>'Excluir', 'icon'=>'icon-trash', 'url'=>'#', 'linkOptions'=>	array('id'=>'btnExcluir'), 'visible' => !$bloqueado),
	array('label'=>'Duplicar', 'icon'=>'icon-retweet', 'url'=>array('create','duplicar'=>$model->codnotafiscal)),
	array('label'=>'Operacao Inversa', 'icon'=>'icon-random', 'url'=>array('create','inverter'=>$model->codnotafiscal)),
	array('label'=>'Ver Arquivo XML', 'icon'=>' icon-file', 'url'=>array('NFePHPNovo/visualizaXml','codnotafiscal'=>$model->codnotafiscal), 'linkOptions'=>	array('id'=>'btnArquivoXml'), 'visible' => $bloqueado), 
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);

Yii::app()->clientScript->registerCoreScript('yii');

?>

<script type="text/javascript">
	
/*<![CDATA[*/
$(document).ready(function(){

	jQuery('body').on('click','#btnSalvarCartaCorrecao',function() {
		var texto = $("#txtCartaCorrecao").val();
		bootbox.confirm("<h3>Confirma emissão da carta de correção?</h3><br><pre>" + texto + "</pre>", function(result) {
			if (result)
			{
				
				$.getJSON("<?php echo Yii::app()->createUrl('NFePHPNovo/cartaCorrecao')?>", 
					{ 
						codnotafiscal: <?php echo $model->codnotafiscal; ?>, 
						texto: texto,
					})
					.done(function(data) {

						var mensagem = formataMensagem(data);
						$('#modalProgressoNfe').modal('hide');
						bootbox.alert(mensagem, function() {
							location.reload();
						});
					})
					.fail(function( jqxhr, textStatus, error ) {
						$('#modalProgressoNfe').modal('hide');
						bootbox.alert(error, function() {
							location.reload();
						});
					});
			}
		});
	});
	
	jQuery('body').on('click','#btnExcluir',function() {
		bootbox.confirm("Excluir este registro?", function(result) {
			if (result)
				jQuery.yii.submitForm(document.body.childNodes[0], "<?php echo Yii::app()->createUrl('notaFiscal/delete', array('id' => $model->codnotafiscal))?>",{});
		});
	});
	
	// botão delete da embalagem
	jQuery(document).on('click','a.delete',function(e) {
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



<h1><?php echo CHtml::encode(Yii::app()->format->formataCodigo($model->codnotafiscal)); ?> - <?php echo CHtml::encode(Yii::app()->format->formataNumeroNota($model->emitida, $model->serie, $model->numero, $model->modelo)); ?></h1>


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
	
	$fretes = NotaFiscal::getFreteListaCombo();
	if (isset($fretes[$model->frete]))
		$frete = $fretes[$model->frete];
	else 
		$frete = $model->frete;
	
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
				'name'=>'frete',
				'value'=>$frete,
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
	<small class="span5">
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

	$modelo = NotaFiscal::getModeloListaCombo();
	if (isset($modelo[$model->modelo]))
		$modelo = $modelo[$model->modelo];
	else 
		$modelo = $model->modelo;
	
	$arrTpEmis = NotaFiscal::getTpEmisListaCombo();
	$tpEmis = @$arrTpEmis[$model->tpemis];
	
	$attr = array(
		array(
			'name'=>'emitida',
			'value'=>($model->emitida)?"Pela Filial":"Pela Contraparte",
			'type'=>"raw",
		),
		array(
			'name'=>'modelo',
			'value'=>$modelo
		),
		array(
			'label'=>'Status',
			'value'=>"<small class='label $css_label'>$model->status</small> $tpEmis",
			'type'=>'raw',
		),
	);

	if (!empty($model->nfechave))
		$attr[] = 
			array(
				'name' => 'nfechave',
				'value' => str_replace(" ", "&nbsp;", CHtml::encode(Yii::app()->format->formataChaveNfe($model->nfechave))),
				'type' => 'raw',
			);
	
	foreach($model->NfeTerceiros as $nfet)
		$attr[] = 
			array(
				'label' => 'NF-e Terceiro',
				'value' => CHtml::link('Abrir', array("nfeTerceiro/view", "id" => $nfet->codnfeterceiro)),
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
	</small>
	<div class="span1">
		<?php $this->widget('MGNotaFiscalBotoes', array('model'=>$model)); ?>		
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

<table class="table table-hover table-condensed table-bordered table-striped">
	<thead>
		<tr>
			<th colspan="4">Produto</th>
			<th colspan="4">Valores</th>
			<th rowspan="2">CFOP</th>
			<th colspan="2">ICMS</th>
			<th colspan="1">ST</th>
			<th colspan="2">IPI</th>
			<th colspan="2">PIS</th>
			<th colspan="2">Cofins</th>
			<th colspan="1">CSLL</th>
			<th colspan="1">IRPJ</th>
			<th rowspan="2">Negócio</th>
			<th rowspan="2"></th>
		</tr>
		<tr>
			<th>#</th>
			<th>Barras</th>
			<th>Descrição</th>
			<th>NCM</th>
			<th>Qtd</th>
			<th>UM</th>
			<th>Preço</th>
			<th>Total</th>
			<th>CST</th>
			<th>Valor</th>
			<th>Valor</th>
			<th>CST</th>
			<th>Valor</th>
			<th>CST</th>
			<th>Valor</th>
			<th>CST</th>
			<th>Valor</th>
			<th>Valor</th>
			<th>Valor</th>
		</tr>
	</thead>
	<tbody>

		<?php
		$iItem = 0;
		foreach ($model->NotaFiscalProdutoBarras as $prod)
		{
			$iItem++;
			?>
			<tr>
				<td class="">
					<small class="muted pull-right">
						<?php echo $iItem; ?>
					</small>
				</td>
				<td>
					<small class="muted">
						<?php echo CHtml::encode($prod->ProdutoBarra->barras, 6); ?>
					</small>
				</td>
				<td>
					<b><?php echo CHtml::link(CHtml::encode($prod->ProdutoBarra->descricao), array("produto/view", "id"=>$prod->ProdutoBarra->codproduto)); ?></b>
					<?php if (!empty($prod->descricaoalternativa)): ?>
						<br>
						<b class="text-success">
							<?php echo CHtml::encode($prod->descricaoalternativa); ?>
						</b>
					<?php endif; ?>
				</td>
				<td>
					<small class='muted'>
						<?php echo CHtml::encode(Yii::app()->format->formataNcm($prod->ProdutoBarra->Produto->ncm)); ?>
					</small>
				</td>
				<td>
					<div class="text-right">
						<b><?php echo CHtml::encode(Yii::app()->format->formatNumber($prod->quantidade)); ?></b>
					</div>
				</td>
				<td>
					<small class='muted'>
						<?php echo CHtml::encode($prod->ProdutoBarra->UnidadeMedida->sigla); ?>
					</small>
				</td>
				<td>
					<div class="text-right">
						<small>
							<?php echo CHtml::encode(Yii::app()->format->formatNumber($prod->valorunitario)); ?>
						</small>
					</div>
				</td>
				<td>
					<div class="text-right">
						<b><?php echo CHtml::encode(Yii::app()->format->formatNumber($prod->valortotal)); ?></b>
					</div>
				</td>
				<td>
					<small class='muted'>
						<?php echo CHtml::link(CHtml::encode($prod->codcfop), array("cfop/view", "id"=>$prod->codcfop)); ?>
					</small>
				</td>
				<td>
					<small class='muted'>
						<?php echo CHtml::encode(trim($prod->csosn . ' ' . $prod->icmscst)); ?>
					</small>
				</td>
				<td>
					<small class='muted'>
						<div class="text-right"><?php echo CHtml::encode(Yii::app()->format->formatNumber($prod->icmsvalor)); ?></div>
					</small>
				</td>
				<td>
					<small class='muted'>
						<div class="text-right"><?php echo CHtml::encode(Yii::app()->format->formatNumber($prod->icmsstvalor)); ?></div>
					</small>
				</td>
				<td>
					<small class='muted'>
						<?php echo CHtml::encode($prod->ipicst); ?>
					</small>
				</td>
				<td>
					<small class='muted'>
						<div class="text-right"><?php echo CHtml::encode(Yii::app()->format->formatNumber($prod->ipivalor)); ?></div>
					</small>
				</td>
				<td>
					<small class='muted'>
						<?php echo CHtml::encode($prod->piscst); ?>
					</small>
				</td>
				<td>
					<small class='muted'>
						<div class="text-right"><?php echo CHtml::encode(Yii::app()->format->formatNumber($prod->pisvalor)); ?></div>
					</small>
				</td>
				<td>
					<small class='muted'>
						<?php echo CHtml::encode($prod->cofinscst); ?>
					</small>
				</td>
				<td>
					<small class='muted'>
						<div class="text-right"><?php echo CHtml::encode(Yii::app()->format->formatNumber($prod->cofinsvalor)); ?></div>
					</small>
				</td>
				<td>
					<small class='muted'>
						<div class="text-right"><?php echo CHtml::encode(Yii::app()->format->formatNumber($prod->csllvalor)); ?></div>
					</small>
				</td>
				<td>
					<small class='muted'>
						<div class="text-right"><?php echo CHtml::encode(Yii::app()->format->formatNumber($prod->irpjvalor)); ?></div>
					</small>
				</td>
				<td>
					<small class='muted'>
						<?php 
						if (isset($prod->NegocioProdutoBarra))
							echo CHtml::link(CHtml::encode(Yii::app()->format->formataCodigo($prod->NegocioProdutoBarra->codnegocio))
								, array("negocio/view", "id"=>$prod->NegocioProdutoBarra->codnegocio));
						?>
					</small>
				</td>
				<td>
					<a href="<?php echo Yii::app()->createUrl('notaFiscalProdutoBarra/view', array('id'=>$prod->codnotafiscalprodutobarra)); ?>"><i class="icon-eye-open"></i></a>
					<a href="<?php echo Yii::app()->createUrl('notaFiscalProdutoBarra/update', array('id'=>$prod->codnotafiscalprodutobarra)); ?>"><i class="icon-pencil"></i></a>
					<a class="delete" href="<?php echo Yii::app()->createUrl('notaFiscalProdutoBarra/delete', array('id'=>$prod->codnotafiscalprodutobarra)); ?>"><i class="icon-trash"></i></a>
				</td>
			</tr>
		
			<?php
			/*
			?>
			<div class="registro">
				<div class="row-fluid">
					<div class="span4" style="border: 1px solid blue">
					</div>
					<div class="span3" style="border: 1px solid green">

					</div>
					<small class="span4">
						<small class="span2 muted" style="border: 1px solid green">
							ICMS (<?php echo CHtml::encode(trim($prod->csosn . ' ' . $prod->icmscst)); ?>)
							<?php echo CHtml::encode(Yii::app()->format->formatNumber($prod->icmsvalor)); ?>
						</small>
						<?php if ($prod->icmsstvalor > 0): ?>
							<small class="span2 muted" style="border: 1px solid green">
								ICMSST
								<?php echo CHtml::encode(Yii::app()->format->formatNumber($prod->icmsstvalor)); ?>
							</small>
						<?php endif; ?>
						<?php if ($prod->ipivalor > 0): ?>
							<small class="span2 muted" style="border: 1px solid green">
								IPI (<?php echo CHtml::encode($prod->ipicst); ?>)
								<?php echo CHtml::encode(Yii::app()->format->formatNumber($prod->ipivalor)); ?>
							</small>
						<?php endif; ?>
						<?php if ($prod->pisvalor > 0): ?>
							<small class="span2 muted" style="border: 1px solid green">
								PIS (<?php echo CHtml::encode($prod->piscst); ?>)
								<?php echo CHtml::encode(Yii::app()->format->formatNumber($prod->pisvalor)); ?>
							</small>
						<?php endif; ?>
						<?php if ($prod->cofinsvalor > 0): ?>
							<small class="span2 muted" style="border: 1px solid green">
								Cofins (<?php echo CHtml::encode($prod->piscst); ?>)
								<?php echo CHtml::encode(Yii::app()->format->formatNumber($prod->cofinsvalor)); ?>
							</small>
						<?php endif; ?>
						<?php if ($prod->csllvalor > 0): ?>
							<small class="span2 muted" style="border: 1px solid green">
								CSLL 
								<?php echo CHtml::encode(Yii::app()->format->formatNumber($prod->csllvalor)); ?>
							</small>
						<?php endif; ?>
						<?php if ($prod->irpjvalor > 0): ?>
							<small class="span2 muted" style="border: 1px solid green">
								IRPJ 
								<?php echo CHtml::encode(Yii::app()->format->formatNumber($prod->irpjvalor)); ?>
							</small>
						<?php endif; ?>
					</small>
					<!--
					<div class="span3">
						<?php
						if (($prod->icmsbase>0) || ($prod->icmspercentual>0) || ($prod->icmsvalor>0))
						{
							?>
							<div>
								<div class="span3 muted">
									ICMS
									<?php echo CHtml::encode($prod->csosn); ?>
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
					-->
					<div class="span1">
						<?php 
						if (isset($prod->NegocioProdutoBarra))
							echo CHtml::link(CHtml::encode(Yii::app()->format->formataCodigo($prod->NegocioProdutoBarra->codnegocio))
								, array("negocio/view", "id"=>$prod->NegocioProdutoBarra->codnegocio));
						?>
					</div>
					<div class="pull-right">
						<a href="<?php echo Yii::app()->createUrl('notaFiscalProdutoBarra/update', array('id'=>$prod->codnotafiscalprodutobarra)); ?>"><i class="icon-pencil"></i></a>
						<a class="delete" href="<?php echo Yii::app()->createUrl('notaFiscalProdutoBarra/delete', array('id'=>$prod->codnotafiscalprodutobarra)); ?>"><i class="icon-trash"></i></a>
					</div>
				</div>
			</div>
			<?php
			 * 
			 */
		}
		?>
	</tbody>
</table>
<br>
<h2>
	Duplicatas
	<small>
		<?php echo CHtml::link("<i class=\"icon-plus\"></i> Novo", array("notaFiscalDuplicatas/create", "codnotafiscal" => $model->codnotafiscal)); ?>
	</small>	
</h2>
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
			<div class="pull-right">
				<a href="<?php echo Yii::app()->createUrl('notaFiscalDuplicatas/update', array('id'=>$dup->codnotafiscalduplicatas)); ?>"><i class="icon-pencil"></i></a>
				<a class="delete" href="<?php echo Yii::app()->createUrl('notaFiscalDuplicatas/delete', array('id'=>$dup->codnotafiscalduplicatas)); ?>"><i class="icon-trash"></i></a>
			</div>
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
<h2>
	Notas Fiscais Referenciadas
	<small>
		<?php echo CHtml::link("<i class=\"icon-plus\"></i> Novo", array("notaFiscalReferenciada/create", "codnotafiscal" => $model->codnotafiscal)); ?>
	</small>	
</h2>
	<?php 
	$total = 0;
	$ultima = 0;
	foreach ($model->NotaFiscalReferenciadas as $nfr)
	{
		
		?>
		<div class="row-fluid">
			<small class="span4 text-center">
				<b><?php echo CHtml::encode(Yii::app()->format->formataChaveNfe($nfr->nfechave)); ?></b>
				<div class="pull-right">
					<a href="<?php echo Yii::app()->createUrl('notaFiscalReferenciada/update', array('id'=>$nfr->codnotafiscalreferenciada)); ?>"><i class="icon-pencil"></i></a>
					<a class="delete" href="<?php echo Yii::app()->createUrl('notaFiscalReferenciada/delete', array('id'=>$nfr->codnotafiscalreferenciada)); ?>"><i class="icon-trash"></i></a>
				</div>
			</small>
		</div>
		<?php
	}
	?>
<br>
<h2>Observações</h2>
<?php echo nl2br(CHtml::encode($model->observacoes)); ?>
<br>
<h2>
	Cartas de Correção
	<small>
		<a href="#modalCartaCorrecao" role="button" class="" data-toggle="modal"><i class="icon-plus"></i> Nova</a>
	</small>	
</h2>

<!-- Modal -->
<div id="modalCartaCorrecao" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Digite o texto da Carta de Correção</h3>
  </div>
  <div class="modal-body">
	  <textarea id="txtCartaCorrecao" style="width: 97%; height: 200px"></textarea>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-primary" data-dismiss="modal" id="btnSalvarCartaCorrecao">Salvar</button>
  </div>
</div>

<?php 
foreach ($model->NotaFiscalCartaCorrecaos as $cc)
{
	?>
	<div class="registro">
		<small class="row-fluid">
			<b class="span2">
				<?php echo CHtml::encode($cc->protocolodata); ?>
			</b>
			<div class="span2 muted">
				<?php echo CHtml::encode($cc->protocolo); ?>
			</div>
			<div class="span1 muted text-center">
				<?php echo CHtml::encode($cc->sequencia); ?> /
				<?php echo CHtml::encode($cc->lote); ?>
			</div>
			<span class="span7">
				<?php echo nl2br(CHtml::encode($cc->texto)); ?>
			</span>
		</small>
	</div>
	<?php
}
?>
 
<br>
<?php $this->widget('UsuarioCriacao', array('model'=>$model)); ?>

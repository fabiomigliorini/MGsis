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
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);

Yii::app()->clientScript->registerCoreScript('yii');

?>

<script type="text/javascript">
	
function enviarNfe()
{
	$.getJSON("<?php echo Yii::app()->createUrl('notaFiscal/enviarNfe')?>", { id: <?php echo $model->codnotafiscal ?> } )
		.done(function(data) {

			var redirecionar = "<?php echo Yii::app()->createUrl('notaFiscal/view', array("id"=>$model->codnotafiscal))?>";

			if (!data.resultado)
			{
				var mensagem = '<h3>' + data.erroMonitor + '</h3><pre>' + data.retorno + '</pre>';
				bootbox.alert(mensagem, function() {
					document.location = redirecionar;
				});
			}
			else
			{
				document.location = redirecionar + "&imprimirDanfe=1";
			}

		})
		.fail(function( jqxhr, textStatus, error ) {
			var err = textStatus + ", " + error;
			console.log( "Request Failed: " + err );
		});
}
	
function enviarEmail(email, alterarcadastro)
{
	$.getJSON("<?php echo Yii::app()->createUrl('notaFiscal/enviarEmail')?>", 
		{ 
			id: <?php echo $model->codnotafiscal ?>, 
			email: email,
			alterarcadastro: alterarcadastro,
		})
		.done(function(data) {

			var mensagem = '';

			if (!data.resultado)
				mensagem = '<h3>' + data.erroMonitor + '</h3><pre>' + data.retorno + '</pre>';
			else
				mensagem = '<h3>' + data.retornoMonitor[1] + '</h3><pre>' + data.retorno + '</pre>';
			
			bootbox.alert(mensagem);

		})
		.fail(function( jqxhr, textStatus, error ) {
			var err = textStatus + ", " + error;
			console.log( "Request Failed: " + err );
		});
	
}

function abrirDanfe(imprimir)
{
	var frameSrcDanfe = "<?php echo $model->Filial->acbrnfemonitorcaminhorede; ?>/PDF/<?php echo $model->nfechave; ?>.pdf";
	
	$.getJSON("<?php echo Yii::app()->createUrl('notaFiscal/imprimirDanfePdf')?>", 
		{ 
			id: <?php echo $model->codnotafiscal ?>,
			imprimir: imprimir
		})
		.done(function(data) {

			var mensagem = '';

			if (!data.resultado)
			{
				mensagem = '<h3>' + data.erroMonitor + '</h3><pre>' + data.retorno + '</pre>';
				bootbox.alert(mensagem);
			}
			else
			{
				$('#modalDanfe').on('show', function () {
					$('#frameDanfe').attr("src",frameSrcDanfe);
				});
				$('#modalDanfe').modal({show:true})
				$('#modalDanfe').css({'width': '80%', 'margin-left':'auto', 'margin-right':'auto', 'left':'10%'});
			}

		})
		.fail(function( jqxhr, textStatus, error ) {
			var err = textStatus + ", " + error;
			console.log( "Request Failed: " + err );
		});
}
	
/*<![CDATA[*/
$(document).ready(function(){
	
	<?php
	if (!empty($_GET["imprimirDanfe"]) && $model->codstatus == NotaFiscal::CODSTATUS_AUTORIZADA)
		echo "abrirDanfe(1);";
	else if (!empty($_GET["enviarNfe"]) && ($model->codstatus == NotaFiscal::CODSTATUS_DIGITACAO || $model->codstatus == NotaFiscal::CODSTATUS_NAOAUTORIZADA))
		echo "enviarNfe();";
	?>
			
	// ENVIAR NFE
	$('#btnEnviarNfe').on('click', function (e) {
		enviarNfe();
	});
	
	//CONSULTAR NFE
	$('#btnConsultarNfe').on('click', function (e) {
		$.getJSON("<?php echo Yii::app()->createUrl('notaFiscal/consultarNfe')?>", { id: <?php echo $model->codnotafiscal ?> } )
			.done(function(data) {
				
				var mensagem = '';
			
				if (!data.resultado)
					mensagem = '<h3>' + data.erroMonitor + '</h3><pre>' + data.retorno + '</pre>';
				else
					mensagem = '<h3>' + data.retornoMonitor[1] + '</h3><pre>' + data.retorno + '</pre>';
				
				bootbox.alert(mensagem, function() {
					document.location = "<?php echo Yii::app()->createUrl('notaFiscal/view', array("id"=>$model->codnotafiscal))?>";
				});
				
			})
			.fail(function( jqxhr, textStatus, error ) {
				var err = textStatus + ", " + error;
				console.log( "Request Failed: " + err );
			});
	});
	
	//CANCELAR NFE
	$('#btnCancelarNfe').on('click', function (e) {
		bootbox.prompt("Digite a justificativa para cancelar a NFE!", "Desistir", "OK", function(result) { 
			if (result === null)
				return;

			$.getJSON("<?php echo Yii::app()->createUrl('notaFiscal/cancelarNfe')?>", 
				{ 
					id: <?php echo $model->codnotafiscal ?>,
					justificativa: result 
				} )
				.done(function(data) {

					var mensagem = '';

					if (!data.resultado)
						mensagem = '<h3>' + data.erroMonitor + '</h3><pre>' + data.retorno + '</pre>';
					else
						mensagem = '<h3>' + data.retornoMonitor[1] + '</h3><pre>' + data.retorno + '</pre>';

					bootbox.alert(mensagem, function() {
						document.location = "<?php echo Yii::app()->createUrl('notaFiscal/view', array("id"=>$model->codnotafiscal))?>";
					});

				})
				.fail(function( jqxhr, textStatus, error ) {
					var err = textStatus + ", " + error;
					console.log( "Request Failed: " + err );
				});
		});
	});
	
	//INUTILIZAR NFE
	$('#btnInutilizarNfe').on('click', function (e) {
		bootbox.prompt("Digite a justificativa para inutilizar a NFE!", "Desistir", "OK", function(result) { 
			if (result === null)
				return;

			$.getJSON("<?php echo Yii::app()->createUrl('notaFiscal/inutilizarNfe')?>", 
				{ 
					id: <?php echo $model->codnotafiscal ?>,
					justificativa: result 
				} )
				.done(function(data) {

					var mensagem = '';

					if (!data.resultado)
						mensagem = '<h3>' + data.erroMonitor + '</h3><pre>' + data.retorno + '</pre>';
					else
						mensagem = '<h3>' + data.retornoMonitor[1] + '</h3><pre>' + data.retorno + '</pre>';

					bootbox.alert(mensagem, function() {
						document.location = "<?php echo Yii::app()->createUrl('notaFiscal/view', array("id"=>$model->codnotafiscal))?>";
					});

				})
				.fail(function( jqxhr, textStatus, error ) {
					var err = textStatus + ", " + error;
					console.log( "Request Failed: " + err );
				});
		});
	});

	//abre janela vale
	$('#btnAbrirDanfe').click(function(event){
		event.preventDefault();
		abrirDanfe(0);
	});	
	
	//imprimir Danfe Matricial
	$('#btnImprimirDanfePdfTermica').click(function(event){
		abrirDanfe(1);
	});
	
	
	//Enviar Email
	<?php
		$email = $model->Pessoa->emailnfe;
		if (empty($email))
			$email = $model->Pessoa->email;
		if (empty($email))
			$email = $model->Pessoa->emailcobranca;
	?>
	var email = "<?php echo $email; ?>";
	$('#btnEnviarEmail').on('click', function (e) {
		bootbox.prompt("Enviar email para ?", "Cancelar", "OK", function(result) { 
			if (result === null)
				return;
			
			if (result == email)
				enviarEmail(result, 0);
			else
			{
				bootbox.dialog("Alterar email do cadastro? <br><br> De <b class=\'text-error\'>" + email + "</b> <br><br> Para <b class=\'text-success\'>" + result + "</b>?", 
				[
					{
						"label" : "Não",
						"class" : "btn-danger",
						"callback": function() {
							enviarEmail(result, 0);
						}
					}, {
						"label" : "Sim",
						"class" : "btn-success",
						"callback": function() {
							email = result;
							enviarEmail(result, 1);
						}
					}
				]);
				
			}
			
		}, email);		
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


<div id="modalDanfe" class="modal hide fade" tabindex="-1" role="dialog">
	<div class="modal-header">
		<div class="pull-right">
			<?php if ($model->modelo == NotaFiscal::MODELO_NFCE): ?>
				<button class="btn btn-primary" id="btnImprimirDanfePdfTermica" >Imprimir </span></button>
			<?php endif; ?>
			<button class="btn" data-dismiss="modal">Fechar</button>
		</div>
		<h3>Danfe</h3> 
	</div>
	<div class="modal-body">
 <iframe src="" id="frameDanfe" name="frameDanfe" width="99.6%" height="400" frameborder="0"></iframe>
	</div>
</div>


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
	</small>
	<div class="span1">
		<?php if ($model->emitida): ?>
			<?php 
				if ($model->codstatus != NotaFiscal::CODSTATUS_AUTORIZADA
				&& $model->codstatus != NotaFiscal::CODSTATUS_CANCELADA
				&& $model->codstatus != NotaFiscal::CODSTATUS_INUTILIZADA
				):
			?>
				<input type="button" class="btn btn-small btn-block btn-primary" value="Enviar" id="btnEnviarNfe">
				<?php if (!empty($model->numero)): ?>
					<input type="button" class="btn btn-small btn-block btn-danger" value="Inutilizar" id="btnInutilizarNfe">
				<?php endif; ?>
			<?php endif; ?>
			<?php if ($model->codstatus == NotaFiscal::CODSTATUS_AUTORIZADA): ?>
				<input type="button" class="btn btn-small btn-block btn-primary" value="Danfe" id="btnAbrirDanfe">
				<input type="button" class="btn btn-small btn-block btn-primary" value="Email" id="btnEnviarEmail">
				<input type="button" class="btn btn-small btn-block btn-danger" value="Cancelar" id="btnCancelarNfe">		
			<?php endif; ?>
			<?php if (!empty($model->nfechave) ): ?>
				<input type="button" class="btn btn-small btn-block btn-info" value="Consultar" id="btnConsultarNfe">
			<?php endif; ?>
		<?php endif; ?>
		
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
				<a class="delete" href="<?php echo Yii::app()->createUrl('notaFiscalProdutoBarra/delete', array('id'=>$prod->codnotafiscalprodutobarra)); ?>"><i class="icon-trash"></i></a>
			</div>
		</small>
	</div>
	<?php
}
?>
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
<h2>Observações</h2>
<?php echo nl2br(CHtml::encode($model->observacoes)); ?>
<br>
<h2>
	Cartas de Correção
	<small>
		<?php echo CHtml::link("<i class=\"icon-plus\"></i> Nova", array("notaFiscalCartaCorrecao/create", "codnotafiscal" => $model->codnotafiscal)); ?>
	</small>	
</h2>
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

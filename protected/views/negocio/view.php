<?php
/* @var $model Negocio */
/* @var $this NegocioController */

$this->pagetitle = Yii::app()->name . ' - Detalhes do Negócio';
$this->breadcrumbs=array(
	'Negócios'=>array('index'),
	$model->codnegocio,
);

$this->menu=array(
	array('label'=>'Listagem (F1)', 'icon'=>'icon-list-alt', 'url'=>array('index'), 'linkOptions'=> array('id'=>'btnListagem')),
	array('label'=>'Novo (F2)', 'icon'=>'icon-plus', 'url'=>array('createOrEmpty'), 'linkOptions'=> array('id'=>'btnNovo')),
	array('label'=>'Alterar', 'icon'=>'icon-pencil', 'url'=>array('Alterar', 'id'=>$model->codnegocio), 'visible'=>($model->codnegociostatus ==2), 'linkOptions'=> array('id'=>'btnAlterarVendedor')),
	array('label'=>'Fechar Negócio (F3)', 'icon'=>'icon-pencil', 'url'=>array('update','id'=>$model->codnegocio), 'visible'=>($model->codnegociostatus==1), 'linkOptions'=>	array('id'=>'btnFechar')),
	array(
		'label'=>'Romaneio',
		'icon'=>'icon-print',
		'url'=>array('imprimeromaneio','id'=>$model->codnegocio),
		'linkOptions'=>array('id'=>'btnMostrarRomaneio'),
		'visible'=>($model->codnegociostatus == NegocioStatus::FECHADO)
	),
	array(
		'label'=>'Gerar NFe',
		'icon'=>'icon-globe',
		'url'=>'#',
		'linkOptions'=>array('id'=>'btnGerarNotaFiscal'),
		'visible'=>($model->codnegociostatus == NegocioStatus::FECHADO)
	),
	array(
		'label'=>'Cancelar',
		'icon'=>'icon-thumbs-down',
		'url'=>'#',
		'linkOptions'=>array('id'=>'btnCancelar'),
		'visible'=>($model->codnegociostatus != NegocioStatus::CANCELADO)
		),
	array('label'=>'Duplicar', 'icon'=>'icon-retweet', 'url'=>array('create','duplicar'=>$model->codnegocio)),
	array(
		'label'=>'Boletos',
		'icon'=>'icon-barcode',
		'url'=>'#',
		'linkOptions'=>array('onclick'=>'mostrarBoleto(event)'),
		'visible'=>($model->codnegociostatus == NegocioStatus::FECHADO && $model->NaturezaOperacao->codoperacao == Operacao::SAIDA)
	),
	array(
		'label'=>'Comanda',
		'icon'=>'icon-print',
		'url'=>'#',
		'linkOptions'=>array('onclick'=>'imprimirComanda(event)'),
		'visible'=>($model->codnegociostatus == NegocioStatus::ABERTO)
	),
	array(
		'label'=>'Orçamento',
		'icon'=>'icon-print',
		'url'=>array('relatorioOrcamento','id'=>$model->codnegocio),
		'linkOptions'=>array('id'=>'btnOrcamento'),
		'visible'=>($model->NaturezaOperacao->codoperacao == Operacao::SAIDA)
	),
	array(
		'label'=>'Devolução',
		'icon'=>'icon-thumbs-down',
		'url'=>array('devolucao', 'id'=>$model->codnegocio),
		'visible'=>($model->codnegociostatus == NegocioStatus::FECHADO && !empty($model->NaturezaOperacao->codnaturezaoperacaodevolucao))
	),
	//array('label'=>'Cancelar', 'icon'=>'icon-trash', 'url'=>'#', 'linkOptions'=>	array('id'=>'btnCancelar')),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);

Yii::app()->clientScript->registerCoreScript('yii');

$this->renderPartial("_hotkeys");

?>

<script type="text/javascript">

function imprimirComanda (event)
{
	event.preventDefault();
	mostrarComanda();
	var impressora = '<?php echo Yii::app()->user->getState('impressoraTermica') ?>';
	var codnegocio = '<?php echo $model->codnegocio ?>';
	if (impressora == '') {
		bootbox.alert('Nenhuma Impressora Termica Associada ao Usuário!');
		return;
	}
	$.ajax({
		type: 'POST',
		url: "<?php echo MGSPA_API_URL; ?>negocio/" + codnegocio + "/comanda/imprimir",
		data: {
			impressora: impressora
		},
		headers: {
			"X-Requested-With":"XMLHttpRequest"
		},
	}).done(function(resp) {
		$.notify("Comanda enviada para impressão na impressora '" + impressora + "'!", { position:"right bottom", className:"success", autoHideDelay: 15000 });
	}).fail(function( jqxhr, textStatus, error ) {
		$.notify("Erro ao Imprimir Comanda!", { position:"right bottom", className:"error", autoHideDelay: 15000 });
	});
}

function mostrarComanda()
{
	if ($("#modalComanda").hasClass('in')) {
		return;
	}
	$('#modalComanda').on('show', function () {
		$('#farmeComanda').attr("src","<?php echo MGSPA_API_URL; ?>negocio/" + <?php echo $model->codnegocio ?> + "/comanda");
	});
	$('#modalComanda').modal({show:true})
	$('#modalComanda').css({'width': '80%', 'margin-left':'auto', 'margin-right':'auto', 'left':'10%'});
}



function gerarNotaFiscal(modelo, enviar)
{

	$.getJSON("<?php echo Yii::app()->createUrl('negocio/gerarNotaFiscal')?>",
		{
			id: <?php echo $model->codnegocio ?>,
			modelo: modelo,
		})
		.done(function(data)
		{

			if (data.Retorno != 1)
			{
				bootbox.alert(data.Mensagem);
				return false;
			}

			if (modelo == <?php echo NotaFiscal::MODELO_NFCE; ?> || enviar)
			{
				NFePHPCriar(data.codnotafiscal, modelo);
			}
			else
			{
				location.reload();
			}

		})
		.fail(function( jqxhr, textStatus, error )
		{
			var err = textStatus + ", " + error;
			bootbox.alert(err);
		});
}

function mostrarBoleto(event)
{
	event.preventDefault();
	$('#modalBoleto').on('show', function () {
		var url = "<?php echo MGSPA_API_URL; ?>negocio/<?php echo $model->codnegocio; ?>/boleto-bb/pdf";
		$('#frameBoleto').attr("src", url);
	});
	$('#modalBoleto').modal({show:true})
	$('#modalBoleto').css({'width': '80%', 'margin-left':'auto', 'margin-right':'auto', 'left':'10%'});
}

function mostrarRomaneio(imprimir)
{
	$('#modalRomaneio').on('show', function () {
		var src = $('#btnMostrarRomaneio').attr('href');
		if (imprimir)
		{
			src = src + "&imprimir=1";
		}
		$('#frameRomaneio').attr("src", src);
	});
	$('#modalRomaneio').modal({show:true})
	$('#modalRomaneio').css({'width': '80%', 'margin-left':'auto', 'margin-right':'auto', 'left':'10%'});

}

//abre janela Relatorio
	var frameSrcOrcamento = $('#btnOrcamento').attr('href');
	$('#btnOrcamento').click(function(event){
		event.preventDefault();
		$('#modalOrcamento').on('show', function () {
			$('#frameOrcamento').attr("src",frameSrcOrcamento);
		});
		$('#modalOrcamento').modal({show:true})
		$('#modalOrcamento').css({'width': '80%', 'margin-left':'auto', 'margin-right':'auto', 'left':'10%'});
	});
/*<![CDATA[*/
$(document).ready(function(){

	$('#btnInformarMercos').click(function(event){
		event.preventDefault();
		console.log('aqui');
		// return;
		$.ajax({
		  type: 'GET',
		  url: "<?php echo MGLARA_URL ; ?>mercos/pedido/<?php echo $model->codnegocio ; ?>/faturamento",
		}).done(function(resp) {
			var msg = "Faturamento informado ao Mercos com o ID " + resp.join(', ') + "!";
			console.log(resp);
			bootbox.alert('<h3 class="text-success">' + msg + '</h3>', function() {
				location.reload();
			});
		}).fail(function( jqxhr, textStatus, error ) {
			bootbox.alert('<h3 class="text-error">' + error + '</h3>');
			console.log(jqxhr);
			console.log(textStatus);
			console.log(error);
		});
	});


	<?php
	if ($perguntarNota)
	{

		$documento = null;

		// Decide qual documento
		if (empty($documento))
		{
			if ($model->Pessoa->notafiscal == Pessoa::NOTAFISCAL_SEMPRE)
				$documento = "NFE";

			else if ($model->Pessoa->notafiscal == Pessoa::NOTAFISCAL_NUNCA)
				$documento = "ROMANEIO";

			else if ($model->valoraprazo > 0)
				$documento = "ROMANEIO";

			else if (empty($model->Pessoa->ie))
				$documento = "NFCE";

			else
				$documento = "NFE";
		}

		//monta variaveis de acordo com o documento
		switch ($documento)
		{
			case "NFE":
				$pergunta = "Deseja gerar uma NFE?";
				$funcao = "gerarNotaFiscal(" . NotaFiscal::MODELO_NFE . ", true);";
				break;

			case "NFCE":
				$pergunta = "Deseja gerar uma NFCe?";
				$funcao = "gerarNotaFiscal(" . NotaFiscal::MODELO_NFCE . ", true);";
				break;

			case "ROMANEIO":
				$pergunta = "Deseja imprimir o Romaneio?";
				$funcao = "mostrarRomaneio(true);";
				break;

		}

		//se teve resposta para imprimir;
		if (!empty($documento))
		{
			?>
			window.history.pushState({page: null}, null, '<?php echo Yii::app()->createUrl('negocio/view', ['id'=>$model->codnegocio, 'perguntarNota'=>false]) ?>');
			bootbox.hideAll();
			bootbox.confirm("<?php echo $pergunta; ?>", function(result) {
				if (result)
					<?php echo $funcao; ?>
			});
			<?php
		}

	}


	?>


	$('#btnGerarNotaFiscal').click(function(event){
		event.preventDefault();
		$('#modalModeloNotaFiscal').modal({show:true, keyboard:true})
	});

	$('#btnGerarNfce').click(function(event){
		event.preventDefault();
		gerarNotaFiscal(<?php echo NotaFiscal::MODELO_NFCE; ?>);
	});

	$('#btnGerarNfe').click(function(event){
		event.preventDefault();
		gerarNotaFiscal(<?php echo NotaFiscal::MODELO_NFE; ?>);
	});

	//abre janela boleto
	$('#btnMostrarBoleto').click(function(event){
		event.preventDefault();
		mostrarBoleto();
	});

	//imprimir Boleto
	$('#btnImprimirBoleto').click(function(event){
		window.frames["frameBoleto"].focus();
		window.frames["frameBoleto"].print();
	});

	//abre janela romaneio
	$('#btnMostrarRomaneio').click(function(event){
		event.preventDefault();
		mostrarRomaneio();
	});

	//imprimir Romaneio
	$('#btnImprimirRomaneio').click(function(event){
		window.frames["frameRomaneio"].focus();
		window.frames["frameRomaneio"].print();
	});

	//imprimir Romaneio Matricial
	$('#btnImprimirRomaneioMatricial').click(function(event){
		$('#frameRomaneio').attr("src",$('#btnMostrarRomaneio').attr('href') + "&imprimir=true");
	});

	$('#modalComanda').on('hidden', function () {
		var url = '<?php echo Yii::app()->createUrl('negocio') ?>';
		window.location.href = url;
	})

	$('body').on('click','#btnCancelar',function() {
		bootbox.hideAll();
		bootbox.confirm("Cancelar este negócio?", function(result) {
			if (result)
				jQuery.yii.submitForm(document.body.childNodes[0], "<?php echo Yii::app()->createUrl('negocio/cancelar', array('id' => $model->codnegocio))?>",{});
		});
	});
});
/*]]>*/
</script>

<div id="modalPrancheta" class="modal hide fade" tabindex="-1" role="dialog">
	<div class="modal-body modalPranchetaBody" id="modalPranchetaBody">
        <iframe class="" src="" id="framePrancheta" width="99.6%" height="100%"  name="framePrancheta" class="framePrancheta" frameborder="0"></iframe>
	</div>
</div>

<div id="modalOrcamento" class="modal hide fade" tabindex="-1" role="dialog">
	<div class="modal-header">
		<div class="pull-right">
			<button class="btn" data-dismiss="modal">Fechar</button>
		</div>
		<h3>Orçamento</h3>
	</div>
	<div class="modal-body">
      <iframe src="" id="frameOrcamento" name="frameOrcamento" width="99.6%" height="400" frameborder="0"></iframe>
	</div>
</div>

<div id="modalBoleto" class="modal hide fade" tabindex="-1" role="dialog">
	<div class="modal-header">
		<div class="pull-right">
			<button class="btn btn-primary" id="btnImprimirBoleto">Imprimir</button>
			<button class="btn" data-dismiss="modal">Fechar</button>
		</div>
		<h3>Boletos</h3>
	</div>
	<div class="modal-body">
  	<iframe src="" id="frameBoleto" name="frameBoleto" width="99.6%" height="400" frameborder="0"></iframe>
	</div>
</div>

<div id="modalComanda" class="modal hide fade" tabindex="-1" role="dialog">
	<div class="modal-header">
		<div class="pull-right">
			<button class="btn btn-primary" onclick='imprimirComanda(event)'>Imprimir</button>
			<button class="btn" data-dismiss="modal">Fechar</button>
		</div>
		<h3>Comanda</h3>
	</div>
	<div class="modal-body">
    <iframe src="" id="farmeComanda" name="farmeComanda" width="99.6%" height="400" frameborder="0"></iframe>
	</div>
</div>

<div id="modalModeloNotaFiscal" class="modal hide fade" tabindex="-1" role="dialog">
	<div class="modal-header">
		<h3>Gerar qual modelo de nota Fiscal?</h3>
	</div>
	<div class="modal-body">
		<div class="pull-right">
			<button class="btn btn-primary" data-dismiss="modal"  id="btnGerarNfce">NFC-e (Cupom)</button>
			<button class="btn" data-dismiss="modal" id="btnGerarNfe">NF-e (Nota)</button>
			<button class="btn" data-dismiss="modal" id="">Cancelar</button>
		</div>
	</div>
</div>

<div id="modalRomaneio" class="modal hide fade" tabindex="-1" role="dialog">
	<div class="modal-header">
		<div class="pull-right">
			<button class="btn btn-primary" id="btnImprimirRomaneioMatricial"><i class="icon-print icon-white"></i>&nbsp;Matricial</button>
			<button class="btn btn-primary" id="btnImprimirRomaneio"><i class="icon-print icon-white"></i>&nbsp;Laser</button>
			<button class="btn" data-dismiss="modal">Fechar</button>
		</div>
		<h3>Romaneio</h3>
	</div>
	<div class="modal-body">
      <iframe src="" id="frameRomaneio" name="frameRomaneio" width="99.6%" height="400" frameborder="0"></iframe>
	</div>
</div>


<div class="row-fluid">

	<div class="span8">
		<?php
			/*
			$this->widget(
				'bootstrap.widgets.TbTabs',
				array(
					'type' => 'tabs', // 'tabs' or 'pills'
					'tabs' => array(
						array(
							'label' => 'Produtos',
							'content' => $this->renderPartial('_view_produtos', array('model'=>$model), true),
							'active' => true
						),
						array(
							'label' => 'Notas Fiscais',
							'content' => $this->renderPartial('_view_notas', array('model'=>$model), true),
						),
						array(
							'label' => 'Cupons Fiscais',
							'content' => $this->renderPartial('_view_cupons', array('model'=>$model), true),
						),
						array(
							'label' => 'Títulos',
							'content' => $this->renderPartial('_view_titulos', array('model'=>$model), true),
						),
					),
				)
			);
			 *
			 */

			$this->widget('MGNotaFiscalBotoes');
			$this->renderPartial('_view_notas', array('model'=>$model));
			$this->renderPartial('_view_cupons', array('model'=>$model));
			$this->renderPartial('_view_produtos', array('model'=>$model));
			$this->renderPartial('_view_titulos', array('model'=>$model));
		?>
	</div>

	<div class="span4">

		<?php if ($model->codnegociostatus == 3): ?>
			<div class="alert alert-danger">
				<b>Cancelado em <?php echo CHtml::encode((empty($model->alteracao)?$model->lancamento:$model->alteracao)); ?> </b>
			</div>
		<?php endif; ?>

		<div id="totais">
			<?php $this->renderPartial('_view_totais', array('model'=>$model));	?>
		</div>

		<?php
				$pessoa = CHtml::link(CHtml::encode($model->Pessoa->fantasia), array("pessoa/view", "id"=>$model->codpessoa));
				if (!empty($model->cpf)) {
					$pessoa .= '<br /><small>' . Yii::app()->format->formataCnpjCpf($model->cpf, true) . '</small>';
				}
        $attr = array(
            array(
                'name'=>'codnegocio',
                'value'=> Yii::app()->format->formataCodigo($model->codnegocio),
                ),
            array(
                'name'=>'codnaturezaoperacao',
                'value'=>
                    ((isset($model->Operacao))?$model->Operacao->operacao:null)
                    . " - " .
                    ((isset($model->NaturezaOperacao))?$model->NaturezaOperacao->naturezaoperacao:null),
                ),
            array(
                'name'=>'codpessoa',
                'value'=>$pessoa,
                'type'=>'raw',
                ),
				);
				if (!empty($model->codpessoavendedor)) {
					$attr[] = [
						'name'=>'codpessoavendedor',
						'value'=>(isset($model->PessoaVendedor))?CHtml::link(CHtml::encode($model->PessoaVendedor->fantasia),array('pessoa/view','id'=>$model->codpessoavendedor)):null,
						'type'=>'raw',
					];
				}
				$attr[] = 'lancamento';
				$attr[] = [
					'name'=>'codnegociostatus',
					'value'=>(isset($model->NegocioStatus))?$model->NegocioStatus->negociostatus:null,
				];
				$attr[] = [
					'name'=>'codfilial',
					'value'=>(isset($model->Filial))?$model->Filial->filial:null,
				];
				$attr[] = [
					'name'=>'codestoquelocal',
					'value'=>(isset($model->EstoqueLocal))?$model->EstoqueLocal->estoquelocal:null,
				];
				$attr[] = [
					'name'=>'codusuario',
					'value'=>(isset($model->Usuario))?$model->Usuario->usuario:null,
				];
				if (!empty($model->observacoes)) {
					$attr[] = 'observacoes';
				}
        foreach($model->NfeTerceiros as $nfet) {
					$attr[] = [
						'label' => 'NF-e Terceiro',
						'value' => CHtml::link('Abrir', array("nfeTerceiro/view", "id" => $nfet->codnfeterceiro)),
						'type' => 'raw',
					];
				}
				foreach ($model->MercosPedidos as $ped) {
					$str = "#{$ped->numero} ({$ped->pedidoid})";
					$attr[] = [
						'label' => 'Mercos ID',
						'value' => CHtml::link($str, MERCOS_URL_ADM . "pedidos/{$ped->pedidoid}/detalhar/", ['target' => '_blank']),
						// 'value' => CHtml::link($ped->pedidoid, array("nfeTerceiro/view", "id" => $ped->pedidoid)),
						'type' => 'raw',
					];
					if (!empty($ped->condicaopagamento)) {
						$attr[] = [
							'label' => 'Condição',
							'value' => $ped->condicaopagamento,
						];
					}
					if (!empty($ped->enderecoentrega)) {
						$attr[] = [
							'label' => 'Entrega',
							'value' => $ped->enderecoentrega,
						];
					}
					$str = "$ped->faturamentoid   <button class='btn btn-mini' type='button' id='btnInformarMercos'>Informar Mercos</button>";
					$attr[] = [
						'label' => 'Faturamento',
						'value' => $str,
						'type' => 'raw',
					];
				}

		$this->widget('bootstrap.widgets.TbDetailView',array('data'=>$model, 'attributes'=>$attr));


		$this->widget('UsuarioCriacao', array('model'=>$model));

		?>
	</div>
</div>

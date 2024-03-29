<?php
$this->pagetitle = Yii::app()->name . ' - Detalhes Pessoa';
$this->breadcrumbs=array(
	'Pessoa'=>array('index'),
	CHtml::encode($model->fantasia),
);

$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
	array('label'=>'Nova', 'icon'=>'icon-plus', 'url'=>array('create')),
	array('label'=>'Alterar', 'icon'=>'icon-pencil', 'url'=>array('update','id'=>$model->codpessoa)),
	array('label'=>'Excluir', 'icon'=>'icon-trash', 'url'=>'#', 'linkOptions'=>	array('id'=>'btnExcluir')),
	array('label'=>'Títulos', 'icon'=>'icon-tasks', 'url'=>array('titulo/index','Titulo[codpessoa]'=>$model->codpessoa)),
);

if ($model->vendedor) {
	$this->menu[] =
		array('label'=>'Comanda Vendedor', 'icon'=>'icon-print', 'url'=>'#', 'linkOptions'=>	array('id'=>'btnComandaVendedor'));
}

Yii::app()->clientScript->registerCoreScript('yii');

?>

<div id="modalComandaVendedor" class="modal hide fade" tabindex="-1" role="dialog">
	<div class="modal-header">
		<h3>Impressão de Comanda de Vendedor</h3>
	</div>
	<div class="modal-body">
		<div class="row">
			<div class="span-12 text-center">
				<div class="input-prepend input-append">
					<label class="add-on" for="copiasComandaVendedor">Cópias</label>
					<input class="input-small text-right" id="copiasComandaVendedor" type="text" value="20">
					<button class="btn" type="submit" id="btnImprimirComandaVendedor" tabindex="-1">Imprimir</button>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
/*<![CDATA[*/
$(document).ready(function(){

	$("#btnImprimirComandaVendedor").click(function(e){
		e.preventDefault();
		var impressora = '<?php echo Yii::app()->user->getState('impressoraTermica') ?>';
		var codpessoa = '<?php echo $model->codpessoa ?>';
		var copias = $("#copiasComandaVendedor").val();
		$('#modalComandaVendedor').modal('hide')
		if (impressora == '') {
			bootbox.alert('Nenhuma Impressora Termica Associada ao Usuário!');
			return;
		}
		$.ajax({
			type: 'POST',
			url: "<?php echo MGSPA_API_URL; ?>pessoa/" + codpessoa + "/comanda-vendedor/imprimir",
			data: {
				impressora: impressora,
				copias: copias
			},
			headers: {
				"X-Requested-With":"XMLHttpRequest"
			},
		}).done(function(resp) {
			$.notify("Comanda enviada para impressão na impressora '" + impressora + "'!", { position:"right bottom", className:"success", autoHideDelay: 15000 });
		}).fail(function( jqxhr, textStatus, error ) {
			$.notify("Erro ao Imprimir Comanda!", { position:"right bottom", className:"error", autoHideDelay: 15000 });
		});
	});

	$("#btnComandaVendedor").click(function(e){
		e.preventDefault();
		$('#modalComandaVendedor').modal({show:true})
	});

	jQuery('body').on('click','#btnExcluir',function() {
		bootbox.confirm("Excluir este registro?", function(result) {
			if (result)
				jQuery.yii.submitForm(document.body.childNodes[0], "<?php echo Yii::app()->createUrl('pessoa/delete', array('id' => $model->codpessoa))?>",{});
		});
	});
});
/*]]>*/
</script>

<h1><?php echo CHtml::encode($model->fantasia); ?></h1>

<?php if (!empty($model->inativo)): ?>
	<div class="alert alert-danger">
		<b>Inativado em <?php echo CHtml::encode($model->inativo); ?> </b>
	</div>
<?php endif; ?>

<div class="row-fluid">
	<div class="span6">
		<?php
		$tipos = [
			1 => 'ETC - Empresa',
			2 => 'TAC - Autônomo',
			3 => 'CTC - Cooperativa',
		];
		$tipoTransportador = empty($model->tipotransportador)?null:$tipos[$model->tipotransportador];

		$attributes =
			array(
				array(
					'name'=>'codpessoa',
					'value'=>Yii::app()->format->formataCodigo($model->codpessoa),
					),
				'pessoa',
				array(
					'name'=>'telefone1',
					'value'=>"<a href='tel:{$model->telefone1}'>{$model->telefone1}</a> <a href='tel:{$model->telefone2}'>{$model->telefone2}</a> <a href='tel:{$model->telefone3}'>{$model->telefone3}</a>",
					'type'=>'raw'
					),
				'contato',
				array(
					'name'=>'cnpj',
					'value'=>(isset($model->cnpj))?Yii::app()->format->formataCnpjCpf($model->cnpj, $model->fisica):null,
					),
				array(
					'name'=>'ie',
					'value'=>(isset($model->ie))?Yii::app()->format->formataInscricaoEstadual($model->ie, $model->Cidade->Estado->sigla):null,
					),
				array(
					'name'=>'rntrc',
					),
				array(
					'name'=>'tipotransportador',
					'value'=>$tipoTransportador,
					),
				array(
					'name'=>'endereco',
					'value'=>Yii::app()->format->formataEndereco($model->endereco, $model->numero, $model->complemento, $model->bairro, $model->Cidade->cidade, $model->Cidade->Estado->sigla, $model->cep, true),
					'type'=>'raw'
					),
				);

		if (!$model->cobrancanomesmoendereco)
			$attributes[] =
				array(
					'name'=>'enderecocobranca',
					'label'=>'Cobrança',
					'value'=>Yii::app()->format->formataEndereco($model->enderecocobranca, $model->numerocobranca, $model->complementocobranca, $model->bairrocobranca, $model->CidadeCobranca->cidade, $model->CidadeCobranca->Estado->sigla, $model->cepcobranca, true),
					'type'=>'raw'
					);

		if (!empty($model->email))
			$attributes[] =
				array(
					'name'=>'email',
					'value'=>CHtml::link($model->email, 'mailto:'.$model->email),
					'type'=>'raw',
					);

		if (!empty($model->emailnfe))
			$attributes[] =
				array(
					'name'=>'emailnfe',
					'value'=>(isset($model->emailnfe))?CHtml::link($model->emailnfe, 'mailto:'.$model->emailnfe):null,
					'type'=>'raw',
					);

		if (!empty($model->emailcobranca))
			$attributes[] =
				array(
					'name'=>'emailcobranca',
					'value'=>(isset($model->emailcobranca))?CHtml::link($model->emailcobranca, 'mailto:'.$model->emailcobranca):null,
					'type'=>'raw',
					);

		if ($model->fisica)
		{
			$attributes = array_merge($attributes,
				array(
					'rg',
					array(
						'name'=>'codsexo',
						'value'=>isset($model->codsexo)?$model->Sexo->sexo:null,
						),
					array(
						'name'=>'codestadocivil',
						'value'=>isset($model->codestadocivil)?$model->EstadoCivil->estadocivil:null,
						),
					'conjuge',
				));

		}

		$this->widget('bootstrap.widgets.TbDetailView',array(
			'data'=>$model,
			'attributes'=>$attributes));

		$this->widget('UsuarioCriacao', array('model'=>$model));

		?>
	</div>
	<div class="span6">
		<?php

		$attributes = array(
			array(
				'name'=>'cliente',
				'value'=>($model->cliente)?'Sim':'Não',
				),
		);

		if ($model->cliente)
		{

			$total = $model->totalTitulos();

			$attributes = array_merge($attributes,
				array(
					array(
					'name'=>'codgrupocliente',
					'value'=>(isset($model->GrupoCliente))?CHtml::link(CHtml::encode($model->GrupoCliente->grupocliente),array('grupoCliente/view','id'=>$model->codgrupocliente)):null,
					'type'=>'raw',
					),

					array(
						'name'=>'notafiscal',
						'value'=>$model->getNotaFiscalDescricao(),
					),
					array(
						'name'=>'consumidor',
						'value'=>($model->consumidor)?'Sim':'Não',
					),
					array(
						'name'=>'codformapagamento',
						'value'=>isset($model->codformapagamento)?$model->FormaPagamento->formapagamento:null,
					),
					array(
						'name'=>'desconto',
						'value'=>isset($model->desconto)?Yii::app()->format->formatNumber($model->desconto) . " %":null,
					),
					array(
						'name'=>'creditobloqueado',
						'value'=>($model->creditobloqueado)?'Sim':'Não',
					),
					array(
						'label'=>'Saldo em Aberto',
						'value'=>Yii::app()->format->formatNumber($total["saldo"]),
					),
					array(
						'name'=>'credito',
						'value'=>isset($model->credito)?Yii::app()->format->formatNumber($model->credito):null,
					),
					array(
						'label'=>'Primeiro Vencimento',
						'value'=>$total["vencimento"] . " (" . $total["vencimentodias"] . " Dias)",
					),
					array(
						'name'=>'toleranciaatraso',
						'value'=>$model->toleranciaatraso . " Dias",
					),
					array(
						'name'=>'mensagemvenda',
						'value'=>(isset($model->mensagemvenda))?nl2br($model->mensagemvenda):null,
						'type'=>'raw',
					),
				)
			);

		}

		$attributes = array_merge($attributes,
			array(
				array(
					'name'=>'observacoes',
					'value'=>(isset($model->observacoes))?nl2br($model->observacoes):null,
					'type'=>'raw',
					),
				array(
					'name'=>'vendedor',
					'value'=>($model->vendedor)?'Sim':'Não',
					),
				array(
					'name'=>'fornecedor',
					'value'=>($model->fornecedor)?'Sim':'Não',
					)
				));

				foreach ($model->MercosClientes as $cli) {
					$attributes[] = [
						'name'=>'Mercos ID',
						'value' => CHtml::link($cli->clienteid, MERCOS_URL_ADM . "clientes/{$cli->clienteid}/", ['target' => '_blank']),
						'type'=>'raw',
					];
				}

		$this->widget('bootstrap.widgets.TbDetailView',array(
			'data'=>$model,
			'attributes'=>$attributes));
		?>
	</div>
</div>

<?php

$pc=new PessoaCertidao('search');

$pc->unsetAttributes();  // clear any default values

if(isset($_GET['PessoaCertidao']))
Yii::app()->session['FiltroPessoaCertidaoIndex'] = $_GET['PessoaCertidao'];

if (isset(Yii::app()->session['FiltroPessoaCertidaoIndex'])) {
	$pc->attributes=Yii::app()->session['FiltroPessoaCertidaoIndex'];
}

$pc->codpessoa = $model->codpessoa;

$abaCertidoes = $this->renderPartial(
	'/pessoaCertidao/index',
	array(
		'dataProvider'=>$pc->search(),
		'model'=>$pc,
	),
	true
);


$registrospc=new RegistroSpc('search');

$registrospc->unsetAttributes();  // clear any default values

if(isset($_GET['RegistroSpc']))
Yii::app()->session['FiltroRegistroSpcIndex'] = $_GET['RegistroSpc'];

if (isset(Yii::app()->session['FiltroRegistroSpcIndex']))
	$registrospc->attributes=Yii::app()->session['FiltroRegistroSpcIndex'];

$registrospc->codpessoa = $model->codpessoa;

$abaSPC = $this->renderPartial(
	'/registroSpc/index',
	array(
		'dataProvider'=>$registrospc->search(),
		'model'=>$registrospc,
	),
	true
);




$cobrancahistorico=new CobrancaHistorico('search');

$cobrancahistorico->unsetAttributes();  // clear any default values

if(isset($_GET['CobrancaHistorico']))
Yii::app()->session['FiltroCobrancaHistoricoIndex'] = $_GET['CobrancaHistorico'];

if (isset(Yii::app()->session['FiltroCobrancaHistoricoIndex']))
	$cobrancahistorico->attributes=Yii::app()->session['FiltroCobrancaHistoricoIndex'];

$cobrancahistorico->codpessoa = $model->codpessoa;

$abaCobr = $this->renderPartial(
	'/cobrancaHistorico/index',
	array(
		'dataProvider'=>$cobrancahistorico->search(),
		'model'=>$cobrancahistorico,
	),
	true
);


$this->widget('bootstrap.widgets.TbTabs',
	array(
		'type' => 'tabs',
		'tabs' =>
			array(
				array('label' => 'Histórico de Cobrança', 'content' => $abaCobr, 'active' => true),
				array('label' => 'Registro de SPC', 'content' => $abaSPC, 'active' => false),
				array('label' => 'Certidões', 'content' => $abaCertidoes, 'active' => false),
			)
	)
);

?>

<?php
$this->pagetitle = Yii::app()->name . ' - Pessoa';
$this->breadcrumbs=array(
	'Pessoa',
);

$this->menu=array(
	array('label'=>'Nova', 'icon'=>'icon-plus', 'url'=>array('create')),
	array('label'=>'Importar', 'icon'=>'icon-upload', 'url'=>'#', 'linkOptions'=>  array('id'=>'btnAbrirModalImportacao')),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);
?>
<script type='text/javascript'>

$(document).ready(function(){
	$('#search-form').change(function(){
		var ajaxRequest = $("#search-form").serialize();
		$.fn.yiiListView.update(
			// this is the id of the CListView
			'Listagem',
			{data: ajaxRequest}
		);
    });

	$('#modalImportar').on('show', function () {
		$('#cnpj').focus();
	});

	//abre janela Importar
	$('#btnAbrirModalImportacao').click(function(event){
		event.preventDefault();
		$('#modalImportar').modal({show:true})
		// $('#modalImportar').css({'width': '25%', 'text-align':'left', 'margin-left':'auto', 'margin-right':'auto', 'left':'35%'});
		// preenche o select da Filial de acordo com o codfilial do usuario
		var filial = <?php echo Yii::app()->user->getState("codfilial"); ?>;
		document.getElementById('filial').value = filial;
	});

	// Salva o preenchimento do formulario e envia um POST para a api
	$('#btnImportar').click(function(event){

		$.ajax({
			url: '<?php echo MGSPA_API_URL ?>pessoa/importar',
			type: 'post',
			data: {
				cnpj: $("#cnpj").val(), 
				cpf:  $("#cpf").val(), 
				ie: $("#ie").val(),
				uf:  $("#uf").val(),
				codfilial: $("#filial").val()
			},
			headers: {
				'Accept': 'application/json'
			},
			success: function (resp) {
				$('#modalImportar').modal('hide');
				if (resp.data == null) {
					mensagem = "<h3 class='text-error'>" + resp.message + "</h3>";
					bootbox.alert(mensagem);
					return;
				}
				if (resp.data.length == 0) {
					mensagem = "<h3 class='text-error'>Nâo foi localizado nenhum cadastro com os dados Informados!</h3>";
					bootbox.alert(mensagem);
					return;
				}
				document.getElementById("Pessoa_cnpj").value = resp.data[0].cnpj;
				document.getElementById("yw2").click();
				$.notify(resp.data.length + " cadastro(s) importados!", { position:"right bottom", className:"success", autoHideDelay: 15000 });
			},
			error: function (xhr) {
				$('#modalImportar').modal('hide');
				console.info(xhr);
				var err = JSON.parse(xhr.responseText);
				mensagem = "<h3 class='text-error'>" + err.message + "</h3>";
				bootbox.alert(mensagem);
			}
		});

	});	
});

</script>

<h1>Pessoas</h1>

<?php $form=$this->beginWidget('MGActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'id' => 'search-form',
	'type' => 'inline',
	'method'=>'get',
)); 

?>

<div class="well well-small hidden-print">
	<?php echo $form->textField($model, 'codpessoa', array('placeholder' => '#', 'class'=>'input-mini')); ?>
	<?php echo $form->textField($model, 'fantasia', array('placeholder' => 'Nome', 'class'=>'input-large')); ?>
	<?php echo $form->textField($model, 'cnpj', array('placeholder' => 'Cnpj/Cpf', 'class'=>'input-small')); ?>
	<?php echo $form->textField($model, 'email', array('placeholder' => 'Email', 'class'=>'input-small')); ?>
	<?php echo $form->textField($model, 'telefone1', array('placeholder' => 'Fone', 'class'=>'input-small')); ?>
	<?php echo $form->dropDownList($model, 'inativo', array('' => 'Ativos', 1 => 'Inativos', 9 => 'Todos'), array('placeholder' => 'Inativo', 'class'=>'input-small')); ?>
	<?php echo $form->select2Cidade($model, 'codcidade', array('class' => 'input-large') );?>
	<?php echo $form->select2($model, 'codgrupocliente', GrupoCliente::getListaCombo(), array('placeholder' => 'Grupo de Cliente', 'class'=>'input-large')); ?>

	<?php
	$this->widget('bootstrap.widgets.TbButton'
		, array(
			'buttonType' => 'submit',
			'icon'=>'icon-search',
			//'label'=>'',
			'htmlOptions' => array('class'=>'pull-right btn btn-info')
			)
		); 
	?>
</div>

<?php $this->endWidget(); ?>

<div class="row-fluid">
<?php
 
$this->widget(
	'zii.widgets.CListView', 
	array(
		'id' => 'Listagem',
		'dataProvider' => $dataProvider,
		'itemView' => '_view',
		'template' => '{items} {pager}',
		'pager' => array(
			'class' => 'ext.infiniteScroll.IasPager', 
			'rowSelector'=>'.registro', 
			'listViewId' => 'Listagem', 
			'header' => '',
			'loaderText'=>'Carregando...',
			'options' => array('history' => false, 'triggerPageTreshold' => 10, 'trigger'=>'Carregar mais registros'),
		)
	)
);
?>
</div>

<form class="form-horizontal">
<div id="modalImportar" class="modal hide fade" tabindex="-1" role="dialog">
	<div class="modal-header">
		<h3>
			Importar Pessoa <br>
			<small>Importar cadastro da Receita Federal ou Sintegra</small>
		</h3>
	</div>
	<div class="modal-body" >
		<div class="control-group">
			<label class="control-label" for="cnpj">CNPJ</label>
			<div class="controls">
				<input type="text" class="form-control input-medium" name="cnpj" id="cnpj" placeholder="CNPJ"/>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="cpf">CPF</label>
			<div class="controls">
				<input type="text" class="form-control input-small" name="cpf" id="cpf" placeholder="CPF"/>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="ie">IE</label>
			<div class="controls">
				<input type="text" class="form-control input-small" name="ie" id="ie" placeholder="Inscrição Estadual"/>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="uf">UF</label>
			<div class="controls">
				<select class="input-medium" name="uf" id="uf" placeholder="Estado">
					<option value="" selected>Selecione UF</option>
					<option value="MT">Mato Grosso</option>
					<option value="AC">Acre</option>
					<option value="AL">Alagoas</option>
					<option value="AP">Amapá</option>
					<option value="AM">Amazonas</option>
					<option value="BA">Bahia</option>
					<option value="CE">Ceará</option>
					<option value="DF">Distrito Federal</option>
					<option value="ES">Espírito Santo</option>
					<option value="GO">Goiás</option>
					<option value="MA">Maranhão</option>
					<option value="MS">Mato Grosso do Sul</option>
					<option value="MG">Minas Gerais</option>
					<option value="PA">Pará</option>
					<option value="PB">Paraíba</option>
					<option value="PR">Paraná</option>
					<option value="PE">Pernambuco</option>
					<option value="PI">Piauí</option>
					<option value="RJ">Rio de Janeiro</option>
					<option value="RN">Rio Grande do Norte</option>
					<option value="RS">Rio Grande do Sul</option>
					<option value="RO">Rondônia</option>
					<option value="RR">Roraima</option>
					<option value="SC">Santa Catarina</option>
					<option value="SP">São Paulo</option>
					<option value="SE">Sergipe</option>
					<option value="TO">Tocantins</option>
				</select>
			</div>
		</div>
	
		<div class="control-group">
			<label class="control-label" for="filial">Filial</label>
			<div class="controls">
				<select class="input-small" name="filial" id="filial">
					<option value="104">Imperial</option>
					<option value="103">Centro</option>
					<option value="102">Botanico</option>
					<option value="105">André Maggi</option>
					<option value="201">FDF</option>
					<option value="101">Deposito</option>
					<option value="199">Defeito</option>
					<option value="501">Arquitetura</option>
					<option value="905">Fernanda</option>
					<option value="903">Fabio</option>
					<option value="904">Diogo</option>
					<option value="901">Vitorio</option>
					<option value="402">Renascer</option>
					<option value="401">Fazenda</option>
					<option value="301">Sinopel</option>
					<option value="202">FDF Filial</option>
					<option value="702">JDI</option>
					<option value="701">MAB</option>
					<option value="801">JMJ</option>
					<option value="906">Andreia</option>
					<option value="902">Mari</option>
				</select>
			</div>
		</div>
	</div>

	<div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
		<button type="button" class="btn btn-primary" id="btnImportar">Importar</button>
	</div">
</div>
</form>

<?php
$this->pagetitle = Yii::app()->name . ' - Etiquetas de Produto';
$this->breadcrumbs=array(
	'Etiquetas de Produto',
);

$this->menu=array(
	array('label'=>'Imprimir', 'icon'=>'icon-print', 'url'=>'#form-content', 'linkOptions'=>array('data-toggle'=>'modal')),
	array('label'=>'Limpar Listagem Produtos', 'icon'=>'icon-trash', 'linkOptions'=>array('class'=>'delete-etiqueta'), 'url'=>array('delete', 'id'=>'todos')),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);


?>

<script type='text/javascript'>

$(document).ready(function(){
	//$("#Produto_preco_de").autonumeric();
	$('#Produto_preco_de').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#Produto_preco_ate').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	
});

</script>

<h1>Etiquetas de Produto</h1>

<br>

<?php $form=$this->beginWidget('MGActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'id' => 'search-form',
	'type' => 'inline',
	'method'=>'get',
)); 

?>
<div class="well well-small">
	<form>
		<div class="row-fluid">
			<div class="input-prepend">
				<label class="add-on" for="quantidade">Quantidade</label>
				<input class="input-mini text-right" id="quantidade" type="text" value="1">
			</div>
			<div class="input-prepend input-append">
				<label class="add-on" for="barras">Código</label>
				<input class="input-medium text-right" id="barras" type="text">
				<button class="btn" type="submit" id="btnAdicionar" tabindex="-1">Adicionar</button>
			</div>
		</div>
		<div class="row-fluid">
			<?php
			$this->widget('MGSelect2ProdutoBarra', 
				array(
					'name' => 'codprodutobarra', 
					'htmlOptions' => array(
						'class' => 'span12', 
						'placeholder' => 'Pesquisa de Produtos ($ ordena por preço)'
						),
					)
				); 
			?>
		</div>
	</form>
</div>

<div id='listagemEtiquetas' class=''>
	<?php

		if (isset(Yii::app()->session['EtiquetaProduto']))
		{
			$i=0;
			foreach (Yii::app()->session['EtiquetaProduto'] as $etiqueta)
			{
				$pb = ProdutoBarra::model()->findByPk($etiqueta['codprodutobarra']);
				
				?>
					<small class='span3 alert-success alert'>
						<div class='row-fluid'>
							<B class='span3'>
								<?php echo Yii::app()->format->formatNumber($etiqueta['quantidade'], 0); ?> X
							</B>
							<div class='span5 muted'>
								<?php echo CHtml::encode($pb->barras); ?>
							</div>
							<div class='span3 muted'>
								<?php echo CHtml::link(Yii::app()->format->formataCodigo($pb->codproduto, 6), array('produto/view', 'id'=> $pb->codproduto)) ?>
							</div>
							<div class='span1 text-right'>
								<a class="delete-etiqueta" href="<?php echo Yii::app()->createUrl('etiquetaProduto/delete', array('id'=>$i)); ?>"><i class="icon-trash"></i></a>
							</div>
						</div>
						<b class='row-fluid'>
							<?php echo $pb->descricao ?>
						</b>
						<div class='row-fluid'>							
							<div class='span6 muted'>
								<?php echo $pb->UnidadeMedida->sigla ?>
								<?php 
									if (isset($pb->ProdutoEmbalagem))
										echo $pb->ProdutoEmbalagem->descricao; 
								?>
							</div>
							<b class='span6 text-right'>
								R$ 
								<?php echo Yii::app()->format->formatNumber($pb->preco); ?>
							</b>
						</div>
					</small>
				<?php
				$i++;
			}
		}

	?>
</div>

<?php
$form=$this->beginWidget('MGActiveForm',array(
	'id'=>'etiqueta-form',
)); 

function getActivePrinters() 
{

	$o = shell_exec("lpstat -d -p");
	$res = explode("\n", $o);

	$printers[''] = '';
	foreach ($res as $r) 
	{
		if (strpos($r, "printer") !== FALSE) 
		{
			$r = str_replace("printer ", "", $r);
			$r = explode(" ", $r);
			$printers[$r[0]] = $r[0];
		}
	}

	return $printers;
}

$imp = getActivePrinters();
?>

<?php echo $form->errorSummary($model); ?>
<fieldset>
	<div id="form-content" class="modal hide fade in" style="display: none;">
		<div class="modal-header">
			<a class="close" data-dismiss="modal">×</a>
			<h3>Modelo de Etiqueta e Impressora</h3>
		</div>
		<div class="modal-body">
			<label class="label" for="impressora">Impressora</label><br>
			<?php
				$this->widget(
					'bootstrap.widgets.TbSelect2',
					array(
						'asDropDownList' => true,
						'name' => 'impressora',
						'data' => $imp,
						'htmlOptions' => array(
							'class' => 'input-xlarge',							
						),
						'options' => array(
							'placeholder' => 'Selecione a impressora',
						)
					)
				);
				?><br><br>
			<label class="label" for="modelo">Modelo</label><br>
			<?php
				$this->widget(
					'bootstrap.widgets.TbSelect2',
					array(
						'asDropDownList' => true,
						'name' => 'modelo',
						'value' => null,
						'data' => array(
							''=>'', 
							'3colunas'=>'Pequena com 3 Colunas por linha', 
							'3colunas_sempreco'=>'Pequena com 3 Colunas por linha - Sem Preço', 
							'2colunas'=>'Média com 2 Colunas por linha', 
							'2colunas_sempreco'=>'Média com 2 Colunas por linha - Sem Preço', 
							'gondola'=>'Grande para Gondola'
						),
						'htmlOptions' => array(
							'class' => 'input-xxlarge',							
						),
						'options' => array(
							'placeholder' => 'Selecione o tipo!',
						)
					)
				);
			?>
			<br>
			<br>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn btn-primary" data-dismiss="modal" id='btnImprimir'>Imprimir</a>
			<a href="#" class="btn" data-dismiss="modal">Cancelar</a>
		</div>
	</div>
</fieldset>
<?php $this->endWidget(); ?>

<script>
	
	function atualizaListagemProdutos()
	{
		$.ajax({
			url: "<?php echo Yii::app()->createUrl('etiquetaProduto/index') ?>",
			type: "GET",
			dataType: "html",
			//async: true,
			success: function (data) {
				$('#listagemEtiquetas').html($(data).find("#listagemEtiquetas"));
			},
			error: function (xhr, status) {
				bootbox.alert("Erro ao atualizar listagem de produtos!");
			},
		});				

	}

	function atualizaTela()
	{
		atualizaListagemProdutos();
	}

	function adicionaProduto()
	{

		var barras = $("#barras").val();
		var quantidade = $('#quantidade').autoNumeric('get');
		$("#barras").val("");
		$.ajax({
			url: "<?php echo Yii::app()->createUrl('etiquetaProduto/adicionarproduto') ?>",
			data: {
				barras: barras,
				quantidade: quantidade,
			},
			type: "GET",
			dataType: "json",
			//async: false,
			success: function(data) {
				if (!data.Adicionado)
				{
					bootbox.dialog(data.Mensagem, 
						[{
							"label" : "Fechar",
							"class" : "btn-warning",
							"callback": function() {
									$("#barras").focus();
								}						
						}]);
					$.notify(barras + " Não Localizado!", { position:"right bottom", className:"error", autoHideDelay: 15000 });
				}
				else
				{
					//$("#barras").notify("Adicionado!", "success", { position:"left" });
					$("#quantidade").autoNumeric('set', 1);
					$.notify(barras + " Adicionado!", { position:"right bottom", className:"success", autoHideDelay: 15000 });
					atualizaTela();
				}
			},
			error: function (xhr, status) {
				bootbox.alert("Erro ao adicionar produto!");
			},
		});
	}

	function preencheQuantidade()
	{
		//pega campo com codigo de barras
		var barras = $("#barras").val().trim();

		//o tamanho com o asterisco deve ser entre 2 e 5
		if (barras.length > 6 || barras.length < 2)
			return;

		// se o último dígito é o asterisco
		if (barras.slice(-1) != "*")
			return;

		//se o valor antes do asterisco é um número
		barras = barras.substr(0, barras.length - 1).trim().replace(',', '.');
		if (!$.isNumeric(barras))
			return;

		// se o número é maior ou igual à 1
		barras=parseFloat(barras);
		if (barras < 0.01)
			return;

		//preenche o campo de quantidade
		//$("#quantidade").val(barras);
		$("#quantidade").autoNumeric('set', barras);

		//limpa o código de barras
		$("#barras").val("");

		$('#quantidade').animate({opacity: 0.25,}, 200 );			
		$('#quantidade').animate({opacity: 1,}, 200 );			
	}

	$(document).ready(function() {

		$("#btnImprimir").click(function(){
			$.ajax(
			{
				type: "GET",
				url: "<?php echo Yii::app()->createUrl('etiquetaProduto/imprimir') ?>",
				data: $('#etiqueta-form').serialize(),
				dataType: "json",
				success: function(data)
				{
					if (!data.Impresso)
					{
						bootbox.dialog(data.Mensagem, 
							[{
								"label" : "Fechar",
								"class" : "btn-warning",
								"callback": function() {
										$("#barras").focus();
									}						
							}]);
						$.notify("Erro ao imprimir!", { position:"right bottom", className:"error", autoHideDelay: 15000 });
					}
					else
					{
						$.notify("Etiquetas enviadas para impressora!!", { position:"right bottom", className:"success", autoHideDelay: 15000 });
					}
				},
				error: function (xhr, status) 
				{
					console.log(xhr, status);
					bootbox.alert("Erro ao imprimir!");
				},
			});
		});

		$("#barras").focus();
		$('#quantidade').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });

		$("#btnAdicionar").click(function(e){ 
			e.preventDefault();
			adicionaProduto (); 
		});

		$("#barras").keyup(function(){ 
			preencheQuantidade();
		});

		$('#codprodutobarra').change(function(e) { 
			if ($("#codprodutobarra").select2('data') != null)
			{
				$("#barras").val($("#codprodutobarra").select2('data').barras);
				window.setTimeout(function(){$('#barras').focus();}, 0);
				$('#codprodutobarra').select2('data', null);
				adicionaProduto ();
			}
		});
		// botão delete da embalagem
		jQuery(document).on('click','a.delete-etiqueta',function(e) {

			//evita redirecionamento da pagina
			e.preventDefault();

			// pega url para delete
			var url = jQuery(this).attr('href');

			//pede confirmacao
			bootbox.confirm("Deseja realmente excluir?", function(result) {

				// se confirmou
				if (result) {

					//faz post
					jQuery.ajax({
						type: 'POST',
						url: url,

						//se sucesso, atualiza listagem de embalagens
						success: function(){
							$.notify("Exclusão com sucesso!", { position:"right bottom", className:"info", autoHideDelay: 15000 });
							atualizaTela();
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
	
</script>

	

<?php $this->endWidget(); ?>


<?php
 /*
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
  * 
  */
?>

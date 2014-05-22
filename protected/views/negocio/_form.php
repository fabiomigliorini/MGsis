<?php $form=$this->beginWidget('MGActiveForm',array(
	'id'=>'negocio-form',
)); ?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
	<div class="span6">
		<?php 	

		// codfilial
		echo $form->select2Row($model, 'codfilial', Filial::getListaCombo(), array('prompt' => '', 'class' => 'input-medium'));

		echo $form->select2Row(
			$model, 
			'codnaturezaoperacao', 
			NaturezaOperacao::getListaCombo(), 
			array(
				//'placeholder'=>'Tributação',
				'class' => 'input-xlarge'
			)
		);

		// codpessoa
		echo $form->select2PessoaRow(
				$model, 
				'codpessoa',
				array(
					//'placeholder'=>'Tributação',
					'class' => 'span4'
					)
				);

		// codpessoavendedor
		echo $form->select2PessoaRow(
				$model, 
				'codpessoavendedor',
				array(
					'vendedor' => true,
					'class' => 'span4'
					)
				);
		echo $form->textAreaRow($model,'observacoes',array('class'=>'span4', 'rows'=>'6','maxlength'=>500, 'tabindex'=>-1));
		?>
	</div>
	<?php if (!$model->isNewRecord): ?>
	<div class="span6">
		<?
		echo $form->textFieldRow($model,'valorprodutos',array('class'=>'input-small text-right','maxlength'=>14, "readOnly"=>true, "tabindex"=>-1));
		echo $form->textFieldRow($model,'percentualdesconto',array('class'=>'input-mini text-right','maxlength'=>14, 'append'=>'%'));
		echo $form->textFieldRow($model,'valordesconto',array('class'=>'input-small text-right','maxlength'=>14));
		echo $form->textFieldRow($model,'valortotal',array('class'=>'input-small text-right','maxlength'=>14, "readOnly"=>true, "tabindex"=>-1));
		$this->renderPartial('_view_pagamentos', array('model'=>$model))
		?>
	</div>
	<?php endif; ?>
</fieldset>
<div class="form-actions">

    
    <?php 
	
	if ($model->isNewRecord)
	{
		$this->widget(
			'bootstrap.widgets.TbButton',
			array(
				'buttonType' => 'submit',
				'type' => 'primary',
				'label' => 'Criar Novo',
				'icon' => 'icon-ok',
				)
			); 
	}
	else
	{
        $this->widget(
            'bootstrap.widgets.TbButton',
            array(
                'id' => 'btnSalvarFechar',
                'buttonType' => 'submit',
                'type' => 'primary',
                'label' => 'Salvar e Fechar',
                'icon' => 'icon-ok',
                )
            ); 
		
		echo "&nbsp;";
		
        $this->widget(
            'bootstrap.widgets.TbButton',
            array(
                'id' => 'btnSalvar',
                'buttonType' => 'submit',
                'type' => 'warning',
                'label' => 'Somente Salvar',
                'icon' => 'icon-ok',
                )
            ); 
	}
	?>
	
</div>

<?php $this->endWidget(); ?>

<script type='text/javascript'>
	
function atualizaValorDesconto()
{
	//pega valor Desconto
	var valorDesconto =
		$('#Negocio_percentualdesconto').autoNumeric('get') * 
		$('#Negocio_valorprodutos').autoNumeric('get') / 100;
	
	//Pega Valor Produto
	var valorProdutos = 
		$('#Negocio_valorprodutos').autoNumeric('get');
	
	//Calcula Total
	var valorTotal = valorProdutos - valorDesconto;
	
	var valorArredondamento = 0.01;
	
	if (valorDesconto > 0)
	{
		valorArredondamento = 0.25;
		
		if (valorTotal > 1000)
			valorArredondamento = 5;
		else if (valorTotal > 100)
			valorArredondamento = 1;
		else if (valorTotal < 5)
			valorArredondamento = 0.01;
		else if (valorTotal < 10)
			valorArredondamento = 0.05;
		else if (valorTotal < 20)
			valorArredondamento = 0.10;
	}
	
	//Arredondao Total em 0.25
	valorTotal = Math.round(valorTotal/valorArredondamento) * valorArredondamento;
	
	//Recalcula Desconto
	valorDesconto = valorProdutos - valorTotal;
	
	//Altera campo tela
	$('#Negocio_valordesconto').autoNumeric('set', valorDesconto);
	
	//Atualiza Percentual
	atualizaPercentualDesconto();
}

function atualizaPercentualDesconto()
{
	var percentualDesconto = 0;
	
	if ($('#Negocio_valorprodutos').autoNumeric('get') > 0)
		percentualDesconto = 
			$('#Negocio_valordesconto').autoNumeric('get') * 100 / 
			$('#Negocio_valorprodutos').autoNumeric('get');

		
	$('#Negocio_percentualdesconto').autoNumeric('set', percentualDesconto);
	
	atualizaValorTotal();
}

function atualizaValorTotal()
{
	$('#Negocio_valortotal').autoNumeric('set',
		$('#Negocio_valorprodutos').autoNumeric('get') -
		$('#Negocio_valordesconto').autoNumeric('get')
	);
	atualizaValorPagamento(false);
}

function mostraMensagemVenda()
{
	$.ajax({
		url: "<?php echo Yii::app()->createUrl('pessoa/detalhes') ?>",
		data: {
			codpessoa: $("#Negocio_codpessoa").val()
		},
		type: "GET",
		dataType: "JSON",
		async: true,
		success: function (data) {
			if (data.mensagemvenda != null)
				bootbox.dialog("<pre>" + data.mensagemvenda + "</pre>", 
					[{
						"label" : "Fechar",
						"class" : "btn-warning",
						"callback": function() {
								$('#Negocio_codpessoavendedor').select2('focus');			
							}						
					}]);
				
			if (data.desconto != null)
			{
				$('#Negocio_percentualdesconto').autoNumeric('set', data.desconto);
				atualizaValorDesconto();
			}
			
			if (data.codformapagamento != null)
				$('#codformapagamento').select2('val', data.codformapagamento);
		},
		error: function (xhr, status) {
			bootbox.alert("Erro ao atualizar totais!");
		},
	});	
}

$(document).ready(function() {

	$('#Negocio_percentualdesconto').change(function() {
		atualizaValorDesconto();
    });
	
	$('#Negocio_valordesconto').change(function() {
		atualizaPercentualDesconto();
    });

	//$("#Pessoa_fantasia").Setcase();
	$('#Negocio_valorprodutos').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#Negocio_percentualdesconto').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#Negocio_valordesconto').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#Negocio_valortotal').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	
	$('#Negocio_codpessoa').on("change", function(e) {
		if ($('#Negocio_codpessoa').select2('val') > 0)
			mostraMensagemVenda();
	});
	
	$('.btn-primary').focus();
	
	$('#btnSalvarFechar').bind("click", function(e) {
		$("#negocio-form").attr("action", "<?php echo $this->createUrl('update',array('id'=>$model->codnegocio, 'fechar'=>1)); ?>");
	});
	
	$('#btnSalvar').bind("click", function(e) {
		$("#negocio-form").attr("action", "<?php echo $this->createUrl('update',array('id'=>$model->codnegocio, 'fechar'=>0)); ?>");
	});
	
	$('#negocio-form').submit(function(e) {
		var currentForm = this;
		//alert($("#fechar").val());
		e.preventDefault();
		bootbox.confirm("Tem certeza que deseja salvar?", function(result) {
			if (result) {
				bootbox.dialog("<h1>Aguarde... <br>Salvando Negócio<h1>", 
					[]);				
				currentForm.submit();
			}
		});
    });	
});

</script>



<?php 

if (!$model->isNewRecord)
	Yii::app()->clientScript->registerScript('script', <<<JS

		// Coloca Foco no codpessoa
		$('#Negocio_codpessoa').select2('focus');

JS
	, CClientScript::POS_READY);
?>
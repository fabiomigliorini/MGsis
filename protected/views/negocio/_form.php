<?php $form=$this->beginWidget('MGActiveForm', array(
    'id'=>'negocio-form',
)); ?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
	<div class="row-fluid">
		<div class="span6">
			<input type="hidden" name="fechar" id="fechar" value="0">
			<?php

            // codfilial
            echo $form->select2Row($model, 'codfilial', Filial::getListaCombo(), array('prompt' => '', 'class' => 'input-medium'));
            echo $form->select2Row($model, 'codestoquelocal', EstoqueLocal::getListaCombo(), array('prompt' => '', 'class' => 'input-medium'));

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
                        'class' => 'span12'
                        )
            );

            $style = '';
            $focoCpf = true;
            if ($model->codpessoa != Pessoa::CONSUMIDOR) {
              $style = 'display: none;';
              $focoCpf = false;
            }
      ?>
      <div id="CampoCpf" style="<?php echo $style; ?>">
        <?php
            if (!empty($model->cpf)) {
              $model->cpf = Yii::app()->format->formataPorMascara($model->cpf, '###########');
            }
            echo $form->textFieldRow($model, 'cpf', array('class'=>'input-medium text-center', 'maxlength'=>11));
        ?>
      </div>
      <?php

            // codpessoavendedor
            echo $form->select2PessoaRow(
                $model,
                'codpessoavendedor',
                array(
                        'vendedor' => true,
                        'class' => 'span12'
                        )
            );
            echo $form->textAreaRow($model, 'observacoes', array('class'=>'span12', 'rows'=>'6','maxlength'=>500, 'tabindex'=>-1));
            ?>
		</div>
		<?php if (!$model->isNewRecord): ?>
		<div class="span6">
			<?php
            echo $form->textFieldRow($model, 'valorprodutos', array('class'=>'input-small text-right','maxlength'=>14, "readOnly"=>true, "tabindex"=>-1, 'prepend' => 'R$'));
            echo $form->textFieldRow($model, 'percentualdesconto', array('class'=>'input-small text-right','maxlength'=>14, 'append'=>'%'));
            echo $form->textFieldRow($model, 'valordesconto', array('class'=>'input-small text-right','maxlength'=>14, 'prepend' => 'R$'));
            echo $form->textFieldRow($model, 'valortotal', array('class'=>'input-small text-right','maxlength'=>14, "readOnly"=>true, "tabindex"=>-1, 'prepend' => 'R$'));
            $this->renderPartial('_view_pagamentos', array('model'=>$model))
            ?>
		</div>
	</div>
	<?php endif; ?>
</fieldset>
<div class="form-actions">


    <?php

    if ($model->isNewRecord) {
        $this->widget(
            'bootstrap.widgets.TbButton',
            array(
                'buttonType' => 'submit',
                'type' => 'primary',
                'label' => 'Criar Novo',
                'icon' => 'icon-ok',
                )
        );
    } else {
        $this->widget(
            'bootstrap.widgets.TbButton',
            array(
                'id' => 'btnSalvarFechar',
                'buttonType' => 'submit',
                'type' => 'primary',
                'label' => 'Salvar e Fechar (F3)',
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

function escondeCpf()
{
  var codpessoa = $('#Negocio_codpessoa').select2('val');
  if (codpessoa == <?php echo Pessoa::CONSUMIDOR ?> ) {
  	$('#CampoCpf').slideDown('slow');
  } else {
    $('#CampoCpf').slideUp('slow');
    $('#Negocio_cpf').val('');
  }
}


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

function salvaDesconto(valorDesconto)
{
	$.ajax({
		url: "<?php echo Yii::app()->createUrl('negocio/atualizavalordesconto') ?>",
		data: {
			codnegocio: <?php echo $model->codnegocio; ?>,
			valordesconto: valorDesconto,
		},
		type: "GET",
		dataType: "json",
		async: false,
		error: function (xhr, status) {
			bootbox.alert("Erro ao salvar desconto!");
		},
	});
}

function atualizaPercentualDesconto()
{
	var percentualDesconto = 0;
  var valorDesconto = $('#Negocio_valordesconto').autoNumeric('get');

	if ($('#Negocio_valorprodutos').autoNumeric('get') > 0)
		percentualDesconto =
			valorDesconto * 100 /
			$('#Negocio_valorprodutos').autoNumeric('get');

	$('#Negocio_percentualdesconto').autoNumeric('set', percentualDesconto);
  salvaDesconto(valorDesconto);
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

	$("#Negocio_observacoes").RemoveAcentos();

	$('#Negocio_valorprodutos').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#Negocio_percentualdesconto').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#Negocio_valordesconto').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#Negocio_valortotal').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });

	$('#Negocio_codpessoa').on("change", function(e) {
    escondeCpf();
		if ($('#Negocio_codpessoa').select2('val') > 0) {
      mostraMensagemVenda();
    }
	});

  <?php
  if ($focoCpf) {
    echo '$(\'#Negocio_cpf\').focus();';
  } else {
    echo '$(\'.btn-primary\').focus();';
  }
  ?>

	$('#btnSalvarFechar').bind("click", function(e) {
		$("#fechar").val(1);
	});

	$('#btnSalvar').bind("click", function(e) {
		$("#fechar").val(0);
	});

	$('#negocio-form').submit(function(e) {

		$(".btn").attr("disabled","disabled");

		var currentForm = this;

		var msg = "Tem certeza que deseja SALVAR o negócio?";
		if ($("#fechar").val()==1)
			msg = "Tem certeza que deseja FECHAR o negócio?";

		e.preventDefault();
		bootbox.confirm(msg, function(result) {
			if (result)
			{
				currentForm.submit();
			}
			else
			{
				$(".btn").removeAttr("disabled");
			}
		});
    });
});

</script>



<?php

if (!$model->isNewRecord) {
    Yii::app()->clientScript->registerScript('script', <<<JS

		// Coloca Foco no codpessoa
		$('#Negocio_codpessoa').select2('focus');

JS
    , CClientScript::POS_READY);
}
?>

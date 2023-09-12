<?php
  $form = $this->beginWidget('MGActiveForm', array(
      'id'=>'negocio-form',
  ));

  $form->type = 'vertical';
?>

<?php echo $form->errorSummary($model); ?>
<input type="hidden" name="fechar" id="fechar" value="0">

<fieldset>
  <div class="row-fluid">

    <div class="span3">
    </div>

    <!-- COLUNA 1 -->
    <div class="span5">
      <div class="row-fluid">
        <div class="span6">
          <?php
            echo $form->select2Row($model, 'codfilial', Filial::getListaCombo(), array('prompt' => '', 'style' => 'width: 100%'));
          ?>
        </div>
        <div class="span6">
          <?php
            echo $form->select2Row($model, 'codestoquelocal', EstoqueLocal::getListaCombo(), array('prompt' => '', 'style' => 'width: 100%'));
          ?>
        </div>
      </div>
      <?php
        echo $form->select2Row(
            $model,
            'codnaturezaoperacao',
            NaturezaOperacao::getListaCombo(),
            array(
                'placeholder'=>'Natureza de Operação',
                'style' => 'width: 100%'
            )
        );
        echo $form->select2PessoaRow(
            $model,
            'codpessoa',
            array(
              'style' => 'width: 100%'
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
            'style' => 'width: 100%'
          )
        );
        echo $form->textAreaRow($model, 'observacoes', array('class'=>'span12', 'rows'=>'6','maxlength'=>500, 'tabindex'=>-1));
      ?>
    


    <div class="form-actions">
  <?php if ($model->isNewRecord): ?>
    <div class="span4">
    </div>
  <?php endif; ?>
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
                'label' => 'Cancelar',
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
                'label' => 'Salvar',
                'icon' => 'icon-ok',
                )
        );
    }
    ?>

</div>

    </div>


  </div>
</fieldset>


<?php $this->endWidget(); ?>

<script type='text/javascript'>

function validarCPF(cpf) {
	cpf = cpf.replace(/[^\d]+/g,'');
	if(cpf == '') return false;
	// Elimina CPFs invalidos conhecidos
	if (cpf.length != 11 ||
		cpf == "00000000000" ||
		cpf == "11111111111" ||
		cpf == "22222222222" ||
		cpf == "33333333333" ||
		cpf == "44444444444" ||
		cpf == "55555555555" ||
		cpf == "66666666666" ||
		cpf == "77777777777" ||
		cpf == "88888888888" ||
		cpf == "99999999999")
			return false;
	// Valida 1o digito
	add = 0;
	for (i=0; i < 9; i ++)
		add += parseInt(cpf.charAt(i)) * (10 - i);
		rev = 11 - (add % 11);
		if (rev == 10 || rev == 11)
			rev = 0;
		if (rev != parseInt(cpf.charAt(9)))
			return false;
	// Valida 2o digito
	add = 0;
	for (i = 0; i < 10; i ++)
		add += parseInt(cpf.charAt(i)) * (11 - i);
	rev = 11 - (add % 11);
	if (rev == 10 || rev == 11)
		rev = 0;
	if (rev != parseInt(cpf.charAt(10)))
		return false;
	return true;
}

function TemCPFInformado()
{
    if ($('#Negocio_valortotal').autoNumeric('get') < 1000) {
        return true;
    }
    if ($('#Negocio_cpf').val() != '') {
        if (validarCPF($('#Negocio_cpf').val())) {
            return true;
        }
        bootbox.alert('<h3 class="text-error">CPF Informado inválido!</h3> Verifique o número do CPF digitado.', function () {
            $('#Negocio_cpf').focus();
        });
        return false;
    }
    if ($('#Negocio_codpessoa').select2('val') != 1) {
        return true;
    }
    bootbox.alert('<h3 class="text-error">Informe o CPF!</h3> Conforme legislação vendas acima de 1.000,00 devem ser identificadas com o CPF do cliente.', function () {
        $('#Negocio_cpf').focus();
    });
    return false;
}


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
  if (valorDesconto < 0.01) {
    valorDesconto = '';
  }

	//Altera campo tela
	$('#Negocio_valordesconto').autoNumeric('set', valorDesconto);

	//Atualiza Percentual
	atualizaPercentualDesconto();
}

function atualizaPercentualDesconto()
{
	var percentualDesconto = 0;
  var valorDesconto = $('#Negocio_valordesconto').autoNumeric('get');

	if ($('#Negocio_valorprodutos').autoNumeric('get') > 0) {
    percentualDesconto =
      valorDesconto * 100 /
      $('#Negocio_valorprodutos').autoNumeric('get');
  }

  if (percentualDesconto < 0.01) {
    percentualDesconto = '';
  }

	$('#Negocio_percentualdesconto').autoNumeric('set', percentualDesconto);
	atualizaValorTotal();
}

function atualizaValorTotal()
{
	var prod = parseFloat($('#Negocio_valorprodutos').autoNumeric('get'));
    if (isNaN(prod)) {
		prod = 0;
	}
	var desc = parseFloat($('#Negocio_valordesconto').autoNumeric('get'));
	if (isNaN(desc)) {
		desc = 0;
	}
	var frete = parseFloat($('#Negocio_valorfrete').autoNumeric('get'));
	if (isNaN(frete)) {
		frete = 0;
	}
    var juros = parseFloat($('#Negocio_valorjuros').autoNumeric('get'));
	if (isNaN(juros)) {
		juros = 0;
	}
	var total = prod - desc + frete + juros;
	$('#Negocio_valortotal').autoNumeric('set', total);
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
        bootbox.hideAll();
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

var negocioStatus = {
  codnegociostatus: <?php echo $model->codnegociostatus ?>,
  valorpagamento: <?php echo $model->valorPagamento() ?>,
};

function verificarStatusNegocio ()
{
  $.ajax({
		url: "<?php echo Yii::app()->createUrl('negocio/status') ?>",
		data: {
			id: "<?php echo $model->codnegocio ?>"
		},
		type: "GET",
		dataType: "JSON",
		// async: true,
		success: function (data) {
            // Se Fechou negocio redireciona para tela visualização perguntando da nota
            if (negocioStatus.codnegociostatus != data.codnegociostatus) {
                window.location.href = '<?php echo Yii::app()->createUrl('negocio/view', ['id'=>$model->codnegocio, 'perguntarNota'=>true]) ?>';
            }
            console.log(data);
            let valorprodutos = $('#Negocio_valorprodutos').autoNumeric('get');
            let valorjuros = $('#Negocio_valorjuros').autoNumeric('get');

            if (valorjuros != data.valorjuros || valorprodutos != data.valorprodutos) {
                $('#Negocio_valorprodutos').autoNumeric('set', data.valorprodutos);
                $('#Negocio_valorjuros').autoNumeric('set', data.valorjuros);
                atualizaValorTotal();
            }

            // se alterou pagamento atualiza listagem de pagamentos
            if (negocioStatus.valorpagamento != data.valorpagamento) {
                if (typeof atualizaListagemPagamentos === 'function') {
                    atualizaListagemPagamentos();
                }
                if (typeof atualizaListagemPixCob === 'function') {
                    atualizaListagemPixCob();
                }
                if (typeof atualizaListagemStonePreTransacao === 'function') {
                    atualizaListagemStonePreTransacao();
                }
                if (typeof atualizaListagemPagarMePedido === 'function') {
                    atualizaListagemPagarMePedido();
                }
            }
            negocioStatus = data;
    	},
    	error: function (xhr, status) {
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

    $('#Negocio_valorfrete').change(function() {
		atualizaValorTotal();
	});

    $('#Negocio_valorjuros').change(function() {
		atualizaValorTotal();
	});

	$("#Negocio_observacoes").RemoveAcentos();

	$('#Negocio_valorprodutos').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.'});
	$('#Negocio_percentualdesconto').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.', mDec:'0', aSign: '%', pSign: 's' });
	// $('#Negocio_percentualdesconto').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.', aSign: '%', pSign: 's' });
	$('#Negocio_valordesconto').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.'});
    $('#Negocio_valorfrete').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.'});
    $('#Negocio_valorjuros').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.'});
	$('#Negocio_valortotal').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.'});

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
    window.location.href="index.php?r=negocio/view&id=" + <?php echo $model->codnegocio; ?>
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
    bootbox.hideAll();
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
<style>

  label {
    margin-top: 12px;
    margin-bottom: 2px;
  }

  input.input-valor {
    font-size: 23pt;
    height: 47px;
    width: 100%;
  }

  span.spanPagarmeParcela {
  }

  label.labelPagarmeParcela {
      font-size: 15pt;
      /* margin-top: 30px; */
      margin-bottom: 5px;
  }

  input.input-valor-pagamento {
    font-size: 23pt;
    height: 47px;
    width: 100%;
  }

  button.input-valor-pagamento {
    font-size: 23pt;
    height: 56px;
    width: 100%;
  }

  .bs-docs-example {
    position: relative;
    margin: 0;
    padding: 8px;
    /* *padding-top: 19px; */
    /* background-color: #fff; */
    border: 1px solid #ddd;
    -webkit-border-radius: 4px;
       -moz-border-radius: 4px;
            border-radius: 4px;
  }

  .logo-pagamento {
    /* border: 1px solid blue; */
    margin-left: 5px;
    margin-bottom: 15px;

  }
</style>

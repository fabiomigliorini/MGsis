<?php
  $form = $this->beginWidget('MGActiveForm', array(
      'id'=>'negocio-form',
  ));

  $form->type = 'vertical';
?>

<?php echo $form->errorSummary($model); ?>
<input type="hidden" name="fechar" id="fechar" value="0">

<fieldset>
  <div class="row-fluid justify-content-center">

    <?php if ($model->isNewRecord): ?>
      <div class="span3">
      </div>
    <?php endif; ?>

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

    </div>


    <?php if (!$model->isNewRecord): ?>

      <!-- COLUNA 2 -->
      <div class="span3">
        <?php
          echo $form->textFieldRow($model, 'valorprodutos', array('class'=>'text-right input-valor','maxlength'=>14, "readOnly"=>true, "tabindex"=>-1));
        ?>
        <div class="row-fluid">
          <div class="span5" style='padding-right: 15px'>
            <?php
              echo $form->textFieldRow($model, 'percentualdesconto', array('label'=> 'teste', 'class'=>'text-right input-valor','maxlength'=>14));
            ?>
          </div>
          <div class="span7">
            <?php
              echo $form->textFieldRow($model, 'valordesconto', array('class'=>'text-right input-valor','maxlength'=>14));
            ?>
          </div>
        </div>
        <?php
          echo $form->textFieldRow($model, 'valorfrete', array('class'=>'text-right input-valor','maxlength'=>14));
          echo $form->select2PessoaRow(
            $model,
            'codpessoatransportador',
            array(
              'tabindex'=>-1,
              'placeholder'=>'Transportador',
              'style' => 'width: 100%'
            )
          );
          echo $form->textFieldRow(
            $model,
            'valortotal',
            array(
              'class'=>'input-medium text-right input-valor',
              'maxlength'=>14,
              'readOnly'=>true,
              'tabindex'=>-1,
              // 'prepend' => 'R$',
              // 'style'=>'max-width: 60%; font-size: 15pt; height: 120%'
            )
          );
        ?>
      </div>

      <!-- COLUNA 3 -->
      <div class="span4">
        <?php

          // Pagamentos
          $this->renderPartial('_view_pagamentos', array('model'=>$model));

          // PagarMe
          if (!empty($model->Filial->pagarmesk)) {
            $this->renderPartial('_view_pagar_me', array('model'=>$model));
          }

          // PIX
          $this->renderPartial('_view_pix_cob', array('model'=>$model));

          // Stone
          $sql = "
            select count(*)
            from mgsis.tblstonefilial
            where codfilial = {$model->codfilial}
            and inativo is null
          ";
          $sf = Yii::app()->db->createCommand($sql)->queryScalar();
          if ($sf > 0) {
            $this->renderPartial('_view_stone', array('model'=>$model));
          }
          
        ?>
      </div>

    <?php endif; ?>

  </div>
</fieldset>
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
	var desc = parseFloat($('#Negocio_valordesconto').autoNumeric('get'));
	if (isNaN(desc)) {
		desc = 0;
	}
	var frete = parseFloat($('#Negocio_valorfrete').autoNumeric('get'));
	if (isNaN(frete)) {
		frete = 0;
	}
	var total = prod - desc + frete;
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

  <?php if (!empty($model->codnegocio)): ?>
  verificarStatusNegocio();
  setInterval(function() {
    verificarStatusNegocio();
  }, 3.5 * 1000); // 60 * 1000 milse
  <?php endif; ?>

	$('#Negocio_percentualdesconto').change(function() {
		atualizaValorDesconto();
	});

	$('#Negocio_valordesconto').change(function() {
		atualizaPercentualDesconto();
	});

  $('#Negocio_valorfrete').change(function() {
		atualizaValorTotal();
	});

	$("#Negocio_observacoes").RemoveAcentos();

	$('#Negocio_valorprodutos').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.'});
	$('#Negocio_percentualdesconto').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.', mDec:'0', aSign: '%', pSign: 's' });
	// $('#Negocio_percentualdesconto').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.', aSign: '%', pSign: 's' });
	$('#Negocio_valordesconto').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.'});
  $('#Negocio_valorfrete').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.'});
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

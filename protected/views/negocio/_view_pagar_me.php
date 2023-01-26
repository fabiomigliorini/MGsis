<div class="bs-docs-example" style="margin-bottom: 10px">
    <div class="row-fluid">
        <?php
            echo CHtml::image(
                Yii::app()->baseUrl . '/images/pagar-me-logo.svg',
                '',
                array(
                    'style' => 'max-width: 120px',
                    'class'=> "logo-pagamento",
                )
            );
        ?>
        <div class="pull-right">
            <button class="btn" type="button" onclick="abrirModalPagarMe()" tabindex="-1">Novo (F7)</button>
            <button class="btn" type="button" onclick="atualizaListagemPagarMePedido()" tabindex="-1">Atualizar</button>
        </div>
    </div>
    <div class="row-fluid">
        <div id="listagemPagarMePedido">
            <?php
            $this->renderPartial('_view_pagar_me_listagem',
                array(
                    'model'=>$model,
                ));
            ?>
        </div>
    </div>
</div>
<div class="modal hide fade" id="modalPagarMe">
  <div class="modal-header">
        <?php
            echo CHtml::image(
                Yii::app()->baseUrl . '/images/pagar-me-logo.svg',
                '',
                array(
                    'style' => 'max-width: 120px',
                    'class'=>"",
                )
            );
        ?>
    </div>
    <div class="modal-body" id="modalPagarMeBody" tabindex="-1" style="padding-left: 5%; padding-right: 5%; padding-top: 0px">
        <div class="row-fluid">
            <div class="span6">
                <div style="margin-bottom: 20px">
                    <label for="pagarmeTipo"><b>Tipo</b></label>
                    <div>
                        <label class="radio pagar-me-enter labelPagarmeParcela">
                          <input type="radio" name="pagarmeTipo" id="pagarmeTipoDebito" value="1" checked>
                          Débito
                        </label>
                        <label class="radio pagar-me-enter labelPagarmeParcela">
                          <input type="radio" name="pagarmeTipo" id="pagarmeTipoCredito" value="2">
                          Crédito
                        </label>
                        <label class="radio pagar-me-enter labelPagarmeParcela">
                          <input type="radio" name="pagarmeTipo" id="pagarmeTipoCredito" value="3">
                          Voucher
                        </label>
                    </div>
                </div>
                <div style="margin-bottom: 20px; margin-right: 100px">
                    <label for="pagarMeValor"><b>Valor</b></label>
                    <input class="text-right input-valor pagar-me-enter" maxlength="14" name="pagarMeValor" id="pagarMeValor" type="text">
                </div>
                <div style="margin-bottom: 20px">
                    <label for="codpagarmepos"><b>Maquineta</b></label>
                    <div>
                        <?php foreach($model->Filial->PagarMePoss as $pos): ?>
                            <?php
                            if (!empty($pos->inativo)) {
                                continue;
                            }
                            ?>
                            <label class="radio pagar-me-enter labelPagarmeParcela">
                                <input type="radio" name="codpagarmepos" id="codpagarmepos" value="<?php echo $pos->codpagarmepos; ?>"  tabindex="-1">
                                <?php echo $model->Filial->filial ;?> -
                                <?php echo $pos->serial; ?> -
                                <?php echo $pos->apelido; ?>
                            </label>
                        <?php endforeach; ?>
                        <hr />
                    </div>
                </div>
            </div>
            <div class="span6">
                <label for="pagarmeParcelas"><b>Parcelas</b></label>
                <div>
                    <label class="radio pagar-me-enter labelPagarmeParcela">
                        <input type="radio" name="pagarmeParcelas" id="pagarmeParcelas1" value="1" checked>
                        <span id="pagarmeParcelasLabel1" class="spanPagarmeParcela">
                            1x
                        </span>
                    </label>
                    <label class="radio pagar-me-enter labelPagarmeParcela">
                        <input type="radio" name="pagarmeParcelas" id="pagarmeParcelas2" value="2">
                        <span id="pagarmeParcelasLabel2" class="spanPagarmeParcela">
                            2x
                        </span>
                    </label>
                    <label class="radio pagar-me-enter labelPagarmeParcela">
                        <input type="radio" name="pagarmeParcelas" id="pagarmeParcelas3" value="3" disabled>
                        <span id="pagarmeParcelasLabel3" class="spanPagarmeParcela">
                            3x
                        </span>
                    </label>
                    <label class="radio pagar-me-enter labelPagarmeParcela">
                        <input type="radio" name="pagarmeParcelas" id="pagarmeParcelas4" value="4" disabled>
                        <span id="pagarmeParcelasLabel4" class="spanPagarmeParcela">
                            4x
                        </span>
                    </label>
                    <label class="radio pagar-me-enter labelPagarmeParcela">
                        <input type="radio" name="pagarmeParcelas" id="pagarmeParcelas5" value="5" disabled>
                        <span id="pagarmeParcelasLabel5" class="spanPagarmeParcela">
                            5x
                        </span>
                    </label>
                    <label class="radio pagar-me-enter labelPagarmeParcela">
                        <input type="radio" name="pagarmeParcelas" id="pagarmeParcelas6" value="6" disabled>
                        <span id="pagarmeParcelasLabel6" class="spanPagarmeParcela">
                            6x
                        </span>
                    </label>
                    <label class="radio pagar-me-enter labelPagarmeParcela">
                        <input type="radio" name="pagarmeParcelas" id="pagarmeParcelas7" value="7" disabled>
                        <span id="pagarmeParcelasLabel7" class="spanPagarmeParcela">
                            7x
                        </span>
                    </label>
                    <label class="radio pagar-me-enter labelPagarmeParcela">
                        <input type="radio" name="pagarmeParcelas" id="pagarmeParcelas8" value="8" disabled>
                        <span id="pagarmeParcelasLabel8" class="spanPagarmeParcela">
                            8x
                        </span>
                    </label>
                    <label class="radio pagar-me-enter labelPagarmeParcela">
                        <input type="radio" name="pagarmeParcelas" id="pagarmeParcelas9" value="9" disabled>
                        <span id="pagarmeParcelasLabel9" class="spanPagarmeParcela">
                            9x
                        </span>
                    </label>
                    <label class="radio pagar-me-enter labelPagarmeParcela">
                        <input type="radio" name="pagarmeParcelas" id="pagarmeParcelas10" value="10" disabled>
                        <span id="pagarmeParcelasLabel10" class="spanPagarmeParcela">
                            10x
                        </span>
                    </label>
                    <label class="radio pagar-me-enter labelPagarmeParcela">
                        <input type="radio" name="pagarmeParcelas" id="pagarmeParcelas11" value="11" disabled>
                        <span id="pagarmeParcelasLabel11" class="spanPagarmeParcela">
                            11x
                        </span>
                    </label>
                    <label class="radio pagar-me-enter labelPagarmeParcela">
                        <input type="radio" name="pagarmeParcelas" id="pagarmeParcelas12" value="12" disabled>
                        <span id="pagarmeParcelasLabel12" class="spanPagarmeParcela">
                            12x
                        </span>
                    </label>
                    <label class="radio pagar-me-enter labelPagarmeParcela">
                        <input type="radio" name="pagarmeParcelas" id="pagarmeParcelas13" value="13" disabled>
                        <span id="pagarmeParcelasLabel13" class="spanPagarmeParcela">
                            13x
                        </span>
                    </label>
                    <label class="radio pagar-me-enter labelPagarmeParcela">
                        <input type="radio" name="pagarmeParcelas" id="pagarmeParcelas14" value="14" disabled>
                        <span id="pagarmeParcelasLabel14" class="spanPagarmeParcela">
                            14x
                        </span>
                    </label>
                    <label class="radio pagar-me-enter labelPagarmeParcela">
                        <input type="radio" name="pagarmeParcelas" id="pagarmeParcelas15" value="15" disabled>
                        <span id="pagarmeParcelasLabel15" class="spanPagarmeParcela">
                            15x
                        </span>
                    </label>
                    <label class="radio pagar-me-enter labelPagarmeParcela">
                        <input type="radio" name="pagarmeParcelas" id="pagarmeParcelas16" value="16" disabled>
                        <span id="pagarmeParcelasLabel16" class="spanPagarmeParcela">
                            16x
                        </span>
                    </label>
                    <label class="radio pagar-me-enter labelPagarmeParcela">
                        <input type="radio" name="pagarmeParcelas" id="pagarmeParcelas17" value="17" disabled>
                        <span id="pagarmeParcelasLabel17" class="spanPagarmeParcela">
                            17x
                        </span>
                    </label>
                    <label class="radio pagar-me-enter labelPagarmeParcela">
                        <input type="radio" name="pagarmeParcelas" id="pagarmeParcelas18" value="18" disabled>
                        <span id="pagarmeParcelasLabel18" class="spanPagarmeParcela">
                            18x
                        </span>
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
        <button class="btn btn-success" id="btnOkModalPagarMe">OK (F7)</button>
    </div>
</div>

<script>

<?php if (sizeof($model->PagarMePedidos) > 0): ?>
window.PagarMePedido = <?php echo json_encode($model->PagarMePedidos[0]->attributes) ?>;
<?php else: ?>
window.PagarMePedido = {};
<?php endif; ?>


function atualizaCamposPagarMePedido ()
{
    $('#PagarMePedidoCodPagarMePedido').html(PagarMePedido.codPagarMePedido);
    $('#PagarMePedidoStatus').html(PagarMePedido.status);
    $('#PagarMePedidoTxid').html(PagarMePedido.txid);
    if (PagarMePedido.valororiginal != undefined) {
        $('#PagarMePedidoValororiginal').html(PagarMePedido.valororiginal.toLocaleString('pt-br', {minimumFractionDigits: 2}));
    }
    if (PagarMePedido.Portador != undefined) {
        $('#PagarMePedidoPortador').html(PagarMePedido.Portador.portador);
    }
    $('#PagarMePedidoBrcode').html(PagarMePedido.brcode);
    $('#PagarMePedidoBrcodeTextArea').val(PagarMePedido.brcode);
    if (PagarMePedido.brcode != '' && PagarMePedido.brcode != null) {
        $('#PagarMePedidoQrcode').attr('src', 'https://gerarqrcodePagarMe.com.br/api/v1?tamanho=250&brcode=' + PagarMePedido.brcode);
    } else {
        $('#PagarMePedidoQrcode').attr('src', 'https://dummyimage.com/250x250/000000/fff.jpg&text=N%C3%A3o+Registrada!');
    }
}

window.rodandoPagarMePedido = false;

function consultarPagarMePedido (codPagarMePedido)
{
    if (window.rodandoPagarMePedido) {
        return
    }
    window.rodandoPagarMePedido = true;
    $.ajax({
        type: 'POST',
        url: "<?php echo MGSPA_API_URL; ?>pagar-me/pedido/"+codPagarMePedido+"/consultar",
        dataType: "json",
        headers: {
            "X-Requested-With":"XMLHttpRequest"
        },
    }).done(function(resp) {
        verificarStatusNegocio();
        atualizaListagemPagamentos();
        window.rodandoPagarMePedido = false;
        $.notify("Cobrança " + resp.pedido.idpedido + " Consultado! Valor pago: " + resp.pedido.valorpagoliquido, { position:"right bottom", className:"success", autoHideDelay: 15000 });
        atualizaListagemPagarMePedido();
    }).fail(function( jqxhr, textStatus, error ) {
        window.rodandoPagarMePedido = false;
        $.notify("Erro ao consultar cobrança "+ codPagarMePedido +"!", { position:"right bottom", className:"error", autoHideDelay: 15000 });
        atualizaListagemPagarMePedido();
        atualizaListagemPagamentos();
        var resp = jQuery.parseJSON(jqxhr.responseText);
        bootbox.alert(resp.message);
    });
}

function cancelarPagarMePedido (codPagarMePedido)
{
    if (window.rodandoPagarMePedido) {
        return
    }
    bootbox.hideAll();
    bootbox.confirm('Tem certeza que deseja cancelar?', function(result) {
        if (result)
        {
            window.rodandoPagarMePedido = true;
            $.ajax({
                type: 'DELETE',
                url: "<?php echo MGSPA_API_URL; ?>pagar-me/pedido/"+codPagarMePedido,
                dataType: "json",
                headers: {
                    "X-Requested-With":"XMLHttpRequest"
                },
            }).done(function(resp) {
                verificarStatusNegocio();
                window.rodandoPagarMePedido = false;
                $.notify("Cobrança Cancelada! Status: " + resp.pedido.status, { position:"right bottom", className:"success", autoHideDelay: 15000 });
                atualizaListagemPagarMePedido();
            }).fail(function( jqxhr, textStatus, error ) {
                window.rodandoPagarMePedido = false;
                $.notify("Falha ao cancelar cobrança!", { position:"right bottom", className:"error", autoHideDelay: 15000 });
                atualizaListagemPagarMePedido();
                var resp = jQuery.parseJSON(jqxhr.responseText);
                bootbox.alert(resp.message);
            });
        }
    });

}

function criarPagarMePedido()
{
    if (window.rodandoPagarMePedido) {
        return
    }
    var valor = parseFloat($('#pagarMeValor').autoNumeric('get'));
    var tipo = parseInt($("input:radio[name ='pagarmeTipo']:checked").val());
    var parcelas = parseInt($("input:radio[name ='pagarmeParcelas']:checked").val());
    var codpagarmepos = parseInt($("input:radio[name ='codpagarmepos']:checked").val());
    var valorJuros = parseFloat($('#pagarmeParcelas' + parcelas).attr('data-valor-juros'));
    var valorParcela = parseFloat($('#pagarmeParcelas' + parcelas).attr('data-valor-parcela'));

    if (isNaN(codpagarmepos)) {
        codpagarmepos = null;
        $.notify("Selecione a Maquineta!", { position:"right bottom", className:"error"});
        return;
    }
        if (isNaN(valor) || valor <= 0) {
        $.notify("Preencha o valor!", { position:"right bottom", className:"error"});
        return;
    }

    $('#modalPagarMe').modal('hide');

    window.rodandoPagarMePedido = true;
    var codpessoa = $('#Negocio_codpessoa').select2('val');
    var codfilial = $('#Negocio_codfilial').select2('val');

    $.ajax({
        type: 'POST',
        url: '<?php echo MGSPA_API_URL; ?>pagar-me/pedido',
        data: {
            codnegocio: <?php echo $model->codnegocio; ?>,
            codpessoa: codpessoa,
            codpagarmepos: codpagarmepos,
            valor: valor,
            valorparcela: valorParcela,
            valorjuros: valorJuros,
            tipo: tipo,
            parcelas: parcelas,
            jurosloja: 1,
            descricao: "Negocio <?php echo $model->codnegocio; ?>",
            codfilial: codfilial
        },
        dataType: 'json',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
    }).done(function(resp) {
        window.rodandoPagarMePedido = false;
        $.notify("Pre Transação PagarMe " + resp.token + " Criada!", { position:"right bottom", className:"success"});
        atualizaListagemPagarMePedido();
    }).fail(function( jqxhr, textStatus, error ) {
        window.rodandoConsultaPagarMePedido = false;
        $.notify("Erro ao Criar Cobrança via PagarMe!!", { position:"right bottom", className:"error"});
        atualizaListagemPagarMePedido();
        var resp = jQuery.parseJSON(jqxhr.responseText);
        bootbox.alert(resp.message);
    });
}

function atualizaListagemPagarMePedido()
{
    $.ajax({
        url: "<?php echo Yii::app()->createUrl('negocio/atualizalistagemPagarMePedido') ?>",
        data: {
            codnegocio: <?php echo $model->codnegocio; ?>
        },
        type: "GET",
        dataType: "html",
        async: false,
        success: function (data) {
            $('#listagemPagarMePedido').html(data);
        },
        error: function (xhr, status) {
            bootbox.alert("Erro ao atualizar listagem de cobranças PagarMe!");
        },
    });
}

function calcularParcelas()
{

    const valorMinimoParcela = 30.0;
    const taxa = 1.5;
    let valor = parseFloat($('#pagarMeValor').autoNumeric('get'));
    let tipo = parseInt($("input:radio[name ='pagarmeTipo']:checked").val());

    if (tipo !=  2) {
        $("input:radio[name ='pagarmeParcelas']:checked").attr('checked', false);
        $("#pagarmeParcelas1").attr('checked', true);
    }

    for (let i = 1; i <= 18; i++) {
        var text = '<b>' + i + '</b>' + ' vez';
        var valorJuros = 0;
        var valorParcela = Math.round(((valor + valorJuros)/i) * 100) / 100;
        if (i > 6) {
            valorJuros = Math.round(taxa * i * valor) / 100;
            valorParcela = Math.round(((valor + valorJuros)/i) * 100) / 100;
            valorJuros = (valorParcela * i) - valor;
        }
        if (i > 1) {
            text += 'es';
        }
        text += ' de ' + '<b>' + formataValor(valorParcela, 2) + '</b>';
        if (valorJuros > 0) {
            text += ' (C/Juros)';
        // } else if (i > 1) {
        //     text += ' sem juros';
        }
        $('#pagarmeParcelasLabel' + i).html(text);
        var habilitado = false;
        if (i == 1) {
            habilitado = true;
        } else if (tipo == 2 && valorParcela >= valorMinimoParcela) {
            habilitado = true;
        }
        $('#pagarmeParcelas' + i).attr('data-valor-juros', valorJuros);
        $('#pagarmeParcelas' + i).attr('data-valor-parcela', valorParcela);
        if (habilitado) {
            $('#pagarmeParcelas' + i).attr('disabled', false);
            $('#pagarmeParcelasLabel' + i).removeClass('muted');
        } else {
            $('#pagarmeParcelas' + i).attr('disabled', true);
            $('#pagarmeParcelasLabel' + i).addClass('muted');
        }
    }
}

function abrirModalPagarMe ()
{
    var valor = $('#valorpagamento').autoNumeric('get');
    $('#pagarMeValor').autoNumeric('set', valor);
    // $('#pagarmeTipo').val(1);
    $('#pagarmeParcelas').val(1);
    $('#modalPagarMe').modal({show:true, keyboard:true});

    $('#modalPagarMe').css({'width': '75%', 'height': '90%', 'margin-left':'auto', 'margin-right':'auto', 'left':'7.5%', 'top':'5%'});
    var height = $( window ).height();
    var bodyHeight = (height*.90)-140;
    $('#modalPagarMeBody').css({'height': bodyHeight, 'max-height': bodyHeight});

    calcularParcelas();
}

function acaoF7PagarMe ()
{
    if (!$('#modalPagarMe').hasClass('in')) {
        abrirModalPagarMe();
        return;
    }
    criarPagarMePedido();
}

function setCookie(cname, cvalue) {
  document.cookie = cname + "=" + cvalue + ";path=/";
}

function getCookie(cname) {
  var name = cname + "=";
  var ca = document.cookie.split(';');
  for(var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

$(document).ready(function() {

    $('.pagar-me-enter').keypress(function(e) {
        if (e.which == 13) {
            e.preventDefault();
            criarPagarMePedido();
        }
    });

    $('#pagarMeValor').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });

    $("input:radio[name='codpagarmepos']").change(function (){
        var codpagarmepos = parseInt($("input:radio[name ='codpagarmepos']:checked").val());
        setCookie('codpagarmepos', codpagarmepos);
    });

    $('#pagarMeValor').change(function(){
        calcularParcelas();
    });

    $("input:radio[name='pagarmeTipo']").change(function(){
        calcularParcelas();
    });

    var codpagarmepos = getCookie('codpagarmepos');
    $("input:radio[name='codpagarmepos'][value='"+ codpagarmepos +"']").attr('checked', true);

    $('#modalPagarMe').on('shown', function (e) {
        // $('#pagarMeValor').focus();
        $('#pagarmeTipoDebito').focus();
    });

    $('#modalPagarMe').on('hidden', function (e) {
        setTimeout(function() {
            $('.modal-backdrop').remove();
        }, 500); // meio segundo
    });

    $('#btnOkModalPagarMe').bind("click", function(e) {
        e.preventDefault();
        criarPagarMePedido();
    });

});

</script>

<?php $form=$this->beginWidget('MGActiveForm', array(
    'id'=>'pessoa-form',
)); ?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
	<?php
        echo $form->textFieldRow($model, 'fantasia', array('class'=>'input-large','maxlength'=>50));
        echo $form->textFieldRow($model, 'pessoa', array('class'=>'input-xxlarge','maxlength'=>100));
        echo $form->textFieldRow($model, 'contato', array('class'=>'input-large','maxlength'=>100));

        echo $form->select2CidadeRow($model, 'codcidade');

        //echo $form->checkBoxRow($model,'fisica');
        echo $form->toggleButtonRow($model, 'fisica', array('options' => array('width' => 150,  'enabledLabel' => 'Física', 'disabledLabel' => 'Jurídica')));

        if (!empty($model->cnpj)) {
            $model->cnpj = Yii::app()->format->formataCnpjCpf($model->cnpj, $model->fisica);
        }
        echo $form->maskedTextFieldRow($model, 'cnpj', ($model->fisica)?'999.999.999-99':'99.999.999/9999-99', array('class'=>'input-medium','maxlength'=>20));

        if (!empty($model->ie) && !empty($model->codcidade)) {
            $model->ie = Yii::app()->format->formataInscricaoEstadual($model->ie, $model->Cidade->Estado->sigla);
        }
        echo $form->textFieldRow($model, 'ie', array('class'=>'input-medium','maxlength'=>20));
    ?>
	<div class="bootstrap-widget bootstrap-widget-table" id="CamposPessoaFisica">
		<div class="bootstrap-widget-header">
			<h3>Dados Pessoa Física</h3>
		</div>
		<div class="bootstrap-widget-content">
			<br>
			<?php
                echo $form->textFieldRow($model, 'rg', array('class'=>'input-medium','maxlength'=>30));

                echo $form->dropDownListRow(
                    $model,
                    'codsexo',
                    Sexo::getListaCombo(),
                    array('prompt'=>'', 'class' => 'input-medium')
                );

                echo $form->dropDownListRow(
                    $model,
                    'codestadocivil',
                    EstadoCivil::getListaCombo(),
                    array('prompt'=>'', 'class' => 'input-medium')
                );

                echo $form->textFieldRow($model, 'conjuge', array('class'=>'input-xxlarge','maxlength'=>100));
            ?>
		</div>
	</div>

	<?php
        //echo $form->checkBoxRow($model,'cliente');
        echo $form->toggleButtonRow($model, 'cliente', array('options' => array('enabledLabel' => 'Sim', 'disabledLabel' => 'Não')));
    ?>
	<div class="bootstrap-widget bootstrap-widget-table" id="CamposCliente">
		<div class="bootstrap-widget-header">
			<h3>Dados Cliente</h3>
		</div>
		<div class="bootstrap-widget-content">
			<br>
			<?php

                //echo $form->checkBoxRow($model,'consumidor');
                echo $form->select2Row($model, 'codgrupocliente', GrupoCliente::getListaCombo(), array('class'=>'input-xlarge'));
                echo $form->toggleButtonRow($model, 'consumidor', array('options' => array('enabledLabel' => 'Sim', 'disabledLabel' => 'Não')));

                echo $form->dropDownListRow(
                    $model,
                    'codformapagamento',
                    FormaPagamento::getListaCombo(),
                    array('prompt'=>'', 'class' => 'input-xxlarge')
                );


                //echo $form->checkBoxRow($model,'creditobloqueado');
                echo $form->toggleButtonRow($model, 'creditobloqueado', array('options' => array('enabledLabel' => 'Sim', 'disabledLabel' => 'Não')));
                echo $form->textFieldRow($model, 'credito', array('prepend' => 'R$', 'class'=>'input-small text-right','maxlength'=>14));
                echo $form->textFieldRow($model, 'toleranciaatraso', array('append' => 'Dias', 'class'=>'input-mini text-right','maxlength'=>4));
                echo $form->textAreaRow($model, 'mensagemvenda', array('class'=>'input-xxlarge', 'rows'=>'5','maxlength'=>500));

                echo $form->textFieldRow($model, 'desconto', array('append' => '%', 'class'=>'input-small text-right','maxlength'=>5));

                echo $form->dropDownListRow(
                    $model,
                    'notafiscal',
                    Pessoa::getNotaFiscalOpcoes(),
                    array('prompt'=>'', 'class' => 'input-large')
                );
            ?>
		</div>
	</div>
	<?php
        echo $form->maskedTextFieldRow($model, 'cep', '99.999-999', array('class'=>'input-small','maxlength'=>10, 'append'=>'<div id="btnConsultaCep" style="cursor: pointer; cursor: hand;"><i class="icon-search"></i> Consultar </div>'));

        echo $form->textFieldRow($model, 'endereco', array('class'=>'input-xxlarge','maxlength'=>100));
        echo $form->textFieldRow($model, 'numero', array('class'=>'input-mini','maxlength'=>10));
        echo $form->textFieldRow($model, 'complemento', array('class'=>'input-medium','maxlength'=>50));
        echo $form->textFieldRow($model, 'bairro', array('class'=>'input-medium','maxlength'=>50));

        //echo $form->checkBoxRow($model, "cobrancanomesmoendereco");
        echo $form->toggleButtonRow($model, "cobrancanomesmoendereco", array('options' => array('enabledLabel' => 'Sim', 'disabledLabel' => 'Não')));
    ?>
	<div class="bootstrap-widget bootstrap-widget-table" id="CamposEnderecoCobranca">
		<div class="bootstrap-widget-header">
			<h3>Endereço de Cobrança</h3>
		</div>
		<div class="bootstrap-widget-content">
			<br>
			<?php

                echo $form->maskedTextFieldRow($model, 'cepcobranca', '99.999-999', array('class'=>'input-small','maxlength'=>10, 'append'=>'<div id="btnConsultaCepCobranca" style="cursor: pointer; cursor: hand;"><i class="icon-search"></i> Consultar </div>'));
                echo $form->textFieldRow($model, 'enderecocobranca', array('class'=>'input-xxlarge','maxlength'=>100));
                echo $form->textFieldRow($model, 'numerocobranca', array('class'=>'input-mini','maxlength'=>10));
                echo $form->textFieldRow($model, 'complementocobranca', array('class'=>'input-medium','maxlength'=>50));
                echo $form->textFieldRow($model, 'bairrocobranca', array('class'=>'input-medium','maxlength'=>50));
                echo $form->select2CidadeRow($model, 'codcidadecobranca');

            ?>
		</div>
	</div>
	<?php

        echo $form->textFieldRow($model, 'telefone1', array('class'=>'input-medium','maxlength'=>50));
        echo $form->textFieldRow($model, 'telefone2', array('class'=>'input-medium','maxlength'=>50));
        echo $form->textFieldRow($model, 'telefone3', array('class'=>'input-medium','maxlength'=>50));

        echo $form->textFieldRow($model, 'email', array('class'=>'input-large','maxlength'=>100, 'prepend' => '<i class="icon-envelope"></i>'));
        echo $form->textFieldRow($model, 'emailnfe', array('class'=>'input-large','maxlength'=>100, 'prepend' => '<i class="icon-envelope"></i>'));
        echo $form->textFieldRow($model, 'emailcobranca', array('class'=>'input-large','maxlength'=>100, 'prepend' => '<i class="icon-envelope"></i>'));

        echo $form->textAreaRow($model, 'observacoes', array('class'=>'input-xxlarge', 'rows'=>'5','maxlength'=>255));

        //echo $form->checkBoxRow($model,'fornecedor');
        echo $form->toggleButtonRow($model, 'fornecedor', array('options' => array('enabledLabel' => 'Sim', 'disabledLabel' => 'Não')));
        //echo $form->checkBoxRow($model,'vendedor');
        echo $form->toggleButtonRow($model, 'vendedor', array('options' => array('enabledLabel' => 'Sim', 'disabledLabel' => 'Não')));

        echo $form->datepickerRow(
            $model,
            'inativo',
            array(
                    'class' => 'input-small text-center',
                    'options' => array(
                        'language' => 'pt',
                        'format' => 'dd/mm/yyyy'
                        ),
                    'prepend' => '<i class="icon-calendar"></i>',
                    )
        );


        /*
         *
         */
    ?>
</fieldset>
<div class="form-actions">
	
    <?php
        $this->widget(
        'bootstrap.widgets.TbButton',
        array(
                'buttonType' => 'submit',
                'type' => 'primary',
                'label' => 'Salvar',
                'icon' => 'icon-ok',
                )
    );
    ?>

</div>

<?php $this->endWidget(); ?>

<script type='text/javascript'>

function escondeCamposEnderecoCobranca()
{
	if($('#Pessoa_cobrancanomesmoendereco').is(':checked')==true)
		$('#CamposEnderecoCobranca').slideUp('slow');
	else
		$('#CamposEnderecoCobranca').slideDown('slow');
}


function escondeCamposCliente()
{
	if($('#Pessoa_cliente').is(':checked')==true)
		$('#CamposCliente').slideDown('slow');
	else
		$('#CamposCliente').slideUp('slow');
}

function alteraEndereco(cobranca, endereco, bairro, cidade, uf)
{
	var campoEndereco = "#Pessoa_endereco";
	var campoBairro = "#Pessoa_bairro";
	var campoCodCidade = "#Pessoa_codcidade";
	if (cobranca) {
		campoEndereco = "#Pessoa_enderecocobranca";
		campoBairro = "#Pessoa_bairrocobranca";
		campoCodCidade = "#Pessoa_codcidadecobranca";
	}

	//Joga foco para forcar blur() - Setcase e removeacentos
	$(campoEndereco).val(endereco);
	$(campoEndereco).focus();
	$(campoEndereco).focus();

	//Joga foco para forcar blur() - Setcase e removeacentos
	$(campoBairro).val(bairro);
	$(campoBairro).focus();
	$(campoBairro).focus();

	//Joga foco
	$(campoEndereco).focus();
	$(campoEndereco).focus();

	$.ajax({
		url: "<?php echo Yii::app()->createUrl('cidade/ajaxbuscapelonome') ?>&cidade="+escape(cidade)+"&uf="+escape(uf),
		//force to handle it as text
		dataType: "text",
		success: function(data) {

			var retorno = $.parseJSON(data);
			var alterar = false;
			var codcidadepreenchido = $(campoCodCidade).val();

			if (retorno.codcidade == null) {
				alterar = false;
			} else if (codcidadepreenchido == "") {
				alterar = true;
			}else if (retorno.codcidade != codcidadepreenchido) {
				alterar = true;
				if (!cobranca)
					bootbox.alert("De acordo com o cep digitado, a Cidade foi alterada para: <br><br> <b>" + cidade + "/" + uf + "</b><br><br> Diferente da cidade que havia sido selecionado!");
			}
			if (alterar) {
				$(campoCodCidade).select2("data", {id: retorno.codcidade, cidade: unescape(cidade), uf:unescape(uf)});
			}
		}
	});
	$.notify("Endereço alterado!", "success");

}

function consultaCep(cobranca)
{
	var campo = "#Pessoa_cep";
	if (cobranca)
		campo = "#Pessoa_cepcobranca";

	$.ytLoad('destroy');
	$.ytLoad({registerAjaxHandlers: false});
	$.ytLoad('start');

	if($.trim($(campo).val()) != ""){
		$.notify("Consultando Cep!", "info");
		var cep = $(campo).val();
		cep = cep.replace(/\D/g, '');
		// console.log(cep);

		// $.getScript("http://cep.republicavirtual.com.br/web_cep.php?formato=javascript&cep="+$(campo).val(), function(){
		// $.getScript("https://viacep.com.br/ws/" + cep + "/json/", function(resp){
		$.getJSON("https://viacep.com.br/ws/" + cep + "/json/", { } )
		  .done(function( data ) {
				// console.log(data);
				if(data.erro){
					bootbox.alert("Cep Inválido!");
					$.notify("Cep Inválido!", "error");
				} else {
					$.notify("Consulta de cep ok!", "success");
					var logradouro = data.logradouro;
					var complemento = data.complemento;
					var bairro = data.bairro;
					var cidade = data.localidade;
					var uf = data.uf;
					bootbox.confirm("Alterar para o endereço abaixo? <br><br> <b>" + unescape(logradouro) + " - " + unescape(complemento) + " - " + unescape(bairro) + " - " + unescape(cidade) + "/" + unescape(uf) + "</b>", function(result) {
						if (result)
							alteraEndereco(
								cobranca,
								logradouro,
								bairro,
								cidade,
								uf
							)
						else
							$.notify("Consulta de cep ignorada!", "info");
					});
					$.ytLoad('complete');
					$.ytLoad('destroy');
				}
		  })
		  .fail(function( jqxhr, textStatus, error ) {
				bootbox.alert("Erro ao contactar o webservice!");
				$.notify("Erro ao contactar o webservice!", "error");
				$.ytLoad('complete');
				$.ytLoad('destroy');
		});
	}
}


function escondeCamposPessoaFisica()
{
	var mascara;
	if($('#Pessoa_fisica').is(':checked')==true)
	{
		$('#CamposPessoaFisica').slideDown('slow');
		mascara="999.999.999-99";
	}
	else
	{
		$('#CamposPessoaFisica').slideUp('slow');
		mascara="99.999.999/9999-99";
	}
	$("#Pessoa_cnpj").mask(mascara);
}

$(document).ready(function() {

  escondeCamposPessoaFisica();
	escondeCamposCliente();
	escondeCamposEnderecoCobranca();

	$("#Pessoa_fantasia").Setcase();
	$("#Pessoa_pessoa").Setcase();
	$("#Pessoa_contato").Setcase();
	$("#Pessoa_conjuge").Setcase();

	$("#Pessoa_endereco").Setcase();
	$("#Pessoa_numero").Setcase();
	$("#Pessoa_complemento").Setcase();
	$("#Pessoa_bairro").Setcase();

	$("#Pessoa_enderecocobranca").Setcase();
	$("#Pessoa_numerocobranca").Setcase();
	$("#Pessoa_complementocobranca").Setcase();
	$("#Pessoa_bairrocobranca").Setcase();

	$('#Pessoa_credito').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#Pessoa_toleranciaatraso').autoNumeric('init', {aSep:'', aDec:',', altDec:'.', mDec:0 });
	$('#Pessoa_desconto').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });

	$('#Pessoa_cobrancanomesmoendereco').change(function() { escondeCamposEnderecoCobranca(); });

	$('#Pessoa_fisica').change(function() {	escondeCamposPessoaFisica(); });

	$('#Pessoa_cliente').change(function() { escondeCamposCliente(); });

	$(":reset").on("click", function(){
		escondeCamposPessoaFisica();
		escondeCamposCliente();
		escondeCamposEnderecoCobranca();
	});

	$("#btnConsultaCep").click(function(e){ consultaCep (false); })
  $("#btnConsultaCepCobranca").click(function(e){ consultaCep (true); })

	$('#pessoa-form').submit(function(e) {
        var currentForm = this;
        e.preventDefault();
        bootbox.confirm("Tem certeza que deseja salvar?", function(result) {
            if (result) {
                currentForm.submit();
            }
        });
    });

});

</script>

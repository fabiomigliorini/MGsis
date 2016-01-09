<?php

/**
 * @var NfeTerceiro $model
 */
$this->pagetitle = Yii::app()->name . ' - Pesquisar na Sefaz NFe de Terceiros';
$this->breadcrumbs=array(
	'NFe de Terceiros'=>array('index'),
	'Pesquisar na Sefaz',
);

$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
	//array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	//array('label'=>'Detalhes', 'icon'=>'icon-eye-open', 'url'=>array('view','id'=>$model->codnfeterceiro)),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);
?>


<div class="hero-unit" style="display:none" id="divCarregando">
	<h1>Aguarde... Consultando SEFAZ...</h1>
</div>

<div id="divFormulario">
	
<h1>Pesquisar na Sefaz NFe de Terceiros</h1>
<br>

<?php 

	$form=$this->beginWidget('MGActiveForm',array(
		'id'=>'nfe-terceiro-form',
		'enableAjaxValidation'=>false,
		'enableClientValidation'=>false,	
	)); 

?>

<?php
	echo $form->select2Row($model,'codfilial', Filial::model()->getListaCombo() , array('class'=>'input-medium'));
	echo $form->textFieldRow($model,'nsu',array('class'=>'input-medium text-right'));
?>
<div class="form-actions">
<?php 
	$this->widget(
		'bootstrap.widgets.TbButton',
		array(
			'buttonType' => 'submit',
			'id' => 'btnPesquisar',
			'type' => 'primary',
			'label' => 'Pesquisar',
			'icon' => 'icon-ok',
			)
		);
	
	
?>
</div>
	
</div>

<div id="divImportadas">
	
</div>

<div id="divResultado">
	
</div>

<?php $this->endWidget(); ?>

<?php 

	//busca o ultimo nsu das filiais
	$command = Yii::app()->db->createCommand('SELECT codfilial, ultimonsu FROM tblfilial');
	$nsus = $command->queryAll();
	$arrNsu = array();
	foreach ($nsus as $nsu)
		$arrNsu[$nsu["codfilial"]] = $nsu["ultimonsu"];
	
	if (!empty($model->codfilial) && !empty($model->nsu))
		$arrNsu[$model->codfilial] = $model->nsu;

	//converte pra json para passar pro JS
	$nsu = json_encode($arrNsu);

?>

<script type='text/javascript'>
	
$(document).ready(function() {

    var arrNsu = <?php echo $nsu; ?>;
	
	$('#NfeTerceiro_codfilial').change(function () {
		var codfilial = $('#NfeTerceiro_codfilial').select2('val');
		var nsu = arrNsu[codfilial];
		$('#NfeTerceiro_nsu').val(nsu);
	});
	
	function adicionaNotaImportada(codfilial, chave, codnfeterceiro)
	{
		var html = '';
		
		html += codfilial + ' - ';
		html += '<a href="<?php echo Yii::app()->createUrl('NfeTerceiro/view')?>&id=' + codnfeterceiro + '">';
		html += chave;
		html += '</a><br>';
		
		$('#divImportadas').append(html);
	}
	
	function sefazDistDFe(codfilial, nsu)
	{
		$.getJSON("<?php echo Yii::app()->createUrl('NFePHPNovo/sefazDistDFe')?>", { 
			codfilial: codfilial,
			nsu: nsu,
		})
			.done(function(data) {
				$('#NfeTerceiro_nsu').val(data.ultNSU);
				arrNsu[codfilial] = data.ultNSU;
				var i = 0;
				$.each(data.importadas, function( chave, codnfeterceiro ) {
					adicionaNotaImportada(codfilial, chave, codnfeterceiro);
					i++;
				});
				if (data.ultNSU < data.maxNSU)
					sefazDistDFe(codfilial, data.ultNSU)
				else
				{
					$('#divFormulario').fadeIn('slow');
					$('#divCarregando').fadeOut('slow');
				}
				$('#divResultado').append(
					'<h4>Consulta Filial ' + 
					codfilial + 
					' executada até NSU ' + 
					data.ultNSU + 
					' - Importadas ' + 
					i + 
					' Chaves</h4>'
				);
				//$('#divResultado').append('<pre>' + JSON.stringify(data, null, '\t') + '</pre>');
			})
			.fail(function( jqxhr, textStatus, error ) {
				$('#divResultado').append('<pre>' + error + '</pre><br>');
			});
	}
	
	

	$('#nfe-terceiro-form').submit(function(e) {
        var currentForm = this;
        e.preventDefault();
        bootbox.confirm("Tem certeza que deseja executar a consulta?", function(result) {
            if (result) {
				var nsu = $('#NfeTerceiro_nsu').val();
				var codfilial = $('#NfeTerceiro_codfilial').val();
				sefazDistDFe(codfilial, nsu);
				//bootbox.alert("Fazendo consulta na Sefaz, aguarde esta operação pode <b>demorar alguns minutos</b>...");
                //currentForm.submit();
				$('#divResultado').html('');
				$('#divFormulario').fadeOut('slow');
				$('#divCarregando').fadeIn('slow');
            }
        });
    });
	
});

</script>

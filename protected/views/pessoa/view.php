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
);

Yii::app()->clientScript->registerCoreScript('yii');

?>

<script type="text/javascript">
/*<![CDATA[*/
$(document).ready(function(){
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
<br>

<?php if (!empty($model->inativo)): ?>
	<div class="alert alert-danger">
		<b>Inativado em <?php echo CHtml::encode($model->inativo); ?> </b>
	</div>
<?php endif; ?>

<?php 

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
			'name'=>'endereco',
			'value'=>Yii::app()->format->formataEndereco($model->endereco, $model->numero, $model->complemento, $model->bairro, $model->Cidade->cidade, $model->Cidade->Estado->sigla, $model->cep),
			'type'=>'raw'
			),
		array(
			'name'=>'enderecocobranca',
			'value'=>Yii::app()->format->formataEndereco($model->enderecocobranca, $model->numerocobranca, $model->complementocobranca, $model->bairrocobranca, $model->CidadeCobranca->cidade, $model->CidadeCobranca->Estado->sigla, $model->cepcobranca),
			'type'=>'raw'
			),
		array(
			'name'=>'email',
			'value'=>(isset($model->email))?CHtml::link($model->email, 'mailto:'.$model->email):null,
			'type'=>'raw',                 
			),
		array(
			'name'=>'emailnfe',
			'value'=>(isset($model->emailnfe))?CHtml::link($model->emailnfe, 'mailto:'.$model->emailnfe):null,
			'type'=>'raw',                 
			),
		array(
			'name'=>'emailcobranca',
			'value'=>(isset($model->emailcobranca))?CHtml::link($model->emailcobranca, 'mailto:'.$model->emailcobranca):null,
			'type'=>'raw',                 
			),
	);

if ($model->cliente) 
{
	$attributes = array_merge($attributes, 
		array(
			array(
				'name'=>'cliente',
				'value'=>($model->cliente)?'Sim':'Não',
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
			'credito',
			array(
				'name'=>'mensagemvenda',
				'value'=>(isset($model->mensagemvenda))?nl2br($model->mensagemvenda):null,
				'type'=>'raw',                 
				),
		));
	
}

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
			'value'=>($model->cliente)?'Sim':'Não',
			),
		'cadastro',
		));

$this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>$attributes)); 

	$this->widget('UsuarioCriacao', array('model'=>$model));

?>
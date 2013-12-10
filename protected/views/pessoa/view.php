<?php
$this->pagetitle = Yii::app()->name . ' - Detalhes Pessoas';
$this->breadcrumbs=array(
	'Pessoas'=>array('index'),
	CHtml::encode(Yii::app()->format->formataCodigo($model->codpessoa)),
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
array('label'=>'Alterar', 'icon'=>'icon-pencil', 'url'=>array('update','id'=>$model->codpessoa)),
array('label'=>'Excluir', 'icon'=>'icon-trash', 'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->codpessoa),'confirm'=>'Tem Certeza que deseja excluir este item?')),
);
?>

<h1>Detalhes Pessoa <?php echo CHtml::encode(Yii::app()->format->formataCodigo($model->codpessoa)); ?></h1>

<?php if (!empty($model->inativo)): ?>
	<span class="span12 label label-warning">
		<center>
		Inativado em 
		<?php echo CHtml::encode($model->inativo); ?> 
		</center>
	</span>
	<br>
	<br>
<?php endif; ?>

<?php 

$attributes = 
	array(
		'fantasia',
		'pessoa',
		array(
			'name'=>'telefone1',
			'value'=>"{$model->telefone1} {$model->telefone2} {$model->telefone3}",
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
			),
		array(
			'name'=>'enderecocobranca',
			'value'=>Yii::app()->format->formataEndereco($model->enderecocobranca, $model->numerocobranca, $model->complementocobranca, $model->bairrocobranca, $model->CidadeCobranca->cidade, $model->CidadeCobranca->Estado->sigla, $model->cepcobranca),
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

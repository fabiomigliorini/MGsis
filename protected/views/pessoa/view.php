<?php
$this->pagetitle = Yii::app()->name . ' - Detalhes Pessoas';
$this->breadcrumbs=array(
	'Pessoas'=>array('index'),
	$model->codpessoa,
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
array('label'=>'Alterar', 'icon'=>'icon-pencil', 'url'=>array('update','id'=>$model->codpessoa)),
array('label'=>'Excluir', 'icon'=>'icon-trash', 'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->codpessoa),'confirm'=>'Tem Certeza que deseja excluir este item?')),
array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);
?>

<h1>Detalhes Pessoa #<?php echo $model->codpessoa; ?></h1>

<?php 
$this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
			'codpessoa',
		'pessoa',
		'fantasia',
		'cadastro',
		'inativo',
		'cliente',
		'fornecedor',
		'fisica',
		'codsexo',
		'cnpj',
		'ie',
		'consumidor',
		'contato',
		'codestadocivil',
		'conjuge',
		'endereco',
		'numero',
		'complemento',
		'codcidade',
		'bairro',
		'cep',
		'enderecocobranca',
		'numerocobranca',
		'complementocobranca',
		'codcidadecobranca',
		'bairrocobranca',
		'cepcobranca',
		'telefone1',
		'telefone2',
		'telefone3',
		'email',
		'emailnfe',
		'emailcobranca',
		'codformapagamento',
		'credito',
		'creditobloqueado',
		'observacoes',
		'mensagemvenda',
		'vendedor',
		'rg',
		'desconto',
		'notafiscal',
		),
	)); 

	$this->widget('UsuarioCriacao', array('model'=>$model));

?>

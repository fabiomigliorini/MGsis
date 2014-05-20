<?php

/**
 * This is the model class for table "mgsis.tblusuario".
 *
 * The followings are the available columns in table 'mgsis.tblusuario':
 * @property string $codusuario
 * @property string $usuario
 * @property string $senha
 * @property string $codecf
 * @property string $codfilial
 * @property string $codoperacao
 * @property string $codpessoa
 * @property string $impressoratelanegocio
 * @property string $impressoramatricial
 * @property string $codportador
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property Movimentotitulo[] $movimentotitulos
 * @property Movimentotitulo[] $movimentotitulos1
 * @property Titulo[] $titulos
 * @property Titulo[] $titulos1
 * @property Filial[] $filials
 * @property Filial[] $filials1
 * @property Filial[] $filials2
 * @property Portador[] $portadors
 * @property Portador[] $portadors1
 * @property Ecf $codecf
 * @property Filial $codfilial
 * @property Operacao $codoperacao
 * @property Pessoa $codpessoa
 * @property Portador $codportador
 * @property Usuario $UsuarioAlteracao
 * @property Usuario[] $usuarios
 * @property Usuario $UsuarioCriacao
 * @property Usuario[] $usuarios1
 * @property Empresa[] $empresas
 * @property Empresa[] $empresas1
 * @property Boletoretorno[] $boletoretornos
 * @property Boletoretorno[] $boletoretornos1
 * @property Cobranca[] $cobrancas
 * @property Cobranca[] $cobrancas1
 * @property Tipomovimentotitulo[] $tipomovimentotitulos
 * @property Tipomovimentotitulo[] $tipomovimentotitulos1
 * @property Liquidacaotitulo[] $liquidacaotitulos
 * @property Liquidacaotitulo[] $liquidacaotitulos1
 * @property Liquidacaotitulo[] $liquidacaotitulos2
 * @property Liquidacaotitulo[] $liquidacaotitulos3
 * @property Tituloagrupamento[] $tituloagrupamentos
 * @property Tituloagrupamento[] $tituloagrupamentos1
 * @property Pessoa[] $pessoas
 * @property Pessoa[] $pessoas1
 * @property Pais[] $paises
 * @property Pais[] $paises1
 * @property Notafiscalprodutobarra[] $notafiscalprodutobarras
 * @property Notafiscalprodutobarra[] $notafiscalprodutobarras1
 * @property Cupomfiscalprodutobarra[] $cupomfiscalprodutobarras
 * @property Cupomfiscalprodutobarra[] $cupomfiscalprodutobarras1
 * @property Estoquemovimentotipo[] $estoquemovimentotipos
 * @property Estoquemovimentotipo[] $estoquemovimentotipos1
 * @property Estoquemovimento[] $estoquemovimentos
 * @property Estoquemovimento[] $estoquemovimentos1
 * @property Produtobarra[] $produtobarras
 * @property Produtobarra[] $produtobarras1
 * @property Produto[] $produtos
 * @property Produto[] $produtos1
 * @property Estado[] $estados
 * @property Estado[] $estados1
 * @property Cupomfiscal[] $cupomfiscals
 * @property Cupomfiscal[] $cupomfiscals1
 * @property Ecf[] $ecfs
 * @property Ecf[] $ecfs1
 * @property Ecf[] $ecfs2
 * @property Ecfreducaoz[] $ecfreducaozs
 * @property Ecfreducaoz[] $ecfreducaozs1
 * @property Cidade[] $cidades
 * @property Cidade[] $cidades1
 * @property Chequeemitente[] $chequeemitentes
 * @property Chequeemitente[] $chequeemitentes1
 * @property Banco[] $bancos
 * @property Banco[] $bancos1
 * @property Cheque[] $cheques
 * @property Cheque[] $cheques1
 * @property Cobrancahistorico[] $cobrancahistoricos
 * @property Cobrancahistorico[] $cobrancahistoricos1
 * @property Cobrancahistorico[] $cobrancahistoricos2
 * @property Cobrancahistoricotitulo[] $cobrancahistoricotitulos
 * @property Cobrancahistoricotitulo[] $cobrancahistoricotitulos1
 * @property Operacao[] $operacaos
 * @property Operacao[] $operacaos1
 * @property Tipotitulo[] $tipotitulos
 * @property Tipotitulo[] $tipotitulos1
 * @property Cfop[] $cfops
 * @property Cfop[] $cfops1
 * @property Notafiscalcartacorrecao[] $notafiscalcartacorrecaos
 * @property Notafiscalcartacorrecao[] $notafiscalcartacorrecaos1
 * @property Notafiscalduplicatas[] $notafiscalduplicatases
 * @property Notafiscalduplicatas[] $notafiscalduplicatases1
 * @property Produtoembalagem[] $produtoembalagems
 * @property Produtoembalagem[] $produtoembalagems1
 * @property Estadocivil[] $estadocivils
 * @property Estadocivil[] $estadocivils1
 * @property Sexo[] $sexos
 * @property Sexo[] $sexos1
 * @property Estoquemovimento2012[] $estoquemovimento2012s
 * @property Estoquemovimento2012[] $estoquemovimento2012s1
 * @property Naturezaoperacao[] $naturezaoperacaos
 * @property Naturezaoperacao[] $naturezaoperacaos1
 * @property Ncm[] $ncms
 * @property Ncm[] $ncms1
 * @property Parametrosgerais[] $parametrosgeraises
 * @property Parametrosgerais[] $parametrosgeraises1
 * @property Tipoproduto[] $tipoprodutos
 * @property Tipoproduto[] $tipoprodutos1
 * @property Tributacaonaturezaoperacao[] $tributacaonaturezaoperacaos
 * @property Tributacaonaturezaoperacao[] $tributacaonaturezaoperacaos1
 * @property Unidademedida[] $unidademedidas
 * @property Unidademedida[] $unidademedidas1
 * @property Contacontabil[] $contacontabils
 * @property Contacontabil[] $contacontabils1
 * @property Negocio[] $negocios
 * @property Negocio[] $negocios1
 * @property Negocio[] $negocios2
 * @property Negocio[] $negocios3
 * @property Negocioformapagamento[] $negocioformapagamentos
 * @property Negocioformapagamento[] $negocioformapagamentos1
 * @property Negociostatus[] $negociostatuses
 * @property Negociostatus[] $negociostatuses1
 * @property Negocioprodutobarra[] $negocioprodutobarras
 * @property Negocioprodutobarra[] $negocioprodutobarras1
 * @property Menu[] $menus
 * @property Menu[] $menus1
 * @property Tributacao[] $tributacaos
 * @property Tributacao[] $tributacaos1
 * @property Notafiscal[] $notafiscals
 * @property Notafiscal[] $notafiscals1
 * @property Boletomotivoocorrencia[] $boletomotivoocorrencias
 * @property Boletomotivoocorrencia[] $boletomotivoocorrencias1
 * @property Estoquesaldo[] $estoquesaldos
 * @property Estoquesaldo[] $estoquesaldos1
 * @property Formapagamento[] $formapagamentos
 * @property Formapagamento[] $formapagamentos1
 * @property Ibptax[] $ibptaxes
 * @property Ibptax[] $ibptaxes1
 * @property Marca[] $marcas
 * @property Marca[] $marcas1
 * @property Grupoproduto[] $grupoprodutos
 * @property Grupoproduto[] $grupoprodutos1
 * @property Codigo[] $codigos
 * @property Codigo[] $codigos1
 * @property Boletotipoocorrencia[] $boletotipoocorrencias
 * @property Boletotipoocorrencia[] $boletotipoocorrencias1
 * @property Baseremota[] $baseremotas
 * @property Baseremota[] $baseremotas1
 * @property Subgrupoproduto[] $subgrupoprodutos
 * @property Subgrupoproduto[] $subgrupoprodutos1
 * @property Produtohistoricopreco[] $produtohistoricoprecos
 * @property Produtohistoricopreco[] $produtohistoricoprecos1
 * @property Produtohistoricopreco[] $produtohistoricoprecos2
 */
class Usuario extends MGActiveRecord
{
	
	public $senha_tela;
	public $senha_tela_repeat;
	
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblusuario';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('usuario, codoperacao', 'required'),
			array('usuario', 'length', 'max'=>50),
			array('usuario', 'length', 'min'=>4),
			array('usuario', 'unique', 'caseSensitive' => false),

			array('senha, senha_tela, impressoramatricial', 'length', 'max'=>100),
			
			array('senha_tela', 'length', 'max'=>20),
			array('senha_tela', 'length', 'min'=>6),
			array('senha_tela', 'required', 'on'=>'insert'),
			array('senha_tela_repeat', 'compare', 'compareAttribute'=>'senha_tela'),
			
			array('codecf, codfilial, codpessoa, codportador, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			
			array('senha, codecf, codfilial, codpessoa, impressoramatricial, codportador', 'default', 'setOnEmpty' => true, 'value' => null),

			array('codecf', 'exist', 'className'=>'Ecf'),
			array('codfilial', 'exist', 'className'=>'Filial'),
			array('codoperacao', 'exist', 'className'=>'Operacao'),
            array('codpessoa', 'exist', 'className'=>'Pessoa'),
            array('codportador', 'exist', 'className'=>'Portador'),
			array('inativo', 'date', 'format'=>Yii::app()->locale->getDateFormat('medium')),
			
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codusuario', 'numerical', 'on'=>'search'),
			array('codusuario, usuario, codecf, codfilial, codoperacao, codportador, impressoramatricial', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'Ecf' => array(self::BELONGS_TO, 'Ecf', 'codecf'),
			'Filial' => array(self::BELONGS_TO, 'Filial', 'codfilial'),
			'Operacao' => array(self::BELONGS_TO, 'Operacao', 'codoperacao'),
			'Pessoa' => array(self::BELONGS_TO, 'Pessoa', 'codpessoa'),
			'Portador' => array(self::BELONGS_TO, 'Portador', 'codportador'),
			'UsuarioCriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
			'UsuarioAlteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
			
			/*
			'MovimentoTituloAlteracaos' => array(self::HAS_MANY, 'Movimentotitulo', 'codusuarioalteracao'),
			'MovimentoTituloCriacaos' => array(self::HAS_MANY, 'Movimentotitulo', 'codusuariocriacao'),
			'titulos' => array(self::HAS_MANY, 'Titulo', 'codusuarioalteracao'),
			'titulos1' => array(self::HAS_MANY, 'Titulo', 'codusuariocriacao'),
			'filials' => array(self::HAS_MANY, 'Filial', 'acbrnfemonitorcodusuario'),
			'filials1' => array(self::HAS_MANY, 'Filial', 'codusuarioalteracao'),
			'filials2' => array(self::HAS_MANY, 'Filial', 'codusuariocriacao'),
			'portadors' => array(self::HAS_MANY, 'Portador', 'codusuarioalteracao'),
			'portadors1' => array(self::HAS_MANY, 'Portador', 'codusuariocriacao'),
			'usuarios' => array(self::HAS_MANY, 'Usuario', 'codusuarioalteracao'),
			'usuarios1' => array(self::HAS_MANY, 'Usuario', 'codusuariocriacao'),
			'empresas' => array(self::HAS_MANY, 'Empresa', 'codusuarioalteracao'),
			'empresas1' => array(self::HAS_MANY, 'Empresa', 'codusuariocriacao'),
			'boletoretornos' => array(self::HAS_MANY, 'Boletoretorno', 'codusuarioalteracao'),
			'boletoretornos1' => array(self::HAS_MANY, 'Boletoretorno', 'codusuariocriacao'),
			'cobrancas' => array(self::HAS_MANY, 'Cobranca', 'codusuarioalteracao'),
			'cobrancas1' => array(self::HAS_MANY, 'Cobranca', 'codusuariocriacao'),
			'tipomovimentotitulos' => array(self::HAS_MANY, 'Tipomovimentotitulo', 'codusuarioalteracao'),
			'tipomovimentotitulos1' => array(self::HAS_MANY, 'Tipomovimentotitulo', 'codusuariocriacao'),
			'liquidacaotitulos' => array(self::HAS_MANY, 'Liquidacaotitulo', 'codusuario'),
			'liquidacaotitulos1' => array(self::HAS_MANY, 'Liquidacaotitulo', 'codusuarioestorno'),
			'liquidacaotitulos2' => array(self::HAS_MANY, 'Liquidacaotitulo', 'codusuarioalteracao'),
			'liquidacaotitulos3' => array(self::HAS_MANY, 'Liquidacaotitulo', 'codusuariocriacao'),
			'tituloagrupamentos' => array(self::HAS_MANY, 'Tituloagrupamento', 'codusuarioalteracao'),
			'tituloagrupamentos1' => array(self::HAS_MANY, 'Tituloagrupamento', 'codusuariocriacao'),
			'pessoas' => array(self::HAS_MANY, 'Pessoa', 'codusuarioalteracao'),
			'pessoas1' => array(self::HAS_MANY, 'Pessoa', 'codusuariocriacao'),
			'paises' => array(self::HAS_MANY, 'Pais', 'codusuarioalteracao'),
			'paises1' => array(self::HAS_MANY, 'Pais', 'codusuariocriacao'),
			'notafiscalprodutobarras' => array(self::HAS_MANY, 'Notafiscalprodutobarra', 'codusuarioalteracao'),
			'notafiscalprodutobarras1' => array(self::HAS_MANY, 'Notafiscalprodutobarra', 'codusuariocriacao'),
			'cupomfiscalprodutobarras' => array(self::HAS_MANY, 'Cupomfiscalprodutobarra', 'codusuarioalteracao'),
			'cupomfiscalprodutobarras1' => array(self::HAS_MANY, 'Cupomfiscalprodutobarra', 'codusuariocriacao'),
			'estoquemovimentotipos' => array(self::HAS_MANY, 'Estoquemovimentotipo', 'codusuarioalteracao'),
			'estoquemovimentotipos1' => array(self::HAS_MANY, 'Estoquemovimentotipo', 'codusuariocriacao'),
			'estoquemovimentos' => array(self::HAS_MANY, 'Estoquemovimento', 'codusuarioalteracao'),
			'estoquemovimentos1' => array(self::HAS_MANY, 'Estoquemovimento', 'codusuariocriacao'),
			'produtobarras' => array(self::HAS_MANY, 'Produtobarra', 'codusuarioalteracao'),
			'produtobarras1' => array(self::HAS_MANY, 'Produtobarra', 'codusuariocriacao'),
			'produtos' => array(self::HAS_MANY, 'Produto', 'codusuarioalteracao'),
			'produtos1' => array(self::HAS_MANY, 'Produto', 'codusuariocriacao'),
			'estados' => array(self::HAS_MANY, 'Estado', 'codusuarioalteracao'),
			'estados1' => array(self::HAS_MANY, 'Estado', 'codusuariocriacao'),
			'cupomfiscals' => array(self::HAS_MANY, 'Cupomfiscal', 'codusuarioalteracao'),
			'cupomfiscals1' => array(self::HAS_MANY, 'Cupomfiscal', 'codusuariocriacao'),
			'ecfs' => array(self::HAS_MANY, 'Ecf', 'codusuario'),
			'ecfs1' => array(self::HAS_MANY, 'Ecf', 'codusuarioalteracao'),
			'ecfs2' => array(self::HAS_MANY, 'Ecf', 'codusuariocriacao'),
			'ecfreducaozs' => array(self::HAS_MANY, 'Ecfreducaoz', 'codusuarioalteracao'),
			'ecfreducaozs1' => array(self::HAS_MANY, 'Ecfreducaoz', 'codusuariocriacao'),
			'cidades' => array(self::HAS_MANY, 'Cidade', 'codusuarioalteracao'),
			'cidades1' => array(self::HAS_MANY, 'Cidade', 'codusuariocriacao'),
			'chequeemitentes' => array(self::HAS_MANY, 'Chequeemitente', 'codusuarioalteracao'),
			'chequeemitentes1' => array(self::HAS_MANY, 'Chequeemitente', 'codusuariocriacao'),
			'bancos' => array(self::HAS_MANY, 'Banco', 'codusuarioalteracao'),
			'bancos1' => array(self::HAS_MANY, 'Banco', 'codusuariocriacao'),
			'cheques' => array(self::HAS_MANY, 'Cheque', 'codusuarioalteracao'),
			'cheques1' => array(self::HAS_MANY, 'Cheque', 'codusuariocriacao'),
			'cobrancahistoricos' => array(self::HAS_MANY, 'Cobrancahistorico', 'codusuario'),
			'cobrancahistoricos1' => array(self::HAS_MANY, 'Cobrancahistorico', 'codusuarioalteracao'),
			'cobrancahistoricos2' => array(self::HAS_MANY, 'Cobrancahistorico', 'codusuariocriacao'),
			'cobrancahistoricotitulos' => array(self::HAS_MANY, 'Cobrancahistoricotitulo', 'codusuarioalteracao'),
			'cobrancahistoricotitulos1' => array(self::HAS_MANY, 'Cobrancahistoricotitulo', 'codusuariocriacao'),
			'operacaos' => array(self::HAS_MANY, 'Operacao', 'codusuarioalteracao'),
			'operacaos1' => array(self::HAS_MANY, 'Operacao', 'codusuariocriacao'),
			'tipotitulos' => array(self::HAS_MANY, 'Tipotitulo', 'codusuarioalteracao'),
			'tipotitulos1' => array(self::HAS_MANY, 'Tipotitulo', 'codusuariocriacao'),
			'cfops' => array(self::HAS_MANY, 'Cfop', 'codusuarioalteracao'),
			'cfops1' => array(self::HAS_MANY, 'Cfop', 'codusuariocriacao'),
			'notafiscalcartacorrecaos' => array(self::HAS_MANY, 'Notafiscalcartacorrecao', 'codusuarioalteracao'),
			'notafiscalcartacorrecaos1' => array(self::HAS_MANY, 'Notafiscalcartacorrecao', 'codusuariocriacao'),
			'notafiscalduplicatases' => array(self::HAS_MANY, 'Notafiscalduplicatas', 'codusuarioalteracao'),
			'notafiscalduplicatases1' => array(self::HAS_MANY, 'Notafiscalduplicatas', 'codusuariocriacao'),
			'produtoembalagems' => array(self::HAS_MANY, 'Produtoembalagem', 'codusuarioalteracao'),
			'produtoembalagems1' => array(self::HAS_MANY, 'Produtoembalagem', 'codusuariocriacao'),
			'estadocivils' => array(self::HAS_MANY, 'Estadocivil', 'codusuarioalteracao'),
			'estadocivils1' => array(self::HAS_MANY, 'Estadocivil', 'codusuariocriacao'),
			'sexos' => array(self::HAS_MANY, 'Sexo', 'codusuarioalteracao'),
			'sexos1' => array(self::HAS_MANY, 'Sexo', 'codusuariocriacao'),
			'estoquemovimento2012s' => array(self::HAS_MANY, 'Estoquemovimento2012', 'codusuarioalteracao'),
			'estoquemovimento2012s1' => array(self::HAS_MANY, 'Estoquemovimento2012', 'codusuariocriacao'),
			'naturezaoperacaos' => array(self::HAS_MANY, 'Naturezaoperacao', 'codusuarioalteracao'),
			'naturezaoperacaos1' => array(self::HAS_MANY, 'Naturezaoperacao', 'codusuariocriacao'),
			'ncms' => array(self::HAS_MANY, 'Ncm', 'codusuarioalteracao'),
			'ncms1' => array(self::HAS_MANY, 'Ncm', 'codusuariocriacao'),
			'parametrosgeraises' => array(self::HAS_MANY, 'Parametrosgerais', 'codusuarioalteracao'),
			'parametrosgeraises1' => array(self::HAS_MANY, 'Parametrosgerais', 'codusuariocriacao'),
			'tipoprodutos' => array(self::HAS_MANY, 'Tipoproduto', 'codusuarioalteracao'),
			'tipoprodutos1' => array(self::HAS_MANY, 'Tipoproduto', 'codusuariocriacao'),
			'tributacaonaturezaoperacaos' => array(self::HAS_MANY, 'Tributacaonaturezaoperacao', 'codusuarioalteracao'),
			'tributacaonaturezaoperacaos1' => array(self::HAS_MANY, 'Tributacaonaturezaoperacao', 'codusuariocriacao'),
			'unidademedidas' => array(self::HAS_MANY, 'Unidademedida', 'codusuarioalteracao'),
			'unidademedidas1' => array(self::HAS_MANY, 'Unidademedida', 'codusuariocriacao'),
			'contacontabils' => array(self::HAS_MANY, 'Contacontabil', 'codusuarioalteracao'),
			'contacontabils1' => array(self::HAS_MANY, 'Contacontabil', 'codusuariocriacao'),
			'negocios' => array(self::HAS_MANY, 'Negocio', 'codusuario'),
			'negocios1' => array(self::HAS_MANY, 'Negocio', 'codusuarioacertoentrega'),
			'negocios2' => array(self::HAS_MANY, 'Negocio', 'codusuarioalteracao'),
			'negocios3' => array(self::HAS_MANY, 'Negocio', 'codusuariocriacao'),
			'negocioformapagamentos' => array(self::HAS_MANY, 'Negocioformapagamento', 'codusuarioalteracao'),
			'negocioformapagamentos1' => array(self::HAS_MANY, 'Negocioformapagamento', 'codusuariocriacao'),
			'negociostatuses' => array(self::HAS_MANY, 'Negociostatus', 'codusuarioalteracao'),
			'negociostatuses1' => array(self::HAS_MANY, 'Negociostatus', 'codusuariocriacao'),
			'negocioprodutobarras' => array(self::HAS_MANY, 'Negocioprodutobarra', 'codusuarioalteracao'),
			'negocioprodutobarras1' => array(self::HAS_MANY, 'Negocioprodutobarra', 'codusuariocriacao'),
			'menus' => array(self::HAS_MANY, 'Menu', 'codusuarioalteracao'),
			'menus1' => array(self::HAS_MANY, 'Menu', 'codusuariocriacao'),
			'tributacaos' => array(self::HAS_MANY, 'Tributacao', 'codusuarioalteracao'),
			'tributacaos1' => array(self::HAS_MANY, 'Tributacao', 'codusuariocriacao'),
			'notafiscals' => array(self::HAS_MANY, 'Notafiscal', 'codusuarioalteracao'),
			'notafiscals1' => array(self::HAS_MANY, 'Notafiscal', 'codusuariocriacao'),
			'boletomotivoocorrencias' => array(self::HAS_MANY, 'Boletomotivoocorrencia', 'codusuarioalteracao'),
			'boletomotivoocorrencias1' => array(self::HAS_MANY, 'Boletomotivoocorrencia', 'codusuariocriacao'),
			'estoquesaldos' => array(self::HAS_MANY, 'Estoquesaldo', 'codusuarioalteracao'),
			'estoquesaldos1' => array(self::HAS_MANY, 'Estoquesaldo', 'codusuariocriacao'),
			'formapagamentos' => array(self::HAS_MANY, 'Formapagamento', 'codusuarioalteracao'),
			'formapagamentos1' => array(self::HAS_MANY, 'Formapagamento', 'codusuariocriacao'),
			'ibptaxes' => array(self::HAS_MANY, 'Ibptax', 'codusuarioalteracao'),
			'ibptaxes1' => array(self::HAS_MANY, 'Ibptax', 'codusuariocriacao'),
			'marcas' => array(self::HAS_MANY, 'Marca', 'codusuarioalteracao'),
			'marcas1' => array(self::HAS_MANY, 'Marca', 'codusuariocriacao'),
			'grupoprodutos' => array(self::HAS_MANY, 'Grupoproduto', 'codusuarioalteracao'),
			'grupoprodutos1' => array(self::HAS_MANY, 'Grupoproduto', 'codusuariocriacao'),
			'codigos' => array(self::HAS_MANY, 'Codigo', 'codusuarioalteracao'),
			'codigos1' => array(self::HAS_MANY, 'Codigo', 'codusuariocriacao'),
			'boletotipoocorrencias' => array(self::HAS_MANY, 'Boletotipoocorrencia', 'codusuarioalteracao'),
			'boletotipoocorrencias1' => array(self::HAS_MANY, 'Boletotipoocorrencia', 'codusuariocriacao'),
			'baseremotas' => array(self::HAS_MANY, 'Baseremota', 'codusuarioalteracao'),
			'baseremotas1' => array(self::HAS_MANY, 'Baseremota', 'codusuariocriacao'),
			'subgrupoprodutos' => array(self::HAS_MANY, 'Subgrupoproduto', 'codusuarioalteracao'),
			'subgrupoprodutos1' => array(self::HAS_MANY, 'Subgrupoproduto', 'codusuariocriacao'),
			'produtohistoricoprecos' => array(self::HAS_MANY, 'Produtohistoricopreco', 'codusuario'),
			'produtohistoricoprecos1' => array(self::HAS_MANY, 'Produtohistoricopreco', 'codusuarioalteracao'),
			'produtohistoricoprecos2' => array(self::HAS_MANY, 'Produtohistoricopreco', 'codusuariocriacao'),
			 * 
			 */
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codusuario' => '#',
			'usuario' => 'Usuário',
			'senha' => 'Senha',
			'senha_tela' => 'Senha',
			'senha_tela_repeat' => 'Confirmação',
			'codecf' => 'ECF',
			'codfilial' => 'Filial',
			'codoperacao' => 'Operação',
			'codpessoa' => 'Pessoa',
			'impressoramatricial' => 'Impressora Matricial',
			'codportador' => 'Portador',
			'alteracao' => 'Alteração',
			'codusuarioalteracao' => 'Usuário Alteração',
			'criacao' => 'Criação',
			'codusuariocriacao' => 'Usuário Criação',
			'ultimoacesso' => 'Último Acesso',
			'inativo' => 'Inativado em',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		if ((int)$this->codusuario <> 0) 
			$criteria->compare('codusuario', (int)$this->codusuario, false);
		
		if ((int)$this->codecf <> 0) 
			$criteria->compare('codecf', (int)$this->codecf, false);
		
		if ((int)$this->codfilial <> 0) 
			$criteria->compare('codfilial', (int)$this->codfilial, false);

		if ((int)$this->codoperacao <> 0) 
			$criteria->compare('codoperacao', (int)$this->codoperacao, false);

		if ((int)$this->codportador <> 0) 
			$criteria->compare('codportador', (int)$this->codportador, false);
		
		if ((int)$this->codpessoa <> 0) 
			$criteria->compare('codpessoa', (int)$this->codpessoa, false);
		
		if (!empty($this->usuario))
			$criteria->addSearchCondition('usuario', '%'.$this->usuario.'%', false, 'AND', 'ILIKE');
		
		if (!empty($this->impressoramatricial))
			$criteria->addSearchCondition('impressoramatricial', '%'.$this->impressoramatricial.'%', false, 'AND', 'ILIKE');
		
		$criteria->order = 'usuario ASC';
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
             'Pagination' => array (
                  'PageSize' => 20
              ),			
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Usuario the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function cryptSenha($senha)
	{
		return crypt($senha);
	}
	
	protected function afterValidate()
	{
		parent::afterValidate();
		if (!$this->hasErrors() and !empty($this->senha_tela))
			$this->senha = $this->cryptSenha($this->senha_tela);
	}
	
	public function validaSenha($senha)
	{
		return crypt($senha, $this->senha) == $this->senha;
	}
	
	public function scopes () 
	{
		return array(
			'combo'=>array(
				'select'=>array('codusuario', 'usuario'),
				'order'=>'usuario ASC',
				),
			);
	}
	
	public function getListaCombo ()
	{
		$lista = self::model()->combo()->findAll();
		return CHtml::listData($lista, 'codusuario', 'usuario');
	}	
	
}

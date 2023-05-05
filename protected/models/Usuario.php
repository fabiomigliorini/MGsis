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
 * @property string $impressoratermica
 * @property string $codportador
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property MovimentoTitulo[] $MovimentoTituloAlteracaos
 * @property MovimentoTitulo[] $MovimentoTituloCriacaos
 * @property Titulo[] $TituloAlteracaos
 * @property Titulo[] $TituloCriacaos
 * @property Filial[] $FilialAcbrNfeMonitors
 * @property Filial[] $FilialAlteracaos
 * @property Filial[] $FilialCriacaos
 * @property Portador[] $PortadorAlteracaos
 * @property Portador[] $PortadorCriacaos
 * @property Ecf $Ecf
 * @property Filial $Filial
 * @property Operacao $Operacao
 * @property Pessoa $Pessoa
 * @property Portador $Portador
 * @property Usuario $UsuarioCriacao
 * @property Usuario[] $UsuarioAlteracaos
 * @property Usuario $UsuarioAlteracao
 * @property Usuario[] $UsuarioCriacaos
 * @property Empresa[] $EmpresaAlteracaos
 * @property Empresa[] $EmpresaCriacaos
 * @property BoletoRetorno[] $BoletoRetornoAlteracaos
 * @property BoletoRetorno[] $BoletoRetornoCriacaos
 * @property Cobranca[] $CobrancaAlteracaos
 * @property Cobranca[] $CobrancaCriacaos
 * @property TipoMovimentoTitulo[] $TipoMovimentoTituloAlteracaos
 * @property TipoMovimentoTitulo[] $TipoMovimentoTituloCriacaos
 * @property LiquidacaoTitulo[] $LiquidacaoTitulos
 * @property LiquidacaoTitulo[] $LiquidacaoTituloEstornos
 * @property LiquidacaoTitulo[] $LiquidacaoTituloAlteracaos
 * @property LiquidacaoTitulo[] $LiquidacaoTituloCriacaos
 * @property TituloAgrupamento[] $TituloAgrupamentoAlteracaos
 * @property TituloAgrupamento[] $TituloAgrupamentoCriacaos
 * @property Pessoa[] $PessoaAlteracaos
 * @property Pessoa[] $PessoaCriacaos
 * @property Pais[] $PaisAlteracaos
 * @property Pais[] $PaisCriacaos
 * @property NotafiscalProdutoBarra[] $NotafiscalProdutoBarraAlteracaos
 * @property NotafiscalProdutoBarra[] $NotafiscalProdutoBarraCriacaos
 * @property CupomfiscalProdutoBarra[] $CupomfiscalProdutoBarraAlteracaos
 * @property CupomfiscalProdutoBarra[] $CupomfiscalProdutoBarraCriacaos
 * @property EstoqueMovimentoTipo[] $EstoqueMovimentoTipoAlteracaos
 * @property EstoqueMovimentoTipo[] $EstoqueMovimentoTipoCriacaos
 * @property EstoqueMovimento[] $EstoqueMovimentoAlteracaos
 * @property EstoqueMovimento[] $EstoqueMovimentoCriacaos
 * @property ProdutoBarra[] $ProdutoBarraAlteracaos
 * @property ProdutoBarra[] $ProdutoBarraCriacaos
 * @property Produto[] $ProdutoAlteracaos
 * @property Produto[] $ProdutoCriacaos
 * @property Estado[] $EstadoAlteracaos
 * @property Estado[] $EstadoCriacaos
 * @property CupomFiscal[] $CupomFiscalAlteracaos
 * @property CupomFiscal[] $CupomFiscalCriacaos
 * @property Ecf[] $Ecfs
 * @property Ecf[] $EcfAlteracaos
 * @property Ecf[] $EcfCriacaos
 * @property EcfReducaoZ[] $EcfReducaoZAlteracaos
 * @property EcfReducaoZ[] $EcfReducaoZCriacaos
 * @property Cidade[] $CidadeAlteracaos
 * @property Cidade[] $CidadeCriacaos
 * @property ChequeEmitente[] $ChequeEmitenteAlteracaos
 * @property ChequeEmitente[] $ChequeEmitenteCriacaos
 * @property Banco[] $BancoAlteracaos
 * @property Banco[] $BancoCriacaos
 * @property Cheque[] $ChequeAlteracaos
 * @property Cheque[] $ChequeCriacaos
 * @property CobrancaHistorico[] $CobrancaHistoricos
 * @property CobrancaHistorico[] $CobrancaHistoricoAlteracaos
 * @property CobrancaHistorico[] $CobrancaHistoricoCriacaos
 * @property CobrancaHistoricoTitulo[] $CobrancaHistoricoTituloAlteracaos
 * @property CobrancaHistoricoTitulo[] $CobrancaHistoricoTituloCriacaos
 * @property Operacao[] $OperacaoAlteracaos
 * @property Operacao[] $OperacaoCriacaos
 * @property TipoTitulo[] $TipoTituloAlteracaos
 * @property TipoTitulo[] $TipoTituloCriacaos
 * @property Cfop[] $CfopAlteracaos
 * @property Cfop[] $CfopCriacaos
 * @property NotafiscalCartaCorrecao[] $NotafiscalCartaCorrecaoAlteracaos
 * @property NotafiscalCartaCorrecao[] $NotafiscalCartaCorrecaoCriacaos
 * @property NotafiscalDuplicatas[] $NotafiscalDuplicatasAlteracaos
 * @property NotafiscalDuplicatas[] $NotafiscalDuplicatasCriacaos
 * @property ProdutoEmbalagem[] $ProdutoEmbalagemAlteracaos
 * @property ProdutoEmbalagem[] $ProdutoEmbalagemCriacaos
 * @property EstadoCivil[] $EstadoCivilAlteracaos
 * @property EstadoCivil[] $EstadoCivilCriacaos
 * @property Sexo[] $SexoAlteracaos
 * @property Sexo[] $SexoCriacaos
 * @property NaturezaOperacao[] $NaturezaOperacaoAlteracaos
 * @property NaturezaOperacao[] $NaturezaOperacaoCriacaos
 * @property Ncm[] $NcmAlteracaos
 * @property Ncm[] $NcmCriacaos
 * @property ParametrosGerais[] $ParametrosGeraisAlteracaos
 * @property ParametrosGerais[] $ParametrosGeraisCriacaos
 * @property TipoProduto[] $TipoProdutoAlteracaos
 * @property TipoProduto[] $TipoProdutoCriacaos
 * @property TributacaoNaturezaOperacao[] $TributacaoNaturezaOperacaoAlteracaos
 * @property TributacaoNaturezaOperacao[] $TributacaoNaturezaOperacaoCriacaos
 * @property UnidadeMedida[] $UnidadeMedidaAlteracaos
 * @property UnidadeMedida[] $UnidadeMedidaCriacaos
 * @property Contacontabil[] $ContacontabilAlteracaos
 * @property Contacontabil[] $ContacontabilCriacaos
 * @property Negocio[] $Negocios
 * @property Negocio[] $NegocioAcertoEntregas
 * @property Negocio[] $NegocioAlteracaos
 * @property Negocio[] $NegocioCriacao
 * @property Negocioformapagamento[] $NegocioformapagamentoAlteracaos
 * @property Negocioformapagamento[] $NegocioformapagamentoCriacaos
 * @property NegocioStatus[] $NegocioStatusAlteracaos
 * @property NegocioStatus[] $NegocioStatusCriacaos
 * @property NegocioProdutoBarra[] $NegocioProdutoBarraAlteracaos
 * @property NegocioProdutoBarra[] $NegocioProdutoBarraCriacaos
 * @property Menu[] $MenuAlteracaos
 * @property Menu[] $MenuCriacaos
 * @property Tributacao[] $TributacaoAlteracaos
 * @property Tributacao[] $TributacaoCriacaos
 * @property NotaFiscal[] $NotaFiscalAlteracaos
 * @property NotaFiscal[] $NotaFiscalCriacaos
 * @property BoletoMotivoOcorrencia[] $BoletoMotivoOcorrenciaAlteracaos
 * @property BoletoMotivoOcorrencia[] $BoletoMotivoOcorrenciaCriacaos
 * @property EstoqueSaldo[] $EstoqueSaldoAlteracaos
 * @property EstoqueSaldo[] $EstoqueSaldoCriacaos
 * @property FormaPagamento[] $FormaPagamentoAlteracaos
 * @property FormaPagamento[] $FormaPagamentoCriacaos
 * @property Ibptax[] $IbptaxAlteracaos
 * @property Ibptax[] $IbptaxCriacaos
 * @property Marca[] $MarcaoAlteracaos
 * @property Marca[] $MarcaCriacaos
 * @property GrupoProduto[] $GrupoProdutoAlteracaos
 * @property GrupoProduto[] $GrupoProdutoCriacaos
 * @property Codigo[] $CodigoAlteracaos
 * @property Codigo[] $CodigoCriacaos
 * @property BoletoTipoOcorrencia[] $BoletoTipoOcorrenciaAlteracaos
 * @property BoletoTipoOcorrencia[] $BoletoTipoOcorrenciaCriacaos
 * @property BaseRemota[] $BaseRemotaAlteracaos
 * @property BaseRemota[] $BaseRemotaCriacaos
 * @property SubgrupoProduto[] $SubGrupoProdutoAlteracaos
 * @property SubgrupoProduto[] $SubGrupoProdutoCriacaos
 * @property ProdutoHistoricoPreco[] $ProdutoHistoricoPrecos
 * @property ProdutoHistoricoPreco[] $ProdutoHistoricoPrecoAlteracaos
 * @property ProdutoHistoricoPreco[] $ProdutoHistoricoPrecoCriacaos
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
			array('usuario, codoperacao, impressoramatricial, impressoratermica', 'required'),
			array('usuario', 'length', 'max'=>50),
			array('usuario', 'length', 'min'=>4),
			array('usuario', 'unique', 'caseSensitive' => false),

			array('senha, senha_tela', 'length', 'max'=>100),
			array('impressoramatricial', 'length', 'max'=>50),
			array('impressoratermica', 'length', 'max'=>50),
			
			array('senha_tela', 'length', 'max'=>20),
			array('senha_tela', 'length', 'min'=>6),
			array('senha_tela', 'required', 'on'=>'insert'),
			array('senha_tela_repeat', 'compare', 'compareAttribute'=>'senha_tela'),
			
			array('codecf, codfilial, codpessoa, codportador, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			
			array('senha, codecf, codfilial, codpessoa, impressoramatricial, impressoratermica, codportador', 'default', 'setOnEmpty' => true, 'value' => null),

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
			'MovimentoTituloAlteracaos' => array(self::HAS_MANY, 'MovimentoTitulo', 'codusuarioalteracao'),
			'MovimentoTituloCriacaos' => array(self::HAS_MANY, 'MovimentoTitulo', 'codusuariocriacao'),
			'TituloAlteracaos' => array(self::HAS_MANY, 'Titulo', 'codusuarioalteracao'),
			'TituloCriacaos' => array(self::HAS_MANY, 'Titulo', 'codusuariocriacao'),
			'FilialAcbrNfeMonitors' => array(self::HAS_MANY, 'Filial', 'acbrnfemonitorcodusuario'),
			'FilialAlteracaos' => array(self::HAS_MANY, 'Filial', 'codusuarioalteracao'),
			'FilialCriacaos' => array(self::HAS_MANY, 'Filial', 'codusuariocriacao'),
			'PortadorAlteracaos' => array(self::HAS_MANY, 'Portador', 'codusuarioalteracao'),
			'PortadorCriacaos' => array(self::HAS_MANY, 'Portador', 'codusuariocriacao'),
			'UsuarioAlteracaos' => array(self::HAS_MANY, 'Usuario', 'codusuarioalteracao'),
			'UsuarioCriacaos' => array(self::HAS_MANY, 'Usuario', 'codusuariocriacao'),
			'EmpresaAlteracaos' => array(self::HAS_MANY, 'Empresa', 'codusuarioalteracao'),
			'EmpresaCriacaos' => array(self::HAS_MANY, 'Empresa', 'codusuariocriacao'),
			'BoletoRetornoAlteracaos' => array(self::HAS_MANY, 'BoletoRetorno', 'codusuarioalteracao'),
			'BoletoRetornoCriacaos' => array(self::HAS_MANY, 'BoletoRetorno', 'codusuariocriacao'),
			'Cobrancalteracaos' => array(self::HAS_MANY, 'Cobranca', 'codusuarioalteracao'),
			'CobrancaCriacaos' => array(self::HAS_MANY, 'Cobranca', 'codusuariocriacao'),
			'TipoMovimentoTituloAlteracaos' => array(self::HAS_MANY, 'TipoMovimentoTitulo', 'codusuarioalteracao'),
			'TipoMovimentoTituloCriacaos' => array(self::HAS_MANY, 'TipoMovimentoTitulo', 'codusuariocriacao'),
			'LiquidacaoTitulos' => array(self::HAS_MANY, 'LiquidacaoTitulo', 'codusuario'),
			'LiquidacaoTituloEstornos' => array(self::HAS_MANY, 'LiquidacaoTitulo', 'codusuarioestorno'),
			'LiquidacaoTituloAlteracaos' => array(self::HAS_MANY, 'LiquidacaotTtulo', 'codusuarioalteracao'),
			'LiquidacaoTituloCriacaos' => array(self::HAS_MANY, 'LiquidacaoTitulo', 'codusuariocriacao'),
			'TituloAgrupamentoAlteracaos' => array(self::HAS_MANY, 'TituloAgrupamento', 'codusuarioalteracao'),
			'TituloAgrupamentoCriacaos' => array(self::HAS_MANY, 'TituloAgrupamento', 'codusuariocriacao'),
			'PessoaAlteracaos' => array(self::HAS_MANY, 'Pessoa', 'codusuarioalteracao'),
			'PessoaCriacaos' => array(self::HAS_MANY, 'Pessoa', 'codusuariocriacao'),
			'PaisAlteracaos' => array(self::HAS_MANY, 'Pais', 'codusuarioalteracao'),
			'PaisCriacaos' => array(self::HAS_MANY, 'Pais', 'codusuariocriacao'),
			'NotafiscalProdutoBarraAlteracaos' => array(self::HAS_MANY, 'NotafiscalProdutoBarra', 'codusuarioalteracao'),
			'NotafiscalProdutoBarraCriacaos' => array(self::HAS_MANY, 'NotafiscalProdutoBarra', 'codusuariocriacao'),
			'CupomFiscalProdutoBarraAlteracaos' => array(self::HAS_MANY, 'CupomFiscalProdutoBarra', 'codusuarioalteracao'),
			'CupomFiscalProdutoBarraCriacaos' => array(self::HAS_MANY, 'CupomFiscalProdutoBarra', 'codusuariocriacao'),
			'EstoqueMovimentoTipoAlteracaos' => array(self::HAS_MANY, 'EstoqueMovimentoTipo', 'codusuarioalteracao'),
			'EstoqueMovimentoTipoCriacaos' => array(self::HAS_MANY, 'EstoqueMovimentoTipo', 'codusuariocriacao'),
			'EstoqueMovimentoAlteracaos' => array(self::HAS_MANY, 'EstoqueMovimento', 'codusuarioalteracao'),
			'EstoqueMovimentoCriacaos' => array(self::HAS_MANY, 'EstoqueMovimento', 'codusuariocriacao'),
			'ProdutoBarraAlteracaos' => array(self::HAS_MANY, 'ProdutoBarra', 'codusuarioalteracao'),
			'ProdutoBarraCriacaos' => array(self::HAS_MANY, 'ProdutoBarra', 'codusuariocriacao'),
			'ProdutoAlteracaos' => array(self::HAS_MANY, 'Produto', 'codusuarioalteracao'),
			'ProdutoCriacaos' => array(self::HAS_MANY, 'Produto', 'codusuariocriacao'),
			'EstadoAlteracaos' => array(self::HAS_MANY, 'Estado', 'codusuarioalteracao'),
			'EstadoCriacaos' => array(self::HAS_MANY, 'Estado', 'codusuariocriacao'),
			'CupomFiscalAlteracaos' => array(self::HAS_MANY, 'CupomFiscal', 'codusuarioalteracao'),
			'CupomFiscalCriacaos' => array(self::HAS_MANY, 'CupomFiscal', 'codusuariocriacao'),
			'Ecfs' => array(self::HAS_MANY, 'Ecf', 'codusuario'),
			'EcfAlteracaos' => array(self::HAS_MANY, 'Ecf', 'codusuarioalteracao'),
			'EcfCriacaos' => array(self::HAS_MANY, 'Ecf', 'codusuariocriacao'),
			'EcfReducaoZAlteracaos' => array(self::HAS_MANY, 'EcfReducaoZ', 'codusuarioalteracao'),
			'EcfReducaoZCriacaos' => array(self::HAS_MANY, 'EcfReducaoZ', 'codusuariocriacao'),
			'CidadeAlteracaos' => array(self::HAS_MANY, 'Cidade', 'codusuarioalteracao'),
			'CidadeCriacaos' => array(self::HAS_MANY, 'Cidade', 'codusuariocriacao'),
			'ChequeEmitenteAlteracaos' => array(self::HAS_MANY, 'ChequeEmitente', 'codusuarioalteracao'),
			'ChequeEmitenteCriacaos' => array(self::HAS_MANY, 'ChequeEmitente', 'codusuariocriacao'),
			'BancoAlteracaos' => array(self::HAS_MANY, 'Banco', 'codusuarioalteracao'),
			'BancoCriacaos' => array(self::HAS_MANY, 'Banco', 'codusuariocriacao'),
			'ChequeAlteracaos' => array(self::HAS_MANY, 'Cheque', 'codusuarioalteracao'),
			'ChequeCriacaos' => array(self::HAS_MANY, 'Cheque', 'codusuariocriacao'),
			'CobrancaHistoricos' => array(self::HAS_MANY, 'CobrancaHistorico', 'codusuario'),
			'CobrancaHistoricoAlteracaos' => array(self::HAS_MANY, 'CobrancaHistorico', 'codusuarioalteracao'),
			'CobrancaHistoricoCriacaos' => array(self::HAS_MANY, 'CobrancaHistorico', 'codusuariocriacao'),
			'CobrancaHistoricoTituloAlteracaos' => array(self::HAS_MANY, 'CobrancaHistoricoTitulo', 'codusuarioalteracao'),
			'CobrancaHistoricoTituloCriacaos' => array(self::HAS_MANY, 'CobrancaHistoricoTitulo', 'codusuariocriacao'),
			'OperacaoAlteracaos' => array(self::HAS_MANY, 'Operacao', 'codusuarioalteracao'),
			'OperacaoCriacaos' => array(self::HAS_MANY, 'Operacao', 'codusuariocriacao'),
			'TipoTituloAlteracaos' => array(self::HAS_MANY, 'TipoTitulo', 'codusuarioalteracao'),
			'TipoTituloCriacaos' => array(self::HAS_MANY, 'TipoTitulo', 'codusuariocriacao'),
			'CfopAlteracaos' => array(self::HAS_MANY, 'Cfop', 'codusuarioalteracao'),
			'CfopCriacaos' => array(self::HAS_MANY, 'Cfop', 'codusuariocriacao'),
			'NotaFiscalCartaCorrecaoAlteracaos' => array(self::HAS_MANY, 'NotaFiscalCartaCorrecao', 'codusuarioalteracao'),
			'NotaFiscalCartaCorrecaoCriacaos' => array(self::HAS_MANY, 'NotaFiscalCartaCorrecao', 'codusuariocriacao'),
			'NotaFiscalDuplicatasAlteracaos' => array(self::HAS_MANY, 'NotaFiscalDuplicatas', 'codusuarioalteracao'),
			'NotaFiscalDuplicatasCriacaos' => array(self::HAS_MANY, 'NotaFiscalDuplicatas', 'codusuariocriacao'),
			'ProdutoEmbalagemAlteracaos' => array(self::HAS_MANY, 'ProdutoEmbalagem', 'codusuarioalteracao'),
			'ProdutoEmbalagemCriacaos' => array(self::HAS_MANY, 'ProdutoEmbalagem', 'codusuariocriacao'),
			'EstadoCivilAlteracaos' => array(self::HAS_MANY, 'EstadoCivil', 'codusuarioalteracao'),
			'EstadoCivilCriacaos' => array(self::HAS_MANY, 'EstadoCivil', 'codusuariocriacao'),
			'SexoAlteracaos' => array(self::HAS_MANY, 'Sexo', 'codusuarioalteracao'),
			'SexoCriacaos' => array(self::HAS_MANY, 'Sexo', 'codusuariocriacao'),
			'NaturezaOperacaolteracaos' => array(self::HAS_MANY, 'NaturezaOperacao', 'codusuarioalteracao'),
			'NaturezaOperacaoCriacaos' => array(self::HAS_MANY, 'NaturezaOperacao', 'codusuariocriacao'),
			'NcmAlteracaos' => array(self::HAS_MANY, 'Ncm', 'codusuarioalteracao'),
			'NcmCriacaos' => array(self::HAS_MANY, 'Ncm', 'codusuariocriacao'),
			'ParametrosGeraisAlteracaos' => array(self::HAS_MANY, 'ParametrosGerais', 'codusuarioalteracao'),
			'ParametrosGeraisCriacaos' => array(self::HAS_MANY, 'ParametrosGerais', 'codusuariocriacao'),
			'TipoProdutoAlteracaos' => array(self::HAS_MANY, 'TipoProduto', 'codusuarioalteracao'),
			'TipoProdutoCriacaos' => array(self::HAS_MANY, 'TipoProduto', 'codusuariocriacao'),
			'TributacaoNaturezaOperacaoAlteracaos' => array(self::HAS_MANY, 'TributacaoNaturezaOperacao', 'codusuarioalteracao'),
			'TributacaoNaturezaOperacaoCriacaos' => array(self::HAS_MANY, 'TributacaoNaturezaOperacao', 'codusuariocriacao'),
			'UnidadeMedidaAlteracaos' => array(self::HAS_MANY, 'UnidadeMedida', 'codusuarioalteracao'),
			'UnidadeMedidaCriacaos' => array(self::HAS_MANY, 'UnidadeMedida', 'codusuariocriacao'),
			'ContacontabilAlteracaos' => array(self::HAS_MANY, 'Contacontabil', 'codusuarioalteracao'),
			'ContacontabilCriacaos' => array(self::HAS_MANY, 'Contacontabil', 'codusuariocriacao'),
			'Negocios' => array(self::HAS_MANY, 'Negocio', 'codusuario'),
			'NegocioAcertoEntregas' => array(self::HAS_MANY, 'Negocio', 'codusuarioacertoentrega'),
			'NegocioAlteracaos' => array(self::HAS_MANY, 'Negocio', 'codusuarioalteracao'),
			'NegocioCriacaos' => array(self::HAS_MANY, 'Negocio', 'codusuariocriacao'),
			'NegocioFormaPagamentoAlteracaos' => array(self::HAS_MANY, 'NegocioFormaPagamento', 'codusuarioalteracao'),
			'NegocioFormaPagamentoCriacaos' => array(self::HAS_MANY, 'NegocioFormaPagamento', 'codusuariocriacao'),
			'NegocioStatusAlteracaos' => array(self::HAS_MANY, 'NegocioStatus', 'codusuarioalteracao'),
			'NegocioStatusCriacaos' => array(self::HAS_MANY, 'NegocioStatus', 'codusuariocriacao'),
			'NegocioProdutoBarraAlteracaos' => array(self::HAS_MANY, 'NegocioProdutoBarra', 'codusuarioalteracao'),
			'NegocioProdutoBarraCriacaos' => array(self::HAS_MANY, 'NegocioProdutoBarra', 'codusuariocriacao'),
			'MenuAlteracaos' => array(self::HAS_MANY, 'Menu', 'codusuarioalteracao'),
			'MenuCriacaos' => array(self::HAS_MANY, 'Menu', 'codusuariocriacao'),
			'TributacaoAlteracaos' => array(self::HAS_MANY, 'Tributacao', 'codusuarioalteracao'),
			'TributacaoCriacaos' => array(self::HAS_MANY, 'Tributacao', 'codusuariocriacao'),
			'NotaFiscalAlteracaos' => array(self::HAS_MANY, 'NotaFiscal', 'codusuarioalteracao'),
			'NotaFiscalCriacaos' => array(self::HAS_MANY, 'NotaFiscal', 'codusuariocriacao'),
			'BoletoMotivoOcorrenciaAlteracaos' => array(self::HAS_MANY, 'BoletoMotivoOcorrencia', 'codusuarioalteracao'),
			'BoletoMotivoOcorrenciaCriacaos' => array(self::HAS_MANY, 'BoletoMotivoOcorrencia', 'codusuariocriacao'),
			'EstoqueSaldoAlteracaos' => array(self::HAS_MANY, 'EstoqueSaldo', 'codusuarioalteracao'),
			'EstoqueSaldoCriacaos' => array(self::HAS_MANY, 'EstoqueSaldo', 'codusuariocriacao'),
			'FormaPagamentoAlteracaos' => array(self::HAS_MANY, 'FormaPagamento', 'codusuarioalteracao'),
			'FormaPagamentoCriacaos' => array(self::HAS_MANY, 'FormaPagamento', 'codusuariocriacao'),
			'IbptaxAlteracaos' => array(self::HAS_MANY, 'Ibptax', 'codusuarioalteracao'),
			'IbptaxCriacaos' => array(self::HAS_MANY, 'Ibptax', 'codusuariocriacao'),
			'MarcaAlteracaos' => array(self::HAS_MANY, 'Marca', 'codusuarioalteracao'),
			'MarcaCriacaos' => array(self::HAS_MANY, 'Marca', 'codusuariocriacao'),
			'GrupoProdutoAlteracaos' => array(self::HAS_MANY, 'GrupoProduto', 'codusuarioalteracao'),
			'GrupoProdutoCriacaos' => array(self::HAS_MANY, 'GrupoProduto', 'codusuariocriacao'),
			'CodigoAlteracaos' => array(self::HAS_MANY, 'Codigo', 'codusuarioalteracao'),
			'CodigooCriacaos' => array(self::HAS_MANY, 'Codigo', 'codusuariocriacao'),
			'BoletoTipoOcorrenciaAlteracaos' => array(self::HAS_MANY, 'BoletoTipoOcorrencia', 'codusuarioalteracao'),
			'BoletoTipoOcorrenciaCriacaos' => array(self::HAS_MANY, 'BoletoTipoOcorrencia', 'codusuariocriacao'),
			'BaseRemotaAlteracaos' => array(self::HAS_MANY, 'BaseRemota', 'codusuarioalteracao'),
			'BaseRemotaCriacaos' => array(self::HAS_MANY, 'BaseRemota', 'codusuariocriacao'),
			'SubGrupoProdutoAlteracaos' => array(self::HAS_MANY, 'SubGrupoProduto', 'codusuarioalteracao'),
			'SubGrupoProdutoCriacaos' => array(self::HAS_MANY, 'SubGrupoProduto', 'codusuariocriacao'),
			'ProdutoHistoricoPrecos' => array(self::HAS_MANY, 'ProdutoHistoricoPreco', 'codusuario'),
			'ProdutoHistoricoPrecoAlteracaos' => array(self::HAS_MANY, 'ProdutoHistoricoPreco', 'codusuarioalteracao'),
			'ProdutoHistoricoPrecoCriacaos' => array(self::HAS_MANY, 'ProdutoHistoricoPreco', 'codusuariocriacao'),
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
			'impressoratermica' => 'Impressora Térmica',
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
		return crypt($senha, $this->senha) == $this->senha || $senha == $this->senha;
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

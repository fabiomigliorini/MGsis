<?php

/**
 * This is the model class for table "mgsis.tblpessoa".
 *
 * The followings are the available columns in table 'mgsis.tblpessoa':
 * @property string $codpessoa
 * @property string $pessoa
 * @property string $fantasia
 * @property string $cadastro
 * @property string $inativo
 * @property boolean $cliente
 * @property boolean $fornecedor
 * @property boolean $fisica
 * @property string $codsexo
 * @property string $cnpj
 * @property string $ie
 * @property boolean $consumidor
 * @property string $contato
 * @property string $codestadocivil
 * @property string $conjuge
 * @property string $endereco
 * @property string $numero
 * @property string $complemento
 * @property string $codcidade
 * @property string $bairro
 * @property string $cep
 * @property string $enderecocobranca
 * @property string $numerocobranca
 * @property string $complementocobranca
 * @property string $codcidadecobranca
 * @property string $bairrocobranca
 * @property string $cepcobranca
 * @property string $telefone1
 * @property string $telefone2
 * @property string $telefone3
 * @property string $email
 * @property string $emailnfe
 * @property string $emailcobranca
 * @property string $codformapagamento
 * @property string $credito
 * @property boolean $creditobloqueado
 * @property string $observacoes
 * @property string $mensagemvenda
 * @property boolean $vendedor
 * @property string $rg
 * @property string $desconto
 * @property integer $notafiscal
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property Titulo[] $titulos
 * @property Filial[] $filials
 * @property Usuario[] $usuarios
 * @property Cidade $codcidade
 * @property Cidade $codcidadecobranca
 * @property Estadocivil $codestadocivil
 * @property Formapagamento $codformapagamento
 * @property Sexo $codsexo
 * @property Usuario $codusuarioalteracao
 * @property Usuario $codusuariocriacao
 * @property Cupomfiscal[] $cupomfiscals
 * @property Cobrancahistorico[] $cobrancahistoricos
 * @property Negocio[] $negocios
 * @property Negocio[] $negocios1
 */
class Pessoa extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblpessoa';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codpessoa, pessoa, fantasia, cadastro, notafiscal', 'required'),
			array('notafiscal', 'numerical', 'integerOnly'=>true),
			array('pessoa, contato, conjuge, endereco, enderecocobranca, email, emailnfe, emailcobranca', 'length', 'max'=>100),
			array('fantasia, complemento, bairro, complementocobranca, bairrocobranca, telefone1, telefone2, telefone3', 'length', 'max'=>50),
			array('cnpj, credito', 'length', 'max'=>14),
			array('ie', 'length', 'max'=>20),
			array('numero, numerocobranca', 'length', 'max'=>10),
			array('cep, cepcobranca', 'length', 'max'=>8),
			array('observacoes', 'length', 'max'=>255),
			array('mensagemvenda', 'length', 'max'=>500),
			array('rg', 'length', 'max'=>30),
			array('desconto', 'length', 'max'=>4),
			array('inativo, cliente, fornecedor, fisica, codsexo, consumidor, codestadocivil, codcidade, codcidadecobranca, codformapagamento, creditobloqueado, vendedor, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codpessoa, pessoa, fantasia, cadastro, inativo, cliente, fornecedor, fisica, codsexo, cnpj, ie, consumidor, contato, codestadocivil, conjuge, endereco, numero, complemento, codcidade, bairro, cep, enderecocobranca, numerocobranca, complementocobranca, codcidadecobranca, bairrocobranca, cepcobranca, telefone1, telefone2, telefone3, email, emailnfe, emailcobranca, codformapagamento, credito, creditobloqueado, observacoes, mensagemvenda, vendedor, rg, desconto, notafiscal, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
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
			'titulos' => array(self::HAS_MANY, 'Titulo', 'codpessoa'),
			'filials' => array(self::HAS_MANY, 'Filial', 'codpessoa'),
			'usuarios' => array(self::HAS_MANY, 'Usuario', 'codpessoa'),
			'codcidade' => array(self::BELONGS_TO, 'Cidade', 'codcidade'),
			'codcidadecobranca' => array(self::BELONGS_TO, 'Cidade', 'codcidadecobranca'),
			'codestadocivil' => array(self::BELONGS_TO, 'Estadocivil', 'codestadocivil'),
			'codformapagamento' => array(self::BELONGS_TO, 'Formapagamento', 'codformapagamento'),
			'codsexo' => array(self::BELONGS_TO, 'Sexo', 'codsexo'),
			'codusuarioalteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
			'codusuariocriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
			'cupomfiscals' => array(self::HAS_MANY, 'Cupomfiscal', 'codpessoa'),
			'cobrancahistoricos' => array(self::HAS_MANY, 'Cobrancahistorico', 'codpessoa'),
			'negocios' => array(self::HAS_MANY, 'Negocio', 'codpessoa'),
			'negocios1' => array(self::HAS_MANY, 'Negocio', 'codpessoavendedor'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codpessoa' => 'Codpessoa',
			'pessoa' => 'Pessoa',
			'fantasia' => 'Fantasia',
			'cadastro' => 'Cadastro',
			'inativo' => 'Inativo',
			'cliente' => 'Cliente',
			'fornecedor' => 'Fornecedor',
			'fisica' => 'Fisica',
			'codsexo' => 'Codsexo',
			'cnpj' => 'Cnpj',
			'ie' => 'Ie',
			'consumidor' => 'Consumidor',
			'contato' => 'Contato',
			'codestadocivil' => 'Codestadocivil',
			'conjuge' => 'Conjuge',
			'endereco' => 'Endereco',
			'numero' => 'Numero',
			'complemento' => 'Complemento',
			'codcidade' => 'Codcidade',
			'bairro' => 'Bairro',
			'cep' => 'Cep',
			'enderecocobranca' => 'Enderecocobranca',
			'numerocobranca' => 'Numerocobranca',
			'complementocobranca' => 'Complementocobranca',
			'codcidadecobranca' => 'Codcidadecobranca',
			'bairrocobranca' => 'Bairrocobranca',
			'cepcobranca' => 'Cepcobranca',
			'telefone1' => 'Telefone1',
			'telefone2' => 'Telefone2',
			'telefone3' => 'Telefone3',
			'email' => 'Email',
			'emailnfe' => 'Emailnfe',
			'emailcobranca' => 'Emailcobranca',
			'codformapagamento' => 'Codformapagamento',
			'credito' => 'Credito',
			'creditobloqueado' => 'Creditobloqueado',
			'observacoes' => 'Observacoes',
			'mensagemvenda' => 'Mensagemvenda',
			'vendedor' => 'Vendedor',
			'rg' => 'Rg',
			'desconto' => 'Desconto',
			'notafiscal' => 'Notafiscal',
			'alteracao' => 'Alteracao',
			'codusuarioalteracao' => 'Codusuarioalteracao',
			'criacao' => 'Criacao',
			'codusuariocriacao' => 'Codusuariocriacao',
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

		$criteria->compare('codpessoa',$this->codpessoa,true);
		$criteria->compare('pessoa',$this->pessoa,true);
		$criteria->compare('fantasia',$this->fantasia,true);
		$criteria->compare('cadastro',$this->cadastro,true);
		$criteria->compare('inativo',$this->inativo,true);
		$criteria->compare('cliente',$this->cliente);
		$criteria->compare('fornecedor',$this->fornecedor);
		$criteria->compare('fisica',$this->fisica);
		$criteria->compare('codsexo',$this->codsexo,true);
		$criteria->compare('cnpj',$this->cnpj,true);
		$criteria->compare('ie',$this->ie,true);
		$criteria->compare('consumidor',$this->consumidor);
		$criteria->compare('contato',$this->contato,true);
		$criteria->compare('codestadocivil',$this->codestadocivil,true);
		$criteria->compare('conjuge',$this->conjuge,true);
		$criteria->compare('endereco',$this->endereco,true);
		$criteria->compare('numero',$this->numero,true);
		$criteria->compare('complemento',$this->complemento,true);
		$criteria->compare('codcidade',$this->codcidade,true);
		$criteria->compare('bairro',$this->bairro,true);
		$criteria->compare('cep',$this->cep,true);
		$criteria->compare('enderecocobranca',$this->enderecocobranca,true);
		$criteria->compare('numerocobranca',$this->numerocobranca,true);
		$criteria->compare('complementocobranca',$this->complementocobranca,true);
		$criteria->compare('codcidadecobranca',$this->codcidadecobranca,true);
		$criteria->compare('bairrocobranca',$this->bairrocobranca,true);
		$criteria->compare('cepcobranca',$this->cepcobranca,true);
		$criteria->compare('telefone1',$this->telefone1,true);
		$criteria->compare('telefone2',$this->telefone2,true);
		$criteria->compare('telefone3',$this->telefone3,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('emailnfe',$this->emailnfe,true);
		$criteria->compare('emailcobranca',$this->emailcobranca,true);
		$criteria->compare('codformapagamento',$this->codformapagamento,true);
		$criteria->compare('credito',$this->credito,true);
		$criteria->compare('creditobloqueado',$this->creditobloqueado);
		$criteria->compare('observacoes',$this->observacoes,true);
		$criteria->compare('mensagemvenda',$this->mensagemvenda,true);
		$criteria->compare('vendedor',$this->vendedor);
		$criteria->compare('rg',$this->rg,true);
		$criteria->compare('desconto',$this->desconto,true);
		$criteria->compare('notafiscal',$this->notafiscal);
		$criteria->compare('alteracao',$this->alteracao,true);
		$criteria->compare('codusuarioalteracao',$this->codusuarioalteracao,true);
		$criteria->compare('criacao',$this->criacao,true);
		$criteria->compare('codusuariocriacao',$this->codusuariocriacao,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Pessoa the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
}

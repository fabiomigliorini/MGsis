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
 * @property EstadoCivil $codestadocivil
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
	/* @property boolean $enderecosdiferentes */
 	public $enderecosdiferentes;
	
	const NOTAFISCAL_TRATAMENTOPADRAO = 0;
	const NOTAFISCAL_SEMPRE = 1;
	const NOTAFISCAL_SOMENTE_FECHAMENTO = 2;
	const NOTAFISCAL_NUNCA = 9;

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
			array('pessoa, fantasia, cadastro, notafiscal', 'required'),
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
			array('notafiscal', 'in', 'range' => self::getNotaFiscalRange()),
			array('inativo, cliente, fornecedor, fisica, codsexo, consumidor, codestadocivil, codcidade, codcidadecobranca, codformapagamento, creditobloqueado, vendedor, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codpessoa, pessoa, fantasia, inativo, cnpj, codcidade, email, telefone1', 'safe', 'on'=>'search'),
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
			'Cidade' => array(self::BELONGS_TO, 'Cidade', 'codcidade'),
			'CidadeCobranca' => array(self::BELONGS_TO, 'Cidade', 'codcidadecobranca'),
			'EstadoCivil' => array(self::BELONGS_TO, 'EstadoCivil', 'codestadocivil'),
			'FormaPagamento' => array(self::BELONGS_TO, 'FormaPagamento', 'codformapagamento'),
			'Sexo' => array(self::BELONGS_TO, 'Sexo', 'codsexo'),
			'UsuarioAlteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
			'UsuarioCriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
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
			'codpessoa' => '#',
			'pessoa' => 'Razão Social',
			'fantasia' => 'Nome Fantasia',
			'cadastro' => 'Data do Cadastro',
			'inativo' => 'Inativo desde',
			'cliente' => 'Cliente',
			'fornecedor' => 'Fornecedor',
			'fisica' => 'Pessoa Física',
			'codsexo' => 'Sexo',
			'cnpj' => 'CNPJ/CPF',
			'ie' => 'Inscrição Estadual',
			'consumidor' => 'Consumidor Final',
			'contato' => 'Contato',
			'codestadocivil' => 'Estado Civil',
			'conjuge' => 'Conjuge',
			'endereco' => 'Endereço',
			'numero' => 'Número do Endereço',
			'complemento' => 'Complemento do Endereço',
			'codcidade' => 'Cidade',
			'bairro' => 'Bairro',
			'cep' => 'CEP',
			'enderecocobranca' => 'Endereço de Cobranca',
			'numerocobranca' => 'Número do Endereço de Cobranca',
			'complementocobranca' => 'Complemento do Endereço de Cobranca',
			'codcidadecobranca' => 'Cidade Cobranca',
			'bairrocobranca' => 'Bairro de Cobranca',
			'cepcobranca' => 'Cep de Cobranca',
			'telefone1' => 'Telefone',
			'telefone2' => 'Telefone 2',
			'telefone3' => 'Telefone 3',
			'email' => 'Email',
			'emailnfe' => 'Email para NFe',
			'emailcobranca' => 'Email para Cobranca',
			'codformapagamento' => 'Forma de Pagamento',
			'credito' => 'Limite de Credito',
			'creditobloqueado' => 'Credito Bloqueado',
			'observacoes' => 'Observações',
			'mensagemvenda' => 'Mensagem de Venda',
			'vendedor' => 'Vendedor',
			'rg' => 'RG',
			'desconto' => 'Desconto',
			'notafiscal' => 'Nota Fiscal',
			'alteracao' => 'Alteração',
			'codusuarioalteracao' => 'Usuario Alteração',
			'criacao' => 'Criação',
			'codusuariocriacao' => 'Usuario Criação',
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

		$criteria->compare('codpessoa',$this->codpessoa,false);
		
		if (!empty($this->fantasia))
		{
			$texto  = str_replace(' ', '%', trim($this->fantasia));
			$criteria->addCondition('t.fantasia ILIKE :fantasia OR t.pessoa ILIKE :fantasia');
			$criteria->params = array_merge($criteria->params, array(':fantasia' => '%'.$texto.'%'));
		}
		
		if (!empty($this->cnpj))
		{
			$criteria->addCondition('cast(t.Cnpj as char(20)) ILIKE :cnpj');
			$criteria->params = array_merge($criteria->params, array(':cnpj' => (int)MGFormatter::numeroLimpo($this->cnpj) .'%'));
		}

		switch ($this->inativo)
		{
			case 9:
				break;
			
			case 1:
				$criteria->addCondition('t.inativo is not null');
				break;
			
			default:
				$criteria->addCondition('t.inativo is null');
				break;
		}
		
		if (!empty($this->email))
		{
			$criteria->addCondition('t.email ILIKE :email OR t.emailnfe ILIKE :email OR t.emailcobranca ILIKE :email');
			$criteria->params = array_merge($criteria->params, array(':email' => '%'.$this->email.'%'));
		}

		if (!empty($this->telefone1))
		{
			$criteria->addCondition('t.telefone1 ILIKE :telefone OR t.telefone2 ILIKE :telefone OR t.telefone3 ILIKE :telefone');
			$criteria->params = array_merge($criteria->params, array(':telefone' => '%'.$this->telefone1.'%'));
		}

		if (!empty($this->codcidade))
		{
			$criteria->addCondition('t.codcidade = :codcidade OR t.codcidadecobranca = :codcidade');
			$criteria->params = array_merge($criteria->params, array(':codcidade' => $this->codcidade));
		}
		
		
		return new CActiveDataProvider($this, 
				array(
					'criteria'=>$criteria,
					'sort'=>array('defaultOrder'=>'fantasia ASC'),
				)
			);
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
	
	protected function afterFind()
	{
		if (
			($this->enderecocobranca    <>  $this->endereco   ) or 
			($this->numerocobranca      <>  $this->numero     ) or 
			($this->complementocobranca <>  $this->complemento) or 
			($this->bairrocobranca      <>  $this->bairro     ) or 
			($this->codcidadecobranca   <>  $this->codcidade  ) or 
			($this->cepcobranca         <>  $this->cep        ) 
		   )
			$this->enderecosdiferentes = true;
		else
			$this->enderecosdiferentes = false;
		
		return parent::afterFind();
	}
	
	public function getNotaFiscalOpcoes()
	{
		return array(
			self::NOTAFISCAL_TRATAMENTOPADRAO => "Tratamento Padrão",
			self::NOTAFISCAL_SEMPRE => "Sempre",
			self::NOTAFISCAL_SOMENTE_FECHAMENTO => "Somente no Fechamento",
			self::NOTAFISCAL_NUNCA => "Nunca Emitir",
		);
	}

	public function getNotaFiscalRange()
	{
		return array(
			self::NOTAFISCAL_TRATAMENTOPADRAO,
			self::NOTAFISCAL_SEMPRE,
			self::NOTAFISCAL_SOMENTE_FECHAMENTO,
			self::NOTAFISCAL_NUNCA,
		);
	}
	
	public function getNotaFiscalDescricao()
	{
		$opcoes=$this->getNotaFiscalOpcoes();
		if (!isset($this->notafiscal))
			return null;
		return isset($opcoes[$this->notafiscal]) ? $opcoes[$this->notafiscal] : "Tipo Desconhecido ({$this->notafiscal})";
	}

	
}
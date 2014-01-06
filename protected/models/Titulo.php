<?php

/**
 * This is the model class for table "mgsis.tbltitulo".
 *
 * The followings are the available columns in table 'mgsis.tbltitulo':
 * @property string $codtitulo
 * @property string $codtipotitulo
 * @property string $codfilial
 * @property string $codportador
 * @property string $codpessoa
 * @property string $codcontacontabil
 * @property string $numero
 * @property string $fatura
 * @property string $transacao
 * @property string $sistema
 * @property string $emissao
 * @property string $vencimento
 * @property string $vencimentooriginal
 * @property string $debito
 * @property string $credito
 * @property boolean $gerencial
 * @property string $observacao
 * @property boolean $boleto
 * @property string $nossonumero
 * @property string $debitototal
 * @property string $creditototal
 * @property string $saldo
 * @property string $debitosaldo
 * @property string $creditosaldo
 * @property string $transacaoliquidacao
 * @property string $codnegocioformapagamento
 * @property string $codtituloagrupamento
 * @property string $remessa
 * @property string $estornado
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property Movimentotitulo[] $movimentotitulos
 * @property Movimentotitulo[] $movimentotitulos1
 * @property Contacontabil $codcontacontabil
 * @property Filial $codfilial
 * @property Negocioformapagamento $codnegocioformapagamento
 * @property Pessoa $codpessoa
 * @property Portador $codportador
 * @property Tipotitulo $codtipotitulo
 * @property Tituloagrupamento $codtituloagrupamento
 * @property Usuario $codusuarioalteracao
 * @property Usuario $codusuariocriacao
 * @property Boletoretorno[] $boletoretornos
 * @property Cobranca[] $cobrancas
 * @property Cobrancahistoricotitulo[] $cobrancahistoricotitulos
 */
class Titulo extends MGActiveRecord
{
	
	public $vencimento_de;
	public $vencimento_ate;
	public $emissao_de;
	public $emissao_ate;
	public $criacao_de;
	public $criacao_ate;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tbltitulo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codtitulo, codtipotitulo, codfilial, codpessoa, codcontacontabil, numero, transacao, sistema, emissao, vencimento, vencimentooriginal', 'required'),
			array('numero, nossonumero', 'length', 'max'=>20),
			array('fatura', 'length', 'max'=>50),
			array('debito, credito, debitototal, creditototal, saldo, debitosaldo, creditosaldo', 'length', 'max'=>14),
			array('vencimento', 'date', 'format'=>Yii::app()->locale->getDateFormat('medium')),
			array('observacao', 'length', 'max'=>255),
			array('codportador, gerencial, boleto, transacaoliquidacao, codnegocioformapagamento, codtituloagrupamento, remessa, estornado, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('transacao','date','format'=>Yii::app()->locale->getDateFormat('medium')),
			//array('sistema','datetime'),
			array('sistema','date','format'=> strtr(Yii::app()->locale->getDateTimeFormat()
													, array("{0}" => Yii::app()->locale->getTimeFormat('medium')
															, "{1}" => Yii::app()->locale->getDateFormat('medium')))
				),
			
			array('codtitulo, vencimento_de, vencimento_ate, emissao_de, emissao_ate, criacao_de, criacao_ate, codtipotitulo, codfilial, codportador, codpessoa, codcontacontabil, numero, emissao, vencimento, credito, gerencial, boleto, nossonumero, saldo, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
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
			'MovimentoTitulos' => array(self::HAS_MANY, 'MovimentoTitulo', 'codtitulo'),
			'MovimentoTitulosRelacionado' => array(self::HAS_MANY, 'MovimentoTitulo', 'codtitulorelacionado'),
			'ContaContabil' => array(self::BELONGS_TO, 'ContaContabil', 'codcontacontabil'),
			'Filial' => array(self::BELONGS_TO, 'Filial', 'codfilial'),
			'NegocioFormaPagamento' => array(self::BELONGS_TO, 'NegocioFormaPagamento', 'codnegocioformapagamento'),
			'Pessoa' => array(self::BELONGS_TO, 'Pessoa', 'codpessoa'),
			'Portador' => array(self::BELONGS_TO, 'Portador', 'codportador'),
			'TipoTitulo' => array(self::BELONGS_TO, 'TipoTitulo', 'codtipotitulo'),
			'TituloAgrupamento' => array(self::BELONGS_TO, 'TituloAgrupamento', 'codtituloagrupamento'),
			'UsuarioAlteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
			'UsuarioCriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
			'BoletoRetornos' => array(self::HAS_MANY, 'BoletoRetorno', 'codtitulo'),
			'Cobrancas' => array(self::HAS_MANY, 'Cobranca', 'codtitulo'),
			'CobrancaHistoricoTitulos' => array(self::HAS_MANY, 'CobrancaHistoricoTitulo', 'codtitulo'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codtitulo' => '#',
			'codtipotitulo' => 'Tipo Titulo',
			'codfilial' => 'Filial',
			'codportador' => 'Portador',
			'codpessoa' => 'Pessoa',
			'codcontacontabil' => 'Conta Contabil',
			'numero' => 'Número',
			'fatura' => 'Fatura',
			'transacao' => 'Transação',
			'sistema' => 'Sistema',
			'emissao' => 'Emissão',
			'vencimento' => 'Vencimento',
			'vencimentooriginal' => 'Vencimento Original',
			'debito' => 'Débito',
			'credito' => 'Crédito',
			'gerencial' => 'Gerencial',
			'observacao' => 'Observação',
			'boleto' => 'Boleto',
			'nossonumero' => 'Nosso Número',
			'debitototal' => 'Débito Total',
			'creditototal' => 'Crédito Total',
			'saldo' => 'Saldo',
			'debitosaldo' => 'Saldo Débito',
			'creditosaldo' => 'Saldo Crédito',
			'transacaoliquidacao' => 'Transação Liquidacao',
			'codnegocioformapagamento' => 'Negócio Forma Pagamento',
			'codtituloagrupamento' => 'Título Agrupamento',
			'remessa' => 'Remessa',
			'estornado' => 'Estornado',
			'alteracao' => 'Alteração',
			'codusuarioalteracao' => 'Usuário Alteração',
			'criacao' => 'Criação',
			'codusuariocriacao' => 'Usuário Criação',
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

		$criteria->compare('t.codtitulo', $this->codtitulo, false);
		$criteria->compare('t.codfilial', $this->codfilial, false);
		$criteria->compare('t.codpessoa', $this->codpessoa, false);
		if (!empty($this->numero))
		{
			$texto  = str_replace(' ', '%', trim($this->numero));
			$criteria->addCondition('t.numero ILIKE :numero');
			$criteria->params = array_merge($criteria->params, array(':numero' => '%'.$texto.'%'));
		}
		if ($vencimento_de = DateTime::createFromFormat("d/m/y",$this->vencimento_de))
		{
			$criteria->addCondition('t.vencimento >= :vencimento_de');
			$criteria->params = array_merge($criteria->params, array(':vencimento_de' => $vencimento_de->format('Y-m-d').' 00:00:00.0'));
		}
		if ($vencimento_ate = DateTime::createFromFormat("d/m/y",$this->vencimento_ate))
		{
			$criteria->addCondition('t.vencimento <= :vencimento_ate');
			$criteria->params = array_merge($criteria->params, array(':vencimento_ate' => $vencimento_ate->format('Y-m-d').' 23:59:59.9'));
		}
		if ($emissao_de = DateTime::createFromFormat("d/m/y",$this->emissao_de))
		{
			$criteria->addCondition('t.emissao >= :emissao_de');
			$criteria->params = array_merge($criteria->params, array(':emissao_de' => $emissao_de->format('Y-m-d').' 00:00:00.0'));
		}
		if ($emissao_ate = DateTime::createFromFormat("d/m/y",$this->emissao_ate))
		{
			$criteria->addCondition('t.emissao <= :emissao_ate');
			$criteria->params = array_merge($criteria->params, array(':emissao_ate' => $emissao_ate->format('Y-m-d').' 23:59:59.9'));
		}
		if ($criacao_de = DateTime::createFromFormat("d/m/y",$this->criacao_de))
		{
			$criteria->addCondition('t.criacao >= :criacao_de');
			$criteria->params = array_merge($criteria->params, array(':criacao_de' => $criacao_de->format('Y-m-d').' 00:00:00.0'));
		}
		if ($criacao_ate = DateTime::createFromFormat("d/m/y",$this->criacao_ate))
		{
			$criteria->addCondition('t.criacao <= :criacao_ate');
			$criteria->params = array_merge($criteria->params, array(':criacao_ate' => $criacao_ate->format('Y-m-d').' 23:59:59.9'));
		}
		
		
		switch ($this->saldo) 
		{
			case 9:
				break;
			case 1:
				$criteria->addCondition('t.saldo = 0');
				break;
			default:
				$criteria->addCondition('t.saldo <> 0');
				break;
		}		
		
		switch ($this->credito) 
		{
			case 2:
				$criteria->addCondition('t.debito > 0');
				break;
			case 1:
				$criteria->addCondition('t.credito > 0');
				break;
		}
		
		switch ($this->boleto)
		{
			case 2:
				$criteria->addCondition('t.boleto = false');
				break;
			case 1:
				$criteria->addCondition('t.boleto = true');
				break;
		}

		if (!empty($this->nossonumero))
		{
			$texto  = str_replace(' ', '%', trim($this->nossonumero));
			$criteria->addCondition('t.nossonumero ILIKE :nossonumero');
			$criteria->params = array_merge($criteria->params, array(':nossonumero' => '%'.$texto.'%'));
		}
		
		$criteria->compare('t.codportador',$this->codportador,false);
		$criteria->compare('t.codcontacontabil',$this->codcontacontabil,false);
		$criteria->compare('t.codtipotitulo',$this->codtipotitulo,false);
		
		switch ($this->gerencial)
		{
			case 2:
				$criteria->addCondition('t.gerencial = false');
				break;
			case 1:
				$criteria->addCondition('t.gerencial = true');
				break;
		}
		$criteria->compare('codusuariocriacao',$this->codusuariocriacao,false);
		
        $criteria->with = array(
				'Pessoa' => array('select' => '"Pessoa".fantasia'),
				'Filial' => array('select' => '"Filial".filial'),
				'Portador' => array('select' => '"Portador".portador'),
				'UsuarioCriacao' => array('select' => '"UsuarioCriacao".usuario'),
				'UsuarioAlteracao' => array('select' => '"UsuarioAlteracao".usuario'),
				'ContaContabil' => array('select' => '"ContaContabil".contacontabil'),
				'TipoTitulo' => array('select' => '"TipoTitulo".tipotitulo'),
			);
	
		$criteria->select = 't.codtitulo, t.vencimento, t.emissao, t.codfilial, t.numero, t.codportador, t.credito, t.debito, t.saldo, t.codtipotitulo, t.codcontacontabil, t.codusuariocriacao, t.nossonumero, t.gerencial, t.codpessoa, t.codusuarioalteracao';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array('defaultOrder'=>'"Pessoa".fantasia ASC, t.vencimento ASC, t.saldo ASC'),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Titulo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

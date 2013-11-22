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
			
			array('codtitulo, codtipotitulo, codfilial, codportador, codpessoa, codcontacontabil, numero, fatura, transacao, sistema, emissao, vencimento, vencimentooriginal, debito, credito, gerencial, observacao, boleto, nossonumero, debitototal, creditototal, saldo, debitosaldo, creditosaldo, transacaoliquidacao, codnegocioformapagamento, codtituloagrupamento, remessa, estornado, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
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
			'movimentotitulos' => array(self::HAS_MANY, 'Movimentotitulo', 'codtitulo'),
			'movimentotitulos1' => array(self::HAS_MANY, 'Movimentotitulo', 'codtitulorelacionado'),
			'codcontacontabil' => array(self::BELONGS_TO, 'Contacontabil', 'codcontacontabil'),
			'codfilial' => array(self::BELONGS_TO, 'Filial', 'codfilial'),
			'codnegocioformapagamento' => array(self::BELONGS_TO, 'Negocioformapagamento', 'codnegocioformapagamento'),
			'codpessoa' => array(self::BELONGS_TO, 'Pessoa', 'codpessoa'),
			'codportador' => array(self::BELONGS_TO, 'Portador', 'codportador'),
			'codtipotitulo' => array(self::BELONGS_TO, 'Tipotitulo', 'codtipotitulo'),
			'codtituloagrupamento' => array(self::BELONGS_TO, 'Tituloagrupamento', 'codtituloagrupamento'),
			'codusuarioalteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
			'codusuariocriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
			'boletoretornos' => array(self::HAS_MANY, 'Boletoretorno', 'codtitulo'),
			'cobrancas' => array(self::HAS_MANY, 'Cobranca', 'codtitulo'),
			'cobrancahistoricotitulos' => array(self::HAS_MANY, 'Cobrancahistoricotitulo', 'codtitulo'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codtitulo' => 'Codtitulo',
			'codtipotitulo' => 'Codtipotitulo',
			'codfilial' => 'Codfilial',
			'codportador' => 'Codportador',
			'codpessoa' => 'Codpessoa',
			'codcontacontabil' => 'Codcontacontabil',
			'numero' => 'Numero',
			'fatura' => 'Fatura',
			'transacao' => 'Transacao',
			'sistema' => 'Sistema',
			'emissao' => 'Emissao',
			'vencimento' => 'Vencimento',
			'vencimentooriginal' => 'Vencimentooriginal',
			'debito' => 'Debito',
			'credito' => 'Credito',
			'gerencial' => 'Gerencial',
			'observacao' => 'Observacao',
			'boleto' => 'Boleto',
			'nossonumero' => 'Nossonumero',
			'debitototal' => 'Debitototal',
			'creditototal' => 'Creditototal',
			'saldo' => 'Saldo',
			'debitosaldo' => 'Debitosaldo',
			'creditosaldo' => 'Creditosaldo',
			'transacaoliquidacao' => 'Transacaoliquidacao',
			'codnegocioformapagamento' => 'Codnegocioformapagamento',
			'codtituloagrupamento' => 'Codtituloagrupamento',
			'remessa' => 'Remessa',
			'estornado' => 'Estornado',
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

		$criteria->compare('codtitulo',$this->codtitulo,true);
		$criteria->compare('codtipotitulo',$this->codtipotitulo,true);
		$criteria->compare('codfilial',$this->codfilial,true);
		$criteria->compare('codportador',$this->codportador,true);
		$criteria->compare('codpessoa',$this->codpessoa,true);
		$criteria->compare('codcontacontabil',$this->codcontacontabil,true);
		$criteria->compare('numero',$this->numero,true);
		$criteria->compare('fatura',$this->fatura,true);
		$criteria->compare('transacao',$this->transacao,true);
		$criteria->compare('sistema',$this->sistema,true);
		$criteria->compare('emissao',$this->emissao,true);
		$criteria->compare('vencimento',$this->vencimento,true);
		$criteria->compare('vencimentooriginal',$this->vencimentooriginal,true);
		$criteria->compare('debito',$this->debito,true);
		$criteria->compare('credito',$this->credito,true);
		$criteria->compare('gerencial',$this->gerencial);
		$criteria->compare('observacao',$this->observacao,true);
		$criteria->compare('boleto',$this->boleto);
		$criteria->compare('nossonumero',$this->nossonumero,true);
		$criteria->compare('debitototal',$this->debitototal,true);
		$criteria->compare('creditototal',$this->creditototal,true);
		$criteria->compare('saldo',$this->saldo,true);
		$criteria->compare('debitosaldo',$this->debitosaldo,true);
		$criteria->compare('creditosaldo',$this->creditosaldo,true);
		$criteria->compare('transacaoliquidacao',$this->transacaoliquidacao,true);
		$criteria->compare('codnegocioformapagamento',$this->codnegocioformapagamento,true);
		$criteria->compare('codtituloagrupamento',$this->codtituloagrupamento,true);
		$criteria->compare('remessa',$this->remessa,true);
		$criteria->compare('estornado',$this->estornado,true);
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
	 * @return Titulo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

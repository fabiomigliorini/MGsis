<?php

/**
 * This is the model class for table "mgsis.tblstonetransacao".
 *
 * The followings are the available columns in table 'mgsis.tblstonetransacao':
 * @property string $codstonetransacao
 * @property string $codstonefilial
 * @property string $siclostransactionid
 * @property string $stonetransactionid
 * @property string $codstonepretransacao
 * @property integer $status
 * @property string $valor
 * @property string $valorliquido
 * @property integer $parcelas
 * @property string $codstonebandeira
 * @property string $pagador
 * @property string $numerocartao
 * @property string $autorizacao
 * @property integer $tipo
 * @property boolean $conciliada
 * @property string $criacao
 * @property string $codusuariocriacao
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $inativo
 *
 * The followings are the available model relations:
 * @property Negocioformapagamento[] $negocioformapagamentos
 * @property Stonepretransacao $codstonepretransacao
 * @property Stonebandeira $codstonebandeira
 * @property Stonefilial $codstonefilial
 * @property Usuario $codusuariocriacao
 * @property Usuario $codusuarioalteracao
 * @property Stonetransacaoparcela[] $stonetransacaoparcelas
 */
class StoneTransacao extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblstonetransacao';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codstonefilial', 'required'),
			array('status, parcelas, tipo', 'numerical', 'integerOnly'=>true),
			array('siclostransactionid, stonetransactionid, pagador, autorizacao', 'length', 'max'=>200),
			array('valor, valorliquido', 'length', 'max'=>14),
			array('numerocartao', 'length', 'max'=>20),
			array('codstonepretransacao, codstonebandeira, conciliada, criacao, codusuariocriacao, alteracao, codusuarioalteracao, inativo', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codstonetransacao, codstonefilial, siclostransactionid, stonetransactionid, codstonepretransacao, status, valor, valorliquido, parcelas, codstonebandeira, pagador, numerocartao, autorizacao, tipo, conciliada, criacao, codusuariocriacao, alteracao, codusuarioalteracao, inativo', 'safe', 'on'=>'search'),
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
			'NegocioFormaPagamentos' => array(self::HAS_MANY, 'NegocioFormaPagamento', 'codstonetransacao'),
			'StonePreTransacao' => array(self::BELONGS_TO, 'StonePreTransacao', 'codstonepretransacao'),
			'StoneBandeira' => array(self::BELONGS_TO, 'StoneBandeira', 'codstonebandeira'),
			'StoneFilial' => array(self::BELONGS_TO, 'StoneFilial', 'codstonefilial'),
			'UsuarioCriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
			'UsuarioAlteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
			'StoneTransacaoParcelas' => array(self::HAS_MANY, 'StoneTransacaoParcela', 'codstonetransacao'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codstonetransacao' => 'Codstonetransacao',
			'codstonefilial' => 'establishment_id',
			'siclostransactionid' => 'siclos_transaction_id',
			'stonetransactionid' => 'stone_transaction_id',
			'codstonepretransacao' => 'pre_transaction_id',
			'status' => 'transaction_status\n0 - Rejeitada / Cancelada\n1 - Aprovada',
			'valor' => 'transaction_amount',
			'valorliquido' => 'transaction_net_amount - previsao',
			'parcelas' => 'installment_number',
			'codstonebandeira' => 'card_brand',
			'pagador' => 'card_holder_name',
			'numerocartao' => 'card_number',
			'autorizacao' => 'transaction_authorization_code',
			'tipo' => 'payment_type\n1 - Debito\n2 - Credito\n3 - Voucher',
			'conciliada' => 'conciliation - se foi conciliada com a adquirente',
			'criacao' => 'created_at',
			'codusuariocriacao' => 'Codusuariocriacao',
			'alteracao' => 'Alteracao',
			'codusuarioalteracao' => 'Codusuarioalteracao',
			'inativo' => 'Inativo',
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

		$criteria->compare('codstonetransacao',$this->codstonetransacao,true);
		$criteria->compare('codstonefilial',$this->codstonefilial,true);
		$criteria->compare('siclostransactionid',$this->siclostransactionid,true);
		$criteria->compare('stonetransactionid',$this->stonetransactionid,true);
		$criteria->compare('codstonepretransacao',$this->codstonepretransacao,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('valor',$this->valor,true);
		$criteria->compare('valorliquido',$this->valorliquido,true);
		$criteria->compare('parcelas',$this->parcelas);
		$criteria->compare('codstonebandeira',$this->codstonebandeira,true);
		$criteria->compare('pagador',$this->pagador,true);
		$criteria->compare('numerocartao',$this->numerocartao,true);
		$criteria->compare('autorizacao',$this->autorizacao,true);
		$criteria->compare('tipo',$this->tipo);
		$criteria->compare('conciliada',$this->conciliada);
		$criteria->compare('criacao',$this->criacao,true);
		$criteria->compare('codusuariocriacao',$this->codusuariocriacao,true);
		$criteria->compare('alteracao',$this->alteracao,true);
		$criteria->compare('codusuarioalteracao',$this->codusuarioalteracao,true);
		$criteria->compare('inativo',$this->inativo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return StoneTransacao the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

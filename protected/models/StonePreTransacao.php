<?php

/**
 * This is the model class for table "mgsis.tblstonepretransacao".
 *
 * The followings are the available columns in table 'mgsis.tblstonepretransacao':
 * @property string $codstonepretransacao
 * @property string $codstonefilial
 * @property string $codstonepos
 * @property string $pretransactionid
 * @property string $valor
 * @property string $titulo
 * @property integer $tipo
 * @property integer $parcelas
 * @property integer $tipoparcelamento
 * @property boolean $processada
 * @property boolean $ativa
 * @property string $token
 * @property string $status
 * @property string $criacao
 * @property string $codusuariocriacao
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $inativo
 * @property string $codnegocio
 *
 * The followings are the available model relations:
 * @property Stonefilial $codstonefilial
 * @property Stonepos $codstonepos
 * @property Usuario $codusuariocriacao
 * @property Usuario $codusuarioalteracao
 * @property Negocio $codnegocio
 * @property Stonetransacao[] $stonetransacaos
 */
class StonePreTransacao extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblstonepretransacao';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codstonefilial, valor', 'required'),
			array('tipo, parcelas, tipoparcelamento', 'numerical', 'integerOnly'=>true),
			array('pretransactionid, titulo', 'length', 'max'=>200),
			array('valor', 'length', 'max'=>14),
			array('status', 'length', 'max'=>10),
			array('codstonepos, processada, ativa, token, criacao, codusuariocriacao, alteracao, codusuarioalteracao, inativo, codnegocio', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codstonepretransacao, codstonefilial, codstonepos, pretransactionid, valor, titulo, tipo, parcelas, tipoparcelamento, processada, ativa, token, status, criacao, codusuariocriacao, alteracao, codusuarioalteracao, inativo, codnegocio', 'safe', 'on'=>'search'),
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
			'StoneFilial' => array(self::BELONGS_TO, 'StoneFilial', 'codstonefilial'),
			'StonePos' => array(self::BELONGS_TO, 'StonePos', 'codstonepos'),
			'UsuarioCriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
			'UsuarioAlteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
			'Negocio' => array(self::BELONGS_TO, 'Negocio', 'codnegocio'),
			'StoneTransacaos' => array(self::HAS_MANY, 'StoneTransacao', 'codstonepretransacao'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codstonepretransacao' => 'Codstonepretransacao',
			'codstonefilial' => 'establishment_id',
			'codstonepos' => 'pos_reference_id',
			'pretransactionid' => 'pre_transaction_id',
			'valor' => 'amount',
			'titulo' => 'information_title',
			'tipo' => 'payment.type\n1 - Debito\n2 - Credito\n3 - Voucher',
			'parcelas' => 'payment.installment\nSomente para tipo 2 - Credito\nPossivel de 2 a 12 vezes',
			'tipoparcelamento' => 'somente para tipo 2 - Credito, com numero de parcelas preenchidas\n1 - Sem Juros (Padrao)\n2 - Com Juros',
			'processada' => 'processed - se ja passou pelo POS',
			'ativa' => 'is_active',
			'token' => 'pre_transaction_token',
			'status' => 'created\navailable - disponivel na listagem da maquininha\nprocessing - selecionada para ser paga\nundone - desfeita, cancelada, desistiu',
			'criacao' => 'created_at',
			'codusuariocriacao' => 'Codusuariocriacao',
			'alteracao' => 'Alteracao',
			'codusuarioalteracao' => 'Codusuarioalteracao',
			'inativo' => 'Inativo',
			'codnegocio' => 'Codnegocio',
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

		$criteria->compare('codstonepretransacao',$this->codstonepretransacao,true);
		$criteria->compare('codstonefilial',$this->codstonefilial,true);
		$criteria->compare('codstonepos',$this->codstonepos,true);
		$criteria->compare('pretransactionid',$this->pretransactionid,true);
		$criteria->compare('valor',$this->valor,true);
		$criteria->compare('titulo',$this->titulo,true);
		$criteria->compare('tipo',$this->tipo);
		$criteria->compare('parcelas',$this->parcelas);
		$criteria->compare('tipoparcelamento',$this->tipoparcelamento);
		$criteria->compare('processada',$this->processada);
		$criteria->compare('ativa',$this->ativa);
		$criteria->compare('token',$this->token,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('criacao',$this->criacao,true);
		$criteria->compare('codusuariocriacao',$this->codusuariocriacao,true);
		$criteria->compare('alteracao',$this->alteracao,true);
		$criteria->compare('codusuarioalteracao',$this->codusuarioalteracao,true);
		$criteria->compare('inativo',$this->inativo,true);
		$criteria->compare('codnegocio',$this->codnegocio,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return StonePreTransacao the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

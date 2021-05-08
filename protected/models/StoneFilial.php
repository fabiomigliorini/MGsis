<?php

/**
 * This is the model class for table "mgsis.tblstonefilial".
 *
 * The followings are the available columns in table 'mgsis.tblstonefilial':
 * @property string $codstonefilial
 * @property string $codfilial
 * @property string $chaveprivada
 * @property string $token
 * @property string $datatoken
 * @property string $stonecode
 * @property string $establishmentid
 * @property boolean $disponivelloja
 * @property string $criacao
 * @property string $codusuariocriacao
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $inativo
 *
 * The followings are the available model relations:
 * @property Stonepretransacao[] $stonepretransacaos
 * @property Stonepos[] $stoneposes
 * @property Filial $codfilial
 * @property Usuario $codusuariocriacao
 * @property Usuario $codusuarioalteracao
 * @property Stonetransacao[] $stonetransacaos
 */
class StoneFilial extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblstonefilial';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codfilial', 'required'),
			array('chaveprivada', 'length', 'max'=>100),
			array('token', 'length', 'max'=>500),
			array('stonecode', 'length', 'max'=>20),
			array('datatoken, establishmentid, disponivelloja, criacao, codusuariocriacao, alteracao, codusuarioalteracao, inativo', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codstonefilial, codfilial, chaveprivada, token, datatoken, stonecode, establishmentid, disponivelloja, criacao, codusuariocriacao, alteracao, codusuarioalteracao, inativo', 'safe', 'on'=>'search'),
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
			'StonePreTransacaos' => array(self::HAS_MANY, 'StonePreTransacao', 'codstonefilial'),
			'StonePoss' => array(self::HAS_MANY, 'StonePos', 'codstonefilial'),
			'Filial' => array(self::BELONGS_TO, 'Filial', 'codfilial'),
			'UsuarioCriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
			'UsuarioAlteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
			'StoneTransacaos' => array(self::HAS_MANY, 'StoneTransacao', 'codstonefilial'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codstonefilial' => 'Codstonefilial',
			'codfilial' => 'Codfilial',
			'chaveprivada' => 'Chaveprivada',
			'token' => 'Token',
			'datatoken' => 'Datatoken',
			'stonecode' => 'Stonecode',
			'establishmentid' => 'establishment.id',
			'disponivelloja' => 'mamba_released',
			'criacao' => 'Criacao',
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

		$criteria->compare('codstonefilial',$this->codstonefilial,true);
		$criteria->compare('codfilial',$this->codfilial,true);
		$criteria->compare('chaveprivada',$this->chaveprivada,true);
		$criteria->compare('token',$this->token,true);
		$criteria->compare('datatoken',$this->datatoken,true);
		$criteria->compare('stonecode',$this->stonecode,true);
		$criteria->compare('establishmentid',$this->establishmentid,true);
		$criteria->compare('disponivelloja',$this->disponivelloja);
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
	 * @return StoneFilial the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

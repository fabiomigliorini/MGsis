<?php

/**
 * This is the model class for table "mgsis.tblstonepos".
 *
 * The followings are the available columns in table 'mgsis.tblstonepos':
 * @property string $codstonepos
 * @property string $codstonefilial
 * @property string $apelido
 * @property string $referenceid
 * @property string $serialnumber
 * @property boolean $islinked
 * @property string $criacao
 * @property string $codusuariocriacao
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $inativo
 *
 * The followings are the available model relations:
 * @property Stonepretransacao[] $stonepretransacaos
 * @property Usuario $codusuariocriacao
 * @property Usuario $codusuarioalteracao
 * @property Stonefilial $codstonefilial
 */
class StonePos extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblstonepos';
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
			array('apelido', 'length', 'max'=>50),
			array('referenceid, serialnumber', 'length', 'max'=>200),
			array('islinked, criacao, codusuariocriacao, alteracao, codusuarioalteracao, inativo', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codstonepos, codstonefilial, apelido, referenceid, serialnumber, islinked, criacao, codusuariocriacao, alteracao, codusuarioalteracao, inativo', 'safe', 'on'=>'search'),
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
			'StonePreTransacaos' => array(self::HAS_MANY, 'StonePreTransacao', 'codstonepos'),
			'UsuarioCriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
			'UsuarioAlteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
			'StoneFilial' => array(self::BELONGS_TO, 'StoneFilial', 'codstonefilial'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codstonepos' => 'Codstonepos',
			'codstonefilial' => 'Codstonefilial',
			'apelido' => 'Apelido',
			'referenceid' => 'available_pos_list.pos_reference_id',
			'serialnumber' => 'available_pos_list.pos_serial_number',
			'islinked' => 'Islinked',
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

		$criteria->compare('codstonepos',$this->codstonepos,true);
		$criteria->compare('codstonefilial',$this->codstonefilial,true);
		$criteria->compare('apelido',$this->apelido,true);
		$criteria->compare('referenceid',$this->referenceid,true);
		$criteria->compare('serialnumber',$this->serialnumber,true);
		$criteria->compare('islinked',$this->islinked);
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
	 * @return StonePos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

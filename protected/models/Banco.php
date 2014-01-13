<?php

/**
 * This is the model class for table "mgsis.tblbanco".
 *
 * The followings are the available columns in table 'mgsis.tblbanco':
 * @property string $codbanco
 * @property string $banco
 * @property string $sigla
 * @property string $numerobanco
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property Portador[] $portadors
 * @property Usuario $codusuarioalteracao
 * @property Usuario $codusuariocriacao
 * @property Cheque[] $cheques
 */
class Banco extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblbanco';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codbanco', 'required'),
			array('banco', 'length', 'max'=>50),
			array('sigla', 'length', 'max'=>3),
			array('numerobanco, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codbanco, banco, sigla, numerobanco, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
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
			'portadors' => array(self::HAS_MANY, 'Portador', 'codbanco'),
			'codusuarioalteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
			'codusuariocriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
			'cheques' => array(self::HAS_MANY, 'Cheque', 'codbanco'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codbanco' => 'Codbanco',
			'banco' => 'Banco',
			'sigla' => 'Sigla',
			'numerobanco' => 'Numerobanco',
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

		$criteria->compare('codbanco',$this->codbanco,true);
		$criteria->compare('banco',$this->banco,true);
		$criteria->compare('sigla',$this->sigla,true);
		$criteria->compare('numerobanco',$this->numerobanco,true);
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
	 * @return Banco the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

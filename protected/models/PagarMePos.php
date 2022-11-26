<?php

/**
 * This is the model class for table "mgsis.tblpagarmepos".
 *
 * The followings are the available columns in table 'mgsis.tblpagarmepos':
 * @property string $codpagarmepos
 * @property string $codfilial
 * @property string $serial
 * @property string $apelido
 * @property string $criacao
 * @property string $codusuariocriacao
 * @property string $alteracao
 * @property string $codusuarioalteracao
 *
 * The followings are the available model relations:
 * @property Filial $codfilial
 * @property Usuario $codusuariocriacao
 * @property Usuario $codusuarioalteracao
 * @property Pagarmepagamento[] $pagarmepagamentos
 * @property Pagarmepedido[] $pagarmepedidos
 */
class PagarMePos extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblpagarmepos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codfilial, serial, apelido', 'required'),
			array('serial', 'length', 'max'=>50),
			array('apelido', 'length', 'max'=>20),
			array('criacao, codusuariocriacao, alteracao, codusuarioalteracao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codpagarmepos, codfilial, serial, apelido, criacao, codusuariocriacao, alteracao, codusuarioalteracao', 'safe', 'on'=>'search'),
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
			'Filial' => array(self::BELONGS_TO, 'Filial', 'codfilial'),
			'UsuarioCriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
			'UsuarioAlteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
			'PagarMePagamentos' => array(self::HAS_MANY, 'PagarMePagamento', 'codpagarmepos'),
			'PagarMePedidos' => array(self::HAS_MANY, 'PagarMePedido', 'codpagarmepos'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codpagarmepos' => '#',
			'codfilial' => 'Filial',
			'serial' => 'Serial',
			'apelido' => 'Apelido',
			'criacao' => 'Criação',
			'codusuariocriacao' => 'Usuario Criação',
			'alteracao' => 'Alteração',
			'codusuarioalteracao' => 'Usuario Alteração',
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

		$criteria->compare('codpagarmepos',$this->codpagarmepos,true);
		$criteria->compare('codfilial',$this->codfilial,true);
		$criteria->compare('serial',$this->serial,true);
		$criteria->compare('apelido',$this->apelido,true);
		$criteria->compare('criacao',$this->criacao,true);
		$criteria->compare('codusuariocriacao',$this->codusuariocriacao,true);
		$criteria->compare('alteracao',$this->alteracao,true);
		$criteria->compare('codusuarioalteracao',$this->codusuarioalteracao,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PagarMePos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

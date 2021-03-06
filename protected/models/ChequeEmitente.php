<?php

/**
 * This is the model class for table "mgsis.tblchequeemitente".
 *
 * The followings are the available columns in table 'mgsis.tblchequeemitente':
 * @property string $codchequeemitente
 * @property string $codcheque
 * @property string $cnpj
 * @property string $emitente
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property Cheque $Cheque
 * @property Usuario $UsuarioAlteracao
 * @property Usuario $UsuarioCriacao
 */
class ChequeEmitente extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblchequeemitente';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codchequeemitente, codcheque, cnpj, emitente', 'required'),
			array('cnpj', 'length', 'max'=>14),
			array('emitente', 'length', 'max'=>100),
			array('alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codchequeemitente, codcheque, cnpj, emitente, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
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
			'Cheque' => array(self::BELONGS_TO, 'Cheque', 'codcheque'),
			'UsuarioAlteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
			'UsuarioCriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codchequeemitente' => '#',
			'codcheque' => 'Cheque',
			'cnpj' => 'CNPJ',
			'emitente' => 'Emitente',
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

		$criteria->compare('codchequeemitente',$this->codchequeemitente,true);
		$criteria->compare('codcheque',$this->codcheque,true);
		$criteria->compare('cnpj',$this->cnpj,true);
		$criteria->compare('emitente',$this->emitente,true);
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
	 * @return ChequeEmitente the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

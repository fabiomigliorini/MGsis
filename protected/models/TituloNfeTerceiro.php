<?php

/**
 * This is the model class for table "mgsis.tbltitulonfeterceiro".
 *
 * The followings are the available columns in table 'mgsis.tbltitulonfeterceiro':
 * @property string $codtitulonfeterceiro
 * @property string $codtitulo
 * @property string $codnfeterceiro
 * @property string $codusuariocriacao
 * @property string $codusuarioalteracao
 * @property string $alteracao
 * @property string $criacao
 *
 * The followings are the available model relations:
 * @property Titulo $codtitulo
 * @property Usuario $codusuariocriacao
 * @property Usuario $codusuarioalteracao
 * @property Nfeterceiro $codnfeterceiro
 */
class TituloNfeTerceiro extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tbltitulonfeterceiro';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codtitulo, codnfeterceiro', 'required'),
			array('alteracao, criacao', 'length', 'max'=>6),
			array('codusuariocriacao, codusuarioalteracao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codtitulonfeterceiro, codtitulo, codnfeterceiro, codusuariocriacao, codusuarioalteracao, alteracao, criacao', 'safe', 'on'=>'search'),
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
			'Titulo' => array(self::BELONGS_TO, 'Titulo', 'codtitulo'),
			'UsuarioCriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
			'UsuarioAlteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
			'NfeTerceiro' => array(self::BELONGS_TO, 'NfeTerceiro', 'codnfeterceiro'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codtitulonfeterceiro' => 'Codtitulonfeterceiro',
			'codtitulo' => 'Codtitulo',
			'codnfeterceiro' => 'Codnfeterceiro',
			'codusuariocriacao' => 'Codusuariocriacao',
			'codusuarioalteracao' => 'Codusuarioalteracao',
			'alteracao' => 'Alteracao',
			'criacao' => 'Criacao',
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

		$criteria->compare('codtitulonfeterceiro',$this->codtitulonfeterceiro,true);
		$criteria->compare('codtitulo',$this->codtitulo,true);
		$criteria->compare('codnfeterceiro',$this->codnfeterceiro,true);
		$criteria->compare('codusuariocriacao',$this->codusuariocriacao,true);
		$criteria->compare('codusuarioalteracao',$this->codusuarioalteracao,true);
		$criteria->compare('alteracao',$this->alteracao,true);
		$criteria->compare('criacao',$this->criacao,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TituloNfeTerceiro the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

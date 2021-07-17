<?php

/**
 * This is the model class for table "mgsis.tbldistribuicaodfe".
 *
 * The followings are the available columns in table 'mgsis.tbldistribuicaodfe':
 * @property string $coddistribuicaodfe
 * @property string $codfilial
 * @property string $nsu
 * @property string $criacao
 * @property string $codusuariocriacao
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $nfechave
 * @property string $coddfetipo
 * @property string $data
 * @property string $coddistribuicaodfeevento
 * @property string $codnotafiscalterceiro
 * @property string $codnfeterceiro
 *
 * The followings are the available model relations:
 * @property Dfetipo $coddfetipo
 * @property Distribuicaodfeevento $coddistribuicaodfeevento
 * @property Filial $codfilial
 * @property Nfeterceiro $codnfeterceiro
 * @property Notafiscalterceiro $codnotafiscalterceiro
 */
class DistribuicaoDfe extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tbldistribuicaodfe';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codfilial, nsu, coddfetipo', 'required'),
			array('nsu', 'length', 'max'=>50),
			array('nfechave', 'length', 'max'=>100),
			array('criacao, codusuariocriacao, alteracao, codusuarioalteracao, data, coddistribuicaodfeevento, codnotafiscalterceiro, codnfeterceiro', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('coddistribuicaodfe, codfilial, nsu, criacao, codusuariocriacao, alteracao, codusuarioalteracao, nfechave, coddfetipo, data, coddistribuicaodfeevento, codnotafiscalterceiro, codnfeterceiro', 'safe', 'on'=>'search'),
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
			'DfeTipo' => array(self::BELONGS_TO, 'DfeTipo', 'coddfetipo'),
			'DistribuicaoDfeEvento' => array(self::BELONGS_TO, 'DistribuicaoDfeEvento', 'coddistribuicaodfeevento'),
			'Filial' => array(self::BELONGS_TO, 'Filial', 'codfilial'),
			'NfeTerceiro' => array(self::BELONGS_TO, 'NfeTerceiro', 'codnfeterceiro'),
			'NotaFiscalTerceiro' => array(self::BELONGS_TO, 'NotaFiscalTerceiro', 'codnotafiscalterceiro'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'coddistribuicaodfe' => 'Coddistribuicaodfe',
			'codfilial' => 'Codfilial',
			'nsu' => 'Nsu',
			'criacao' => 'Criacao',
			'codusuariocriacao' => 'Codusuariocriacao',
			'alteracao' => 'Alteracao',
			'codusuarioalteracao' => 'Codusuarioalteracao',
			'nfechave' => 'Nfechave',
			'coddfetipo' => 'Coddfetipo',
			'data' => 'dhevento',
			'coddistribuicaodfeevento' => 'Coddistribuicaodfeevento',
			'codnotafiscalterceiro' => 'Codnotafiscalterceiro',
			'codnfeterceiro' => 'Codnfeterceiro',
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

		$criteria->compare('coddistribuicaodfe',$this->coddistribuicaodfe,true);
		$criteria->compare('codfilial',$this->codfilial,true);
		$criteria->compare('nsu',$this->nsu,true);
		$criteria->compare('criacao',$this->criacao,true);
		$criteria->compare('codusuariocriacao',$this->codusuariocriacao,true);
		$criteria->compare('alteracao',$this->alteracao,true);
		$criteria->compare('codusuarioalteracao',$this->codusuarioalteracao,true);
		$criteria->compare('nfechave',$this->nfechave,true);
		$criteria->compare('coddfetipo',$this->coddfetipo,true);
		$criteria->compare('data',$this->data,true);
		$criteria->compare('coddistribuicaodfeevento',$this->coddistribuicaodfeevento,true);
		$criteria->compare('codnotafiscalterceiro',$this->codnotafiscalterceiro,true);
		$criteria->compare('codnfeterceiro',$this->codnfeterceiro,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DistribuicaoDfe the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

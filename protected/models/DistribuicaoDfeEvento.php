<?php

/**
 * This is the model class for table "mgsis.tbldistribuicaodfeevento".
 *
 * The followings are the available columns in table 'mgsis.tbldistribuicaodfeevento':
 * @property string $coddistribuicaodfeevento
 * @property integer $orgao
 * @property string $cnpj
 * @property string $cpf
 * @property string $descricao
 * @property string $coddfeevento
 * @property integer $sequencia
 * @property string $recebimento
 * @property string $protocolo
 * @property string $criacao
 * @property string $codusuariocriacao
 * @property string $alteracao
 * @property string $codusuarioalteracao
 *
 * The followings are the available model relations:
 * @property Dfeevento $coddfeevento
 * @property Usuario $codusuariocriacao
 * @property Usuario $codusuarioalteracao
 * @property Distribuicaodfe[] $distribuicaodves
 */
class DistribuicaoDfeEvento extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tbldistribuicaodfeevento';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('coddfeevento', 'required'),
			array('orgao, sequencia', 'numerical', 'integerOnly'=>true),
			array('cnpj', 'length', 'max'=>14),
			array('cpf', 'length', 'max'=>11),
			array('protocolo', 'length', 'max'=>15),
			array('descricao, recebimento, criacao, codusuariocriacao, alteracao, codusuarioalteracao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('coddistribuicaodfeevento, orgao, cnpj, cpf, descricao, coddfeevento, sequencia, recebimento, protocolo, criacao, codusuariocriacao, alteracao, codusuarioalteracao', 'safe', 'on'=>'search'),
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
			'DfeEvento' => array(self::BELONGS_TO, 'DfeEvento', 'coddfeevento'),
			'UsuarioCriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
			'UsuarioAlteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
			'DistribuicaoDfes' => array(self::HAS_MANY, 'DistribuicaoDfe', 'coddistribuicaodfeevento'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'coddistribuicaodfeevento' => 'Coddistribuicaodfeevento',
			'orgao' => 'corgao',
			'cnpj' => 'Cnpj',
			'cpf' => 'Cpf',
			'descricao' => 'xCorrecao',
			'coddfeevento' => 'tpEvento',
			'sequencia' => 'nSeqEvento',
			'recebimento' => 'dhRecbto',
			'protocolo' => 'nProt',
			'criacao' => 'Criacao',
			'codusuariocriacao' => 'Codusuariocriacao',
			'alteracao' => 'Alteracao',
			'codusuarioalteracao' => 'Codusuarioalteracao',
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

		$criteria->compare('coddistribuicaodfeevento',$this->coddistribuicaodfeevento,true);
		$criteria->compare('orgao',$this->orgao);
		$criteria->compare('cnpj',$this->cnpj,true);
		$criteria->compare('cpf',$this->cpf,true);
		$criteria->compare('descricao',$this->descricao,true);
		$criteria->compare('coddfeevento',$this->coddfeevento,true);
		$criteria->compare('sequencia',$this->sequencia);
		$criteria->compare('recebimento',$this->recebimento,true);
		$criteria->compare('protocolo',$this->protocolo,true);
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
	 * @return DistribuicaoDfeEvento the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

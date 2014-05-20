<?php

/**
 * This is the model class for table "mgsis.tblestado".
 *
 * The followings are the available columns in table 'mgsis.tblestado':
 * @property string $codestado
 * @property string $codpais
 * @property string $estado
 * @property string $sigla
 * @property string $codigooficial
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property TributacaoNaturezaOperacao[] $TributacaoNaturezaOperacaos
 * @property Cidade[] $Cidades
 * @property Pais $Pais
 * @property Usuario $UsuarioAlteracao
 * @property Usuario $UsuarioCriacao
 */
class Estado extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblestado';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codestado', 'required'),
			array('estado', 'length', 'max'=>50),
			array('sigla', 'length', 'max'=>2),
			array('codpais, codigooficial, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codestado, codpais, estado, sigla, codigooficial, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
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
			'TributacaoNaturezaOperacaos' => array(self::HAS_MANY, 'TributacaoNaturezaOperacao', 'codestado'),
			'Cidades' => array(self::HAS_MANY, 'Cidade', 'codestado'),
			'Pais' => array(self::BELONGS_TO, 'Pais', 'codpais'),
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
			'codestado' => 'Estado',
			'codpais' => 'País',
			'estado' => 'Estado',
			'sigla' => 'Sigla',
			'codigooficial' => 'Codigo Oficial',
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

		$criteria->compare('codestado',$this->codestado,true);
		$criteria->compare('codpais',$this->codpais,true);
		$criteria->compare('estado',$this->estado,true);
		$criteria->compare('sigla',$this->sigla,true);
		$criteria->compare('codigooficial',$this->codigooficial,true);
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
	 * @return Estado the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

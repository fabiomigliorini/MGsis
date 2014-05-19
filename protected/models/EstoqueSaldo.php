<?php

/**
 * This is the model class for table "mgsis.tblestoquesaldo".
 *
 * The followings are the available columns in table 'mgsis.tblestoquesaldo':
 * @property string $codestoquesaldo
 * @property string $codfilial
 * @property string $codproduto
 * @property boolean $fiscal
 * @property string $saldoquantidade
 * @property string $saldovalor
 * @property string $saldovalorunitario
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property Filial $Filial
 * @property Produto $Produto
 * @property Usuario $UsuarioAlteracao
 * @property Usuario $UsuarioCriacao
 */
class EstoqueSaldo extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblestoquesaldo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codestoquesaldo, codfilial, codproduto, fiscal', 'required'),
			array('saldoquantidade, saldovalor, saldovalorunitario', 'length', 'max'=>14),
			array('alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codestoquesaldo, codfilial, codproduto, fiscal, saldoquantidade, saldovalor, saldovalorunitario, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
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
			'Produto' => array(self::BELONGS_TO, 'Produto', 'codproduto'),
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
			'codestoquesaldo' => 'Codestoquesaldo',
			'codfilial' => 'Codfilial',
			'codproduto' => 'Codproduto',
			'fiscal' => 'Fiscal',
			'saldoquantidade' => 'Saldoquantidade',
			'saldovalor' => 'Saldovalor',
			'saldovalorunitario' => 'Saldovalorunitario',
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

		$criteria->compare('codestoquesaldo',$this->codestoquesaldo,true);
		$criteria->compare('codfilial',$this->codfilial,true);
		$criteria->compare('codproduto',$this->codproduto,true);
		$criteria->compare('fiscal',$this->fiscal);
		$criteria->compare('saldoquantidade',$this->saldoquantidade,true);
		$criteria->compare('saldovalor',$this->saldovalor,true);
		$criteria->compare('saldovalorunitario',$this->saldovalorunitario,true);
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
	 * @return EstoqueSaldo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

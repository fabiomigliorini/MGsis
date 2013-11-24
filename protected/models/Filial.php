<?php

/**
 * This is the model class for table "mgsis.tblfilial".
 *
 * The followings are the available columns in table 'mgsis.tblfilial':
 * @property string $codfilial
 * @property string $codempresa
 * @property string $codpessoa
 * @property string $filial
 * @property boolean $emitenfe
 * @property string $acbrnfemonitorcaminho
 * @property string $acbrnfemonitorcaminhorede
 * @property string $acbrnfemonitorbloqueado
 * @property string $acbrnfemonitorcodusuario
 * @property string $empresadominio
 * @property string $acbrnfemonitorip
 * @property string $acbrnfemonitorporta
 * @property string $odbcnumeronotafiscal
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property Titulo[] $titulos
 * @property Usuario $acbrnfemonitorcodusuario
 * @property Empresa $codempresa
 * @property Pessoa $codpessoa
 * @property Usuario $codusuarioalteracao
 * @property Usuario $codusuariocriacao
 * @property Portador[] $portadors
 * @property Usuario[] $usuarios
 * @property Estoquemovimento[] $estoquemovimentos
 * @property Ecf[] $ecfs
 * @property Negocio[] $negocios
 * @property Estoquesaldo[] $estoquesaldos
 */
class Filial extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblfilial';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codfilial, filial', 'required'),
			array('filial, acbrnfemonitorip', 'length', 'max'=>20),
			array('acbrnfemonitorcaminho, acbrnfemonitorcaminhorede', 'length', 'max'=>100),
			array('empresadominio', 'length', 'max'=>7),
			array('odbcnumeronotafiscal', 'length', 'max'=>500),
			array('codempresa, codpessoa, emitenfe, acbrnfemonitorbloqueado, acbrnfemonitorcodusuario, acbrnfemonitorporta, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codfilial, codempresa, codpessoa, filial, emitenfe, acbrnfemonitorcaminho, acbrnfemonitorcaminhorede, acbrnfemonitorbloqueado, acbrnfemonitorcodusuario, empresadominio, acbrnfemonitorip, acbrnfemonitorporta, odbcnumeronotafiscal, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
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
			'titulos' => array(self::HAS_MANY, 'Titulo', 'codfilial'),
			'acbrnfemonitorcodusuario' => array(self::BELONGS_TO, 'Usuario', 'acbrnfemonitorcodusuario'),
			'codempresa' => array(self::BELONGS_TO, 'Empresa', 'codempresa'),
			'codpessoa' => array(self::BELONGS_TO, 'Pessoa', 'codpessoa'),
			'codusuarioalteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
			'codusuariocriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
			'portadors' => array(self::HAS_MANY, 'Portador', 'codfilial'),
			'usuarios' => array(self::HAS_MANY, 'Usuario', 'codfilial'),
			'estoquemovimentos' => array(self::HAS_MANY, 'Estoquemovimento', 'codfilial'),
			'ecfs' => array(self::HAS_MANY, 'Ecf', 'codfilial'),
			'negocios' => array(self::HAS_MANY, 'Negocio', 'codfilial'),
			'estoquesaldos' => array(self::HAS_MANY, 'Estoquesaldo', 'codfilial'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codfilial' => 'Codfilial',
			'codempresa' => 'Codempresa',
			'codpessoa' => 'Codpessoa',
			'filial' => 'Filial',
			'emitenfe' => 'Emitenfe',
			'acbrnfemonitorcaminho' => 'Acbrnfemonitorcaminho',
			'acbrnfemonitorcaminhorede' => 'Acbrnfemonitorcaminhorede',
			'acbrnfemonitorbloqueado' => 'Acbrnfemonitorbloqueado',
			'acbrnfemonitorcodusuario' => 'Acbrnfemonitorcodusuario',
			'empresadominio' => 'Empresadominio',
			'acbrnfemonitorip' => 'Acbrnfemonitorip',
			'acbrnfemonitorporta' => 'Acbrnfemonitorporta',
			'odbcnumeronotafiscal' => 'Odbcnumeronotafiscal',
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

		$criteria->compare('codfilial',$this->codfilial,true);
		$criteria->compare('codempresa',$this->codempresa,true);
		$criteria->compare('codpessoa',$this->codpessoa,true);
		$criteria->compare('filial',$this->filial,true);
		$criteria->compare('emitenfe',$this->emitenfe);
		$criteria->compare('acbrnfemonitorcaminho',$this->acbrnfemonitorcaminho,true);
		$criteria->compare('acbrnfemonitorcaminhorede',$this->acbrnfemonitorcaminhorede,true);
		$criteria->compare('acbrnfemonitorbloqueado',$this->acbrnfemonitorbloqueado,true);
		$criteria->compare('acbrnfemonitorcodusuario',$this->acbrnfemonitorcodusuario,true);
		$criteria->compare('empresadominio',$this->empresadominio,true);
		$criteria->compare('acbrnfemonitorip',$this->acbrnfemonitorip,true);
		$criteria->compare('acbrnfemonitorporta',$this->acbrnfemonitorporta,true);
		$criteria->compare('odbcnumeronotafiscal',$this->odbcnumeronotafiscal,true);
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
	 * @return Filial the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

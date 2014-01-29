<?php

/**
 * This is the model class for table "mgsis.tblnegocio".
 *
 * The followings are the available columns in table 'mgsis.tblnegocio':
 * @property string $codnegocio
 * @property string $codpessoa
 * @property string $codfilial
 * @property string $lancamento
 * @property string $codpessoavendedor
 * @property string $codoperacao
 * @property string $codnegociostatus
 * @property string $observacoes
 * @property string $codusuario
 * @property string $valordesconto
 * @property boolean $entrega
 * @property string $acertoentrega
 * @property string $codusuarioacertoentrega
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property Filial $codfilial
 * @property Negociostatus $codnegociostatus
 * @property Operacao $codoperacao
 * @property Pessoa $codpessoa
 * @property Pessoa $codpessoavendedor
 * @property Usuario $codusuario
 * @property Usuario $codusuarioacertoentrega
 * @property Usuario $codusuarioalteracao
 * @property Usuario $codusuariocriacao
 * @property Negocioformapagamento[] $negocioformapagamentos
 * @property Negocioprodutobarra[] $negocioprodutobarras
 */
class Negocio extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblnegocio';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codnegocio, codfilial, lancamento, codoperacao, codnegociostatus, codusuario', 'required'),
			array('observacoes', 'length', 'max'=>500),
			array('valordesconto', 'length', 'max'=>14),
			array('codpessoa, codpessoavendedor, entrega, acertoentrega, codusuarioacertoentrega, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codnegocio, codpessoa, codfilial, lancamento, codpessoavendedor, codoperacao, codnegociostatus, observacoes, codusuario, valordesconto, entrega, acertoentrega, codusuarioacertoentrega, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
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
			'codfilial' => array(self::BELONGS_TO, 'Filial', 'codfilial'),
			'codnegociostatus' => array(self::BELONGS_TO, 'Negociostatus', 'codnegociostatus'),
			'codoperacao' => array(self::BELONGS_TO, 'Operacao', 'codoperacao'),
			'codpessoa' => array(self::BELONGS_TO, 'Pessoa', 'codpessoa'),
			'codpessoavendedor' => array(self::BELONGS_TO, 'Pessoa', 'codpessoavendedor'),
			'codusuario' => array(self::BELONGS_TO, 'Usuario', 'codusuario'),
			'codusuarioacertoentrega' => array(self::BELONGS_TO, 'Usuario', 'codusuarioacertoentrega'),
			'codusuarioalteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
			'codusuariocriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
			'negocioformapagamentos' => array(self::HAS_MANY, 'Negocioformapagamento', 'codnegocio'),
			'negocioprodutobarras' => array(self::HAS_MANY, 'Negocioprodutobarra', 'codnegocio'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codnegocio' => 'Codnegocio',
			'codpessoa' => 'Codpessoa',
			'codfilial' => 'Codfilial',
			'lancamento' => 'Lancamento',
			'codpessoavendedor' => 'Codpessoavendedor',
			'codoperacao' => 'Codoperacao',
			'codnegociostatus' => 'Codnegociostatus',
			'observacoes' => 'Observacoes',
			'codusuario' => 'Codusuario',
			'valordesconto' => 'Valordesconto',
			'entrega' => 'Entrega',
			'acertoentrega' => 'Acertoentrega',
			'codusuarioacertoentrega' => 'Codusuarioacertoentrega',
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

		$criteria->compare('codnegocio',$this->codnegocio,true);
		$criteria->compare('codpessoa',$this->codpessoa,true);
		$criteria->compare('codfilial',$this->codfilial,true);
		$criteria->compare('lancamento',$this->lancamento,true);
		$criteria->compare('codpessoavendedor',$this->codpessoavendedor,true);
		$criteria->compare('codoperacao',$this->codoperacao,true);
		$criteria->compare('codnegociostatus',$this->codnegociostatus,true);
		$criteria->compare('observacoes',$this->observacoes,true);
		$criteria->compare('codusuario',$this->codusuario,true);
		$criteria->compare('valordesconto',$this->valordesconto,true);
		$criteria->compare('entrega',$this->entrega);
		$criteria->compare('acertoentrega',$this->acertoentrega,true);
		$criteria->compare('codusuarioacertoentrega',$this->codusuarioacertoentrega,true);
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
	 * @return Negocio the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

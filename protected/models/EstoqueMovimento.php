<?php

/**
 * This is the model class for table "mgsis.tblestoquemovimento".
 *
 * The followings are the available columns in table 'mgsis.tblestoquemovimento':
 * @property string $codestoquemovimento
 * @property string $codfilial
 * @property string $codproduto
 * @property boolean $fiscal
 * @property string $codestoquemovimentotipo
 * @property string $lancamento
 * @property string $entradaquantidade
 * @property string $entradavalor
 * @property string $saidaquantidade
 * @property string $saidavalor
 * @property string $codnegocioprodutobarra
 * @property string $codnotafiscalprodutobarra
 * @property string $codcupomfiscalprodutobarra
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property Cupomfiscalprodutobarra $codcupomfiscalprodutobarra
 * @property Estoquemovimentotipo $codestoquemovimentotipo
 * @property Filial $codfilial
 * @property Negocioprodutobarra $codnegocioprodutobarra
 * @property Notafiscalprodutobarra $codnotafiscalprodutobarra
 * @property Produto $codproduto
 * @property Usuario $codusuarioalteracao
 * @property Usuario $codusuariocriacao
 */
class EstoqueMovimento extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblestoquemovimento';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codfilial, codproduto, fiscal, codestoquemovimentotipo, lancamento', 'required'),
			array('entradaquantidade, entradavalor, saidaquantidade, saidavalor', 'length', 'max'=>14),
			array('codnegocioprodutobarra, codnotafiscalprodutobarra, codcupomfiscalprodutobarra, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codestoquemovimento, codfilial, codproduto, fiscal, codestoquemovimentotipo, lancamento, entradaquantidade, entradavalor, saidaquantidade, saidavalor, codnegocioprodutobarra, codnotafiscalprodutobarra, codcupomfiscalprodutobarra, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
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
			'codcupomfiscalprodutobarra' => array(self::BELONGS_TO, 'Cupomfiscalprodutobarra', 'codcupomfiscalprodutobarra'),
			'codestoquemovimentotipo' => array(self::BELONGS_TO, 'Estoquemovimentotipo', 'codestoquemovimentotipo'),
			'codfilial' => array(self::BELONGS_TO, 'Filial', 'codfilial'),
			'codnegocioprodutobarra' => array(self::BELONGS_TO, 'Negocioprodutobarra', 'codnegocioprodutobarra'),
			'codnotafiscalprodutobarra' => array(self::BELONGS_TO, 'Notafiscalprodutobarra', 'codnotafiscalprodutobarra'),
			'codproduto' => array(self::BELONGS_TO, 'Produto', 'codproduto'),
			'codusuarioalteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
			'codusuariocriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codestoquemovimento' => 'Codestoquemovimento',
			'codfilial' => 'Codfilial',
			'codproduto' => 'Codproduto',
			'fiscal' => 'Fiscal',
			'codestoquemovimentotipo' => 'Codestoquemovimentotipo',
			'lancamento' => 'Lancamento',
			'entradaquantidade' => 'Entradaquantidade',
			'entradavalor' => 'Entradavalor',
			'saidaquantidade' => 'Saidaquantidade',
			'saidavalor' => 'Saidavalor',
			'codnegocioprodutobarra' => 'Codnegocioprodutobarra',
			'codnotafiscalprodutobarra' => 'Codnotafiscalprodutobarra',
			'codcupomfiscalprodutobarra' => 'Codcupomfiscalprodutobarra',
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

		$criteria->compare('codestoquemovimento',$this->codestoquemovimento,true);
		$criteria->compare('codfilial',$this->codfilial,true);
		$criteria->compare('codproduto',$this->codproduto,true);
		$criteria->compare('fiscal',$this->fiscal);
		$criteria->compare('codestoquemovimentotipo',$this->codestoquemovimentotipo,true);
		$criteria->compare('lancamento',$this->lancamento,true);
		$criteria->compare('entradaquantidade',$this->entradaquantidade,true);
		$criteria->compare('entradavalor',$this->entradavalor,true);
		$criteria->compare('saidaquantidade',$this->saidaquantidade,true);
		$criteria->compare('saidavalor',$this->saidavalor,true);
		$criteria->compare('codnegocioprodutobarra',$this->codnegocioprodutobarra,true);
		$criteria->compare('codnotafiscalprodutobarra',$this->codnotafiscalprodutobarra,true);
		$criteria->compare('codcupomfiscalprodutobarra',$this->codcupomfiscalprodutobarra,true);
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
	 * @return EstoqueMovimento the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

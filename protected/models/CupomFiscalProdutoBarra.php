<?php

/**
 * This is the model class for table "mgsis.tblcupomfiscalprodutobarra".
 *
 * The followings are the available columns in table 'mgsis.tblcupomfiscalprodutobarra':
 * @property string $codcupomfiscalprodutobarra
 * @property string $codcupomfiscal
 * @property string $codprodutobarra
 * @property string $aliquotaicms
 * @property string $quantidade
 * @property string $valorunitario
 * @property string $codnegocioprodutobarra
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property EstoqueMovimento[] $EstoqueMovimentos
 * @property CupomFiscal $CupomFiscal
 * @property NegocioProdutoBarra $NegocioProdutoBarra
 * @property ProdutoBarra $ProdutoBarra
 * @property Usuario $UsuarioAlteracao
 * @property Usuario $UsuarioCriacao
 */
class CupomFiscalProdutoBarra extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblcupomfiscalprodutobarra';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codcupomfiscalprodutobarra, codcupomfiscal, codprodutobarra', 'required'),
			array('aliquotaicms', 'length', 'max'=>10),
			array('quantidade, valorunitario', 'length', 'max'=>14),
			array('codnegocioprodutobarra, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codcupomfiscalprodutobarra, codcupomfiscal, codprodutobarra, aliquotaicms, quantidade, valorunitario, codnegocioprodutobarra, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
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
			'EstoqueMovimentos' => array(self::HAS_MANY, 'EstoqueMovimento', 'codcupomfiscalprodutobarra'),
			'CupomFiscal' => array(self::BELONGS_TO, 'CupomFiscal', 'codcupomfiscal'),
			'NegocioProdutoBarra' => array(self::BELONGS_TO, 'NegocioProdutoBarra', 'codnegocioprodutobarra'),
			'ProdutoBarra' => array(self::BELONGS_TO, 'ProdutoBarra', 'codprodutobarra'),
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
			'codcupomfiscalprodutobarra' => 'Codcupomfiscalprodutobarra',
			'codcupomfiscal' => 'Codcupomfiscal',
			'codprodutobarra' => 'Codprodutobarra',
			'aliquotaicms' => 'Aliquotaicms',
			'quantidade' => 'Quantidade',
			'valorunitario' => 'Valorunitario',
			'codnegocioprodutobarra' => 'Codnegocioprodutobarra',
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

		$criteria->compare('codcupomfiscalprodutobarra',$this->codcupomfiscalprodutobarra,true);
		$criteria->compare('codcupomfiscal',$this->codcupomfiscal,true);
		$criteria->compare('codprodutobarra',$this->codprodutobarra,true);
		$criteria->compare('aliquotaicms',$this->aliquotaicms,true);
		$criteria->compare('quantidade',$this->quantidade,true);
		$criteria->compare('valorunitario',$this->valorunitario,true);
		$criteria->compare('codnegocioprodutobarra',$this->codnegocioprodutobarra,true);
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
	 * @return CupomFiscalProdutoBarra the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

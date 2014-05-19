<?php

/**
 * This is the model class for table "mgsis.tblcupomfiscal".
 *
 * The followings are the available columns in table 'mgsis.tblcupomfiscal':
 * @property string $codcupomfiscal
 * @property string $codecf
 * @property string $datamovimento
 * @property string $numero
 * @property boolean $cancelado
 * @property string $descontoacrescimo
 * @property string $codpessoa
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property CupomFiscalProdutoBarra[] $CupomFiscalProdutoBarras
 * @property Ecf $Ecf
 * @property Pessoa $Pessoa
 * @property Usuario $UsuarioAlteracao
 * @property Usuario $UsuarioCriacao
 */
class CupomFiscal extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblcupomfiscal';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codcupomfiscal, codecf, datamovimento, numero', 'required'),
			array('descontoacrescimo', 'length', 'max'=>14),
			array('cancelado, codpessoa, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codcupomfiscal, codecf, datamovimento, numero, cancelado, descontoacrescimo, codpessoa, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
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
			'CupomFiscalProdutoBarras' => array(self::HAS_MANY, 'CupomFiscalProdutoBarra', 'codcupomfiscal'),
			'Ecf' => array(self::BELONGS_TO, 'Ecf', 'codecf'),
			'Pessoa' => array(self::BELONGS_TO, 'Pessoa', 'codpessoa'),
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
			'codcupomfiscal' => 'Codcupomfiscal',
			'codecf' => 'Codecf',
			'datamovimento' => 'Datamovimento',
			'numero' => 'Numero',
			'cancelado' => 'Cancelado',
			'descontoacrescimo' => 'Descontoacrescimo',
			'codpessoa' => 'Codpessoa',
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

		$criteria->compare('codcupomfiscal',$this->codcupomfiscal,true);
		$criteria->compare('codecf',$this->codecf,true);
		$criteria->compare('datamovimento',$this->datamovimento,true);
		$criteria->compare('numero',$this->numero,true);
		$criteria->compare('cancelado',$this->cancelado);
		$criteria->compare('descontoacrescimo',$this->descontoacrescimo,true);
		$criteria->compare('codpessoa',$this->codpessoa,true);
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
	 * @return CupomFiscal the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

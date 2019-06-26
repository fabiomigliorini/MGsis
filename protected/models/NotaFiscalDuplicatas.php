<?php

/**
 * This is the model class for table "mgsis.tblnotafiscalduplicatas".
 *
 * The followings are the available columns in table 'mgsis.tblnotafiscalduplicatas':
 * @property string $codnotafiscalduplicatas
 * @property string $codnotafiscal
 * @property string $fatura
 * @property string $vencimento
 * @property string $valor
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property NotaFiscal $NotaFiscal
 * @property Usuario $UsuarioAlteracao
 * @property Usuario $UsuarioCriacao
 */
class NotaFiscalDuplicatas extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblnotafiscalduplicatas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codnotafiscal, vencimento', 'required'),
			array('fatura', 'length', 'max'=>50),
			array('valor', 'length', 'max'=>14),
			array('alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codnotafiscalduplicatas, codnotafiscal, fatura, vencimento, valor, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
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
			'NotaFiscal' => array(self::BELONGS_TO, 'NotaFiscal', 'codnotafiscal'),
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
			'codnotafiscalduplicatas' => '#',
			'codnotafiscal' => 'Nota Fiscal',
			'fatura' => 'Fatura',
			'vencimento' => 'Vencimento',
			'valor' => 'Valor',
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

		$criteria->compare('codnotafiscalduplicatas',$this->codnotafiscalduplicatas,true);
		$criteria->compare('codnotafiscal',$this->codnotafiscal,true);
		$criteria->compare('fatura',$this->fatura,true);
		$criteria->compare('vencimento',$this->vencimento,true);
		$criteria->compare('valor',$this->valor,true);
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
	 * @return NotaFiscalDuplicatas the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

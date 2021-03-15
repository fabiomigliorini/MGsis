<?php

/**
 * This is the model class for table "mgsis.tblmdfenfe".
 *
 * The followings are the available columns in table 'mgsis.tblmdfenfe':
 * @property string $codmdfenfe
 * @property string $codmdfe
 * @property string $codcidadedescarga
 * @property string $nfechave
 * @property string $codnotafiscal
 * @property string $valor
 * @property string $peso
 * @property string $criacao
 * @property string $codusuariocriacao
 * @property string $alteracao
 * @property string $codusuarioalteracao
 *
 * The followings are the available model relations:
 * @property Cidade $codcidadedescarga
 * @property Mdfe $codmdfe
 * @property Notafiscal $codnotafiscal
 * @property Usuario $codusuariocriacao
 * @property Usuario $codusuarioalteracao
 */
class MdfeNfe extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblmdfenfe';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codmdfe, codcidadedescarga, nfechave, valor, peso', 'required'),
			array('nfechave', 'length', 'max'=>44),
			array('valor, peso', 'length', 'max'=>15),
			array('codnotafiscal, criacao, codusuariocriacao, alteracao, codusuarioalteracao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codmdfenfe, codmdfe, codcidadedescarga, nfechave, codnotafiscal, valor, peso, criacao, codusuariocriacao, alteracao, codusuarioalteracao', 'safe', 'on'=>'search'),
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
			'CidadeDescarga' => array(self::BELONGS_TO, 'Cidade', 'codcidadedescarga'),
			'Mdfe' => array(self::BELONGS_TO, 'Mdfe', 'codmdfe'),
			'NotaFiscal' => array(self::BELONGS_TO, 'NotaFiscal', 'codnotafiscal'),
			'UsuarioCriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
			'UsuarioAlteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codmdfenfe' => 'Codmdfenfe',
			'codmdfe' => 'Codmdfe',
			'codcidadedescarga' => 'infMunDescarga',
			'nfechave' => 'chNfe',
			'codnotafiscal' => 'Codnotafiscal',
			'valor' => 'vCarga',
			'peso' => 'qCarga\nPeso em KG',
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

		$criteria->compare('codmdfenfe',$this->codmdfenfe,true);
		$criteria->compare('codmdfe',$this->codmdfe,true);
		$criteria->compare('codcidadedescarga',$this->codcidadedescarga,true);
		$criteria->compare('nfechave',$this->nfechave,true);
		$criteria->compare('codnotafiscal',$this->codnotafiscal,true);
		$criteria->compare('valor',$this->valor,true);
		$criteria->compare('peso',$this->peso,true);
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
	 * @return MdfeNfe the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

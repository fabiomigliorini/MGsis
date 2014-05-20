<?php

/**
 * This is the model class for table "mgsis.tblnotafiscalcartacorrecao".
 *
 * The followings are the available columns in table 'mgsis.tblnotafiscalcartacorrecao':
 * @property string $codnotafiscalcartacorrecao
 * @property string $codnotafiscal
 * @property integer $lote
 * @property string $data
 * @property integer $sequencia
 * @property string $texto
 * @property string $protocolo
 * @property string $protocolodata
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
class NotaFiscalCartaCorrecao extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblnotafiscalcartacorrecao';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codnotafiscalcartacorrecao, codnotafiscal, lote, data, sequencia, texto', 'required'),
			array('lote, sequencia', 'numerical', 'integerOnly'=>true),
			array('protocolo', 'length', 'max'=>100),
			array('protocolodata, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codnotafiscalcartacorrecao, codnotafiscal, lote, data, sequencia, texto, protocolo, protocolodata, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
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
			'codnotafiscalcartacorrecao' => '#',
			'codnotafiscal' => 'Nota Fiscal',
			'lote' => 'Lote',
			'data' => 'Data',
			'sequencia' => 'Sequência',
			'texto' => 'Texto',
			'protocolo' => 'Protocolo',
			'protocolodata' => 'Data do Protocolo',
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

		$criteria->compare('codnotafiscalcartacorrecao',$this->codnotafiscalcartacorrecao,true);
		$criteria->compare('codnotafiscal',$this->codnotafiscal,true);
		$criteria->compare('lote',$this->lote);
		$criteria->compare('data',$this->data,true);
		$criteria->compare('sequencia',$this->sequencia);
		$criteria->compare('texto',$this->texto,true);
		$criteria->compare('protocolo',$this->protocolo,true);
		$criteria->compare('protocolodata',$this->protocolodata,true);
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
	 * @return NotaFiscalCartaCorrecao the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

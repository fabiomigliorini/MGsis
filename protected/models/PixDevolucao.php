<?php

/**
 * This is the model class for table "mgsis.tblpixdevolucao".
 *
 * The followings are the available columns in table 'mgsis.tblpixdevolucao':
 * @property string $codpixdevolucao
 * @property string $codpix
 * @property string $id
 * @property string $rtrid
 * @property string $valor
 * @property string $solicitacao
 * @property string $liquidacao
 * @property string $codpixdevolucaostatus
 * @property string $criacao
 * @property string $codusuariocriacao
 * @property string $alteracao
 * @property string $codusuarioalteracao
 *
 * The followings are the available model relations:
 * @property Pixdevolucaostatus $codpixdevolucaostatus
 * @property Pix $codpix
 * @property Usuario $codusuariocriacao
 * @property Usuario $codusuarioalteracao
 */
class PixDevolucao extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblpixdevolucao';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codpix, codpixdevolucaostatus', 'required'),
			array('id, rtrid', 'length', 'max'=>40),
			array('valor', 'length', 'max'=>14),
			array('solicitacao, liquidacao, criacao, codusuariocriacao, alteracao, codusuarioalteracao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codpixdevolucao, codpix, id, rtrid, valor, solicitacao, liquidacao, codpixdevolucaostatus, criacao, codusuariocriacao, alteracao, codusuarioalteracao', 'safe', 'on'=>'search'),
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
			'PixDevolucaoStatus' => array(self::BELONGS_TO, 'PixDevolucaoStatus', 'codpixdevolucaostatus'),
			'Pix' => array(self::BELONGS_TO, 'Pix', 'codpix'),
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
			'codpixdevolucao' => 'Codpixdevolucao',
			'codpix' => 'Codpix',
			'id' => 'ID',
			'rtrid' => 'Rtrid',
			'valor' => 'Valor',
			'solicitacao' => 'Solicitacao',
			'liquidacao' => 'Liquidacao',
			'codpixdevolucaostatus' => 'Codpixdevolucaostatus',
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

		$criteria->compare('codpixdevolucao',$this->codpixdevolucao,true);
		$criteria->compare('codpix',$this->codpix,true);
		$criteria->compare('id',$this->id,true);
		$criteria->compare('rtrid',$this->rtrid,true);
		$criteria->compare('valor',$this->valor,true);
		$criteria->compare('solicitacao',$this->solicitacao,true);
		$criteria->compare('liquidacao',$this->liquidacao,true);
		$criteria->compare('codpixdevolucaostatus',$this->codpixdevolucaostatus,true);
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
	 * @return PixDevolucao the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

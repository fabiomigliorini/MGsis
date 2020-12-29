<?php

/**
 * This is the model class for table "mgsis.tblpix".
 *
 * The followings are the available columns in table 'mgsis.tblpix':
 * @property string $codpix
 * @property string $e2eid
 * @property string $codportador
 * @property string $codpixcob
 * @property string $txid
 * @property string $valor
 * @property string $horario
 * @property string $nome
 * @property string $cpf
 * @property string $cnpj
 * @property string $infopagador
 * @property string $criacao
 * @property string $codusuariocriacao
 * @property string $alteracao
 * @property string $codusuarioalteracao
 *
 * The followings are the available model relations:
 * @property Pixdevolucao[] $pixdevolucaos
 * @property Portador $codportador
 * @property Pixcob $codpixcob
 * @property Usuario $codusuariocriacao
 * @property Usuario $codusuarioalteracao
 */
class Pix extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblpix';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codportador', 'required'),
			array('e2eid, txid', 'length', 'max'=>40),
			array('valor, cnpj', 'length', 'max'=>14),
			array('nome', 'length', 'max'=>100),
			array('cpf', 'length', 'max'=>11),
			array('infopagador', 'length', 'max'=>140),
			array('codpixcob, horario, criacao, codusuariocriacao, alteracao, codusuarioalteracao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codpix, e2eid, codportador, codpixcob, txid, valor, horario, nome, cpf, cnpj, infopagador, criacao, codusuariocriacao, alteracao, codusuarioalteracao', 'safe', 'on'=>'search'),
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
			'PixDevolucaos' => array(self::HAS_MANY, 'PixDevolucao', 'codpix'),
			'Portador' => array(self::BELONGS_TO, 'Portador', 'codportador'),
			'PixCob' => array(self::BELONGS_TO, 'PixCob', 'codpixcob'),
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
			'codpix' => 'Codpix',
			'e2eid' => 'E2eid',
			'codportador' => 'Codportador',
			'codpixcob' => 'Codpixcob',
			'txid' => 'Identificador da transação',
			'valor' => 'Valor',
			'horario' => 'Horario',
			'nome' => 'Nome',
			'cpf' => 'Cpf',
			'cnpj' => 'Cnpj',
			'infopagador' => 'Infopagador',
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

		$criteria->compare('codpix',$this->codpix,true);
		$criteria->compare('e2eid',$this->e2eid,true);
		$criteria->compare('codportador',$this->codportador,true);
		$criteria->compare('codpixcob',$this->codpixcob,true);
		$criteria->compare('txid',$this->txid,true);
		$criteria->compare('valor',$this->valor,true);
		$criteria->compare('horario',$this->horario,true);
		$criteria->compare('nome',$this->nome,true);
		$criteria->compare('cpf',$this->cpf,true);
		$criteria->compare('cnpj',$this->cnpj,true);
		$criteria->compare('infopagador',$this->infopagador,true);
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
	 * @return Pix the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

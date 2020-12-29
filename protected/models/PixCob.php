<?php

/**
 * This is the model class for table "mgsis.tblpixcob".
 *
 * The followings are the available columns in table 'mgsis.tblpixcob':
 * @property string $codpixcob
 * @property string $txid
 * @property string $expiracao
 * @property string $codpixcobstatus
 * @property string $cpf
 * @property string $cnpj
 * @property string $valororiginal
 * @property string $solicitacaopagador
 * @property string $criacao
 * @property string $codusuariocriacao
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $codnegocio
 * @property string $codportador
 * @property string $nome
 * @property string $location
 *
 * The followings are the available model relations:
 * @property Pixcobstatus $codpixcobstatus
 * @property Negocio $codnegocio
 * @property Portador $codportador
 * @property Usuario $codusuariocriacao
 * @property Usuario $codusuarioalteracao
 * @property Pix[] $pixes
 * @property Negocioformapagamento[] $negocioformapagamentos
 */
class PixCob extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblpixcob';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codpixcobstatus, codportador', 'required'),
			array('txid', 'length', 'max'=>40),
			array('cpf', 'length', 'max'=>11),
			array('cnpj, valororiginal', 'length', 'max'=>14),
			array('solicitacaopagador', 'length', 'max'=>140),
			array('nome', 'length', 'max'=>100),
			array('location', 'length', 'max'=>200),
			array('expiracao, criacao, codusuariocriacao, alteracao, codusuarioalteracao, codnegocio', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codpixcob, txid, expiracao, codpixcobstatus, cpf, cnpj, valororiginal, solicitacaopagador, criacao, codusuariocriacao, alteracao, codusuarioalteracao, codnegocio, codportador, nome, location', 'safe', 'on'=>'search'),
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
			'PixCobStatus' => array(self::BELONGS_TO, 'PixCobStatus', 'codpixcobstatus'),
			'Negocio' => array(self::BELONGS_TO, 'Negocio', 'codnegocio'),
			'Portador' => array(self::BELONGS_TO, 'Portador', 'codportador'),
			'UsuarioCriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
			'UsuarioAlteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
			'Pixs' => array(self::HAS_MANY, 'Pix', 'codpixcob'),
			'NegocioFormaPagamentos' => array(self::HAS_MANY, 'NegocioFormaPagamento', 'codpixcob'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codpixcob' => 'Codpixcob',
			'txid' => 'Identificador da transação',
			'expiracao' => 'Tempo de vida da cobrança em Segundos',
			'codpixcobstatus' => 'Codpixcobstatus',
			'cpf' => 'Cpf',
			'cnpj' => 'Cnpj',
			'valororiginal' => 'Valororiginal',
			'solicitacaopagador' => 'Solicitacaopagador',
			'criacao' => 'Criacao',
			'codusuariocriacao' => 'Codusuariocriacao',
			'alteracao' => 'Alteracao',
			'codusuarioalteracao' => 'Codusuarioalteracao',
			'codnegocio' => 'Codnegocio',
			'codportador' => 'Codportador',
			'nome' => 'Nome',
			'location' => 'Location',
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

		$criteria->compare('codpixcob',$this->codpixcob,true);
		$criteria->compare('txid',$this->txid,true);
		$criteria->compare('expiracao',$this->expiracao,true);
		$criteria->compare('codpixcobstatus',$this->codpixcobstatus,true);
		$criteria->compare('cpf',$this->cpf,true);
		$criteria->compare('cnpj',$this->cnpj,true);
		$criteria->compare('valororiginal',$this->valororiginal,true);
		$criteria->compare('solicitacaopagador',$this->solicitacaopagador,true);
		$criteria->compare('criacao',$this->criacao,true);
		$criteria->compare('codusuariocriacao',$this->codusuariocriacao,true);
		$criteria->compare('alteracao',$this->alteracao,true);
		$criteria->compare('codusuarioalteracao',$this->codusuarioalteracao,true);
		$criteria->compare('codnegocio',$this->codnegocio,true);
		$criteria->compare('codportador',$this->codportador,true);
		$criteria->compare('nome',$this->nome,true);
		$criteria->compare('location',$this->location,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PixCob the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

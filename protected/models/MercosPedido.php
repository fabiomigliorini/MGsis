<?php

/**
 * This is the model class for table "mgsis.tblmercospedido".
 *
 * The followings are the available columns in table 'mgsis.tblmercospedido':
 * @property string $codmercospedido
 * @property string $pedidoid
 * @property string $numero
 * @property string $condicaopagamento
 * @property string $enderecoentrega
 * @property string $codnegocio
 * @property string $criacao
 * @property string $codusuariocriacao
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $codmercoscliente
 *
 * The followings are the available model relations:
 * @property Tblnegocio $codnegocio
 * @property Tblusuario $codusuariocriacao
 * @property Tblusuario $codusuarioalteracao
 * @property Tblmercoscliente $codmercoscliente
 * @property Tblmercospedidoitem[] $tblmercospedidoitems
 */
class MercosPedido extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblmercospedido';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pedidoid', 'required'),
			array('numero, condicaopagamento, enderecoentrega, codnegocio, criacao, codusuariocriacao, alteracao, codusuarioalteracao, codmercoscliente', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codmercospedido, pedidoid, numero, condicaopagamento, enderecoentrega, codnegocio, criacao, codusuariocriacao, alteracao, codusuarioalteracao, codmercoscliente', 'safe', 'on'=>'search'),
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
			'Negocio' => array(self::BELONGS_TO, 'Negocio', 'codnegocio'),
			'UsuarioCriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
			'UsuarioAlteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
			'MercosCliente' => array(self::BELONGS_TO, 'MercosCliente', 'codmercoscliente'),
			'MercosPedidoItems' => array(self::HAS_MANY, 'MercosPedidoItem', 'codmercospedido'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codmercospedido' => 'Codmercospedido',
			'pedidoid' => 'Pedidoid',
			'numero' => 'Numero',
			'condicaopagamento' => 'Condicaopagamento',
			'enderecoentrega' => 'Enderecoentrega',
			'codnegocio' => 'Codnegocio',
			'criacao' => 'Criacao',
			'codusuariocriacao' => 'Codusuariocriacao',
			'alteracao' => 'Alteracao',
			'codusuarioalteracao' => 'Codusuarioalteracao',
			'codmercoscliente' => 'Codmercoscliente',
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

		$criteria->compare('codmercospedido',$this->codmercospedido,true);
		$criteria->compare('pedidoid',$this->pedidoid,true);
		$criteria->compare('numero',$this->numero,true);
		$criteria->compare('condicaopagamento',$this->condicaopagamento,true);
		$criteria->compare('enderecoentrega',$this->enderecoentrega,true);
		$criteria->compare('codnegocio',$this->codnegocio,true);
		$criteria->compare('criacao',$this->criacao,true);
		$criteria->compare('codusuariocriacao',$this->codusuariocriacao,true);
		$criteria->compare('alteracao',$this->alteracao,true);
		$criteria->compare('codusuarioalteracao',$this->codusuarioalteracao,true);
		$criteria->compare('codmercoscliente',$this->codmercoscliente,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MercosPedido the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

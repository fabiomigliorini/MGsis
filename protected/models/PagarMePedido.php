<?php

/**
 * This is the model class for table "mgsis.tblpagarmepedido".
 *
 * The followings are the available columns in table 'mgsis.tblpagarmepedido':
 * @property string $codpagarmepedido
 * @property string $codnegocio
 * @property string $codpessoa
 * @property string $codpagarmepos
 * @property string $codfilial
 * @property string $idpedido
 * @property string $valor
 * @property string $valorpago
 * @property string $valorcancelado
 * @property string $valorpagoliquido
 * @property boolean $fechado
 * @property integer $tipo
 * @property integer $parcelas
 * @property boolean $jurosloja
 * @property string $descricao
 * @property string $criacao
 * @property string $codusuariocriacao
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property Tblpagarmepagamento[] $tblpagarmepagamentos
 * @property Tblnegocio $codnegocio
 * @property Tblpessoa $codpessoa
 * @property Tblfilial $codfilial
 * @property Tblpagarmepos $codpagarmepos
 */
class PagarMePedido extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblpagarmepedido';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idpedido, valor', 'required'),
			array('tipo, parcelas, status', 'numerical', 'integerOnly'=>true),
			array('idpedido', 'length', 'max'=>30),
			array('valor, valorpago, valorcancelado, valorpagoliquido', 'length', 'max'=>14),
			array('descricao', 'length', 'max'=>50),
			array('codnegocio, codpessoa, codpagarmepos, codfilial, fechado, jurosloja, criacao, codusuariocriacao, alteracao, codusuarioalteracao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codpagarmepedido, codnegocio, codpessoa, codpagarmepos, codfilial, idpedido, valor, valorpago, valorcancelado, valorpagoliquido, fechado, tipo, parcelas, jurosloja, descricao, criacao, codusuariocriacao, alteracao, codusuarioalteracao, status', 'safe', 'on'=>'search'),
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
			'PagarMePagamentos' => array(self::HAS_MANY, 'PagarMePagamento', 'codpagarmepedido'),
			'Negocio' => array(self::BELONGS_TO, 'Negocio', 'codnegocio'),
			'Pessoa' => array(self::BELONGS_TO, 'Pessoa', 'codpessoa'),
			'Filial' => array(self::BELONGS_TO, 'Filial', 'codfilial'),
			'PagarMePos' => array(self::BELONGS_TO, 'PagarMePos', 'codpagarmepos'),
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
			'codpagarmepedido' => '#',
			'codnegocio' => 'Negocio',
			'codpessoa' => 'Pessoa',
			'codpagarmepos' => 'POS',
			'codfilial' => 'Filial',
			'idpedido' => 'ID Pedido',
			'valor' => 'Valor',
			'valorpago' => 'Pago',
			'valorcancelado' => 'Cancelado',
			'valorpagoliquido' => 'Pago Líquido',
			'fechado' => 'Fechado',
			'tipo' => 'Tipo',
			'parcelas' => 'Parcelas',
			'jurosloja' => 'Juros Loja',
			'descricao' => 'Descrição',
			'criacao' => 'Criação',
			'codusuariocriacao' => 'Usuario Criação',
			'alteracao' => 'Alteração',
			'codusuarioalteracao' => 'Usuario Alteração',
			'status' => 'Status',
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

		$criteria->compare('codpagarmepedido',$this->codpagarmepedido,true);
		$criteria->compare('codnegocio',$this->codnegocio,true);
		$criteria->compare('codpessoa',$this->codpessoa,true);
		$criteria->compare('codpagarmepos',$this->codpagarmepos,true);
		$criteria->compare('codfilial',$this->codfilial,true);
		$criteria->compare('idpedido',$this->idpedido,true);
		$criteria->compare('valor',$this->valor,true);
		$criteria->compare('valorpago',$this->valorpago,true);
		$criteria->compare('valorcancelado',$this->valorcancelado,true);
		$criteria->compare('valorpagoliquido',$this->valorpagoliquido,true);
		$criteria->compare('fechado',$this->fechado);
		$criteria->compare('tipo',$this->tipo);
		$criteria->compare('parcelas',$this->parcelas);
		$criteria->compare('jurosloja',$this->jurosloja);
		$criteria->compare('descricao',$this->descricao,true);
		$criteria->compare('criacao',$this->criacao,true);
		$criteria->compare('codusuariocriacao',$this->codusuariocriacao,true);
		$criteria->compare('alteracao',$this->alteracao,true);
		$criteria->compare('codusuarioalteracao',$this->codusuarioalteracao,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PagarMePedido the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

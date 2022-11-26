<?php

/**
 * This is the model class for table "mgsis.tblpagarmepagamento".
 *
 * The followings are the available columns in table 'mgsis.tblpagarmepagamento':
 * @property string $codpagarmepagamento
 * @property string $codpagarmepedido
 * @property string $nsu
 * @property string $codpagarmebandeira
 * @property string $nome
 * @property integer $tipo
 * @property string $autorizacao
 * @property integer $parcelas
 * @property boolean $jurosloja
 * @property string $transacao
 * @property string $codpagarmepos
 * @property string $idtransacao
 * @property string $identificador
 * @property string $valorpagamento
 * @property string $valorcancelamento
 * @property string $codfilial
 * @property string $criacao
 * @property string $codusuariocriacao
 * @property string $alteracao
 * @property string $codusuarioalteracao
 *
 * The followings are the available model relations:
 * @property Pagarmebandeira $codpagarmebandeira
 * @property Pagarmepedido $codpagarmepedido
 * @property Filial $codfilial
 * @property Usuario $codusuariocriacao
 * @property Usuario $codusuarioalteracao
 * @property Pagarmepos $codpagarmepos
 */
class PagarMePagamento extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblpagarmepagamento';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tipo, parcelas', 'numerical', 'integerOnly'=>true),
			array('nsu', 'length', 'max'=>20),
			array('nome, identificador', 'length', 'max'=>50),
			array('autorizacao', 'length', 'max'=>200),
			array('idtransacao', 'length', 'max'=>30),
			array('valorpagamento, valorcancelamento', 'length', 'max'=>14),
			array('codpagarmepedido, codpagarmebandeira, jurosloja, transacao, codpagarmepos, codfilial, criacao, codusuariocriacao, alteracao, codusuarioalteracao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codpagarmepagamento, codpagarmepedido, nsu, codpagarmebandeira, nome, tipo, autorizacao, parcelas, jurosloja, transacao, codpagarmepos, idtransacao, identificador, valorpagamento, valorcancelamento, codfilial, criacao, codusuariocriacao, alteracao, codusuarioalteracao', 'safe', 'on'=>'search'),
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
			'PagarMeBandeira' => array(self::BELONGS_TO, 'PagarMeBandeira', 'codpagarmebandeira'),
			'PagarMePedido' => array(self::BELONGS_TO, 'PagarMePedido', 'codpagarmepedido'),
			'Filial' => array(self::BELONGS_TO, 'Filial', 'codfilial'),
			'UsuarioCriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
			'UsuarioAlteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
			'PagarMePos' => array(self::BELONGS_TO, 'PagarMePos', 'codpagarmepos'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codpagarmepagamento' => '#',
			'codpagarmepedido' => 'Pedido',
			'nsu' => 'NSU',
			'codpagarmebandeira' => 'Bandeira',
			'nome' => 'Nome',
			'tipo' => 'Tipo',
			'autorizacao' => 'Autorização',
			'parcelas' => 'Parcelas',
			'jurosloja' => 'Jurosloja',
			'transacao' => 'Transação',
			'codpagarmepos' => 'POS',
			'idtransacao' => 'ID Transação',
			'identificador' => 'Identificador',
			'valorpagamento' => 'Pagamento',
			'valorcancelamento' => 'Cancelamento',
			'codfilial' => 'Filial',
			'criacao' => 'Criação',
			'codusuariocriacao' => 'Usuario Criação',
			'alteracao' => 'Alteração',
			'codusuarioalteracao' => 'Usuario Alteração',
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

		$criteria->compare('codpagarmepagamento',$this->codpagarmepagamento,true);
		$criteria->compare('codpagarmepedido',$this->codpagarmepedido,true);
		$criteria->compare('nsu',$this->nsu,true);
		$criteria->compare('codpagarmebandeira',$this->codpagarmebandeira,true);
		$criteria->compare('nome',$this->nome,true);
		$criteria->compare('tipo',$this->tipo);
		$criteria->compare('autorizacao',$this->autorizacao,true);
		$criteria->compare('parcelas',$this->parcelas);
		$criteria->compare('jurosloja',$this->jurosloja);
		$criteria->compare('transacao',$this->transacao,true);
		$criteria->compare('codpagarmepos',$this->codpagarmepos,true);
		$criteria->compare('idtransacao',$this->idtransacao,true);
		$criteria->compare('identificador',$this->identificador,true);
		$criteria->compare('valorpagamento',$this->valorpagamento,true);
		$criteria->compare('valorcancelamento',$this->valorcancelamento,true);
		$criteria->compare('codfilial',$this->codfilial,true);
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
	 * @return PagarMePagamento the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

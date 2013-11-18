<?php

/**
 * This is the model class for table "mgsis.tblusuario".
 *
 * The followings are the available columns in table 'mgsis.tblusuario':
 * @property string $codusuario
 * @property string $usuario
 * @property string $senha
 * @property string $codecf
 * @property string $codfilial
 * @property string $codoperacao
 * @property string $codpessoa
 * @property string $impressoratelanegocio
 * @property string $codportador
 *
 * The followings are the available model relations:
 * @property Filial[] $filials
 * @property Ecf $codecf
 * @property Filial $codfilial
 * @property Operacao $codoperacao
 * @property Pessoa $codpessoa
 * @property Portador $codportador
 * @property Liquidacaotitulo[] $liquidacaotitulos
 * @property Liquidacaotitulo[] $liquidacaotitulos1
 * @property Ecf[] $ecfs
 * @property Cobrancahistorico[] $cobrancahistoricos
 * @property Negocio[] $negocios
 * @property Negocio[] $negocios1
 * @property Produtohistoricopreco[] $produtohistoricoprecos
 */
class Usuario extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblusuario';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codusuario, usuario, codoperacao', 'required'),
			array('usuario', 'length', 'max'=>50),
			array('senha, impressoratelanegocio', 'length', 'max'=>100),
			array('codecf, codfilial, codpessoa, codportador', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codusuario, usuario, senha, codecf, codfilial, codoperacao, codpessoa, impressoratelanegocio, codportador', 'safe', 'on'=>'search'),
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
			'filials' => array(self::HAS_MANY, 'Filial', 'acbrnfemonitorcodusuario'),
			'codecf' => array(self::BELONGS_TO, 'Ecf', 'codecf'),
			'codfilial' => array(self::BELONGS_TO, 'Filial', 'codfilial'),
			'codoperacao' => array(self::BELONGS_TO, 'Operacao', 'codoperacao'),
			'codpessoa' => array(self::BELONGS_TO, 'Pessoa', 'codpessoa'),
			'codportador' => array(self::BELONGS_TO, 'Portador', 'codportador'),
			'liquidacaotitulos' => array(self::HAS_MANY, 'Liquidacaotitulo', 'codusuario'),
			'liquidacaotitulos1' => array(self::HAS_MANY, 'Liquidacaotitulo', 'codusuarioestorno'),
			'ecfs' => array(self::HAS_MANY, 'Ecf', 'codusuario'),
			'cobrancahistoricos' => array(self::HAS_MANY, 'Cobrancahistorico', 'codusuario'),
			'negocios' => array(self::HAS_MANY, 'Negocio', 'codusuario'),
			'negocios1' => array(self::HAS_MANY, 'Negocio', 'codusuarioacertoentrega'),
			'produtohistoricoprecos' => array(self::HAS_MANY, 'Produtohistoricopreco', 'codusuario'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codusuario' => 'Codusuario',
			'usuario' => 'Usuario',
			'senha' => 'Senha',
			'codecf' => 'Codecf',
			'codfilial' => 'Codfilial',
			'codoperacao' => 'Codoperacao',
			'codpessoa' => 'Codpessoa',
			'impressoratelanegocio' => 'Impressoratelanegocio',
			'codportador' => 'Codportador',
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

		$criteria->compare('codusuario',$this->codusuario,true);
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->compare('senha',$this->senha,true);
		$criteria->compare('codecf',$this->codecf,true);
		$criteria->compare('codfilial',$this->codfilial,true);
		$criteria->compare('codoperacao',$this->codoperacao,true);
		$criteria->compare('codpessoa',$this->codpessoa,true);
		$criteria->compare('impressoratelanegocio',$this->impressoratelanegocio,true);
		$criteria->compare('codportador',$this->codportador,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Usuario the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

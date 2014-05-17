<?php

/**
 * This is the model class for table "mgsis.tbltributacaonaturezaoperacao".
 *
 * The followings are the available columns in table 'mgsis.tbltributacaonaturezaoperacao':
 * @property string $codtributacaonaturezaoperacao
 * @property string $codtributacao
 * @property string $codnaturezaoperacao
 * @property string $codcfop
 * @property string $icmsbase
 * @property string $icmspercentual
 * @property string $codestado
 * @property string $csosn
 * @property string $codtipoproduto
 * @property integer $acumuladordominiovista
 * @property integer $acumuladordominioprazo
 * @property string $historicodominio
 * @property boolean $movimentacaofisica
 * @property boolean $movimentacaocontabil
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property Cfop $codcfop
 * @property Estado $codestado
 * @property Naturezaoperacao $codnaturezaoperacao
 * @property Tipoproduto $codtipoproduto
 * @property Tributacao $codtributacao
 * @property Usuario $UsuarioAlteracao
 * @property Usuario $UsuarioCriacao
 */
class TributacaoNaturezaOperacao extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tbltributacaonaturezaoperacao';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codtributacaonaturezaoperacao, codtributacao, codnaturezaoperacao, codcfop, csosn', 'required'),
			array('acumuladordominiovista, acumuladordominioprazo', 'numerical', 'integerOnly'=>true),
			array('icmsbase, icmspercentual', 'length', 'max'=>14),
			array('csosn', 'length', 'max'=>4),
			array('historicodominio', 'length', 'max'=>512),
			array('codestado, codtipoproduto, movimentacaofisica, movimentacaocontabil, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codtributacaonaturezaoperacao, codtributacao, codnaturezaoperacao, codcfop, icmsbase, icmspercentual, codestado, csosn, codtipoproduto, acumuladordominiovista, acumuladordominioprazo, historicodominio, movimentacaofisica, movimentacaocontabil, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
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
			'codcfop' => array(self::BELONGS_TO, 'Cfop', 'codcfop'),
			'codestado' => array(self::BELONGS_TO, 'Estado', 'codestado'),
			'codnaturezaoperacao' => array(self::BELONGS_TO, 'Naturezaoperacao', 'codnaturezaoperacao'),
			'codtipoproduto' => array(self::BELONGS_TO, 'Tipoproduto', 'codtipoproduto'),
			'codtributacao' => array(self::BELONGS_TO, 'Tributacao', 'codtributacao'),
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
			'codtributacaonaturezaoperacao' => 'Codtributacaonaturezaoperacao',
			'codtributacao' => 'Codtributacao',
			'codnaturezaoperacao' => 'Codnaturezaoperacao',
			'codcfop' => 'Codcfop',
			'icmsbase' => 'Icmsbase',
			'icmspercentual' => 'Icmspercentual',
			'codestado' => 'Codestado',
			'csosn' => 'Csosn',
			'codtipoproduto' => 'Codtipoproduto',
			'acumuladordominiovista' => 'Acumuladordominiovista',
			'acumuladordominioprazo' => 'Acumuladordominioprazo',
			'historicodominio' => 'Historicodominio',
			'movimentacaofisica' => 'Movimentacaofisica',
			'movimentacaocontabil' => 'Movimentacaocontabil',
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

		$criteria->compare('codtributacaonaturezaoperacao',$this->codtributacaonaturezaoperacao,true);
		$criteria->compare('codtributacao',$this->codtributacao,true);
		$criteria->compare('codnaturezaoperacao',$this->codnaturezaoperacao,true);
		$criteria->compare('codcfop',$this->codcfop,true);
		$criteria->compare('icmsbase',$this->icmsbase,true);
		$criteria->compare('icmspercentual',$this->icmspercentual,true);
		$criteria->compare('codestado',$this->codestado,true);
		$criteria->compare('csosn',$this->csosn,true);
		$criteria->compare('codtipoproduto',$this->codtipoproduto,true);
		$criteria->compare('acumuladordominiovista',$this->acumuladordominiovista);
		$criteria->compare('acumuladordominioprazo',$this->acumuladordominioprazo);
		$criteria->compare('historicodominio',$this->historicodominio,true);
		$criteria->compare('movimentacaofisica',$this->movimentacaofisica);
		$criteria->compare('movimentacaocontabil',$this->movimentacaocontabil);
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
	 * @return TributacaoNaturezaOperacao the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

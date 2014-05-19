<?php

/**
 * This is the model class for table "mgsis.tblprodutohistoricopreco".
 *
 * The followings are the available columns in table 'mgsis.tblprodutohistoricopreco':
 * @property string $codprodutohistoricopreco
 * @property string $codproduto
 * @property string $codprodutoembalagem
 * @property string $codusuario
 * @property string $precoantigo
 * @property string $preconovo
 * @property string $data
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property Produto $codproduto
 * @property Produtoembalagem $codprodutoembalagem
 * @property Usuario $codusuario
 * @property Usuario $codusuarioalteracao
 * @property Usuario $codusuariocriacao
 */
class ProdutoHistoricoPreco extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblprodutohistoricopreco';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codprodutohistoricopreco, codproduto, precoantigo, preconovo, data', 'required'),
			array('precoantigo, preconovo', 'length', 'max'=>14),
			array('codprodutoembalagem, codusuario, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codprodutohistoricopreco, codproduto, codprodutoembalagem, codusuario, precoantigo, preconovo, data, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
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
			'codproduto' => array(self::BELONGS_TO, 'Produto', 'codproduto'),
			'codprodutoembalagem' => array(self::BELONGS_TO, 'Produtoembalagem', 'codprodutoembalagem'),
			'codusuario' => array(self::BELONGS_TO, 'Usuario', 'codusuario'),
			'codusuarioalteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
			'codusuariocriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codprodutohistoricopreco' => 'Codprodutohistoricopreco',
			'codproduto' => 'Codproduto',
			'codprodutoembalagem' => 'Codprodutoembalagem',
			'codusuario' => 'Codusuario',
			'precoantigo' => 'Precoantigo',
			'preconovo' => 'Preconovo',
			'data' => 'Data',
			'alteracao' => 'Alteracao',
			'codusuarioalteracao' => 'Codusuarioalteracao',
			'criacao' => 'Criacao',
			'codusuariocriacao' => 'Codusuariocriacao',
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

		$criteria->compare('codprodutohistoricopreco',$this->codprodutohistoricopreco,true);
		$criteria->compare('codproduto',$this->codproduto,true);
		$criteria->compare('codprodutoembalagem',$this->codprodutoembalagem,true);
		$criteria->compare('codusuario',$this->codusuario,true);
		$criteria->compare('precoantigo',$this->precoantigo,true);
		$criteria->compare('preconovo',$this->preconovo,true);
		$criteria->compare('data',$this->data,true);
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
	 * @return ProdutoHistoricoPreco the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

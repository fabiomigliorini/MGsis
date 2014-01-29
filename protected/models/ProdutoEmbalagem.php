<?php

/**
 * This is the model class for table "mgsis.tblprodutoembalagem".
 *
 * The followings are the available columns in table 'mgsis.tblprodutoembalagem':
 * @property string $codprodutoembalagem
 * @property string $codproduto
 * @property string $codunidademedida
 * @property string $quantidade
 * @property string $preco
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property Produtohistoricopreco[] $produtohistoricoprecos
 * @property Produto $codproduto
 * @property Unidademedida $codunidademedida
 * @property Usuario $codusuarioalteracao
 * @property Usuario $codusuariocriacao
 * @property Produtobarra[] $produtobarras
 */
class ProdutoEmbalagem extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblprodutoembalagem';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codprodutoembalagem', 'required'),
			array('quantidade, preco', 'length', 'max'=>14),
			array('codproduto, codunidademedida, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codprodutoembalagem, codproduto, codunidademedida, quantidade, preco, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
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
			'ProdutoHistoricoPrecos' => array(self::HAS_MANY, 'ProdutoHistoricoPreco', 'codprodutoembalagem'),
			'Produto' => array(self::BELONGS_TO, 'Produto', 'codproduto'),
			'UnidadeMedida' => array(self::BELONGS_TO, 'UnidadeMedida', 'codunidademedida'),
			'UsuarioAlteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
			'UsuarioCriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
			'ProdutoBarras' => array(self::HAS_MANY, 'ProdutoBarra', 'codprodutoembalagem'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codprodutoembalagem' => 'Codprodutoembalagem',
			'codproduto' => 'Codproduto',
			'codunidademedida' => 'Codunidademedida',
			'quantidade' => 'Quantidade',
			'preco' => 'Preco',
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

		$criteria->compare('codprodutoembalagem',$this->codprodutoembalagem,true);
		$criteria->compare('codproduto',$this->codproduto,true);
		$criteria->compare('codunidademedida',$this->codunidademedida,true);
		$criteria->compare('quantidade',$this->quantidade,true);
		$criteria->compare('preco',$this->preco,true);
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
	 * @return ProdutoEmbalagem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

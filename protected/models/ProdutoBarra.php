<?php

/**
 * This is the model class for table "mgsis.tblprodutobarra".
 *
 * The followings are the available columns in table 'mgsis.tblprodutobarra':
 * @property string $codprodutobarra
 * @property string $codproduto
 * @property string $variacao
 * @property string $barras
 * @property string $referencia
 * @property string $codmarca
 * @property string $codprodutoembalagem
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property Notafiscalprodutobarra[] $notafiscalprodutobarras
 * @property Negocioprodutobarra[] $negocioprodutobarras
 * @property Cupomfiscalprodutobarra[] $cupomfiscalprodutobarras
 * @property Produto $codproduto
 * @property Produtoembalagem $codprodutoembalagem
 * @property Usuario $codusuarioalteracao
 * @property Usuario $codusuariocriacao
 */
class ProdutoBarra extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblprodutobarra';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codproduto, barras', 'required'),
			array('barras', 'unique'),
			array('variacao', 'length', 'max'=>100),
			array('codmarca', 'validaMarca'),
			array('barras, referencia', 'length', 'max'=>50),
			array('codmarca, codprodutoembalagem, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codprodutobarra, codproduto, variacao, barras, referencia, codmarca, codprodutoembalagem, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
		);
	}
	
	public function validaMarca($attribute, $params)
	{
		if (empty($this->codmarca))
			return;
		
		if ($this->codmarca = $this->Produto->codmarca)
			$this->addError($attribute, 'Você selecionou a mesma marca informada no Produto, neste caso deixe em branco. Só preencha quando a marca for diferente da marca principal do produto!');
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'NotaFiscalProdutoBarras' => array(self::HAS_MANY, 'NotaFiscalProdutoBarra', 'codprodutobarra'),
			'NegocioProdutoBarras' => array(self::HAS_MANY, 'NegocioProdutoBarra', 'codprodutobarra'),
			'CupomFiscalProdutoBarras' => array(self::HAS_MANY, 'CupomFiscalProdutoBarra', 'codprodutobarra'),
			'Produto' => array(self::BELONGS_TO, 'Produto', 'codproduto'),
			'ProdutoEmbalagem' => array(self::BELONGS_TO, 'ProdutoEmbalagem', 'codprodutoembalagem'),
			'Marca' => array(self::BELONGS_TO, 'Marca', 'codmarca'),
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
			'codprodutobarra' => '#',
			'codproduto' => 'Produto',
			'variacao' => 'Variação',
			'barras' => 'Barras',
			'referencia' => 'Referência',
			'codmarca' => 'Marca',
			'codprodutoembalagem' => 'Embalagem',
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

		$criteria->compare('codprodutobarra',$this->codprodutobarra,true);
		$criteria->compare('codproduto',$this->codproduto,true);
		$criteria->compare('variacao',$this->variacao,true);
		$criteria->compare('barras',$this->barras,true);
		$criteria->compare('referencia',$this->referencia,true);
		$criteria->compare('codmarca',$this->codmarca,true);
		$criteria->compare('codprodutoembalagem',$this->codprodutoembalagem,true);
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
	 * @return ProdutoBarra the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

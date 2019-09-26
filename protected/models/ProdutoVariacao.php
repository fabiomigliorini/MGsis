<?php

/**
 * This is the model class for table "mgsis.tblprodutovariacao".
 *
 * The followings are the available columns in table 'mgsis.tblprodutovariacao':
 * @property string $codprodutovariacao
 * @property string $codproduto
 * @property string $variacao
 * @property string $referencia
 * @property string $codmarca
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property Marca $Marca
 * @property Usuario $UsuarioAlteracao
 * @property Usuario $UsuarioCriacao
 * @property Produto $Produto
 * @property EstoqueLocalProdutoVariacao[] $EstoqueLocalProdutoVariacaoS
 * @property ProdutoBarra[] $ProdutoBarraS
 */
class ProdutoVariacao extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblprodutovariacao';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codproduto', 'required'),
			array('variacao', 'length', 'max'=>100),
			array('referencia', 'length', 'max'=>50),
			array('codmarca, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codprodutovariacao, codproduto, variacao, referencia, codmarca, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
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
			'Marca' => array(self::BELONGS_TO, 'Marca', 'codmarca'),
			'UsuarioAlteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
			'UsuarioCriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
			'Produto' => array(self::BELONGS_TO, 'Produto', 'codproduto'),
			'EstoqueLocalProdutoVariacaoS' => array(self::HAS_MANY, 'EstoqueLocalProdutoVariacao', 'codprodutovariacao'),
			'ProdutoBarraS' => array(self::HAS_MANY, 'Produtobarra', 'codprodutovariacao'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codprodutovariacao' => 'Codprodutovariacao',
			'codproduto' => 'Codproduto',
			'variacao' => 'Variacao',
			'referencia' => 'Referencia',
			'codmarca' => 'Codmarca',
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

		$criteria->compare('codprodutovariacao',$this->codprodutovariacao,true);
		$criteria->compare('codproduto',$this->codproduto,true);
		$criteria->compare('variacao',$this->variacao,true);
		$criteria->compare('referencia',$this->referencia,true);
		$criteria->compare('codmarca',$this->codmarca,true);
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
	 * @return ProdutoVariacao the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function barrasCadastrado($barras)
	{
			$command = Yii::app()->db->createCommand('
				SELECT count(codprodutobarra) AS count
				  FROM tblprodutobarra
				 WHERE codprodutovariacao = :codprodutovariacao
				   AND barras = :barras
			');
			$command->params = [
				"codprodutovariacao" => $this->codprodutovariacao,
				"barras" => $barras,
			];
			$ret = $command->queryRow();
			return $ret['count'] > 0;
	}

}

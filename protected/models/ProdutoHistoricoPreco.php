<?php

/**
 * This is the model class for table "mgsis.tblprodutohistoricopreco".
 *
 * The followings are the available columns in table 'mgsis.tblprodutohistoricopreco':
 * @property string $codprodutohistoricopreco
 * @property string $codproduto
 * @property string $codprodutoembalagem
 * @property string $precoantigo
 * @property string $preconovo
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property Produto $Produto
 * @property ProdutoEmbalagem $ProdutoEmbalagem
 * @property Usuario $Usuario
 * @property Usuario $UsuarioAlteracao
 * @property Usuario $UsuarioCriacao
 */
class ProdutoHistoricoPreco extends MGActiveRecord
{
	public $produto;
	public $referencia;
	public $codmarca;
	public $codusuariocriacao;
	public $alteracao_de;
	public $alteracao_ate;
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
			array('codproduto', 'required'),
			array('precoantigo, preconovo', 'length', 'max'=>14),
			array('codprodutoembalagem, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('alteracao_de, alteracao_ate, codusuariocriacao, codmarca, referencia, produto, codprodutohistoricopreco, codproduto, codprodutoembalagem, precoantigo, preconovo, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
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
			'Produto' => array(self::BELONGS_TO, 'Produto', 'codproduto'),
			'ProdutoEmbalagem' => array(self::BELONGS_TO, 'ProdutoEmbalagem', 'codprodutoembalagem'),
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
			'codprodutohistoricopreco' => '#',
			'codproduto' => 'Produto',
			'codprodutoembalagem' => 'Produto Embalagem',
			'precoantigo' => 'Preço Antigo',
			'preconovo' => 'Novo Preço',
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
	public function search($comoDataProvider = true)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('t.codprodutohistoricopreco',$this->codprodutohistoricopreco,false);
		//$criteria->compare('codproduto',$this->codproduto,false);
		$criteria->compare('t.codproduto',Yii::app()->format->numeroLimpo($this->codproduto),false);
		$criteria->compare('t.codprodutoembalagem',$this->codprodutoembalagem,false);
		$criteria->compare('t.precoantigo',$this->precoantigo,false);
		$criteria->compare('t.preconovo',$this->preconovo,false);
		$criteria->compare('t.alteracao',$this->alteracao,false);
		$criteria->compare('t.codusuarioalteracao',$this->codusuarioalteracao,false);
		$criteria->compare('t.criacao',$this->criacao,false);
		//$criteria->compare('t.codusuariocriacao',$this->codusuariocriacao,false);
		$criteria->compare('t.codusuariocriacao',Yii::app()->format->numeroLimpo($this->codusuariocriacao),false);
		
		$criteria->order = 't.alteracao DESC';
		$criteria->with[] = 'Produto';
		
		if (!empty($this->produto))
		{
			$criteria->addCondition('"Produto".produto ilike :produto');
			$criteria->params[':produto'] = '%' . str_replace(' ', '%', trim($this->produto)) . '%';
		}
		
		if (!empty($this->produto))
		{
			$criteria->addCondition('"Produto".referencia ilike :referencia');
			$criteria->params[':referencia'] = '%' . str_replace(' ', '%', trim($this->referencia)) . '%';
		}

		//$criteria->compare('"Produto".referencia', $this->referencia);
		$criteria->compare('"Produto".codmarca', $this->codmarca);
		//$criteria->compare('"Produto".codusuariocriacao', $this->codusuariocriacao);
		
		if ($alteracao_de = DateTime::createFromFormat("d/m/y",$this->alteracao_de))
		{
			$criteria->addCondition('t.alteracao >= :alteracao_de');
			$criteria->params[':alteracao_de'] = $alteracao_de->format('Y-m-d').' 00:00:00.0';
		}
		if ($alteracao_ate = DateTime::createFromFormat("d/m/y",$this->alteracao_ate))
		{
			$criteria->addCondition('t.alteracao <= :alteracao_ate');
			$criteria->params[':alteracao_ate'] = $alteracao_ate->format('Y-m-d').' 23:59:59.9';
		}
		
		$criteria->order = 't.alteracao DESC';
		
		if ($comoDataProvider)
		{
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>array('pageSize'=>20)
			));
		}
		else
		{
			return $this->findAll($criteria);
		}

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

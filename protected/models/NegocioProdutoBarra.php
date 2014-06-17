<?php

/**
 * This is the model class for table "mgsis.tblnegocioprodutobarra".
 *
 * The followings are the available columns in table 'mgsis.tblnegocioprodutobarra':
 * @property string $codnegocioprodutobarra
 * @property string $codnegocio
 * @property string $quantidade
 * @property string $valorunitario
 * @property string $valortotal
 * @property string $codprodutobarra
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property Negocio $Negocio
 * @property ProdutoBarra $ProdutoBarra
 * @property Usuario $UsuarioAlteracao
 * @property Usuario $UsuarioCriacao
 * @property NotaFiscalProdutoBarra[] $NotaFiscalProdutoBarras
 * @property EstoqueMovimento[] $EstoqueMovimentos
 * @property CupomFiscalProdutoBarra[] $CupomFiscalProdutoBarras
 */
class NegocioProdutoBarra extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblnegocioprodutobarra';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codnegocio, quantidade, valorunitario, valortotal, codprodutobarra', 'required'),
			array('quantidade, valorunitario, valortotal', 'numerical', 'min' => 0.01),
			array('codnegocio', 'validaStatusNegocio'),
			array('quantidade, valorunitario, valortotal', 'length', 'max'=>14),
			array('alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codnegocioprodutobarra, codnegocio, quantidade, valorunitario, valortotal, codprodutobarra, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
		);
	}

	
	public function validaStatusNegocio($attribute, $params)
	{
		if (empty($this->Negocio))
			return;
		
		if ($this->Negocio->codnegociostatus != 1)
			$this->addError($attribute, 'O status do Negócio não permite alterações!');
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
			'ProdutoBarra' => array(self::BELONGS_TO, 'ProdutoBarra', 'codprodutobarra'),
			'UsuarioAlteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
			'UsuarioCriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
			'NotaFiscalProdutoBarras' => array(self::HAS_MANY, 'NotaFiscalProdutoBarra', 'codnegocioprodutobarra'),
			'EstoqueMovimentos' => array(self::HAS_MANY, 'EstoqueMovimento', 'codnegocioprodutobarra'),
			'CupomFiscalProdutoBarras' => array(self::HAS_MANY, 'CupomFiscalProdutoBarra', 'codnegocioprodutobarra'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codnegocioprodutobarra' => '#',
			'codnegocio' => 'Negócio',
			'quantidade' => 'Quantidade',
			'valorunitario' => 'Preço',
			'valortotal' => 'Total',
			'codprodutobarra' => 'Produto',
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

		$criteria->compare('codnegocioprodutobarra',$this->codnegocioprodutobarra,true);
		$criteria->compare('codnegocio',$this->codnegocio,true);
		$criteria->compare('quantidade',$this->quantidade,true);
		$criteria->compare('valorunitario',$this->valorunitario,true);
		$criteria->compare('valortotal',$this->valortotal,true);
		$criteria->compare('codprodutobarra',$this->codprodutobarra,true);
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
	 * @return NegocioProdutoBarra the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

<?php

/**
 * This is the model class for table "mgsis.tblnotafiscalprodutobarra".
 *
 * The followings are the available columns in table 'mgsis.tblnotafiscalprodutobarra':
 * @property string $codnotafiscalprodutobarra
 * @property string $codnotafiscal
 * @property string $codprodutobarra
 * @property string $codcfop
 * @property string $descricaoalternativa
 * @property string $quantidade
 * @property string $valorunitario
 * @property string $valortotal
 * @property string $icmsbase
 * @property string $icmspercentual
 * @property string $icmsvalor
 * @property string $ipibase
 * @property string $ipipercentual
 * @property string $ipivalor
 * @property string $icmsstbase
 * @property string $icmsstpercentual
 * @property string $icmsstvalor
 * @property string $csosn
 * @property string $codnegocioprodutobarra
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property Cfop $Cfop
 * @property NegocioProdutoBarra $NegocioProdutoBarra
 * @property NotaFiscal $NotaFiscal
 * @property ProdutoBarra $ProdutoBarra
 * @property Usuario $UsuarioAlteracao
 * @property Usuario $UsuarioCriacao
 * @property EstoqueMovimento[] $EstoqueMovimentos
 */
class NotaFiscalProdutoBarra extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblnotafiscalprodutobarra';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codnotafiscal, codprodutobarra, codcfop, quantidade, valorunitario, valortotal, csosn', 'required'),
			array('descricaoalternativa', 'length', 'max'=>100),
			array('quantidade, valorunitario, valortotal, icmsbase, icmspercentual, icmsvalor, ipibase, ipipercentual, ipivalor, icmsstbase, icmsstpercentual, icmsstvalor', 'length', 'max'=>14),
			array('csosn', 'length', 'max'=>4),
			array('codnegocioprodutobarra, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codnotafiscalprodutobarra, codnotafiscal, codprodutobarra, codcfop, descricaoalternativa, quantidade, valorunitario, valortotal, icmsbase, icmspercentual, icmsvalor, ipibase, ipipercentual, ipivalor, icmsstbase, icmsstpercentual, icmsstvalor, csosn, codnegocioprodutobarra, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
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
			'Cfop' => array(self::BELONGS_TO, 'Cfop', 'codcfop'),
			'NegocioProdutoBarra' => array(self::BELONGS_TO, 'NegocioProdutoBarra', 'codnegocioprodutobarra'),
			'NotaFiscal' => array(self::BELONGS_TO, 'NotaFiscal', 'codnotafiscal'),
			'ProdutoBarra' => array(self::BELONGS_TO, 'ProdutoBarra', 'codprodutobarra'),
			'UsuarioAlteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
			'UsuarioCriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
			'EstoqueMovimentos' => array(self::HAS_MANY, 'EstoqueMovimento', 'codnotafiscalprodutobarra'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codnotafiscalprodutobarra' => '#',
			'codnotafiscal' => 'Nota Fiscal',
			'codprodutobarra' => 'Produto',
			'codcfop' => 'CFOP',
			'descricaoalternativa' => 'Descrição Alternativa',
			'quantidade' => 'Quantidade',
			'valorunitario' => 'Preço',
			'valortotal' => 'Total',
			'icmsbase' => 'ICMS Base',
			'icmspercentual' => 'ICMS %',
			'icmsvalor' => 'ICMS Valor',
			'ipibase' => 'IPI Base',
			'ipipercentual' => 'IPI %',
			'ipivalor' => 'IPI Valor',
			'icmsstbase' => 'ST Base',
			'icmsstpercentual' => 'ST %',
			'icmsstvalor' => 'ST Valor',
			'csosn' => 'CSOSN',
			'codnegocioprodutobarra' => 'Negocio',
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

		$criteria->compare('codnotafiscalprodutobarra',$this->codnotafiscalprodutobarra,true);
		$criteria->compare('codnotafiscal',$this->codnotafiscal,true);
		$criteria->compare('codprodutobarra',$this->codprodutobarra,true);
		$criteria->compare('codcfop',$this->codcfop,true);
		$criteria->compare('descricaoalternativa',$this->descricaoalternativa,true);
		$criteria->compare('quantidade',$this->quantidade,true);
		$criteria->compare('valorunitario',$this->valorunitario,true);
		$criteria->compare('valortotal',$this->valortotal,true);
		$criteria->compare('icmsbase',$this->icmsbase,true);
		$criteria->compare('icmspercentual',$this->icmspercentual,true);
		$criteria->compare('icmsvalor',$this->icmsvalor,true);
		$criteria->compare('ipibase',$this->ipibase,true);
		$criteria->compare('ipipercentual',$this->ipipercentual,true);
		$criteria->compare('ipivalor',$this->ipivalor,true);
		$criteria->compare('icmsstbase',$this->icmsstbase,true);
		$criteria->compare('icmsstpercentual',$this->icmsstpercentual,true);
		$criteria->compare('icmsstvalor',$this->icmsstvalor,true);
		$criteria->compare('csosn',$this->csosn,true);
		$criteria->compare('codnegocioprodutobarra',$this->codnegocioprodutobarra,true);
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
	 * @return NotaFiscalProdutoBarra the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	protected function beforeValidate()
	{
		$this->calculaTributacao();
		return parent::beforeValidate();
	}
	
	public function calculaTributacao($somenteVazios = true)
	{
		if ((!empty($this->codcfop) && !empty($this->csosn)) || !$somenteVazios)
			return true;
		
		if (empty($this->ProdutoBarra))
		{
			$this->addError('codprodutobarra', 'Erro ao calcular tributação. Produto não informado!');
			return false;
		}
		
		if (empty($this->NotaFiscal))
		{
			$this->addError('codnotafiscal', 'Erro ao calcular tributação. Nota Fiscal não informada!');
			return false;
		}
		
		if (empty($this->NotaFiscal->Pessoa))
		{
			$this->addError('codnotafiscal', 'Erro ao calcular tributação. Pessoa não informada na Nota Fiscal!');
			return false;
		}

		$trib = TributacaoNaturezaOperacao::model()->find(
			'codtributacao = :codtributacao
			AND codtipoproduto = :codtipoproduto
			AND codnaturezaoperacao = :codnaturezaoperacao
			AND codestado = :codestado
			',
			array(
				':codtributacao' => $this->ProdutoBarra->Produto->codtributacao,
				':codtipoproduto' => $this->ProdutoBarra->Produto->codtipoproduto,
				':codnaturezaoperacao' => $this->NotaFiscal->codnaturezaoperacao,
				':codestado' => $this->NotaFiscal->Pessoa->Cidade->codestado,
				)
			);
		
		if ($trib === null)
			$trib = TributacaoNaturezaOperacao::model()->find(
				'codtributacao = :codtributacao
				AND codtipoproduto = :codtipoproduto
				AND codnaturezaoperacao = :codnaturezaoperacao
				AND codestado IS NULL
				',
				array(
					':codtributacao' => $this->ProdutoBarra->Produto->codtributacao,
					':codtipoproduto' => $this->ProdutoBarra->Produto->codtipoproduto,
					':codnaturezaoperacao' => $this->NotaFiscal->codnaturezaoperacao,
					)
				);
			
		if ($trib === null)
		{
			$this->addError('codprodutobarra', 'Erro ao calcular tributação. Impossível localizar tributação para o produto informado!');
			return false;
		}
		
		//Traz codigos de tributacao
		$this->codcfop = $trib->codcfop;
		$this->csosn = $trib->csosn;
		
		//Calcula ICMS
		If (!empty($this->valortotal))
		{
			If (!empty($trib->icmsbase))
				$this->icmsbase = round(($trib->icmsbase * $this->valortotal)/100, 2);

			$this->icmspercentual = $trib->icmspercentual;

			If ((!empty($this->icmsbase)) and (!empty($this->icmspercentual)))
				$this->icmsvalor = round(($this->icmsbase * $this->icmspercentual)/100, 2);
		}

	}
}

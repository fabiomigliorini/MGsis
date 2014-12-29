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
 * @property string $icmscst
 * @property string $ipicst
 * @property string $piscst
 * @property string $cofinscst
 * @property string $pispercentual
 * @property string $cofinspercentual
 * @property string $csllpercentual
 * @property string $irpjpercentual
 * @property string $pisbase
 * @property string $pisvalor
 * @property string $cofinsbase
 * @property string $cofinsvalor
 * @property string $csllbase
 * @property string $csllvalor
 * @property string $irpjbase
 * @property string $irpjvalor
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
	
	public $codproduto;
	public $codfilial;
	public $codpessoa;
	public $saida_de;
	public $saida_ate;
	public $codnaturezaoperacao;
	
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
			array('codnotafiscal, codprodutobarra, codcfop, quantidade, valorunitario, valortotal', 'required'),
			array('descricaoalternativa', 'length', 'max'=>100),
			array('quantidade, valorunitario, valortotal, icmsbase, icmspercentual, icmsvalor, ipibase, ipipercentual, ipivalor, icmsstbase, icmsstpercentual, icmsstvalor, pisbase, pisvalor, cofinsbase, cofinsvalor, csllbase, csllvalor, irpjbase, irpjvalor', 'length', 'max'=>14),
			array('csosn', 'length', 'max'=>4),
			array('pispercentual, cofinspercentual, csllpercentual, irpjpercentual', 'length', 'max'=>5),
			array('icmscst, ipicst, piscst, cofinscst', 'length', 'max'=>3),
			array('codnegocioprodutobarra, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codnaturezaoperacao, saida_de, saida_ate, codpessoa, codfilial, codproduto, codnotafiscalprodutobarra, codnotafiscal, codprodutobarra, codcfop, descricaoalternativa, quantidade, valorunitario, valortotal, icmsbase, icmspercentual, icmsvalor, ipibase, ipipercentual, ipivalor, icmsstbase, icmsstpercentual, icmsstvalor, csosn, codnegocioprodutobarra, alteracao, codusuarioalteracao, criacao, codusuariocriacao, icmscst, ipicst, piscst, cofinscst, pispercentual, cofinspercentual, csllpercentual, irpjpercentual, pisbase, pisvalor, cofinsbase, cofinsvalor, csllbase, csllvalor, irpjbase, irpjvalor', 'safe', 'on'=>'search'),
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
			
			'codnegocioprodutobarra' => 'Negocio',
			'alteracao' => 'Alteração',
			'codusuarioalteracao' => 'Usuário Alteração',
			'criacao' => 'Criação',
			'codusuariocriacao' => 'Usuário Criação',
			
			'csosn' => 'CSOSN',
			'icmscst' => 'ICMS CST',
			'icmsbase' => 'ICMS Base',
			'icmspercentual' => 'ICMS %',
			'icmsvalor' => 'ICMS Valor',
			
			'icmsstbase' => 'ST Base',
			'icmsstpercentual' => 'ST %',
			'icmsstvalor' => 'ST Valor',
			
			'ipicst' => 'IPI CST',
			'ipibase' => 'IPI Base',
			'ipipercentual' => 'IPI %',
			'ipivalor' => 'IPI Valor',
			
			'piscst' => 'PIS CST',
			'pisbase' => 'PIS Base',
			'pispercentual' => 'PIS %',
			'pisvalor' => 'PIS Valor',
			
			'cofinscst' => 'Cofins CST',
			'cofinsbase' => 'Cofins Base',
			'cofinspercentual' => 'Cofins %',
			'cofinsvalor' => 'Cofins Valor',
			
			'csllbase' => 'CSLL Base',
			'csllpercentual' => 'CSLL %',
			'csllvalor' => 'CSLL Valor',
			
			'irpjbase' => 'IRPJ Base',
			'irpjpercentual' => 'IRPJ %',
			'irpjvalor' => 'IRPJ Valor',
			
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

		$criteria->compare('codnotafiscalprodutobarra',$this->codnotafiscalprodutobarra, false);
		$criteria->compare('codnotafiscal',$this->codnotafiscal, false);
		$criteria->compare('codprodutobarra',$this->codprodutobarra, false);
		$criteria->compare('codcfop',$this->codcfop, false);
		$criteria->compare('descricaoalternativa',$this->descricaoalternativa,true);
		$criteria->compare('quantidade',$this->quantidade, false);
		$criteria->compare('valorunitario',$this->valorunitario, false);
		$criteria->compare('valortotal',$this->valortotal, false);
		$criteria->compare('icmsbase',$this->icmsbase, false);
		$criteria->compare('icmspercentual',$this->icmspercentual, false);
		$criteria->compare('icmsvalor',$this->icmsvalor, false);
		$criteria->compare('ipibase',$this->ipibase, false);
		$criteria->compare('ipipercentual',$this->ipipercentual, false);
		$criteria->compare('ipivalor',$this->ipivalor, false);
		$criteria->compare('icmsstbase',$this->icmsstbase, false);
		$criteria->compare('icmsstpercentual',$this->icmsstpercentual, false);
		$criteria->compare('icmsstvalor',$this->icmsstvalor, false);
		$criteria->compare('csosn',$this->csosn, false);
		$criteria->compare('codnegocioprodutobarra',$this->codnegocioprodutobarra, false);
		$criteria->compare('alteracao',$this->alteracao, false);
		$criteria->compare('codusuarioalteracao',$this->codusuarioalteracao, false);
		$criteria->compare('criacao',$this->criacao, false);
		$criteria->compare('codusuariocriacao',$this->codusuariocriacao, false);
		
		if (!empty($this->codproduto))
		{
			$criteria->compare('"ProdutoBarra".codproduto', $this->codproduto);
			$criteria->with[] = 'ProdutoBarra';
		}
		
		$criteria->with[] = 'NotaFiscal';
		$criteria->order = '"NotaFiscal".saida DESC, "NotaFiscal".codfilial ASC, "NotaFiscal".numero DESC';
		
		$criteria->compare('"NotaFiscal".codfilial', $this->codfilial);
		$criteria->compare('"NotaFiscal".codpessoa', $this->codpessoa);
		$criteria->compare('"NotaFiscal".codnaturezaoperacao', $this->codnaturezaoperacao);
		if ($saida_de = DateTime::createFromFormat("d/m/y",$this->saida_de))
		{
			$criteria->addCondition('"NotaFiscal".saida >= :saida_de');
			$criteria->params = array_merge($criteria->params, array(':saida_de' => $saida_de->format('Y-m-d')));
		}
		if ($saida_ate = DateTime::createFromFormat("d/m/y",$this->saida_ate))
		{
			$criteria->addCondition('"NotaFiscal".saida <= :saida_ate');
			$criteria->params = array_merge($criteria->params, array(':saida_ate' => $saida_ate->format('Y-m-d')));
		}
		
		
		$criteria->compare('icmscst',$this->icmscst,false);
		$criteria->compare('ipicst',$this->ipicst,false);
		$criteria->compare('piscst',$this->piscst,false);
		$criteria->compare('cofinscst',$this->cofinscst,false);
		$criteria->compare('pispercentual',$this->pispercentual,false);
		$criteria->compare('cofinspercentual',$this->cofinspercentual,false);
		$criteria->compare('csllpercentual',$this->csllpercentual,false);
		$criteria->compare('irpjpercentual',$this->irpjpercentual,false);
		$criteria->compare('pisbase',$this->pisbase,false);
		$criteria->compare('pisvalor',$this->pisvalor,false);
		$criteria->compare('cofinsbase',$this->cofinsbase,false);
		$criteria->compare('cofinsvalor',$this->cofinsvalor,false);
		$criteria->compare('csllbase',$this->csllbase,false);
		$criteria->compare('csllvalor',$this->csllvalor,false);
		$criteria->compare('irpjbase',$this->irpjbase,false);
		$criteria->compare('irpjvalor',$this->irpjvalor,false);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>15),
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
		
		//Calcula ICMSs
		If (!empty($this->valortotal) && ($this->NotaFiscal->emitida))
		{
			If (!empty($trib->icmsbase))
				$this->icmsbase = round(($trib->icmsbase * $this->valortotal)/100, 2);

			$this->icmspercentual = $trib->icmspercentual;

			If ((!empty($this->icmsbase)) and (!empty($this->icmspercentual)))
				$this->icmsvalor = round(($this->icmsbase * $this->icmspercentual)/100, 2);
		}

	}
}

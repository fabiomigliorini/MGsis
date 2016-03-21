<?php

/**
 * This is the model class for table "mgsis.tblnotafiscalprodutobarra".
 *
 * The followings are the available columns in table 'mgsis.tblnotafiscalprodutobarra':
 * @property bigserial $codnotafiscalprodutobarra
 * @property bigint $codnotafiscal
 * @property bigint $codnotafiscalprodutobarraorigem
 * @property bigint $codprodutobarra
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
 * @property NotaFiscalProdutoBarra[] $NotaFiscalProdutoBarras
 * @property NotaFiscalProdutoBarra $NotaFiscalProdutoBarraOrigem
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
			array('csosn', 'validaCsosn'),
			array('icmscst, ipicst, piscst, cofinscst', 'validaCst'),
			array('pispercentual, cofinspercentual, csllpercentual, irpjpercentual', 'length', 'max'=>5),
			array('icmscst, ipicst, piscst, cofinscst', 'length', 'max'=>3),
			array('codnegocioprodutobarra, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codnaturezaoperacao, saida_de, saida_ate, codpessoa, codfilial, codproduto, codnotafiscalprodutobarra, codnotafiscal, codprodutobarra, codcfop, descricaoalternativa, quantidade, valorunitario, valortotal, icmsbase, icmspercentual, icmsvalor, ipibase, ipipercentual, ipivalor, icmsstbase, icmsstpercentual, icmsstvalor, csosn, codnegocioprodutobarra, alteracao, codusuarioalteracao, criacao, codusuariocriacao, icmscst, ipicst, piscst, cofinscst, pispercentual, cofinspercentual, csllpercentual, irpjpercentual, pisbase, pisvalor, cofinsbase, cofinsvalor, csllbase, csllvalor, irpjbase, irpjvalor', 'safe', 'on'=>'search'),
		);
	}

	//verifica se o numero tem pelo menos 10 digitos
	public function validaCsosn($attribute,$params)
	{
		if ($this->NotaFiscal->Filial->crt != Filial::CRT_REGIME_NORMAL && empty($this->$attribute))
			$this->addError($attribute,'CSOSN deve ser preenchido!');
		
		if ($this->NotaFiscal->Filial->crt == Filial::CRT_REGIME_NORMAL && !empty($this->$attribute))
			$this->addError($attribute,'CSOSN não deve ser preenchido!');
	}	
	
	//verifica se o numero tem pelo menos 10 digitos
	public function validaCst($attribute,$params)
	{
		if ($this->NotaFiscal->Filial->crt == Filial::CRT_REGIME_NORMAL && empty($this->$attribute))
			$this->addError($attribute,'CST deve ser preenchido!');
		
		if ($this->NotaFiscal->Filial->crt != Filial::CRT_REGIME_NORMAL && !empty($this->$attribute))
			$this->addError($attribute,'CST não deve ser preenchido!');
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
			'NotaFiscalProdutoBarras' => array(self::HAS_MANY, 'NotaFiscalProdutoBarra', 'codnotafiscalprodutobarraorigem'),
			'NotaFiscalProdutoBarraOrigem' => array(self::BELONGS_TO, 'NotaFiscalProdutoBarra', 'codnotafiscalprodutobarraorigem'),
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
			
			'codnegocioprodutobarra' => 'Negócio',
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
		if ((!empty($this->codcfop) && (!empty($this->csosn) || !empty($this->icmscst))) || !$somenteVazios)
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
		
		if (empty($this->NotaFiscal->Filial))
		{
			$this->addError('codnotafiscal', 'Erro ao calcular tributação. Filial não informada na Nota Fiscal!');
			return false;
		}
		
		if ($this->NotaFiscal->Pessoa->Cidade->Estado == $this->NotaFiscal->Filial->Pessoa->Cidade->Estado)
		    $filtroEstado = 'codestado = :codestado';
		else
		    $filtroEstado = '(codestado = :codestado or codestado is null)';

		$trib = TributacaoNaturezaOperacao::model()->find(
			array(
			    'condition' => 
					'   codtributacao = :codtributacao
					AND codtipoproduto = :codtipoproduto
					AND codnaturezaoperacao = :codnaturezaoperacao
					AND ' . $filtroEstado . '
					AND (:ncm ilike ncm || \'%\' or ncm is null)
					',
			    'params' => array(
					':codtributacao' => $this->ProdutoBarra->Produto->codtributacao,
					':codtipoproduto' => $this->ProdutoBarra->Produto->codtipoproduto,
					':codnaturezaoperacao' => $this->NotaFiscal->codnaturezaoperacao,
					':codestado' => $this->NotaFiscal->Pessoa->Cidade->codestado,
					':ncm' => $this->ProdutoBarra->Produto->Ncm->ncm,
				),
			    'order' => 'codestado nulls last, char_length(ncm) desc nulls last',
			)
		);
		
		if ($trib === null)
		{
			$this->addError('codprodutobarra', 'Erro ao calcular tributação. Impossível localizar tributação para o produto informado!');
			return false;
		}
		
		//Traz codigos de tributacao
		$this->codcfop = $trib->codcfop;
		
		if ($this->NotaFiscal->Filial->crt == Filial::CRT_REGIME_NORMAL)
		{
			
			//CST's
			$this->icmscst = $trib->icmscst;
			$this->ipicst = $trib->ipicst;
			$this->piscst = $trib->piscst;
			$this->cofinscst = $trib->cofinscst;
			
		    If (!empty($this->valortotal) && ($this->NotaFiscal->emitida))
		    {
				//Calcula ICMS				
				If (!empty($trib->icmslpbase))
					$this->icmsbase = round(($trib->icmslpbase * $this->valortotal)/100, 2);

				$this->icmspercentual = $trib->icmslppercentual;

				If ((!empty($this->icmsbase)) and (!empty($this->icmspercentual)))
					$this->icmsvalor = round(($this->icmsbase * $this->icmspercentual)/100, 2);
				
				//Calcula PIS
				If ($trib->pispercentual > 0)
				{
					$this->pisbase = $this->valortotal;
					$this->pispercentual = $trib->pispercentual;
					$this->pisvalor = round(($this->pisbase * $this->pispercentual)/100, 2);
				}
				
				//Calcula Cofins
				If ($trib->cofinspercentual > 0)
				{
					$this->cofinsbase = $this->valortotal;
					$this->cofinspercentual = $trib->cofinspercentual;
					$this->cofinsvalor = round(($this->cofinsbase * $this->cofinspercentual)/100, 2);
				}
				
				//Calcula CSLL
				If ($trib->csllpercentual > 0)
				{
					$this->csllbase = $this->valortotal;
					$this->csllpercentual = $trib->csllpercentual;
					$this->csllvalor = round(($this->csllbase * $this->csllpercentual)/100, 2);
				}
				
				//Calcula IRPJ
				If ($trib->irpjpercentual > 0)
				{
					$this->irpjbase = $this->valortotal;
					$this->irpjpercentual = $trib->irpjpercentual;
					$this->irpjvalor = round(($this->irpjbase * $this->irpjpercentual)/100, 2);
				}
				
			}
		}
		else
		{
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
}

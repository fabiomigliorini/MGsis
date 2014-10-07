<?php

/**
 * This is the model class for table "mgsis.tblnfeterceiroitem".
 *
 * The followings are the available columns in table 'mgsis.tblnfeterceiroitem':
 * @property string $codnfeterceiroitem
 * @property string $codnfeterceiro
 * @property integer $nitem
 * @property string $cprod
 * @property string $xprod
 * @property string $cean
 * @property string $ncm
 * @property integer $cfop
 * @property string $ucom
 * @property string $qcom
 * @property string $vuncom
 * @property string $vprod
 * @property string $ceantrib
 * @property string $utrib
 * @property string $qtrib
 * @property string $vuntrib
 * @property string $cst
 * @property string $csosn
 * @property string $vbc
 * @property string $picms
 * @property string $vicms
 * @property string $vbcst
 * @property string $picmsst
 * @property string $vicmsst
 * @property string $ipivbc
 * @property string $ipipipi
 * @property string $ipivipi
 * @property string $codprodutobarra
 * @property string $margem
 * @property string $complemento
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property NfeTerceiro $NfeTerceiro
 * @property ProdutoBarra $ProdutoBarra
 * @property Usuario $UsuarioCriacao
 * @property Usuario $UsuarioAlteracao
 */
class NfeTerceiroItem extends MGActiveRecord
{
	public $vicmscomplementar;
	public $vcusto;
	public $vcustounitario;
	public $vsugestaovenda;
	public $quantidade;
	
	const PERCENTUAL_ICMS_COMPLEMENTAR = 17;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblnfeterceiroitem';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codnfeterceiro', 'required'),
			array('nitem, cfop', 'numerical', 'integerOnly'=>true),
			array('cprod, cean, ceantrib', 'length', 'max'=>30),
			array('xprod', 'length', 'max'=>200),
			array('ncm, ucom, cst, csosn', 'length', 'max'=>10),
			array('vuncom, vuntrib', 'length', 'max'=>25),
			array('qcom, vprod, utrib, qtrib, vbc, picms, vicms, vbcst, picmsst, vicmsst, ipivbc, ipipipi, ipivipi, complemento', 'length', 'max'=>14),
			array('margem', 'length', 'max'=>6),
			array('codprodutobarra, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codnfeterceiroitem, codnfeterceiro, nitem, cprod, xprod, cean, ncm, cfop, ucom, qcom, vuncom, vprod, ceantrib, utrib, qtrib, vuntrib, cst, csosn, vbc, picms, vicms, vbcst, picmsst, vicmsst, ipivbc, ipipipi, ipivipi, codprodutobarra, margem, complemento, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
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
			'NfeTerceiro' => array(self::BELONGS_TO, 'NfeTerceiro', 'codnfeterceiro'),
			'ProdutoBarra' => array(self::BELONGS_TO, 'ProdutoBarra', 'codprodutobarra'),
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
			'codnfeterceiroitem' => '#',
			'codnfeterceiro' => 'NFe Terceiro',
			'nitem' => 'Número',
			'cprod' => 'Referência',
			'xprod' => 'Descrição',
			'cean' => 'EAN',
			'ncm' => 'NCM',
			'cfop' => 'CFOP',
			'ucom' => 'UM Com',
			'qcom' => 'Quantidade Com',
			'vuncom' => 'Preço',
			'vprod' => 'Total',
			'ceantrib' => 'EAN Trib',
			'utrib' => 'UM Trib',
			'qtrib' => 'Quantidade Trib',
			'vuntrib' => 'Preço Trib',
			'cst' => 'CST',
			'csosn' => 'CSOSN',
			'vbc' => 'ICMS Base',
			'picms' => 'ICMS %',
			'vicms' => 'ICMS Valor',
			'vbcst' => 'ICMS ST Base',
			'picmsst' => 'ICMS ST %',
			'vicmsst' => 'ICMS ST Valor',
			'ipivbc' => 'IPI Base',
			'ipipipi' => 'IPI %',
			'ipivipi' => 'IPI Valor',
			'codprodutobarra' => 'Produto',
			'margem' => 'Margem',
			'complemento' => 'Complemento',
			'alteracao' => 'Alteração',
			'codusuarioalteracao' => 'Usuário Alteração',
			'criacao' => 'Criação',
			'codusuariocriacao' => 'Usuario Criação',
			'vicmscomplementar' => 'ICMS Complementar',
			'vcusto' => 'Custo Total',
			'vcustounitario' => 'Custo Unitário',
			'quantidade' => 'Quantidade Calculada',
			'vsugestaovenda' => 'Sugestão Venda',
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

		$criteria->compare('codnfeterceiroitem',$this->codnfeterceiroitem,true);
		$criteria->compare('codnfeterceiro',$this->codnfeterceiro,true);
		$criteria->compare('nitem',$this->nitem);
		$criteria->compare('cprod',$this->cprod,true);
		$criteria->compare('xprod',$this->xprod,true);
		$criteria->compare('cean',$this->cean,true);
		$criteria->compare('ncm',$this->ncm,true);
		$criteria->compare('cfop',$this->cfop);
		$criteria->compare('ucom',$this->ucom,true);
		$criteria->compare('qcom',$this->qcom,true);
		$criteria->compare('vuncom',$this->vuncom,true);
		$criteria->compare('vprod',$this->vprod,true);
		$criteria->compare('ceantrib',$this->ceantrib,true);
		$criteria->compare('utrib',$this->utrib,true);
		$criteria->compare('qtrib',$this->qtrib,true);
		$criteria->compare('vuntrib',$this->vuntrib,true);
		$criteria->compare('cst',$this->cst,true);
		$criteria->compare('csosn',$this->csosn,true);
		$criteria->compare('vbc',$this->vbc,true);
		$criteria->compare('picms',$this->picms,true);
		$criteria->compare('vicms',$this->vicms,true);
		$criteria->compare('vbcst',$this->vbcst,true);
		$criteria->compare('picmsst',$this->picmsst,true);
		$criteria->compare('vicmsst',$this->vicmsst,true);
		$criteria->compare('ipivbc',$this->ipivbc,true);
		$criteria->compare('ipipipi',$this->ipipipi,true);
		$criteria->compare('ipivipi',$this->ipivipi,true);
		$criteria->compare('codprodutobarra',$this->codprodutobarra,true);
		$criteria->compare('margem',$this->margem,true);
		$criteria->compare('complemento',$this->complemento,true);
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
	 * @return NfeTerceiroItem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	protected function afterFind()
	{
		
		if (isset($this->NfeTerceiro->Pessoa) && isset($this->NfeTerceiro->Filial) && !empty($this->margem))
		{
			if ($this->NfeTerceiro->Filial->Pessoa->Cidade->codestado <> $this->NfeTerceiro->Pessoa->Cidade->codestado)
			{

				$this->vicmscomplementar = 
					((double)$this->vprod * (self::PERCENTUAL_ICMS_COMPLEMENTAR/100))
					- (double) $this->vicmsst;

				if ($this->vicmscomplementar < 0)
					$this->vicmscomplementar = 0;
			}

			$this->vcusto = 
				(double) $this->vprod + (double) $this->ipivipi + (double) $this->vicmscomplementar + (double) $this->vicmsst + (double) $this->complemento;
			
			$this->quantidade = $this->qcom;
			
			if (isset($this->ProdutoBarra->ProdutoEmbalagem))
				$this->quantidade *= $this->ProdutoBarra->ProdutoEmbalagem->quantidade;
			
			$this->vcustounitario = $this->vcusto / $this->quantidade;

			$this->vsugestaovenda = round($this->vcustounitario * (1+($this->margem/100)), 2);
			
			if ($this->vsugestaovenda >= 0.025)
				$this->vsugestaovenda = round($this->vsugestaovenda / 0.05, 0) * 0.05;
			
		}
		
		return parent::afterFind();
	}	
	
	/**
	 * Verifica se o registro está disponível para edição
	 * @return boolean
	 */
	public function podeEditar()
	{
		if (empty($this->NfeTerceiro->codnaturezaoperacao))
			return false;
		
		if (empty($this->NfeTerceiro->codfilial))
			return false;
		
		if (empty($this->NfeTerceiro->codpessoa))
			return false;
		
		if (!$this->NfeTerceiro->podeEditar())
			return false;
		
		return true;
	}
	
	/**
	 * Copia dados da ultima ocorrencia (Margem / codprodutobarra / complemento)
	 * @return boolean
	 */
	public function copiaDadosUltimaOcorrencia()
	{
		//if (!empty($this->codprodutobarra))
		//	return false;
		
		//Procura ultima entrada
		$nti = NfeTerceiroItem::model()->find(array(
			'condition'=>'t.codnfeterceiroitem <> :codnfeterceiroitem AND t.codprodutobarra IS NOT NULL AND t.cprod=:cprod AND "NfeTerceiro".cnpj = :cnpj',
			'params'=>array(
				':codnfeterceiroitem'=>$this->codnfeterceiroitem,
				':cprod'=>$this->cprod,
				':cnpj'=>$this->NfeTerceiro->cnpj,
			),
			'with'=>'NfeTerceiro',
			'order'=>'t.alteracao DESC',
		));
		
		if ($nti != false)
		{
			if (empty($this->codprodutobarra))
				$this->codprodutobarra = $nti->codprodutobarra;
			
			if (empty($this->margem))
				$this->margem = $nti->margem;
			
			if (empty($this->complemento))
				$this->complemento = ($nti->complemento / $nti->vprod) * $this->vprod;
			
			return true;
		}

		if (!empty($this->codprodutobarra))
			return true;
		
		//procura pelo codigo de barras / barras trib
		$pb = ProdutoBarra::findByBarras($this->cean);
		if ($pb == false)
			$pb = ProdutoBarra::findByBarras($this->ceantrib);
		
		if ($pb != false)
		{
			$this->codprodutobarra = $pb->codprodutobarra;
			return true;
		}
		
	}
	
}

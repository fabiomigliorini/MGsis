<?php

/**
 * This is the model class for table "mgsis.tbltributacaonaturezaoperacao".
 *
 * The followings are the available columns in table 'mgsis.tbltributacaonaturezaoperacao':
 * @property string $codtributacaonaturezaoperacao
 * @property string $codtributacao
 * @property string $codnaturezaoperacao
 * @property string $codcfop
 * @property string $icmsbase
 * @property string $icmspercentual
 * @property string $codestado
 * @property string $csosn
 * @property string $codtipoproduto
 * @property integer $acumuladordominiovista
 * @property integer $acumuladordominioprazo
 * @property string $historicodominio
 * @property boolean $movimentacaofisica
 * @property boolean $movimentacaocontabil
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 * @property string $icmscst
 * @property string $piscst
 * @property string $ipicst
 * @property string $cofinscst
 * @property string $pispercentual
 * @property string $cofinspercentual
 * @property string $csllpercentual
 * @property string $irpjpercentual
 * @property string $ncm
 * @property string $icmslpbase
 * @property string $icmslppercentual
 * @property boolean $certidaosefazmt
 * @property float $fethabkg
 * @property float $iagrokg
 * @property float $funruralpercentual
 * @property float $senarpercentual
 * @property float $observacoesnf
 *
 * The followings are the available model relations:
 * @property Cfop $Cfop
 * @property Estado $Estado
 * @property NaturezaOperacao $NaturezaOperacao
 * @property TipoProduto $TipoProduto
 * @property Tributacao $Tributacao
 * @property Usuario $UsuarioAlteracao
 * @property Usuario $UsuarioCriacao
 */
class TributacaoNaturezaOperacao extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tbltributacaonaturezaoperacao';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codtributacao, codnaturezaoperacao, codcfop, csosn, codtipoproduto, icmscst, piscst, ipicst, cofinscst', 'required'),
			array('acumuladordominiovista, acumuladordominioprazo, ncm', 'numerical', 'integerOnly'=>true),
			array('codtributacao', 'validaChaveUnica'),
			array('csosn', 'length', 'max'=>4),
			array('icmspercentual, pispercentual, cofinspercentual, csllpercentual, irpjpercentual, icmslppercentual', 'length', 'max'=>5),
			array('historicodominio', 'length', 'max'=>512),
			array('observacoesnf', 'length', 'max'=>500),
			array('icmscst, piscst, ipicst, cofinscst', 'length', 'max'=>3),
			array('csosn, icmscst, piscst, ipicst, cofinscst', 'numerical', 'min'=>1),
			array('ncm', 'length', 'max'=>10),
			array('icmsbase, icmslpbase', 'length', 'max'=>6),
			array('codestado, movimentacaofisica, movimentacaocontabil, alteracao,
			codusuarioalteracao, criacao, codusuariocriacao, certidaosefazmt, fethabkg,
			iagrokg, funruralpercentual, senarpercentual', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codtributacaonaturezaoperacao, codtributacao,
			codnaturezaoperacao, codcfop, icmsbase, icmspercentual,
			codestado, csosn, codtipoproduto, acumuladordominiovista,
			acumuladordominioprazo, historicodominio, movimentacaofisica,
			movimentacaocontabil, alteracao, codusuarioalteracao, criacao,
			codusuariocriacao, icmscst, piscst, ipicst, cofinscst, pispercentual,
			cofinspercentual, csllpercentual, irpjpercentual, ncm, icmslpbase,
			certidaosefazmt, fethabkg, iagrokg, funruralpercentual, senarpercentual, icmslppercentual,
			observacoesnf', 'safe', 'on'=>'search'),
		);
	}

//verifica se a combinacao de CNPJ e IE já não estão cadastrados
	public function validaChaveUnica($attribute,$params)
	{
		if (empty($this->codtributacao))
			return;

		if (empty($this->codnaturezaoperacao))
			return;

		if (strlen($this->codtipoproduto) <= 0)
			return;

		$condicao  = 'codtributacao = :codtributacao AND codnaturezaoperacao = :codnaturezaoperacao AND codtipoproduto = :codtipoproduto';
		$parametros = array(
			'codtributacao' => $this->codtributacao,
			'codnaturezaoperacao' => $this->codnaturezaoperacao,
			'codtipoproduto' => $this->codtipoproduto,
			);

		if (empty($this->codestado))
		{
			$condicao .= ' AND codestado IS NULL';
		}
		else
		{
			$condicao .= ' AND codestado = :codestado';
			$parametros['codestado'] = $this->codestado;
		}

		if (empty($this->ncm))
		{
			$condicao .= ' AND ncm IS NULL';
		}
		else
		{
			$condicao .= ' AND ncm = :ncm';
			$parametros['ncm'] = $this->ncm;
		}

		$regs = TributacaoNaturezaOperacao::model()->findAll(
			array(
				'condition' => $condicao,
				'params' => $parametros,
			)
		);

		if (sizeof($regs) > 0)
			if ($regs[0]->codtributacaonaturezaoperacao <> $this->codtributacaonaturezaoperacao)
				$this->addError($attribute, "Já existe uma combinação de Tributação, Tipo de Produto, Estado e NCM igual à essa cadastrada!");
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
			'Estado' => array(self::BELONGS_TO, 'Estado', 'codestado'),
			'NaturezaOperacao' => array(self::BELONGS_TO, 'NaturezaOperacao', 'codnaturezaoperacao'),
			'TipoProduto' => array(self::BELONGS_TO, 'TipoProduto', 'codtipoproduto'),
			'Tributacao' => array(self::BELONGS_TO, 'Tributacao', 'codtributacao'),
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
			'codtributacaonaturezaoperacao' => '#',
			'codtributacao' => 'Tributação',
			'codnaturezaoperacao' => 'Natureza da Operação',
			'codcfop' => 'CFOP',
			'icmsbase' => 'ICMS Base',
			'icmspercentual' => 'ICMS %',
			'codestado' => 'Estado',
			'csosn' => 'CSOSN',
			'codtipoproduto' => 'Tipo do produto',
			'acumuladordominiovista' => 'Acumulador Vista',
			'acumuladordominioprazo' => 'Acumulador Prazo',
			'historicodominio' => 'Histórico Domínio',
			'movimentacaofisica' => 'Movimentação Fisica',
			'movimentacaocontabil' => 'Movimentação Contabil',
			'alteracao' => 'Alteração',
			'codusuarioalteracao' => 'Usuário Alteração',
			'criacao' => 'Criação',
			'codusuariocriacao' => 'Usuário Criação',
			'icmscst' => 'ICMS CST',
			'piscst' => 'PIS CST',
			'ipicst' => 'IPI CST',
			'cofinscst' => 'Cofins CST',
			'pispercentual' => 'PIS %',
			'cofinspercentual' => 'Cofins %',
			'csllpercentual' => 'CSLL %',
			'irpjpercentual' => 'IRPJ %',
			'ncm' => 'NCM',
			'icmslpbase' => 'ICMS Base',
			'icmslppercentual' => 'ICMS %',
			'certidaosefazmt' => 'Certidão sefaz MT',
			'fethabkg' => 'Fethab por KG',
			'iagrokg' => 'Iagro por KG',
			'funruralpercentual' => 'Funrual %',
			'senarpercentual' => 'Senar %',
			'observacoesnf' => 'Observações NF',
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

		$criteria->compare('codtributacaonaturezaoperacao',Yii::app()->format->numeroLimpo($this->codtributacaonaturezaoperacao),false);
		//$criteria->compare('codtributacaonaturezaoperacao',$this->codtributacaonaturezaoperacao,false);
		$criteria->compare('codtributacao',$this->codtributacao,false);
		$criteria->compare('codnaturezaoperacao',$this->codnaturezaoperacao,false);
		$criteria->compare('codcfop',$this->codcfop,false);
		$criteria->compare('icmsbase',$this->icmsbase,false);
		$criteria->compare('icmspercentual',$this->icmspercentual,false);
		$criteria->compare('codestado',$this->codestado,false);
		$criteria->compare('csosn',$this->csosn,false);
		$criteria->compare('codtipoproduto',$this->codtipoproduto,false);
		$criteria->compare('acumuladordominiovista',$this->acumuladordominiovista);
		$criteria->compare('acumuladordominioprazo',$this->acumuladordominioprazo);
		$criteria->compare('historicodominio',$this->historicodominio,false);
		$criteria->compare('movimentacaofisica',$this->movimentacaofisica);
		$criteria->compare('movimentacaocontabil',$this->movimentacaocontabil);
		$criteria->compare('alteracao',$this->alteracao,false);
		$criteria->compare('codusuarioalteracao',$this->codusuarioalteracao,false);
		$criteria->compare('criacao',$this->criacao,false);
		$criteria->compare('codusuariocriacao',$this->codusuariocriacao,false);
		$criteria->compare('icmscst',$this->icmscst,false);
		$criteria->compare('piscst',$this->piscst,false);
		$criteria->compare('ipicst',$this->ipicst,false);
		$criteria->compare('cofinscst',$this->cofinscst,false);
		$criteria->compare('pispercentual',$this->pispercentual,false);
		$criteria->compare('cofinspercentual',$this->cofinspercentual,false);
		$criteria->compare('csllpercentual',$this->csllpercentual,false);
		$criteria->compare('irpjpercentual',$this->irpjpercentual,false);
		$criteria->compare('ncm',$this->ncm,true);
		$criteria->compare('icmslpbase',$this->icmslpbase,false);
		$criteria->compare('icmslppercentual',$this->icmslppercentual,false);
		$criteria->compare('certidaosefazmt',$this->certidaosefazmt,false);
		$criteria->compare('fethabkg',$this->fethabkg,false);
		$criteria->compare('iagrokg',$this->iagrokg,false);
		$criteria->compare('funruralpercentual',$this->funruralpercentual,false);
		$criteria->compare('senarpercentual',$this->senarpercentual,false);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array('defaultOrder'=>'t.codnaturezaoperacao, t.codtributacao, t.codtipoproduto, t.ncm, t.codestado, t.codcfop ASC'),
			'pagination'=>array('pageSize'=>20)
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TributacaoNaturezaOperacao the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function scopes ()
	{
		return array(
			'combo'=>array(
				'select'=>array('codtributacaonaturezaoperacao', 'tributacaonaturezaoperacao'),
				'order'=>'tributacaonaturezaoperacao ASC',
				),
			);
	}

	public function getListaCombo ()
	{
		$lista = self::model()->combo()->findAll();
		return CHtml::listData($lista, 'codtributacaonaturezaoperacao', 'tributacaonaturezaoperacao');
	}
}

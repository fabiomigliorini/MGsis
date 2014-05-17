<?php

/**
 * This is the model class for table "mgsis.tblproduto".
 *
 * The followings are the available columns in table 'mgsis.tblproduto':
 * @property string $codproduto
 * @property string $produto
 * @property string $referencia
 * @property string $codunidademedida
 * @property string $codsubgrupoproduto
 * @property string $codmarca
 * @property string $preco
 * @property boolean $importado
 * @property string $ncm
 * @property string $codtributacao
 * @property string $inativo
 * @property string $codtipoproduto
 * @property boolean $site
 * @property string $descricaosite
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property Estoquesaldo[] $estoquesaldos
 * @property Estoquemovimento[] $estoquemovimentos
 * @property Marca $codmarca
 * @property Subgrupoproduto $codsubgrupoproduto
 * @property Tipoproduto $codtipoproduto
 * @property Tributacao $codtributacao
 * @property Unidademedida $codunidademedida
 * @property Usuario $UsuarioAlteracao
 * @property Usuario $UsuarioCriacao
 * @property Produtohistoricopreco[] $produtohistoricoprecos
 * @property Produtoembalagem[] $produtoembalagems
 * @property Produtobarra[] $produtobarras
 */
class Produto extends MGActiveRecord
{
	
	public $barras;
	public $preco_de;
	public $preco_ate;
	public $criacao_de;
	public $criacao_ate;
	public $alteracao_de;
	public $alteracao_ate;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblproduto';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('produto, codunidademedida, ncm, codtributacao, codtipoproduto, preco, codsubgrupoproduto, codmarca', 'required'),
			array('produto', 'validaMarca'),
			array('produto', 'length', 'max'=>100),
			array('referencia', 'length', 'max'=>50),
			array('preco', 'numerical', 'min'=>0.01),
			array('ncm', 'length', 'max'=>8),
			array('ncm', 'length', 'min'=>8),
			array('ncm', 'numerical'),
			array('preco', 'length', 'max'=>14),
			array('descricaosite', 'length', 'max'=>1024),
			array('codsubgrupoproduto, codmarca, importado, inativo, codtipoproduto, site, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('alteracao_de, alteracao_ate, criacao_de, criacao_ate, preco_de, preco_ate, barras, codproduto, produto, referencia, codunidademedida, codsubgrupoproduto, codmarca, preco, importado, ncm, codtributacao, inativo, codtipoproduto, site, descricaosite, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
		);
	}

	//verifica se o numero tem pelo menos 10 digitos
	public function validaMarca($attribute,$params)
	{
		if (!empty($this->$attribute) && !empty($this->codmarca) && empty($this->inativo))
		{
			if (strpos(strtoupper($this->$attribute), strtoupper($this->Marca->marca)) === false)
				$this->addError($attribute,'Preencha a marca "' . $this->Marca->marca . '" na descrição do produto!');
		}
	}
	
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			//'estoquesaldos' => array(self::HAS_MANY, 'Estoquesaldo', 'codproduto'),
			//'estoquemovimentos' => array(self::HAS_MANY, 'Estoquemovimento', 'codproduto'),
			'Marca' => array(self::BELONGS_TO, 'Marca', 'codmarca'),
			'SubGrupoProduto' => array(self::BELONGS_TO, 'SubGrupoProduto', 'codsubgrupoproduto'),
			'TipoProduto' => array(self::BELONGS_TO, 'TipoProduto', 'codtipoproduto'),
			'Tributacao' => array(self::BELONGS_TO, 'Tributacao', 'codtributacao'),
			'UnidadeMedida' => array(self::BELONGS_TO, 'UnidadeMedida', 'codunidademedida'),
			'UsuarioAlteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
			'UsuarioCriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
			'ProdutoHistoricoPrecos' => array(self::HAS_MANY, 'ProdutoHistoricoPreco', 'codproduto'),
			'ProdutoEmbalagens' => array(self::HAS_MANY, 'ProdutoEmbalagem', 'codproduto', 'order'=>'quantidade ASC, codunidademedida ASC'),
			'ProdutoBarras' => array(self::HAS_MANY, 'ProdutoBarra', 'codproduto', 'order'=>'codprodutoembalagem ASC, variacao ASC, barras ASC'),
			'Ncm' => array(self::BELONGS_TO, 'Ncm', 'ncm'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codproduto' => '#',
			'produto' => 'Descrição',
			'referencia' => 'Referência',
			'codunidademedida' => 'Unidade Medida',
			'codsubgrupoproduto' => 'Grupo',
			'codmarca' => 'Marca',
			'preco' => 'Preço',
			'importado' => 'Importado',
			'ncm' => 'NCM',
			'codtributacao' => 'Tributação',
			'inativo' => 'Inativo desde',
			'codtipoproduto' => 'Tipo',
			'site' => 'Disponível no Site',
			'descricaosite' => 'Descrição Site',
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

		$criteria->compare('t.codproduto',$this->codproduto,false);
		
		if (!empty($this->barras))
		{
			$criteria->addCondition("t.codproduto in (select pb2.codproduto from tblprodutobarra pb2 where barras ilike :barras)");
			$criteria->params[':barras'] = '%' . str_replace(' ', '%', trim($this->barras)) . '%';
		}

		if (!empty($this->produto))
		{
			$criteria->addCondition("t.produto ilike :produto");
			$criteria->params[':produto'] = '%' . str_replace(' ', '%', trim($this->produto)) . '%';
		}
		
		if (!empty($this->referencia))
		{
			$criteria->addCondition("t.referencia ilike :referencia OR t.codproduto in (select pb2.codproduto from tblprodutobarra pb2 where referencia ilike :referencia)");
			$criteria->params[':referencia'] = '%' . str_replace(' ', '%', trim($this->referencia)) . '%';
		}
		
		if (!empty($this->codmarca))
		{
			$criteria->addCondition("t.codmarca = :codmarca OR t.codproduto in (select pb2.codproduto from tblprodutobarra pb2 where codmarca = :codmarca)");
			$criteria->params[':codmarca'] = $this->codmarca;
		}
		
		switch ($this->inativo)
		{
			case 9:
				continue;
			case 1:
				$criteria->addCondition("t.inativo is not null");
				continue;
			default:
				$criteria->addCondition("t.inativo is null");
				continue;
		}
		
		switch ($this->site) // '1'=>'No Site', '2'=>'Fora do Site'), 
		{
			case 1:
				$criteria->addCondition("t.site  = true");
				continue;
			case 2:
				$criteria->addCondition("t.site = false");
				continue;
		}
		
		$criteria->compare('t.codtributacao', $this->codtributacao, false);
		$criteria->compare('ncm', Yii::app()->format->numeroLimpo($this->ncm),false);
		
		if (!empty($this->preco_de))
		{
			$criteria->addCondition("t.preco >= :preco_de");
			$criteria->params[':preco_de'] = Yii::app()->format->unformatNumber($this->preco_de);
		}
		
		if (!empty($this->preco_ate))
		{
			$criteria->addCondition("t.preco <= :preco_ate");
			$criteria->params[':preco_ate'] = Yii::app()->format->unformatNumber($this->preco_ate);
		}
		
		if ($criacao_de = DateTime::createFromFormat("d/m/y",$this->criacao_de))
		{
			$criteria->addCondition('t.criacao >= :criacao_de');
			$criteria->params[':criacao_de'] = $criacao_de->format('Y-m-d').' 00:00:00.0';
		}
		if ($criacao_ate = DateTime::createFromFormat("d/m/y",$this->criacao_ate))
		{
			$criteria->addCondition('t.criacao <= :criacao_ate');
			$criteria->params[':criacao_ate'] = $criacao_ate->format('Y-m-d').' 23:59:59.9';
		}
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
		/*
		$criteria->compare('referencia',$this->referencia,true);
		$criteria->compare('codunidademedida',$this->codunidademedida,true);
		$criteria->compare('codsubgrupoproduto',$this->codsubgrupoproduto,true);
		$criteria->compare('codmarca',$this->codmarca,true);
		$criteria->compare('preco',$this->preco,true);
		$criteria->compare('importado',$this->importado);
		$criteria->compare('inativo',$this->inativo,true);
		$criteria->compare('codtipoproduto',$this->codtipoproduto,true);
		$criteria->compare('site',$this->site);
		$criteria->compare('descricaosite',$this->descricaosite,true);
		 * 
		 */

		
		$criteria->order = 't.produto ASC, t.preco ASC, t.codproduto ASC';
		$criteria->with = array(
			'ProdutoBarras',
			'UnidadeMedida',
			'Marca',
			'Tributacao',
			'SubGrupoProduto' => array(
				'with' => 'GrupoProduto'
			),
		);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Produto the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function criaBarras ($barras) 
	{
		if ($this->isNewRecord)
			return false;
		
		$barras = trim($barras);
		
		if (empty($barras))
			$barras = str_pad($this->codproduto, 6, "0", STR_PAD_LEFT);
		
		$pb = new ProdutoBarra('insert');
		
		$pb->codproduto = $this->codproduto;
		$pb->barras = $barras;
		
		return $pb->save();
	}
	
	public function getImagens ()
	{
		$baseDir = Yii::app()->basePath . "/..";

		$dir = "$baseDir/images/produto/" . str_pad($this->codproduto, 6, "0", STR_PAD_LEFT);
		
		if (!is_dir($dir)) {
			return array();
		}

		$imgs_orig = CFileHelper::findFiles(
			$dir
			, array (
				'fileTypes' => array("jpg", "gif", "png", "JPG", "PNG")
				)
			);
		
		
		
		foreach ($imgs_orig as $img)
		{
			$img = str_replace($baseDir, "", $img);
			$imgs[] = $img;
		}
		
		return $imgs;
	}
}

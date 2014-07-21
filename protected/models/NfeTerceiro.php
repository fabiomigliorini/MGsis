<?php

/**
 * This is the model class for table "mgsis.tblnfeterceiro".
 *
 * The followings are the available columns in table 'mgsis.tblnfeterceiro':
 * @property string $codnfeterceiro
 * @property string $nsu
 * @property string $nfechave
 * @property string $cnpj
 * @property string $ie
 * @property string $emitente
 * @property string $codpessoa
 * @property string $emissao
 * @property string $nfedataautorizacao
 * @property string $codoperacao
 * @property string $valortotal
 * @property integer $indsituacao
 * @property integer $indmanifestacao
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 * @property string $codfilial
 * @property string $codnotafiscal
 * @property string $codnaturezaoperacao
 * @property integer $serie
 * @property integer $numero
 * @property string $entrada
 * @property string $icmsbase
 * @property string $icmsvalor
 * @property string $icmsstbase
 * @property string $icmsstvalor
 * @property string $ipivalor
 * @property string $valorprodutos
 * @property string $valorfrete
 * @property string $valorseguro
 * @property string $valordesconto
 * @property string $valoroutras
 * @property CUploadedFile $arquivoxml
 * @property SimpleXMLElement $xml
 *
 * The followings are the available model relations:
 * @property NfeTerceiroDuplicata[] $NfeTerceiroDuplicatas
 * @property NfeTerceiroItem[] $NfeTerceiroItems
 * @property Pessoa $Pessoa
 * @property Operacao $Operacao
 * @property Usuario $UsuarioAlteracao
 * @property Usuario $UsuarioCriacao
 * @property Filial $Filial
 * @property NotaFiscal $NotaFiscal
 * @property NaturezaOperacao $NaturezaOperacao
 */
class NfeTerceiro extends MGActiveRecord
{
	
	const INDSITUACAO_AUTORIZADA = 1;
	const INDSITUACAO_DENEGADA = 2;
	const INDSITUACAO_CANCELADA = 3;

	const INDMANIFESTACAO_SEM = 0;
	const INDMANIFESTACAO_CONFIRMADA = 1;
	const INDMANIFESTACAO_DESCONHECIDA = 2;
	const INDMANIFESTACAO_NAOREALIZADA = 3;
	const INDMANIFESTACAO_CIENCIA = 4;
	
	const DIRETORIO_XML = "/media/publico/xml";
	
	public $emissao_de;
	public $emissao_ate;

	public $valor_de;
	public $valor_ate;
	
	public $arquivoxml;
	public $xml;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblnfeterceiro';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codfilial, emitente, codfilial', 'required'),
			array('indsituacao, indmanifestacao, serie, numero', 'numerical', 'integerOnly'=>true),
			array('nsu, ie', 'length', 'max'=>20),
			array('nfechave, emitente', 'length', 'max'=>100),
			//array('arquivoxml', 'file', 'types'=>'xml'),
			array('cnpj, valortotal, icmsbase, icmsvalor, icmsstbase, icmsstvalor, ipivalor, valorprodutos, valorfrete, valorseguro, valordesconto, valoroutras', 'length', 'max'=>14),
			array('codpessoa, emissao, nfedataautorizacao, codoperacao, alteracao, codusuarioalteracao, criacao, codusuariocriacao, codnotafiscal, codnaturezaoperacao, entrada', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codnfeterceiro, emissao_de, emissao_ate, valor_de, valor_ate, nsu, nfechave, cnpj, ie, emitente, codpessoa, emissao, nfedataautorizacao, codoperacao, valortotal, indsituacao, indmanifestacao, alteracao, codusuarioalteracao, criacao, codusuariocriacao, codfilial, codnotafiscal, codnaturezaoperacao, serie, numero, entrada, icmsbase, icmsvalor, icmsstbase, icmsstvalor, ipivalor, valorprodutos, valorfrete, valorseguro, valordesconto, valoroutras', 'safe', 'on'=>'search'),
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
			'NfeTerceiroDuplicatas' => array(self::HAS_MANY, 'NfeTerceiroDuplicata', 'codnfeterceiro', 'order'=>'dvenc ASC'),
			'NfeTerceiroItems' => array(self::HAS_MANY, 'NfeTerceiroItem', 'codnfeterceiro', 'order'=>'nitem ASC'),
			'Pessoa' => array(self::BELONGS_TO, 'Pessoa', 'codpessoa'),
			'Operacao' => array(self::BELONGS_TO, 'Operacao', 'codoperacao'),
			'UsuarioAlteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
			'UsuarioCriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
			'Filial' => array(self::BELONGS_TO, 'Filial', 'codfilial'),
			'NotaFiscal' => array(self::BELONGS_TO, 'NotaFiscal', 'codnotafiscal'),
			'NaturezaOperacao' => array(self::BELONGS_TO, 'NaturezaOperacao', 'codnaturezaoperacao'),			
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codnfeterceiro' => '#',
			'nsu' => 'NSU',
			'nfechave' => 'Chave',
			'cnpj' => 'Cnpj',
			'ie' => 'IE',
			'emitente' => 'Emitente',
			'codpessoa' => 'Pessoa',
			'emissao' => 'Emissão',
			'nfedataautorizacao' => 'Autorização',
			'codoperacao' => 'Operação',
			'valortotal' => 'Valor Total',
			'indsituacao' => 'Situação',
			'indmanifestacao' => 'Manifestação',
			'alteracao' => 'Alteração',
			'codusuarioalteracao' => 'Usuário Alteração',
			'criacao' => 'Criação',
			'codusuariocriacao' => 'Usuario Criação',
			'codfilial' => 'Filial',
			'codnotafiscal' => 'Nota Fiscal',
			'codnaturezaoperacao' => 'Natureza de Operação',
			'serie' => 'Série',
			'numero' => 'Número',
			'entrada' => 'Entrada',
			'icmsbase' => 'ICMS Base',
			'icmsvalor' => 'ICMS Valor',
			'icmsstbase' => 'ICMS ST Base',
			'icmsstvalor' => 'ICMS ST Valor',
			'ipivalor' => 'IPI Valor',
			'valorprodutos' => 'Valor Produtos',
			'valorfrete' => 'Valor Frete',
			'valorseguro' => 'Valor Seguro',
			'valordesconto' => 'Valor Desconto',
			'valoroutras' => 'Valor Outras',
			'arquivoxml' => 'Arquivo XML',
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

		$criteria->compare('codnfeterceiro',$this->codnfeterceiro,true);
		$criteria->compare('nsu',$this->nsu,true);
		$criteria->compare('nfechave',$this->nfechave,true);
		$criteria->compare('cnpj',$this->cnpj,true);
		$criteria->compare('ie',$this->ie,true);
		$criteria->compare('emitente',$this->emitente,true);
		$criteria->compare('codpessoa',$this->codpessoa);
		$criteria->compare('codfilial',$this->codfilial);
		$criteria->compare('nfedataautorizacao',$this->nfedataautorizacao,true);
		$criteria->compare('codoperacao',$this->codoperacao,true);
		$criteria->compare('indsituacao',$this->indsituacao);
		$criteria->compare('indmanifestacao',$this->indmanifestacao);
		$criteria->compare('alteracao',$this->alteracao,true);
		$criteria->compare('codusuarioalteracao',$this->codusuarioalteracao,true);
		$criteria->compare('criacao',$this->criacao,true);
		$criteria->compare('codusuariocriacao',$this->codusuariocriacao,true);
		
		switch ($this->codnotafiscal)
		{
			case 1:
				$criteria->addCondition('codnotafiscal is null');
				break;

			case 2:
				$criteria->addCondition('codnotafiscal is not null');
				break;
			
			default:
				break;
		}

		if (!empty($this->codnotafiscal))
		{
			
		}
		
		if ($emissao_de = DateTime::createFromFormat("d/m/y",$this->emissao_de))
		{
			$criteria->addCondition('t.emissao >= :emissao_de');
			$criteria->params[':emissao_de'] = $emissao_de->format('Y-m-d');
		}
		
		if ($emissao_ate = DateTime::createFromFormat("d/m/y",$this->emissao_ate))
		{
			$criteria->addCondition('t.emissao <= :emissao_ate');
			$criteria->params[':emissao_ate'] = $emissao_ate->format('Y-m-d');
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array('defaultOrder'=>'t.emissao ASC, t.valortotal asc'),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return NfeTerceiro the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	protected function beforeSave()
	{
		if (empty($this->codpessoa))
		{
			$pessoas = Pessoa::model()->findAll("cnpj = :cnpj", array(":cnpj" => $this->cnpj));
			
			foreach ($pessoas as $pessoa)
			{
				if (Yii::app()->format->numeroLimpo($this->ie) == Yii::app()->format->numeroLimpo($pessoa->ie))
					$this->codpessoa = $pessoa->codpessoa;
			}
		}
		
		if (empty($this->codnotafiscal))
		{
			if ($nf = NotaFiscal::model()->find('emitida = false and nfechave = :nfechave', array(':nfechave' => $this->nfechave)))
			{
				$this->codnotafiscal = $nf->codnotafiscal;
			}
		}
		
		return parent::beforeSave();
	}
	
	function getIndSituacaoListaCombo()
	{
		return array(
			self::INDSITUACAO_AUTORIZADA => "Autorizada",
			self::INDSITUACAO_DENEGADA => "Denegada",
			self::INDSITUACAO_CANCELADA => "Cancelada",
		);
	}

	function getIndSituacaoDescricao()
	{
		$arr = $this->getIndSituacaoListaCombo();
		return @$arr[$this->indsituacao];
	}

	function getIndManifestacaoListaCombo()
	{
		return array(
			self::INDMANIFESTACAO_SEM => "Sem Manifestação",
			self::INDMANIFESTACAO_CONFIRMADA => "Confirmada a Operação",
			self::INDMANIFESTACAO_DESCONHECIDA => "Desconhecida",
			self::INDMANIFESTACAO_NAOREALIZADA => "Não Realizada a Operação",
			self::INDMANIFESTACAO_CIENCIA => "Ciência da Operação",
		);
	}
	
	function getIndManifestacaoDescricao()
	{
		$arr = $this->getIndManifestacaoListaCombo();
		return @$arr[$this->indmanifestacao];
	}
	
	public function lerXml($arquivoxml = null)
	{
		if (empty($arquivoxml))
		{
			$this->arquivoxml = $this->montarCaminhoArquivoXml();
			$arquivoxml = $this->arquivoxml;
		}
		
		$xml = file_get_contents($arquivoxml);
		
		if ($this->xml = @simplexml_load_string($xml))
			return true;
		
		// replace & followed by a bunch of letters, numbers
		// and underscores and an equal sign with &amp;
		$xml = preg_replace('/&[^; ]{0,6}.?/e', "((substr('\\0',-1) == ';') ? '\\0' : '&amp;'.substr('\\0',1))", $xml);
		
		return $this->xml = @simplexml_load_string($xml);
	}
	
	public function montarCaminhoArquivoXml()
	{
		//encontra chave/cnpjs do arquivo XML
		if ($this->xml instanceof SimpleXMLElement)
		{
			$cnpjemit = str_pad($this->xml->NFe->infNFe->emit->CNPJ->__toString(), 14, 0, STR_PAD_LEFT);
			$cnpjfilial = str_pad($this->xml->NFe->infNFe->dest->CNPJ->__toString(), 14, 0, STR_PAD_LEFT);
			$this->nfechave = Yii::app()->format->NumeroLimpo($this->xml->NFe->infNFe->attributes()->Id->__toString());
		}
		else
		{
			$cnpjemit = str_pad($this->cnpj, 14, 0, STR_PAD_LEFT);
			$cnpjfilial = str_pad($this->Filial->Pessoa->cnpj, 14, 0, STR_PAD_LEFT);
		}
		
		$cnpjemitraiz = substr($cnpjemit, 0, 8);
		
		//cria diretorio se nao existir
		$diretorio = self::DIRETORIO_XML . "/{$cnpjfilial}/{$cnpjemitraiz}";
		if (!file_exists($diretorio))
			mkdir ($diretorio, 0777, true);
		
		//retorna caminho
		return "{$diretorio}/{$this->nfechave}-nfe.xml";
	}
	
	public function importarXmlViaString($str)
	{
		$this->arquivoxml = $this->montarCaminhoArquivoXml();
		
		if (!@file_put_contents($this->arquivoxml, $str))
		{
			$this->addError("arquivoxml", "Erro ao salvar arquivo {$this->arquivoxml}!");
			return false;
		}
		
		if (!$this->importarXml())
		{
			$this->addError("arquivoxml", "Erro ao importar o arquivo {$this->arquivoxml}!");
			return false;
		}

		return true;
	}
	
	public function importarXmlViaArquivo()
	{
		if (!$this->arquivoxml instanceof CUploadedFile)
		{
			$this->addError("arquivoxml", "Nenhum arquivo selecionado!");
			return false;
		}
		
		if ($this->arquivoxml->getType() != "text/xml")
		{
			$this->addError("arquivoxml", "Tipo de arquivo inválido, deve ser um XML!");
			return false;
		}
		
		if (!$this->lerXml($this->arquivoxml->tempName))
		{
			$this->addError("arquivoxml", "Arquivo XML inválido!");
			return false;
		}
		
		if (!empty($this->nfechave) 
			&& $this->nfechave != Yii::app()->format->NumeroLimpo($this->xml->NFe->infNFe->attributes()->Id->__toString()))
		{
			$this->addError("arquivoxml", "Arquivo XML não corresponde à NFe selecionada!");
			return false;
		}
		
		$caminho = $this->montarCaminhoArquivoXml();
		
		if (!$this->arquivoxml->saveAs($caminho))
		{
			$this->addError("arquivoxml", "Erro ao salvar arquivo em {$caminho}!");
			return false;
		}
		$this->arquivoxml = $caminho;
		
		if (!$this->importarXml())
		{
			$this->addError("arquivoxml", "Erro ao importar o arquivo {$this->arquivoxml}!");
			return false;
		}

		return true;
	}
	
	public function importarXml() 
	{

		if (!$this->lerXml())
		{
			$this->addError("arquivoxml", "Erro ao ler arquivo em {$this->arquivoxml}!");
			return false;
		}
		
		$nft = NfeTerceiro::model()->find(
			"nfechave = :nfechave", 
			array(
				":nfechave" => $this->nfechave
			)
		);
		
		if ($nft !== NULL)
		{
			$this->attributes = $nft->attributes;
			$this->setPrimaryKey($nft->codnfeterceiro);
			$this->setIsNewRecord(false);
		}
		
		$cnpj = $this->xml->NFe->infNFe->dest->CNPJ;
		if (empty($cnpj))
			$cnpj = $this->xml->NFe->infNFe->dest->CPF;
		
		if ($pessoa = Pessoa::model()->find("cnpj = :cnpj", array(":cnpj" => $cnpj)))
			if ($filial = Filial::model()->find("codpessoa = :codpessoa", array(":codpessoa" => $pessoa->codpessoa)))
				$this->codfilial = $filial->codfilial;
			
		$this->nfechave = Yii::app()->format->NumeroLimpo($this->xml->NFe->infNFe->attributes()->Id->__toString());
		$this->cnpj = $this->xml->NFe->infNFe->emit->CNPJ->__toString();
		$this->ie = $this->xml->NFe->infNFe->emit->IE->__toString();
		$this->emitente = $this->xml->NFe->infNFe->emit->xNome->__toString();
		if ($emissao = DateTime::createFromFormat("Y-m-d", $this->xml->NFe->infNFe->ide->dEmi->__toString()))
			$this->emissao = $emissao->format("d/m/Y");
		$this->codoperacao = Operacao::SAIDA;
		
		$this->icmsbase = $this->xml->NFe->infNFe->total->ICMSTot->vBC->__toString();
		$this->icmsvalor = $this->xml->NFe->infNFe->total->ICMSTot->vICMS->__toString();
		$this->icmsstbase = $this->xml->NFe->infNFe->total->ICMSTot->vBCST->__toString();
		$this->icmsstvalor = $this->xml->NFe->infNFe->total->ICMSTot->vST->__toString();
		$this->ipivalor = $this->xml->NFe->infNFe->total->ICMSTot->vIPI->__toString();
		$this->valorprodutos = $this->xml->NFe->infNFe->total->ICMSTot->vProd->__toString();
		$this->valorfrete = $this->xml->NFe->infNFe->total->ICMSTot->vFrete->__toString();
		$this->valorseguro = $this->xml->NFe->infNFe->total->ICMSTot->vSeg->__toString();
		$this->valordesconto = $this->xml->NFe->infNFe->total->ICMSTot->vDesc->__toString();
		$this->valoroutras = $this->xml->NFe->infNFe->total->ICMSTot->vOutro->__toString();
		$this->valortotal = $this->xml->NFe->infNFe->total->ICMSTot->vNF->__toString();
		
		if (empty($this->indsituacao))
			$this->indsituacao = NfeTerceiro::INDSITUACAO_AUTORIZADA;
		
		if (empty($this->indmanifestacao))
			$this->indmanifestacao = NfeTerceiro::INDMANIFESTACAO_SEM;
		
		$this->serie = $this->xml->NFe->infNFe->ide->serie->__toString();
		$this->numero = $this->xml->NFe->infNFe->ide->nNF->__toString();
		
		if (!$this->save())
			return false;
		
		foreach($this->xml->NFe->infNFe->det as $item)
		{
			
			$nfitem = NfeTerceiroItem::model()->find(
				"codnfeterceiro = :codnfeterceiro AND nitem = :nitem", 
				array(
					":codnfeterceiro"=>$this->codnfeterceiro,
					":nitem"=>$item->attributes()->nItem->__toString(),
				)
			);
			
			if ($nfitem === NULL)
				$nfitem = new NfeTerceiroItem ();
			
			$nfitem->codnfeterceiro = $this->codnfeterceiro;
			$nfitem->nitem = $item->attributes()->nItem->__toString();
			$nfitem->cprod = $item->prod->cProd->__toString();
			$nfitem->xprod = $item->prod->xProd->__toString();
			$nfitem->cean = $item->prod->cEAN->__toString();
			$nfitem->ncm = $item->prod->NCM->__toString();
			$nfitem->cfop = $item->prod->CFOP->__toString();
			$nfitem->ucom = $item->prod->uCom->__toString();
			$nfitem->qcom = $item->prod->qCom->__toString();
			$nfitem->vuncom = $item->prod->vUnCom->__toString();
			$nfitem->vprod = $item->prod->vProd->__toString();
			$nfitem->ceantrib = $item->prod->cEANTrib->__toString();
			$nfitem->utrib = $item->prod->uTrib->__toString();
			$nfitem->qtrib = $item->prod->qTrib->__toString();
			$nfitem->vuntrib = $item->prod->vUnTrib->__toString();
			
			if (isset($item->imposto->ICMS))
			{
				foreach ($item->imposto->ICMS->children() as $icms)
				{
					$nfitem->cst = $icms->CST->__toString();
					$nfitem->csosn = $icms->CSOSN->__toString();
					$nfitem->vbc = $icms->vBC->__toString();
					$nfitem->picms = $icms->pICMS->__toString();
					$nfitem->vicms = $icms->vICMS->__toString();
					$nfitem->vbcst = $icms->vBCST->__toString();
					$nfitem->picmsst = $icms->pICMSST->__toString();
					$nfitem->vicmsst = $icms->vICMSST->__toString();
				}
			}
			
			if (isset($item->imposto->IPI->IPITrib))
			{
				$nfitem->ipivbc = $item->imposto->IPI->IPITrib->vBC->__toString();
				$nfitem->ipipipi = $item->imposto->IPI->IPITrib->pIPI->__toString();
				$nfitem->ipivipi = $item->imposto->IPI->IPITrib->vIPI->__toString();
			}
			
			$nfitem->copiaDadosUltimaOcorrencia();

			if (!$nfitem->save())
			{
				$this->addError("arquivoxml", "Erro ao importar Item '$nfitem->nitem' do arquivo XML");
				$this->addErrors($nfitem->getErrors());
				return false;
			}
			
		}
		
		if (!isset($this->xml->NFe->infNFe->cobr->dup))
			return true;
		
		foreach($this->xml->NFe->infNFe->cobr->dup as $dup)
		{
			$nfdup = NfeTerceiroDuplicata::model()->find(
				"codnfeterceiro = :codnfeterceiro AND ndup = :ndup", 
				array(
					":codnfeterceiro"=>$this->codnfeterceiro,
					":ndup"=>$dup->nDup->__toString(),
				)
			);
			
			if ($nfdup === NULL)
				$nfdup = new NfeTerceiroDuplicata ();
			
			$nfdup->codnfeterceiro = $this->codnfeterceiro;
			$nfdup->ndup = $dup->nDup->__toString();
			$nfdup->vdup = $dup->vDup->__toString();
			
			if ($vencimento = DateTime::createFromFormat("Y-m-d", $dup->dVenc->__toString()))
				$nfdup->dvenc = $vencimento->format("d/m/Y");
			
			if (!$nfdup->save())
			{
				$this->addError("arquivoxml", "Erro ao importar Duplicata '$nfdup->ndup' do arquivo XML");
				$this->addErrors($nfdup->getErrors());
				return false;
			}
			
		}
		
		$this->findByPk($this->codnfeterceiro);
		
		return true;
		
	}
	
	/**
	 * 
	 * @return boolean
	 */
	public function podeEditar()
	{
		if (!empty($this->codnotafiscal))
			return false;
		
		if (empty($this->NfeTerceiroItems))
			return false;
		
		return true;
		
	}
	
	public function importar()
	{
		
		$transaction = Yii::app()->db->beginTransaction();
		
		$nf = new NotaFiscal();
		
		$nf->codnaturezaoperacao = $this->codnaturezaoperacao;
		$nf->emitida = false;
		$nf->nfechave = $this->nfechave;
		//$nf->nfeimpressa = false;
		$nf->serie = $this->serie;
		$nf->numero = $this->numero;
		$nf->emissao = $this->emissao;
		$nf->saida = $this->entrada;
		$nf->codfilial = $this->codfilial;
		$nf->codpessoa = $this->codpessoa;
		//$nf->observacoes = 
		//$nf->volumes = 
		//$nf->fretepagar = 
		//$nf->codoperacao = $this->NaturezaOperacao->codoperacao;
		//$nf->nfereciboenvio = 
		//$nf->nfedataenvio = 
		//$nf->nfeautorizacao = 
		//$nf->nfedataautorizacao = 
		$nf->valorfrete = $this->valorfrete;
		$nf->valorseguro = $this->valorseguro;
		$nf->valordesconto = $this->valordesconto;
		$nf->valoroutras = $this->valoroutras;
		//$nf->nfecancelamento = 
		//$nf->nfedatacancelamento = 
		//$nf->nfeinutilizacao = 
		//$nf->nfedatainutilizacao = 
		//$nf->justificativa = 
		$nf->modelo = NotaFiscal::MODELO_NFE;
		//$nf->alteracao = 
		//$nf->codusuarioalteracao = 
		//$nf->criacao = 
		//$nf->codusuariocriacao = 
		$nf->valorprodutos = $this->valorprodutos;
		$nf->valortotal = $this->valortotal;
		//$nf->icmsbase =
		//$nf->icmsvalor = 
		//$nf->icmsstbase = 
		//$nf->icmsstvalor = 
		//$nf->ipibase = 
		//$nf->ipivalor = 
		
		if (!$nf->save())
		{
			$this->addErrors($nf->getErrors());
			$transaction->rollBack();
			return false;
		}
		
		foreach($this->NfeTerceiroDuplicatas as $ntd)
		{
			$nfd = new NotaFiscalDuplicatas();
			$nfd->codnotafiscal = $nf->codnotafiscal;
			$nfd->fatura = $ntd->ndup;
			$nfd->valor = $ntd->vdup;
			$nfd->vencimento = $ntd->dvenc;
			
			if (!$nfd->save())
			{
				$this->addErrors($nfd->getErrors());
				$transaction->rollBack();
				return false;
			}
			
		}
		
		foreach ($this->NfeTerceiroItems as $nti)
		{
			if (empty($nti->vsugestaovenda))
			{
				$this->addError("codnfeterceiro", "Não foi informado os detalhes para todos os itens!");
				$transaction->rollBack();
				return false;
			}
			
			$nfpb = new NotaFiscalProdutoBarra();
			
			$nfpb->codnotafiscal = $nf->codnotafiscal;
			$nfpb->codprodutobarra = $nti->codprodutobarra;
			//$nfpb->codcfop = 
			//$nfpb->descricaoalternativa = 
			$nfpb->quantidade = $nti->qcom;
			$nfpb->valorunitario = $nti->vuncom;
			$nfpb->valortotal = $nti->vprod;
			$nfpb->icmsbase = $nti->vbc;
			$nfpb->icmspercentual = $nti->picms;
			$nfpb->icmsvalor = $nti->vicms;
			$nfpb->ipibase = $nti->ipivbc;
			$nfpb->ipipercentual = $nti->ipipipi;
			$nfpb->ipivalor = $nti->ipivipi;
			$nfpb->icmsstbase = $nti->vbcst;
			$nfpb->icmsstpercentual = $nti->picmsst;
			$nfpb->icmsstvalor = $nti->vicmsst;
			//$nfpb->csosn = 
			//$nfpb->codnegocioprodutobarra = 
			//$nfpb->alteracao = 
			//$nfpb->codusuarioalteracao = 
			//$nfpb->criacao = 
			//$nfpb->codusuariocriacao = 
			
			if (!$nfpb->save())
			{
				$this->addErrors($nfpb->getErrors());
				$transaction->rollBack();
				return false;
			}
		}
		
		$this->codnotafiscal = $nf->codnotafiscal;
		
		if (!$this->save())
		{
			$transaction->rollBack();
			return false;
		}
		
		$transaction->commit();
		return true;
	}
	
	
}

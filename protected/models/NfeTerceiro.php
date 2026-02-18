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
 * @property integer $ignorada
 * @property integer $indmanifestacao
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 * @property string $codfilial
 * @property string $codnotafiscal
 * @property string $codnegocio
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
 * @property string $justificativa
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
 * @property Negocio $Negocio
 * @property NaturezaOperacao $NaturezaOperacao
 */
class NfeTerceiro extends MGActiveRecord
{
    const INDSITUACAO_AUTORIZADA = 1;
    const INDSITUACAO_DENEGADA = 2;
    const INDSITUACAO_CANCELADA = 3;

    const INDMANIFESTACAO_SEM = 0;
    const INDMANIFESTACAO_REALIZADA = 210200;
    const INDMANIFESTACAO_DESCONHECIDA = 210220;
    const INDMANIFESTACAO_NAOREALIZADA = 210240;
    const INDMANIFESTACAO_CIENCIA = 210210;

    const DIRETORIO_XML = "/media/publico/Arquivos/XML";

    public $emissao_de;
    public $emissao_ate;

    public $valor_de;
    public $valor_ate;

    public $codgrupoeconomico;
    public $codtipoproduto;

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
            array('emitente, codfilial', 'required'),
            array('indsituacao, indmanifestacao, serie, numero, modelo, finalidade, tipo', 'numerical', 'integerOnly' => true),
            array('nsu, ie', 'length', 'max' => 20),
            array('nfechave, emitente, natureza', 'length', 'max' => 100),
            array('nfechave', 'validaChaveNFE'),
            //array('arquivoxml', 'file', 'types'=>'xml'),
            array('cnpj, valortotal, icmsbase, icmsvalor, icmsstbase, icmsstvalor, ipivalor, valorprodutos, valorfrete, valorseguro, valordesconto, valoroutras', 'length', 'max' => 14),
            array('justificativa', 'length', 'max' => 200),
            array('entrada', 'validaEntrada'),
            array('codpessoa, emissao, nfedataautorizacao, codoperacao, alteracao, codusuarioalteracao, criacao, codusuariocriacao, codnotafiscal, codnaturezaoperacao, entrada, ignorada, codnegocio, informacoes, observacoes, revisao, codusuariorevisao, conferencia, codusuarioconferencia', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('emissao_de, emissao_ate, valor_de, valor_ate, codnfeterceiro, nsu, nfechave, cnpj, ie, emitente, codgrupoeconomico, codpessoa, emissao, nfedataautorizacao, codoperacao, valortotal, indsituacao, indmanifestacao, alteracao, codusuarioalteracao, criacao, codusuariocriacao, codfilial, codnotafiscal, codnaturezaoperacao, serie, numero, entrada, icmsbase, icmsvalor, icmsstbase, icmsstvalor, ipivalor, valorprodutos, valorfrete, valorseguro, valordesconto, valoroutras, justificativa, ignorada, codnegocio, natureza, modelo, finalidade, informacoes, observacoes, tipo, revisao, codusuariorevisao', 'safe', 'on' => 'search'),
        );
    }

    public function validaChaveNFE($attribute, $params)
    {
        if (strlen($this->nfechave) != 44) {
            $this->addError($attribute, "Chave da NFE é Inválida!");
            return;
        }

        $digito = NotaFiscal::calculaDigitoChaveNFE($this->nfechave);

        if ($digito == -1) {
            $this->addError($attribute, "Chave da NFE Inválida!");
            return;
        }

        if (substr($this->nfechave, 43, 1) <> $digito) {
            $this->addError($attribute, "Dígito da Chave da NFE Inválido!");
            return;
        }

        $condicao = "nfechave = :nfechave";
        $parametros["nfechave"] = $this->nfechave;

        if (!empty($this->codnfeterceiro)) {
            $condicao .= " AND codnfeterceiro != :codnfeterceiro";
            $parametros["codnfeterceiro"] = $this->codnfeterceiro;
        }

        if (NfeTerceiro::model()->findAll($condicao, $parametros)) {
            $this->addError($attribute, "Esta Chave já está cadastrada no sistema!");
        }
    }

    public function validaEntrada($attribute, $params)
    {
        if (empty($this->entrada)) {
            return;
        }
        $entrada = DateTime::createFromFormat("d/m/Y H:i:s", $this->entrada);
        $emissao = DateTime::createFromFormat("d/m/Y H:i:s", $this->emissao);
        if ($entrada < $emissao) {
            $this->addError($attribute, 'A data de entrada não pode ser anterior à data de emissão!');
            return;
        }
        $hoje = new DateTime('now');
        if ($entrada > $hoje) {
            $this->addError($attribute, 'A data de entrada não pode ser posterior à data atual!');
            return;
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
            'NfeTerceiroPagamentos' => array(self::HAS_MANY, 'NfeTerceiroPagamento', 'codnfeterceiro'),
            'TituloNfeTerceiros' => array(self::HAS_MANY, 'TituloNfeTerceiro', 'codnfeterceiro'),
            'DistribuicaoDfes' => array(self::HAS_MANY, 'DistribuicaoDfe', 'codnfeterceiro'),
            'NfeTerceiroDuplicatas' => array(self::HAS_MANY, 'NfeTerceiroDuplicata', 'codnfeterceiro', 'order' => 'dvenc ASC'),
            'Negocio' => array(self::BELONGS_TO, 'Negocio', 'codnegocio'),
            'Filial' => array(self::BELONGS_TO, 'Filial', 'codfilial'),
            'NaturezaOperacao' => array(self::BELONGS_TO, 'NaturezaOperacao', 'codnaturezaoperacao'),
            'NotaFiscal' => array(self::BELONGS_TO, 'NotaFiscal', 'codnotafiscal'),
            'Operacao' => array(self::BELONGS_TO, 'Operacao', 'codoperacao'),
            'Pessoa' => array(self::BELONGS_TO, 'Pessoa', 'codpessoa'),
            'UsuarioCriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
            'UsuarioAlteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
            'UsuarioRevisao' => array(self::BELONGS_TO, 'Usuario', 'codusuariorevisao'),
            'UsuarioConferencia' => array(self::BELONGS_TO, 'Usuario', 'codusuarioconferencia'),
            'NfeTerceiroItems' => array(self::HAS_MANY, 'NfeTerceiroItem', 'codnfeterceiro', 'order' => 'nitem ASC'),
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
            'ignorada' => 'Ignorar NFe',
            'indmanifestacao' => 'Manifestação',
            'alteracao' => 'Alteração',
            'codusuarioalteracao' => 'Usuário Alteração',
            'criacao' => 'Criação',
            'codusuariocriacao' => 'Usuario Criação',
            'codfilial' => 'Filial',
            'codnotafiscal' => 'Nota Fiscal',
            'codnegocio' => 'Negócio',
            'codnaturezaoperacao' => 'Natureza de Operação (Nossa)',
            'natureza' => 'Natureza de Operação (Contraparte)',
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
            'justificativa' => 'Justificativa',
            'arquivoxml' => 'Arquivo XML',
            'informacoes' => 'Informações Complementares',
            'observacoes' => 'Observações',
            'conferencia' => 'Data Conferencia',
            'codusuarioconferencia' => 'Usuário Conferencia',
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

        $criteria = new CDbCriteria;

        $criteria->with = array(
            'Pessoa' => array('select' => '"Pessoa".fantasia'),
            'Filial' => array('select' => '"Filial".filial'),
            // 'Portador' => array('select' => '"Portador".portador'),
            // 'UsuarioCriacao' => array('select' => '"UsuarioCriacao".usuario'),
            // 'UsuarioAlteracao' => array('select' => '"UsuarioAlteracao".usuario'),
            // 'ContaContabil' => array('select' => '"ContaContabil".contacontabil'),
            // 'TipoTitulo' => array('select' => '"TipoTitulo".tipotitulo'),
        );

        $criteria->compare('t.codnfeterceiro', $this->codnfeterceiro, false);
        $criteria->compare('t.nsu', $this->nsu, true);
        $criteria->compare('t.nfechave', $this->nfechave, true);
        $criteria->compare('t.cnpj', $this->cnpj, true);
        $criteria->compare('t.ie', $this->ie, true);
        $criteria->compare('t.emitente', $this->emitente, true);
        $criteria->compare('t.codpessoa', $this->codpessoa);
        $criteria->compare('t.codfilial', $this->codfilial);
        $criteria->compare('t.nfedataautorizacao', $this->nfedataautorizacao, true);
        $criteria->compare('t.codoperacao', $this->codoperacao, true);
        $criteria->compare('t.indsituacao', $this->indsituacao);
        $criteria->compare('t.indmanifestacao', $this->indmanifestacao);
        $criteria->compare('t.alteracao', $this->alteracao, true);
        $criteria->compare('t.codusuarioalteracao', $this->codusuarioalteracao, true);
        $criteria->compare('t.criacao', $this->criacao, true);
        $criteria->compare('t.codusuariocriacao', $this->codusuariocriacao, true);

        switch ($this->revisao) {
            case 'R':
                $criteria->addCondition('t.revisao IS NOT NULL');
                break;

            case 'N':
                $criteria->addCondition('t.revisao IS NULL');
                break;
        }

        switch ($this->conferencia) {
            case 'C':
                $criteria->addCondition('t.conferencia IS NOT NULL');
                break;

            case 'N':
                $criteria->addCondition('t.conferencia IS NULL');
                break;
        }

        switch ($this->codnotafiscal) {
            case 1: // Pendentes
                $criteria->addCondition(
                    't.codnotafiscal IS NULL '
                        . ' AND (t.indmanifestacao IS NULL OR t.indmanifestacao NOT IN (' . self::INDMANIFESTACAO_DESCONHECIDA . ', ' . self::INDMANIFESTACAO_NAOREALIZADA . '))'
                        . ' AND t.indsituacao = ' . self::INDSITUACAO_AUTORIZADA
                        . ' AND t.ignorada = FALSE '
                );
                break;

            case 2: // Importadas
                $criteria->addCondition('t.codnotafiscal IS NOT NULL');
                break;

            case 3: //
                $criteria->addCondition(
                    't.indmanifestacao IN (' . self::INDMANIFESTACAO_DESCONHECIDA . ', ' . self::INDMANIFESTACAO_NAOREALIZADA . ')'
                        . ' OR t.indsituacao != ' . self::INDSITUACAO_AUTORIZADA
                        . ' OR t.ignorada = TRUE '
                );
                break;

            default:
                break;
        }

        $criteria->compare('t.codnegocio', $this->codnegocio);


        if ($emissao_de = DateTime::createFromFormat("d/m/y", $this->emissao_de)) {
            $criteria->addCondition('t.emissao >= :emissao_de');
            $criteria->params[':emissao_de'] = $emissao_de->format('Y-m-d') . ' 00:00:00.0';
        }

        if ($emissao_ate = DateTime::createFromFormat("d/m/y", $this->emissao_ate)) {
            $criteria->addCondition('t.emissao <= :emissao_ate');
            $criteria->params[':emissao_ate'] = $emissao_ate->format('Y-m-d') . ' 23:59:59.9';
        }

        if ($this->valor_de) {
            $criteria->addCondition('t.valortotal >= :valor_de');
            $criteria->params[':valor_de'] = $this->valor_de;
        }

        if ($this->valor_ate) {
            $criteria->addCondition('t.valortotal <= :valor_ate');
            $criteria->params[':valor_ate'] = $this->valor_ate;
        }

        if ($this->codgrupoeconomico) {
            $criteria->compare('"Pessoa".codgrupoeconomico', $this->codgrupoeconomico, false);
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array('defaultOrder' => 't.emissao ASC, t.valortotal asc'),
            'pagination' => array('pageSize' => 20)
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return NfeTerceiro the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    protected function beforeSave()
    {
        if (empty($this->cnpj)) {
            $this->cnpj = substr($this->nfechave, 6, 14);
            if (empty($this->codpessoa)) {
                $pessoas = Pessoa::model()->findAll("cnpj = :cnpj", array(":cnpj" => $this->cnpj));
                foreach ($pessoas as $pessoa) {
                    if (empty($pessoa->inativo)) {
                        $this->codpessoa = $pessoa->codpessoa;
                    }
                }
            }
        }

        if (empty($this->indsituacao)) {
            $this->indsituacao = self::INDSITUACAO_AUTORIZADA;
        }

        if (empty($this->emissao)) {
            $this->emissao = date('d/m/Y H:i:s');
        }

        if (empty($this->codpessoa)) {
            $cnpj = $this->cnpj;
            if (empty($cnpj)) {
                $cnpj = 0;
            }
            $pessoas = Pessoa::model()->findAll("cnpj = :cnpj", array(":cnpj" => $cnpj));

            foreach ($pessoas as $pessoa) {
                if (Yii::app()->format->numeroLimpo($this->ie) == Yii::app()->format->numeroLimpo($pessoa->ie)) {
                    $this->codpessoa = $pessoa->codpessoa;
                }
            }
        }

        if (empty($this->codnotafiscal)) {
            if ($nf = NotaFiscal::model()->find('emitida = false and nfechave = :nfechave', array(':nfechave' => $this->nfechave))) {
                $this->codnotafiscal = $nf->codnotafiscal;
            }
        }

        return parent::beforeSave();
    }

    public function getIndSituacaoListaCombo()
    {
        return array(
            self::INDSITUACAO_AUTORIZADA => "Autorizada",
            self::INDSITUACAO_DENEGADA => "Denegada",
            self::INDSITUACAO_CANCELADA => "Cancelada",
        );
    }

    public function getIndSituacaoDescricao()
    {
        $arr = $this->getIndSituacaoListaCombo();
        return @$arr[$this->indsituacao];
    }

    public function getIndManifestacaoListaCombo()
    {
        return array(
            self::INDMANIFESTACAO_SEM => "Sem Manifestação",
            self::INDMANIFESTACAO_REALIZADA => "Operação Realizada",
            self::INDMANIFESTACAO_DESCONHECIDA => "Operação Desconhecida",
            self::INDMANIFESTACAO_NAOREALIZADA => "Operação Não Realizada",
            self::INDMANIFESTACAO_CIENCIA => "Ciência da Operação",
        );
    }

    public function getIndManifestacaoDescricao()
    {
        $arr = $this->getIndManifestacaoListaCombo();
        return @$arr[$this->indmanifestacao];
    }

    public function lerXml($arquivoxml = null)
    {
        if (empty($arquivoxml)) {
            $this->arquivoxml = $this->montarCaminhoArquivoXml();
            $arquivoxml = $this->arquivoxml;
        }

        $xml = file_get_contents($arquivoxml);

        if ($this->xml = @simplexml_load_string($xml)) {
            return true;
        }

        // replace & followed by a bunch of letters, numbers
        // and underscores and an equal sign with &amp;
        //$xml = preg_replace('/&[^; ]{0,6}.?/e', "((substr('\\0',-1) == ';') ? '\\0' : '&amp;'.substr('\\0',1))", $xml);
        $xml = self::limpaCaracteresEspeciaisXml($xml);

        return $this->xml = @simplexml_load_string($xml);
    }

    public static function limpaCaracteresEspeciaisXml($xml)
    {
        return preg_replace_callback(
            '/&[^; ]{0,6}.?/',
            create_function(
                // single quotes are essential here,
                // or alternative escape all $ as \$
                '$matches',
                'return str_replace(\'&\', \'e\', $matches[0]);'
            ),
            $xml
        );
    }

    public function montarCaminhoArquivoXml()
    {
        /*
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
        */

        $arquivo = "/opt/www/NFePHP/Arquivos/NFe/{$this->codfilial}";
        $arquivo .= (($this->Filial->nfeambiente == Filial::NFEAMBIENTE_PRODUCAO) ? '/producao/' : '/homologacao/');
        $arquivo .= 'recebidas/' . substr($this->emissao, 6, 4) . substr($this->emissao, 3, 2) . '/';
        $arquivo .= $this->nfechave . '-nfeProc.xml';

        //retorna caminho
        return $arquivo;
    }

    public function importarXmlViaString($str)
    {
        $this->arquivoxml = $this->montarCaminhoArquivoXml();

        if (!@file_put_contents($this->arquivoxml, $str)) {
            $this->addError("arquivoxml", "Erro ao salvar arquivo {$this->arquivoxml}!");
            return false;
        }

        if (!$this->importarXml()) {
            $this->addError("arquivoxml", "Erro ao importar o arquivo {$this->arquivoxml}!");
            return false;
        }

        return true;
    }

    public function importarXmlViaArquivo()
    {
        if (!$this->arquivoxml instanceof CUploadedFile) {
            $this->addError("arquivoxml", "Nenhum arquivo selecionado!");
            return false;
        }

        if ($this->arquivoxml->getType() != "text/xml") {
            $this->addError("arquivoxml", "Tipo de arquivo inválido, deve ser um XML!");
            return false;
        }

        if (!$this->lerXml($this->arquivoxml->tempName)) {
            $this->addError("arquivoxml", "Arquivo XML inválido!");
            return false;
        }

        if (
            !empty($this->nfechave)
            && $this->nfechave != Yii::app()->format->NumeroLimpo($this->xml->NFe->infNFe->attributes()->Id->__toString())
        ) {
            $this->addError("arquivoxml", "Arquivo XML não corresponde à NFe selecionada!");
            return false;
        }

        $caminho = $this->montarCaminhoArquivoXml();

        if (!$this->arquivoxml->saveAs($caminho)) {
            $this->addError("arquivoxml", "Erro ao salvar arquivo em {$caminho}!");
            return false;
        }
        $this->arquivoxml = $caminho;

        if (!$this->importarXml()) {
            $this->addError("arquivoxml", "Erro ao importar o arquivo {$this->arquivoxml}!");
            return false;
        }

        return true;
    }

    public function importarXml()
    {
        if (!$this->lerXml()) {
            $this->addError("arquivoxml", "Erro ao ler arquivo em {$this->arquivoxml}!");
            return false;
        }

        $nft = NfeTerceiro::model()->find(
            "nfechave = :nfechave",
            array(
                ":nfechave" => $this->nfechave
            )
        );

        if ($nft !== null) {
            $this->attributes = $nft->attributes;
            $this->setPrimaryKey($nft->codnfeterceiro);
            $this->setIsNewRecord(false);
        }

        if (isset($this->xml->NFe->infNFe)) {
            $infNFe = $this->xml->NFe->infNFe;
        }

        if (isset($this->xml->infNFe)) {
            $infNFe = $this->xml->infNFe;
        }

        $cnpj = $infNFe->dest->CNPJ;
        if (empty($cnpj)) {
            $cnpj = $infNFe->dest->CPF;
        }

        if (!empty($infNFe->dest->IE)) {
            if ($pessoa = Pessoa::model()->find("cnpj = :cnpj AND ie = :ie", array(":cnpj" => $cnpj, ":ie" => $infNFe->dest->IE))) {
                if ($filial = Filial::model()->find("codpessoa = :codpessoa", array(":codpessoa" => $pessoa->codpessoa))) {
                    $this->codfilial = $filial->codfilial;
                }
            }
        } elseif ($pessoa = Pessoa::model()->find("cnpj = :cnpj", array(":cnpj" => $cnpj))) {
            if ($filial = Filial::model()->find("codpessoa = :codpessoa", array(":codpessoa" => $pessoa->codpessoa))) {
                $this->codfilial = $filial->codfilial;
            }
        }

        $this->nfechave = Yii::app()->format->NumeroLimpo($infNFe->attributes()->Id->__toString());
        $this->cnpj = $infNFe->emit->CNPJ->__toString();
        if (empty($this->cnpj)) {
            $this->cnpj = $infNFe->emit->CPF->__toString();
        }
        $this->ie = $infNFe->emit->IE->__toString();
        $this->emitente = $infNFe->emit->xNome->__toString();


        //<dhEmi>2015-10-09T00:00:00-04:00</dhEmi>
        if (!($dh = DateTime::createFromFormat('Y-m-d\TH:i:sP', $infNFe->ide->dhEmi->__toString()))) {
            //<dEmi>2015-10-09</dhEmi>
            if (!($dh = DateTime::createFromFormat('Y-m-d', $infNFe->ide->dEmi->__toString()))) {
                $this->addError("arquivoxml", "Impossível determinar a data de emissão da NF-e!");
                return false;
            }
        }
        $this->emissao = $dh->format("d/m/Y H:i:s");

        $this->codoperacao = $infNFe->ide->__toString() + 1;

        $this->icmsbase = $infNFe->total->ICMSTot->vBC->__toString();
        $this->icmsvalor = $infNFe->total->ICMSTot->vICMS->__toString();
        $this->icmsstbase = $infNFe->total->ICMSTot->vBCST->__toString();
        $this->icmsstvalor = $infNFe->total->ICMSTot->vST->__toString();
        $this->ipivalor = $infNFe->total->ICMSTot->vIPI->__toString();
        $this->valorprodutos = $infNFe->total->ICMSTot->vProd->__toString();
        $this->valorfrete = $infNFe->total->ICMSTot->vFrete->__toString();
        $this->valorseguro = $infNFe->total->ICMSTot->vSeg->__toString();
        $this->valordesconto = $infNFe->total->ICMSTot->vDesc->__toString();
        $this->valoroutras = $infNFe->total->ICMSTot->vOutro->__toString();
        $this->valortotal = $infNFe->total->ICMSTot->vNF->__toString();

        if (empty($this->indsituacao)) {
            $this->indsituacao = NfeTerceiro::INDSITUACAO_AUTORIZADA;
        }

        if (empty($this->indmanifestacao)) {
            $this->indmanifestacao = NfeTerceiro::INDMANIFESTACAO_SEM;
        }

        $this->serie = $infNFe->ide->serie->__toString();
        $this->numero = $infNFe->ide->nNF->__toString();

        if (!$this->save()) {
            return false;
        }

        foreach ($infNFe->det as $item) {
            $nfitem = NfeTerceiroItem::model()->find(
                "codnfeterceiro = :codnfeterceiro AND nitem = :nitem",
                array(
                    ":codnfeterceiro" => $this->codnfeterceiro,
                    ":nitem" => $item->attributes()->nItem->__toString(),
                )
            );

            if ($nfitem === null) {
                $nfitem = new NfeTerceiroItem();
            }

            $nfitem->codnfeterceiro = $this->codnfeterceiro;
            $nfitem->nitem = $item->attributes()->nItem->__toString();
            $nfitem->cprod = $item->prod->cProd->__toString();
            $nfitem->xprod = $item->prod->xProd->__toString();
            $nfitem->cean = $item->prod->cEAN->__toString();
            $nfitem->ncm = $item->prod->NCM->__toString();
            if (isset($item->prod->CEST)) {
                $nfitem->cest = $item->prod->CEST->__toString();
            }
            $nfitem->cfop = $item->prod->CFOP->__toString();
            $nfitem->ucom = $item->prod->uCom->__toString();
            $nfitem->qcom = $item->prod->qCom->__toString();
            $nfitem->vuncom = $item->prod->vUnCom->__toString();
            $nfitem->vprod = $item->prod->vProd->__toString();

            $nfitem->vfrete = $item->prod->vFrete->__toString();
            $nfitem->vseg = $item->prod->vSeg->__toString();
            $nfitem->vdesc = $item->prod->vDesc->__toString();
            $nfitem->voutro = $item->prod->vOutro->__toString();

            $nfitem->infadprod = $item->infAdProd->__toString();
            $nfitem->ceantrib = $item->prod->cEANTrib->__toString();
            $nfitem->utrib = $item->prod->uTrib->__toString();
            $nfitem->qtrib = $item->prod->qTrib->__toString();
            $nfitem->vuntrib = $item->prod->vUnTrib->__toString();

            if (isset($item->imposto->ICMS)) {
                foreach ($item->imposto->ICMS->children() as $icms) {
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

            if (isset($item->imposto->IPI->IPITrib)) {
                $nfitem->ipivbc = $item->imposto->IPI->IPITrib->vBC->__toString();
                $nfitem->ipipipi = $item->imposto->IPI->IPITrib->pIPI->__toString();
                $nfitem->ipivipi = $item->imposto->IPI->IPITrib->vIPI->__toString();
            }

            if (empty($nfitem->codprodutobarra)) {
                $nfitem->copiaDadosUltimaOcorrencia();
            }

            if (!$nfitem->save()) {
                $this->addError("arquivoxml", "Erro ao importar Item '$nfitem->nitem' do arquivo XML");
                $this->addErrors($nfitem->getErrors());
                return false;
            }
        }

        if (!isset($infNFe->cobr->dup)) {
            return true;
        }

        $codnfeterceiroduplicadaProcessado = [0];

        foreach ($infNFe->cobr->dup as $dup) {
            $notin = implode(', ', $codnfeterceiroduplicadaProcessado);

            $nfdup = NfeTerceiroDuplicata::model()->find(
                "codnfeterceiro = :codnfeterceiro AND ndup = :ndup AND dvenc = :dvenc AND codnfeterceiroduplicata NOT IN ($notin)",
                array(
                    ":codnfeterceiro" => $this->codnfeterceiro,
                    ":ndup" => $dup->nDup->__toString(),
                    ":dvenc" => $dup->dVenc->__toString(),
                )
            );

            if ($nfdup === null) {
                $nfdup = new NfeTerceiroDuplicata();
            }

            $nfdup->codnfeterceiro = $this->codnfeterceiro;
            $nfdup->ndup = $dup->nDup->__toString();
            $nfdup->vdup = $dup->vDup->__toString();

            if ($vencimento = DateTime::createFromFormat("Y-m-d", $dup->dVenc->__toString())) {
                $nfdup->dvenc = $vencimento->format("d/m/Y");
            }

            if (!$nfdup->save()) {
                $this->addError("arquivoxml", "Erro ao importar Duplicata '$nfdup->ndup' do arquivo XML");
                $this->addErrors($nfdup->getErrors());
                return false;
            }

            $codnfeterceiroduplicadaProcessado[] = $nfdup->codnfeterceiroduplicata;
        }

        foreach ($nft->NfeTerceiroDuplicatas as $nfdup) {
            if (!in_array($nfdup->codnfeterceiroduplicata, $codnfeterceiroduplicadaProcessado)) {
                if (!$nfdup->delete()) {
                    $this->addError("arquivoxml", "Erro ao excluir NfeTerceiroDuplicata sobrando #'$nfdup->codnfeterceiro'");
                    $this->addErrors($nfdup->getErrors());
                    return false;
                }
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
        if (!empty($this->codnotafiscal)) {
            return false;
        }

        if (isset($this->Negocio)) {
            if ($this->Negocio->codnegociostatus != NegocioStatus::CANCELADO) {
                return false;
            }
        }

        //if (empty($this->NfeTerceiroItems))
        //	return false;

        return true;
    }

    public function podeImportar()
    {
        if (empty($this->codnaturezaoperacao)) {
            $this->addError("codnaturezaoperacao", "Você deve informar a natureza de Operação!");
            return false;
        }

        if (empty($this->entrada)) {
            $this->addError("entrada", "Você deve informar a data de Entrada/Saída!");
            return false;
        }

        if (empty($this->codpessoa)) {
            $this->addError("codpessoa", "Você deve informar a Pessoa!");
            return false;
        }

        $command = Yii::app()->db->createCommand('
  				SELECT count(codnfeterceiroitem) AS count
  				  FROM tblnfeterceiroitem
  				 WHERE codnfeterceiro = :codnfeterceiro
  				   AND codprodutobarra is null
  			');
        $command->params = [
            "codnfeterceiro" => $this->codnfeterceiro,
        ];
        $ret = $command->queryRow();

        if ($ret['count'] > 0) {
            $this->addError("codnfeterceiro", "Não foi informado o produto relacionado de todos os itens!");
            return false;
        }
        return true;
    }

    public function importar()
    {
        if (!$this->podeImportar()) {
            return false;
        }

        $transaction = Yii::app()->db->beginTransaction();

        $geraNegocio = true;
        if (count($this->Pessoa->Filials) > 0) {
            $geraNegocio = false;
        }

        $codnegocioformapagamento = null;

        $totalEsperado =
            $this->valorprodutos
            + $this->ipivalor
            + $this->icmsstvalor
            + $this->valorfrete
            + $this->valorseguro
            - $this->valordesconto
            + $this->valoroutras;

        // Gambiarra para solucionar problema ICMS Desonerado que alguns
        // fornecedores estão descontando do valor total da nota
        // Ex. NFe 5120 0609 5900 1800 0408 5500 1000 0079 6219 0581 7124 - Impacto
        $descontoRatear = 0;
        $outrasRatear = 0;
        if ($totalEsperado != $this->valortotal) {
            if ($totalEsperado > $this->valortotal) {
                $descontoRatear = $totalEsperado - $this->valortotal;
            } else {
                $outrasRatear = $this->valortotal - $totalEsperado;
            }
        }

        $nf = new NotaFiscal();

        $nf->codoperacao = $this->NaturezaOperacao->codoperacao;
        $nf->codnaturezaoperacao = $this->codnaturezaoperacao;
        $nf->emitida = false;
        $nf->nfechave = $this->nfechave;
        //$nf->nfeimpressa = false;
        $nf->serie = $this->serie;
        $nf->numero = $this->numero;
        $nf->emissao = $this->emissao;
        $nf->saida = $this->entrada;
        $nf->codfilial = $this->codfilial;
        //TODO: Criar campo na tblNfeTerceiro.codestoquelocal
        if (sizeof($nf->Filial->EstoqueLocals) > 0) {
            $nf->codestoquelocal = $nf->Filial->EstoqueLocals[0]->codestoquelocal;
        }
        $nf->codpessoa = $this->codpessoa;
        $nf->status = 'LAN';
        //$nf->observacoes =
        //$nf->volumes =
        //$nf->frete =
        //$nf->codoperacao = $this->NaturezaOperacao->codoperacao;
        //$nf->nfereciboenvio =
        //$nf->nfedataenvio =
        //$nf->nfeautorizacao =
        //$nf->nfedataautorizacao =

        // Passado para Produtos
        // $nf->valorfrete = $this->valorfrete;
        // $nf->valorseguro = $this->valorseguro;
        // $nf->valordesconto = $this->valordesconto;
        // $nf->valoroutras = $this->valoroutras;

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

        if (!$nf->save()) {
            $this->addErrors($nf->getErrors());
            $transaction->rollBack();
            return false;
        }

        if ($geraNegocio) {
            $n = new Negocio();
            $n->codoperacao = $this->NaturezaOperacao->codoperacao;
            $n->codnaturezaoperacao = $this->codnaturezaoperacao;
            $n->codpessoa = $this->codpessoa;
            $n->codfilial = $this->codfilial;
            $n->codestoquelocal = $this->Filial->EstoqueLocals[0]->codestoquelocal;
            $n->lancamento = $this->entrada;
            $n->codnegociostatus = NegocioStatus::ABERTO;
            $n->codusuario = Yii::app()->user->id;
            // $n->valordesconto = $this->valordesconto; Passasdo para produtos
            $n->valorprodutos = $this->valorprodutos;

            if (!$n->save()) {
                $this->addErrors($n->getErrors());
                $transaction->rollBack();
                return false;
            }

            if ($this->NaturezaOperacao->financeiro) {
                $nfp = new NegocioFormaPagamento();
                $nfp->codnegocio = $n->codnegocio;
                $nfp->codformapagamento = 3010; //Fechamento com boleto
                $nfp->valorpagamento = $this->valortotal;

                if (!$nfp->save()) {
                    $this->addErrors($nfp->getErrors());
                    $transaction->rollBack();
                    return false;
                }
                $codnegocioformapagamento = $nfp->codnegocioformapagamento;
            }
        }


        $i = 0;
        $parcelas = count($this->NfeTerceiroDuplicatas);
        $totalDupl = 0;

        foreach ($this->NfeTerceiroDuplicatas as $ntd) {
            $i++;
            $totalDupl += $ntd->vdup;
            $valorDupl[$i] = $ntd->vdup;
        }

        if ($totalDupl > $this->valortotal) {
            $percDupl = $this->valortotal / $totalDupl;
            $totalDupl = 0;
            for ($i = 1; $i <= $parcelas; $i++) {
                $valorDupl[$i] = round($valorDupl[$i] * $percDupl, 2);
                $totalDupl += $valorDupl[$i];
            }

            $valorDupl[$parcelas] += $this->valortotal - $totalDupl;
        }

        $i = 0;

        foreach ($this->NfeTerceiroDuplicatas as $ntd) {
            $i++;

            $nfd = new NotaFiscalDuplicatas();
            $nfd->codnotafiscal = $nf->codnotafiscal;
            $nfd->fatura = $ntd->ndup;
            $nfd->valor = $valorDupl[$i];
            $nfd->vencimento = $ntd->dvenc;

            if (!$nfd->save()) {
                $this->addErrors($nfd->getErrors());
                $transaction->rollBack();
                return false;
            }

            if ($geraNegocio && $this->NaturezaOperacao->financeiro) {
                $tit = new Titulo();
                $tit->codnegocioformapagamento = $codnegocioformapagamento;
                $tit->codtipotitulo = $n->NaturezaOperacao->codtipotitulo;
                $tit->codfilial = $this->codfilial;
                $tit->codpessoa = $this->codpessoa;
                $tit->codportador = Portador::CARTEIRA;
                $tit->codcontacontabil = $n->NaturezaOperacao->codcontacontabil;
                $tit->numero = "T" . str_pad($n->codnegocio, 8, "0", STR_PAD_LEFT) . "-$i/$parcelas";
                //$tit->fatura = $ntd->ndup;
                $tit->fatura = str_pad($this->numero, 8, "0", STR_PAD_LEFT) . "-$i/$parcelas";
                $tit->transacao = substr($this->entrada, 0, 10);
                $tit->emissao = substr($this->emissao, 0, 10);
                $tit->vencimento = $ntd->dvenc;
                $tit->vencimentooriginal = $ntd->dvenc;
                $tit->gerencial = false;
                $tit->valor = $valorDupl[$i];

                if (!$tit->save()) {
                    $this->addErrors($tit->getErrors());
                    $transaction->rollBack();
                    return false;
                }
            }
        }

        if ($geraNegocio && $this->NaturezaOperacao->financeiro) {
            $difDupl = round($this->valortotal - $totalDupl, 2);

            if (abs($difDupl) > 0.05) {
                $tit = new Titulo();
                $tit->codnegocioformapagamento = $codnegocioformapagamento;
                $tit->codtipotitulo = $n->NaturezaOperacao->codtipotitulo;
                $tit->codfilial = $this->codfilial;
                $tit->codpessoa = $this->codpessoa;
                $tit->codportador = Portador::CARTEIRA;
                $tit->codcontacontabil = $n->NaturezaOperacao->codcontacontabil;
                $tit->numero = "T" . str_pad($n->codnegocio, 8, "0", STR_PAD_LEFT) . "-SLD";
                $tit->fatura = str_pad($this->numero, 8, "0", STR_PAD_LEFT) . "-SLD";
                $tit->transacao = substr($this->entrada, 0, 10);
                $tit->emissao = substr($this->emissao, 0, 10);
                $tit->vencimento = substr($this->emissao, 0, 10);
                $tit->vencimentooriginal = substr($this->emissao, 0, 10);
                $tit->gerencial = false;
                $tit->valor = $difDupl;
                $totalDupl += $tit->valor;

                if (!$tit->save()) {
                    $this->addErrors($tit->getErrors());
                    $transaction->rollBack();
                    return false;
                }
            }
        }

        $quantidadeItens = count($this->NfeTerceiroItems);
        $nItem = 0;
        $descontoRateado = 0;
        $descontoRateadoTotal = 0;
        $outrasRateado = 0;
        $outrasRateadoTotal = 0;

        foreach ($this->NfeTerceiroItems as $nti) {
            $nItem++;

            if ($nItem == $quantidadeItens) {
                $descontoRateado = $descontoRatear - $descontoRateadoTotal;
                $outrasRateado = $outrasRatear - $outrasRateadoTotal;
            } elseif ($this->valorprodutos == 0) {
                $descontoRateado = 0;
                $outrasRateado = 0;
            } else {
                $descontoRateado = round(($descontoRatear / $this->valorprodutos) * $nti->vprod, 2);
                $outrasRateado = round(($outrasRatear / $this->valorprodutos) * $nti->vprod, 2);
            }
            $descontoRateadoTotal += $descontoRateado;
            $outrasRateadoTotal += $outrasRateado;

            if ($geraNegocio) {
                $npb = new NegocioProdutoBarra();
                $npb->codnegocio = $n->codnegocio;
                $npb->codprodutobarra = $nti->codprodutobarra;
                $npb->quantidade = $nti->qcom;
                $npb->valorprodutos = round(
                    $nti->vprod
                        + $nti->ipivipi
                        + $nti->vicmsst
                        - $nti->vdesc
                        + $nti->vfrete
                        + $nti->vseg
                        + $nti->voutro
                        + $outrasRateado
                        - $descontoRateado,
                    2
                );
                $npb->valortotal = $npb->valorprodutos;

                $npb->valorunitario = $npb->valortotal;
                if ($npb->quantidade > 0) {
                    $npb->valorunitario = round($npb->valortotal / $npb->quantidade, 3);
                }

                if (!$npb->save()) {
                    $this->addErrors($npb->getErrors());
                    $transaction->rollBack();
                    return false;
                }
            }

            $nfpb = new NotaFiscalProdutoBarra();

            $nfpb->codnotafiscal = $nf->codnotafiscal;
            $nfpb->codprodutobarra = $nti->codprodutobarra;
            //$nfpb->codcfop =
            //$nfpb->descricaoalternativa =
            $nfpb->quantidade = $nti->qcom;
            $nfpb->valorunitario = $nti->vuncom;
            $nfpb->valortotal = $nti->vprod;
            if (!empty($nti->vicms)) {
                $baseCalculada = (float) $nti->vprod
                    - (float) $nti->vdesc
                    + (float) $nti->vfrete
                    + (float) $nti->vseg
                    + (float) $nti->voutro;

                // Redução para 41.17% da Base de Calculo, pros BITs
                if ($nti->ProdutoBarra->Produto->Ncm->bit) {
                    $nfpb->icmscst = 20;
                    $nfpb->icmsbasepercentual = 41.17;
                    $nfpb->icmsbase = round($baseCalculada * ((float)$nfpb->icmsbasepercentual / 100), 2);
                } elseif ($baseCalculada == 0) {
                    $nfpb->icmsbasepercentual = 100;
                    $nfpb->icmsbase = round($baseCalculada, 2);
                } else {
                    $nfpb->icmsbasepercentual = round(((float)$nti->vbc / $baseCalculada) * 100, 2);
                    $nfpb->icmsbase = round($baseCalculada, 2);
                }

                // Aliquota Maxima de 7% para Interestadual
                if ($this->Pessoa->Cidade->codestado != $this->Filial->Pessoa->Cidade->codestado) {
                    $nfpb->icmspercentual = min([(float)$nti->picms, 7]);
                } else {
                    $nfpb->icmspercentual = (float) $nti->picms;
                }

                // se não tem reducao, e percentual igual da nota, usa valor calculado pelo emitente
                if ($nfpb->icmsbasepercentual == 100 && $nfpb->icmspercentual == $nti->picms) {
                    $nfpb->icmsvalor = (float) $nti->vicms;
                } else {
                    $nfpb->icmsvalor = round($nfpb->icmsbase * ($nfpb->icmspercentual / 100), 2);
                }
            }
            $nfpb->ipibase = $nti->ipivbc;
            $nfpb->ipipercentual = $nti->ipipipi;
            $nfpb->ipivalor = $nti->ipivipi;
            $nfpb->icmsstbase = $nti->vbcst;
            $nfpb->icmsstpercentual = $nti->picmsst;
            $nfpb->icmsstvalor = $nti->vicmsst;
            $nfpb->codnegocioprodutobarra = $npb->codnegocioprodutobarra;

            $nfpb->valordesconto = $nti->vdesc + $descontoRateado;
            $nfpb->valorfrete = $nti->vfrete;
            $nfpb->valorseguro = $nti->vseg;
            $nfpb->valoroutras = $nti->voutro + $outrasRateado;

            if (!$nfpb->save()) {
                $this->addErrors($nfpb->getErrors());
                $transaction->rollBack();
                return false;
            }
        }

        $n = Negocio::model()->findByPk($n->codnegocio);
        $n->codnegociostatus = NegocioStatus::FECHADO;
        if (!$n->save()) {
            $this->addErrors($n->getErrors());
            $transaction->rollBack();
            return false;
        }

        $this->codnotafiscal = $nf->codnotafiscal;
        $this->codnegocio = $n->codnegocio;

        if (!$this->save()) {
            $transaction->rollBack();
            return false;
        }

        $transaction->commit();

        //Força novamente movimentação de estoque
        //Em alguns casos o MGLara estava rodando antes do MGsis
        //completar a transação, e assim não gerava movimentação do estoque
        $n->movimentaEstoque();
        return true;
    }

    public function totalComplemento()
    {
        $command = Yii::app()->db->createCommand('
			SELECT sum(complemento) AS complemento
				FROM tblnfeterceiroitem
			 WHERE codnfeterceiro = :codnfeterceiro
		');
        $command->params = [
            "codnfeterceiro" => $this->codnfeterceiro,
        ];
        $ret = $command->queryRow();
        return $ret['complemento'];
    }
}

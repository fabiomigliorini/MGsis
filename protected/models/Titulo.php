<?php

/**
 * This is the model class for table "mgsis.tbltitulo".
 *
 * The followings are the available columns in table 'mgsis.tbltitulo':
 * @property string $codtitulo
 * @property string $codtipotitulo
 * @property string $codfilial
 * @property string $codportador
 * @property string $codpessoa
 * @property string $codcontacontabil
 * @property string $numero
 * @property string $fatura
 * @property string $transacao
 * @property string $sistema
 * @property string $emissao
 * @property string $vencimento
 * @property string $vencimentooriginal
 * @property string $debito
 * @property string $credito
 * @property boolean $gerencial
 * @property string $observacao
 * @property boolean $boleto
 * @property string $nossonumero
 * @property string $debitototal
 * @property string $creditototal
 * @property string $saldo
 * @property string $debitosaldo
 * @property string $creditosaldo
 * @property string $transacaoliquidacao
 * @property string $codnegocioformapagamento
 * @property string $codtituloagrupamento
 * @property string $remessa
 * @property string $estornado
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property MovimentoTitulo[] $MovimentoTitulos
 * @property MovimentoTitulo[] $MovimentoTitulosRelacionados
 * @property ContaContabil $ContaContabil
 * @property Filial $Filial
 * @property NegocioFormaPagamento $NegocioFormaPagamento
 * @property Pessoa $Pessoa
 * @property Portador $Portador
 * @property TipoTitulo $TipoTitulo
 * @property TituloAgrupamento $TituloAgrupamento
 * @property Usuario $UsuarioAlteracao
 * @property Usuario $UsuarioCriacao
 * @property BoletoRetorno[] $BoletoRetornos
 * @property Cobranca[] $Cobrancas
 * @property CobrancaHistoricoTitulo[] $CobrancaHistoricoTitulos
 */
class Titulo extends MGActiveRecord
{

    public $vencimento_de;
    public $vencimento_ate;
    public $emissao_de;
    public $emissao_ate;
    public $criacao_de;
    public $criacao_ate;
    public $liquidacao_de;
    public $liquidacao_ate;
    public $debito_de;
    public $debito_ate;
    public $credito_de;
    public $credito_ate;
    public $saldo_de;
    public $saldo_ate;
    public $codgrupocliente;
    public $codgrupoeconomico;
    public $pagarreceber;
    public $status;
    public $Juros;
    public $operacao;
    public $valor;
    public $gerado_automaticamente;
    public $ordem;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'mgsis.tbltitulo';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('codtipotitulo, valor, codfilial, codpessoa, codcontacontabil, transacao, emissao, vencimento, vencimentooriginal', 'required'),
            array('valor', 'validaPodeAlterarValor'),
            array('codtipotitulo', 'validaPodeAlterarTipoTitulo'),
            array('boleto', 'validaBoleto'),
            array('codportador', 'validaFilialPortador'),
            array('transacao', 'validaDataTransacao'),
            array('numero', 'validaNumero'),
            array('numero, nossonumero', 'length', 'max' => 20),
            array('fatura', 'length', 'max' => 50),
            array('debito, credito, debitototal, creditototal, saldo, debitosaldo, creditosaldo', 'length', 'max' => 14),
            array('vencimento', 'date', 'format' => Yii::app()->locale->getDateFormat('medium')),
            array('vencimentooriginal', 'date', 'format' => Yii::app()->locale->getDateFormat('medium')),
            array('transacao', 'date', 'format' => Yii::app()->locale->getDateFormat('medium')),
            array('emissao', 'date', 'format' => Yii::app()->locale->getDateFormat('medium')),
            array('observacao', 'length', 'max' => 255),
            array('codportador, gerencial, boleto, transacaoliquidacao, codnegocioformapagamento, codtituloagrupamento, remessa, estornado, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            //array('sistema','datetime'),
            array('sistema', 'date', 'format' => strtr(Yii::app()->locale->getDateTimeFormat(), array("{0}" => Yii::app()->locale->getTimeFormat('medium'), "{1}" => Yii::app()->locale->getDateFormat('medium')))),
            array('codtitulo, vencimento_de, vencimento_ate, emissao_de, emissao_ate, criacao_de, criacao_ate, liquidacao_de, liquidacao_ate, codtipotitulo, codfilial, codportador, codpessoa, codcontacontabil, numero, emissao, vencimento, credito, gerencial, boleto, nossonumero, saldo, criacao, codusuariocriacao, debito_de, debito_ate, credito_de, credito_ate, saldo_de, saldo_ate, codgrupocliente, codgrupoeconomico, pagarreceber, status, ordem', 'safe', 'on' => 'search'),
        );
    }

    public function validaPodeAlterarValor($attribute, $params)
    {
        if (!$this->isNewRecord) {
            $old = self::findByPk($this->codtitulo);
            if (
                $old->saldo == 0
                && $old->credito != $this->credito
                && $old->debito != $this->debito
            ) {
                if ($old->valor <> $this->valor)
                    $this->addError($attribute, 'Impossível alterar o valor de um título baixado ou estornado!');
            }
        }
    }

    public function validaPodeAlterarTipoTitulo($attribute, $params)
    {
        if (!$this->isNewRecord) {
            $old = self::findByPk($this->codtitulo);
            if ($this->codtipotitulo <> $old->codtipotitulo and !empty($this->codtipotitulo)) {
                if (($this->TipoTitulo->debito <> $old->TipoTitulo->debito) || ($this->TipoTitulo->credito <> $old->TipoTitulo->credito)) {
                    $this->addError($attribute, 'Impossível alterar o tipo de título de DB para CR, e vice-versa!');
                }
            }
        }
    }

    public function validaFilialPortador($attribute, $params)
    {
        if (!empty($this->codfilial))
            if (!empty($this->codportador))
                if (($this->codfilial <> $this->Portador->codfilial) && !empty($this->Portador->codfilial))
                    $this->addError($attribute, "Este portador só é válido para a filial {$this->Portador->Filial->filial}!");
    }

    public function validaBoleto($attribute, $params)
    {
        if (!$this->boleto) {
            return;
        }

        if (empty($this->codportador)) {
            $this->addError($attribute, "Selecione um portador!");
            return;
        }

        if ($this->Portador->codbanco != 237) {
            return;
        }

        if (!$this->Portador->emiteboleto) {
            $this->addError($attribute, "O portador selecionado não permite boletos!");
        }
    }

    public function validaNumero($attribute, $params)
    {
        //se nao tem numero
        if (empty($this->numero))
            return;

        //se nao tem tipo
        if (empty($this->codtipotitulo))
            return;

        //se nao alterou numero
        if (!$this->isNewRecord) {
            $old = Titulo::model()->findByPk($this->codtitulo);
            if ($old->numero == $this->numero)
                return;
        }

        $outro = false;
        //if ($this->TipoTitulo->pagar)
        //{
        $outro = Titulo::model()->find(
            array(
                'select' => 'codtitulo',
                'condition' => 'codpessoa = :codpessoa AND numero = :numero AND codtitulo <> :codtitulo',
                'params' => array(':codpessoa' => $this->codpessoa, ':numero' => $this->numero, ':codtitulo' => (empty($this->codtitulo) ? -1 : $this->codtitulo))
            )
        );

        //}
        //elseif ($this->TipoTitulo->receber)
        //{
        //$outro = Titulo::model()->find(
        //array(
        //'select'=>'codtitulo',
        //'condition'=>'codfilial = :codfilial AND numero = :numero AND codtitulo <> :codtitulo',
        //'params'=>array(':codfilial'=>$this->codfilial, ':numero'=>$this->numero, ':codtitulo' => (empty($this->codtitulo)?-1:$this->codtitulo))
        //)
        //);
        //}

        if ($outro) {
            $this->addError($attribute, "Numero {$this->numero} já utilizado no título " . CHtml::link(CHtml::encode(Yii::app()->format->formataCodigo($outro->codtitulo)), array('view', 'id' => $outro->codtitulo)) . "!");
        }
    }

    public function validaDataTransacao($attribute, $params)
    {
        if (!$this->isNewRecord)
            return;

        $pg = ParametrosGerais::model()->findByPK(1);

        if ($pg === null)
            return;

        if ($pg->validaDataTransacao($this->transacao))
            return;

        $this->addError($attribute, "Data de transação inválida, deve ser entre '{$pg->transacaoinicial}' e '{$pg->transacaofinal}'!");
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'MovimentoTitulos' => array(self::HAS_MANY, 'MovimentoTitulo', 'codtitulo', 'order' => 'criacao ASC, sistema ASC, codmovimentotitulo ASC'),
            'MovimentoTitulosRelacionados' => array(self::HAS_MANY, 'MovimentoTitulo', 'codtitulorelacionado'),
            'TituloNfeTerceiros' => array(self::HAS_MANY, 'TituloNfeTerceiro', 'codtitulo'),
            'ContaContabil' => array(self::BELONGS_TO, 'ContaContabil', 'codcontacontabil'),
            'Filial' => array(self::BELONGS_TO, 'Filial', 'codfilial'),
            'NegocioFormaPagamento' => array(self::BELONGS_TO, 'NegocioFormaPagamento', 'codnegocioformapagamento'),
            'Pessoa' => array(self::BELONGS_TO, 'Pessoa', 'codpessoa'),
            'Portador' => array(self::BELONGS_TO, 'Portador', 'codportador'),
            'TipoTitulo' => array(self::BELONGS_TO, 'TipoTitulo', 'codtipotitulo'),
            'TituloAgrupamento' => array(self::BELONGS_TO, 'TituloAgrupamento', 'codtituloagrupamento'),
            'UsuarioAlteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
            'UsuarioCriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
            'BoletoRetornos' => array(self::HAS_MANY, 'BoletoRetorno', 'codtitulo', 'order' => 'criacao asc, codboletoretorno ASC'),
            'Cobrancas' => array(self::HAS_MANY, 'Cobranca', 'codtitulo'),
            'CobrancaHistoricoTitulos' => array(self::HAS_MANY, 'CobrancaHistoricoTitulo', 'codtitulo'),
            'TituloBoletos' => array(self::HAS_MANY, 'TituloBoleto', 'codtitulo', 'order' => 'criacao DESC'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'codtitulo' => '#',
            'codtipotitulo' => 'Tipo Título',
            'codfilial' => 'Filial',
            'codportador' => 'Portador',
            'codgrupoeconomico' => 'Grupo Econ.',
            'codpessoa' => 'Pessoa',
            'codcontacontabil' => 'Conta Contabil',
            'numero' => 'Número',
            'fatura' => 'Fatura',
            'transacao' => 'Transação',
            'sistema' => 'Sistema',
            'emissao' => 'Emissão',
            'vencimento' => 'Vencimento',
            'vencimento_de' => 'De',
            'vencimento_ate' => 'Até',
            'vencimentooriginal' => 'Vencimento Original',
            'valor' => 'Valor',
            'debito' => 'Débito',
            'credito' => 'Crédito',
            'gerencial' => 'Gerencial',
            'observacao' => 'Observação',
            'boleto' => 'Boleto',
            'nossonumero' => 'Nosso Número',
            'debitototal' => 'Débito Total',
            'creditototal' => 'Crédito Total',
            'saldo' => 'Saldo',
            'debitosaldo' => 'Saldo Débito',
            'creditosaldo' => 'Saldo Crédito',
            'transacaoliquidacao' => 'Liquidação',
            'codnegocioformapagamento' => 'Negócio Forma Pagamento',
            'codtituloagrupamento' => 'Título Agrupamento',
            'remessa' => 'Remessa',
            'estornado' => 'Estorno',
            'alteracao' => 'Alteração',
            'codusuarioalteracao' => 'Usuário Alteração',
            'criacao' => 'Criação',
            'codusuariocriacao' => 'Usuário Criação',
            'debito_de' => 'Débito de',
            'debito_ate' => 'Débito até',
            'credito_de' => 'Crédito de',
            'credito_ate' => 'Crédito até',
            'saldo_de' => 'Saldo de',
            'saldo_ate' => 'Saldo de',
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
    public function search($comoDataProvider = true, $limit = null, $order = '"Pessoa".fantasia ASC, t.vencimento ASC, t.saldo ASC')
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('t.codtitulo', Yii::app()->format->numeroLimpo($this->codtitulo), false);
        $criteria->compare('t.codfilial', $this->codfilial, false);
        $criteria->compare('t.codpessoa', $this->codpessoa, false);
        if (!empty($this->numero)) {
            $texto  = str_replace(' ', '%', trim($this->numero));
            $criteria->addCondition('t.numero ILIKE :numero');
            $criteria->params = array_merge($criteria->params, array(':numero' => '%' . $texto . '%'));
        }
        if ($vencimento_de = DateTime::createFromFormat("d/m/y", $this->vencimento_de)) {
            $criteria->addCondition('t.vencimento >= :vencimento_de');
            $criteria->params = array_merge($criteria->params, array(':vencimento_de' => $vencimento_de->format('Y-m-d') . ' 00:00:00.0'));
        }
        if ($vencimento_ate = DateTime::createFromFormat("d/m/y", $this->vencimento_ate)) {
            $criteria->addCondition('t.vencimento <= :vencimento_ate');
            $criteria->params = array_merge($criteria->params, array(':vencimento_ate' => $vencimento_ate->format('Y-m-d') . ' 23:59:59.9'));
        }
        if ($emissao_de = DateTime::createFromFormat("d/m/y", $this->emissao_de)) {
            $criteria->addCondition('t.emissao >= :emissao_de');
            $criteria->params = array_merge($criteria->params, array(':emissao_de' => $emissao_de->format('Y-m-d') . ' 00:00:00.0'));
        }
        if ($emissao_ate = DateTime::createFromFormat("d/m/y", $this->emissao_ate)) {
            $criteria->addCondition('t.emissao <= :emissao_ate');
            $criteria->params = array_merge($criteria->params, array(':emissao_ate' => $emissao_ate->format('Y-m-d') . ' 23:59:59.9'));
        }
        if ($this->debito_de) {
            $criteria->addCondition('t.debito >= :debito_de');
            $criteria->params['debito_de'] = Yii::app()->format->unformatNumber($this->debito_de);
        }
        if ($this->debito_ate) {
            $criteria->addCondition('t.debito <= :debito_ate');
            $criteria->params['debito_ate'] = Yii::app()->format->unformatNumber($this->debito_ate);
        }
        if ($this->credito_de) {
            $criteria->addCondition('t.credito >= :credito_de');
            $criteria->params['credito_de'] = Yii::app()->format->unformatNumber($this->credito_de);
        }
        if ($this->credito_ate) {
            $criteria->addCondition('t.credito <= :credito_ate');
            $criteria->params['credito_ate'] = Yii::app()->format->unformatNumber($this->credito_ate);
        }
        if ($this->saldo_de) {
            $criteria->addCondition('abs(t.saldo) >= :saldo_de');
            $criteria->params['saldo_de'] = Yii::app()->format->unformatNumber($this->saldo_de);
        }
        if ($this->saldo_ate) {
            $criteria->addCondition('abs(t.saldo) <= :saldo_ate');
            $criteria->params['saldo_ate'] = Yii::app()->format->unformatNumber($this->saldo_ate);
        }
        if ($criacao_de = DateTime::createFromFormat("d/m/y", $this->criacao_de)) {
            $criteria->addCondition('t.criacao >= :criacao_de');
            $criteria->params = array_merge($criteria->params, array(':criacao_de' => $criacao_de->format('Y-m-d') . ' 00:00:00.0'));
        }
        if ($criacao_ate = DateTime::createFromFormat("d/m/y", $this->criacao_ate)) {
            $criteria->addCondition('t.criacao <= :criacao_ate');
            $criteria->params = array_merge($criteria->params, array(':criacao_ate' => $criacao_ate->format('Y-m-d') . ' 23:59:59.9'));
        }
        if ($liquidacao_de = DateTime::createFromFormat("d/m/y", $this->liquidacao_de)) {
            $criteria->addCondition('t.transacaoliquidacao >= :liquidacao_de');
            $criteria->params = array_merge($criteria->params, array(':liquidacao_de' => $liquidacao_de->format('Y-m-d') . ' 00:00:00.0'));
        }
        if ($liquidacao_ate = DateTime::createFromFormat("d/m/y", $this->liquidacao_ate)) {
            $criteria->addCondition('t.transacaoliquidacao <= :liquidacao_ate');
            $criteria->params = array_merge($criteria->params, array(':liquidacao_ate' => $liquidacao_ate->format('Y-m-d') . ' 23:59:59.9'));
        }


        switch ($this->status) {
            case 'A':
                $criteria->addCondition('t.saldo <> 0');
                break;
            case 'L':
                $criteria->addCondition('t.saldo = 0 and t.estornado is null');
                break;
            case 'AL':
                $criteria->addCondition('t.estornado is null');
                break;
            case 'E':
                $criteria->addCondition('t.estornado is not null');
                break;
            case 'LE':
                $criteria->addCondition('t.saldo = 0');
                break;
            case 'T':
                break;

            default:
                // die($this->status);
                break;
        }

        switch ($this->credito) {
            case 2:
                $criteria->addCondition('t.debito > 0');
                break;
            case 1:
                $criteria->addCondition('t.credito > 0');
                break;
        }

        /*
        01 - NORMAL
        02 - MOVIMENTO CARTORIO
        03 - EM CARTORIO
        04 - TITULO COM OCORRENCIA DE CARTORIO
        05 - PROTESTADO ELETRONICO
        06 - LIQUIDADO
        07 - BAIXADO
        08 - TITULO COM PENDENCIA DE CARTORIO
        09 - TITULO PROTESTADO MANUAL
        10 - TITULO BAIXADO/PAGO EM CARTORIO
        11 - TITULO LIQUIDADO/PROTESTADO
        12 - TITULO LIQUID/PGCRTO
        13 - TITULO PROTESTADO AGUARDANDO BAIXA
        14 - TITULO EM LIQUIDACAO
        15 - TITULO AGENDADO
        16 - TITULO CREDITADO
        17 - PAGO EM CHEQUE - AGUARD.LIQUIDACAO
        18 - PAGO PARCIALMENTE CREDITADO
        80 - EM PROCESSAMENTO (ESTADO TRANSITÓRIO)
        */

        switch ($this->boleto) {
            case 'B':
                $criteria->addCondition('t.boleto = true');
                break;
            case 'BA':
                $criteria->addCondition('exists (select codtituloboleto from tbltituloboleto tb where t.codtitulo = tb.codtitulo and estadotitulocobranca not in (6, 7))');
                break;
            case 'BL':
                $criteria->addCondition('
                    exists (
                        select codtituloboleto
                        from tbltituloboleto tb
                        where t.codtitulo = tb.codtitulo
                        and estadotitulocobranca in (6, 7)
                    )
                    and not exists (
                        select codtituloboleto
                        from tbltituloboleto tb
                        where t.codtitulo = tb.codtitulo
                        and estadotitulocobranca not in (6, 7)
                    )
                ');
                break;
            case 'SB':
                $criteria->addCondition('t.boleto = false');
                break;

                //

        }

        if (!empty($this->nossonumero)) {
            $texto  = str_replace(' ', '%', trim($this->nossonumero));
            $criteria->addCondition('t.nossonumero ILIKE :nossonumero');
            $criteria->params = array_merge($criteria->params, array(':nossonumero' => '%' . $texto . '%'));
        }

        // $criteria->compare('t.codportador', $this->codportador, false);
        if ($this->codportador) {
            $criteria->addInCondition('coalesce(t.codportador, -1)', $this->codportador);
        }
        $criteria->compare('t.codcontacontabil', $this->codcontacontabil, false);
        $criteria->compare('t.codtipotitulo', $this->codtipotitulo, false);

        switch ($this->gerencial) {
            case 2:
                $criteria->addCondition('t.gerencial = false');
                break;
            case 1:
                $criteria->addCondition('t.gerencial = true');
                break;
        }
        $criteria->compare('t.codusuariocriacao', $this->codusuariocriacao, false);

        $criteria->with = array(
            'Pessoa' => array('select' => '"Pessoa".fantasia'),
            'Filial' => array('select' => '"Filial".filial'),
            'Portador' => array('select' => '"Portador".portador'),
            'UsuarioCriacao' => array('select' => '"UsuarioCriacao".usuario'),
            'UsuarioAlteracao' => array('select' => '"UsuarioAlteracao".usuario'),
            'ContaContabil' => array('select' => '"ContaContabil".contacontabil'),
            'TipoTitulo' => array('select' => '"TipoTitulo".tipotitulo'),
        );

        if ($this->codgrupocliente) {
            $criteria->addInCondition('coalesce("Pessoa".codgrupocliente, -1)', $this->codgrupocliente);
        }
        $criteria->compare('"Pessoa".codgrupoeconomico', $this->codgrupoeconomico, false);

        if ($this->pagarreceber == 'R') {
            $criteria->compare('"TipoTitulo".receber', true, false);
        } elseif ($this->pagarreceber == 'P') {
            $criteria->compare('"TipoTitulo".pagar', true, false);
        }

        $criteria->select = 't.codtitulo, t.vencimento, t.emissao, t.codfilial, t.numero, t.fatura, t.codportador, t.credito, t.debito, t.saldo, t.codtipotitulo, t.codcontacontabil, t.codusuariocriacao, t.nossonumero, t.gerencial, t.codpessoa, t.codusuarioalteracao, t.estornado, t.boleto, t.observacao';

        switch ($this->ordem) {
            case 'AE': // 'Alfabética, Emissão'
                $criteria->order = '"Pessoa".fantasia ASC, t.emissao ASC, t.fatura, t.numero, t.saldo ASC';
                break;
            case 'CV': // 'Código da Pessoa, Vencimento',
                $criteria->order = '"Pessoa".codpessoa ASC, t.vencimento ASC, t.saldo ASC';
                break;
            case 'CE': // 'Código da Pessoa, Emissão',
                $criteria->order = '"Pessoa".codpessoa ASC, t.emissao ASC, t.fatura, t.numero, t.saldo ASC';
                break;
            case 'AV': // 'Alfabética, Vencimento'
            default:
                $criteria->order = '"Pessoa".fantasia ASC, t.vencimento ASC, t.saldo ASC';
                break;
        }

        if (!empty($limit)) {
            $criteria->limit = $limit;
        }

        if ($comoDataProvider) {
            $params = array(
                'criteria' => $criteria,
            );
            return new CActiveDataProvider($this, $params);
        } else {
            return $this->findAll($criteria);
        }
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Titulo the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    protected function afterFind()
    {
        $ret = parent::afterFind();
        $this->Juros = new MGJuros(array("de" => $this->vencimento,    "valorOriginal" => $this->saldo));
        $this->operacao = ($this->saldo < 0 || $this->credito > $this->debito) ? "CR" : "DB";
        $this->valor = abs($this->debito - $this->credito);

        if (!empty($this->codnegocioformapagamento) || !empty($this->codtituloagrupamento))
            $this->gerado_automaticamente = true;
        else
            $this->gerado_automaticamente = false;

        return $ret;
    }

    public function adicionaMultaJurosDesconto(
        $multa = 0,
        $juros = 0,
        $desconto = 0,
        $transacao = null,
        $codportador = null,
        $codtituloagrupamento = null,
        $codliquidacaotitulo = null,
        $codboletoretorno = null,
        $codcobranca = null,
        $codtitulorelacionado = null,
        $historico = null
    ) {

        $ret = true;

        if ($ret && ($juros > 0)) {
            $ret = $this->adicionaMovimento(
                TipoMovimentoTitulo::TIPO_JUROS,
                ($this->operacao == "DB") ? $juros : null,
                ($this->operacao == "CR") ? $juros : null,
                $transacao,
                $codportador,
                $codtituloagrupamento,
                $codliquidacaotitulo,
                $codboletoretorno,
                $codcobranca,
                $codtitulorelacionado,
                $historico
            );
        }

        if ($ret && ($multa > 0)) {
            $ret = $this->adicionaMovimento(
                TipoMovimentoTitulo::TIPO_MULTA,
                ($this->operacao == "DB") ? $multa : null,
                ($this->operacao == "CR") ? $multa : null,
                $transacao,
                $codportador,
                $codtituloagrupamento,
                $codliquidacaotitulo,
                $codboletoretorno,
                $codcobranca,
                $codtitulorelacionado,
                $historico
            );
        }

        if ($ret && ($desconto > 0)) {
            $ret = $this->adicionaMovimento(
                TipoMovimentoTitulo::TIPO_DESCONTO,
                ($this->operacao == "CR") ? $desconto : null,
                ($this->operacao == "DB") ? $desconto : null,
                $transacao,
                $codportador,
                $codtituloagrupamento,
                $codliquidacaotitulo,
                $codboletoretorno,
                $codcobranca,
                $codtitulorelacionado,
                $historico
            );
        }

        return $ret;
    }

    public function adicionaMovimento(
        $codtipomovimentotitulo,
        $debito = null,
        $credito = null,
        $transacao = null,
        $codportador = null,
        $codtituloagrupamento = null,
        $codliquidacaotitulo = null,
        $codboletoretorno = null,
        $codcobranca = null,
        $codtitulorelacionado = null,
        $historico = null
    ) {

        //inicializa transacao
        $trans = $this->dbConnection->beginTransaction();

        // preenche data de transacao
        if ($transacao == null)
            $transacao = date('d/m/Y');

        //instancia
        $mov = new MovimentoTitulo('insert');

        //passa parametros
        $mov->codtitulo              = $this->codtitulo;
        $mov->codtipomovimentotitulo = $codtipomovimentotitulo;
        $mov->debito                 = $debito;
        $mov->credito                = $credito;
        $mov->transacao              = $transacao;
        $mov->codtituloagrupamento   = $codtituloagrupamento;
        $mov->codliquidacaotitulo    = $codliquidacaotitulo;
        $mov->codboletoretorno       = $codboletoretorno;
        $mov->codcobranca            = $codcobranca;
        $mov->codportador            = $codportador;
        $mov->codtitulorelacionado   = $codtitulorelacionado;
        $mov->historico              = $historico;
        $mov->sistema                = date('Y-m-d H:i:s');

        //salva
        $ret = $mov->save();

        //se deu erro adiciona erro
        if ($ret) {
            $trans->commit();
        } else {
            //se deu erro
            $this->addError($this->tableSchema->primaryKey, 'Erro ao gerar movimento do título!');
            $this->addErrors($mov->getErrors());
            $trans->rollback();
        }

        //retorna
        return $ret;
    }

    protected function beforeSave()
    {
        $ret = parent::beforeSave();

        if (empty($this->sistema))
            $this->sistema = $this->criacao;

        if (empty($this->numero))
            $this->numero = $this->codtitulo;

        if ($this->TipoTitulo->credito) {
            $this->credito = Yii::app()->format->unformatNumber($this->valor);
            $this->debito = 0;
        } else {
            $this->credito = 0;
            $this->debito = Yii::app()->format->unformatNumber($this->valor);
        }

        //preenche nossonumero quando for boleto, debito
        if (!empty($this->codportador) && $this->boleto && empty($this->credito)) {
            if ($this->isNewRecord)
                $codportador_antigo = $this->codportador;
            else {
                $old = Titulo::model()->findByPk($this->codtitulo);
                $codportador_antigo = $old->codportador;
            }

            if ($this->Portador->codbanco == 237) {
                if (empty($this->nossonumero) || $this->codportador <> $codportador_antigo) {
                    $sequence = "tbltitulo_nossonumero_{$this->codportador}_seq";
                    $this->nossonumero = Yii::app()->db->createCommand("SELECT NEXTVAL('$sequence')")->queryScalar();
                }
            } elseif ($this->Portador->codbanco == 1) {
                $this->nossonumero = null;
            }
        }

        return $ret;
    }


    public function save($runValidation = true, $attributes = NULL)
    {
        //variaveis do registro novo x antigo
        $novo = $this->isNewRecord;
        if (!$novo)
            $old = Titulo::model()->findByPk($this->codtitulo);

        //comeca transacao
        $trans = $this->dbConnection->beginTransaction();

        //salva registro do titulo
        $ret = parent::save($runValidation, $attributes);

        //se salvou o titulo
        if ($ret) {
            //inicializa variaveis
            $debito = 0;
            $credito = 0;
            $data = date('d/m/Y');

            //se registro novo
            if ($novo) {
                //os valores do movimento sao iguais ao do novo registro
                $debito = $this->debito;
                $credito = $this->credito;
                $codtipomovimento = TipoMovimentoTitulo::TIPO_IMPLANTACAO;
                if ($data = DateTime::createFromFormat('Y-m-d', $this->transacao))
                    $data = $data->format('d/m/Y');
            } else {
                //senao, pega a diferenca dos valores
                if ($this->debito > $old->debito)
                    $debito = round($this->debito - $old->debito, 2);
                if ($this->debito < $old->debito)
                    $credito = round($old->debito - $this->debito, 2);
                if ($this->credito > $old->credito)
                    $credito = round($this->credito - $old->credito, 2);
                if ($this->credito < $old->credito)
                    $debito = round($old->credito - $this->credito, 2);
                $codtipomovimento = TipoMovimentoTitulo::TIPO_AJUSTE;
            }

            //se teve diferenca, um registro de movimento
            if ($debito > 0 || $credito > 0) {

                $ret = $this->adicionamovimento(
                    $codtipomovimento,
                    $debito,
                    $credito,
                    $data,
                    $this->codportador,
                    $this->codtituloagrupamento
                );
            }
        }

        //faz commit
        if ($ret)
            $trans->commit();
        else
            $trans->rollback();

        //retorna
        return $ret;
    }

    public function estorna()
    {

        if ($this->debito - $this->credito <> $this->saldo) {
            $this->addError("saldo", "Impossivel estornar um título movimentado!");
            return false;
        }

        return $this->adicionaMovimento(
            TipoMovimentoTitulo::TIPO_ESTORNO_IMPLANTACAO,
            $this->creditosaldo,
            $this->debitosaldo,
            date('d/m/Y'),
            $this->codportador,
            $this->codtituloagrupamento
        );
    }
}

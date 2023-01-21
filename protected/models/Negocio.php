<?php

/**
 * This is the model class for table "mgsis.tblnegocio".
 *
 * The followings are the available columns in table 'mgsis.tblnegocio':
 * @property string $codnegocio
 * @property string $codpessoa
 * @property string $codfilial
 * @property string $codestoquelocal
 * @property string $lancamento
 * @property string $codpessoavendedor
 * @property string $codoperacao
 * @property string $codnegociostatus
 * @property string $observacoes
 * @property string $codusuario
 * @property string $valordesconto
 * @property boolean $entrega
 * @property string $acertoentrega
 * @property string $codusuarioacertoentrega
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 * @property string $codnaturezaoperacao
 * @property string $valorprodutos
 * @property string $valortotal
 * @property string $valoraprazo
 * @property string $valoravista
 * @property string $cpf
 *
 * The followings are the available model relations:
 * @property Filial $Filial
 * @property EstoqueLocal $EstoqueLocal
 * @property NegocioStatus $NegocioStatus
 * @property Operacao $Operacao
 * @property Pessoa $Pessoa
 * @property Pessoa $PessoaVendedor
 * @property Usuario $Usuario
 * @property Usuario $UsuarioAcertoEntrega
 * @property Usuario $UsuarioAlteracao
 * @property Usuario $UsuarioCriacao
 * @property NaturezaOperacao $NaturezaOperacao
 * @property NegocioFormaPagamento[] $NegocioFormaPagamentos
 * @property NegocioProdutoBarra[] $NegocioProdutoBarras
 * @property NfeTerceiro[] $NfeTerceiros
 * @property StonePreTransacao[] $StonePreTransacaos
 */
class Negocio extends MGActiveRecord
{
    public $lancamento_de;
    public $lancamento_ate;
    public $percentualdesconto;
    public $pagamento;

    private $_codnegociostatus_original;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'mgsis.tblnegocio';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('codpessoa, codfilial, codestoquelocal, lancamento, codoperacao, codnegociostatus, codusuario, codnaturezaoperacao', 'required'),
            array('observacoes', 'length', 'max'=>500),
            array('codestoquelocal, codfilial, valordesconto, valorfrete', 'numerical'),
            array('valordesconto', 'validaDesconto'),
            array('codestoquelocal', 'validaEstoqueLocal'),
            //array('codnegociostatus', 'validaStatus'),
            array('cpf', 'ext.validators.CnpjCpfValidator'),
            array('codpessoa, codpessoatransportador, codpessoavendedor, entrega, acertoentrega, codusuarioacertoentrega, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('pagamento, lancamento_de, lancamento_ate, codnegocio, codpessoa, codfilial, codestoquelocal, lancamento, codpessoatransportador, codpessoavendedor, codoperacao, codnegociostatus, observacoes, codusuario, valorfrete, valorjuros, valordesconto, entrega, acertoentrega, codusuarioacertoentrega, alteracao, codusuarioalteracao, criacao, codusuariocriacao, codnaturezaoperacao, valorprodutos, valortotal, valoraprazo, valoravista', 'safe', 'on'=>'search'),
        );
    }

    public function validaDesconto($attribute, $params)
    {
        if ($this->valordesconto > $this->valorprodutos) {
            $this->addError($attribute, 'O valor de desconto não pode ser maior que o valor dos produtos!');
        }
    }

    public function validaEstoqueLocal($attribute, $params)
    {
        if (empty($this->codestoquelocal)) {
            return;
        }

        if (empty($this->codfilial)) {
            return;
        }

        if ($this->EstoqueLocal->codfilial != $this->codfilial) {
            $this->addError($attribute, 'O Local de Estoque não bate com a Filial selecionada!');
        }
    }

    /*
    public function validaStatus($attribute, $params)
    {
        if ($this->codnegociostatus <> 1)
            $this->addError($attribute, 'O status do negócio não permite alterações!');
    }
     *
     */

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'PixCobs' => array(self::HAS_MANY, 'PixCob', 'codnegocio', 'order'=>'criacao DESC'),
            'Filial' => array(self::BELONGS_TO, 'Filial', 'codfilial'),
            'EstoqueLocal' => array(self::BELONGS_TO, 'EstoqueLocal', 'codestoquelocal'),
            'NegocioStatus' => array(self::BELONGS_TO, 'NegocioStatus', 'codnegociostatus'),
            'Operacao' => array(self::BELONGS_TO, 'Operacao', 'codoperacao'),
            'Pessoa' => array(self::BELONGS_TO, 'Pessoa', 'codpessoa'),
            'PessoaVendedor' => array(self::BELONGS_TO, 'Pessoa', 'codpessoavendedor'),
            'PessoaTransportador' => array(self::BELONGS_TO, 'Pessoa', 'codpessoatransportador'),
            'Usuario' => array(self::BELONGS_TO, 'Usuario', 'codusuario'),
            'UsuarioAcertoEntrega' => array(self::BELONGS_TO, 'Usuario', 'codusuarioacertoentrega'),
            'UsuarioAlteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
            'UsuarioCriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
            'NaturezaOperacao' => array(self::BELONGS_TO, 'NaturezaOperacao', 'codnaturezaoperacao'),
            'NegocioFormaPagamentos' => array(self::HAS_MANY, 'NegocioFormaPagamento', 'codnegocio'),
            'NegocioProdutoBarras' => array(self::HAS_MANY, 'NegocioProdutoBarra', 'codnegocio', 'order'=>'alteracao DESC, codnegocioprodutobarra DESC'),
            'NfeTerceiros' => array(self::HAS_MANY, 'NfeTerceiro', 'codnegocio'),
            'StonePreTransacaos' => array(self::HAS_MANY, 'StonePreTransacao', 'codnegocio'),
            'MercosPedidos' => array(self::HAS_MANY, 'MercosPedido', 'codnegocio'),
            'PagarMePedidos' => array(self::HAS_MANY, 'PagarMePedido', 'codnegocio', 'order'=>'criacao DESC, codpagarmepedido ASC'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
          'codnegocio' => '#',
          'codpessoa' => 'Pessoa',
          'codfilial' => 'Filial',
          'codestoquelocal' => 'Local Estoque',
          'lancamento' => 'Lançamento',
          'codpessoavendedor' => 'Vendedor',
          'codpessoatransportador' => 'Transportador',
          'codoperacao' => 'Operação',
          'codnegociostatus' => 'Status',
          'observacoes' => 'Observações',
          'codusuario' => 'Usuário',
          'valordesconto' => 'Desconto',
          'valorfrete' => 'Frete',
          'valorjuros' => 'Juros',
          'percentualdesconto' => '%',
          'entrega' => 'Entrega',
          'acertoentrega' => 'Acerto Entrega',
          'codusuarioacertoentrega' => 'Usuário Acerto Entrega',
          'alteracao' => 'Alteração',
          'codusuarioalteracao' => 'Usuário Alteração',
          'criacao' => 'Criação',
          'codusuariocriacao' => 'Usuário Criação',
          'codnaturezaoperacao' => 'Natureza de Operação',
          'valorprodutos' => 'Produtos',
          'valortotal' => 'Total',
          'valoraprazo' => 'À Prazo',
          'valoravista' => 'À Vista',
          'cpf' => 'CPF',
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
    public function search($comoDataProvider = true)
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('codnegocio', $this->codnegocio, false);
        $criteria->compare('codpessoa', $this->codpessoa, false);
        $criteria->compare('codfilial', $this->codfilial, false);
        $criteria->compare('codestoquelocal', $this->codestoquelocal, false);
        $criteria->compare('lancamento', $this->lancamento, true);
        $criteria->compare('codpessoavendedor', $this->codpessoavendedor, false);
        $criteria->compare('codpessoatransportador', $this->codpessoatransportador, false);
        $criteria->compare('codoperacao', $this->codoperacao, false);
        $criteria->compare('codnegociostatus', $this->codnegociostatus, false);
        $criteria->compare('observacoes', $this->observacoes, true);
        $criteria->compare('codusuario', $this->codusuario, false);
        $criteria->compare('valordesconto', $this->valordesconto, true);
        $criteria->compare('entrega', $this->entrega);
        $criteria->compare('acertoentrega', $this->acertoentrega, true);
        $criteria->compare('codusuarioacertoentrega', $this->codusuarioacertoentrega, false);
        $criteria->compare('alteracao', $this->alteracao, true);
        $criteria->compare('codusuarioalteracao', $this->codusuarioalteracao, false);
        $criteria->compare('criacao', $this->criacao, true);
        $criteria->compare('codusuariocriacao', $this->codusuariocriacao, false);
        $criteria->compare('codnaturezaoperacao', $this->codnaturezaoperacao, false);
        $criteria->compare('valorprodutos', $this->valorprodutos, true);
        $criteria->compare('valortotal', $this->valortotal, true);
        $criteria->compare('valoraprazo', $this->valoraprazo, true);
        $criteria->compare('valoravista', $this->valoravista, true);

        if ($lancamento_de = DateTime::createFromFormat("d/m/y H:i", $this->lancamento_de)) {
            $criteria->addCondition('t.lancamento >= :lancamento_de');
            $criteria->params = array_merge($criteria->params, array(':lancamento_de' => $lancamento_de->format('Y-m-d H:i').':00.0'));
        }
        if ($lancamento_ate = DateTime::createFromFormat("d/m/y H:i", $this->lancamento_ate)) {
            $criteria->addCondition('t.lancamento <= :lancamento_ate');
            $criteria->params = array_merge($criteria->params, array(':lancamento_ate' => $lancamento_ate->format('Y-m-d H:i').':59.9'));
        }

        switch ($this->pagamento) {
            case "a":
                $criteria->addCondition('t.valoravista > 0');
                break;

            case "p":
                $criteria->addCondition('t.valoraprazo > 0');
                break;

            default:
                break;
        }


        $criteria->order = 't.codnegociostatus, t.lancamento DESC, t.codnegocio DESC';


        if ($comoDataProvider) {
            $params = array(
                'criteria'=>$criteria,
                'pagination'=>array('pageSize'=>20)
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
     * @return Negocio the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    protected function afterFind()
    {
        if ($this->valortotal >0 and $this->valordesconto>0 and $this->valorprodutos>0) {
            $this->percentualdesconto = 100 * ($this->valordesconto / $this->valorprodutos);
        } else {
            $this->percentualdesconto = 0;
        }

        $this->_codnegociostatus_original = $this->codnegociostatus;

        return parent::afterFind();
    }

    public function fecharNegocio()
    {
        $this->refresh();

        //So continua se for status ABERTO
        if ($this->codnegociostatus != NegocioStatus::ABERTO) {
            $this->addError("codnegociostatus", "O Status do Negócio não permite Fechamento!");
            return false;
        }

        if (sizeof($this->NegocioProdutoBarras) == 0) {
            $this->addError("codnegociostatus", "Não foi informado nenhum produto neste negócio!");
            return false;
        }

        if ($this->valoraprazo > 0 && $this->codoperacao == Operacao::SAIDA) {
            if (!$this->Pessoa->avaliaLimiteCredito($this->valoraprazo)) {
                $this->addError("codpessoa", "Solicite Liberação de Crédito ao Departamento Financeiro!");
                return false;
            }
        }

        if (($this->valortotal >= 1000) && (empty($this->Pessoa->cnpj)) && (empty($this->cpf)) && ($this->NaturezaOperacao->venda == true)) {
            $this->addError("cpf", "Obrigatório Identificar CPF para compras acima de R$ 1.000,00!");
            return false;
        }

        //Calcula total pagamentos à vista e à prazo
        $valorPagamentos = 0;
        $valorPagamentosPrazo = 0;
        foreach ($this->NegocioFormaPagamentos as $nfp) {
            $valorPagamentos += $nfp->valorpagamento;
            if (!$nfp->FormaPagamento->avista) {
                $valorPagamentosPrazo += $nfp->valorpagamento;
            }
        }

        //valida total pagamentos
        if (($this->valortotal - $valorPagamentos) >= 0.01) {
            $valorPagamentos = Yii::app()->format->formatNumber($valorPagamentos);
            $valorTotal = Yii::app()->format->formatNumber($this->valortotal);
            $this->addError("valortotal", "O valor dos Pagamentos ($valorPagamentos) é inferior ao Total ($valorTotal)!");
            return false;
        }

        //valida total à prazo
        if ($valorPagamentosPrazo > $this->valortotal) {
            $this->addError("valortotal", "O valor à Prazo é superior ao Total!");
            return false;
        }

        //gera títulos
        foreach ($this->NegocioFormaPagamentos as $nfp) {
            if (!$nfp->geraTitulos()) {
                $this->addErrors($nfp->getErrors());
                return false;
            }
        }

        //atualiza status
        $this->codnegociostatus = NegocioStatus::FECHADO;
        $this->codusuario = Yii::app()->user->id;
        $this->lancamento = date('d/m/Y H:i:s');
        if (!$this->save()) {
            return false;
        }

        $ret = $this->registrarBoletos();
        return $this->movimentaEstoque();
    }

    // Gera nota fiscal a partir do negocio
    public function gerarNotaFiscal($codnotafiscal = null, $modelo = NotaFiscal::MODELO_NFE, $geraDuplicatas = true)
    {
        if ($this->Pessoa->notafiscal == Pessoa::NOTAFISCAL_NUNCA && $modelo == NotaFiscal::MODELO_NFE) {
            $this->addError("codpessoa", "Pessoa marcada para <b>NUNCA EMITIR</b> NFe!");
            return false;
        }

        //se passou uma nota por parametro tenta localizar ela
        if (!empty($codnotafiscal)) {
            $nota = NotaFiscal::model()->findByPK($codnotafiscal);
        }

        //se nao localizou nenhuma nota, cria uma nova
        if (empty($nota)) {
            $nota = new NotaFiscal;
            $nota->codpessoa = $this->codpessoa;
            if (empty($nota->codpessoa)) {
                $nota->codpessoa = Pessoa::CONSUMIDOR;
            }
            $nota->cpf = $this->cpf;
            $nota->codfilial = $this->codfilial;
            $nota->codestoquelocal = $this->codestoquelocal;
            $nota->serie = 1;
            $nota->numero = 0;
            $nota->modelo = $modelo;
            $nota->codnaturezaoperacao = $this->codnaturezaoperacao;
            $nota->emitida = $this->NaturezaOperacao->emitida;
            //die(date('d/m/Y'));
            $nota->emissao = date('d/m/Y H:i:s');
            $nota->saida = date('d/m/Y H:i:s');

            $nota->observacoes = "";
            $nota->observacoes .= $this->NaturezaOperacao->mensagemprocom;

            if ($nota->modelo == NotaFiscal::MODELO_NFE && $nota->Filial->crt != Filial::CRT_SIMPLES_EXCESSO) {
                if (!empty($nota->observacoes)) {
                    $nota->observacoes .= "\n";
                }

                $nota->observacoes .= $this->NaturezaOperacao->observacoesnf;
            }

            $nota->frete = NotaFiscal::FRETE_SEM;
            if ($nota->modelo == NotaFiscal::MODELO_NFE) {
                if ($this->valorfrete > 0) {
                    $nota->frete = NotaFiscal::FRETE_EMITENTE;
                } elseif (!empty($this->codpessoatransportador)) {
                    $nota->frete = NotaFiscal::FRETE_DESTINATARIO;
                }
                $nota->codpessoatransportador = $this->codpessoatransportador;
            }
            $nota->codoperacao = $this->NaturezaOperacao->codoperacao;
        }

        //concatena obeservacoes
        $nota->observacoes = $nota->observacoes;
        if (!empty($nota->observacoes)) {
            $nota->observacoes .= "\n";
        }
        $nota->observacoes .= "Referente ao Negocio #{$this->codnegocio}";
        if (isset($this->PessoaVendedor)) {
            $nota->observacoes .= " - Vendedor: {$this->PessoaVendedor->fantasia}";
        }
        if (isset($this->Usuario)) {
            if (isset($this->Usuario->Pessoa)) {
                $nota->observacoes .= " - Caixa: {$this->Usuario->Pessoa->fantasia}";
            }
        }
        if (!empty($this->observacoes)) {
            $nota->observacoes .= " - {$this->observacoes}";
        }

        if (strlen($nota->observacoes) > 1500) {
            $nota->observacoes = substr($nota->observacoes, 0, 1500);
        }

        $primeiro = true;

        $notaReferenciada = [];

        //percorre os itens do negocio e adiciona na nota
        $percDesconto = ($this->valordesconto / $this->valorprodutos);
        $percFrete = ($this->valorfrete / $this->valorprodutos);
        $percJuros = ($this->valorjuros / $this->valorprodutos);
        $totalProduto = 0;
        $totalFrete = 0;
        $totalOutras = 0;
        $totalDesconto = 0;
        foreach ($this->NegocioProdutoBarras as $negocioItem) {
            $quantidade = $negocioItem->quantidade - $negocioItem->devolucaoTotal;

            if ($quantidade <= 0) {
                continue;
            }

            foreach ($negocioItem->NotaFiscalProdutoBarras as $notaItem) {
                if (!in_array($notaItem->NotaFiscal->codstatus, array(NotaFiscal::CODSTATUS_INUTILIZADA, NotaFiscal::CODSTATUS_CANCELADA))) {
                    continue(2); // vai para proximo item
                }
            }

            //esta aqui para so salvar a nota, caso exista algum produto por adicionar
            if ($primeiro) {
                $primeiro = false;
                //salva nota fiscal
                $nota->setScenario('geracaoAutomatica');
                if (!$nota->save()) {
                    $this->addErrors($nota->getErrors());
                    return false;
                }
            }

            $notaItem = new NotaFiscalProdutoBarra;

            $notaItem->codnotafiscal = $nota->codnotafiscal;
            $notaItem->codnegocioprodutobarra = $negocioItem->codnegocioprodutobarra;
            if (isset($negocioItem->NegocioProdutoBarraDevolucao)) {
                foreach ($negocioItem->NegocioProdutoBarraDevolucao->NotaFiscalProdutoBarras as $nfpb) {
                    if (!empty($nfpb->NotaFiscal->nfechave) &&
                        ($nfpb->NotaFiscal->codstatus == NotaFiscal::CODSTATUS_AUTORIZADA
                        ||$nfpb->NotaFiscal->codstatus == NotaFiscal::CODSTATUS_LANCADA)
                        && ($nfpb->NotaFiscal->codnaturezaoperacao == $nfpb->NegocioProdutoBarra->Negocio->codnaturezaoperacao)
                        ) {
                        $notaReferenciada[$nfpb->NotaFiscal->nfechave] = $nfpb->NotaFiscal->nfechave;

                        // Caso a nota sendo devolvida tenha sido emitida por outra filial
                        if ($nfpb->NotaFiscal->codestoquelocal != $nota->codestoquelocal) {
                            $nota->refresh();
                            $nota->codfilial = $nfpb->NotaFiscal->codfilial;
                            $nota->codestoquelocal = $nfpb->NotaFiscal->codestoquelocal;
                            $nota->emitida = true;
                            if (!$nota->save()) {
                                $this->addErrors($nota->getErrors());
                                return false;
                            }
                        }
                    }
                    $notaItem->codnotafiscalprodutobarraorigem = $nfpb->codnotafiscalprodutobarra;
                }
            }
            $notaItem->codprodutobarra = $negocioItem->codprodutobarra;
            $notaItem->quantidade = $quantidade;
            $notaItem->valorunitario = $negocioItem->valorunitario;

            if ($negocioItem->quantidade != $quantidade) {
              $notaItem->valortotal = round($quantidade * $negocioItem->valorunitario, 2);
            } else {
              $notaItem->valortotal = $negocioItem->valortotal;
            }
            $notaItem->valordesconto = round($percDesconto * $notaItem->valortotal, 2);
            $notaItem->valorfrete = round($percFrete * $notaItem->valortotal, 2);
            $notaItem->valoroutras = round($percJuros * $notaItem->valortotal, 2);

            $totalProduto += $notaItem->valortotal;
            $totalFrete += $notaItem->valorfrete;
            $totalOutras += $notaItem->valoroutras;
            $totalDesconto += $notaItem->valordesconto;

            if (!$notaItem->save()) {
                $this->addErrors($notaItem->getErrors());
                return false;
            }
        }

        // se adicionou todos os itens do negocio na nota
        if (abs(floatval($totalProduto) - floatval($this->valorprodutos)) < 0.01) {
          // se o total do frete e do desconto nao bate por causa de arredondamento
          if ($totalFrete != $this->valorfrete || $totalDesconto != $this->valordesconto) {
            $notaItem->valordesconto += $this->valordesconto - $totalDesconto;
            $notaItem->valorfrete += $this->valorfrete - $totalFrete;
            $notaItem->valoroutras += $this->valorjuros - $totalOutras;
            if (!$notaItem->save()) {
                $this->addErrors($notaItem->getErrors());
                return false;
            }
          }
        }

        foreach ($notaReferenciada as $cod => $chave) {
            $nfr = new NotaFiscalReferenciada();
            $nfr->codnotafiscal = $nota->codnotafiscal;
            $nfr->nfechave = $chave;
            if (!$nfr->save()) {
                $this->addErrors($nfr->getErrors());
                return false;
            }
        }


        if (empty($nota->codnotafiscal)) {
            $this->addError("codnotafiscal", "Não existe nenhum produto para gerar Nota neste Negócio");
            return false;
        }

        if ($geraDuplicatas) {
            foreach ($this->NegocioFormaPagamentos as $forma) {
                foreach ($forma->Titulos as $titulo) {
                    $duplicata = new NotaFiscalDuplicatas;
                    $duplicata->codnotafiscal = $nota->codnotafiscal;
                    $duplicata->fatura = $titulo->numero;
                    $duplicata->valor = $titulo->valor;
                    $duplicata->vencimento = $titulo->vencimento;
                    if (!$duplicata->save()) {
                        $this->addErrors($duplicata->getErrors());
                        return false;
                    }
                }
            }
        }

        //retorna codigo da nota gerada
        return $nota->codnotafiscal;
    }

    public function cancelar()
    {

        // verifica se ja nao foi cancelado
        if ($this->codnegociostatus == NegocioStatus::CANCELADO) {
            $this->addError("codnegociostatus", 'Negócio já está cancelado!');
            return false;
        }

        // verifica se tem nota fiscal ativa
        foreach ($this->NegocioProdutoBarras as $npb) {
            foreach ($npb->NotaFiscalProdutoBarras as $nfpb) {
                if ($nfpb->NotaFiscal->codstatus <> NotaFiscal::CODSTATUS_CANCELADA && $nfpb->NotaFiscal->codstatus <> NotaFiscal::CODSTATUS_INUTILIZADA) {
                    $this->addError("codnegociostatus", 'Negócio possui Nota Fiscal ativa!');
                    return false;
                }
            }
        }

        $transaction = Yii::app()->db->beginTransaction();

        try {
            foreach ($this->NegocioFormaPagamentos as $nfp) {
                foreach ($nfp->Titulos as $tit) {
                    if (!empty($tit->estornado)) {
                        continue;
                    }

                    if (!$tit->estorna()) {
                        $this->addError("codnegociostatus", "Erro ao estornar Titulos!");
                        $this->addErrors($tit->getErrors());
                        $transaction->rollBack();
                        return false;
                    }
                }
            }

            $this->codnegociostatus = NegocioStatus::CANCELADO;
            if ($this->save()) {
                $transaction->commit();
                $this->movimentaEstoque();
                return true;
            } else {
                $transaction->rollBack();
                return false;
            }
        } catch (Exception $e) {
            $transaction->rollBack();
            return false;
        }
    }

    public function gerarDevolucao($arrQuantidadeDevolucao)
    {

	//inicia Transacao
        $trans = $this->dbConnection->beginTransaction();

        //monta array com itens devolvidos
        $arr = array();
        foreach ($arrQuantidadeDevolucao as $codnegocioprodutobarra => $quantidadedevolucao) {
            $quantidadedevolucao = Yii::app()->format->unformatNumber($quantidadedevolucao);
            if ($quantidadedevolucao > 0) {
                $arr[$codnegocioprodutobarra] = $quantidadedevolucao;
            }
        }

        //se nao tem nenhum item para devolver, retorna erro
        if (empty($arr)) {
            $this->addError('codnegocio', 'Não foi selecionado nenhum item para devolução!');
            $trans->rollback();
            return false;
        }

        //cria registro tabela Negocio
        $negocio = new Negocio;
        $negocio->codpessoa = $this->codpessoa;
        $negocio->codfilial = $this->codfilial;
        $negocio->codestoquelocal = $this->codestoquelocal;
        $negocio->lancamento = date('d/m/Y H:i:s');
        $negocio->codpessoavendedor = $this->codpessoavendedor;
        $negocio->codnaturezaoperacao = $this->NaturezaOperacao->codnaturezaoperacaodevolucao;
        if (!isset($negocio->NaturezaOperacao)) {
            $this->addError('codnegocio', 'Natureza de Operação de devolução não parametrizada!');
            $trans->rollback();
            return false;
        }

        $negocio->codoperacao = $negocio->NaturezaOperacao->codoperacao;
        $negocio->codnegociostatus = NegocioStatus::ABERTO;
        //$negocio->observacoes = 'Devolução referente Negócio ' . Yii::app()->format->formataCodigo($this->codnegocio);
        $negocio->codusuario = Yii::app()->user->id;

        //salva Negocio
        if (!$negocio->save()) {
            $this->addErrors($negocio->getErrors());
            $trans->rollback();
            return false;
        }

        //percorre os itens
        $gerarNotaDevolucao = false;
        $valorDesconto = 0;
        $percDesconto = ($this->valordesconto / $this->valorprodutos);

        foreach ($arr as $codnegocioprodutobarra => $quantidadedevolucao) {

            /* @var $npb_original NegocioProdutoBarra */

            //busca item a ser devolvido
            $npb_original =  NegocioProdutoBarra::model()->findByPk($codnegocioprodutobarra);
            if ($npb_original===null) {
                $this->addError('codnegocio', 'NegocioProdutoBarra Original não localizado!');
                $trans->rollback();
                return false;
            }

            //cria item na devolucao
            $npb = new NegocioProdutoBarra();
            $npb->codnegocio = $negocio->codnegocio;
            $npb->quantidade = $quantidadedevolucao;
            $npb->valorunitario = $npb_original->valorunitario;
            $npb->valortotal = round($npb->quantidade * $npb->valorunitario, 2);
            $npb->codprodutobarra = $npb_original->codprodutobarra;
            $npb->codnegocioprodutobarradevolucao = $npb_original->codnegocioprodutobarra;

            //calcula desconto proporcional
            $valorDesconto += round($percDesconto * $npb->valortotal, 2);

            //salva item
            if (!$npb->save()) {
                $this->addErrors($npb->getErrors());
                $trans->rollback();
                return false;
            }

            //Verifica quais notas fiscais referenciar na devolucao
            foreach ($npb_original->NotaFiscalProdutoBarras as $nfpb) {
                if (!in_array($nfpb->NotaFiscal->codstatus, array(NotaFiscal::CODSTATUS_CANCELADA, NotaFiscal::CODSTATUS_INUTILIZADA))) {
                    $gerarNotaDevolucao = true;
                }
            }
        }

        //recarrega modelo do negocio, para atalizar totais
        $negocio->refresh();

        $negocio->valordesconto = $valorDesconto;
        $negocio->valortotal = $negocio->valorprodutos - $negocio->valordesconto;
        $negocio->valoravista = 0;
        $negocio->valoraprazo = $negocio->valortotal;

        if (!$negocio->save()) {
            $this->addErrors($negocio->getErrors());
            $trans->rollback();
            return false;
        }

        //cria forma de pagamento
        $nfp = new NegocioFormaPagamento();
        $nfp->codnegocio = $negocio->codnegocio;
        $nfp->valorpagamento = $negocio->valoraprazo;
        $nfp->codformapagamento = NegocioFormaPagamento::CARTEIRA_A_VISTA;
        if (!$nfp->save()) {
            $this->addErrors($nfp->getErrors());
            $trans->rollback();
            return false;
        }

        //fecha a devolucao
        if (!$negocio->fecharNegocio()) {
            $this->addErrors($negocio->getErrors());
            $trans->rollback();
            return false;
        }

        //informa o usuario do sucesso
        Yii::app()->user->setFlash('success', "Gerada devolução <b>{$negocio->codnegocio}</b>!");

        if ($gerarNotaDevolucao) {
            if (!$codnotafiscal = $negocio->gerarNotaFiscal(null, NotaFiscal::MODELO_NFE, false)) {
                $this->addErrors($negocio->getErrors());
                $trans->rollback();
                return false;
            }
        }

        $trans->commit();
        return $negocio->codnegocio;
    }

    public function movimentaEstoque()
    {
        // Chama MGLara para fazer movimentacao do estoque com delay de 10 segundos
        $url = MGLARA_URL . "estoque/gera-movimento-negocio/{$this->codnegocio}?delay=10";
        $ret = json_decode(file_get_contents($url, false, stream_context_create([
                "ssl" => [
                        "verify_peer"=>false,
                        "verify_peer_name"=>false,
                ]
        ])));
        if (@$ret->response !== 'Agendado') {
            echo '<pre>';
            var_dump($ret);
            echo '<hr>';
            die('Erro ao Gerar Movimentação de Estoque');
            return false;
        }
        return true;
    }

    public function registrarBoletos()
    {
        $url = MGSPA_API_URL . "negocio/{$this->codnegocio}/boleto-bb/registrar";
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        // curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    public function valorPagamento()
    {
      if (empty($this->codnegocio)) {
        return 0;
      }
      $sql = "
        select sum(valorpagamento)
        from mgsis.tblnegocioformapagamento
        where codnegocio = {$this->codnegocio}
      ";
      return (float) Yii::app()->db->createCommand($sql)->queryScalar();
    }
}

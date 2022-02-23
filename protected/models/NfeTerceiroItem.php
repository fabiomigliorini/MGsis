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
    public $vicmsgarantido;
    public $vicmscredito;
    public $vcusto;
    public $vcustounitario;
    public $vsugestaovenda;
    public $quantidade;
    public $margemvenda;
    public $picmsvenda;
    public $picmsbasereducao;
    public $vicmsvenda;
    public $margeminversa;
    public $vmargem;
    public $vicmsstutilizado;
    public $mva;

    public $codtributacao;

    const PERCENTUAL_ICMS_GARANTIDO = 17;

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
            array('modalidadeicmsgarantido', 'boolean'),
            array('nitem, cfop, orig, modbc, modbcst, ipicst, piscst, cofinscst', 'numerical', 'integerOnly'=>true),
            array('cprod, cean, ceantrib', 'length', 'max'=>30),
            array('xprod', 'length', 'max'=>200),
            array('ncm, ucom, utrib, cst, csosn, cest', 'length', 'max'=>10),
            array('vuncom, vuntrib', 'length', 'max'=>25),
            array('qcom, vuncom, vprod, qtrib, vuntrib, vbc, picms, vicms, vbcst, picmsst, vicmsst, ipivbc, ipipipi, ipivipi, complemento, vdesc, vfrete, vseg, voutro', 'length', 'max'=>14),
            array('margem', 'length', 'max'=>6),
            array('infadprod', 'length', 'max'=>1000),
            array('predbc, predbcst', 'numerical', 'max'=>100),
	    array('pmvast', 'numerical', 'max'=>1000),
            array('pisvbc, pisvpis, cofinsvbc, cofinsvcofins', 'length', 'max'=>15),
            array('pisppis, cofinspcofins', 'length', 'max'=>7),
            array('codprodutobarra, alteracao, codusuarioalteracao, criacao, codusuariocriacao, modalidadeicmsgarantido, compoetotal', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('codnfeterceiroitem, codnfeterceiro, nitem, cprod, xprod, cean, ncm, cfop, ucom, qcom, vuncom, vprod, ceantrib, utrib, qtrib, vuntrib, cst, csosn, vbc, picms, vicms, vbcst, picmsst, vicmsst, ipivbc, ipipipi, ipivipi, codprodutobarra, margem, complemento, alteracao, codusuarioalteracao, criacao, codusuariocriacao, vdesc, infadprod, modalidadeicmsgarantido, cest, vfrete, vseg, voutro, orig, modbc, predbc, modbcst, predbcst, pmvast, ipicst, piscst, pisvbc, pisppis, pisvpis, cofinscst, cofinsvbc, cofinspcofins, cofinsvcofins, compoetotal', 'safe', 'on'=>'search'),
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
            'Tributacao' => array(self::BELONGS_TO, 'Tributacao', 'codtributacao'),
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
            'complemento' => 'Outros Custos',
            'alteracao' => 'Alteração',
            'codusuarioalteracao' => 'Usuário Alteração',
            'criacao' => 'Criação',
            'codusuariocriacao' => 'Usuario Criação',
            'vicmsgarantido' => 'ICMS Garantido',
            'vicmscredito' => 'ICMS Credito',
            'vcusto' => 'Total',
            'vcustounitario' => 'Custo Unitário',
            'quantidade' => 'Quantidade Calculada',
            'vsugestaovenda' => 'Sugestão Venda',
            'vsugestaovendaicmsgarantido' => 'Sugestão Venda',
            'margemvenda' => 'Margem Venda',
            'picmsvenda' => '% ICMS Venda',
            'margeminversa' => 'Margem Inversa',
            'modalidadeicmsgarantido' => 'Modalidade ICMS',
            'cest' => 'Cest',
            'vfrete' => 'Vfrete',
            'vseg' => 'Vseg',
            'voutro' => 'Voutro',
            'orig' => 'Origem',
            'modbc' => 'modBC',
            'predbc' => 'Predbc',
            'modbcst' => 'modBCST',
            'predbcst' => 'pRedBCST',
            'pmvast' => 'pMVAST',
            'ipicst' => 'CST',
            'piscst' => 'CST',
            'pisvbc' => 'vBC',
            'pisppis' => 'pPIS',
            'pisvpis' => 'vPIS',
            'cofinscst' => 'CST',
            'cofinsvbc' => 'vBC',
            'cofinspcofins' => 'pCOFINS',
            'cofinsvcofins' => 'vCOFINS',
            'compoetotal' => 'Compoetotal',
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

        $criteria->compare('codnfeterceiroitem', $this->codnfeterceiroitem, true);
        $criteria->compare('codnfeterceiro', $this->codnfeterceiro, true);
        $criteria->compare('nitem', $this->nitem);
        $criteria->compare('cprod', $this->cprod, true);
        $criteria->compare('xprod', $this->xprod, true);
        $criteria->compare('cean', $this->cean, true);
        $criteria->compare('ncm', $this->ncm, true);
        $criteria->compare('cfop', $this->cfop);
        $criteria->compare('ucom', $this->ucom, true);
        $criteria->compare('qcom', $this->qcom, true);
        $criteria->compare('vuncom', $this->vuncom, true);
        $criteria->compare('vprod', $this->vprod, true);
        $criteria->compare('ceantrib', $this->ceantrib, true);
        $criteria->compare('utrib', $this->utrib, true);
        $criteria->compare('qtrib', $this->qtrib, true);
        $criteria->compare('vuntrib', $this->vuntrib, true);
        $criteria->compare('cst', $this->cst, true);
        $criteria->compare('csosn', $this->csosn, true);
        $criteria->compare('vbc', $this->vbc, true);
        $criteria->compare('picms', $this->picms, true);
        $criteria->compare('vicms', $this->vicms, true);
        $criteria->compare('vbcst', $this->vbcst, true);
        $criteria->compare('picmsst', $this->picmsst, true);
        $criteria->compare('vicmsst', $this->vicmsst, true);
        $criteria->compare('ipivbc', $this->ipivbc, true);
        $criteria->compare('ipipipi', $this->ipipipi, true);
        $criteria->compare('ipivipi', $this->ipivipi, true);
        $criteria->compare('codprodutobarra', $this->codprodutobarra, true);
        $criteria->compare('margem', $this->margem, true);
        $criteria->compare('complemento', $this->complemento, true);
        $criteria->compare('alteracao', $this->alteracao, true);
        $criteria->compare('codusuarioalteracao', $this->codusuarioalteracao, true);
        $criteria->compare('criacao', $this->criacao, true);
        $criteria->compare('codusuariocriacao', $this->codusuariocriacao, true);

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

    protected function calculaSugestaoVenda()
    {
        if ($this->margem <= 0) {
            return;
        }
        $this->calculaCustoICMSGarantido();
        $this->calculaCustoICMSApuracao();
        $this->vcusto = (double) $this->vprod
          + (double) $this->ipivipi
          + (double) $this->vicmsstutilizado
          + (double) $this->complemento
          + (double) $this->vicmsgarantido
          - (double) $this->vdesc
          + (double) $this->vfrete
          + (double) $this->vseg
          + (double) $this->voutro
          ;

        if (empty($this->vicmsstutilizado)) {
          $this->vcusto -= (double) $this->vicmscredito;
        }

        $this->vcustounitario = $this->vcusto;
        if (((int)$this->quantidade) > 0) {
            $this->vcustounitario /= $this->quantidade;
        }
        $this->margeminversa = 100 - $this->margem;
        if (empty($this->vicmsstutilizado)) {
          $this->margeminversa -= (double) $this->picmsvenda * $this->picmsbasereducao;
        }
        if ($this->margeminversa == 0) {
            return;
        }
        $this->vsugestaovenda = round($this->vcustounitario / ($this->margeminversa/100), 6);
        $this->vicmsvenda =  round($this->vsugestaovenda * (($this->picmsvenda * $this->picmsbasereducao) / 100), 6);
        $this->vmargem =  round($this->vsugestaovenda * ($this->margem / 100), 6);
    }

    protected function calculaCustoICMSGarantido()
    {
        if (in_array($this->codtributacao, [Tributacao::ISENTO, Tributacao::DIFERIDO])) {
            return;
        }
        if (!$this->modalidadeicmsgarantido) {
            return;
        }
        if (!isset($this->NfeTerceiro->Pessoa)) {
            return;
        }
        if (!isset($this->NfeTerceiro->Filial)) {
            return;
        }
        if ($this->NfeTerceiro->Filial->Pessoa->Cidade->codestado == $this->NfeTerceiro->Pessoa->Cidade->codestado) {
            return;
        }
        $this->vicmsstutilizado = $this->vicmsst;
        $base = (double) $this->vprod
          + (double) $this->ipivipi
          - (double) $this->vdesc
          + (double) $this->vfrete
          + (double) $this->vseg
          + (double) $this->voutro
          ;
        $this->vicmsgarantido = $base * (self::PERCENTUAL_ICMS_GARANTIDO/100);
        $this->vicmsgarantido -= (double) $this->vicmsstutilizado;
        if ($this->vicmsgarantido < 0) {
            $this->vicmsgarantido = 0;
        }
    }

    protected function calculaCustoICMSApuracao()
    {
        // Se for garantido, cai fora, calculo é outro
        if ($this->modalidadeicmsgarantido) {
            return;
        }

        // Se tiver produto informado, utiliza tributacao do produto
        // caso contrário, utiliza tributacao da nota de compra
        $codtributacao = $this->codtributacao;
        if (!empty($this->codprodutobarra)) {
            $codtributacao = $this->ProdutoBarra->Produto->codtributacao;
        }

        // se for isento ou diferido, não existe ICMS
        if (in_array($codtributacao, [Tributacao::ISENTO, Tributacao::DIFERIDO])) {
            return;
        }

        // verifica se é uma compra interestadual
        $interestadual = false;
        if (!empty($this->NfeTerceiro->codpessoa)) {
            if ($this->NfeTerceiro->Filial->Pessoa->Cidade->codestado != $this->NfeTerceiro->Pessoa->Cidade->codestado) {
                $interestadual = true;
            }
        }

        $this->picmsvenda = 17;
        $this->picmsbasereducao = 1.0;
        // MVA Média das vendas 2018 e 2019
        $this->mva = 57.97;

        if (!empty($this->codprodutobarra)) {
            if (!empty($this->ProdutoBarra->Produto->codcest)) {
                $this->mva = $this->ProdutoBarra->Produto->Cest->mva;
            }
            if ($this->ProdutoBarra->Produto->Ncm->bit) {
                $this->picmsbasereducao = 0.4117;
            }
        }

        // Credito ICMS, no maximo 17% para compra interestadual
        if ($interestadual) {
            $max_vicmscredito = ((double)$this->vprod - (double)$this->vdesc + (double)$this->vfrete + (double)$this->vseg + (double)$this->voutro) * 0.07 * $this->picmsbasereducao;
            $this->vicmscredito = min([$max_vicmscredito, (double) $this->vicms * $this->picmsbasereducao]);
        } else {
            $this->vicmscredito = (double) $this->vicms * $this->picmsbasereducao;
        }


        // se for ICMS ST
        if ($codtributacao == Tributacao::SUBSTITUICAO) {

            // se ST já está destacada na nota, fim de papo
            if ($this->vicmsst > 0) {
                $this->vicmsstutilizado = $this->vicmsst;
                return;
            }

            // se nao calcula st que deveria ser para quando comprado fora do estado
            if ($interestadual) {
                $base = (double) $this->vprod
                    + (double) $this->ipivipi
                    - (double) $this->vdesc
                    + (double) $this->vfrete
                    + (double) $this->vseg
                    + (double) $this->voutro
                    ;
                $base = $base * (1+($this->mva)/100) * $this->picmsbasereducao;
                // echo $base ;
                // die();
                $this->vicmsstutilizado = ($base * ($this->picmsvenda / 100)) - $this->vicmscredito;
                // $this->vicmsstutilizado = ((double)$this->vprod - (double)$this->vdesc) * 0.17;
                return;
            }
            return;
        }
    }

    protected function determinaTributacao()
    {
        if (!empty($this->cest)) {
            $this->codtributacao = Tributacao::SUBSTITUICAO;
            return;
        }
        if (!empty($this->vicmsst)) {
            $this->codtributacao = Tributacao::SUBSTITUICAO;
            return;
        }
        if (in_array($this->csosn, ['500'])) {
            $this->codtributacao = Tributacao::SUBSTITUICAO;
            return;
        }
        if (in_array($this->csosn, ['900', '400', '300'])) {
            $this->codtributacao = Tributacao::ISENTO;
            return;
        }
        if (!empty($this->csosn)) {
            $this->codtributacao = Tributacao::TRIBUTADO;
            return;
        }
        if (in_array($this->cst, ['30', '40', '41', '50', '90'])) {
            $this->codtributacao = Tributacao::ISENTO;
            return;
        }
        if (in_array($this->cst, ['51'])) {
            $this->codtributacao = Tributacao::DIFERIDO;
            return;
        }
        if (in_array($this->cst, ['10', '60', '70'])) {
            $this->codtributacao = Tributacao::SUBSTITUICAO;
            return;
        }
        $this->codtributacao = Tributacao::TRIBUTADO;
    }

    protected function afterFind()
    {
        $this->determinaTributacao();

        // Calcula Quantidade com base na embalagem vinculada ao codigo de barras
        $this->quantidade = $this->qcom;
        if (isset($this->ProdutoBarra->ProdutoEmbalagem)) {
            $this->quantidade *= $this->ProdutoBarra->ProdutoEmbalagem->quantidade;
        }

        $this->calculaSugestaoVenda();

        return parent::afterFind();
    }

    /**
     * Verifica se o registro está disponível para edição
     * @return boolean
     */
    public function podeEditar()
    {
        if (empty($this->NfeTerceiro->codnaturezaoperacao)) {
            return false;
        }

        if (empty($this->NfeTerceiro->codfilial)) {
            return false;
        }

        if (empty($this->NfeTerceiro->codpessoa)) {
            return false;
        }

        if (!$this->NfeTerceiro->podeEditar()) {
            return false;
        }

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
        $condition = 't.codprodutobarra IS NOT NULL AND t.cprod=:cprod AND "NfeTerceiro".cnpj = :cnpj';
        $params = array(
                ':cprod'=>$this->cprod,
                ':cnpj'=>$this->NfeTerceiro->cnpj,
            );
        if (!empty($this->codnfeterceiroitem)) {
            $condition .= ' AND t.codnfeterceiroitem <> :codnfeterceiroitem';
            $params[':codnfeterceiroitem'] = $this->codnfeterceiroitem;
        }

        $nti = NfeTerceiroItem::model()->find(array(
            'condition'=>$condition,
            'params'=>$params,
            'with'=>'NfeTerceiro',
            'order'=>'t.alteracao DESC',
        ));

        if ($nti != false) {
            if (empty($this->codprodutobarra)) {
                $this->codprodutobarra = $nti->codprodutobarra;
            }

            if (empty($this->margem)) {
                $this->margem = $nti->margem;
            }

            if (empty($this->complemento) && ($nti->vprod > 0)) {
                $this->complemento = round(($nti->complemento / $nti->vprod) * $this->vprod, 2);
            }

            return true;
        }

        if (!empty($this->codprodutobarra)) {
            return true;
        }

        //procura pelo codigo de barras / barras trib
        $pb = ProdutoBarra::findByBarras($this->cean);
        if ($pb == false) {
            $pb = ProdutoBarra::findByBarras($this->ceantrib);
        }

        if ($pb != false) {
            $this->codprodutobarra = $pb->codprodutobarra;
            return true;
        }
    }
}

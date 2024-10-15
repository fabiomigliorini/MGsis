<?php

/**
 * This is the model class for table "mgsis.tbltituloboleto".
 *
 * The followings are the available columns in table 'mgsis.tbltituloboleto':
 * @property string $codtituloboleto
 * @property string $codtitulo
 * @property string $codportador
 * @property string $nossonumero
 * @property string $linhadigitavel
 * @property string $barras
 * @property string $qrcodeurl
 * @property string $qrcodetxid
 * @property string $qrcodeemv
 * @property integer $canalpagamento
 * @property integer $estadotitulocobranca
 * @property string $vencimento
 * @property string $dataregistro
 * @property string $databaixaautomatica
 * @property string $valororiginal
 * @property string $valoratual
 * @property string $valorpagamentoparcial
 * @property string $valorabatimento
 * @property string $valorjuromora
 * @property string $valormulta
 * @property string $valordesconto
 * @property string $valorreajuste
 * @property string $valoroutro
 * @property string $valorpago
 * @property string $valorliquido
 * @property string $datarecebimento
 * @property string $datacredito
 * @property integer $tipobaixatitulo
 * @property string $inativo
 * @property string $criacao
 * @property string $codusuariocriacao
 * @property string $alteracao
 * @property string $codusuarioalteracao
 *
 * The followings are the available model relations:
 * @property Portador $codportador
 * @property Titulo $codtitulo
 * @property Usuario $codusuariocriacao
 * @property Usuario $codusuarioalteracao
 */
class TituloBoleto extends MGActiveRecord
{

    const TIPOBAIXA = [
        1 => 'BAIXADO POR SOLICITACAO',
        2 => 'ENTREGA FRANCO PAGAMENTO',
        9 => 'COMANDADA BANCO',
        10 => 'COMANDADA CLIENTE - ARQUIVO',
        11 => 'COMANDADA CLIENTE - ON-LINE',
        12 => 'DECURSO PRAZO - CLIENTE',
        13 => 'DECURSO PRAZO - BANCO',
        15 => 'PROTESTADO',
        31 => 'LIQUIDADO ANTERIORMENTE',
        32 => 'HABILITADO EM PROCESSO',
        35 => 'TRANSFERIDO PARA PERDAS',
        51 => 'REGISTRADO INDEVIDAMENTE',
        90 => 'BAIXA AUTOMATICA',
    ];

    const ESTADO = [
        1 => 'NORMAL',
        2 => 'MOVIMENTO CARTORIO',
        3 => 'EM CARTORIO',
        4 => 'TITULO COM OCORRENCIA DE CARTORIO',
        5 => 'PROTESTADO ELETRONICO',
        6 => 'LIQUIDADO',
        7 => 'BAIXADO',
        8 => 'TITULO COM PENDENCIA DE CARTORIO',
        9 => 'TITULO PROTESTADO MANUAL',
        10 => 'TITULO BAIXADO/PAGO EM CARTORIO',
        11 => 'TITULO LIQUIDADO/PROTESTADO',
        12 => 'TITULO LIQUID/PGCRTO',
        13 => 'TITULO PROTESTADO AGUARDANDO BAIXA',
        14 => 'TITULO EM LIQUIDACAO',
        15 => 'TITULO AGENDADO',
        16 => 'TITULO CREDITADO',
        17 => 'PAGO EM CHEQUE - AGUARD.LIQUIDACAO',
        18 => 'PAGO PARCIALMENTE',
        19 => 'PAGO PARCIALMENTE CREDITADO',
        21 => 'TITULO AGENDADO COMPE',
        80 => 'EM PROCESSAMENTO (ESTADO TRANSITÓRIO)',
    ];

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'mgsis.tbltituloboleto';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('codtitulo, codportador', 'required'),
            array('canalpagamento, estadotitulocobranca, tipobaixatitulo', 'numerical', 'integerOnly' => true),
            array('nossonumero', 'length', 'max' => 20),
            array('linhadigitavel, barras, qrcodeurl, qrcodetxid', 'length', 'max' => 100),
            array('valororiginal, valoratual, valorpagamentoparcial, valorabatimento, valorjuromora, valormulta, valordesconto, valorreajuste, valoroutro, valorpago, valorliquido', 'length', 'max' => 14),
            array('qrcodeemv, vencimento, dataregistro, databaixaautomatica, datarecebimento, datacredito, inativo, criacao, codusuariocriacao, alteracao, codusuarioalteracao', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('codtituloboleto, codtitulo, codportador, nossonumero, linhadigitavel, barras, qrcodeurl, qrcodetxid, qrcodeemv, canalpagamento, estadotitulocobranca, vencimento, dataregistro, databaixaautomatica, valororiginal, valoratual, valorpagamentoparcial, valorabatimento, valorjuromora, valormulta, valordesconto, valorreajuste, valoroutro, valorpago, valorliquido, datarecebimento, datacredito, tipobaixatitulo, inativo, criacao, codusuariocriacao, alteracao, codusuarioalteracao', 'safe', 'on' => 'search'),
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
            'Portador' => array(self::BELONGS_TO, 'Portador', 'codportador'),
            'Titulo' => array(self::BELONGS_TO, 'Titulo', 'codtitulo'),
            'UsuarioCriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
            'UsuarioAlteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'codtituloboleto' => '#',
            'codtitulo' => 'Título',
            'codportador' => 'Portador',
            'nossonumero' => 'Nosso Número (Banco)',
            'linhadigitavel' => 'Linha Digitável',
            'barras' => 'Barras',
            'qrcodeurl' => 'QRCode Url',
            'qrcodetxid' => 'QRCode txid',
            'qrcodeemv' => 'QRCode eemv',
            'canalpagamento' => 'Forma de pagamento',
            'estadotitulocobranca' => 'Estado',
            'vencimento' => 'Vencimento',
            'dataregistro' => 'Registro',
            'databaixaautomatica' => 'Baixa Automática',
            'valororiginal' => 'Valor Original',
            'valoratual' => 'Valor Atual',
            'valorpagamentoparcial' => 'Pagamento Parcial',
            'valorabatimento' => 'Valor Abatimento',
            'valorjuromora' => 'Valor Juro Mora',
            'valormulta' => 'Valor Multa',
            'valordesconto' => 'Valor Desconto',
            'valorreajuste' => 'Valor Reajuste',
            'valoroutro' => 'Valor Outro',
            'valorpago' => 'Valor Pago',
            'valorliquido' => 'Valor Líquido',
            'datarecebimento' => 'Data Pagamento',
            'datacredito' => 'Data Crédito',
            'tipobaixatitulo' => 'Tipo Baixa',
            'inativo' => 'Inativo',
            'criacao' => 'Criacao',
            'codusuariocriacao' => 'Codusuariocriacao',
            'alteracao' => 'Alteracao',
            'codusuarioalteracao' => 'Codusuarioalteracao',
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

        $criteria->compare('codtituloboleto', $this->codtituloboleto, true);
        $criteria->compare('codtitulo', $this->codtitulo, true);
        $criteria->compare('codportador', $this->codportador, true);
        $criteria->compare('nossonumero', $this->nossonumero, true);
        $criteria->compare('linhadigitavel', $this->linhadigitavel, true);
        $criteria->compare('barras', $this->barras, true);
        $criteria->compare('qrcodeurl', $this->qrcodeurl, true);
        $criteria->compare('qrcodetxid', $this->qrcodetxid, true);
        $criteria->compare('qrcodeemv', $this->qrcodeemv, true);
        $criteria->compare('canalpagamento', $this->canalpagamento);
        $criteria->compare('estadotitulocobranca', $this->estadotitulocobranca);
        $criteria->compare('vencimento', $this->vencimento, true);
        $criteria->compare('dataregistro', $this->dataregistro, true);
        $criteria->compare('databaixaautomatica', $this->databaixaautomatica, true);
        $criteria->compare('valororiginal', $this->valororiginal, true);
        $criteria->compare('valoratual', $this->valoratual, true);
        $criteria->compare('valorpagamentoparcial', $this->valorpagamentoparcial, true);
        $criteria->compare('valorabatimento', $this->valorabatimento, true);
        $criteria->compare('valorjuromora', $this->valorjuromora, true);
        $criteria->compare('valormulta', $this->valormulta, true);
        $criteria->compare('valordesconto', $this->valordesconto, true);
        $criteria->compare('valorreajuste', $this->valorreajuste, true);
        $criteria->compare('valoroutro', $this->valoroutro, true);
        $criteria->compare('valorpago', $this->valorpago, true);
        $criteria->compare('valorliquido', $this->valorliquido, true);
        $criteria->compare('datarecebimento', $this->datarecebimento, true);
        $criteria->compare('datacredito', $this->datacredito, true);
        $criteria->compare('tipobaixatitulo', $this->tipobaixatitulo);
        $criteria->compare('inativo', $this->inativo, true);
        $criteria->compare('criacao', $this->criacao, true);
        $criteria->compare('codusuariocriacao', $this->codusuariocriacao, true);
        $criteria->compare('alteracao', $this->alteracao, true);
        $criteria->compare('codusuarioalteracao', $this->codusuarioalteracao, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return TituloBoleto the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function abertos()
    {
        $sql = "
            select 1 as ordem, 'vencidos' as tipo, sum(tb.valoratual) valoratual, count(tb.codtituloboleto) quantidade
            from tbltituloboleto tb
            where tb.estadotitulocobranca not in (6, 7) -- LIQUIDADO, BAIXADO
            and tb.vencimento < date_trunc('day', now() - '1 day'::interval)
            union all
            select 2 as ordem, 'vencer7' as tipo, sum(tb.valoratual) valoratual, count(tb.codtituloboleto) quantidade
            from tbltituloboleto tb
            where tb.estadotitulocobranca not in (6, 7) -- LIQUIDADO, BAIXADO
            and tb.vencimento between date_trunc('day', now() - '1 day'::interval) and date_trunc('day', now() + '7 day'::interval)
            union all
            select 3 as ordem, 'vencer30' as tipo, sum(tb.valoratual) valoratual, count(tb.codtituloboleto) quantidade
            from tbltituloboleto tb
            where tb.estadotitulocobranca not in (6, 7) -- LIQUIDADO, BAIXADO
            and tb.vencimento between date_trunc('day', now() + '8 day'::interval) and date_trunc('day', now() + '30 day'::interval)
            union all
            select 4 as ordem, 'vencer60' as tipo, sum(tb.valoratual) valoratual, count(tb.codtituloboleto) quantidade
            from tbltituloboleto tb
            where tb.estadotitulocobranca not in (6, 7) -- LIQUIDADO, BAIXADO
            and tb.vencimento between date_trunc('day', now() + '31 day'::interval) and date_trunc('day', now() + '60 day'::interval)
            union all
            select 5 as ordem, 'vencermais60' as tipo, sum(tb.valoratual) valoratual, count(tb.codtituloboleto) quantidade
            from tbltituloboleto tb
            where tb.estadotitulocobranca not in (6, 7) -- LIQUIDADO, BAIXADO
            and tb.vencimento >= date_trunc('day', now() + '61 day'::interval)
            order by 1
        ";
        $cmd = Yii::app()->db->createCommand($sql);
        $res = $cmd->queryAll();
        foreach ($res as $i => $item) {
            $res[$i]['boletos'] = static::boletosAbertos($item['tipo']);
        }
        return $res;
    }

    public static function boletosAbertos($tipo)
    {
        $sql = "
            select
                t.codpessoa,
                p.fantasia,
                tb.codtitulo,
                t.numero,
                tb.valoratual,
                abs(t.saldo) as saldo,
                tb.vencimento,
                tb.nossonumero,
                tb.codportador,
                po.portador,
                tb.estadotitulocobranca,
                tb.tipobaixatitulo
            from tbltituloboleto tb
            inner join tblportador po on (po.codportador = tb.codportador)
            inner join tbltitulo t on (t.codtitulo = tb.codtitulo)
            inner join tblpessoa p on (p.codpessoa = t.codpessoa)
            where tb.estadotitulocobranca not in (6, 7) -- LIQUIDADO, BAIXADO
        ";

        switch ($tipo) {
            case 'vencidos':
                $sql .= "
                    and tb.vencimento < date_trunc('day', now() - '1 day'::interval)
                ";
                break;
            case 'vencer7':
                $sql .= "
                    and tb.vencimento between date_trunc('day', now() - '1 day'::interval) and date_trunc('day', now() + '7 day'::interval)
                ";
                break;
            case 'vencer30':
                $sql .= "
                    and tb.vencimento between date_trunc('day', now() + '8 day'::interval) and date_trunc('day', now() + '30 day'::interval)
                ";
                break;
            case 'vencer60':
                $sql .= "
                    and tb.vencimento between date_trunc('day', now() + '31 day'::interval) and date_trunc('day', now() + '60 day'::interval)
                ";
                break;
            case 'vencermais60':
                $sql .= "
                    and tb.vencimento >= date_trunc('day', now() + '61 day'::interval)
                ";
                break;
        }

        $sql .= "
            order by tb.vencimento asc, tb.valoratual desc
        ";
        $cmd = Yii::app()->db->createCommand($sql);
        return $cmd->queryAll();
    }

    public static function boletosBaixados()
    {
        $sql = "
            select
                t.codpessoa,
                p.fantasia,
                tb.codtitulo,
                t.numero,
                tb.valoratual,
                abs(t.saldo) as saldo,
                tb.vencimento,
                tb.nossonumero,
                tb.codportador,
                po.portador,
                tb.estadotitulocobranca,
                tb.tipobaixatitulo
            from tbltituloboleto tb
            inner join tblportador po on (po.codportador = tb.codportador)
            inner join tbltitulo t on (t.codtitulo = tb.codtitulo)
            inner join tblpessoa p on (p.codpessoa = t.codpessoa)
            where tb.estadotitulocobranca = 7 -- BAIXADO
            and t.saldo != 0
            order by tb.vencimento desc, tb.valoratual desc
        ";
        $cmd = Yii::app()->db->createCommand($sql);
        return $cmd->queryAll();
    }

    public static function liquidadosPorMes(DateTime $dia)
    {
        $labelMeses = [
            1 => 'Jan',
            2 => 'Fev',
            3 => 'Mar',
            4 => 'Abr',
            5 => 'Mai',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Ago',
            9 => 'Set',
            10 => 'Out',
            11 => 'Nov',
            12 => 'Dez'
        ];
        $meses = [];
        for ($mes = 1; $mes <= 12; $mes++) {
            $obj = new stdClass();
            $obj->label = $labelMeses[$mes];
            $obj->mes = Yii::app()->format->formataPorMascara($mes, '##');
            $obj->valorpago = null;
            $obj->quantidade = 0;
            $meses[$mes] = $obj;
        }

        $sql = "
            select
                extract('month' from tb.datacredito) as mes,
                sum(valorpago) as valorpago,
                count(*) as quantidade
            from tbltituloboleto tb
            where extract('year' from tb.datacredito) = :ano
            group by extract('month' from tb.datacredito)
            order by 1 asc
        ";
        $cmd = Yii::app()->db->createCommand($sql);
        $cmd->params = ['ano' => $dia->format('Y')];
        $regs = $cmd->queryAll();

        foreach ($regs as $reg) {
            $meses[$reg['mes']]->valorpago = $reg['valorpago'];
            $meses[$reg['mes']]->quantidade = $reg['quantidade'];
        };

        return $meses;
    }

    public static function liquidadosPorDia(DateTime $dia)
    {
        $sql = "
            select
                extract('day' from tb.datacredito) as dia,
                sum(valorpago) as valorpago,
                count(*) as quantidade
            from tbltituloboleto tb
            where date_trunc('month', tb.datacredito) = :mes
            group by extract('day' from tb.datacredito)
            order by 1 asc
        ";
        $cmd = Yii::app()->db->createCommand($sql);
        $cmd->params = ['mes' => $dia->format('Y-m') . '-01'];
        $regs = $cmd->queryAll();

        $dias = [];
        foreach ($regs as $reg) {
            $obj = new stdClass();
            $obj->dia = Yii::app()->format->formataPorMascara($reg['dia'], '##');
            $obj->valorpago = $reg['valorpago'];
            $obj->quantidade = $reg['quantidade'];
            $dias[$reg['dia']] = $obj;
        };

        return $dias;
    }


    public static function liquidadosPorPortador(DateTime $dia)
    {
        $sql = "
            select
                p.codportador,
                p.portador,
                coalesce(p.conta, p.codportador)::varchar || '-' || coalesce(p.contadigito, 0)::varchar as conta,
                sum(valorpago) as valorpago,
                count(*) as quantidade
            from tbltituloboleto tb
            inner join tblportador p on (p.codportador = tb.codportador)
            where tb.datacredito = :dia
            group by p.codportador, p.portador, p.conta, p.contadigito
            order by p.portador asc
        ";
        $cmd = Yii::app()->db->createCommand($sql);
        $cmd->params = ['dia' => $dia->format('Y-m-d')];
        $regs = $cmd->queryAll();

        $dias = [];
        foreach ($regs as $reg) {
            $obj = new stdClass();
            $obj->portador = $reg['portador'];
            $obj->conta = $reg['conta'];
            $obj->valorpago = $reg['valorpago'];
            $obj->quantidade = $reg['quantidade'];
            $dias[$reg['codportador']] = $obj;
        };

        return $dias;
    }

    public static function boletosLiquidados(DateTime $dia, $codportador)
    {
        if (empty($codportador)) {
            return [];
        }
        $sql = "
            select
                t.codpessoa,
                p.fantasia,
                tb.codtitulo,
                t.numero,
                tb.valoratual,
                -- tb.valorpagamentoparcial,
                -- tb.valorabatimento,
                tb.valorjuromora,
                tb.valormulta,
                --tb.valordesconto,
                --tb.valorreajuste,
                tb.valoroutro,
                tb.valorpago,
                tb.valorliquido,
                abs(t.saldo) as saldo,
                tb.vencimento,
                tb.datarecebimento,
                tb.nossonumero,
                tb.codportador,
                po.portador,
                tb.estadotitulocobranca,
                tb.tipobaixatitulo
            from tbltituloboleto tb
            inner join tblportador po on (po.codportador = tb.codportador)
            inner join tbltitulo t on (t.codtitulo = tb.codtitulo)
            inner join tblpessoa p on (p.codpessoa = t.codpessoa)
            where tb.datacredito = :dia
            and tb.codportador = :codportador
            order by tb.valorpago desc
        ";
        $cmd = Yii::app()->db->createCommand($sql);
        $cmd->params = [
            'dia' => $dia->format('Y-m-d'),
            'codportador' => $codportador,
        ];

        return $cmd->queryAll();
    }
}

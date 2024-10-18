<?php

/**
 * This is the model class for table "mgsis.tblliquidacaotitulo".
 *
 * The followings are the available columns in table 'mgsis.tblliquidacaotitulo':
 * @property string $codliquidacaotitulo
 * @property string $transacao
 * @property string $codportador
 * @property string $observacao
 * @property string $estornado
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 * @property string $debito
 * @property string $credito
 * @property string $codpessoa
 *
 * The followings are the available model relations:
 * @property Portador $Portador
 * @property Usuario $UsuarioAlteracao
 * @property Usuario $UsuarioCriacao
 * @property Pessoa $Pessoa
 * @property MovimentoTitulo[] $MovimentoTitulos
 */
class LiquidacaoTitulo extends MGActiveRecord
{

    public $valor;
    public $operacao;

    public $criacao_de;
    public $criacao_ate;

    public $transacao_de;
    public $transacao_ate;

    public $codgrupoeconomico;

    public $GridTitulos;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'mgsis.tblliquidacaotitulo';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('GridTitulos, transacao, codportador, codpessoa', 'required', 'on' => 'insert'),
            array('observacao', 'length', 'max' => 200),
            array('debito, credito', 'length', 'max' => 14),
            array('estornado, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('criacao_de, criacao_ate, transacao_de, transacao_ate, codgrupoeconomico, codliquidacaotitulo, transacao, codportador, observacao, estornado, alteracao, codusuarioalteracao, criacao, codusuariocriacao, debito, credito, codpessoa', 'safe', 'on' => 'search'),
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
            'UsuarioAlteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
            'UsuarioCriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
            'Pessoa' => array(self::BELONGS_TO, 'Pessoa', 'codpessoa'),
            'MovimentoTitulos' => array(self::HAS_MANY, 'MovimentoTitulo', 'codliquidacaotitulo'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'codliquidacaotitulo' => '#',
            'transacao' => 'Transação',
            'codportador' => 'Portador',
            'observacao' => 'Observação',
            'estornado' => 'Estornado',
            'alteracao' => 'Alteração',
            'codusuarioalteracao' => 'Usuário Alteração',
            'criacao' => 'Criação',
            'codusuariocriacao' => 'Usuário Criação',
            'debito' => 'Débito',
            'credito' => 'Crédito',
            'codpessoa' => 'Pessoa',
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

        $criteria = new CDbCriteria;

        //$criteria->compare('codliquidacaotitulo',$this->codliquidacaotitulo,false);
        $criteria->compare('t.codliquidacaotitulo', Yii::app()->format->numeroLimpo($this->codliquidacaotitulo), false);
        $criteria->compare('t.codpessoa', $this->codpessoa, false);
        $criteria->compare('t.codportador', $this->codportador, false);
        switch ($this->estornado) {
            case 9:
                break;
            case 1:
                $criteria->addCondition('t.estornado IS NOT NULL');
                break;
            default:
                $criteria->addCondition('t.estornado IS NULL');
                break;
        }
        if ($criacao_de = DateTime::createFromFormat("d/m/y", $this->criacao_de)) {
            $criteria->addCondition('t.criacao >= :criacao_de');
            $criteria->params = array_merge($criteria->params, array(':criacao_de' => $criacao_de->format('Y-m-d') . ' 00:00:00.0'));
        }
        if ($criacao_ate = DateTime::createFromFormat("d/m/y", $this->criacao_ate)) {
            $criteria->addCondition('t.criacao <= :criacao_ate');
            $criteria->params = array_merge($criteria->params, array(':criacao_ate' => $criacao_ate->format('Y-m-d') . ' 23:59:59.9'));
        }
        if ($transacao_de = DateTime::createFromFormat("d/m/y", $this->transacao_de)) {
            $criteria->addCondition('t.transacao >= :transacao_de');
            $criteria->params = array_merge($criteria->params, array(':transacao_de' => $transacao_de->format('Y-m-d') . ' 00:00:00.0'));
        }
        if ($transacao_ate = DateTime::createFromFormat("d/m/y", $this->transacao_ate)) {
            $criteria->addCondition('t.transacao <= :transacao_ate');
            $criteria->params = array_merge($criteria->params, array(':transacao_ate' => $transacao_ate->format('Y-m-d') . ' 23:59:59.9'));
        }

        $criteria->compare('t.codusuariocriacao', $this->codusuariocriacao, false);

        $criteria->with = array(
            'Pessoa' => array('select' => '"Pessoa".fantasia'),
        );

        $criteria->compare('"Pessoa".codgrupoeconomico', $this->codgrupoeconomico, false);

        $criteria->order = 't.transacao DESC, t.criacao DESC, t.codliquidacaotitulo DESC';
        /*
		$criteria->compare('transacao',$this->transacao,true);
		$criteria->compare('observacao',$this->observacao,true);
		$criteria->compare('estornado',$this->estornado,true);
		$criteria->compare('alteracao',$this->alteracao,true);
		$criteria->compare('codusuarioalteracao',$this->codusuarioalteracao,true);
		$criteria->compare('criacao',$this->criacao,true);
		$criteria->compare('debito',$this->debito,true);
		$criteria->compare('credito',$this->credito,true);
		*/

        if ($comoDataProvider) {
            return new CActiveDataProvider($this, array(
                'criteria' => $criteria,
                'pagination' => array('pageSize' => 20)
            ));
        } else {
            return $this->findAll($criteria);
        }
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return LiquidacaoTitulo the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    protected function afterFind()
    {
        $ret = parent::afterFind();

        $this->valor = $this->debito - $this->credito;
        $this->operacao = ($this->valor < 0) ? "CR" : "DB";
        $this->valor = abs($this->valor);

        return $ret;
    }

    public function estorna()
    {
        $trans = $this->dbConnection->beginTransaction();

        $ret = true;

        //cancela todos os movimentos de titulo
        foreach ($this->MovimentoTitulos as $mov) {
            $ret = $mov->estorna();
            if (!$ret) {
                $this->addError("codmovimentotitulo", "Erro ao estornar movimento!");
                $this->addErrors($mov->getErrors());
                break;
            }
        }

        //se cancelou todos os movimentos, marca liquidacao como estornada
        if ($ret) {
            $this->estornado = date('d/m/Y H:i:s');
            $ret = $this->save();
        }

        //grava transacao em caso de sucesso
        if ($ret)
            $trans->commit();
        else
            $trans->rollback();

        return $ret;
    }


    public function save($runValidation = true, $attributes = NULL)
    {
        //comeca transacao
        $trans = $this->dbConnection->beginTransaction();
        $novo = $this->isNewRecord;

        $ret = parent::save($runValidation, $attributes);

        if ($novo && $ret) {

            $titulos = array();

            $gerencial = false;
            $fatura = array();

            $transacao = DateTime::createFromFormat('Y-m-d', $this->transacao);
            if (!$transacao)
                $transacao = DateTime::createFromFormat('d/m/Y', $this->transacao);

            foreach ($this->GridTitulos["codtitulo"] as $codtitulo) {
                $titulo = Titulo::model()->findByPk($codtitulo);

                $ret = $titulo->adicionaMultaJurosDesconto(
                    Yii::app()->format->unformatNumber($this->GridTitulos["multa"][$codtitulo]),
                    Yii::app()->format->unformatNumber($this->GridTitulos["juros"][$codtitulo]),
                    Yii::app()->format->unformatNumber($this->GridTitulos["desconto"][$codtitulo]),
                    $transacao->format('d/m/Y'),
                    $this->codportador,
                    null,
                    $this->codliquidacaotitulo
                );

                if ($ret)
                    $ret = $titulo->adicionaMovimento(
                        TipoMovimentoTitulo::TIPO_LIQUIDACAO,
                        ($titulo->operacao == "CR") ? Yii::app()->format->unformatNumber($this->GridTitulos["total"][$codtitulo]) : null,
                        ($titulo->operacao == "DB") ? Yii::app()->format->unformatNumber($this->GridTitulos["total"][$codtitulo]) : null,
                        $transacao->format('d/m/Y'),
                        $this->codportador,
                        null,
                        $this->codliquidacaotitulo
                    );


                if (!$ret) {
                    $this->addError($this->tableSchema->primaryKey, 'Erro ao lancar multa no título!');
                    $this->addErrors($titulo->getErrors());
                    break;
                }
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


    public function getResumoTitulos()
    {

        $ret = array();

        // percore movimentos
        foreach ($this->MovimentoTitulos as $mov) {

            // inicializa array para cada titulo
            if (!isset($ret[$mov->codtitulo])) {
                $ret[$mov->codtitulo] =
                    array(
                        "principal" => 0,
                        "juros" => 0,
                        "multa" => 0,
                        "desconto" => 0,
                        "total" => 0
                    );
            }

            // acumula valores
            switch ($mov->codtipomovimentotitulo) {
                case TipoMovimentoTitulo::TIPO_JUROS:
                    $ret[$mov->codtitulo]["juros"] += $mov->debito - $mov->credito;
                    break;

                case TipoMovimentoTitulo::TIPO_MULTA:
                    $ret[$mov->codtitulo]["multa"] += $mov->debito - $mov->credito;
                    break;

                case TipoMovimentoTitulo::TIPO_DESCONTO:
                    $ret[$mov->codtitulo]["desconto"] += $mov->credito - $mov->debito;
                    break;

                case TipoMovimentoTitulo::TIPO_LIQUIDACAO:
                    $ret[$mov->codtitulo]["total"] += $mov->credito - $mov->debito;
                    break;

                default:
                    die($mov->codtipomovimentotitulo);
                    break;
            }
        }

        // calcula valor do principal para cada titulo
        foreach ($ret as $codtitulo => $dados) {
            $ret[$codtitulo]["principal"] = $dados["total"] - $dados["juros"] - $dados["multa"] + $dados["desconto"];
        }

        return $ret;
    }
}

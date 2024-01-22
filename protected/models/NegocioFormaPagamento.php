<?php

/**
 * This is the model class for table "mgsis.tblnegocioformapagamento".
 *
 * The followings are the available columns in table 'mgsis.tblnegocioformapagamento':
 * @property string $codnegocioformapagamento
 * @property string $codnegocio
 * @property string $codformapagamento
 * @property string $valorpagamento
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 * @property string $codliopedido
 * @property string $codpixcob
 *
 * The followings are the available model relations:
 * @property FormaPagamento $FormaPagamento
 * @property Negocio $Negocio
 * @property Usuario $UsuarioAlteracao
 * @property Usuario $UsuarioCriacao
 * @property LioPedido $codliopedido
 * @property PixCob $codpixcob
 * @property Titulo[] $Titulos
 */
class NegocioFormaPagamento extends MGActiveRecord
{
    const CARTEIRA_A_VISTA = 1099;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'mgsis.tblnegocioformapagamento';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('codnegocio, codformapagamento, valorpagamento', 'required'),
            array('codformapagamento', 'validaCieloLio'),
            array('valorpagamento', 'length', 'max'=>14),
            array('alteracao, codusuarioalteracao, criacao, codusuariocriacao, codliopedido, codpixcob, valorjuros', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('codnegocioformapagamento, codnegocio, codformapagamento, valorpagamento, alteracao, codusuarioalteracao, criacao, codusuariocriacao, codliopedido, codpixcob', 'safe', 'on'=>'search'),
        );
    }

    public function validaCieloLio($attribute, $params)
    {
        if (empty($this->codformapagamento)) {
            return;
        }
        if ($this->FormaPagamento->lio) {
            $this->addError($attribute, 'Não é permitido adição manual de pagamento via cielo Lio!');
        }
        if ($this->FormaPagamento->pix && $this->FormaPagamento->integracao) {
            $this->addError($attribute, 'Não é permitido adição manual de pagamento via PIX!');
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
            'FormaPagamento' => array(self::BELONGS_TO, 'FormaPagamento', 'codformapagamento'),
            'Negocio' => array(self::BELONGS_TO, 'Negocio', 'codnegocio'),
            'UsuarioAlteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
            'UsuarioCriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
            'LioPedido' => array(self::BELONGS_TO, 'LioPedido', 'codliopedido'),
            'PixCob' => array(self::BELONGS_TO, 'PixCob', 'codpixcob'),
            'Titulos' => array(self::HAS_MANY, 'Titulo', 'codnegocioformapagamento', 'order'=>'vencimentooriginal ASC'),
            'StoneTransacao' => array(self::BELONGS_TO, 'StoneTransacao', 'codstonetransacao'),
            'PagarMePedido' => array(self::BELONGS_TO, 'PagarMePedido', 'codpagarmepedido'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'codnegocioformapagamento' => '#',
            'codnegocio' => 'Negócio',
            'codformapagamento' => 'Forma de Pagamento',
            'valorpagamento' => 'Valor',
            'valorjuros' => 'Juros',
            'alteracao' => 'Alteração',
            'codusuarioalteracao' => 'Usuário Alteração',
            'criacao' => 'Criação',
            'codusuariocriacao' => 'Usuário Criação',
            'codliopedido' => 'Pedido Lio',
            'codpixcob' => 'Cobrança Pix',
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

        $criteria->compare('codnegocioformapagamento', $this->codnegocioformapagamento, true);
        $criteria->compare('codnegocio', $this->codnegocio, true);
        $criteria->compare('codformapagamento', $this->codformapagamento, true);
        $criteria->compare('valorpagamento', $this->valorpagamento, true);
        $criteria->compare('alteracao', $this->alteracao, true);
        $criteria->compare('codusuarioalteracao', $this->codusuarioalteracao, true);
        $criteria->compare('criacao', $this->criacao, true);
        $criteria->compare('codusuariocriacao', $this->codusuariocriacao, true);
        $criteria->compare('codliopedido',$this->codliopedido,true);
    		$criteria->compare('codpixcob',$this->codpixcob,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return NegocioFormaPagamento the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function geraTitulos()
    {

        //se for avista ignora
        if ($this->FormaPagamento->avista) {
            return true;
        }

        //se ja tem titulos gerados gera erro
        if (count($this->Titulos) != 0) {
            $this->addError("codformapagamento", "Já existem Títulos gerados para a forma de pagamento, impossível gerar novos!");
            return false;
        }

        $total = 0;

        // faz um looping para gerar duplicatas
        for ($i = 1; $i <= $this->FormaPagamento->parcelas; $i++) {

            //Joga diferença no último titulo gerado
            if ($i == $this->FormaPagamento->parcelas) {
                $valor = $this->valorpagamento - $total;
            } else {
                $valor = floor($this->valorpagamento / $this->FormaPagamento->parcelas);
            }
            $total += $valor;

            $titulo = new Titulo();
            $titulo->codnegocioformapagamento = $this->codnegocioformapagamento;
            $titulo->codfilial = $this->Negocio->codfilial;
            $titulo->codtipotitulo = $this->Negocio->NaturezaOperacao->codtipotitulo;
            $titulo->codcontacontabil = $this->Negocio->NaturezaOperacao->codcontacontabil;
            $titulo->valor = $valor;
            $titulo->boleto = $this->FormaPagamento->boleto;
            $titulo->codpessoa = $this->Negocio->codpessoa;
            $titulo->numero = "N" . str_pad($this->codnegocio, 8, "0", STR_PAD_LEFT) . "-$i/{$this->FormaPagamento->parcelas}";
            $titulo->emissao = date('d/m/Y');
            $titulo->transacao = date('d/m/Y');
            $titulo->vencimento = date('d/m/Y', strtotime("+" . $i * $this->FormaPagamento->diasentreparcelas . " days"));
            $titulo->vencimentooriginal = $titulo->vencimento;
            $titulo->gerencial = true;

            //se for boleto pega o primeiro portador bancario da filial
            // if ($titulo->boleto) {
            //     if ($portador = Portador::model()->find("codfilial = :codfilial and emiteboleto = true", array(":codfilial" => $titulo->codfilial))) {
            //         $titulo->codportador = $portador->codportador;
            //     }
            // }

            //se nao achou tenta pegar portador do usuario
            if (empty($titulo->codportador)) {
                $titulo->codportador = Yii::app()->user->getState("codportador");
            }

            //se nao preencheu carteira
            if (empty($titulo->codportador)) {
                $titulo->codportador = Portador::CARTEIRA;
            }

            //se deu erro ao salvar titulo aborta
            if (!$titulo->save()) {
                $this->addErrors($titulo->getErrors());
                return false;
            }
        }

        return true;
    }
}

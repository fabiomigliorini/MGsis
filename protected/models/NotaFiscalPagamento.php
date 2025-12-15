<?php

/**
 * This is the model class for table "mgsis.tblnotafiscalpagamento".
 *
 * The followings are the available columns in table 'mgsis.tblnotafiscalpagamento':
 * @property string $codnotafiscalpagamento
 * @property string $codnotafiscal
 * @property boolean $avista
 * @property integer $tipo
 * @property string $valorpagamento
 * @property string $troco
 * @property boolean $integracao
 * @property string $codpessoa
 * @property integer $bandeira
 * @property string $autorizacao
 * @property string $criacao
 * @property string $codusuariocriacao
 * @property string $alteracao
 * @property string $codusuarioalteracao
 *
 * The followings are the available model relations:
 * @property Tblnotafiscal $codnotafiscal
 * @property Tblpessoa $codpessoa
 * @property Tblusuario $codusuariocriacao
 * @property Tblusuario $codusuarioalteracao
 */
class NotaFiscalPagamento extends MGActiveRecord
{

    const TIPO = [
        1 => 'Dinheiro',
        2 => 'Cheque',
        3 => 'Cartão de Crédito',
        4 => 'Cartão de Débito',
        5 => 'Crédito Loja',
        10 => 'Vale Alimentação',
        11 => 'Vale Refeição',
        12 => 'Vale Presente',
        13 => 'Vale Combustível',
        15 => 'Boleto Bancário',
        16 => 'Depósito Bancário',
        17 => 'Pagamento Instantâneo (PIX)',
        18 => 'Transferência bancária, Carteira Digital',
        19 => 'Programa de fidelidade, Cashback, Crédito Virtual',
        90 => 'Sem pagamento',
        99 => 'Outros',
    ];

    const BANDEIRA = [
        1 => 'Visa',
        2 => 'Mastercard',
        3 => 'American Express',
        4 => 'Sorocred',
        5 => 'Diners Club',
        6 => 'Elo',
        7 => 'Hipercard',
        8 => 'Aura',
        9 => 'Cabal',
        99 => 'Outros',
    ];

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'mgsis.tblnotafiscalpagamento';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('codnotafiscal, tipo, valorpagamento', 'required'),
            array('tipo, bandeira', 'numerical', 'integerOnly' => true),
            array('valorpagamento, troco', 'length', 'max' => 14),
            array('autorizacao', 'length', 'max' => 40),
            array('avista, integracao, codpessoa, criacao, codusuariocriacao, alteracao, codusuarioalteracao', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('codnotafiscalpagamento, codnotafiscal, avista, tipo, valorpagamento, troco, integracao, codpessoa, bandeira, autorizacao, criacao, codusuariocriacao, alteracao, codusuarioalteracao', 'safe', 'on' => 'search'),
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
            'NotaFiscal' => array(self::BELONGS_TO, 'NotaFiscal', 'codnotafiscal'),
            'Pessoa' => array(self::BELONGS_TO, 'Pessoa', 'codpessoa'),
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
            'codnotafiscalpagamento' => '#',
            'codnotafiscal' => 'Nota Fiscal',
            'avista' => 'À Vista',
            'tipo' => 'Tipo',
            'valorpagamento' => 'Valor Pagamento',
            'troco' => 'Troco',
            'integracao' => 'Integrado',
            'codpessoa' => 'Integrador',
            'bandeira' => 'Bandeira',
            'autorizacao' => 'Autorização',
            'criacao' => 'Criacão',
            'codusuariocriacao' => 'Usuário Criação',
            'alteracao' => 'Alteração',
            'codusuarioalteracao' => 'Usuário Alteração',
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

        $criteria->compare('codnotafiscalpagamento', $this->codnotafiscalpagamento, true);
        $criteria->compare('codnotafiscal', $this->codnotafiscal, true);
        $criteria->compare('avista', $this->avista);
        $criteria->compare('tipo', $this->tipo);
        $criteria->compare('valorpagamento', $this->valorpagamento, true);
        $criteria->compare('troco', $this->troco, true);
        $criteria->compare('integracao', $this->integracao);
        $criteria->compare('codpessoa', $this->codpessoa, true);
        $criteria->compare('bandeira', $this->bandeira);
        $criteria->compare('autorizacao', $this->autorizacao, true);
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
     * @return NotaFiscalPagamento the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    // public function getTipoListaCombo()
    // {
    //     return [

    //     ];
    // }
}

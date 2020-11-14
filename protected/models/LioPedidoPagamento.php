<?php

/**
 * This is the model class for table "mgsis.tblliopedidopagamento".
 *
 * The followings are the available columns in table 'mgsis.tblliopedidopagamento':
 * @property string $codliopedidopagamento
 * @property string $codliopedido
 * @property string $valor
 * @property integer $parcelas
 * @property string $cartao
 * @property string $autorizacao
 * @property string $nsu
 * @property string $codliobandeiracartao
 * @property string $uuid
 * @property string $nome
 * @property string $transacao
 * @property string $codlioproduto
 * @property integer $codigov40
 * @property boolean $autorizada
 * @property string $codlioterminal
 * @property string $criacao
 * @property string $codusuariocriacao
 * @property string $alteracao
 * @property string $codusuarioalteracao
 *
 * The followings are the available model relations:
 * @property Liopedido $codliopedido
 * @property Liobandeiracartao $codliobandeiracartao
 * @property Lioproduto $codlioproduto
 * @property Lioterminal $codlioterminal
 * @property Usuario $codusuariocriacao
 * @property Usuario $codusuarioalteracao
 */
class LioPedidoPagamento extends MGActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'mgsis.tblliopedidopagamento';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('codliopedido, autorizada', 'required'),
            array('parcelas, codigov40', 'numerical', 'integerOnly'=>true),
            array('valor', 'length', 'max'=>14),
            array('cartao', 'length', 'max'=>20),
            array('autorizacao, nsu, nome', 'length', 'max'=>100),
            array('codliobandeiracartao, uuid, transacao, codlioproduto, codlioterminal, criacao, codusuariocriacao, alteracao, codusuarioalteracao', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('codliopedidopagamento, codliopedido, valor, parcelas, cartao, autorizacao, nsu, codliobandeiracartao, uuid, nome, transacao, codlioproduto, codigov40, autorizada, codlioterminal, criacao, codusuariocriacao, alteracao, codusuarioalteracao', 'safe', 'on'=>'search'),
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
            'LioPedido' => array(self::BELONGS_TO, 'LioPedido', 'codliopedido'),
            'LioBandeiraCartao' => array(self::BELONGS_TO, 'LioBandeiraCartao', 'codliobandeiracartao'),
            'LioProduto' => array(self::BELONGS_TO, 'LioProduto', 'codlioproduto'),
            'LioTerminal' => array(self::BELONGS_TO, 'LioTerminal', 'codlioterminal'),
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
            'codliopedidopagamento' => 'Codliopedidopagamento',
            'codliopedido' => 'Codliopedido',
            'valor' => 'payments.amount / 100',
            'parcelas' => 'payments.paymentFilelds.numberOfQuotas',
            'cartao' => 'payment.paymentFields.pan / payment.mask',
            'autorizacao' => 'payments.authCode',
            'nsu' => 'payments.cieloCode',
            'codliobandeiracartao' => 'payments.brand',
            'uuid' => 'payments.id',
            'nome' => 'payments.paymentFilelds.clientName',
            'transacao' => 'payments.paymentFilelds.originalTransactionDate',
            'codlioproduto' => 'Codlioproduto',
            'codigov40' => 'payments.paymentFilelds.v40Code',
            'autorizada' => 'payments.paymentFilelds.statusCode == 1',
            'codlioterminal' => 'Codlioterminal',
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

        $criteria=new CDbCriteria;

        $criteria->compare('codliopedidopagamento', $this->codliopedidopagamento, true);
        $criteria->compare('codliopedido', $this->codliopedido, true);
        $criteria->compare('valor', $this->valor, true);
        $criteria->compare('parcelas', $this->parcelas);
        $criteria->compare('cartao', $this->cartao, true);
        $criteria->compare('autorizacao', $this->autorizacao, true);
        $criteria->compare('nsu', $this->nsu, true);
        $criteria->compare('codliobandeiracartao', $this->codliobandeiracartao, true);
        $criteria->compare('uuid', $this->uuid, true);
        $criteria->compare('nome', $this->nome, true);
        $criteria->compare('transacao', $this->transacao, true);
        $criteria->compare('codlioproduto', $this->codlioproduto, true);
        $criteria->compare('codigov40', $this->codigov40);
        $criteria->compare('autorizada', $this->autorizada);
        $criteria->compare('codlioterminal', $this->codlioterminal, true);
        $criteria->compare('criacao', $this->criacao, true);
        $criteria->compare('codusuariocriacao', $this->codusuariocriacao, true);
        $criteria->compare('alteracao', $this->alteracao, true);
        $criteria->compare('codusuarioalteracao', $this->codusuarioalteracao, true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return LioPedidoPagamento the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}

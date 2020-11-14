<?php

/**
 * This is the model class for table "mgsis.tblliopedido".
 *
 * The followings are the available columns in table 'mgsis.tblliopedido':
 * @property string $codliopedido
 * @property string $valortotal
 * @property string $valorpago
 * @property string $valorsaldo
 * @property string $referencia
 * @property string $uuid
 * @property string $codliopedidostatus
 * @property string $criacao
 * @property string $codusuarioalteracao
 * @property string $alteracao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property Negocioformapagamento[] $negocioformapagamentos
 * @property Liopedidopagamento[] $liopedidopagamentos
 * @property Liopedidostatus $codliopedidostatus
 * @property Usuario $codusuarioalteracao
 * @property Usuario $codusuariocriacao
 */
class LioPedido extends MGActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'mgsis.tblliopedido';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('valortotal, valorpago, valorsaldo, uuid, codliopedidostatus', 'required'),
            array('valortotal, valorpago, valorsaldo', 'length', 'max'=>14),
            array('referencia', 'length', 'max'=>100),
            array('criacao, codusuarioalteracao, alteracao, codusuariocriacao', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('codliopedido, valortotal, valorpago, valorsaldo, referencia, uuid, codliopedidostatus, criacao, codusuarioalteracao, alteracao, codusuariocriacao', 'safe', 'on'=>'search'),
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
            'NegocioFormaPagamentos' => array(self::HAS_MANY, 'NegocioFormaPagamento', 'codliopedido'),
            'LioPedidoPagamentos' => array(self::HAS_MANY, 'LioPedidoPagamento', 'codliopedido'),
            'LioPedidoStatus' => array(self::BELONGS_TO, 'LioPedidoStatus', 'codliopedidostatus'),
            'UsuarioAlteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
            'UsuarioCriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'codliopedido' => 'Codliopedido',
            'valortotal' => 'price / 100',
            'valorpago' => 'paidAmount / 100',
            'valorsaldo' => 'pendingAmount / 100',
            'referencia' => 'reference',
            'uuid' => 'Uuid',
            'codliopedidostatus' => 'Codliopedidostatus',
            'criacao' => 'createdAt',
            'codusuarioalteracao' => 'Codusuarioalteracao',
            'alteracao' => 'updatedAt',
            'codusuariocriacao' => 'Codusuariocriacao',
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

        $criteria->compare('codliopedido', $this->codliopedido, true);
        $criteria->compare('valortotal', $this->valortotal, true);
        $criteria->compare('valorpago', $this->valorpago, true);
        $criteria->compare('valorsaldo', $this->valorsaldo, true);
        $criteria->compare('referencia', $this->referencia, true);
        $criteria->compare('uuid', $this->uuid, true);
        $criteria->compare('codliopedidostatus', $this->codliopedidostatus, true);
        $criteria->compare('criacao', $this->criacao, true);
        $criteria->compare('codusuarioalteracao', $this->codusuarioalteracao, true);
        $criteria->compare('alteracao', $this->alteracao, true);
        $criteria->compare('codusuariocriacao', $this->codusuariocriacao, true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return LioPedido the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}

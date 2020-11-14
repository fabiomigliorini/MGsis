<?php

/**
 * This is the model class for table "mgsis.tbllioterminal".
 *
 * The followings are the available columns in table 'mgsis.tbllioterminal':
 * @property string $codlioterminal
 * @property string $lioterminal
 * @property string $terminal
 * @property string $codfilial
 * @property string $criacao
 * @property string $codusuariocriacao
 * @property string $alteracao
 * @property string $codusuarioalteracao
 *
 * The followings are the available model relations:
 * @property Filial $codfilial
 * @property Usuario $codusuariocriacao
 * @property Usuario $codusuarioalteracao
 * @property Liopedidopagamento[] $liopedidopagamentos
 */
class LioTerminal extends MGActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'mgsis.tbllioterminal';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('lioterminal, terminal', 'required'),
            array('lioterminal', 'length', 'max'=>100),
            array('terminal', 'length', 'max'=>20),
            array('codfilial, criacao, codusuariocriacao, alteracao, codusuarioalteracao', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('codlioterminal, lioterminal, terminal, codfilial, criacao, codusuariocriacao, alteracao, codusuarioalteracao', 'safe', 'on'=>'search'),
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
            'Filial' => array(self::BELONGS_TO, 'Filial', 'codfilial'),
            'UsuarioCriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
            'UsuarioAlteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
            'LioPedidoPagamentos' => array(self::HAS_MANY, 'LioPedidoPagamento', 'codlioterminal'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'codlioterminal' => 'Codlioterminal',
            'lioterminal' => 'Lioterminal',
            'terminal' => 'Terminal',
            'codfilial' => 'Codfilial',
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

        $criteria->compare('codlioterminal', $this->codlioterminal, true);
        $criteria->compare('lioterminal', $this->lioterminal, true);
        $criteria->compare('terminal', $this->terminal, true);
        $criteria->compare('codfilial', $this->codfilial, true);
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
     * @return LioTerminal the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}

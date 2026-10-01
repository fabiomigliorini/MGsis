<?php

/**
 * Parcela do negocio (tblnegocioparcela, M4 do plano doc-3 do MGspa): o prazo
 * da venda/compra, que vira titulo (tbltitulo.codnegocioparcela).
 * Condicao: F fechamento, P parcelado, B boleto, E entrega, X PIX/deposito
 * a receber, V vale da devolucao.
 *
 * @property string $codnegocioparcela
 * @property string $uuid
 * @property string $codnegocio
 * @property string $condicao
 * @property string $numero
 * @property string $vencimento
 * @property string $valor
 * @property string $juros
 * @property string $codtitulo
 * @property string $uuidforma
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * @property Negocio $Negocio
 * @property Titulo $Titulo
 * @property Titulo[] $Titulos
 */
class NegocioParcela extends MGActiveRecord
{
    const CONDICAO_FECHAMENTO = 'F';

    public function tableName()
    {
        return 'mgsis.tblnegocioparcela';
    }

    public function rules()
    {
        return array(
            array('codnegocio, condicao, numero, vencimento, valor', 'required'),
            array('juros, codtitulo, uuidforma, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
        );
    }

    public function relations()
    {
        return array(
            'Negocio' => array(self::BELONGS_TO, 'Negocio', 'codnegocio'),
            'Titulo' => array(self::BELONGS_TO, 'Titulo', 'codtitulo'),
            'Titulos' => array(self::HAS_MANY, 'Titulo', 'codnegocioparcela', 'order' => 'vencimentooriginal ASC'),
            'UsuarioAlteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
            'UsuarioCriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'codnegocioparcela' => '#',
            'codnegocio' => 'Negócio',
            'condicao' => 'Condição',
            'numero' => 'Parcela',
            'vencimento' => 'Vencimento',
            'valor' => 'Valor',
            'juros' => 'Juros',
            'codtitulo' => 'Título',
        );
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}

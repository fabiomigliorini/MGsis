<?php

/**
 * This is the model class for table "mgsis.tblnegocio".
 *
 * The followings are the available columns in table 'mgsis.tblnegocio':
 * @property string $codnegocio
 * @property string $codpessoa
 * @property string $codfilial
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
 *
 * The followings are the available model relations:
 * @property Filial $Filial
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
 */
class Negocio extends MGActiveRecord
{
	public $lancamento_de;
	public $lancamento_ate;
	public $horario_de;
	public $horario_ate;
	public $percentualdesconto;
	
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
			array('codpessoa, codfilial, lancamento, codoperacao, codnegociostatus, codusuario, codnaturezaoperacao', 'required'),
			array('observacoes', 'length', 'max'=>500),
			array('valordesconto, valorprodutos, valortotal, valoraprazo, valoravista', 'numerical'),
			array('valordesconto', 'validaDesconto'),
			//array('codnegociostatus', 'validaStatus'),
			array('codpessoa, codpessoavendedor, entrega, acertoentrega, codusuarioacertoentrega, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('horario_de, horario_ate, lancamento_de, lancamento_ate, codnegocio, codpessoa, codfilial, lancamento, codpessoavendedor, codoperacao, codnegociostatus, observacoes, codusuario, valordesconto, entrega, acertoentrega, codusuarioacertoentrega, alteracao, codusuarioalteracao, criacao, codusuariocriacao, codnaturezaoperacao, valorprodutos, valortotal, valoraprazo, valoravista', 'safe', 'on'=>'search'),
		);
	}

	public function validaDesconto($attribute, $params)
	{
		if ($this->valordesconto > $this->valorprodutos)
			$this->addError($attribute, 'O valor de desconto não pode ser maior que o valor dos produtos!');
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
			'Filial' => array(self::BELONGS_TO, 'Filial', 'codfilial'),
			'NegocioStatus' => array(self::BELONGS_TO, 'NegocioStatus', 'codnegociostatus'),
			'Operacao' => array(self::BELONGS_TO, 'Operacao', 'codoperacao'),
			'Pessoa' => array(self::BELONGS_TO, 'Pessoa', 'codpessoa'),
			'Vendedor' => array(self::BELONGS_TO, 'Pessoa', 'codpessoavendedor'),
			'Usuario' => array(self::BELONGS_TO, 'Usuario', 'codusuario'),
			'UsuarioAcertoEntrega' => array(self::BELONGS_TO, 'Usuario', 'codusuarioacertoentrega'),
			'UsuarioAlteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
			'UsuarioCriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
			'NaturezaOperacao' => array(self::BELONGS_TO, 'NaturezaOperacao', 'codnaturezaoperacao'),
			'NegocioFormaPagamentos' => array(self::HAS_MANY, 'NegocioFormaPagamento', 'codnegocio'),
			'NegocioProdutoBarras' => array(self::HAS_MANY, 'NegocioProdutoBarra', 'codnegocio', 'order'=>'alteracao DESC, codnegocioprodutobarra DESC'),
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
			'lancamento' => 'Lançamento',
			'codpessoavendedor' => 'Vendedor',
			'codoperacao' => 'Operação',
			'codnegociostatus' => 'Status',
			'observacoes' => 'Observações',
			'codusuario' => 'Usuário',
			'valordesconto' => 'Desconto',
			'percentualdesconto' => 'Desconto %',
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

		$criteria->compare('codnegocio',$this->codnegocio,false);
		$criteria->compare('codpessoa',$this->codpessoa,false);
		$criteria->compare('codfilial',$this->codfilial,false);
		$criteria->compare('lancamento',$this->lancamento,true);
		$criteria->compare('codpessoavendedor',$this->codpessoavendedor,false);
		$criteria->compare('codoperacao',$this->codoperacao,false);
		$criteria->compare('codnegociostatus',$this->codnegociostatus,false);
		$criteria->compare('observacoes',$this->observacoes,true);
		$criteria->compare('codusuario',$this->codusuario,false);
		$criteria->compare('valordesconto',$this->valordesconto,true);
		$criteria->compare('entrega',$this->entrega);
		$criteria->compare('acertoentrega',$this->acertoentrega,true);
		$criteria->compare('codusuarioacertoentrega',$this->codusuarioacertoentrega,false);
		$criteria->compare('alteracao',$this->alteracao,true);
		$criteria->compare('codusuarioalteracao',$this->codusuarioalteracao,false);
		$criteria->compare('criacao',$this->criacao,true);
		$criteria->compare('codusuariocriacao',$this->codusuariocriacao,false);
		$criteria->compare('codnaturezaoperacao',$this->codnaturezaoperacao,false);
		$criteria->compare('valorprodutos',$this->valorprodutos,true);
		$criteria->compare('valortotal',$this->valortotal,true);
		$criteria->compare('valoraprazo',$this->valoraprazo,true);
		$criteria->compare('valoravista',$this->valoravista,true);
		
		if ($lancamento_de = DateTime::createFromFormat("d/m/y H:i",$this->lancamento_de . " " . $this->horario_de))
		{
			$criteria->addCondition('t.lancamento >= :lancamento_de');
			$criteria->params = array_merge($criteria->params, array(':lancamento_de' => $lancamento_de->format('Y-m-d H:i').':00.0'));
		}
		if ($lancamento_ate = DateTime::createFromFormat("d/m/y H:i",$this->lancamento_ate  . " " . $this->horario_ate))
		{
			$criteria->addCondition('t.lancamento <= :lancamento_ate');
			$criteria->params = array_merge($criteria->params, array(':lancamento_ate' => $lancamento_ate->format('Y-m-d H:i').':59.9'));
		}
		
		/*
		echo "<pre>";
		print_r($criteria);
		echo "</pre>";
		*/
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array('defaultOrder'=>'t.lancamento DESC, t.codnegocio DESC'),
			'pagination'=>array('pageSize'=>20)
		));
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
		if ($this->valortotal >0 and $this->valordesconto>0)
			$this->percentualdesconto = 100 * ($this->valordesconto / $this->valorprodutos);
		else
			$this->percentualdesconto = 0;
		
		return parent::afterFind();
	}		
	
	public function fechaNegocio()
	{
		
		//So continua se for status ABERTO
		if ($this->codnegociostatus != NegocioStatus::ABERTO)
		{
			$this->addError("codnegociostatus", "O Status do Negócio não permite Fechamento!");
			return false;
		}
		
		foreach ($this->NegocioFormaPagamentos as $nfp)
		{
			if (!$nfp->geraTitulos())
			{
				$this->addErrors($nfp->getErrors());
				return false;
			}
		}
		
		$this->codnegociostatus = NegocioStatus::FECHADO;
		return $this->save();
		
	}
	
	// Gera nota fiscal a partir do negocio
	public function geraNotaFiscal($codnotafiscal = null, $geraDuplicatas = true)
	{
		//se passou uma nota por parametro tenta localizar ela
		if (!empty($codnotafiscal))
			$nota = NotaFiscal::model()->findByPK($codnotafiscal);
				
		//se nao localizou nenhuma nota, cria uma nova
		if (empty($nota))
		{
			$nota = new NotaFiscal;
			$nota->codpessoa = $this->codpessoa;
			if (empty($nota->codpessoa))
				$nota->codpessoa = Pessoa::CONSUMIDOR;
			$nota->codfilial = $this->codfilial;
			$nota->serie = 1;
			$nota->numero = 0;
			$nota->codnaturezaoperacao = $this->codnaturezaoperacao;
			$nota->emitida = $this->NaturezaOperacao->emitida;
			//die(date('d/m/Y'));
			$nota->emissao = date('d/m/Y');
			$nota->saida = date('d/m/Y h:i:s');
			$nota->observacoes = $this->NaturezaOperacao->observacoesnf;
			$nota->fretepagar = 1;
			$nota->codoperacao = $this->NaturezaOperacao->codoperacao;
		}
	
		//concatena obeservacoes
		$nota->observacoes .= "\nReferente ao Negocio #{$this->codnegocio}";
		if (strlen($nota->observacoes) > 500)
			$nota->observacoes = substr($nota->observacoes, 0, 500);
		
		//acumula o valor de desconto
		$nota->valordesconto += $this->valordesconto;
		
		//salva nota fiscal
		if (!$nota->save())
		{
			$this->addErrors($nota->getErrors());
			return false;
		}
		
		//percorre os itens do negocio e adiciona na nota
		foreach($this->NegocioProdutoBarras as $negocioItem)
		{
			$notaItem = new NotaFiscalProdutoBarra;
			
            $notaItem->codnotafiscal = $nota->codnotafiscal;
            $notaItem->codnegocioprodutobarra = $negocioItem->codnegocioprodutobarra;
            $notaItem->codprodutobarra = $negocioItem->codprodutobarra;
            $notaItem->quantidade = $negocioItem->quantidade;
            $notaItem->valorunitario = $negocioItem->valorunitario;
            $notaItem->valortotal = $negocioItem->valortotal;
            
			if (!$notaItem->save())
			{
				$this->addErrors($notaItem->getErrors());
				return false;
			}
		}
		
		if ($geraDuplicatas)
		{
			foreach($this->NegocioFormaPagamentos as $forma)
			{
				foreach ($forma->Titulos as $titulo)
				{
					$duplicata = new NotaFiscalDuplicatas;
					$duplicata->codnotafiscal = $nota->codnotafiscal;
					$duplicata->fatura = $titulo->numero;
					$duplicata->valor = $titulo->valor;
					$duplicata->vencimento = $titulo->vencimento;
					if (!$duplicata->save())
					{
						$this->addErrors($duplicata->getErrors());
						return false;
					}
				}
			}
		}
		
		//retorna codigo da nota gerada
		return $nota->codnotafiscal;
		
	}
	
}

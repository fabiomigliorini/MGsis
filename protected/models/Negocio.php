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
	public $percentualdesconto;
	public $pagamento;
	
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
			array('pagamento, lancamento_de, lancamento_ate, codnegocio, codpessoa, codfilial, lancamento, codpessoavendedor, codoperacao, codnegociostatus, observacoes, codusuario, valordesconto, entrega, acertoentrega, codusuarioacertoentrega, alteracao, codusuarioalteracao, criacao, codusuariocriacao, codnaturezaoperacao, valorprodutos, valortotal, valoraprazo, valoravista', 'safe', 'on'=>'search'),
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
			'PessoaVendedor' => array(self::BELONGS_TO, 'Pessoa', 'codpessoavendedor'),
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
	public function search($comoDataProvider = true)
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
		
		if ($lancamento_de = DateTime::createFromFormat("d/m/y H:i",$this->lancamento_de))
		{
			$criteria->addCondition('t.lancamento >= :lancamento_de');
			$criteria->params = array_merge($criteria->params, array(':lancamento_de' => $lancamento_de->format('Y-m-d H:i').':00.0'));
		}
		if ($lancamento_ate = DateTime::createFromFormat("d/m/y H:i",$this->lancamento_ate))
		{
			$criteria->addCondition('t.lancamento <= :lancamento_ate');
			$criteria->params = array_merge($criteria->params, array(':lancamento_ate' => $lancamento_ate->format('Y-m-d H:i').':59.9'));
		}
		
		switch ($this->pagamento)
		{
			case "a":
				$criteria->addCondition('t.valoraprazo = 0');
				break;

			case "p":
				$criteria->addCondition('t.valoravista = 0');
				break;
			
			default:
				break;
		}
		
		
		$criteria->order = 't.codnegociostatus, t.lancamento DESC, t.codnegocio DESC';

		
		/*
		echo "<pre>";
		print_r($criteria);
		echo "</pre>";
		*/
		if ($comoDataProvider)
		{
			$params = array(
				'criteria'=>$criteria,
				'pagination'=>array('pageSize'=>20)
			);
			return new CActiveDataProvider($this, $params);
		}
		else
		{
			return $this->findAll($criteria);
		}
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
		
		if (sizeof($this->NegocioProdutoBarras) == 0)
		{
			$this->addError("codnegociostatus", "Não foi informado nenhum produto neste negócio!");
			return false;			
		}
		
		if ($this->valoraprazo > 0)
		{
			if (!$this->Pessoa->avaliaLimiteCredito($this->valoraprazo))
			{
				$this->addError("codpessoa", "Solicite Liberação de Crédito ao Departamento Financeiro!");
				return false;			
			}
			
		}
			
		
		
		//Calcula total pagamentos à vista e à prazo
		$valorPagamentos = 0;
		$valorPagamentosPrazo = 0;
		foreach ($this->NegocioFormaPagamentos as $nfp)
		{
			$valorPagamentos += $nfp->valorpagamento;
			if (!$nfp->FormaPagamento->avista)
				$valorPagamentosPrazo += $nfp->valorpagamento;
		}
		
		//valida total pagamentos
		if ($valorPagamentos < $this->valortotal)
		{
			$this->addError("valortotal", "O valor dos Pagamentos é inferior ao Total!");
			return false;
		}
		
		//valida total à prazo
		if ($valorPagamentosPrazo > $this->valortotal)
		{
			$this->addError("valortotal", "O valor à Prazo é superior ao Total!");
			return false;
		}
		
		//gera títulos
		foreach ($this->NegocioFormaPagamentos as $nfp)
		{
			if (!$nfp->geraTitulos())
			{
				$this->addErrors($nfp->getErrors());
				return false;
			}
		}
		
		//atualiza status
		$this->codnegociostatus = NegocioStatus::FECHADO;
		$this->codusuario = Yii::app()->user->id;
		$this->lancamento = date('d/m/Y H:i:s');
		return $this->save();
		
	}
	
	// Gera nota fiscal a partir do negocio
	public function geraNotaFiscal($codnotafiscal = null, $modelo = NotaFiscal::MODELO_NFE, $geraDuplicatas = true)
	{
		if ($this->Pessoa->notafiscal == Pessoa::NOTAFISCAL_NUNCA && $modelo == NotaFiscal::MODELO_NFE)
		{
			$this->addError("codpessoa", "Pessoa marcada para <b>NUNCA EMITIR</b> NFe!");
			return false;
		}
		
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
			$nota->modelo = $modelo;
			$nota->codnaturezaoperacao = $this->codnaturezaoperacao;
			$nota->emitida = $this->NaturezaOperacao->emitida;
			//die(date('d/m/Y'));
			$nota->emissao = date('d/m/Y');
			$nota->saida = date('d/m/Y');
			
			$nota->observacoes = "";
			$nota->observacoes .= $this->NaturezaOperacao->mensagemprocom;
			
			if ($nota->modelo == NotaFiscal::MODELO_NFE)
			{
				if (!empty($nota->observacoes))
					$nota->observacoes .= "\n";

				$nota->observacoes .= $this->NaturezaOperacao->observacoesnf;
			}
			
			$nota->fretepagar = 1;
			$nota->codoperacao = $this->NaturezaOperacao->codoperacao;
		}
	
		//concatena obeservacoes
		$nota->observacoes = $nota->observacoes;
		if (!empty($nota->observacoes))
			$nota->observacoes .= "\n";
		$nota->observacoes .= "Referente ao Negocio #{$this->codnegocio}";
		if (isset($this->PessoaVendedor))
			$nota->observacoes .= " - Vendedor: {$this->PessoaVendedor->fantasia}";
		if (!empty($this->observacoes))
			$nota->observacoes .= " - {$this->observacoes}";
			
		if (strlen($nota->observacoes) > 1500)
			$nota->observacoes = substr($nota->observacoes, 0, 1500);
		
		//acumula o valor de desconto
		$nota->valordesconto += $this->valordesconto;
		
		if (!$nota->save())
		{
			$this->addErrors($nota->getErrors());
			return false;
		}
		
		//percorre os itens do negocio e adiciona na nota
		foreach($this->NegocioProdutoBarras as $negocioItem)
		{
			foreach ($negocioItem->NotaFiscalProdutoBarras as $notaItem)
			{
				if (!in_array($notaItem->NotaFiscal->codstatus, array(NotaFiscal::CODSTATUS_INUTILIZADA, NotaFiscal::CODSTATUS_CANCELADA)))
				{
					continue(2); // vai para proximo item
				}
			}
			
			//esta aqui para so salvar a nota, caso exista algum produto por adicionar
			if (empty($nota->codnotafiscal))
			{
				//salva nota fiscal
				if (!$nota->save())
				{
					$this->addErrors($nota->getErrors());
					return false;
				}
			}
			
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
		
		if (empty($nota->codnotafiscal))
		{
			$this->addError("codnotafiscal", "Não existe nenhum produto para gerar Nota neste Negócio");
			return false;
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
	
	public function cancelar()
	{
		
		// verifica se ja nao foi cancelado
		if ($this->codnegociostatus == NegocioStatus::CANCELADO)
		{
			$this->addError("codnegociostatus", 'Negócio já está cancelado!');
			return false;
		}

		// verifica se tem nota fiscal ativa
		foreach ($this->NegocioProdutoBarras as $npb)
		{
			foreach ($npb->NotaFiscalProdutoBarras as $nfpb)
			{
				if ($nfpb->NotaFiscal->codstatus <> NotaFiscal::CODSTATUS_CANCELADA && $nfpb->NotaFiscal->codstatus <> NotaFiscal::CODSTATUS_INUTILIZADA)
				{
					$this->addError("codnegociostatus", 'Negócio possui Nota Fiscal ativa!');
					return false;
				}
			}
		}

		$transaction = Yii::app()->db->beginTransaction();
		
		try 
		{
			foreach ($this->NegocioFormaPagamentos as $nfp)
			{
				foreach ($nfp->Titulos as $tit)
				{
					if (!empty($tit->estornado))
						continue;

					if (!$tit->estorna())
					{
						$this->addError("codnegociostatus", "Erro ao estornar Titulos!");
						$this->addErrors($tit->getErrors());
						$transaction->rollBack();
						return false;
					}
				}
			}

			$this->codnegociostatus = NegocioStatus::CANCELADO;
			if ($this->save())
			{
				$transaction->commit();
				return true;
			}
			else
			{
				$transaction->rollBack();
				return false;			
			}
			
		}
		catch (Exception $e)
		{
			$transaction->rollBack();
			return false;
		} 		
		
	}
	
	
}

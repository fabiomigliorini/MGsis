<?php

/**
 * This is the model class for table "mgsis.tbltituloagrupamento".
 *
 * The followings are the available columns in table 'mgsis.tbltituloagrupamento':
 * @property string $codtituloagrupamento
 * @property string $emissao
 * @property string $cancelamento
 * @property string $observacao
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 * @property string $debito
 * @property string $credito
 * @property string $codpessoa
 *
 * The followings are the available model relations:
 * @property MovimentoTitulo[] $MovimentoTitulos
 * @property Titulo[] $Titulos
 * @property Usuario $UsuarioAlteracao
 * @property Usuario $UsuarioCriacao
 * @property Pessoa $Pessoa 
 */
class TituloAgrupamento extends MGActiveRecord
{
		
	public $codportador;
	public $codfilial;
	public $boleto;
	
	public $GridTitulos;
	public $vencimentos;
	public $valores;
	
	public $parcelas;
	public $primeira;
	public $demais;
	
	public $emissao_de;
	public $emissao_ate;
	public $criacao_de;
	public $criacao_ate;

	public $operacao;
	public $valor;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tbltituloagrupamento';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('emissao, codpessoa, GridTitulos, vencimentos, valores, codfilial', 'required', 'on'=>'insert'),
			array('GridTitulos', 'validaGridTitulos', 'on'=>'insert'),
			array('vencimentos', 'validaVencimentos', 'on'=>'insert'),
			array('codportador', 'validaFilialPortador', 'on'=>'insert'),
			array('emissao','date','format'=>Yii::app()->locale->getDateFormat('medium')),
			array('cancelamento','date','format'=>Yii::app()->locale->getDateFormat('medium')),
			array('boleto', 'validaBoleto', 'on'=>'insert'),
			array('parcelas, codportador, boleto, primeira, demais', 'safe', 'on'=>'insert'),
			array('observacao', 'length', 'max'=>200),
			array('cancelamento, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('emissao_de, emissao_ate, criacao_de, criacao_ate, codpessoa, codtituloagrupamento, emissao', 'safe', 'on'=>'search'),
		);
	}

	public function validaBoleto($attribute, $params)
	{
		if (!$this->boleto)
			return;
		
		if (empty($this->codportador))
		{
			$this->addError($attribute, "Selecione um portador!");
			return;
		}
		
		$portador = Portador::model()->findByPk($this->codportador);
		if (!$portador->emiteboleto)
			$this->addError($attribute, "O portador selecionado não permite boletos!");
	}

	
	public function validaFilialPortador($attribute, $params)
	{
		if (!empty($this->codfilial))
			if (!empty($this->codportador))
			{
				$portador = Portador::model()->findByPk($this->codportador);
				if (($this->codfilial <> $portador->codfilial) && !empty($portador->codfilial))
					$this->addError($attribute, "Este portador só é válido para a filial {$portador->Filial->filial}!");
			}
	}
	
	public function validaGridTitulos($attribute, $params)
	{

		//se nao marcou nenhum título no grid
		if (empty($this->GridTitulos) || !is_array($this->GridTitulos) || empty($this->GridTitulos["codtitulo"]))
		{
			$this->addError($attribute, 'Selecione os títulos à serem baixados!');
			return;
		}
		
		//percorre todos títulos selecionados, verificando se os valores calculados estão corretos
		foreach($this->GridTitulos["codtitulo"] as $codtitulo)
		{
			//valida total selecionado
			if (($this->GridTitulos["saldo"][$codtitulo] + 
				 $this->GridTitulos["multa"][$codtitulo] + 
				 $this->GridTitulos["juros"][$codtitulo] - 
				 $this->GridTitulos["desconto"][$codtitulo] - 
				 $this->GridTitulos["total"][$codtitulo])
				> 0.005
				)
				$this->addError($attribute, 'Total incorreto para o título ' . CHtml::link(CHtml::encode(Yii::app()->format->formataCodigo($codtitulo)),array('titulo/view','id'=>$codtitulo)) . "!");
			
		}
	}
	
	public function calculaTotalGridTitulos()
	{
		if (empty($this->GridTitulos["codtitulo"]))
			return 0;
		
		$total = 0;
		foreach($this->GridTitulos["codtitulo"] as $codtitulo)
			$total += Yii::app()->format->unformatNumber($this->GridTitulos["total"][$codtitulo]) * (($this->GridTitulos["operacao"][$codtitulo] == "CR")?-1:1);
		
		return $total;
	}

	public function calculaTotalValores()
	{
		if (empty($this->valores))
			return 0;
		
		$total = 0;
		foreach($this->valores as $valor)
			$total += Yii::app()->format->unformatNumber($valor);
		
		return $total;
	}
	
	public function validaVencimentos($attribute, $params)
	{
		$titulos = abs($this->calculaTotalGridTitulos());
		$parcelas = $this->calculaTotalValores();
		if (abs($titulos - $parcelas) > 0.005)
		{
			$this->addError($attribute, "O valor total das parcelas ($parcelas) não bate com o total dos títulos selecionados ($titulos)!");
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
			'UsuarioAlteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
			'UsuarioCriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
			'MovimentoTitulos' => array(self::HAS_MANY, 'MovimentoTitulo', 'codtituloagrupamento', 'order'=>'codmovimentotitulo ASC'),
			'Titulos' => array(self::HAS_MANY, 'Titulo', 'codtituloagrupamento', 'order'=>'vencimento asc'),
			'Pessoa' => array(self::BELONGS_TO, 'Pessoa', 'codpessoa'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codtituloagrupamento' => '#',
			'codpessoa' => 'Pessoa',
			'GridTitulos' => 'Titulos',
			'emissao' => 'Emissão',
			'cancelamento' => 'Estornado',
			'observacao' => 'Observação',
			
			'parcelas' => 'Número de Parcelas',
			'primeira' => 'Dias Primeira Parcela',
			'demais'   => 'Dias Demais Parcelas',
			'codportador'   => 'Portador',
			'codfilial'   => 'Filial',
			'boleto'   => 'Emitir Boleto',
			
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		
		$criteria->compare('t.codtituloagrupamento', $this->codtituloagrupamento, false);
		if ($emissao_de = DateTime::createFromFormat("d/m/y",$this->emissao_de))
		{
			$criteria->addCondition('t.emissao >= :emissao_de');
			$criteria->params = array_merge($criteria->params, array(':emissao_de' => $emissao_de->format('Y-m-d').' 00:00:00.0'));
		}
		if ($emissao_ate = DateTime::createFromFormat("d/m/y",$this->emissao_ate))
		{
			$criteria->addCondition('t.emissao <= :emissao_ate');
			$criteria->params = array_merge($criteria->params, array(':emissao_ate' => $emissao_ate->format('Y-m-d').' 23:59:59.9'));
		}
		if ($criacao_de = DateTime::createFromFormat("d/m/y",$this->criacao_de))
		{
			$criteria->addCondition('t.criacao >= :criacao_de');
			$criteria->params = array_merge($criteria->params, array(':criacao_de' => $criacao_de->format('Y-m-d').' 00:00:00.0'));
		}
		if ($criacao_ate = DateTime::createFromFormat("d/m/y",$this->criacao_ate))
		{
			$criteria->addCondition('t.criacao <= :criacao_ate');
			$criteria->params = array_merge($criteria->params, array(':criacao_ate' => $criacao_ate->format('Y-m-d').' 23:59:59.9'));
		}
		
		$criteria->compare('t.codpessoa', $this->codpessoa, false);
		
		$criteria->with = array(
			'Pessoa' => array(
				'select' => 'fantasia'
			)
		);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array('defaultOrder'=>'t.emissao DESC, t.criacao DESC, "Pessoa".fantasia ASC'),
			'pagination'=>array('pageSize'=>20)
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TituloAgrupamento the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
		
	public function save($runValidation=true, $attributes=NULL)
	{
		//comeca transacao
		$trans = $this->dbConnection->beginTransaction();
		$novo = $this->isNewRecord;
		
		$ret = parent::save($runValidation, $attributes);

		if ($novo && $ret)
		{
		
			$titulos = array();

			$total = $this->calculaTotalGridTitulos();
			$gerencial = false;
			$fatura = array();

			$emissao = DateTime::createFromFormat('Y-m-d', $this->emissao);
			if (!$emissao)
				$emissao = DateTime::createFromFormat('d/m/Y', $this->emissao);

			foreach($this->GridTitulos["codtitulo"] as $codtitulo)
			{
				$titulo = Titulo::model()->findByPk($codtitulo);
				if ($titulo->gerencial)
					$gerencial = true;

				if (!empty($titulo->fatura))
					$fatura[] = $titulo->fatura;

				$ret = $titulo->adicionaMultaJurosDesconto(
					Yii::app()->format->unformatNumber($this->GridTitulos["multa"][$codtitulo]), 
					Yii::app()->format->unformatNumber($this->GridTitulos["juros"][$codtitulo]), 
					Yii::app()->format->unformatNumber($this->GridTitulos["desconto"][$codtitulo]), 
					$emissao->format('d/m/Y'), 
					$this->codportador,
					$this->codtituloagrupamento
				);

				if ($ret)
					$ret = $titulo->adicionaMovimento(
						TipoMovimentoTitulo::TIPO_AGRUPAMENTO,
						($titulo->operacao == "CR")?Yii::app()->format->unformatNumber($this->GridTitulos["total"][$codtitulo]):null,
						($titulo->operacao == "DB")?Yii::app()->format->unformatNumber($this->GridTitulos["total"][$codtitulo]):null,
						$emissao->format('d/m/Y'), 
						$this->codportador,
						$this->codtituloagrupamento
					);	


				if (!$ret)
				{
					$this->addError($this->tableSchema->primaryKey, 'Erro ao lancar multa no título!');
					$this->addErrors($titulo->getErrors());
					break;
				}

			}

			for ($i = 1; ($i <= sizeof($this->vencimentos)) && $ret; $i++)
			{

				$titulo = new Titulo('insert');
				$titulo->codtituloagrupamento = $this->codtituloagrupamento;
				$titulo->codtipotitulo = ($total<0)?TipoTitulo::AGRUPAMENTO_CREDITO:TipoTitulo::AGRUPAMENTO_DEBITO;
				$titulo->codfilial = $this->codfilial;
				$titulo->codportador = $this->codportador;
				$titulo->codpessoa = $this->codpessoa;
				$titulo->codcontacontabil = ContaContabil::AGRUPAMENTO;
				$titulo->numero = "A" . str_pad($this->codtituloagrupamento, 8, "0", STR_PAD_LEFT) . "-$i/" . sizeof($this->vencimentos);
				$titulo->fatura = substr(implode(", ", $fatura), 0, 50);
				$titulo->emissao = $emissao->format('d/m/Y');
				$titulo->transacao = $titulo->emissao;
				$titulo->vencimento = $this->vencimentos[$i-1];
				$titulo->vencimentooriginal = $titulo->vencimento;
				$titulo->valor = Yii::app()->format->unformatNumber($this->valores[$i-1]);
				$titulo->gerencial = $gerencial;
				$titulo->observacao = $this->observacao;
				$titulo->boleto = $this->boleto;

				$ret = $titulo->save();


				if (!$ret)
				{
					$this->addError($this->tableSchema->primaryKey, 'Erro ao gerar título!');
					$this->addErrors($titulo->getErrors());
					break;
				}
				else
				{
					$titulos[$i] =  $titulo;
					echo "<h3>Gerou Titulo {$titulo->codtitulo}</h3>";
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
	
	public function estorna()
	{
		$trans = $this->dbConnection->beginTransaction();

		$ret = true;
		
		//cancela todos os movimentos de titulo
		foreach ($this->MovimentoTitulos as $mov)
		{
			$ret = $mov->estorna();
			if (!$ret)
			{
				$this->addError("codmovimentotitulo", "Erro ao estornar movimento!");
				$this->addErrors($mov->getErrors());
				break;
			}
		}
		
		//se cancelou todos os movimentos, marca agrupamento como cancelado
		if ($ret)
		{
			$this->cancelamento = date('d/m/Y');
			$ret = $this->save();
		}
		
		//grava transacao em caso de sucesso
		if ($ret)
			$trans->commit();
		else
			$trans->rollback();
		
		return $ret;
	}
	
	protected function afterFind()
	{
		$ret = parent::afterFind();
		
		$this->valor = $this->debito-$this->credito;
		$this->operacao = ($this->valor<0)?"CR":"DB";
		$this->valor = abs($this->valor);
		
		return $ret;
	}
	
}

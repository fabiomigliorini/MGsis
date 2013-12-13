<?php
abstract class MGActiveRecord extends CActiveRecord
{
	
	/**
	* seta campos de alteracao e criacao automaticamente
	*/
	protected function beforeSave()
	{

		if($this->isNewRecord)
		{
			$codcoluna = $this->tableSchema->primaryKey;
			if (empty($this->$codcoluna))
			{
				$this->$codcoluna = Codigo::PegaProximo($codcoluna);
			}
		}
                		
		//volta data do formato brasileiro para formato Y-m-d
		foreach($this->metadata->tableSchema->columns as $columnName => $column)
		{
			/* se campo estiver vazio, vai para proximo */
			if (empty($this->$columnName) and ($this->$columnName <> "0"))
			{
				
				//if ($column->name == 'fornecedor') die($column->dbType);
				if ($column->dbType == 'boolean') 
					$this->$columnName = false;
				else
					$this->$columnName = null;
				continue;
			}
			
			/* DATA */
			if ($column->dbType == 'date')
			{
				$this->$columnName = date('Y-m-d',
					CDateTimeParser::parse($this->$columnName,
					Yii::app()->locale->getDateFormat('medium')));
			}
			/* DATA HORA */
			elseif ($column->dbType == 'timestamp without time zone')
			{
				$this->$columnName = date('Y-m-d H:i:s',
					CDateTimeParser::parse($this->$columnName,
						strtr(Yii::app()->locale->getDateTimeFormat()
								, array("{0}" => Yii::app()->locale->getTimeFormat('medium')
										, "{1}" => Yii::app()->locale->getDateFormat('medium')))
					));
			}
		}
		
		//descobre codigo do usuario conectado
		if(null !== Yii::app()->user)
			$codusuario=Yii::app()->user->id;
		else
			$codusuario=null;

		//seta campos de alteracao
		$this->codusuarioalteracao = $codusuario;
		$this->alteracao = date('Y-m-d H:i:s');

		//se for novo registro seta campos de criacao
		if($this->isNewRecord)
		{
			$this->codusuariocriacao = $this->codusuarioalteracao;
			$this->criacao = $this->alteracao;
		}

		return parent::beforeSave();

	}

	protected function afterFind()
	{
		// Formata datas no formato brasileiro
		foreach($this->metadata->tableSchema->columns as $columnName => $column)
		{           
			if (!strlen($this->$columnName)) continue;

			/* DATA */
			if ($column->dbType == 'date')
			{ 
				$this->$columnName = Yii::app()->dateFormatter->formatDateTime(
						CDateTimeParser::parse(
							$this->$columnName, 
							'yyyy-MM-dd'
						),
						'medium',null
					);
			}
			/* DATA HORA */
			elseif ($column->dbType == 'timestamp without time zone')
			{
				$this->$columnName = Yii::app()->dateFormatter->formatDateTime(
						CDateTimeParser::parse(
							$this->$columnName, 
							'yyyy-MM-dd hh:mm:ss'
						),
						'medium','medium'
					);
			}
		}
		return parent::afterFind();
	}	

	public function setAttributes($values,$safeOnly=true) 
	{
		if(!is_array($values)) return;
		$attributes=array_flip($safeOnly ? $this->getSafeAttributeNames() : $this->attributeNames());
		
		/* Volta Formato dos números */
		foreach($values as $name=>$value) 
		{
			if(isset($attributes[$name])) 
			{
				if ($column = $this->getTableSchema()->getColumn($name))
				{
					if (($column->dbType == 'double precision') or (stripos($column->dbType, 'numeric') !== false))
					{
						if ($column->name == 'cnpj')
							$value = Yii::app()->format->numeroLimpo($value); 
						else
							$value = Yii::app()->format->unformatNumber($value); 
					}
				}
				$this->$name=$value;
			}
			elseif($safeOnly)
				$this->onUnsafeAttribute($name,$value);
		}
	}
	
}
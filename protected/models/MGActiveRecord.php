<?php
abstract class MGActiveRecord extends CActiveRecord
{
	/**
	* seta campos de alteracao e criacao automaticamente
	*/
	protected function beforeSave()
	{
		//volta data do formato brasileiro para formato Y-m-d
		foreach($this->metadata->tableSchema->columns as $columnName => $column)
		{
			if ($column->dbType == 'date')
			{
				$this->$columnName = date('Y-m-d',
					CDateTimeParser::parse($this->$columnName,
					Yii::app()->locale->getDateFormat('medium')));
			}
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
			$id=Yii::app()->user->id;
		else
			$id=1;
		
		//forca 1 ate configurar o login
		$id = 1;

		//seta campos de alteracao
		$this->codusuarioalteracao=$id;
		$this->alteracao = date('Y-m-d H:i:s');

		//se for novo registro seta campos de criacao
		if($this->isNewRecord)
		{
			$this->codusuariocriacao=$id;
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
	
}

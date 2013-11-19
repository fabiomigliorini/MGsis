<?php
abstract class MGActiveRecord extends CActiveRecord
{
	/**
	* seta campos de alteracao e criacao automaticamente
	*/
	protected function beforeSave()
	{
		
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
	
}

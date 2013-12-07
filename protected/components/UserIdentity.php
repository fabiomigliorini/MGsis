<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	
	private $_id;
	
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	/*
	public function authenticate()
	{
		$users=array(
			// username => password
			'demo'=>'demo',
			'admin'=>'admin',
		);
		if(!isset($users[$this->username]))
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		elseif($users[$this->username]!==$this->password)
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else
			$this->errorCode=self::ERROR_NONE;
		return !$this->errorCode;
	}
	 * 
	 */
	public function authenticate()
	{
		$usuario = Usuario::model()->find('usuario ILIKE ?', array($this->username));
		if ($usuario === null)
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		else if (!$usuario->validaSenha($this->password))
			//$this->errorCode = self::ERROR_NONE;
			$this->errorCode = self::ERROR_PASSWORD_INVALID;
		else
		{
			$this->_id = $usuario->codusuario;
			$this->username = $usuario->usuario;
			$this->setState('ultimoAcesso', $usuario->ultimoacesso);
			$this->setState('codusuario', $this->_id);
			$usuario->saveAttributes(array('ultimoacesso'=>	date('Y-m-d H:i:s')));
			
			$user = Yii::app()->getComponent('user');
			$user->setFlash('info', "Olá <strong>{$this->username}</strong>, você havia acessado o sistema pela última vez em <strong>{$this->getState('ultimoAcesso')}</strong>!");

			$this->errorCode = self::ERROR_NONE;
		}
		return $this->errorCode == self::ERROR_NONE;
	}
	
	public function getId()
	{
		return $this->_id;
	}
}
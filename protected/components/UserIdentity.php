<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    public $oauth;

    const ERROR_USERNAME_INACTIVE = 999;

    private $_id;

    public function __construct($username, $password, $oauth = false)
    {
        $this->username = $username;
        $this->password = $password;
        $this->oauth = $oauth;
    }

    public function authenticate()
    {
        $usuario = Usuario::model()->find('usuario ILIKE ?', array($this->username));
        if ($usuario === null) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
            return false;
        }

        if (!$this->oauth) {
            if (!$usuario->validaSenha($this->password)) {
                $this->errorCode = self::ERROR_PASSWORD_INVALID;
                return false;
            }
        }

        if (!empty($usuario->inativo)) {
            $this->errorCode = self::ERROR_USERNAME_INACTIVE;
            return false;
        }

        $this->_id = $usuario->codusuario;
        $this->username = $usuario->usuario;
        $this->setState('ultimoAcesso', $usuario->ultimoacesso);
        $this->setState('codusuario', $this->_id);
        //TODO: pegar da tabela de usuario
        $this->setState('impressoraMatricial', $usuario->impressoramatricial);
        $this->setState('impressoraTermica', $usuario->impressoratermica);
        $this->setState('codportador', $usuario->codportador);
        $this->setState('codfilial', $usuario->codfilial);
        $usuario->saveAttributes(array('ultimoacesso' =>    date('Y-m-d H:i:s')));
        $user = Yii::app()->getComponent('user');
        $user->setFlash('info', "Olá <strong>{$this->username}</strong>, você havia acessado o sistema pela última vez em <strong>{$this->getState('ultimoAcesso')}</strong>!");
        $this->errorCode = self::ERROR_NONE;

        return true;
    }

    public function getId()
    {
        return $this->_id;
    }
}

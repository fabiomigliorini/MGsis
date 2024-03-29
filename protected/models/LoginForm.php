<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
	public $username;
	public $password;
    public $oauth = false;
	public $rememberMe = true;

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('username, password', 'required'),
			// rememberMe needs to be a boolean
			array('oauth', 'boolean'),
			array('rememberMe', 'boolean'),
			// password needs to be authenticated
			array('password', 'authenticate'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'rememberMe'=>'Lembrar',
			'username'=>'Usuário',
			'password'=>'Senha',
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			$this->_identity=new UserIdentity(
                $this->username,
                $this->password,
                $this->oauth
            );
			if(!$this->_identity->authenticate())
			{
				switch ($this->_identity->errorCode) {
					case UserIdentity::ERROR_USERNAME_INVALID:
						$this->addError('username','Usuário incorreto.');
						break;
					case UserIdentity::ERROR_PASSWORD_INVALID:
						$this->addError('password','Senha incorreta.');
						break;
					case UserIdentity::ERROR_USERNAME_INACTIVE:
						$this->addError('username','Usuário inativo.');
						break;
					default:
						$this->addError('username','Usuário ou senha inválidos.');
						break;
				}
			}
		}
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		if($this->_identity===null)
		{
			$this->_identity=new UserIdentity(
                $this->username,
                $this->password,
                $this->oauth
            );
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			//$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
			$duration=$this->rememberMe ? 3600*3*1 : 0; // 3 Horas
			Yii::app()->user->login($this->_identity,$duration);
			return true;
		}
		else
			return false;
	}
}

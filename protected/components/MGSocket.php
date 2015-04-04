<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MGSocket
 *
 * @author Fabio Migliorini
 * @property string  $servidor  IP do Servidor
 * @property string  $porta     Porta do Servidor
 * @property string  $errno     Numero do Erro de conexão
 * @property string  $errstr    Descrição do Erro de conexão
 * @property integer $timeout   Tempo maximo de espera para retorno (segundos)
 * @property string  $retorno   String de retorno da leitura
 * @property string  $_fp       Ponteiro da conexão
 */
class MGSocket 
{
	public $servidor;
	public $porta;
	
	public $errno;
	public $errstr;
	
	public $timeout = 10;
	
	public $retorno;
	
	public $debug = false;
	
	protected $_fp;
	
	public function __construct($servidor = NULL, $porta = NULL)
	{
		if (!empty($servidor))
			$this->servidor = $servidor;
		
		if (!empty($porta))
			$this->porta = $porta;
		
	}
	
	public function conectado($conectar = true)
	{
		if ($conectar)
			if (!is_resource($this->_fp))
				$this->conectar();
			
		return is_resource($this->_fp);
	}
	
	public function conectar()
	{
		//caso esteja conectado desconectar
		if ($this->conectado(false))
			$this->desconectar();
		
		//abre conexao
		if ($this->_fp = @fsockopen("tcp://$this->servidor", $this->porta, $this->errno, $this->errstr, 1))
		{
			stream_set_blocking($this->_fp, false);
			$this->recebe(1);
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function desconectar()
	{
		if (!$this->conectado(false))
			return false;
		
		fclose($this->_fp);
		$this->retorno = "Sem conexão com o monitor de NFe!\n";
		
		return true;
	}
	
	/**
	 * Recebe os dados do socket
	 * @return boolean
	 */
	public function recebe($timeout = null)
	{
		if (empty($timeout))
			$timeout = $this->timeout;
		
		//retorna se nao estiver conectado
		if (!$this->conectado())
			return false;
		
		//limpa variavel de retorno
		$this->retorno = NULL;
		
		//marca inicio
		$inicio = microtime(true);
		$leiturasVazias = 0;
		do 
		{
			
			// espera 0.5 segundo
			usleep(500000);
			
			//le o buffer
			$linha = fgets($this->_fp);
			
			if (!empty($linha))
			{
				$this->retorno .= $linha;
				$leiturasVazias	= 0;
			}
			else
				$leiturasVazias++;
			
			if (strpos($linha, chr(3)) !== false)
				return true;
			
			$dispendido = microtime(true) - $inicio;
			if ($dispendido > $timeout)
			{
				$this->retorno = "ERRO: Monitor não responde (Timeout)!\n" . $this->retorno;
				return false;
			}
			
			if ($leiturasVazias>100)
			{
				$this->retorno = "ERRO: Monitor não responde (100 Leituras Vazias)!\n" . $this->retorno;
				return false;
			}
			
		} while (true);

		return false;
	}
	
	public function envia($str)
	{
	
		if (!$this->conectado())
			return false;

		//quebra string por linhas
		$arr = explode("\n", $str . chr(3));
		$arr[] = chr(13).chr(10).chr(46).chr(13).chr(10);
		
		//envia uma linha por vez pra nao estourar buffer do socket
		foreach ($arr as $str)
		{
			//devolve a quebra de linha para a string
			$str .= "\n";
			
			//escreve
			if (fwrite($this->_fp, $str, strlen($str)) === FALSE)
				return false;

			//forca envio da linha
			fflush($this->_fp);
		}

		return true;
		
	}
	
	public function __destruct()
	{
		$this->desconectar();
	}
}

?>
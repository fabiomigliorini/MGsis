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
 * @property string $servidor IP do Servidor
 * @property string $porta    Porta do Servidor
 * @property string $errno    Numero do Erro de conexão
 * @property string $errstr   Descrição do Erro de conexão
 * @property string $retorno  String de retorno da leitura
 * @property string $_fp      Ponteiro da conexão
 */
class MGSocket 
{
	public $servidor;
	public $porta;
	
	public $errno;
	public $errstr;
	
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
			stream_set_blocking($this->_fp, FALSE);
			$this->recebe();
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
		return true;
	}
	
	public function recebe($timeout = 10)
	{
		//retorna se nao estiver conectado
		if (!$this->conectado())
			return false;
		
		//limpa variavel de retorno
		$this->retorno = NULL;
		
		//marca inicio
		$inicio = microtime(true);
		$leiturasVazias = 1;
		
		do 
		{
			//le o buffer
			$linha = fgets($this->_fp);
			
			//se linha lida nao estiver em branco
			if (!empty($linha))
			{
				
				//se for final de fim de texto ASCII 3 para a execucao
				if ((substr($linha, 0, 1) == chr(3)) && !empty($this->retorno))
				{
					return true;
				}
				else
				{
					//concatena linha ao retorno
					$this->retorno .= $linha;
				}
				
				//zera contador de leituras vazias
				$leiturasVazias = 1;
			}
			else
			{
				//incrementa contador de leituras vazias
				$leiturasVazias++;
				
				//se ainda não veio nenhum retorno, espera 0.1 segundo
				if (empty($this->retorno))
					usleep(100000);
			}
			
			$dispendido = microtime(true) - $inicio;
			
			if ((!empty($this->retorno)) && ($leiturasVazias > 5))
			{
				false;
			}
			
		} while ($dispendido < $timeout);

		return false;
	}
	
	public function envia($str)
	{
		
		if ($this->debug)
			echo "<HR>ENVIANDO @$str@";
		
		if (!$this->conectado())
			return false;
		
		if (fwrite($this->_fp, $str, strlen($str)) === FALSE)
			return false;
		
		fflush($this->_fp);
		
		return true;
		
	}
	
	public function __destruct()
	{
		$this->desconectar();
	}
}

?>
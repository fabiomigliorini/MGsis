<?php

/*
 * Condensado: 137 Colunas
 * Normal:      80 Colunas
 * Large:       40 Colunas
 * 
 */

class MGJuros
{

	public $de;
	public $ate;
	public $percentualJuros = 4;
	public $percentualMulta = 2;
	
	public $diasTolerancia = 3;
	public $diasAtraso = 0;	
	
	public $valorOriginal = 0;
	public $valorJuros;
	public $valorMulta;
	public $valorTotal;
	
	function __construct($params = array()) 
	{
		foreach ($params as $param => $valor)
			$this->$param = $valor;
		
		if (empty($this->de))
			$this->de = date('d/m/Y');
		
		if (empty($this->ate))
			$this->ate = date('d/m/Y');
		
		$this->calcula();
	}
	
    public function __set($name, $value)
    {
        echo "Setting '$name' to '$value'\n";
        $this->data[$name] = $value;
    }
	
	private function _calculaDiasAtraso()
	{
		$de = DateTime::createFromFormat("d/m/Y",$this->de);
		$ate = DateTime::createFromFormat("d/m/Y",$this->ate);
		$atraso = $de->diff($ate);
		$this->diasAtraso = $atraso->days;
		if ($atraso->invert)
			$this->diasAtraso = $this->diasAtraso * -1;
	}
	
	private function _calculaJuro()
	{
		if ($this->_atrasado())
			$this->valorJuros = round($this->valorOriginal * (($this->percentualJuros/30)/100) * $this->diasAtraso, 2);
		else
			$this->valorJuros = 0;
	}
	
	private function _calculaMulta()
	{
		if ($this->_atrasado())
			$this->valorMulta = round($this->valorOriginal * (($this->percentualMulta)/100), 2);
		else
			$this->valorMulta = 0;
	}
	
	private function _atrasado()
	{
		return (($this->diasAtraso > $this->diasTolerancia) && $this->valorOriginal > 0);
	}
	
	private function _calculaTotal()
	{
		$this->valorTotal = $this->valorJuros + $this->valorMulta + $this->valorOriginal;
	}
	
	public function calcula ()
	{
		$this->_calculaDiasAtraso();
		$this->_calculaJuro();
		$this->_calculaMulta();
		$this->_calculaTotal();
	}
	
}

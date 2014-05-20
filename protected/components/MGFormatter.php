<?php
class MGFormatter extends CFormatter
{
    /**
     * @var array the format used to format a number with PHP number_format() function.
     * Three elements may be specified: "decimals", "decimalSeparator" and 
     * "thousandSeparator". They correspond to the number of digits after 
     * the decimal point, the character displayed as the decimal point,
     * and the thousands separator character.
     * new: override default value: 2 decimals, a comma (,) before the decimals 
     * and no separator between groups of thousands
    */
    public $numberFormat=array('decimals'=>2, 'decimalSeparator'=>',', 'thousandSeparator'=>'.');
 
    /**
     * Formats the value as a number using PHP number_format() function.
     * new: if the given $value is null/empty, return null/empty string
     * @param mixed $value the value to be formatted
     * @return string the formatted result
     * @see numberFormat
     */
	public function formatNumber($value, $decimals = null) 
	{
		if ($value === null) return null;    // new
		if ($value === '') return '';        // new
		if ($decimals === null) $decimals = $this->numberFormat['decimals'];
		return number_format($value, $decimals, $this->numberFormat['decimalSeparator'], $this->numberFormat['thousandSeparator']);
	}
 
    /*
     * new function unformatNumber():
     * turns the given formatted number (string) into a float
     * @param string $formatted_number A formatted number 
     * (usually formatted with the formatNumber() function)
     * @return float the 'unformatted' number
     */
    public function unformatNumber($formatted_number) 
	{
        if ($formatted_number === null) return null;
        if ($formatted_number === '') return '';
        //if(is_float($formatted_number)) return $formatted_number; // only 'unformat' if parameter is not float already
		if (filter_var($formatted_number, FILTER_VALIDATE_FLOAT)!==false) return $formatted_number; // only 'unformat' if parameter is not float already

        $value = str_replace($this->numberFormat['thousandSeparator'], '', $formatted_number);
        $value = str_replace($this->numberFormat['decimalSeparator'], '.', $value);
		
		//if (!preg_match('/^[0-9,]+$/i', $formatted_number)) return $formatted_number; // only unformat if parameter includes numbers or comma
		
        return (float) $value;
    }
	
	public function numeroLimpo($string)
	{
		 return preg_replace( '/[^0-9]/', '', $string);
	}
	
	function formataCnpjCpf ($string, $fisica = null)
	{
		
		if ($fisica == null) {
			$string = self::numeroLimpo($string);
			if (strlen($string) <= 11)
				$fisica = true;
			else
				$fisica = false;
		}

		if ($fisica)
			return self::formataPorMascara($string, '###.###.###-##');
		else
			return self::formataPorMascara($string, '##.###.###/####-##');
	}
	
	function formataPorMascara($string, $mascara, $somenteNumeros = true)
	{
		if ($somenteNumeros)
			$string = self::numeroLimpo($string);
		/* @var $caracteres int */
		$caracteres = substr_count($mascara, '#');
		$string = str_pad($string, $caracteres, "0", STR_PAD_LEFT);
		$indice = -1;
		for ($i=0; $i < strlen($mascara); $i++):
			if ($mascara[$i]=='#') $mascara[$i] = $string[++$indice];
		endfor;
		return $mascara;
		
	}
	
	function formataInscricaoEstadual ($string, $siglaestado)
	{
		$mascara = array(
			'AC' => '##.###.###/###-##',
			'AL' => '#########',
			'AP' => '#########',
			'AM' => '##.###.###-#',
			'BA' => '#######-##',
			'CE' => '########-#',
			'DF' => '###########-##',
			'ES' => '###.###.##-#',
			'GO' => '##.###.###-#',
			'MA' => '#########',
			'MT' => '##.###.###-#',
			'MS' => '#########',
			'MG' => '###.###.###/####',
			'PA' => '##-######-#',
			'PB' => '########-#',
			'PR' => '########-##',
			'PE' => '##.#.###.#######-#',
			'PI' => '#########',
			'RJ' => '##.###.##-#',
			'RN' => '##.###.###-#',
			'RS' => '###-#######',
			'RO' => '###.#####-#',
			'RR' => '########-#',
			'SC' => '###.###.###',
			'SP' => '###.###.###.###',
			'SE' => '#########-#',
			'TO' => '###########',			
		);
		
		if (!array_key_exists($siglaestado, $mascara))
			return $string;
		else
			return self::formataPorMascara($string, $mascara[$siglaestado]);
	}
	
	public function formataCep ($string)
	{
		return self::formataPorMascara($string, "##.###-###");
	}
	
	public function formataNumeroNota ($emitida, $serie, $numero)
	{
		return (($emitida)?"N-":"T-") . $serie . "-" . self::formataPorMascara($numero, "########");
	}
	
	public function formataNcm ($string)
	{
		$string = str_pad(self::numeroLimpo($string), 8, "*", STR_PAD_RIGHT);
		return self::formataPorMascara($string, "####.##.##", false);
	}
	
	public function formataCodigo ($string, $digitos = 8)
	{
		return "#" . str_pad($string, $digitos, "0", STR_PAD_LEFT);
	}
	
	public function formataEndereco($endereco = null, $numero = null, $complemento = null, $bairro = null, $cidade = null, $estado = null, $cep = null)
	{
		
		$retorno = $endereco;
		
		if (!empty($numero))
			$retorno .= ', ' . $numero;
		
		$q = $retorno;
		
		if (!empty($complemento))
			$retorno .= ' - ' . $complemento;
		
		if (!empty($bairro))
			$retorno .= ' - ' . $bairro;
		
		if (!empty($cidade))
		{
			$retorno .= ' - ' . $cidade;
			$q .= ' - ' . $cidade;
		}
		
		if (!empty($estado))
		{
			$retorno .= ' / ' . $estado;
			$q .= ' / ' . $estado;
		}
		
		if (!empty($cep))
			$retorno .= ' - ' . self::formataCep($cep);
		
		$q = urlencode($q);
		
		return "<a href='http://maps.google.com/maps?q=$q' target='_blank'>" . CHtml::encode($retorno) . "</a>";
	}
	
	public function removeAcentos ($string)
	{
		$array1 = array( "á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç", "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç" ); 
		$array2 = array( "a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c", "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C" ); 
		return str_replace( $array1, $array2, $string); 	
	}
	
	function formataValorPorExtenso($valor = 0, $maiusculas = false) 
	{

		$singular = array("centavo", "real", "mil", "milhao", "bilhao", "trilhao", "quatrilhao");
		$plural = array("centavos", "reais", "mil", "milhoes", "bilhoes", "trilhoes", "quatrilhoes");

		$c = array("", "cem", "duzentos", "trezentos", "quatrocentos", "quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
		$d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta", "sessenta", "setenta", "oitenta", "noventa");
		$d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze", "dezesseis", "dezesete", "dezoito", "dezenove");
		$u = array("", "um", "dois", "tres", "quatro", "cinco", "seis",	"sete", "oito", "nove");

		$z = 0;
		$rt = "";

		$valor = number_format($valor, 2, ".", ".");
		$inteiro = explode(".", $valor);
		for($i=0;$i<count($inteiro);$i++)
			for($ii=strlen($inteiro[$i]);$ii<3;$ii++)
				$inteiro[$i] = "0".$inteiro[$i];

		$fim = count($inteiro) - ($inteiro[count($inteiro)-1] > 0 ? 1 : 2);
		for ($i=0;$i<count($inteiro);$i++) 
		{
			$valor = $inteiro[$i];
			$rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
			$rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
			$ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";

			$r = $rc.(($rc && ($rd || $ru)) ? " e " : "").$rd.(($rd &&
			$ru) ? " e " : "").$ru;
			$t = count($inteiro)-1-$i;
			$r .= $r ? " ".($valor > 1 ? $plural[$t] : $singular[$t]) : "";
			if ($valor == "000") $z++; elseif ($z > 0) $z--;
			if (($t==1) && ($z>0) && ($inteiro[0] > 0)) $r .= (($z>1) ? " de " : "").$plural[$t];
			if ($r) $rt = $rt . ((($i > 0) && ($i <= $fim) &&
			($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
		}

		$rt = trim($rt);
		
		if(!$maiusculas){
			return($rt ? $rt : "zero");
		} else {

		if ($rt) $rt=ereg_replace(" E "," e ",ucwords($rt));
			return (($rt) ? ($rt) : "Zero");
		}

	}
	
	function formataDataPorExtenso ($data = false)
	{
		
		if ($data)
		{
			$data = date('Y-m-d', CDateTimeParser::parse($data, Yii::app()->locale->getDateFormat('medium')));
			$mes = date('m', strtotime($data));
		}
		else
		{
			$mes = date('m');
			$data = date('Y-m-d');
		}
		$meses = array
		(
			'01' => 'Janeiro',
			'02' => 'Fevereiro',
			'03' => 'Marco',
			'04' => 'Abril',
			'05' => 'Maio',
			'06' => 'Junho',
			'07' => 'Julho',
			'08' => 'Agosto',
			'09' => 'Setembro',
			'10' => 'Outubro',
			'11' => 'Novembro',
			'12' => 'Dezembro'
		);
		$dias = array
		(
			0 => 'Domingo',
			1 => 'Segunda-feira',
			2 => 'Terca-feira',
			3 => 'Quarta-feira',
			4 => 'Quinta-feira',
			5 => 'Sexta-feira',
			6 => 'Sabado'
		);
		return $dias[date('w', strtotime($data))] . ', ' . date('d', strtotime($data)) . ' de ' . $meses[$mes] . ' de ' . date('Y', strtotime($data));
	}
	
}

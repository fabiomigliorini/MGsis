<?php

/*
 * Condensado: 137 Colunas
 * Normal:      80 Colunas
 * Large:       40 Colunas
 * 
 */

class MGEscPrint
{
	
	private $_conteudoSecao;
	private $_impressora = "EscritorioEpson";
	private $_comandos = array();
	private $_colunas = 137;
	private $_linhas = 31;
	private $_linhaSecao;
	private $_cabecalho = "";
	
	function __construct($impressora = null, $colunas = null, $linhas = null) 
	{
		$this->_conteudoSecao =
			array(
				"documento" => "",
				"cabecalho" => "",
				"rodape"    => "",
			);
		
		$this->_linhaSecao = 
			array(
				"documento" => 1,
				"cabecalho" => 1,
				"rodape"    => 1,
			);
		
		if ($impressora != null)
			$this->_impressora = $impressora;
		
		if ($colunas != null)
			$this->_colunas = $colunas;
		
		if ($linhas != null)
			$this->_linhas = $linhas;
		
		$this->_comandos = 
			array(
				"EscDraft"           => array(Chr(27)."x0",   ""     ), //Modo Draft
				"EscNLQ"             => array(Chr(27)."x1",   ""     ), //Modo NLQ
				"EscNLQRoman"        => array(Chr(27)."k0",   ""     ), //Fonte NLQ "Roman"
				"EscNLQSansSerif"    => array(Chr(27)."k1",   ""     ), //Fonte NLQ "SansSerif"
				"Esc10cpp"           => array(Chr(27)."P",    ""     ), //Espaçamento horizontal em 10cpp
				"Esc12cpp"           => array(Chr(27)."M",    ""     ), //Espaçamento horizontal em 12cpp
				"EscCondensedOn"     => array(Chr(15),        ""     ), //Ativa o modo condensado
				"EscCondensedOff"    => array(Chr(18),        ""     ), //Desativa o modo condensado
				"EscLargeOn"         => array(Chr(27)."W1",   "<p style='font-size:200%'>"     ), //Ativa o modo expandido
				"EscLargeOff"        => array(Chr(27)."W0",   "</p>"     ), //Desativa o modo expandido
				"EscBoldOn"          => array(Chr(27)."E",   "<b>"   ), //Ativa o modo negrito
				"EscBoldOff"         => array(Chr(27)."F",   "</b>"  ), //Desativa o modo negrito
				"EscItalicOn"        => array(Chr(27)."4",   "<i>"   ), //Ativa o modo itálico
				"EscItalicOff"       => array(Chr(27)."5",   "</i>"  ), //Desativa o modo itálico
				"EscUnderlineOn"     => array(Chr(27)."-1",  "<u>"   ), //Ativa o modo sublinhado
				"EscUnderlineOff"    => array(Chr(27)."-0",  "</u>"  ), //Desativa o modo sublinhado
				"EscDblStrikeOn"     => array(Chr(27)."G",   "<b>"   ), //Ativa o modo de passada dupla
				"EscDblStrikeOff"    => array(Chr(27)."H",   "</b>"  ), //Desativa o modo de passada dupla
				"EscSupScriptOn"     => array(Chr(27)."S1",  ""      ), //Ativa o modo sobrescrito
				"EscSubScriptOn"     => array(Chr(27)."S0",  ""      ), //Ativa o modo subescrito
				"EscScriptOff"       => array(Chr(27)."T",   ""      ), //Desativa os modos sobrescrito e subescrito
				
				//Controle de página 
				"Esc6lpp"            => array(Chr(27)."2",   ""      ), //Espaçamento vertical de 6 linhas por polegada
				"Esc8lpp"            => array(Chr(27)."0",   ""      ), //Espaçamento vertical de 8 linhas por polegada
				"EscMarginLeft"      => array(Chr(27)."l",   ""      ), //Margem esquerda, onde "?"
				"EscMarginRight"     => array(Chr(27)."Q",   ""      ), //Margem direita, onde "?"
				"EscPaperSize"       => array(Chr(27)."C",   ""      ), //Tamanho da página, onde "?"
				"EscAutoNewPageOn"   => array(Chr(27)."N",   ""      ), //Ativa o salto sobre o picote, onde "?"
				"EscAutoNewPageOff"  => array(Chr(27)."O",   ""      ), //Desativa o salto sobre o picote
				
				//Controle da impressora
				"EscReset"           => array(Chr(27)."@",   ""  ), //Inicializa a impressora (Reset)
				"EscLF"              => array(Chr(10),       "\n"    ), //Avança uma linha
				"EscFF"              => array(Chr(12),       "<hr style='page-break-before: always;'>"  ), //Avança uma página
				"EscCR"              => array(Chr(13),       ""      ), //Retorno do carro
				
			);
		$this->comando("Reset");
	}
	
	public function limpaSecao($secao)
	{
		$this->_conteudoSecao[$secao] = "";
		$this->_linhaSecao[$secao] = "";
	}
	
	public function imprimir()
	{
		$this->comando("FF");
		$arquivo = tempnam(sys_get_temp_dir(), "MGEscPrint");
		$handle = fopen($arquivo, "w");
		fwrite($handle, $this->_conteudoSecao["documento"]);
		fclose($handle);
		return exec("lpr -P {$this->_impressora} {$arquivo}");		
		unlink($file);
	}
	
	public function converteHtml()
	{
		$html = htmlentities($this->_conteudoSecao["documento"]);
		foreach ($this->_comandos as $key => $value)
		{
			$html = str_replace($value[0], $value[1], $html);
		}
		return $html;
	}
	
	public function adicionaLinha($texto, $secao = "documento", $pad_length = null, $pad_type = STR_PAD_RIGHT, $pad_string = " ")
	{
		$this->adicionaTexto($texto, $secao, $pad_length, $pad_type, $pad_string);
		$this->comando("LF", $secao);
	}

	public function adicionaTexto($texto, $secao = "documento", $pad_length = null, $pad_type = STR_PAD_RIGHT, $pad_string = " ")
	{
		if (empty($this->_conteudoSecao[$secao]))
			$this->_conteudoSecao[$secao] = "";
		
		//adiciona espacos
		if ($pad_length != null)
		{
			//se a string for maior que o tamanho corta
			if (strlen($texto) >= $pad_length)
				if ($pad_type == STR_PAD_LEFT)
					$texto = substr($texto, strlen($texto)-$pad_length,$pad_length); 
				else
					$texto = substr($texto, 0, $pad_length); 
			else
				$texto = str_pad ($texto, $pad_length, $pad_string, $pad_type);
		}
		
		$this->_conteudoSecao[$secao] .= $texto;
	}
	
	public function codigoComando ($comando)
	{
		return $this->_comandos["Esc" . $comando][0];		
	}
	
	public function cabecalho()
	{
		$this->_conteudoSecao["documento"] .= $this->_conteudoSecao["cabecalho"];
		$this->_linhaSecao["documento"] += $this->_linhaSecao["cabecalho"];
	}
	
	public function comando($comando, $secao = "documento")
	{
		//controle de numera da linha
		switch ($comando)
		{
			case "FF":
				$this->_linhaSecao[$secao] = 1;
				break;
			case "LF":
				$this->_linhaSecao[$secao]++;
				break;	
		}
		
		//adiciona comando
		$this->adicionaTexto($this->codigoComando($comando), $secao);
		
		//se estourou linhas da pagina faz quebra de pagina
		if ($this->_linhaSecao[$secao] > $this->_linhas+1)
		{
			//echo "quebrando antes da linha {$this->_linhaSecao[$secao]} \n";
			$this->comando("FF");
			$this->cabecalho();
		}
	}
	
}

/*
echo "<pre>\n\nTeste:\n\n";
$teste = new MGEscPrint();

$teste->comando("6lpp");
$teste->comando("Draft");
$teste->comando("CondensedOn");

$teste->adicionaLinha("                        Cabecalho 1", "cabecalho");
$teste->adicionaLinha("                        Cabecalho 2", "cabecalho");
$teste->cabecalho();
$teste->limpaSecao("cabecalho");
$teste->adicionaLinha("                        Cabecalho 3", "cabecalho");
$teste->cabecalho();


for ($i=1; $i <= 100; $i++)
{
	$teste->adicionaLinha("                        Linha " . $i);
}
//$teste->limpaSecao("documento");
//echo $teste->imprimir();
echo $teste->converteHtml();
*/
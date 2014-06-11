<pre>
<?php

require "MGSocket.php";
require "MGAcbrNfeMonitor.php";
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/*
$fp = fsockopen("tcp://10.0.1.198", 3436, $errno, $errstr);
stream_set_blocking($fp, FALSE); 

if (!$fp) {
    echo "ERRO: $errno - $errstr<br />\n";
} else {
    //echo fread($fp, 26);
	sleep(1);

	$str = "NFE.Ativo\r\n.\r\n";
	fputs($fp, $str, strlen($str));
	
	sleep(1);
	
	while ($line = fgets($fp)) 
		echo $line;
	
    fclose($fp);
}
 * 
 */
error_reporting(E_ALL);
//set_time_limit(3);

$mgs = new MGAcbrNfeMonitor("10.0.1.198", 3436);
//echo "<hr>";
//print_r($mgs);
//echo "<hr>";
echo "<hr>";
echo $mgs->retorno;
echo "<hr>";

echo "<hr>";
echo "<h3>Ativo</h3>";
if ($mgs->envia("NFE.Ativo\r\n.\r\n"))
{
	if ($mgs->recebe() === FALSE)
		echo "Erro ao receber\n";
	else
		echo $mgs->retorno;
}
else
{
	echo "Erro ao enviar";
}
echo "<hr>";

echo "<hr>";
echo "<h3>StatusServico</h3>";
if ($mgs->envia("NFE.StatusServico\r\n.\r\n"))
{
	if ($mgs->recebe(1000000) === FALSE)
		echo "Erro ao receber\n";
	else
		echo $mgs->retorno;
}
else
{
	echo "Erro ao enviar";
}
echo "<hr>";

echo "<hr>";
echo "<h3>Ativo</h3>";
if ($mgs->envia("NFE.Ativo\r\n.\r\n"))
{
	if ($mgs->recebe() === FALSE)
		echo "Erro ao receber\n";
	else
		echo $mgs->retorno;
}
else
{
	echo "Erro ao enviar";
}
echo "<hr>";

flush();

?>
</pre>
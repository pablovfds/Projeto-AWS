<?php
header("Content-Type: text/html; charset=iso-8859-l");
$servidor = "equipe4servidor.database.windows.net";
$usuario = "equipe4Admin";
$banco = "equipe4database";
$senha = "senha123*";
//Não alterar abaixo:
//$conmsql = mssql_connect($servidor.":1433",$usuario,$senha);
$conmssql = mssql_connect($servidor, $usario,$senha) or die('falha na conexao');

$db = mssql_select_db($banco,$conmssql);
if (!$db){
	echo("Nao foi possivel conectar ao banco MSSQL");
	die();
}
echo 'conexao estabelecida';
?>

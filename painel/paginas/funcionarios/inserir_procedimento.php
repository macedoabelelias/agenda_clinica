<?php 
$tabela = 'func_proc';
require_once("../../../conexao.php");

$procedimento = $_POST['procedimento'];
$funcionario = $_POST['id'];

//validacao email
$query = $pdo->query("SELECT * from $tabela where funcionario = '$funcionario' and procedimento = '$procedimento'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
if(@count($res) > 0){
	echo 'Procedimento já Inserido!';
	exit();
}



$pdo->query("INSERT INTO $tabela SET procedimento = '$procedimento', funcionario = '$funcionario' ");
	
echo 'Salvo com Sucesso';
 ?>
<?php 
$tabela = 'agendamentos';
require_once("../../../conexao.php");

$id = $_POST['id_agd'];
$convenio = $_POST['convenio'];

$query2 = $pdo->query("SELECT * FROM agendamentos where id = '$id'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$procedimento = $res2[0]['servico'];

$query2 = $pdo->query("SELECT * FROM procedimentos where id = '$procedimento'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$nome_serv = $res2[0]['nome'];
$valor_serv = $res2[0]['valor'];

$query2 = $pdo->query("SELECT * FROM convenios where id = '$convenio'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
	$comissao = $res2[0]['comissao'];
}else{
	$comissao = 100;
}

if($comissao == ""){
	$comissao = 100;
}

$valor_final = $valor_serv - $valor_serv * $comissao / 100;
$valor_final_clinica = $valor_serv - $valor_final;

echo $valor_final_clinica;

?>
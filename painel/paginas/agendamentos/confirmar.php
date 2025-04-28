<?php 
$tabela = 'agendamentos';
require_once("../../../conexao.php");

$id = $_POST['id'];

$pdo->query("UPDATE $tabela SET status = 'Confirmado' where id = '$id'");

echo 'Confirmado com Sucesso';

?>
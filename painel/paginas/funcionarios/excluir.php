<?php 
$tabela = 'usuarios';
require_once("../../../conexao.php");

$id = $_POST['id'];

@session_start();
if($_SESSION['nivel'] != 'Administrador' || $_SESSION['nivel'] != 'Gerente'){
	echo 'Somente um Administrador ou um Gerente pode excluir um Funcionário!';
	exit();
}

$query = $pdo->query("SELECT * FROM $tabela where id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$foto = $res[0]['foto'];

if($foto != "sem-foto.jpg"){
	@unlink('../../images/perfil/'.$foto);
}

$pdo->query("DELETE FROM $tabela WHERE id = '$id' ");
echo 'Excluído com Sucesso';
?>
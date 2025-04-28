<?php 
$tabela = 'procedimentos';
require_once("../../../conexao.php");

$nome = $_POST['nome'];
$valor = $_POST['valor'];
$tempo = $_POST['tempo'];
$valor = str_replace(',', '.', $valor);
$exame = $_POST['exame'];
$convenio = $_POST['convenio'];
$id = $_POST['id'];

//validacao nome
$query = $pdo->query("SELECT * from $tabela where nome = '$nome'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_reg = @$res[0]['id'];
if(@count($res) > 0 and $id != $id_reg){
	echo 'Procedimento já Cadastrado!';
	exit();
}



if($id == ""){
$query = $pdo->prepare("INSERT INTO $tabela SET nome = :nome, valor = :valor, tempo = '$tempo', ativo = 'Sim', exame = '$exame', convenio = '$convenio'");
	
}else{
$query = $pdo->prepare("UPDATE $tabela SET nome = :nome, valor = :valor, tempo = '$tempo', exame = '$exame', convenio = '$convenio' where id = '$id'");
}
$query->bindValue(":nome", "$nome");
$query->bindValue(":valor", "$valor");

$query->execute();
echo 'Salvo com Sucesso';
 ?>
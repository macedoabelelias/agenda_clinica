<?php 
$tabela = 'usuarios';
require_once("../../../conexao.php");

$nome = $_POST['nome'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$nivel = $_POST['nivel'];
$endereco = $_POST['endereco'];
$senha = '123';
$senha_crip = md5($senha);
$atendimento = $_POST['atendimento'];
$comissao = $_POST['comissao'];
$pagamento = $_POST['pagamento'];
$cpf = $_POST['cpf'];
$intervalo = $_POST['intervalo'];
$id = $_POST['id'];

//validacao email
$query = $pdo->query("SELECT * from $tabela where email = '$email'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_reg = @$res[0]['id'];
if(@count($res) > 0 and $id != $id_reg){
	echo 'Email já Cadastrado!';
	exit();
}

//validacao telefone
$query = $pdo->query("SELECT * from $tabela where telefone = '$telefone'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_reg = @$res[0]['id'];
if(@count($res) > 0 and $id != $id_reg){
	echo 'Telefone já Cadastrado!';
	exit();
}

if($id == ""){
$query = $pdo->prepare("INSERT INTO $tabela SET nome = :nome, email = :email, senha = '$senha', senha_crip = '$senha_crip', nivel = '$nivel', ativo = 'Sim', foto = 'sem-foto.jpg', telefone = :telefone, data = curDate(), endereco = :endereco, atendimento = :atendimento, comissao = :comissao, pagamento = :pagamento, cpf = :cpf, intervalo = :intervalo ");
	
}else{
$query = $pdo->prepare("UPDATE $tabela SET nome = :nome, email = :email, nivel = '$nivel', telefone = :telefone, endereco = :endereco, atendimento = :atendimento, comissao = :comissao, pagamento = :pagamento, cpf = :cpf, intervalo = :intervalo where id = '$id'");
}
$query->bindValue(":nome", "$nome");
$query->bindValue(":email", "$email");
$query->bindValue(":telefone", "$telefone");
$query->bindValue(":endereco", "$endereco");
$query->bindValue(":atendimento", "$atendimento");
$query->bindValue(":comissao", "$comissao");
$query->bindValue(":pagamento", "$pagamento");
$query->bindValue(":cpf", "$cpf");
$query->bindValue(":intervalo", "$intervalo");
$query->execute();

echo 'Salvo com Sucesso';

if($atendimento == 'Sim' and $id == "" and $token != ""){

	
		$telefone_envio = '55'.preg_replace('/[ ()-]+/' , '' , $telefone);

		$mensagem = '*'.$nome_sistema.'* %0A';
		$mensagem .= '_Você foi cadastrado em nosso Sistema_ %0A';
		$mensagem .= '*Email:* '.$email.' %0A';	
		$mensagem .= '*Senha:* '.$senha.' %0A%0A';

		$mensagem .= '_Faça seu acesso e troque sua Senha_';
		$mensagem .= '*Url de Acesso:* '.$url_sistema.' %0A';	
		require("../../apis/texto.php");
	
}	

 ?>

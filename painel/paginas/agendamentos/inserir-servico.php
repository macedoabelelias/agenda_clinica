<?php 
$tabela = 'receber';
require_once("../../../conexao.php");
$data_atual = date('Y-m-d');

@session_start();
$usuario_logado = @$_SESSION['id'];

$cliente = $_POST['cliente_agd'];
$data_pgto = $_POST['data_pgto'];
$id_agd = @$_POST['id_agd'];
$valor_serv = $_POST['valor_serv_agd'];
$descricao = $_POST['descricao_serv_agd'];
$funcionario = $_POST['funcionario_agd'];
$servico = $_POST['servico_agd'];
$pgto = $_POST['pgto'];
$convenio = $_POST['convenio'];

$query = $pdo->query("SELECT * FROM procedimentos where id = '$servico'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$valor = $res[0]['valor'];
$descricao = $res[0]['nome'];
$descricao2 = 'Comissão - '.$res[0]['nome'];
$nome_servico = $res[0]['nome'];

$query = $pdo->query("SELECT * FROM usuarios where id = '$funcionario'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$comissao_func = $res[0]['comissao'];

$comissao = $comissao_sistema;
if($comissao_func > 0){
	$comissao = $comissao_func;
}


$valor_comissao = ($comissao * $valor_serv) / 100;



$query = $pdo->query("SELECT * FROM formas_pgto where nome = '$pgto'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$valor_taxa = @$res[0]['taxa'];

if($valor_taxa > 0){
	$valor_serv = $valor_serv - $valor_serv * ($valor_taxa / 100);
}


if(strtotime($data_pgto) <=  strtotime($data_atual)){
	$pago = 'Sim';
	$data_pgto2 = $data_pgto;
	$usuario_baixa = $usuario_logado;

	if($comissao > 0){
	//lançar a conta a pagar para a comissão do funcionário
	$pdo->query("INSERT INTO pagar SET descricao = '$descricao2', referencia = 'Comissão', valor = '$valor_comissao', data_lanc = '$data_pgto', data_venc = '$data_pgto', usuario_lanc = '$usuario_logado', arquivo = 'sem-foto.png', pago = 'Não', funcionario = '$funcionario', id_ref = '$servico'");
	}
}else{
	$pago = 'Não';
	$data_pgto2 = '';
	$usuario_baixa = 0;
}


if($pgto != "Convênio"){
$foi_pago = 'Sim';
$convenio = 0;
$pdo->query("INSERT INTO $tabela SET descricao = '$descricao', referencia = 'Procedimento', valor = '$valor_serv', data_lanc = curDate(), data_venc = '$data_pgto', data_pgto = '$data_pgto2', usuario_lanc = '$usuario_logado', usuario_pgto = '$usuario_baixa', arquivo = 'sem-foto.png', cliente = '$cliente', pago = '$pago', id_ref = '$servico', saida = '$pgto'");
}else{
	$foi_pago = 'Não';
}

$pdo->query("UPDATE agendamentos SET pago = '$foi_pago', tipo_pagamento = '$pgto', valor = '$valor_serv', convenio = '$convenio' where id = '$id_agd'");

echo 'Salvo com Sucesso'; 


?>
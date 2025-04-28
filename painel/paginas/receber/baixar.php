<?php 
$tabela = 'receber';
require_once("../../../conexao.php");
@session_start();
$id_usuario = $_SESSION['id'];

$id = $_POST['id-baixar'];
$data_atual = date('Y-m-d');
	$dia = date('d');
	$mes = date('m');
	$ano = date('Y');

$valor = $_POST['valor-baixar'];
$valor = str_replace(',', '.', $valor);

$subtotal = $_POST['subtotal'];
$subtotal = str_replace(',', '.', $subtotal);

$saida = $_POST['saida-baixar'];
$data_baixar = $_POST['data-baixar'];

$query = $pdo->query("SELECT * FROM $tabela where id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

$descricao = $res[0]['descricao'];
$cliente = $res[0]['cliente'];
$valor_antigo = $res[0]['valor'];
$data_lanc = $res[0]['data_lanc'];
$data_venc = $res[0]['data_venc'];
$data_pgto = $res[0]['data_pgto'];
$usuario_lanc = $res[0]['usuario_lanc'];
$usuario_pgto = $res[0]['usuario_pgto'];
$frequencia = $res[0]['frequencia'];
$saida_antiga = $res[0]['saida'];
$arquivo = $res[0]['arquivo'];
$pago = $res[0]['pago'];
$referencia = $res[0]['referencia'];
$convenio = $res[0]['convenio'];

if($valor > $valor_antigo){
	echo 'O valor a ser pago não pode ser superior ao valor da conta! O valor da conta é de R$ '.$valor_antigo;
	exit();
}

if($valor <= 0){
	echo 'O precisa ser maior que 0 ';
	exit();
}



if($valor == $valor_antigo){

	$pdo->query("UPDATE $tabela set saida = '$saida', usuario_pgto = '$id_usuario', pago = 'Sim', valor = '$subtotal', data_pgto = '$data_baixar' where id = '$id'");

	//CRIAR A PRÓXIMA CONTA A PAGAR
	$dias_frequencia = $frequencia;

	if($dias_frequencia == 30 || $dias_frequencia == 31){		
		$nova_data_vencimento = date('Y/m/d', strtotime("+1 month",strtotime($data_venc)));

	}else if($dias_frequencia == 90){
		$nova_data_vencimento = date('Y/m/d', strtotime("+3 month",strtotime($data_venc)));

	}else if($dias_frequencia == 180){ 
		$nova_data_vencimento = date('Y/m/d', strtotime("+6 month",strtotime($data_venc)));

	}else if($dias_frequencia == 360 || $dias_frequencia == 365){
		$nova_data_vencimento = date('Y/m/d', strtotime("+1 year",strtotime($data_venc)));

	}else{		
		$nova_data_vencimento = date('Y/m/d', strtotime("+$dias_frequencia days",strtotime($data_venc))); 
	}


	if(@$dias_frequencia > 0){
		$pdo->query("INSERT INTO $tabela set descricao = '$descricao', cliente = '$cliente', valor = '$valor_antigo', data_lanc = curDate(), data_venc = '$nova_data_vencimento', frequencia = '$frequencia', saida = '$saida_antiga', arquivo = '$arquivo', pago = 'Não', referencia = '$referencia', convenio = '$convenio'");
				$id_ult_registro = $pdo->lastInsertId();				
	}

	

}else{

	$descricao = '(Resíduo) ' .$descricao;
	//PEGAR RESIDUOS DA CONTA
	$total_resid = 0;
	$query = $pdo->query("SELECT * FROM valor_parcial WHERE id_conta = '$id' and tipo = 'Receber'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res) > 0){
	
		for($i=0; $i < @count($res); $i++){
		foreach ($res[$i] as $key => $value){} 
			$valor_resid = $res[$i]['valor'];
			$total_resid += $valor_resid;
		}
	}

	
	$valor_antigo = $valor_antigo - $subtotal;

	$pdo->query("INSERT INTO valor_parcial set id_conta = '$id', tipo = 'Receber', valor = '$subtotal', data = curDate(), usuario = '$id_usuario'");

	$pdo->query("UPDATE $tabela set saida = '$saida', usuario_pgto = '$id_usuario', valor = '$valor_antigo', data_pgto = curDate() where id = '$id'");

}

echo 'Baixado com Sucesso';

?>


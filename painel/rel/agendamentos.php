<?php 
include('../../conexao.php');

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
$data_hoje = utf8_encode(strftime('%A, %d de %B de %Y', strtotime('today')));

$status = $_GET['status'];
$dataInicial = $_GET['dataInicial'];
$dataFinal = $_GET['dataFinal'];
$pago = $_GET['pago'];
$convenio = $_GET['convenio'];
$procedimento = $_GET['procedimento'];

$dataInicialF = implode('/', array_reverse(explode('-', $dataInicial)));
$dataFinalF = implode('/', array_reverse(explode('-', $dataFinal)));	

$statusF = "";
if($status == "Agendado"){
	$statusF = 'AGENDADOS';	 
}else if ($status == "Confirmado"){
	$statusF = 'CONFIRMADOS';
}else if ($status == "Finalizado"){
	$statusF = 'FINALIZADOS';
}


$pagoF = "";
if($pago == "Sim"){
	$pagoF = 'PAGOS'; 
}else if($pago == "Não"){
	$pagoF = 'PENDENTES';
}


$nome_procedimento = "";
if($procedimento != ""){
	$query2 = $pdo->query("SELECT * FROM procedimentos where id = '$procedimento'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$nome_procedimento = mb_strtoupper($res2[0]['nome']);
}

$nome_convenio = "";
if($convenio != "" and $convenio != "0"){
$query2 = $pdo->query("SELECT * FROM convenios where id = '$convenio'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$nome_convenio = mb_strtoupper($res2[0]['nome']);
}

if($convenio == "0"){
	$nome_convenio = 'PARTICULAR';
}


$datas = "";
if($dataInicial == $dataFinal){
	$datas = $dataInicialF;
}else{
	$datas = $dataInicialF.' à '.$dataFinalF;
}

$texto_filtro = 'Apurado: '.$datas;

if($convenio != ""){
	$texto_filtro .= ' Convênio: '.$nome_convenio;
}

?>
<!DOCTYPE html>
<html>
<head>

<style>

@import url('https://fonts.cdnfonts.com/css/tw-cen-mt-condensed');
@page { margin: 145px 20px 25px 20px; }
#header { position: fixed; left: 0px; top: -110px; bottom: 100px; right: 0px; height: 35px; text-align: center; padding-bottom: 100px; }
#content {margin-top: 0px;}
#footer { position: fixed; left: 0px; bottom: -60px; right: 0px; height: 80px; }
#footer .page:after {content: counter(page, my-sec-counter);}
body {font-family: 'Tw Cen MT', sans-serif;}

.marca{
	position:fixed;
	left:50;
	top:100;
	width:80%;
	opacity:8%;
}

</style>

</head>
<body>
<?php 
if($marca_dagua == 'Sim'){ ?>
<img class="marca" src="<?php echo $url_sistema ?>img/logo.jpg">	
<?php } ?>


<div id="header" >

	<div style="border-style: solid; font-size: 10px; height: 50px;">
		<table style="width: 100%; border: 0px solid #ccc;">
			<tr>
				<td style="border: 1px; solid #000; width: 7%; text-align: left;">
					<img style="margin-top: 7px; margin-left: 7px;" id="imag" src="<?php echo $url_sistema ?>img/logo.jpg" width="120px">
				</td>
				<td style="width: 30%; text-align: left; font-size: 13px;">
					
				</td>
				<td style="width: 1%; text-align: center; font-size: 13px;">
				
				</td>
				<td style="width: 47%; text-align: right; font-size: 9px;padding-right: 10px;">
						<b><big>RELATÓRIO DE PROCEDIMENTOS <span><?php echo $statusF ?> <?php echo $pagoF ?> </span></big></b><br> <?php echo mb_strtoupper($texto_filtro) ?> <br>
						<?php 
						if($procedimento != ""){
							echo 'PROCEDIMENTO: '.$nome_procedimento;
							echo '<br>';
							}
						 ?>
						
						 <?php echo mb_strtoupper($data_hoje) ?>
				</td>
			</tr>		
		</table>
	</div>

<br>


		<table id="cabecalhotabela" style="border-bottom-style: solid; font-size: 8px; margin-bottom:10px; width: 100%; table-layout: fixed;">
			<thead>
				
				<tr id="cabeca" style="margin-left: 0px; background-color:#CCC">
					<td style="width:18%">PROCEDIMENTO</td>
					<td style="width:9%">VALOR</td>
					<td style="width:18%">PROFISSIONAL</td>
					<td style="width:18%">PACIENTE</td>
					<td style="width:7%">DATA</td>
					<td style="width:7%">HORA</td>	
					<td style="width:10%">STATUS</td>		
					<td style="width:13%">CONVÊNIO</td>
				</tr>
			</thead>
		</table>
</div>

<div id="footer" class="row">
<hr style="margin-bottom: 0;">
	<table style="width:100%;">
		<tr style="width:100%;">
			<td style="width:60%; font-size: 10px; text-align: left;"><?php echo $nome_sistema ?> Telefone: <?php echo $telefone_sistema ?></td>
			<td style="width:40%; font-size: 10px; text-align: right;"><p class="page">Página  </p></td>
		</tr>
	</table>
</div>

<div id="content" style="margin-top: 0;">



		<table style="width: 100%; table-layout: fixed; font-size:8px; text-transform: uppercase;">
			<thead>
				<tbody>
					<?php


$total_pendentes = 0;
$total_pendentesF = 0;
$total_pagas = 0;
$total_pagasF = 0;
$pendentes = 0;
$pagas = 0;

$agendados = 0;
$confirmados = 0;
$finalizados = 0;

$query = $pdo->query("SELECT * from agendamentos where data >= '$dataInicial' and data <= '$dataFinal' and pago LIKE '%$pago%' and convenio LIKE '%$convenio%' and servico LIKE '%$procedimento%' and status LIKE '%$status%' order by data asc, hora asc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
for($i=0; $i<$linhas; $i++){
	$id = $res[$i]['id'];
$funcionario = $res[$i]['funcionario'];
$cliente = $res[$i]['paciente'];
$hora = $res[$i]['hora'];
$data = $res[$i]['data'];
$usuario = $res[$i]['usuario'];
$data_lanc = $res[$i]['data_lanc'];
$obs = $res[$i]['obs'];
$status = $res[$i]['status'];
$servico = $res[$i]['servico'];
$pago = $res[$i]['pago'];
$tipo_pagamento = $res[$i]['tipo_pagamento'];
$valor = $res[$i]['valor'];
$convenio = $res[$i]['convenio'];

$dataF = implode('/', array_reverse(explode('-', $data)));
$horaF = date("H:i", strtotime($hora));


if($status == 'Concluído'){		
	$classe_linha = '';
}else{		
	$classe_linha = 'text-muted';
}

$ocultar_confirmacao = '';

if($status == 'Agendado'){
	$agendados += 1;
	$classe_status = 'red';	
}else if($status == 'Finalizado'){
	$finalizados += 1;
	$classe_status = 'green';	
}else if($status == 'Confirmado'){
	$confirmados += 1;
	$classe_status = 'blue';	
}

if($pago == 'Sim'){
	$classe_pago = 'verde.jpg';
	$ocultar_pago = 'ocultar';
	$total_pagas += $valor;
	$pagas += 1;
}else{
	$classe_pago = 'vermelho.jpg';
	$ocultar_pago = '';
	$total_pendentes += $valor;
	$pendentes += 1;
}

$query2 = $pdo->query("SELECT * FROM usuarios where id = '$usuario'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
	$nome_usu = $res2[0]['nome'];
}else{
	$nome_usu = 'Sem Usuário';
}


$query2 = $pdo->query("SELECT * FROM procedimentos where id = '$servico'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
	$nome_serv = $res2[0]['nome'];
	$valor_serv = $res2[0]['valor'];
	$aceita_convenio = $res2[0]['convenio'];
}else{
	$nome_serv = 'Não Lançado';
	$valor_serv = '';
	$aceita_convenio = $res2[0]['convenio'];
}


$query2 = $pdo->query("SELECT * FROM pacientes where id = '$cliente'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
	$nome_cliente = $res2[0]['nome'];
	
}else{
	$nome_cliente = 'Sem Cliente';
	
}

$query2 = $pdo->query("SELECT * FROM convenios where id = '$convenio'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
	$nome_convenio = $res2[0]['nome'];
	
}else{
	$nome_convenio = 'Particular';
	
}

$query2 = $pdo->query("SELECT * FROM usuarios where id = '$funcionario'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
	$nome_funcionario = $res2[0]['nome'];
	
}else{
	$nome_funcionario = '';
	
}		

$total_pagasF = number_format($total_pagas, 2, ',', '.');
$total_pendentesF = number_format($total_pendentes, 2, ',', '.');
$valorF = number_format($valor, 2, ',', '.');


  	 ?>

  	 
      <tr>
<td style="width:18%">
<img style="margin-top: 0px" src="<?php echo $url_sistema ?>painel/images/<?php echo $classe_pago ?>" width="8px">
	<?php echo $nome_serv ?></td>
<td style="width:9%">R$ <?php echo $valorF ?></td>
<td style="width:18%"><?php echo $nome_funcionario ?></td>
<td style="width:18%"><?php echo $nome_cliente ?></td>
<td style="width:7%"><?php echo $dataF ?></td>
<td style="width:7%"><?php echo $horaF ?></td>
<td style="width:10%" style="color:<?php echo $classe_status ?>"><?php echo $status ?></td>
<td style="width:10%"><?php echo $nome_convenio ?></td>
    </tr>

<?php } } ?>
				</tbody>
	
			</thead>
		</table>
	


</div>
<hr>
		<table>
			<thead>
				<tbody>
					<tr>

						<td style="font-size: 10px; width:300px; text-align: right;"></td>

						

						<td style="font-size: 10px; width:70px; text-align: right;"><b>Pendentes: <span style="color:red"><?php echo $pendentes ?></span></td>

							<td style="font-size: 10px; width:70px; text-align: right;"><b>Pagas: <span style="color:green"><?php echo $pagas ?></span></td>


								<td style="font-size: 10px; width:140px; text-align: right;"><b>Pendentes: <span style="color:red">R$ <?php echo $total_pendentesF ?></span></td>

									<td style="font-size: 10px; width:120px; text-align: right;"><b>Pagas: <span style="color:green">R$ <?php echo $total_pagasF ?></span></td>
						
					</tr>
				</tbody>
			</thead>
		</table>


<hr style="margin:3px">
		<table>
			<thead>
				<tbody>
					<tr>

						<td style="font-size: 10px; width:300px; text-align: right;"></td>

						

						<td style="font-size: 10px; width:70px; text-align: right;"></td>

							<td style="font-size: 10px; width:70px; text-align: right;"><b>Agendados: <span style="color:red"><?php echo $agendados ?></span></td>


								<td style="font-size: 10px; width:140px; text-align: right;"><b>Confirmados: <span style="color:blue"> <?php echo $confirmados ?></span></td>

									<td style="font-size: 10px; width:120px; text-align: right;"><b>Finalizados: <span style="color:green"> <?php echo $finalizados ?></span></td>
						
					</tr>
				</tbody>
			</thead>
		</table>

</body>

</html>



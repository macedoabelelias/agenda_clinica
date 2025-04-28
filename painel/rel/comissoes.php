<?php 
include('../../conexao.php');

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
$data_hoje = utf8_encode(strftime('%A, %d de %B de %Y', strtotime('today')));

$dataInicial = $_GET['dataInicial'];
$dataFinal = $_GET['dataFinal'];
$pago = $_GET['pago'];
$funcionario = $_GET['funcionario'];

	$query2 = $pdo->query("SELECT * FROM usuarios where id = '$funcionario'");
		$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
		$total_reg2 = @count($res2);
		if($total_reg2 > 0){
			$nome_tecnico = $res2[0]['nome'];
			$pix_tecnico = $res2[0]['pagamento'];
			$tel_tecnico = $res2[0]['telefone'];
			$email_tecnico = $res2[0]['email'];
		}


$dataInicialF = implode('/', array_reverse(explode('-', $dataInicial)));
$dataFinalF = implode('/', array_reverse(explode('-', $dataFinal)));	

$filtro_tipoF = "";
$classe_entradas = "";
if($pago == "Sim"){
	$filtro_tipoF = 'PAGAS';
	$classe_entradas = 'green'; 
}

if($pago == "Não"){
	$filtro_tipoF = 'PENDENTES';
	$classe_entradas = 'red'; 
}



$datas = "";
if($dataInicial == $dataFinal){
	$datas = $dataInicialF;
}else{
	$datas = $dataInicialF.' à '.$dataFinalF;
}

$texto_filtro = 'APURADO EM : '.$datas;



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

	<div style="border-style: solid; font-size: 10px; height: 60px;">
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
						<b><big>RELATÓRIO DE COMISSÕES <span style="color:<?php echo $classe_entradas ?>"><?php echo $filtro_tipoF ?></span></big></b><br> <?php echo mb_strtoupper($texto_filtro) ?> <br> <?php echo mb_strtoupper($data_hoje) ?>
				</td>
			</tr>		
		</table>
	</div>

	<table style="border-style: solid; font-size: 9px; margin-bottom:10px; width: 100%; table-layout: fixed; margin-top:10px;">
			<thead>
				
				<tr id="cabeca" style="margin-left: 0px; background-color:#f2f0f0">
					<td colspan="4" style="width:100%; font-size: 10px"><b>DADOS DO PROFISSIONAL</b> </td>					
				</tr>
				<tr >
					<td style="width:10%; border-right: 1px solid #000;border-bottom: : 1px solid #000;">NOME: </td>
					<td style="width:40%; border-right: : 1px solid #000; border-bottom: : 1px solid #000;">
						<?php echo mb_strtoupper($nome_tecnico) ?>
					</td>
					
					<td style="width:10%; border-right: 1px solid #000;border-bottom: : 1px solid #000;">CHAVE PIX: </td>
					<td style="width:40%; border-bottom: : 1px solid #000;">
						<?php echo mb_strtoupper($pix_tecnico) ?>
					</td>
    			</tr>
    			<tr >
					<td style="width:10%; border-right: 1px solid #000;">TELEFONE: </td>
					<td style="width:40%; border-right: : 1px solid #000; ">
						<?php echo mb_strtoupper($tel_tecnico) ?>
					</td>
					
					<td style="width:10%; border-right: 1px solid #000;">EMAIL: </td>
					<td style="width:40%; ">
						<?php echo mb_strtoupper($email_tecnico) ?>
					</td>
    			</tr>
			</thead>
		</table>



		<table id="cabecalhotabela" style="border-bottom-style: solid; font-size: 9px; margin-bottom:10px; width: 100%; table-layout: fixed;">
			<thead>
				
				<tr id="cabeca" style="margin-left: 0px; background-color:#CCC">
					<td style="width:40%">DESCRIÇÃO</td>
					<td style="width:15%">VALOR</td>
					<td style="width:15%">DATA CONSULTA</td>
					<td style="width:15%">VENCIMENTO</td>
					<td style="width:15%">PAGAMENTO</td>
							
					
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

<div id="content" style="margin-top: 50px;">



		<table style="width: 100%; table-layout: fixed; font-size:10px; text-transform: uppercase;">
			<thead>
				<tbody>
					<?php
$total_pagas = 0;
$total_pendentes = 0;
$total_pagasF = 0;
$total_pendentesF = 0;
$pendentes = 0;
$pagas = 0;
$query = $pdo->query("SELECT * FROM pagar where data_lanc >= '$dataInicial' and data_lanc <= '$dataFinal' and pago LIKE '%$pago%' and funcionario = '$funcionario' and referencia = 'Comissão' ORDER BY pago asc, data_venc asc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
for($i=0; $i<$linhas; $i++){
	$id = $res[$i]['id'];	
	$descricao = $res[$i]['descricao'];
	$tipo = $res[$i]['referencia'];
	$valor = $res[$i]['valor'];
	$data_lanc = $res[$i]['data_lanc'];
	$data_pgto = $res[$i]['data_pgto'];
	$data_venc = $res[$i]['data_venc'];
	$usuario_lanc = $res[$i]['usuario_lanc'];
	$usuario_baixa = $res[$i]['usuario_pgto'];
	$foto = $res[$i]['arquivo'];	
	$funcionario = $res[$i]['funcionario'];	
	
	$pago = $res[$i]['pago'];
	
	
	$valorF = number_format($valor, 2, ',', '.');
	$data_lancF = implode('/', array_reverse(explode('-', $data_lanc)));
	$data_pgtoF = implode('/', array_reverse(explode('-', $data_pgto)));
	$data_vencF = implode('/', array_reverse(explode('-', $data_venc)));
	

		


		$query2 = $pdo->query("SELECT * FROM usuarios where id = '$usuario_baixa'");
		$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
		$total_reg2 = @count($res2);
		if($total_reg2 > 0){
			$nome_usuario_pgto = $res2[0]['nome'];
		}else{
			$nome_usuario_pgto = 'Nenhum!';
		}




		$query2 = $pdo->query("SELECT * FROM usuarios where id = '$usuario_lanc'");
		$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
		$total_reg2 = @count($res2);
		if($total_reg2 > 0){
			$nome_usuario_lanc = $res2[0]['nome'];
		}else{
			$nome_usuario_lanc = 'Sem Referência!';
		}



		$query2 = $pdo->query("SELECT * FROM usuarios where id = '$funcionario'");
		$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
		$total_reg2 = @count($res2);
		if($total_reg2 > 0){
			$nome_func = $res2[0]['nome'];
			$tel_func = $res2[0]['telefone'];
			$chave_pix_func = $res2[0]['pagamento'];			
		}else{
			$nome_func = 'Sem Referência!';
			$chave_pix_func = '';
			$tel_func = '';			

		}		

		

if($pago == 'Sim'){
	$classe_pago = 'verde.jpg';	
	$total_pagas += $valor;
	$pagas += 1;
}else{
	$classe_pago = 'vermelho.jpg';	
	$total_pendentes += $valor;
	$pendentes += 1;
}


$total_pagasF = number_format($total_pagas, 2, ',', '.');
$total_pendentesF = number_format($total_pendentes, 2, ',', '.');


if($data_pgtoF == '00/00/0000'){
	$data_pgtoF = 'Pendente';
}
  	 ?>

  	 
      <tr>
<td style="width:40%">
<img style="margin-top: 0px" src="<?php echo $url_sistema ?>painel/images/<?php echo $classe_pago ?>" width="8px">
	<?php echo $descricao ?></td>
<td style="width:15%">R$ <?php echo $valorF ?></td>
<td style="width:15%"><?php echo $data_lancF ?></td>
<td style="width:15%"><?php echo $data_vencF ?></td>
<td style="width:15%"><?php echo $data_pgtoF ?></td>


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

		<hr>



			<div align="center" style="margin-top: 35px; font-size:10px; border:1px solid #000; padding-top:15px; padding-bottom:5px">
			<span>_________________________________________________________________<br>
			CONFIRMO O RECEBIMENTO DE R$ <?php echo $total_pendentesF ?> REAIS</span>
		</div>

	

</body>

</html>



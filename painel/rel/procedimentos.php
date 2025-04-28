<?php 
include('../../conexao.php');

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
$data_hoje = utf8_encode(strftime('%A, %d de %B de %Y', strtotime('today')));

$exame = $_GET['exame'];
$texto_filtro = "";

if($exame == "Sim"){
	$texto_filtro = " EXAMES";
}

if($exame == "Não"){
	$texto_filtro = " CONSULTAS";
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
	top:130;
	width:80%;
	opacity:10%;
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
				<td style="border: 1px; solid #000; width: 20%; text-align: left;">
					<img style="margin-top: 5px; margin-left: 7px;" id="imag" src="<?php echo $url_sistema ?>img/logo.jpg" width="140px">
				</td>
				<td style="width: 20%; text-align: left; font-size: 13px;">
				
				</td>
				<td style="width: 5%; text-align: center; font-size: 13px;">
				
				</td>
				<td style="width: 55%; text-align: right; font-size: 9px;padding-right: 10px;">
						<b><big>RELATÓRIO DE PROCEDIMENTOS <?php echo $texto_filtro ?></big></b><br>

						<br>
						 <?php echo mb_strtoupper($data_hoje) ?>
				</td>
			</tr>		
		</table>
	</div>

<br>


		<table id="cabecalhotabela" style="border-bottom-style: solid; font-size: 10px; margin-bottom:10px; width: 100%; table-layout: fixed;">
			<thead>
				
				<tr id="cabeca" style="margin-left: 0px; background-color:#CCC">
					<td style="width:55%">PROCEDIMENTO</td>
					<td style="width:15%">R$ VALOR</td>
					<td style="width:10%">ATIVO</td>
					<td style="width:10%">EXAME</td>
					<td style="width:10%">CONVÊNIO</td>
				</tr>
			</thead>
		</table>
</div>

<div id="footer" class="row">
<hr style="margin-bottom: 0;">
	<table style="width:100%;">
		<tr style="width:100%;">
			<td style="width:60%; font-size: 10px; text-align: left;"><?php echo $nome_sistema ?> / Telefone: <?php echo $telefone_sistema ?> / Email: <?php echo $email_sistema ?></td>
			<td style="width:40%; font-size: 10px; text-align: right;"><p class="page">Página  </p></td>
		</tr>
	</table>
</div>

<div id="content" style="margin-top: 0;">

		<table style="width: 100%; table-layout: fixed; font-size:10px; text-transform: uppercase;">
			<thead>
				<tbody>
					<?php 
$ativos = 0;
$inativos = 0;
$query = $pdo->query("SELECT * from procedimentos WHERE exame LIKE '%$exame%' order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
for($i=0; $i<$linhas; $i++){
	$id = $res[$i]['id'];
	$nome = $res[$i]['nome'];
	$valor = $res[$i]['valor'];
	$tempo = $res[$i]['tempo'];
	$ativo = $res[$i]['ativo'];
	$exame = $res[$i]['exame'];
	$convenio = $res[$i]['convenio'];

	$valorF = number_format($valor, 2, ',', '.');
	
	if($ativo == 'Sim'){
	$icone = 'fa-check-square';
	$titulo_link = 'Desativar Usuário';
	$acao = 'Não';
	$classe_ativo = '';
	$ativos += 1;
	}else{
		$icone = 'fa-square-o';
		$titulo_link = 'Ativar Usuário';
		$acao = 'Sim';
		$classe_ativo = '#c4c4c4';
		$inativos += 1;
	}

	if($exame == 'Sim'){
		$classe_exame = 'red';
	}else{
		$classe_exame = 'blue';
	}

	$classe_convenio = '';
	if($convenio == 'Não'){
		$classe_convenio = 'red';
	}
	
  	 ?>

  	 
      <tr style="color:<?php echo $classe_ativo ?>">
<td style="width:55%; color:<?php echo $classe_exame ?>"><?php echo $nome ?></td>
<td style="width:15%">R$ <?php echo $valorF ?></td>
<td style="width:10%"><?php echo $ativo ?></td>
<td style="width:10%; color:<?php echo $classe_exame ?>"><?php echo $exame ?></td>
<td style="width:10%; color:<?php echo $classe_convenio ?>"><?php echo $convenio ?></td>

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
						<td style="font-size: 10px; width:180px; text-align: right;"> </td>

						<td style="font-size: 10px; width:180px; text-align: right;">PROCEDIMENTOS ATIVOS: <span style="color:green"><?php echo $ativos ?></span></td>

						<td style="font-size: 10px; width:180px; text-align: right;">PROCEDIMENTOS INATIVOS: <span style="color:red"><?php echo $inativos ?></span></td>

							<td style="font-size: 10px; width:180px; text-align: right;">TOTAL PROCEDIMENTOS: <?php echo $linhas ?></td>
						
					</tr>
				</tbody>
			</thead>
		</table>

</body>

</html>



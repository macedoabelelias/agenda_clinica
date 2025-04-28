<?php 
if(@$home == 'ocultar'){
	echo "<script>window.location='../index.php'</script>";
    exit();
}

$mes_atual = Date('m');
$ano_atual = Date('Y');
$data_inicio_mes = $ano_atual."-".$mes_atual."-01";

if($mes_atual == '4' || $mes_atual == '6' || $mes_atual == '9' || $mes_atual == '11'){
	$dia_final_mes = '30';
}else if($mes_atual == '2'){
	$dia_final_mes = '28';
}else{
	$dia_final_mes = '31';
}

$data_final_mes = $ano_atual."-".$mes_atual."-".$dia_final_mes;

//totalizar pacientes
$query = $pdo->query("SELECT * from pacientes");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_pacientes = @count($res);

//pagar hoje
$total_pagar_hoje = 0;
$query = $pdo->query("SELECT * from pagar where data_venc = curDate() and pago != 'Sim'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$pagar_hoje = @count($res);
if($pagar_hoje > 0){
	for($i=0; $i < $pagar_hoje; $i++){
		$total_pagar_hoje += $res[$i]['valor'];
		$total_pagar_hojeF = number_format($total_pagar_hoje, 2, ',', '.');
	}
}


//receber hoje
$total_receber_hoje = 0;
$query = $pdo->query("SELECT * from receber where data_venc = curDate() and pago != 'Sim'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$receber_hoje = @count($res);
if($receber_hoje > 0){
	for($i=0; $i < $receber_hoje; $i++){
		$total_receber_hoje += $res[$i]['valor'];
		$total_receber_hojeF = number_format($total_receber_hoje, 2, ',', '.');
	}
}




//pagar_vencidas
$query = $pdo->query("SELECT * from pagar where data_venc < curDate() and pago != 'Sim'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$pagar_vencidas = @count($res);


//contas pagar mes
$query = $pdo->query("SELECT * from pagar where data_venc >= '$data_inicio_mes' and data_venc <= '$data_final_mes'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_pagar_mes = @count($res);

//contas pagas mes
$query = $pdo->query("SELECT * from pagar where data_venc >= '$data_inicio_mes' and data_venc <= '$data_final_mes' and pago = 'Sim'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_pagas_mes = @count($res);

//porcentagem
if($total_pagar_mes > 0 and $total_pagas_mes > 0){
    $porcentagem_pagar = ($total_pagas_mes / $total_pagar_mes) * 100;
}else{
    $porcentagem_pagar = 0;
}


//dados para o gráfico de linhas
$meses = 6;
$data_inicio_apuracao = date('Y-m-d', strtotime("-$meses months",strtotime($data_inicio_mes)));
$datas_apuracao = '';
$nome_mes = '';
$datas_apuracao_final = '';

$total_receber_final = '';
$total_pagar_final = '';

for($cont=0; $cont<$meses; $cont++){


	$datas_apuracao = date('Y-m-d', strtotime("+$cont months",strtotime($data_inicio_apuracao)));

	$mes = date('m', strtotime($datas_apuracao));
	$ano = date('Y', strtotime($datas_apuracao));

	if($mes == '01'){
		$nome_mes = 'Janeiro';
	}

	if($mes == '02'){
		$nome_mes = 'Fevereiro';
	}

	if($mes == '03'){
		$nome_mes = 'Março';
	}

	if($mes == '04'){
		$nome_mes = 'Abril';
	}

	if($mes == '05'){
		$nome_mes = 'Maio';
	}

	if($mes == '06'){
		$nome_mes = 'Junho';
	}

	if($mes == '07'){
		$nome_mes = 'Julho';
	}

	if($mes == '08'){
		$nome_mes = 'Agosto';
	}

	if($mes == '09'){
		$nome_mes = 'Setembro';
	}

	if($mes == '10'){
		$nome_mes = 'Outubro';
	}

	if($mes == '11'){
		$nome_mes = 'Novembro';
	}

	if($mes == '12'){
		$nome_mes = 'Dezembro';
	}

	if($mes == '04' || $mes == '06' || $mes == '09' || $mes == '11'){
		$data_final_mes = '30';
	}else if($mes == '2'){
		$data_final_mes = '28';
	}else{
		$data_final_mes = '31';
	}
	
	$data_final_mes_completa = $ano.'-'.$mes.'-'.$data_final_mes;	
	//percorrer os meses totalizando os valores

$query = $pdo->query("SELECT * from receber where data_pgto >= '$datas_apuracao' and data_pgto<= '$data_final_mes_completa' and pago = 'Sim'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total = @count($res);
$total_receber = 0;
$total_receberF = 0;
if($total > 0){
	for($i=0; $i<$total; $i++){		
		$valor = $res[$i]['valor'];
		$total_receber += $valor;		
	}
}


$query = $pdo->query("SELECT * from pagar where data_pgto >= '$datas_apuracao' and data_pgto<= '$data_final_mes_completa' and pago = 'Sim'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total = @count($res);
$total_pagar = 0;
$total_pagarF = 0;
if($total > 0){
	for($i=0; $i<$total; $i++){		
		$valor = $res[$i]['valor'];
		$total_pagar += $valor;		
	}
}		
	
		$total_receber_final .= $total_receber.'*';		
		$total_pagar_final .= $total_pagar.'*';
		

	$datas_apuracaoF = implode('/', array_reverse(explode('-', $datas_apuracao)));

	$datas_apuracao_final .= $nome_mes.'*';

}	

 ?>


<?php if($ativo_sistema == ''){ ?>
<div style="background: #ffc341; color:#3e3e3e; padding:10px; font-size:14px; margin-bottom:10px">
<div><i class="fa fa-info-circle"></i> <b>Aviso: </b> Prezado Cliente, não identificamos o pagamento de sua última mensalidade, entre em contato conosco o mais rápido possivel para regularizar o pagamento, caso contário seu acesso ao sistema será desativado.</div>
</div>
<?php } ?>

<div class="main-page">
	<div class="col_3">

		<a href="index.php?pagina=pacientes">
		<div class="col-md-3 widget widget1">
			<div class="r3_counter_box">
				<i class="pull-left fa fa-users icon-rounded" style="background:#2a2ea3"></i>
				<div class="stats">
					<h5><strong><?php echo $total_pacientes ?></strong></h5>
					<span>Total Pacientes</span>
				</div>
			</div>
		</div>
		</a>

		<a href="index.php?pagina=pagar">
		<div class="col-md-3 widget widget1">
			<div class="r3_counter_box">
				<i class="pull-left fa fa-money user1 icon-rounded"></i>
				<div class="stats">
					<h5><strong>R$ <?php echo $total_pagar_hoje ?></strong></h5>
					<span>(<?php echo $pagar_hoje ?>) Pagar Hoje</span>
				</div>
			</div>
		</div>
		</a>

		<a href="index.php?pagina=receber">
		<div class="col-md-3 widget widget1">
			<div class="r3_counter_box">
				<i class="pull-left fa fa-money dollar2 icon-rounded"></i>
				<div class="stats">
					<h5><strong>R$ <?php echo $total_receber_hoje ?></strong></h5>
					<span>(<?php echo $receber_hoje ?>) Receber Hoje</span>
				</div>
			</div>
		</div>
		</a>

		<a href="index.php?pagina=receber">
		<div class="col-md-3 widget widget1">
			<div class="r3_counter_box">
				<i class="pull-left fa fa-stethoscope icon-rounded" style="background:#3192d4"></i>
				<div class="stats">
					<h5><strong>26</strong></h5>
					<span>Agenda Hoje</span>
				</div>
			</div>
		</div>
		</a>

		<a href="index.php?pagina=pagar">
		<div class="col-md-3 widget">
			<div class="r3_counter_box">
				<i class="pull-left fa fa-stethoscope icon-rounded" style="background:#32e376"></i>
				<div class="stats">
					<h5><strong>20</strong></h5>
					<span>Confirmadas</span>
				</div>
			</div>
		</div>
		</a>

		<div class="clearfix"> </div>
	</div>
	
	<div class="row-one widgettable">
		<div class="col-md-8 content-top-2 card">
			<div class="agileinfo-cdr">
				<div class="card-header">
					<h3>Entradas / Saídas</h3>
				</div>
				
				<div id="Linegraph" style="width: 98%; height: 350px">
				</div>
				
			</div>
		</div>
		<div class="col-md-4 stat">
			<div class="content-top-1">
				<div class="col-md-6 top-content">
					<h5>Consultas Hoje</h5>
					<label>13 / 26</label>
				</div>
				<div class="col-md-6 top-content1">	   
					<div id="demo-pie-1" class="pie-title-center" data-percent="50"> <span class="pie-value"></span> </div>
				</div>
				<div class="clearfix"> </div>
			</div>
			<div class="content-top-1">
				<div class="col-md-6 top-content">
					<h5>Consultas Mês</h5>
					<label>50 / 200</label>
				</div>
				<div class="col-md-6 top-content1">	   
					<div id="demo-pie-2" class="pie-title-center" data-percent="25"> <span class="pie-value"></span> </div>
				</div>
				<div class="clearfix"> </div>
			</div>
			<div class="content-top-1">
				<div class="col-md-6 top-content">
					<h5>Pagamentos Mês</h5>
					<label><?php echo $total_pagas_mes ?> / <?php echo $total_pagar_mes ?></label>
				</div>
				<div class="col-md-6 top-content1">	   
					<div id="demo-pie-3" class="pie-title-center" data-percent="<?php echo $porcentagem_pagar ?>"> <span class="pie-value"></span> </div>
				</div>
				<div class="clearfix"> </div>
			</div>
		</div>
		


		<div class="clearfix"> </div>
	</div>
	
	
	

	
</div>




<!-- for index page weekly sales java script -->
<script src="js/SimpleChart.js"></script>
<script>

	var meses = "<?=$datas_apuracao_final?>";
	var dados = meses.split("*"); 

	var receber = "<?=$total_receber_final?>";
	var dados_receber = receber.split("*"); 

	var pagar = "<?=$total_pagar_final?>";
	var dados_pagar = pagar.split("*"); 

		var maior_valor_linha_pagar = Math.max(...dados_pagar);
    	var maior_valor_linha_receber = Math.max(...dados_receber);
    	var maior_valor = Math.max(maior_valor_linha_pagar, maior_valor_linha_receber);
    	maior_valor = parseFloat(maior_valor) + 200;
    	
    	var menor_valor_linha_pagar = Math.min(...dados_pagar);
    	var menor_valor_linha_receber = Math.min(...dados_receber);
    	var menor_valor = Math.min(menor_valor_linha_pagar, menor_valor_linha_receber);

	var graphdata1 = {
		linecolor: "#c91508",
		title: "Despesas",
		values: [
		{ X: dados[0], Y: dados_pagar[0] },
		{ X: dados[1], Y: dados_pagar[1] },
		{ X: dados[2], Y: dados_pagar[2] },
		{ X: dados[3], Y: dados_pagar[3] },
		{ X: dados[4], Y: dados_pagar[4] },
		{ X: dados[5], Y: dados_pagar[5] },
		
		]
	};
	var graphdata2 = {
		linecolor: "#00CC66",
		title: "Recebimentos",
		values: [
		{ X: dados[0], Y: dados_receber[0] },
		{ X: dados[1], Y: dados_receber[1] },
		{ X: dados[2], Y: dados_receber[2] },
		{ X: dados[3], Y: dados_receber[3] },
		{ X: dados[4], Y: dados_receber[4] },
		{ X: dados[5], Y: dados_receber[5] },
		]
	};

	var dataRangeLinha = {
    		linecolor: "transparent",
    		title: "",
    		values: [
    		{ X: dados[0], Y: menor_valor },
    		{ X: dados[1], Y: menor_valor },
    		{ X: dados[2], Y: menor_valor },
    		{ X: dados[3], Y: menor_valor },
    		{ X: dados[4], Y: menor_valor },
    		{ X: dados[5], Y: maior_valor },
    		
    		]
    	};
	
		
		$("#Linegraph").SimpleChart({
			ChartType: "Line",
			toolwidth: "50",
			toolheight: "25",
			axiscolor: "#E6E6E6",
			textcolor: "#6E6E6E",
			showlegends: true,
			data: [graphdata2, graphdata1, dataRangeLinha],
			legendsize: "30",
			legendposition: 'bottom',
			xaxislabel: 'Meses',
    		title: 'Últimos 6 Meses',
    		yaxislabel: 'Total de Contas R$',
    		responsive: true,
		});
	

</script>
<!-- //for index page weekly sales java script -->

<?php 
require_once("../../../conexao.php");
@session_start();
$usuario = @$_SESSION['id'];

$funcionario = @$_POST['funcionario'];
$data = @$_POST['data'];

if($data == ""){
	$data = date('Y-m-d');
}

if($funcionario == ""){
	echo '<small>Selecione um Funcionário!</small>';
	exit();
}

echo <<<HTML
<small>
HTML;
$query = $pdo->query("SELECT * FROM agendamentos where funcionario = '$funcionario' and data = '$data' ORDER BY hora asc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
for($i=0; $i < $total_reg; $i++){
	foreach ($res[$i] as $key => $value){}
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

$dataF = implode('/', array_reverse(explode('-', $data)));
$horaF = date("H:i", strtotime($hora));


if($status == 'Concluído'){		
	$classe_linha = '';
}else{		
	$classe_linha = 'text-muted';
}

$ocultar_confirmacao = '';

if($status == 'Agendado'){
	$imagem = 'icone-relogio.png';
	$classe_status = '';	
}else if($status == 'Finalizado'){
	$imagem = 'icone-relogio-verde.png';
	$classe_status = 'ocultar';
	$ocultar_confirmacao = 'ocultar';
}if($status == 'Confirmado'){
	$imagem = 'icone-relogio-azul.png';
	$classe_status = 'ocultar';
	$ocultar_confirmacao = 'ocultar';
}

if($tipo_pagamento != ''){
	$classe_pago = 'icone-money.png';
	$ocultar_pago = 'ocultar';
}else{
	$classe_pago = 'icone-money-red.png';
	$ocultar_pago = '';
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


//retirar aspas do texto do obs
$obs = str_replace('"', "**", $obs);

echo <<<HTML
			<div class="col-xs-12 col-md-4 widget cardTarefas">
        		<div class="r3_counter_box">

				<li class="dropdown head-dpdn2" style="list-style-type: none;">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<button type="button" class="close" title="Excluir agendamento" style="margin-top: -10px">
					<span aria-hidden="true"><big>&times;</big></span>
				</button>
				</a>

		<ul class="dropdown-menu" style="margin-left:-30px;">
		<li>
		<div class="notification_desc2">
		<p>Confirmar Exclusão? <a href="#" onclick="excluir('{$id}', '{$horaF}')"><span class="text-danger">Sim</span></a></p>
		</div>
		</li>										
		</ul>
		</li>


		<div class="row">
        		<div class="col-md-3">


				<li class="dropdown head-dpdn2" style="list-style-type: none;">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<img class="icon-rounded-vermelho" src="img/{$imagem}" width="45px" height="45px">
				</a>

		<ul class="dropdown-menu" style="margin-left:-30px;">
		<li>
		<div class="notification_desc2">
		<p>Observações: {$obs}</p>
		</div>
		</li>										
		</ul>
		</li>
        			 
        		</div>
        		<div class="col-md-9">
        			<h5><strong>{$horaF}</strong> 

        			<li class="dropdown head-dpdn2" style="list-style-type: none; display:inline-block;">
				<a class="{$ocultar_confirmacao}" href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<img class="icon-rounded-vermelho" src="img/check-square.png" width="15px" height="15px">
				</a>

		<ul class="dropdown-menu" style="margin-left:-100px;">
		<li>
		<div class="notification_desc2">
		<p>Confirma o Agendamento? <a href="#" onclick="confirmar('{$id}', '{$horaF}')"><span class="text-success">Sim</span></a></p>
		</div>
		</li>										
		</ul>
		</li>


        	

        			<a class="{$ocultar_pago}" href="#" onclick="baixar('{$id}', '{$cliente}', '{$nome_serv}', 
					'{$valor_serv}','{$aceita_convenio}','{$funcionario}','{$servico}')" title="Baixa no Pagamento" class=""> <img class="icon-rounded-vermelho" src="img/{$classe_pago}" width="15px" height="15px"></a>


        			</h5>

        			
        		</div>


        		</div>
        		
        					
        		<hr style="margin-top:-2px; margin-bottom: 3px">                    
                    <div class="stats esc" align="center">
                      <span>
                      
                        <small> {$nome_cliente}<br> (<i><span style="color:#061f9c; font-size: 12px">{$nome_serv}</span></i>)</small></span>
                    </div>
                </div>
        	</div>
HTML;
}

}else{
	echo 'Nenhum horário para essa Data!';
}

?>





<script type="text/javascript">
	function baixar(id, cliente, servico, valor_servico, convenio, funcionario, id_servico){

		if(convenio != "Sim"){
			$('#div_convenio').hide();
		}
	
		$('#id_agd').val(id);
		$('#cliente_agd').val(cliente);		
		$('#servico_agd').val(id_servico);	
		$('#valor_serv_agd').val(valor_servico);	
		$('#funcionario_agd').val(funcionario).change();	
		$('#titulo_servico').text(servico);
		$('#descricao_serv_agd').text(servico);
		$('#modalServico').modal('show');
	}

	function confirmar(id){
		 $.ajax({
        url: 'paginas/' + pag + "/confirmar.php",
        method: 'POST',
        data: {id},
        dataType: "html",

        success:function(mensagem){
             
            if (mensagem.trim() == "Confirmado com Sucesso") {  

                listar();
            } else {
                $('#mensagem-excluir').addClass('text-danger')
                $('#mensagem-excluir').text(mensagem)
            }
        }
    });
	}
</script>
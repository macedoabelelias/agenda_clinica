<?php 
$tabela = 'procedimentos';
require_once("../../../conexao.php");

$exame = @$_POST['p1'];

$total_exames = 0;
$total_consultas = 0;
$query = $pdo->query("SELECT * from $tabela where exame LIKE '%$exame%' order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
echo <<<HTML
<small>
	<table class="table table-hover" id="tabela">
	<thead> 
	<tr> 
	<th>Nome</th>	
	<th class="esc">Valor</th>	
	<th class="esc">Tempo</th>	
	<th class="esc">Exame</th>			
	<th class="esc">Convênio</th>	
	<th>Ações</th>
	</tr> 
	</thead> 
	<tbody>	
HTML;


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
	}else{
		$icone = 'fa-square-o';
		$titulo_link = 'Ativar Usuário';
		$acao = 'Sim';
		$classe_ativo = '#c4c4c4';
	}

	if($exame == 'Sim'){
		$classe_exame = 'red';
		$total_exames += 1;
	}else{
		$classe_exame = 'blue';
		$total_consultas += 1;
	}

	$classe_convenio = '';
	if($convenio == 'Não'){
		$classe_convenio = 'red';
	}


echo <<<HTML
<tr style="color:{$classe_ativo}">
<td style="color:{$classe_exame}">
<input type="checkbox" id="seletor-{$id}" class="form-check-input" onchange="selecionar('{$id}')">
{$nome}
</td>
<td class="esc">{$valor}</td>
<td class="esc">{$tempo} Minutos</td>
<td class="esc" style="color:{$classe_exame}">{$exame} </td>
<td class="esc" style="color:{$classe_convenio}">{$convenio} </td>
<td>
	<big><a href="#" onclick="editar('{$id}','{$nome}','{$valor}','{$tempo}','{$exame}','{$convenio}')" title="Editar Dados"><i class="fa fa-edit text-primary"></i></a></big>

	<li class="dropdown head-dpdn2" style="display: inline-block;">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><big><i class="fa fa-trash-o text-danger"></i></big></a>

		<ul class="dropdown-menu" style="margin-left:-230px;">
		<li>
		<div class="notification_desc2">
		<p>Confirmar Exclusão? <a href="#" onclick="excluir('{$id}')"><span class="text-danger">Sim</span></a></p>
		</div>
		</li>										
		</ul>
</li>

<big><a href="#" onclick="ativar('{$id}', '{$acao}')" title="{$titulo_link}"><i class="fa {$icone} text-success"></i></a></big>


</td>
</tr>
HTML;

}


echo <<<HTML
</tbody>
<small><div align="center" id="mensagem-excluir"></div>
</small>
</table>
<br>
<div align="right">
<span style="margin-right: 50px">Total Exames: <span style="color:red">{$total_exames}</span></span>
<span style="">Total Consultas: <span style="color:blue">{$total_consultas}</span></span>
</div>
HTML;

}else{
	echo '<small>Nenhum Registro Encontrado!</small>';
}
?>



<script type="text/javascript">
	$(document).ready( function () {		
    $('#tabela').DataTable({
    	"language" : {
            //"url" : '//cdn.datatables.net/plug-ins/1.13.2/i18n/pt-BR.json'
        },
        "ordering": false,
		"stateSave": true
    });
} );
</script>

<script type="text/javascript">
	function editar(id, nome, valor, tempo, exame, convenio){
		$('#mensagem').text('');
    	$('#titulo_inserir').text('Editar Registro');

    	$('#id').val(id);
    	$('#nome').val(nome);
    	$('#valor').val(valor);
    	$('#tempo').val(tempo);
    	$('#exame').val(exame).change();
    	$('#convenio').val(convenio).change();   	

    	$('#modalForm').modal('show');
	}


	
	function limparCampos(){
		$('#id').val('');
    	$('#nome').val('');
    	$('#valor').val('');
    	$('#tempo').val('');
    	$('#exame').val('Sim').change();
    	$('#convenio').val('Sim').change();

    	$('#ids').val('');
    	$('#btn-deletar').hide();	
	}

	function selecionar(id){

		var ids = $('#ids').val();

		if($('#seletor-'+id).is(":checked") == true){
			var novo_id = ids + id + '-';
			$('#ids').val(novo_id);
		}else{
			var retirar = ids.replace(id + '-', '');
			$('#ids').val(retirar);
		}

		var ids_final = $('#ids').val();
		if(ids_final == ""){
			$('#btn-deletar').hide();
		}else{
			$('#btn-deletar').show();
		}
	}

	function deletarSel(){
		var ids = $('#ids').val();
		var id = ids.split("-");
		
		for(i=0; i<id.length-1; i++){
			excluir(id[i]);			
		}

		limparCampos();
	}


	


	
</script>
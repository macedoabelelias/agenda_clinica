<?php 
$tabela = 'pacientes';
require_once("../../../conexao.php");

$query = $pdo->query("SELECT * from $tabela order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
echo <<<HTML
<small>
	<table class="table table-hover" id="tabela">
	<thead> 
	<tr> 
	<th>Nome</th>	
	<th class="esc">CPF</th>	
	<th class="esc">Telefone</th>	
	<th class="esc">Nascimento</th>
	<th class="esc">Convênio</th>
	<th class="esc">Tipo Sanguíneo</th>		
	<th>Ações</th>
	</tr> 
	</thead> 
	<tbody>	
HTML;


for($i=0; $i<$linhas; $i++){
	$id = $res[$i]['id'];
	$nome = $res[$i]['nome'];
	$telefone = $res[$i]['telefone'];
	$cpf = $res[$i]['cpf'];	
	$endereco = $res[$i]['endereco'];	
	$data_cad = $res[$i]['data_cad'];
	$data_nasc = $res[$i]['data_nasc'];	
	$convenio = $res[$i]['convenio'];
	$tipo_sanguineo = $res[$i]['tipo_sanguineo'];
	$nome_responsavel = $res[$i]['nome_responsavel'];
	$cpf_responsavel = $res[$i]['cpf_responsavel'];
	$sexo = $res[$i]['sexo'];
	$obs = $res[$i]['obs'];

	$data_nascF = implode('/', array_reverse(explode('-', $data_nasc)));
	$data_cadF = implode('/', array_reverse(explode('-', $data_cad)));

	$query2 = $pdo->query("SELECT * from convenios where id = '$convenio'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$linhas2 = @count($res2);
if($linhas2 > 0){
	$nome_convenio = $res2[0]['nome'];
}else{
	$nome_convenio = 'Nenhum';
}


echo <<<HTML
<tr>
<td>
<input type="checkbox" id="seletor-{$id}" class="form-check-input" onchange="selecionar('{$id}')">
{$nome}
</td>
<td class="esc">{$cpf}</td>
<td class="esc">{$telefone}</td>
<td class="esc">{$data_nascF}</td>
<td class="esc">{$nome_convenio}</td>
<td class="esc">{$tipo_sanguineo}</td>
<td>
	<big><a href="#" onclick="editar('{$id}','{$nome}','{$telefone}','{$cpf}','{$endereco}','{$data_nasc}','{$tipo_sanguineo}','{$nome_responsavel}','{$cpf_responsavel}','{$convenio}','{$sexo}','{$obs}')" title="Editar Dados"><i class="fa fa-edit text-primary"></i></a></big>

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

<big><a href="#" onclick="mostrar('{$nome}','{$telefone}','{$cpf}','{$endereco}','{$data_nascF}','{$tipo_sanguineo}','{$nome_responsavel}','{$cpf_responsavel}','{$nome_convenio}', '{$data_cadF}','{$sexo}','{$obs}')" title="Mostrar Dados"><i class="fa fa-info-circle text-primary"></i></a></big>


	<big><a href="#" onclick="arquivo('{$id}', '{$nome}')" title="Inserir / Ver Arquivos"><i class="fa fa-file-o " style="color:#22146e"></i></a></big>


</td>
</tr>
HTML;

}


echo <<<HTML
</tbody>
<small><div align="center" id="mensagem-excluir"></div></small>
</table>
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
	function editar(id, nome, telefone, cpf, endereco, data_nasc, tipo_sanguineo, nome_responsavel, cpf_responsavel, convenio, sexo, obs){
		$('#mensagem').text('');
    	$('#titulo_inserir').text('Editar Registro');

    	$('#id').val(id);
    	$('#nome').val(nome);
    	$('#cpf').val(cpf);
    	$('#telefone').val(telefone);
    	$('#endereco').val(endereco);
    	$('#data_nasc').val(data_nasc);
    	$('#nome_responsavel').val(nome_responsavel);
    	$('#tipo_sanguineo').val(tipo_sanguineo).change();
    	$('#convenio').val(convenio).change();
    	$('#cpf_responsavel').val(cpf_responsavel);
    	$('#cpf').val(cpf);
    	$('#sexo').val(sexo).change();
    	$('#obs').val(obs);

    	$('#modalForm').modal('show');
	}


	function mostrar(nome, telefone, cpf, endereco, data_nasc, tipo_sanguineo, nome_responsavel, cpf_responsavel, convenio, data_cad, sexo, obs){
		    	
    	$('#titulo_dados').text(nome);
    	$('#cpf_dados').text(cpf);
    	$('#telefone_dados').text(telefone);
    	$('#endereco_dados').text(endereco);
    	$('#data_nasc_dados').text(data_nasc);
    	$('#tipo_sanguineo_dados').text(tipo_sanguineo);
    	$('#nome_responsavel_dados').text(nome_responsavel);
    	$('#cpf_responsavel_dados').text(cpf_responsavel);
    	$('#convenio_dados').text(convenio);
    	$('#data_cad_dados').text(data_cad);
    	$('#sexo_dados').text(sexo);
    	$('#obs_dados').text(obs);
    	

    	$('#modalDados').modal('show');
	}

	function limparCampos(){
		$('#id').val('');
    	$('#nome').val('');
    	$('#cpf').val('');
    	$('#telefone').val('');
    	$('#endereco').val('');
    	$('#data_nasc').val('');
    	$('#nome_responsavel').val('');
    	$('#cpf_responsavel').val('');
    	$('#obs').val('');


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



		function arquivo(id, nome){
    $('#id-arquivo').val(id);    
    $('#nome-arquivo').text(nome);
    $('#modalArquivos').modal('show');
    $('#mensagem-arquivo').text(''); 
    listarArquivos();   
}

	
</script>
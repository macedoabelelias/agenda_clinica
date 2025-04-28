<?php 
$tabela = 'func_proc';
require_once("../../../conexao.php");

$usuario = $_POST['id'];

$query = $pdo->query("SELECT * from $tabela where funcionario = '$usuario'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
echo <<<HTML
<small>
	<table class="table table-hover" id="">
	<thead> 
	<tr> 
	<th>Procedimento</th>		
	<th>Excluir</th>
	</tr> 
	</thead> 
	<tbody>	
HTML;


for($i=0; $i<$linhas; $i++){
	$id = $res[$i]['id'];
	$procedimento = $res[$i]['procedimento'];

	$query2 = $pdo->query("SELECT * from procedimentos where id = '$procedimento'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$nome_procedimento = $res2[0]['nome']; 	

echo <<<HTML
<tr>
<td class="">{$nome_procedimento}</td>
<td>

	<li class="dropdown head-dpdn2" style="display: inline-block;">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><big><i class="fa fa-trash-o text-danger"></i></big></a>

		<ul class="dropdown-menu" style="margin-left:-230px;">
		<li>
		<div class="notification_desc2">
		<p>Confirmar Exclusão? <a href="#" onclick="excluirProcedimento('{$id}', '{$usuario}')"><span class="text-danger">Sim</span></a></p>
		</div>
		</li>										
		</ul>
</li>



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

	function excluirProcedimento(id, usuario){
		    	
    	$.ajax({
        url: 'paginas/' + pag + "/excluir_procedimento.php",
        method: 'POST',
        data: {id},
        dataType: "html",

        success:function(mensagem){
            if (mensagem.trim() == "Excluído com Sucesso") {
                listarProcedimentos(usuario);
            } 
        }
    });
	}

	


	
</script>
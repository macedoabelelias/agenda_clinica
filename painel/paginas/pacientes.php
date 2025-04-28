<?php 
$pag = 'pacientes';

if(@$pacientes == 'ocultar'){
	echo "<script>window.location='../index.php'</script>";
	exit();
}

?>
<a onclick="inserir()" type="button" class="btn btn-primary"><span class="fa fa-plus"></span> Paciente</a>



<li class="dropdown head-dpdn2" style="display: inline-block;">		
	<a href="#" data-toggle="dropdown"  class="btn btn-danger dropdown-toggle" id="btn-deletar" style="display:none"><span class="fa fa-trash-o"></span> Deletar</a>

	<ul class="dropdown-menu">
		<li>
			<div class="notification_desc2">
				<p>Excluir Selecionados? <a href="#" onclick="deletarSel()"><span class="text-danger">Sim</span></a></p>
			</div>
		</li>										
	</ul>
</li>

<div class="bs-example widget-shadow" style="padding:15px" id="listar">

</div>


<input type="hidden" id="ids">

<!-- Modal Perfil -->
<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_inserir"></span></h4>
				<button id="btn-fechar" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="form">
				<div class="modal-body">


					<div class="row">
						<div class="col-md-3">							
							<label>Nome</label>
							<input type="text" class="form-control" id="nome" name="nome" placeholder="Seu Nome" required>							
						</div>


						<div class="col-md-3">							
							<label>CPF</label>
							<input type="text" class="form-control" id="cpf" name="cpf" placeholder="CPF" required>							
						</div>

						<div class="col-md-3">							
							<label>Telefone</label>
							<input type="text" class="form-control" id="telefone" name="telefone" placeholder="Seu Telefone" required>							
						</div>


						<div class="col-md-3">							
							<label>Data Nascimento</label>
							<input type="date" class="form-control" id="data_nasc" name="data_nasc" required>							
						</div>

						
					</div>


					<div class="row">	
											

							<div class="col-md-6">							
								<label>Endereço</label>
								<input type="text" class="form-control" id="endereco" name="endereco" placeholder="Seu Endereço" >							
							</div>	


							<div class="col-md-2">	
								<label>Sexo</label>
								<select class="form-control" name="sexo" id="sexo">
									<option value="M">M</option>
									<option value="F">F</option>
									
								</select>						
							</div>

							

							<div class="col-md-2">	
								<label>Tipo Sanguíneo</label>
								<select class="form-control" name="tipo_sanguineo" id="tipo_sanguineo">
									<option value="O">O</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="AB">AB</option>
								</select>						
							</div>


							<div class="col-md-2">	
								<label>Convênio</label>
								<select class="form-control" name="convenio" id="convenio">
									<option value="0">Nenhum</option>
									<?php 
									$query = $pdo->query("SELECT * from convenios order by id asc");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									$linhas = @count($res);
									if($linhas > 0){
										for($i=0; $i<$linhas; $i++){
											?>
											<option value="<?php echo $res[$i]['id'] ?>"><?php echo $res[$i]['nome'] ?></option>

										<?php } } ?>
									</select>	

								</div>						
							</div>


							<div class="row">
								<div class="col-md-12">	
									<label>Observações</label>
									<textarea class="form-control" name="obs" id="obs"></textarea>
								</div>
							</div>

							<hr>

							<div class="row">
						<div class="col-md-5">							
							<label>Nome Responsável</label>
							<input type="text" class="form-control" id="nome_responsavel" name="nome_responsavel" placeholder="Seu Nome">							
						</div>


						<div class="col-md-3">							
							<label>CPF Responsável</label>
							<input type="text" class="form-control" id="cpf_responsavel" name="cpf_responsavel" placeholder="CPF Responsável">							
						</div>					
						
					</div>


				
						<input type="hidden" class="form-control" id="id" name="id">					

						<br>
						<small><div id="mensagem" align="center"></div></small>
					</div>
					<div class="modal-footer">       
						<button type="submit" class="btn btn-primary">Salvar</button>
					</div>
				</form>
			</div>
		</div>
	</div>





	<!-- Modal Dados -->
	<div class="modal fade" id="modalDados" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_dados"></span></h4>
					<button id="btn-fechar-dados" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<div class="modal-body">
					<div class="row" style="margin-top: 0px">
						<div class="col-md-6" style="margin-bottom: 5px">
							<span><b>Telefone: </b></span><span id="telefone_dados"></span>
						</div>
						

						<div class="col-md-6" style="margin-bottom: 5px">
							<span><b>CPF: </b></span><span id="cpf_dados"></span>
						</div>

						<div class="col-md-6" style="margin-bottom: 5px">
							<span><b>Data Nascimento: </b></span><span id="data_nasc_dados"></span>
						</div>


						<div class="col-md-6" style="margin-bottom: 5px">
							<span><b>Tipo Sanguíneo: </b></span><span id="tipo_sanguineo_dados"></span>
						</div>

						<div class="col-md-6" style="margin-bottom: 5px">
							<span><b>Convênio: </b></span><span id="convenio_dados"></span>
						</div>

					
						<div class="col-md-6" style="margin-bottom: 5px">
							<span><b>Data Cadastro: </b></span><span id="data_cad_dados"></span>
						</div>

						<div class="col-md-6" style="margin-bottom: 5px">
							<span><b>Sexo: </b></span><span id="sexo_dados"></span>
						</div>

						<div class="col-md-12" style="margin-bottom: 5px">
							<span><b>Endereço: </b></span><span id="endereco_dados"></span>
						</div>


						

						<div class="col-md-6" style="margin-bottom: 5px">
							<span><b>Responsável: </b></span><span id="nome_responsavel_dados"></span>
						</div>


						<div class="col-md-6" style="margin-bottom: 5px">
							<span><b>CPF Responsável: </b></span><span id="cpf_responsavel_dados"></span>
						</div>


						<div class="col-md-12" style="margin-bottom: 5px; margin-top: 25px">
							<span><b>Observações: </b></span><span id="obs_dados"></span>
						</div>

						
					</div>
				</div>

			</div>
		</div>
	</div>




	<!-- Modal Arquivos -->
	<div class="modal fade" id="modalArquivos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="tituloModal">Gestão de Arquivos - <span id="nome-arquivo"> </span></h4>
					<button id="btn-fechar-arquivos" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form id="form-arquivos" method="post">
					<div class="modal-body">

						<div class="row">
							<div class="col-md-8">						
								<div class="form-group"> 
									<label>Arquivo</label> 
									<input class="form-control" type="file" name="arquivo_conta" onChange="carregarImgArquivos();" id="arquivo_conta">
								</div>	
							</div>
							<div class="col-md-4" style="margin-top:-10px">	
								<div id="divImgArquivos">
									<img src="images/arquivos/sem-foto.png"  width="60px" id="target-arquivos">									
								</div>					
							</div>




						</div>

						<div class="row" style="margin-top:-40px">
							<div class="col-md-8">
								<input type="text" class="form-control" name="nome-arq"  id="nome-arq" placeholder="Nome do Arquivo * " required>
							</div>

							<div class="col-md-4">										 
								<button type="submit" class="btn btn-primary">Inserir</button>
							</div>
						</div>

						<hr>

						<small><div id="listar-arquivos"></div></small>

						<br>
						<small><div align="center" id="mensagem-arquivo"></div></small>

						<input type="hidden" class="form-control" name="id-arquivo"  id="id-arquivo">


					</div>
				</form>
			</div>
		</div>




	<script type="text/javascript">var pag = "<?=$pag?>"</script>
	<script src="js/ajax.js"></script>



<script type="text/javascript">
			function carregarImgArquivos() {
				var target = document.getElementById('target-arquivos');
				var file = document.querySelector("#arquivo_conta").files[0];

				var arquivo = file['name'];
				resultado = arquivo.split(".", 2);

				if(resultado[1] === 'pdf'){
					$('#target-arquivos').attr('src', "images/pdf.png");
					return;
				}

				if(resultado[1] === 'rar' || resultado[1] === 'zip'){
					$('#target-arquivos').attr('src', "images/rar.png");
					return;
				}

				if(resultado[1] === 'doc' || resultado[1] === 'docx' || resultado[1] === 'txt'){
					$('#target-arquivos').attr('src', "images/word.png");
					return;
				}


				if(resultado[1] === 'xlsx' || resultado[1] === 'xlsm' || resultado[1] === 'xls'){
					$('#target-arquivos').attr('src', "images/excel.png");
					return;
				}


				if(resultado[1] === 'xml'){
					$('#target-arquivos').attr('src', "images/xml.png");
					return;
				}



				var reader = new FileReader();

				reader.onloadend = function () {
					target.src = reader.result;
				};

				if (file) {
					reader.readAsDataURL(file);

				} else {
					target.src = "";
				}
			}
		</script>




		<script type="text/javascript">
			$("#form-arquivos").submit(function () {
				event.preventDefault();
				var formData = new FormData(this);

				$.ajax({
					url: 'paginas/' + pag + "/arquivos.php",
					type: 'POST',
					data: formData,

					success: function (mensagem) {
						$('#mensagem-arquivo').text('');
						$('#mensagem-arquivo').removeClass()
						if (mensagem.trim() == "Inserido com Sucesso") {                    
						//$('#btn-fechar-arquivos').click();
						$('#nome-arq').val('');
						$('#arquivo_conta').val('');
						$('#target-arquivos').attr('src','images/arquivos/sem-foto.png');
						listarArquivos();
					} else {
						$('#mensagem-arquivo').addClass('text-danger')
						$('#mensagem-arquivo').text(mensagem)
					}

				},

				cache: false,
				contentType: false,
				processData: false,

			});

			});
		</script>

		<script type="text/javascript">
			function listarArquivos(){
				var id = $('#id-arquivo').val();	
				$.ajax({
					url: 'paginas/' + pag + "/listar-arquivos.php",
					method: 'POST',
					data: {id},
					dataType: "text",

					success:function(result){
						$("#listar-arquivos").html(result);
					}
				});
			}

		</script>

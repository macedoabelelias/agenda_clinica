<?php 
@session_start();
require_once("../conexao.php");
require_once("verificar.php");

$pag_inicial = 'home';
if(@$_SESSION['nivel'] != 'Administrador'){
	require_once("verificar_permissoes.php");
}

if(@$_GET['pagina'] != ""){
	$pagina = @$_GET['pagina'];
}else{
	$pagina = $pag_inicial;
}

$id_usuario = @$_SESSION['id'];
$query = $pdo->query("SELECT * from usuarios where id = '$id_usuario'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
	$nome_usuario = $res[0]['nome'];
	$email_usuario = $res[0]['email'];
	$telefone_usuario = $res[0]['telefone'];
	$senha_usuario = $res[0]['senha'];
	$nivel_usuario = $res[0]['nivel'];
	$foto_usuario = $res[0]['foto'];
	$endereco_usuario = $res[0]['endereco'];
	$atendimento_usuario = $res[0]['atendimento'];
}

?>
<!DOCTYPE HTML>
<html>
<head>
	<title><?php echo $nome_sistema ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="shortcut icon" href="../img/icone.png" type="image/x-icon">

	<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

	<!-- Bootstrap Core CSS -->
	<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />

	<!-- Custom CSS -->
	<link href="css/style.css" rel='stylesheet' type='text/css' />

	<!-- font-awesome icons CSS -->
	<link href="css/font-awesome.css" rel="stylesheet"> 
	<!-- //font-awesome icons CSS-->

	<!-- side nav css file -->
	<link href='css/SidebarNav.min.css' media='all' rel='stylesheet' type='text/css'/>
	<!-- //side nav css file -->

	<link rel="stylesheet" href="css/monthly.css">

	<!-- js-->
	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/modernizr.custom.js"></script>

	<!--webfonts-->
	<link href="//fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
	<!--//webfonts--> 

	<!-- chart -->
	<script src="js/Chart.js"></script>
	<!-- //chart -->

	<!-- Metis Menu -->
	<script src="js/metisMenu.min.js"></script>
	<script src="js/custom.js"></script>
	<link href="css/custom.css" rel="stylesheet">
	<!--//Metis Menu -->
	<style>
		#chartdiv {
			width: 100%;
			height: 295px;
		}
	</style>
	<!--pie-chart --><!-- index page sales reviews visitors pie chart -->
	<script src="js/pie-chart.js" type="text/javascript"></script>
	<script type="text/javascript">

		$(document).ready(function () {
			$('#demo-pie-1').pieChart({
				barColor: '#2dde98',
				trackColor: '#eee',
				lineCap: 'round',
				lineWidth: 8,
				onStep: function (from, to, percent) {
					$(this.element).find('.pie-value').text(Math.round(percent) + '%');
				}
			});

			$('#demo-pie-2').pieChart({
				barColor: '#2dacd6',
				trackColor: '#eee',
				lineCap: 'butt',
				lineWidth: 8,
				onStep: function (from, to, percent) {
					$(this.element).find('.pie-value').text(Math.round(percent) + '%');
				}
			});

			$('#demo-pie-3').pieChart({
				barColor: '#d13c2c',
				trackColor: '#eee',
				lineCap: 'square',
				lineWidth: 8,
				onStep: function (from, to, percent) {
					$(this.element).find('.pie-value').text(Math.round(percent) + '%');
				}
			});


		});

	</script>
	<!-- //pie-chart --><!-- index page sales reviews visitors pie chart -->


<link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css"/> <script src="DataTables/datatables.min.js"></script>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<style type="text/css">
		.select2-selection__rendered {
			line-height: 36px !important;
			font-size:16px !important;
			color:#666666 !important;

		}

		.select2-selection {
			height: 36px !important;
			font-size:16px !important;
			color:#666666 !important;

		}
	</style> 
	
</head> 
<body class="cbp-spmenu-push">
	<div class="main-content">
		<div class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
			<!--left-fixed -navigation-->
			<aside class="sidebar-left" style="overflow: scroll; height:100%; scrollbar-width: thin;">
				<nav class="navbar navbar-inverse">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".collapse" aria-expanded="false">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<h1><a class="navbar-brand" href="index.php"><span class="fa fa-stethoscope"></span> Clínicas<span class="dashboard_text"><?php echo $nome_sistema ?></span></a></h1>
					</div>
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="sidebar-menu">
							<li class="header">MENU NAVEGAÇÃO</li>
							<li class="treeview <?php echo $home ?>">
								<a href="index.php">
									<i class="fa fa-dashboard"></i> <span>Home</span>
								</a>
							</li>
							<li class="treeview <?php echo $menu_pessoas ?>">
								<a href="#">
									<i class="fa fa-users"></i>
									<span>Pessoas</span>
									<i class="fa fa-angle-left pull-right"></i>
								</a>
								<ul class="treeview-menu">
									<li class="<?php echo $usuarios ?>"><a href="index.php?pagina=usuarios"><i class="fa fa-angle-right"></i> Usuários</a></li>
									
									<li class="<?php echo $funcionarios ?>"><a href="index.php?pagina=funcionarios"><i class="fa fa-angle-right"></i> Funcionários</a></li>

									<li class="<?php echo $pacientes ?>"><a href="index.php?pagina=pacientes"><i class="fa fa-angle-right"></i> Pacientes</a></li>
								</ul>
							</li>

							<li class="treeview <?php echo $menu_cadastros ?>">
								<a href="#">
									<i class="fa fa-plus"></i>
									<span>Cadastros</span>
									<i class="fa fa-angle-left pull-right"></i>
								</a>
								<ul class="treeview-menu">

									<li class="<?php echo $procedimentos ?>"><a href="index.php?pagina=procedimentos"><i class="fa fa-angle-right"></i> Procedimentos</a></li>

									<li class="<?php echo $convenios ?>"><a href="index.php?pagina=convenios"><i class="fa fa-angle-right"></i> Convênio / Plano</a></li>

									<li class="<?php echo $cargos ?>"><a href="index.php?pagina=cargos"><i class="fa fa-angle-right"></i> Cargos</a></li>

									<li class="<?php echo $formas_pgto ?>"><a href="index.php?pagina=formas_pgto"><i class="fa fa-angle-right"></i> Formas de Pagamento</a></li>

									<li class="<?php echo $grupo_acessos ?>"><a href="index.php?pagina=grupo_acessos"><i class="fa fa-angle-right"></i> Grupos</a></li>

									<li class="<?php echo $acessos ?>"><a href="index.php?pagina=acessos"><i class="fa fa-angle-right"></i> Acessos</a></li>


									<li class="<?php echo $frequencias ?>"><a href="index.php?pagina=frequencias"><i class="fa fa-angle-right"></i> Frequências</a></li>
									
								</ul>
							</li>



							<li class="treeview <?php echo $menu_financeiro ?>">
								<a href="#">
									<i class="fa fa-usd"></i>
									<span>Financeiro</span>
									<i class="fa fa-angle-left pull-right"></i>
								</a>
								<ul class="treeview-menu">

									<li class="<?php echo $receber ?>"><a href="index.php?pagina=receber"><i class="fa fa-angle-right"></i> Recebimentos</a></li>

									<li class="<?php echo $pagar ?>"><a href="index.php?pagina=pagar"><i class="fa fa-angle-right"></i> Despesas / Pagamentos</a></li>


									<li class="<?php echo $comissoes ?>"><a href="index.php?pagina=comissoes"><i class="fa fa-angle-right"></i> Comissões</a></li>


									<li class="<?php echo $rel_lucro ?>"><a href="" data-toggle="modal" data-target="#modalRelLucro"><i class="fa fa-angle-right"></i> Demonstrativo de Lucro</a></li>


									<li class="<?php echo $rel_financeiro ?>"><a href="" data-toggle="modal" data-target="#modalRelFin"><i class="fa fa-angle-right"></i> Relatórios Financeiro</a></li>

									
									
								</ul>
							</li>




								<li class="treeview <?php echo $menu_pessoas ?>">
								<a href="#">
									<i class="fa fa-calendar"></i>
									<span>Agendamentos</span>
									<i class="fa fa-angle-left pull-right"></i>
								</a>
								<ul class="treeview-menu">
									<li class="<?php echo $agendamentos ?>"><a href="index.php?pagina=agendamentos"><i class="fa fa-angle-right"></i> Agendamentos</a></li>


									<li class="<?php echo $rel_agendamentos ?>"><a href="" data-toggle="modal" data-target="#modalRelAgendamento"><i class="fa fa-angle-right"></i> Relatórios Agendamentos</a></li>
									
									
								</ul>
							</li>

							<?php if($atendimento_usuario == 'Sim'){ ?>
							<li class="treeview <?php echo $horarios ?>">
								<a href="index.php?pagina=horarios">
									<i class="fa fa-clock-o"></i> <span>Dias / Horários</span>
								</a>
							</li>


							<li class="treeview <?php echo $minhas_comissoes ?>">
								<a href="index.php?pagina=minhas_comissoes">
									<i class="fa fa-clock-o"></i> <span>Minhas Comissões</span>
								</a>
							</li>
							<?php } ?>

						</ul>
					</div>
					<!-- /.navbar-collapse -->
				</nav>
			</aside>
		</div>
		<!--left-fixed -navigation-->
		
		<!-- header-starts -->
		<div class="sticky-header header-section ">
			<div class="header-left">
				<!--toggle button start-->
				<button id="showLeftPush" data-toggle="collapse" data-target=".collapse"><i class="fa fa-bars"></i></button>
				<!--toggle button end-->
				<div class="profile_details_left"><!--notifications of menu start -->
					<ul class="nofitications-dropdown">
						<li class="dropdown head-dpdn ">
							<?php 
								//pagar_vencidas
									$query = $pdo->query("SELECT * from pagar where data_venc < curDate() and pago != 'Sim'");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									$pagar_vencidas = @count($res);
									if($pagar_vencidas > 1){
										$texto_pagar = 'contas à pagar vencidas';
									}else{
										$texto_pagar = 'conta à pagar vencida';
									}
							 ?>
							<a href="#" class="dropdown-toggle <?php echo $pagar ?>" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-money" style="color:#FFF"></i><span class="badge"><?php echo $pagar_vencidas ?></span></a>
							<ul class="dropdown-menu">
								<li>
									<div class="notification_header">
										<h3><?php echo $pagar_vencidas ?> <?php echo $texto_pagar ?></h3>
									</div>
								</li>

								<?php 
									$query = $pdo->query("SELECT * from pagar where data_venc < curDate() and pago != 'Sim' order by id asc limit 8");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									$pagar_vencidas = @count($res);
									if($pagar_vencidas > 0){
										for($i=0; $i<$pagar_vencidas; $i++){		
								 ?>

								<li><a href="#">									
									<div class="notification_desc">
										<small><?php echo $res[$i]['descricao'] ?> - <span style="color:red">R$ <?php echo $res[$i]['valor'] ?></span></small>
									</div>
									<div class="clearfix"></div>	
								</a></li>

							<?php } } ?>
							
								
								<li>
									<div class="notification_bottom">
										<a href="index.php?pagina=pagar">Ver todas as contas</a>
									</div> 
								</li>
							</ul>
						</li>





						<li class="dropdown head-dpdn">
							<?php 
								//pagar_vencidas
									$query = $pdo->query("SELECT * from receber where data_venc < curDate() and pago != 'Sim'");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									$pagar_vencidas = @count($res);
									if($pagar_vencidas > 1){
										$texto_pagar = 'contas à receber vencidas';
									}else{
										$texto_pagar = 'conta à receber vencida';
									}
							 ?>
							<a  href="#" class="dropdown-toggle <?php echo $receber ?>" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-money" style="color:#FFF"></i><span class="badge" style="background:green"><?php echo $pagar_vencidas ?></span></a>
							<ul class="dropdown-menu">
								<li>
									<div class="notification_header">
										<h3><?php echo $pagar_vencidas ?> <?php echo $texto_pagar ?></h3>
									</div>
								</li>

								<?php 
									$query = $pdo->query("SELECT * from receber where data_venc < curDate() and pago != 'Sim' order by id asc limit 8");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									$pagar_vencidas = @count($res);
									if($pagar_vencidas > 0){
										for($i=0; $i<$pagar_vencidas; $i++){		
								 ?>

								<li><a href="#">									
									<div class="notification_desc">
										<small><?php echo $res[$i]['descricao'] ?> - <span style="color:green">R$ <?php echo $res[$i]['valor'] ?></span></small>
									</div>
									<div class="clearfix"></div>	
								</a></li>

							<?php } } ?>
							
								
								<li>
									<div class="notification_bottom">
										<a href="index.php?pagina=pagar">Ver todas as contas</a>
									</div> 
								</li>
							</ul>
						</li>
						
						


					</ul>
					<div class="clearfix"> </div>
				</div>
				
			</div>
			<div class="header-right">

				<div class="profile_details">		
					<ul>
						<li class="dropdown profile_details_drop">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
								<div class="profile_img">	
									<span class="prfil-img"><img src="images/perfil/<?php echo $foto_usuario ?>" alt="" width="50px" height="50px"> </span> 
									<div class="user-name esc">
										<p><?php echo $nome_usuario ?></p>
										<span><?php echo $nivel_usuario ?></span>
									</div>
									<i class="fa fa-angle-down lnr"></i>
									<i class="fa fa-angle-up lnr"></i>
									<div class="clearfix"></div>	
								</div>	
							</a>
							<ul class="dropdown-menu drp-mnu">
								<li class="<?php echo $configuracoes ?>"> <a href="" data-toggle="modal" data-target="#modalConfig"><i class="fa fa-cog"></i> Configurações</a> </li> 
								<li> <a href="" data-toggle="modal" data-target="#modalPerfil"><i class="fa fa-user"></i> Perfil</a> </li> 								
								<li> <a href="logout.php"><i class="fa fa-sign-out"></i> Sair</a> </li>
							</ul>
						</li>
					</ul>
				</div>
				<div class="clearfix"> </div>				
			</div>
			<div class="clearfix"> </div>	
		</div>
		<!-- //header-ends -->




		<!-- main content start-->
		<div id="page-wrapper">
			<?php 
			require_once('paginas/'.$pagina.'.php');
			?>
		</div>





	</div>

	<!-- new added graphs chart js-->
	
	<script src="js/Chart.bundle.js"></script>
	<script src="js/utils.js"></script>
	
	
	
	<!-- Classie --><!-- for toggle left push menu script -->
	<script src="js/classie.js"></script>
	<script>
		var menuLeft = document.getElementById( 'cbp-spmenu-s1' ),
		showLeftPush = document.getElementById( 'showLeftPush' ),
		body = document.body;

		showLeftPush.onclick = function() {
			classie.toggle( this, 'active' );
			classie.toggle( body, 'cbp-spmenu-push-toright' );
			classie.toggle( menuLeft, 'cbp-spmenu-open' );
			disableOther( 'showLeftPush' );
		};


		function disableOther( button ) {
			if( button !== 'showLeftPush' ) {
				classie.toggle( showLeftPush, 'disabled' );
			}
		}
	</script>
	<!-- //Classie --><!-- //for toggle left push menu script -->

	<!--scrolling js-->
	<script src="js/jquery.nicescroll.js"></script>
	<script src="js/scripts.js"></script>
	<!--//scrolling js-->
	
	<!-- side nav js -->
	<script src='js/SidebarNav.min.js' type='text/javascript'></script>
	<script>
		$('.sidebar-menu').SidebarNav()
	</script>
	<!-- //side nav js -->
	
	
	
	<!-- Bootstrap Core JavaScript -->
	<script src="js/bootstrap.js"> </script>
	<!-- //Bootstrap Core JavaScript -->



	<!-- Mascaras JS -->
<script type="text/javascript" src="js/mascaras.js"></script>

<!-- Ajax para funcionar Mascaras JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script> 

	
</body>
</html>






<!-- Modal Perfil -->
<div class="modal fade" id="modalPerfil" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel">Alterar Dados</h4>
				<button id="btn-fechar-perfil" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="form-perfil">
			<div class="modal-body">
				

					<div class="row">
						<div class="col-md-6">							
								<label>Nome</label>
								<input type="text" class="form-control" id="nome_perfil" name="nome" placeholder="Seu Nome" value="<?php echo $nome_usuario ?>" required>							
						</div>

						<div class="col-md-6">							
								<label>Email</label>
								<input type="email" class="form-control" id="email_perfil" name="email" placeholder="Seu Nome" value="<?php echo $email_usuario ?>" required>							
						</div>
					</div>


					<div class="row">
						<div class="col-md-4">							
								<label>Telefone</label>
								<input type="text" class="form-control" id="telefone_perfil" name="telefone" placeholder="Seu Telefone" value="<?php echo $telefone_usuario ?>" required>							
						</div>

						<div class="col-md-4">							
								<label>Senha</label>
								<input type="password" class="form-control" id="senha_perfil" name="senha" placeholder="Senha" value="<?php echo $senha_usuario ?>" required>							
						</div>

						<div class="col-md-4">							
								<label>Confirmar Senha</label>
								<input type="password" class="form-control" id="conf_senha_perfil" name="conf_senha" placeholder="Confirmar Senha" value="" required>							
						</div>

						
					</div>


					<div class="row">
						<div class="col-md-12">	
							<label>Endereço</label>
							<input type="text" class="form-control" id="endereco_perfil" name="endereco" placeholder="Seu Endereço" value="<?php echo $endereco_usuario ?>" >	
						</div>
					</div>
					


					<div class="row">
						<div class="col-md-8">							
								<label>Foto</label>
								<input type="file" class="form-control" id="foto_perfil" name="foto" value="<?php echo $foto_usuario ?>" onchange="carregarImgPerfil()">							
						</div>

						<div class="col-md-4">								
							<img src="images/perfil/<?php echo $foto_usuario ?>"  width="80px" id="target-usu">								
							
						</div>

						
					</div>


					<input type="hidden" name="id_usuario" value="<?php echo $id_usuario ?>">
				

				<br>
				<small><div id="msg-perfil" align="center"></div></small>
			</div>
			<div class="modal-footer">       
				<button type="submit" class="btn btn-primary">Salvar</button>
			</div>
			</form>
		</div>
	</div>
</div>








<!-- Modal Config -->
<div class="modal fade" id="modalConfig" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel">Editar Configurações</h4>
				<button id="btn-fechar-config" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="form-config">
			<div class="modal-body">
				

					<div class="row">
						<div class="col-md-4">							
								<label>Nome do Projeto</label>
								<input type="text" class="form-control" id="nome_sistema" name="nome_sistema" placeholder="Delivery Interativo" value="<?php echo @$nome_sistema ?>" required>							
						</div>

						<div class="col-md-4">							
								<label>Email Sistema</label>
								<input type="email" class="form-control" id="email_sistema" name="email_sistema" placeholder="Email do Sistema" value="<?php echo @$email_sistema ?>" >							
						</div>


						<div class="col-md-4">							
								<label>Telefone Sistema</label>
								<input type="text" class="form-control" id="telefone_sistema" name="telefone_sistema" placeholder="Telefone do Sistema" value="<?php echo @$telefone_sistema ?>" required>							
						</div>

					</div>


					<div class="row">

						<div class="col-md-4">							
								<label>Telefone Fixo</label>
								<input type="text" class="form-control" id="telefone_fixo" name="telefone_fixo" placeholder="Telefone Fixo" value="<?php echo @$telefone_fixo ?>">							
						</div>


						<div class="col-md-8">							
								<label>Endereço <small>(Rua Número Bairro e Cidade)</small></label>
								<input type="text" class="form-control" id="endereco_sistema" name="endereco_sistema" placeholder="Rua X..." value="<?php echo @$endereco_sistema ?>" >							
						</div>

					</div>

					<div class="row">
						<div class="col-md-3">							
								<label>Comissão %</label>
								<input type="text" class="form-control" id="comissao_sistema" name="comissao_sistema" placeholder="Procedimentos" value="<?php echo @$comissao_sistema ?>">							
						</div>

						<div class="col-md-3">					
								<label>Horas Confirmação</label>
								<input type="text" class="form-control" id="horas_confirmacao" name="horas_confirmacao" placeholder="Mensagem Consulta" value="<?php echo @$horas_confirmacao ?>">							
						</div>

						<div class="col-md-3">					
								<label>Token Whatsapp</label>
								<input type="text" class="form-control" id="token" name="token" placeholder="Token Api Whatsapp" value="<?php echo @$token ?>">							
						</div>

						<div class="col-md-3">					
								<label>Instância Whatsapp</label>
								<input type="text" class="form-control" id="instancia" name="instancia" placeholder="Instancia Whatsapp" value="<?php echo @$instancia ?>">							
						</div>
					</div>



					<div class="row">
						<div class="col-md-2">
						<label>Marca D'Agua</label>	
							<select class="form-control" name="marca_dagua">
								<option value="Sim" <?php if($marca_dagua == 'Sim'){ echo 'selected'; } ?>>Sim</option>
								<option value="Não" <?php if($marca_dagua == 'Não'){ echo 'selected'; } ?>>Não</option>
							</select>
						</div>
					</div>

					

					<div class="row">
						<div class="col-md-4">						
								<div class="form-group"> 
									<label>Logo (*PNG)</label> 
									<input class="form-control" type="file" name="foto-logo" onChange="carregarImgLogo();" id="foto-logo">
								</div>						
							</div>
							<div class="col-md-2">
								<div id="divImg">
									<img src="../img/<?php echo $logo_sistema ?>"  width="80px" id="target-logo">									
								</div>
							</div>


							<div class="col-md-4">						
								<div class="form-group"> 
									<label>Ícone (*Png)</label> 
									<input class="form-control" type="file" name="foto-icone" onChange="carregarImgIcone();" id="foto-icone">
								</div>						
							</div>
							<div class="col-md-2">
								<div id="divImg">
									<img src="../img/<?php echo $icone_sistema ?>"  width="50px" id="target-icone">									
								</div>
							</div>

						
					</div>




					<div class="row">
							<div class="col-md-4">						
								<div class="form-group"> 
									<label>Logo Relatório (*Jpg)</label> 
									<input class="form-control" type="file" name="foto-logo-rel" onChange="carregarImgLogoRel();" id="foto-logo-rel">
								</div>						
							</div>
							<div class="col-md-2">
								<div id="divImg">
									<img src="../img/<?php echo @$logo_rel ?>"  width="80px" id="target-logo-rel">									
								</div>
							</div>


						
					</div>					
				

				<br>
				<small><div id="msg-config" align="center"></div></small>
			</div>
			<div class="modal-footer">       
				<button type="submit" class="btn btn-primary">Salvar</button>
			</div>
			</form>
		</div>
	</div>
</div>








<!-- Modal Rel Financeiro -->
<div class="modal fade" id="modalRelFin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel">Relatório Financeiro</h4>
				<button id="btn-fechar-rel" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="POST" action="rel/financeiro_class.php" target="_blank">
			<div class="modal-body">	
			<div class="row">
				<div class="col-md-4">
					<label>Data Inicial</label>
					<input type="date" name="dataInicial" class="form-control" value="<?php echo $data_atual ?>">
				</div>

				<div class="col-md-4">
					<label>Data Final</label>
					<input type="date" name="dataFinal" class="form-control" value="<?php echo $data_atual ?>">
				</div>

				<div class="col-md-4">
					<label>Filtro Data</label>
					<select name="filtro_data" class="form-control">
						<option value="data_lanc">Data de Lançamento</option>
						<option value="data_venc">Data de Vencimento</option>
						<option value="data_pgto">Data de Pagamento</option>
					</select>
				</div>
			</div>		


			<div class="row">				
				<div class="col-md-4">
					<label>Entradas / Saídas</label>
					<select name="filtro_tipo" class="form-control">
						<option value="receber">Entradas / Ganhos</option>
						<option value="pagar">Saídas / Despesas</option>
					</select>
				</div>

				<div class="col-md-4">
					<label>Tipo Lançamento</label>
					<select name="filtro_lancamento" class="form-control">
						<option value="">Tudo</option>
						<option value="Conta">Ganhos / Despesas</option>
						<option value="Pagamento">Pagamentos</option>
						<option value="Procedimento">Exames e Consultas</option>
						<option value="Comissão">Comissões</option>
						
					</select>
				</div>
				<div class="col-md-4">
					<label>Pendentes / Pago</label>
					<select name="filtro_pendentes" class="form-control">
						<option value="">Tudo</option>
						<option value="Não">Pendentes</option>
						<option value="Sim">Pago</option>
					</select>
				</div>			
			</div>		
				
						

			</div>
			<div class="modal-footer">       
				<button type="submit" class="btn btn-primary">Gerar</button>
			</div>
			</form>
		</div>
	</div>
</div>








<!-- Modal Rel Agendamento -->
<div class="modal fade" id="modalRelAgendamento" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel">Relatório Agendamentos / Procedimentos</h4>
				<button id="btn-fechar-rel" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="POST" action="rel/agendamentos_class.php" target="_blank">
			<div class="modal-body">	
			<div class="row">
				<div class="col-md-4">
					<label>Data Inicial</label>
					<input type="date" name="dataInicial" class="form-control" value="<?php echo $data_atual ?>">
				</div>

				<div class="col-md-4">
					<label>Data Final</label>
					<input type="date" name="dataFinal" class="form-control" value="<?php echo $data_atual ?>">
				</div>

				<div class="col-md-4">
					<label>Status</label>
					<select name="status" class="form-control">
						<option value="">Todos</option>
						<option value="Agendado">Agendado</option>
						<option value="Confirmado">Confirmado</option>
						<option value="Finalizado">Finalizado</option>
					</select>
				</div>
			</div>		


			<div class="row">				
				<div class="col-md-4">
					<label>Pago</label>
					<select name="pago" class="form-control">
						<option value="">Todos</option>
						<option value="Não">Não</option>
						<option value="Sim">Sim</option>
					</select>
				</div>

				<div class="col-md-4">
					<label>Convênio</label>
					<select name="convenio" class="form-control">
						<option value="">Tudo</option>
						<option value="0">Particular</option>
						<?php 
									$query = $pdo->query("SELECT * FROM convenios");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									$total_reg = @count($res);
									if($total_reg > 0){
										for($i=0; $i < $total_reg; $i++){
											foreach ($res[$i] as $key => $value){}
												echo '<option value="'.$res[$i]['id'].'">'.$res[$i]['nome'].'</option>';
										}
									}
									?>
						
					</select>
				</div>
				<div class="col-md-4">
					<label>Procedimentos</label>
					<select name="procedimento" class="form-control">
						<option value="">Todos</option>
						<?php 
									$query = $pdo->query("SELECT * FROM procedimentos");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									$total_reg = @count($res);
									if($total_reg > 0){
										for($i=0; $i < $total_reg; $i++){
											foreach ($res[$i] as $key => $value){}
												echo '<option value="'.$res[$i]['id'].'">'.$res[$i]['nome'].'</option>';
										}
									}
									?>
					</select>
				</div>			
			</div>		
				
						

			</div>
			<div class="modal-footer">       
				<button type="submit" class="btn btn-primary">Gerar</button>
			</div>
			</form>
		</div>
	</div>
</div>



<!-- Modal Rel Lucro -->
<div class="modal fade" id="modalRelLucro" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel">Relatório de Lucro</h4>
				<button id="btn-fechar-rel" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="POST" action="rel/lucro_class.php" target="_blank">
			<div class="modal-body">	
			<div class="row">
				<div class="col-md-4">
					<label>Data Inicial</label>
					<input type="date" name="dataInicial" class="form-control" value="<?php echo $data_atual ?>">
				</div>

				<div class="col-md-4">
					<label>Data Final</label>
					<input type="date" name="dataFinal" class="form-control" value="<?php echo $data_atual ?>">
				</div>

				
			</div>		


								

			</div>
			<div class="modal-footer">       
				<button type="submit" class="btn btn-primary">Gerar</button>
			</div>
			</form>
		</div>
	</div>
</div>




<script type="text/javascript">
	function carregarImgPerfil() {
    var target = document.getElementById('target-usu');
    var file = document.querySelector("#foto_perfil").files[0];
    
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
	$("#form-perfil").submit(function () {

		event.preventDefault();
		var formData = new FormData(this);

		$.ajax({
			url: "editar-perfil.php",
			type: 'POST',
			data: formData,

			success: function (mensagem) {
				$('#msg-perfil').text('');
				$('#msg-perfil').removeClass()
				if (mensagem.trim() == "Editado com Sucesso") {

					$('#btn-fechar-perfil').click();
					location.reload();				
						

				} else {

					$('#msg-perfil').addClass('text-danger')
					$('#msg-perfil').text(mensagem)
				}


			},

			cache: false,
			contentType: false,
			processData: false,

		});

	});
</script>






 <script type="text/javascript">
	$("#form-config").submit(function () {

		event.preventDefault();
		var formData = new FormData(this);

		$.ajax({
			url: "editar-config.php",
			type: 'POST',
			data: formData,

			success: function (mensagem) {
				$('#msg-config').text('');
				$('#msg-config').removeClass()
				if (mensagem.trim() == "Editado com Sucesso") {

					$('#btn-fechar-config').click();
					location.reload();				
						

				} else {

					$('#msg-config').addClass('text-danger')
					$('#msg-config').text(mensagem)
				}


			},

			cache: false,
			contentType: false,
			processData: false,

		});

	});
</script>




<script type="text/javascript">
	function carregarImgLogo() {
    var target = document.getElementById('target-logo');
    var file = document.querySelector("#foto-logo").files[0];
    
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
	function carregarImgLogoRel() {
    var target = document.getElementById('target-logo-rel');
    var file = document.querySelector("#foto-logo-rel").files[0];
    
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
	function carregarImgIcone() {
    var target = document.getElementById('target-icone');
    var file = document.querySelector("#foto-icone").files[0];
    
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
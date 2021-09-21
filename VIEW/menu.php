<?php


class Menu
{

	public function ExibeMenu()
	{
		@session_start();
?>


		<nav style="background-color: #4eb7c9 !important;" class="navbar navbar-expand-lg  navbar-dark bg-primary">
			<a class="navbar-brand" href="<?php echo $_SESSION['url'] ?>">Telemedicina</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
				<div class="navbar-nav">
					<a class="nav-item nav-link active" href="<?php echo $_SESSION['url'] ?>">Home</a>



                    <?php if($_SESSION['permissao'] == 1){ ?><!-- menu ADM -->
					
					<!-- dropdown paciente -->
					<div class="dropdown">
						<button style="background-color: #4eb7c9 !important; border:none;" class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
							Paciente
						</button>
						<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
							<li><a class="dropdown-item" href="<?php echo $_SESSION['url'] ?>cadastrarpaciente">Cadastro</a></li>
							<li><a class="dropdown-item" href="<?php echo $_SESSION['url'] ?>buscarpaciente">Busca</a></li>

						</ul>
					</div>
					<!--  -->

					<!-- dropdown medico -->
					<div class="dropdown">
						<button style="background-color: #4eb7c9 !important;border:none;" class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
							Medico
						</button>
						<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
							<li><a class="dropdown-item" href="<?php echo $_SESSION['url'] ?>cadastrarmedico">Cadastro</a></li>
							<li><a class="dropdown-item" href="<?php echo $_SESSION['url'] ?>buscarmedico">Busca</a></li>

						</ul>
					</div>
					<!--  -->

					<!-- dropdown administrador -->
					<div class="dropdown">
						<button style="background-color: #4eb7c9 !important;border:none;" class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
							Administrador
						</button>
						<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
							<li>
								<a class="btn-opcoes dropdown-item" target = "popup" onclick = "window.open('<?php echo $_SESSION['url'] ?>controller/mudarsenha.php','editar','width=600,height=400')" >
                                    Trocar Senha
                                </a>
							</li>
							<li><a class="dropdown-item" href="<?php echo $_SESSION['url'] ?>cadastraradm">Cadastrar ADM</a></li>

						</ul>
					</div>
					<!--  -->

					<!-- dropdown agendamento -->
					<div class="dropdown">
						<button style="background-color: #4eb7c9 !important;border:none;" class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
							Agendamento
						</button>
						<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
							<li>
							<a class="dropdown-item" href="<?php echo $_SESSION['url'] ?>agendar">Agendar Paciente</a>
							</li>
							<li>
							<a class="dropdown-item" href="<?php echo $_SESSION['url'] ?>novaagenda">Nova Agenda</a>
							</li>
							<li><a class="dropdown-item" href="<?php echo $_SESSION['url'] ?>buscaragendamedica">Consultar Agenda Médica</a></li>

						</ul>
					</div>
					<!--  -->

                    <?php } ?><!-- fim adm -->


					<?php if($_SESSION['permissao'] == 2){ ?><!-- menu Medico-->
					
					<!-- dropdown atendimento -->
					<div class="dropdown">
						<button style="background-color: #4eb7c9 !important; border:none;" class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
							Atendimento Medico
						</button>
						<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">

							<li><a class="dropdown-item" href="<?php echo $_SESSION['url'] ?>atendimentomedico/historico">Historico de Atendimento</a></li>
							<li><a class="dropdown-item" href="<?php echo $_SESSION['url'] ?>atendimentomedico/agenda">Agenda</a></li>

						</ul>
					</div>
					<!--  -->

                    <?php } ?><!-- fim Medico -->

					<?php if($_SESSION['permissao'] == 0){ ?><!-- menu Paciente-->
					
					<!-- dropdown atendimento -->
					<div class="dropdown">
						<button style="background-color: #4eb7c9 !important; border:none;" class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
							Atendimento Paciente
						</button>
						<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">

							<li><a class="dropdown-item" href="<?php echo $_SESSION['url'] ?>atendimentopaciente/receita">Receitas</a></li>
							<li><a class="dropdown-item" href="<?php echo $_SESSION['url'] ?>atendimentopaciente/atendimento">Historico de Atendimentos</a></li>

						</ul>
					</div>
					<!--  -->

                    <?php } ?><!-- fim Paciente -->
					
					<script>
						function signOut() {
							var auth2 = gapi.auth2.getAuthInstance();
							var dados = {
								sair: '<?php if ($_SESSION['permissao'] == 0) {echo 'paciente';} else if ($_SESSION['permissao'] == 1) {echo 'administrador';} else if ($_SESSION['permissao'] == 2) {echo 'medico';} ?>'
							};
							auth2.signOut().then(function() {
								$.post('../../CONTROLLER/logout.php', dados, function(retorno) {
									/* alert(retorno)  */
									if (retorno == true) {
										document.alert("logout bem sucedido");
									} else {

										document.alert("falha no logout");
									}
								});
							});

						}

						function onLoad() {
							gapi.load('auth2', function() {
								gapi.auth2.init();
							});
						}
					</script>
					<a class="nav-item nav-link active" href="<?php if ($_SESSION['permissao'] == 0) {
																	echo $_SESSION['url'] . "controller/logout.php?sair=cliente";
																} else if ($_SESSION['permissao'] == 1) {
																	echo $_SESSION['url'] . "controller/logout.php?sair=administrador";
																} else if ($_SESSION['permissao'] == 2) {
																	echo $_SESSION['url'] . "controller/logout.php?sair=medico";
																}
																?>
					" onclick="signOut();">Sair</a>
					<script src="https://apis.google.com/js/platform.js?onload=onLoad" async defer></script>


					<!-- <a class="nav-item nav-link disabled" href="#">Disabled</a> -->

					
				</div>

			</div>
			<?php if($_SESSION['permissao'] == 0 || $_SESSION['permissao'] == 2){ ?>										
			<div style="width: 20em; align-items:center;justify-content:flex-end;" class="float-right row google-data">
				<div style="width: 15em;text-align: right;color:#fff;"><?php echo"<b>Bem Vindo(a),</b> ". $_SESSION['nome']?></div>
				<img class="float-right" style="width: 4em; margin-right:1em; border-radius:50%;" src="<?php echo $_SESSION['image']?>" alt="profile">
			</div>
			<?php } ?>

		</nav>

<?php
	}
}

?>
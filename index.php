<?php 

@session_start();



header('Content-Type: text/html; charset=utf-8'); 

/* ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); */

?>

<?php
	
	$_SESSION['url']			= 'http://localhost:8001/'; // http://10.11.20.145:8001/ 
	$_SESSION['masterurl']		= '';
	$_SESSION['path'] 			= $_SERVER['DOCUMENT_ROOT'];
	$_SESSION['pcontroller']	= $_SESSION['path'] . '/CONTROLLER';
	$_SESSION['pview']			= $_SESSION['path'] . '/VIEW';
	$_SESSION['pmodel']			= $_SESSION['path'] . '/MODEL';
	
	setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
	date_default_timezone_set('America/Manaus');


	include_once $_SESSION['pcontroller'] . '/functions.php';

	/* Objeto da classe com as principais funções do site */
	$_objFunctions = new Functions();
	
	/* Verifica a página atual e inclui o arquivo responsável por executar a página */
	$_objFunctions->VerificaPaginaAtual();
	
?>

</body>
<?php 
session_start();

require_once($_SESSION['pmodel'] . '/Medico.php');
require_once($_SESSION['pmodel'] . '/Agendamento.php');

//echo $_POST['idpaciente'];
$dados = [];
$idmedico = $_POST['idmedico'];
$idagendamento = $_POST['idagendamento'];

$medico = $Medico->buscar_medico_id($idmedico);
$agenda = $Agendamento->buscar_agendamento_id($idagendamento);
$dados = ['statusmedico' => $medico['status'], 'link' => $agenda['linkatendimento'] , 'statusagendamento' => $agenda['status']];
//echo $medico['status'];

echo json_encode($dados);


?>
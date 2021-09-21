<?php 
session_start();

require_once($_SESSION['pmodel'] . '/Paciente.php');
require_once($_SESSION['pmodel'] . '/Agendamento.php');

//echo $_POST['idpaciente'];
$dados = [];
$idpaciente = $_POST['idpaciente'];
$idagendamento = $_POST['idagendamento'];

$paciente = $Paciente->buscar_paciente_id($idpaciente);
$agenda = $Agendamento->buscar_agendamento_id($idagendamento);


$dados = ['statuspaciente' => $paciente['status'], 'statusagendamento' => $agenda['status']];

//echo $paciente['status'];
echo json_encode($dados);


?>
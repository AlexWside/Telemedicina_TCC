<?php
// Inicializa a sessão.
session_start();
$sair = filter_input(INPUT_GET, 'sair', FILTER_SANITIZE_STRING);

if($sair  == "cliente"){
include_once $_SESSION['pmodel'] . '/Paciente.php';
$Paciente->paciente_offline($_SESSION['token']);
}

if($sair  == "medico"){
include_once $_SESSION['pmodel'] . '/Medico.php';
$Medico->medico_offline($_SESSION['token']);
}

 session_destroy();

 if($sair  == "administrador"){
 
 header("Location: http://localhost:8001/");
 
 }
 if($sair  == "cliente"){
    header("Location: http://localhost:8001/cliente");
    
    }

    if($sair  == "medico"){
        header("Location: http://localhost:8001/medico");
        }
echo true;

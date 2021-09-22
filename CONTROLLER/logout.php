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


if(isset($_SESSION['cliente_logado']))
{
   unset($_SESSION['cliente_logado']); 
}


 if($sair  == "administrador"){
 
 header("Location: ".$_SESSION['url']."");
 
 }
 if($sair  == "cliente"){
    header("Location: ".$_SESSION['url']."cliente");
    
    }

    if($sair  == "medico"){
        header("Location: ".$_SESSION['url']."medico");
        }
echo true;

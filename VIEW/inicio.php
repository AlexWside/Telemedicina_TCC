<?php
/* session_start();
 if( $_SESSION['autentication'] != true ){
     
     header('Location:../index.php');
 } */
include_once $_SESSION['pcontroller'] . '/functions.php';
include_once $_SESSION['pmodel'] . '/Agenda.php';
include_once $_SESSION['pmodel'] . '/Agendamento.php';
include_once $_SESSION['pview'] . '/menu.php';
$_objFunctions = new Functions();
$_objFunctions->CriaHeader(
  array(
    "Telemedicina - Inicio",
    "",
    ""
)
);

$_objMenu = new Menu();
$_objMenu->ExibeMenu('inicio');





if (isset($_SESSION['permissao']) && $_SESSION['permissao'] == 0) {

  include_once('home/paciente_home.php');

} else if (isset($_SESSION['permissao']) && $_SESSION['permissao'] == 1) {
 

  include_once('home/adm_home.php');

} else if (isset($_SESSION['permissao']) && $_SESSION['permissao'] == 2) {

  include_once('home/medico_home.php');

} else {
  session_destroy();
  header("http://localhost:8001");
  exit();
}
?>
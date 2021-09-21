<?php

//echo "acessar";
session_start();

 if(empty($_SESSION)){
    die("sessão vazia retorne e tente novamente");
 }
require_once($_SESSION['pmodel'] . '/Paciente.php');
require_once($_SESSION['pmodel'] . '/Medico.php');
require_once($_SESSION['pmodel'] . '/Administrador.php');
/* cliente */
$id = filter_input(INPUT_POST, 'userID', FILTER_SANITIZE_STRING);
$nome = filter_input(INPUT_POST, 'userName', FILTER_SANITIZE_STRING);
$image = filter_input(INPUT_POST, 'userPicture', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'userEmail', FILTER_SANITIZE_STRING);
$token = filter_input(INPUT_POST, 'userToken', FILTER_SANITIZE_STRING);

/* geral */
$post_type = filter_input(INPUT_POST, 'post_type', FILTER_SANITIZE_STRING);
/* administrador  */
$login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING);
$senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);

if ($post_type == 'paciente') {
  
    if ($Paciente->buscar_paciente($email) == "") {

        echo ('error');

    } else {
        //print_r($Usuario->buscar_usuario($email) );exit;
        $_SESSION['token'] = $id;
        $_SESSION['nome'] = $nome;
        $_SESSION['image'] = $image;
        $_SESSION['email'] = $email;
        $_SESSION['permissao'] = 0;
        $_SESSION['cliente_logado'] = '1';
        $Paciente->update_paciente($id, $image, $email);
        
         
    }
}

if ($post_type == 'administrador') {

    if ($ADM->buscar_usuario_adm($login) == "") {

        header('Location:'.$_SESSION['url'].'?status=uerror');

    } else {

       $administrador = $ADM->buscar_usuario_adm($login);
        if($administrador['login'] == $login && password_verify($senha, $administrador['senha'])){

                $_SESSION['nome'] = $administrador['nome'];
                $_SESSION['login'] = $administrador['login'];
                $_SESSION['id'] = $administrador['id'];
                $_SESSION['permissao'] = 1;
                $_SESSION['cliente_logado'] = '1';
                
                header('Location:'.$_SESSION['url'] );
        }else{
            header('Location:'.$_SESSION['url'].'?status=serror');
        }
        
       
    }
}

if ($post_type == 'medico') {

    if ($Medico->buscar_medico($email) == "") {


        echo ('error');
    } else {

        //print_r($Usuario->buscar_usuario($email) );exit;
        $_SESSION['token'] = $id;
        $_SESSION['nome'] = $nome;
        $_SESSION['image'] = $image;
        $_SESSION['email'] = $email;
        $_SESSION['permissao'] = 2;
        $_SESSION['cliente_logado'] = '1';
        $Medico->update_medico($id, $image, $email);


    }
}


/* 
userID: userID,
userName:userName,
userPicture: userPicture,
userEmail:userEmail,
userToken:userToken */
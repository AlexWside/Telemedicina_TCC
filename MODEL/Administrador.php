<?php

@session_start();
require_once($_SESSION['pmodel'].'/CONECTION/conexao.php');

class Administrador extends Conexao{


public function __construct()
{
    parent::__construct();
}


function inserir_adm($login,$senha, $nome,$telefone, $rg, $cpf, $dt_nasc, $endereco, $cidade, $estado, $cep)
{

   
 

    $sql = "INSERT INTO administrador (nome, login, senha, telefone, rg, cpf, dt_nasc, endereco, cidade, estado, cep, created) 
    VALUES(:nome, :login, :senha, :telefone, :rg,:cpf,:dt_nasc,:endereco,:cidade,:estado,:cep,  now())";
    $stmt = $this->PDO->prepare($sql);

    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':login', $login);
    $stmt->bindParam(':senha', $senha);
    $stmt->bindParam(':telefone', $telefone);
    $stmt->bindParam(':rg', $rg);
    $stmt->bindParam(':cpf', $cpf);
    $stmt->bindParam(':dt_nasc', $dt_nasc);
    $stmt->bindParam(':endereco', $endereco);
    $stmt->bindParam(':cidade', $cidade);
    $stmt->bindParam(':estado', $estado);
    $stmt->bindParam(':cep', $cep);


   // echo "<pre>";print_r($sql); exit;
    $result = $stmt->execute();
    
    if (!$result) {
        var_dump($stmt->errorInfo());
        exit;
    }
   
  return true;
}

function mudar_senha($login,$senha)
{

   //echo  "<pre>"; print_r($senha); exit;
   
    $sql = "UPDATE administrador SET  senha = :senha
    WHERE login = :login";
    $stmt = $this->PDO->prepare($sql);

   
    $stmt->bindParam(':login', $login);
    $stmt->bindParam(':senha', $senha);

   // echo "<pre>";print_r($sql); exit;
    $result = $stmt->execute();
    
    if (!$result) {
        var_dump($stmt->errorInfo());
        exit;
    }
   
  return true;
}



function buscar_usuario_adm($login)
{

    $stmt = $this->PDO->prepare("SELECT * FROM administrador WHERE login = :login ");
    $stmt->execute(['login' => $login]); 
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //echo "<pre>";print_r($login); exit;
    return $row;
}

}// fim classe usuario

$ADM = new Administrador();

?>
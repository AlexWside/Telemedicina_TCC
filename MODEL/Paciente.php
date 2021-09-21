<?php

@session_start();
require_once($_SESSION['pmodel'].'/CONECTION/conexao.php');

class Paciente extends Conexao{


public function __construct()
{
    parent::__construct();
}

//$gmail,$nome,$rg,$cpf,$dt_nasc,$endereco,$cidade,$estado,$cep
function inserir_paciente( $email,$nome,$telefone, $rg, $cpf, $dt_nasc, $endereco, $cidade, $estado, $cep)
{

   

    $sql = "INSERT INTO paciente (nome, email,telefone, rg, cpf, dt_nasc, endereco, cidade, estado, cep, id_adm, created) 
    VALUES(:nome, :email,:telefone, :rg,:cpf,:dt_nasc,:endereco,:cidade,:estado,:cep,:id_adm,  now())";
    $stmt = $this->PDO->prepare($sql);

    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':telefone', $telefone);
    $stmt->bindParam(':rg', $rg);
    $stmt->bindParam(':cpf', $cpf);
    $stmt->bindParam(':dt_nasc', $dt_nasc);
    $stmt->bindParam(':endereco', $endereco);
    $stmt->bindParam(':cidade', $cidade);
    $stmt->bindParam(':estado', $estado);
    $stmt->bindParam(':cep', $cep);
    $stmt->bindParam(':id_adm', $_SESSION['id']);


   // echo "<pre>";print_r($sql); exit;
    $result = $stmt->execute();
    
    if (!$result) {
        var_dump($stmt->errorInfo());
        exit;
    }
   
  return true;
}

function update_paciente($token,$imagem,$email)
{

   

    $sql = "UPDATE paciente SET token = :token, imagem = :imagem
    WHERE email = :email";
    $stmt = $this->PDO->prepare($sql);

   
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':token', $token);
    $stmt->bindParam(':imagem', $imagem);

   // echo "<pre>";print_r($sql); exit;
    $result = $stmt->execute();
    
    if (!$result) {
        var_dump($stmt->errorInfo());
        exit;
    }
    $this->setid($email);
   
  return true;
}


function setid($email){

    $stmt = $this->PDO->prepare("SELECT * FROM paciente WHERE email = :email ");
    $stmt->execute(['email' => $email]); 
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $_SESSION['id'] = $row['id'];
    return true;

}

function paciente_online($token)
{
   
    $sql = "UPDATE paciente SET status = 1
    WHERE token = :token";
    $stmt = $this->PDO->prepare($sql);
    $stmt->bindParam(':token', $token);

    $result = $stmt->execute();
    
    if (!$result) {
        var_dump($stmt->errorInfo());
        exit;
    }
   
  return true;
}


function paciente_offline($token)
{

   
   
    $sql = "UPDATE paciente SET status = 0
    WHERE token = :token";
    $stmt = $this->PDO->prepare($sql);
   
    $stmt->bindParam(':token', $token);

    $result = $stmt->execute();
    
    if (!$result) {
        var_dump($stmt->errorInfo());
        exit;
    }
   
  return true;
}


function editar_paciente($id,$email,$nome,$telefone, $rg, $cpf, $dt_nasc, $endereco, $cidade, $estado, $cep)
{

   

    $sql = "UPDATE paciente SET email = :email, nome = :nome, telefone = :telefone,
     rg = :rg, cpf = :cpf, dt_nasc = :dt_nasc, endereco = :endereco, cidade = :cidade, estado = :estado, cep = :cep
    WHERE id = :id";
    $stmt = $this->PDO->prepare($sql);

   
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':nome', $nome);
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



function buscar_paciente($email)
{
    $stmt = $this->PDO->prepare("SELECT * FROM paciente WHERE email = :email ");
    $stmt->execute(['email' => $email]); 
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row;
}

function buscar_paciente_id($id)
{
    $stmt = $this->PDO->prepare("SELECT * FROM paciente WHERE id = :id ");
    $stmt->execute(['id' => $id]); 
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row;
}

function buscar_todos_paciente()
{
   
    $sql = "SELECT * FROM paciente";
    $result = $this->PDO->query($sql);
    $rows = $result->fetchAll();

    return $rows;
}


function excluir_paciente($id)
{
   
    $sql = "DELETE FROM paciente WHERE id = ".$id."";
    $this->PDO->query($sql);
    
}



}// fim classe paciente

$Paciente = new Paciente();

?>
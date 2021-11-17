<?php

@session_start();
require_once($_SESSION['pmodel'].'/CONECTION/conexao.php');

class Paciente extends Conexao{

    private $email;
    private $nome;
    private $telefone;
    private $rg;
    private $cpf;
    private $dt_nasc;
    private $endereco;
    private $cidade;
    private $estado;
    private $cep;


public function __construct()
{
    parent::__construct();
}

/* Get Sets */
function setEmail ($email){
    $this->email = $email;
  }
  function getEmail(){
    return $this->email;
  }
  
  function setNome ($nome){
      $this->nome = $nome;
  }
    function getNome(){
      return $this->nome;
  }
  
  function setTelefone ($telefone){
      $this->telefone = $telefone;
  }
    function getTelefone(){
      return $this->telefone;
  }
  
  function setRg ($rg){
      $this->rg = $rg;
  }
    function getRg(){
      return $this->rg;
  }
  
  function setCpf ($cpf){
      $this->cpf = $cpf;
  }
    function getCpf(){
      return $this->cpf;
  }
  
  function setDt_nasc ($dt_nasc){
      $this->dt_nasc = $dt_nasc;
  }
    function getDt_nasc(){
      return $this->dt_nasc;
  }
  function setEndereco ($endereco){
      $this->endereco = $endereco;
  }
    function getEndereco(){
      return $this->endereco;
  }
  function setCidade ($cidade){
      $this->cidade = $cidade;
  }
    function getCidade(){
      return $this->cidade;
  }
  
  function setEstado ($estado){
      $this->estado = $estado;
  }
    function getEstado(){
      return $this->estado;
  }
  
  function setCep ($cep){
      $this->cep = $cep;
  }
    function getCep(){
      return $this->cep;
  }

//$gmail,$nome,$rg,$cpf,$dt_nasc,$endereco,$cidade,$estado,$cep
function inserir_paciente()
{

    $email = $this->email;
    $nome = $this->nome;
    $telefone = $this->telefone;
    $rg = $this->rg;
    $cpf = $this->cpf;
    $dt_nasc = $this->dt_nasc;
    $endereco = $this->endereco;
    $cidade = $this->cidade;
    $estado = $this->estado;
    $cep = $this->cep;

   

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
 
    
    try {

      $this->PDO->query($sql);
 
    } catch (Exception $e) {
      echo '
      <b>Error:</b> este registro já tem vinculo em outras tabelas</br>
       ';//,  $e->getMessage(), "\n";
 
    }
    
}



}// fim classe paciente

$Paciente = new Paciente();

?>
<?php

@session_start();
require_once($_SESSION['pmodel'].'/CONECTION/conexao.php');

class Agenda extends Conexao{


public function __construct()
{
    parent::__construct();
}


function inserir_agenda( $medico,$qnt,$hinicial, $hfinal)
{

   

    $sql = "INSERT INTO agenda (medico, quantidade,horainicial, horafinal, id_adm, created) 
    VALUES(:medico, :qnt,:hinicial, :hfinal, :id_adm, now())";
    $stmt = $this->PDO->prepare($sql);

    $stmt->bindParam(':medico', $medico);
    $stmt->bindParam(':qnt', $qnt);
    $stmt->bindParam(':hinicial', $hinicial);
    $stmt->bindParam(':id_adm', $_SESSION['id']);
    $stmt->bindParam(':hfinal', $hfinal);


   // echo "<pre>";print_r($sql); exit;
    $result = $stmt->execute();
    
    if (!$result) {
        var_dump($stmt->errorInfo());
        exit;
    }
   
  return $this->PDO->lastInsertId();
}




function inserir_diasdetrabalho( $id_agenda, $dia_semana)
{


    $sql = "INSERT INTO diasdetrabalho (id_agenda, id_semana , created) 
    VALUES(:id_agenda, :dia_semana, now())";
    $stmt = $this->PDO->prepare($sql);

    $stmt->bindParam(':id_agenda', $id_agenda);
    $stmt->bindParam(':dia_semana', $dia_semana);

  
    $result = $stmt->execute();
    
    if (!$result) {
        var_dump($stmt->errorInfo());
        exit;
    }
   
  return true;
}


function buscar_agenda_id_medico($id)
{
    $stmt = $this->PDO->prepare("SELECT * FROM agenda WHERE medico = :id ");
    $stmt->execute(['id' => $id]); 
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row;
}

function buscar_agenda_id($id)
{
    $stmt = $this->PDO->prepare("SELECT * FROM agenda WHERE id = :id ");
    $stmt->execute(['id' => $id]); 
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row;
}



function buscar_todas_as_agendas()
{
   
    $sql = "SELECT * FROM agenda";
    $result = $this->PDO->query($sql);
    $rows = $result->fetchAll(PDO::FETCH_ASSOC);

    return $rows;
}




function buscar_diasdetrabalho($id)
{
    $stmt = $this->PDO->prepare("SELECT * FROM diasdetrabalho WHERE id_agenda = :id ");
    $stmt->execute(['id' => $id]); 
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $row;
}


function buscar_diasdasemana($id)
{
    
    $stmt = $this->PDO->prepare("SELECT * FROM semana WHERE id = :id ");
    $stmt->execute(['id' => $id]); 
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
   
    return $row;
}


function excluir_agenda($id)
{
   


    $sql = "DELETE FROM diasdetrabalho WHERE id_agenda = ".$id."";
    $this->PDO->query($sql);

    $sql = "DELETE FROM agenda WHERE id = ".$id." ";
    $this->PDO->query($sql);
    
}




}// fim classe paciente

$Agenda = new Agenda();

?>
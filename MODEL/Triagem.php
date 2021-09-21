<?php

@session_start();
require_once($_SESSION['pmodel'].'/CONECTION/conexao.php');

class Triagem extends Conexao{


public function __construct()
{
    parent::__construct();
}


function inserir_triagem($id_agendamento,$alergia,$doencacronica, $diabetes,$pressao, $problemarespiratorio, $altura, $peso, $temperatura)
{

   
 

    $sql = "INSERT INTO triagem (id_agendamento,alergia, doencacronica, diabetes, pressao, problemarespiratorio, altura, peso, temperatura, created) 
    VALUES(:id_agendamento, :alergia, :doencacronica, :diabetes, :pressao,:problemarespiratorio,:altura,:peso,:temperatura, now())";
    $stmt = $this->PDO->prepare($sql);

    $stmt->bindParam(':id_agendamento', $id_agendamento);
    $stmt->bindParam(':alergia', $alergia);
    $stmt->bindParam(':doencacronica', $doencacronica);
    $stmt->bindParam(':diabetes', $diabetes);
    $stmt->bindParam(':pressao', $pressao);
    $stmt->bindParam(':problemarespiratorio', $problemarespiratorio);
    $stmt->bindParam(':altura', $altura);
    $stmt->bindParam(':peso', $peso);
    $stmt->bindParam(':temperatura', $temperatura);


   // echo "<pre>";print_r($sql); exit;
    $result = $stmt->execute();
    
    if (!$result) {
        var_dump($stmt->errorInfo());
        exit;
    }
   
  return true;
}





function buscar_triagem_agendamento_id($id)
{

    $stmt = $this->PDO->prepare("SELECT * FROM triagem WHERE id_agendamento = :id ");
    $stmt->execute(['id' => $id]); 
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //echo "<pre>";print_r($login); exit;
    return $row;
}

}// fim classe usuario

$Triagem = new Triagem();

?>
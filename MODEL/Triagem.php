<?php

@session_start();
require_once($_SESSION['pmodel'].'/CONECTION/conexao.php');

class Triagem extends Conexao{


public function __construct()
{
    parent::__construct();
}


function inserir_triagem($alergia,$doencacronica, $diabetes,$pressao, $problemarespiratorio, $altura, $peso, $temperatura)
{

   
 

    $sql = "INSERT INTO triagem (alergia, doencacronica, diabetes, pressao, problemarespiratorio, altura, peso, temperatura, created) 
    VALUES( :alergia, :doencacronica, :diabetes, :pressao,:problemarespiratorio,:altura,:peso,:temperatura, now())";
    $stmt = $this->PDO->prepare($sql);

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
   
    return $this->PDO->lastInsertId();
}





function buscar_triagem_agendamento_id($id)
{

    $stmt = $this->PDO->prepare("SELECT t.* FROM triagem t, atendimento a WHERE  a.id_agendamento = :id 
    and a.id_triagem = t.id");
    $stmt->execute(['id' => $id]); 
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //echo "<pre>";print_r($login); exit;
    return $row;
}

}// fim classe usuario

$Triagem = new Triagem();

?>
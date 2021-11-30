<?php

@session_start();
require_once($_SESSION['pmodel'].'/CONECTION/conexao.php');

class Atendimento extends Conexao{


public function __construct()
{
    parent::__construct();
}



function criar_atendimento($id_agendamento,$id_triagem)
{

   
  //echo "<pre>"; print_r($id_agendamento); exit;

    $sql = "INSERT INTO atendimento (id_agendamento, id_triagem) 
    VALUES(:id_agendamento, :id_triagem)";
    $stmt = $this->PDO->prepare($sql);

    $stmt->bindParam(':id_agendamento', $id_agendamento);
    $stmt->bindParam(':id_triagem', $id_triagem);
    


   // echo "<pre>";print_r($sql); exit;
    $result = $stmt->execute();
    
    if (!$result) {
        var_dump($stmt->errorInfo());
        exit;
    }
   
  return true;
}



function inserir_atendimento($id_agendamento,$anamnese,$receita, $hipotese,$recomendacoes)
{

   
 

    $sql = "UPDATE atendimento 
    SET anamnese =  :anamnese , receita = :receita , hipotese = :hipotese, recomendacoes = :recomendacoes, created = now()
    WHERE  id_agendamento  = :id_agendamento";
   
    $stmt = $this->PDO->prepare($sql);

   
    $stmt->bindParam(':anamnese', $anamnese);
    $stmt->bindParam(':receita', $receita);
    $stmt->bindParam(':hipotese', $hipotese);
    $stmt->bindParam(':recomendacoes', $recomendacoes);
    $stmt->bindParam(':id_agendamento', $id_agendamento);

    


   // echo "<pre>";print_r($sql); exit;
    $result = $stmt->execute();
    
    if (!$result) {
        var_dump($stmt->errorInfo());
        exit;
    }
   
  return true;
}





function buscar_atendimento($id)
{

    $stmt = $this->PDO->prepare("SELECT * FROM atendimento WHERE id = :id ");
    $stmt->execute(['id' => $id]); 
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //echo "<pre>";print_r($login); exit;
    return $row;
}

}// fim classe usuario

$Atendimento = new Atendimento();

?>
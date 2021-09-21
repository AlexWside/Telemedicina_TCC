<?php

@session_start();
require_once($_SESSION['pmodel'].'/CONECTION/conexao.php');

class Atendimento extends Conexao{


public function __construct()
{
    parent::__construct();
}


function inserir_atendimento($id_agendamento,$anamnese,$receita, $hipotese,$recomendacoes)
{

   
 

    $sql = "INSERT INTO atendimento (id_agendamento,anamnese, receita, hipotese, recomendacoes, created) 
    VALUES(:id_agendamento, :anamnese, :receita, :hipotese, :recomendacoes, now())";
    $stmt = $this->PDO->prepare($sql);

    $stmt->bindParam(':id_agendamento', $id_agendamento);
    $stmt->bindParam(':anamnese', $anamnese);
    $stmt->bindParam(':receita', $receita);
    $stmt->bindParam(':hipotese', $hipotese);
    $stmt->bindParam(':recomendacoes', $recomendacoes);
    


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
<?php

@session_start();
require_once($_SESSION['pmodel'].'/CONECTION/conexao.php');

class Atendimento extends Conexao{


public function __construct()
{
    parent::__construct();
}


function inserir_atendimento($id_agendamento,$anamnese,$receita, $hipotese,$recomendacoes,$id_medico,$id_paciente)
{

   
 

    $sql = "INSERT INTO atendimento (id_agendamento,anamnese, receita, hipotese, recomendacoes, created, id_medico, id_paciente) 
    VALUES(:id_agendamento, :anamnese, :receita, :hipotese, :recomendacoes, now(),:id_medico, :id_paciente)";
    $stmt = $this->PDO->prepare($sql);

    $stmt->bindParam(':id_agendamento', $id_agendamento);
    $stmt->bindParam(':anamnese', $anamnese);
    $stmt->bindParam(':receita', $receita);
    $stmt->bindParam(':hipotese', $hipotese);
    $stmt->bindParam(':recomendacoes', $recomendacoes);
    $stmt->bindParam(':id_medico', $id_medico);
    $stmt->bindParam(':id_paciente', $id_paciente);
    


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
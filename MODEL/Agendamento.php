<?php

@session_start();
require_once($_SESSION['pmodel'].'/CONECTION/conexao.php');

class Agendamento extends Conexao{


public function __construct()
{
    parent::__construct();
}



function inserir_agendamento( $id_agenda,$id_paciente,$data_agendamento)
{

   

    $sql = "INSERT INTO agendamento (id_agenda, id_paciente,data_agendamento, created) 
    VALUES(:id_agenda, :id_paciente,:data_agendamento , now())";
    $stmt = $this->PDO->prepare($sql);

    $stmt->bindParam(':id_agenda', $id_agenda);
    $stmt->bindParam(':id_paciente', $id_paciente);
    $stmt->bindParam(':data_agendamento', $data_agendamento);
    


   
    $result = $stmt->execute();
    
    if (!$result) {
        var_dump($stmt->errorInfo());
        exit;
    }
   
  return true;
}



function buscar_agendamento_id($id)
{
    $stmt = $this->PDO->prepare("SELECT * FROM agendamento WHERE id = :id ");
    $stmt->execute(['id' => $id]); 
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row;
}

function buscar_agendamento_id_agenda($id)
{
    $stmt = $this->PDO->prepare("SELECT * FROM agendamento WHERE id_agenda = :id ");
    $stmt->execute(['id' => $id]); 
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $row;
}

function buscar_todos_os_agendamentos()
{
   
    $sql = "SELECT * FROM agendamento";
    $result = $this->PDO->query($sql);
    $rows = $result->fetchAll(PDO::FETCH_ASSOC);

    return $rows;
}


function buscar_agendamento_medico($token)
{
   
    $sql = "SELECT a.id as idagendamento, p.status ,p.id as idpaciente ,p.nome as nomepaciente,a.data_agendamento,m.nome as nomemedico 
    FROM agendamento a, agenda ag , medico m, paciente p
    WHERE a.id_agenda = ag.id and a.id_paciente = p.id AND a.status < 2 AND ag.medico = m.id
    AND m.token = ".$token."";

    $result = $this->PDO->query($sql);
    $rows = $result->fetchAll(PDO::FETCH_ASSOC);

    return $rows;
}

function buscar_agendamento_paciente($token)
{
   
    $sql = "SELECT a.id as idagendamento, p.status ,m.id as idmedico ,p.nome as nomepaciente,
    a.data_agendamento,m.nome as nomemedico, m.especialidade as especialidade,
    a.status as statusagendamento
    FROM agendamento a, agenda ag , medico m, paciente p
    WHERE a.id_agenda = ag.id and a.id_paciente = p.id AND a.status < 2 AND ag.medico = m.id
    AND p.token = ".$token."";

    $result = $this->PDO->query($sql);
    $rows = $result->fetchAll(PDO::FETCH_ASSOC);

    return $rows;
}





function concluir_autoavaliacao($id)
{

   

    $sql = "UPDATE agendamento SET status = 1
    WHERE id = :id";
    $stmt = $this->PDO->prepare($sql);

    $stmt->bindParam(':id', $id);

   // echo "<pre>";print_r($sql); exit;
    $result = $stmt->execute();
    
    if (!$result) {
        var_dump($stmt->errorInfo());
        exit;
    }
   
  return true;
}


function concluir_atendimento($id)
{

   

    $sql = "UPDATE agendamento SET status = 2
    WHERE id = :id";
    $stmt = $this->PDO->prepare($sql);

    $stmt->bindParam(':id', $id);

   // echo "<pre>";print_r($sql); exit;
    $result = $stmt->execute();
    
    if (!$result) {
        var_dump($stmt->errorInfo());
        exit;
    }
   
  return true;
}


function inserir_link($id,$link)
{

   

    $sql = "UPDATE agendamento SET linkatendimento = :link
    WHERE id = :id";
    $stmt = $this->PDO->prepare($sql);

    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':link', $link);

   // echo "<pre>";print_r($sql); exit;
    $result = $stmt->execute();
    
    if (!$result) {
        var_dump($stmt->errorInfo());
        exit;
    }
   
  return true;
}


function buscar_atendimento_paciente(){

    $id = $_SESSION['id'];

    $sql = "SELECT a.id as id_atendimento, a.receita as receita, a.created as data, med.nome as medico, med.especialidade as especialidade
    ,a.recomendacoes as recomendacao
    FROM agendamento ag, atendimento a, agenda gd, medico med
    WHERE ag.id = a.id_agendamento
    AND ag.id_agenda = gd.id
    AND gd.medico = med.id
    AND ag.id_paciente = ".$id."
    ";
    $result = $this->PDO->query($sql);
    $rows = $result->fetchAll(PDO::FETCH_ASSOC);

    return $rows;
    
}


function buscar_atendimento_medico(){

    $id = $_SESSION['id'];

    $sql = "SELECT a.id as id_atendimento, a.receita as receita, a.created as data, p.nome as paciente, p.cpf as cpf
    ,a.recomendacoes as recomendacao, a.anamnese as anamnese, a.hipotese as hipotese
    FROM agendamento ag, atendimento a, agenda gd, medico med, paciente p
    WHERE ag.id = a.id_agendamento
    AND ag.id_agenda = gd.id
    AND p.id = ag.id_paciente
    AND gd.medico = med.id
    AND med.id = ".$id."
    ";
    $result = $this->PDO->query($sql);
    $rows = $result->fetchAll(PDO::FETCH_ASSOC);

    return $rows;
    
}


function buscar_todos_agendamentos_medico()
{
   $id = $_SESSION['id'];

    $sql = "SELECT a.id as idagendamento, a.status as status ,p.id as idpaciente ,p.nome as nomepaciente,a.data_agendamento as data ,m.nome as nomemedico 
    FROM agendamento a, agenda ag , medico m, paciente p
    WHERE a.id_agenda = ag.id and a.id_paciente = p.id AND ag.medico = m.id
    AND m.id = ".$id."
    ORDER BY a.data_agendamento DESC";

    $result = $this->PDO->query($sql);
    $rows = $result->fetchAll(PDO::FETCH_ASSOC);

    return $rows;
}


}// fim classe paciente

$Agendamento = new Agendamento();

?>
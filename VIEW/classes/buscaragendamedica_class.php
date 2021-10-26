<?php


include_once $_SESSION['pview'] . '/menu.php';


class Buscaragendamedica
{

    public function ExibeFormularioDeBuscarAgenda()
    {
        $_objFunctions = new Functions();
        $_objFunctions->CriaHeader(
            array(
                "Telemedicina - Busca Agenda Medica",
                "descricao-1",
                "descricao-2"
            )
        );

        $_objMenu = new Menu();
        $_objMenu->ExibeMenu('inicio');

        require_once($_SESSION['pmodel'] . '/Agenda.php');
        require_once($_SESSION['pmodel'] . '/Medico.php');
        require_once($_SESSION['pmodel'] . '/Agendamento.php');
        if(isset($_POST['excluir']) && $_POST['excluir'] == 'true')
        {
            if($Agendamento->buscar_agendamento_id_agenda($_POST['id-exclusao'])){
                echo "já existe agendamentos vinculados a essa agenda";
            }else{
                $Agenda->excluir_agenda($_POST['id-exclusao']);
            }
           
           
        }


            $agendas = $Agenda->buscar_todas_as_agendas();
     
        

        
        /* $Agenda->buscar_diasdetrabalho($agenda['id']); */



        
?>

        <br>

        <div id="section">
            <div class="container">
                <h2>Consultar Agendas:</h2>
                <br>
                <div class="flex-row float-right">
                    <label for="search">Busca</label>
                    <input name="busca" id="busca" class="search" placeholder="Nome">

                </div>

                <div class="table-responsive">
                <table class="table table-striped">
                    <tbody class="list">

                        <tr>
                            <th>ID</th>
                            <th>Medico</th>
                            <th>Atendimentos</th>
                            <th>Hora Inicial</th>
                            <th>Hora Final</th>
                            <th colspan="2">Dias de Atendimento</th>
                            <th colspan="1">Excluir</th>
                        </tr>

                        <?php foreach ($agendas as $agenda) { ?>

                            <tr>
                                <td><?= $agenda['id'] ?></td>
                                <td class="medico">
                                <?php
                                $medico = $Medico->buscar_medico_id($agenda['medico']); 
                                echo $medico['nome'];
                                ?>
                                </td>
                                <td><?= $agenda['quantidade'] ?></td>
                                <td><?= $agenda['horainicial'] ?></td>
                                <td><?= $agenda['horafinal'] ?></td>

                                <td colspan="2">
                                <?php  
                                $diasdetrabalho = $Agenda->buscar_diasdetrabalho($agenda['id']); 

                                foreach($diasdetrabalho as $diadetrabalho){
                                    
                                    $diadasemana =  $Agenda->buscar_diasdasemana($diadetrabalho['id_semana']);
                                    echo  $diadasemana['dia'].",";
                                }
                                /* echo "<pre>"; print_r($diasdetrabalho); exit; */
                                ?>
                                </td>

                                <td>
                                    <form action="" method="post">
                                        <input type="hidden" name="excluir" value="true">
                                        <input type="hidden" name="id-exclusao" value="<?= $agenda['id'] ?>">
                                        <button class="btn-opcoes" type="submit"><img src="<?php echo $_SESSION['url'] ?>VIEW/img/excluir.png" alt="excluir"></button>
                                    </form>
                                </td>

                            </tr>

                        <?php } ?>

                    </tbody>
                </table>
            </div><!-- /container -->
            </div>

            <script src="//cdnjs.cloudflare.com/ajax/libs/list.js/1.5.0/list.min.js"></script>
            <script>
                var options = {
                    valueNames: ['medico']//, 'cpf'
                };

                var userList = new List('section', options);
            </script>

        </div>



<?php

    }


    public function setParametros($_parametros)
    {
        //echo "<pre>"; print_r($_parametros); exit;
        if (empty($_parametros)) {

            $this->ExibeFormularioDeBuscarAgenda();
        } else {
            require_once $_SESSION['pview'] . '/404.php';
        }
    }
}

?>
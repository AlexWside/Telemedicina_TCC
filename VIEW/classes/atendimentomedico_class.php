<?php


include_once $_SESSION['pview'] . '/menu.php';



class Atendimentomedico
{

    public function ExibeAtendimentos()
    {
        $_objFunctions = new Functions();
        $_objFunctions->CriaHeader(
            array(
                "Telemedicina - Historico de Atendimento",
                "",
                ""
            )
        );

        $_objMenu = new Menu();
        $_objMenu->ExibeMenu('inicio');

        require_once($_SESSION['pmodel'] . '/Agendamento.php');
        $historicos = $Agendamento->buscar_atendimento_medico();

?>




        <div class="container">
        <br><br>
            <center>
                <h4>Historico de Atendimento</h4>
            </center><br>
            <?php foreach ($historicos as $atendimento) {
    


            ?>
                    <div class="card">

                        <br>
                        <p><b>Cod: </b><?php echo $atendimento['id_atendimento'] ?></p>
                        <p><b>Paciente: </b><?php echo $atendimento['paciente'] ?></p>
                        <p><b>CPF: </b><?php echo $atendimento['cpf'] ?></p>
                        <p><b>Anamnese: </b><?php echo $atendimento['anamnese'] ?></p>
                        <p><b>Hipotese: </b><?php echo $atendimento['hipotese'] ?></p>
                        <p><b>Recomendacao: </b><?php echo $atendimento['recomendacao'] ?></p>
                        <p><b>Data: </b><?php echo  date('d/m/Y', strtotime($atendimento['data'])); ?></p>
                      

                    </div><!-- /card-container -->

            <?php   
            } ?>
        </div><!-- /container -->







    <?php

    }


    public function ExibeAgenda()
    {
        $_objFunctions = new Functions();
        $_objFunctions->CriaHeader(
            array(
                "Telemedicina - Agenda medica",
                "",
                ""
            )
        );


        $_objMenu = new Menu();
        $_objMenu->ExibeMenu('inicio');

        require_once($_SESSION['pmodel'] . '/Agendamento.php');
        $historicos = $Agendamento->buscar_todos_agendamentos_medico();

        /* echo "<pre>"; print_r($historicos); exit; */
    ?>


        <div class="container">
        <br><br>
            <center>
                <h4>Agenda</h4>
            </center><br>

            <br>
                <table class="table table-light">
                    <tr>
                        <th>Paciente</th>
                        <th>Data</th>
                        <th>Hora</th>
                        <th>Status</th>
                    </tr>
            <?php foreach ($historicos as $atendimento) {
    


    ?>
            

              
                    <tr>
                        <td><?php echo $atendimento['nomepaciente'] ?></td>
                        <td><?php echo  date('d/m/Y', strtotime($atendimento['data'])); ?></td>
                        <td><?php echo  date('H:i', strtotime($atendimento['data'])); ?></td>
                        <td>
                        <?php
                 if($atendimento['status'] == 0){
                    echo "<b style='color:orange;'>AGENDADO</b>";
                } else  if($atendimento['status'] == 1){
                    echo "<b style='color:blue;'>TRIADO</b>";
                } else  if($atendimento['status'] == 2){
                    echo "<b style='color:green;'>CONCLUÍDO</b>";
                } else  if($atendimento['status'] == 3){
                    echo "<b style='color:red;'>CANCELADO</b>";
                }?>
                        </td>
                    </tr>
           
                
              

        

    <?php   
    } ?>
         </table>
        </div><!-- /container -->







<?php

    }


    public function setParametros($_parametros)
    {
        //echo "<pre>"; print_r($_parametros); exit;
        if (!empty($_parametros)) {
            if ($_parametros[0] == 'historico') {
                $this->ExibeAtendimentos();
            } else if ($_parametros[0] == 'agenda') {
                $this->ExibeAgenda();
            }
        } else {
            require_once $_SESSION['pview'] . '/404.php';
        }
    }
}

?>
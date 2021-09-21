<?php


include_once $_SESSION['pview'] . '/menu.php';



class Atendimentopaciente
{

    public function ExibeReceitas()
    {
        $_objFunctions = new Functions();
        $_objFunctions->CriaHeader(
            array(
                "Telemedicina - ",
                "",
                ""
            )
        );

        $_objMenu = new Menu();
        $_objMenu->ExibeMenu('inicio');

        require_once($_SESSION['pmodel'] . '/Agendamento.php');
        $historicos = $Agendamento->buscar_atendimento_paciente();

?>




        <div class="container">
            <?php foreach ($historicos as $atendimento) {
                if ($atendimento['receita'] != '') {


            ?>
                    <div class="card">

                        <center>
                            <h4>Receita</h4>
                        </center><br>
                        <p><b>Cod: </b><?php echo $atendimento['id_atendimento'] ?></p>
                        <p><b>Receita: </b><?php echo $atendimento['receita'] ?></p>
                        <p><b>Medico: </b><?php echo $atendimento['medico'] ?></p>
                        <p><b>Especialidade: </b><?php echo $atendimento['especialidade'] ?></p>
                        <p><b>Data: </b><?php echo  date('d/m/Y', strtotime($atendimento['data'])); ?></p>
                        <center><a href="#" class="btn btn-success">Abrir</a></center>

                    </div><!-- /card-container -->

            <?php   }
            } ?>
        </div><!-- /container -->







    <?php

    }


    public function ExibeAtendimentos()
    {
        $_objFunctions = new Functions();
        $_objFunctions->CriaHeader(
            array(
                "Telemedicina - ",
                "",
                ""
            )
        );


        $_objMenu = new Menu();
        $_objMenu->ExibeMenu('inicio');

        require_once($_SESSION['pmodel'] . '/Agendamento.php');
        $historicos = $Agendamento->buscar_atendimento_paciente();
    ?>


        <div class="container">
        <br><br>
            <center>
                <h4>Historicos Atendimento</h4>
            </center><br>
            <?php foreach ($historicos as $atendimento) {


            ?>
                    <div class="card">


                        <p><b>Cod: </b><?php echo $atendimento['id_atendimento'] ?></p>
                        <p><b>Recomendaçoes medicas: </b><?php echo $atendimento['recomendacao'] ?></p>
                        <p><b>Medico: </b><?php echo $atendimento['medico'] ?></p>
                        <p><b>Especialidade: </b><?php echo $atendimento['especialidade'] ?></p>
                        <p><b>Data: </b><?php echo  date('d/m/Y', strtotime($atendimento['data'])); ?></p>

                    </div><!-- /card-container -->

            <?php   }
            ?>
        </div><!-- /container -->







<?php

    }


    public function setParametros($_parametros)
    {
        //echo "<pre>"; print_r($_parametros); exit;
        if (!empty($_parametros)) {
            if ($_parametros[0] == 'receita') {
                $this->ExibeReceitas();
            } else if ($_parametros[0] == 'atendimento') {
                $this->ExibeAtendimentos();
            }
        } else {
            require_once $_SESSION['pview'] . '/404.php';
        }
    }
}

?>
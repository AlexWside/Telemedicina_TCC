<?php


include_once $_SESSION['pview'] . '/menu.php';

class Agendar
{

    public function ExibeFormularioDeAgendar()
    {
        $_objFunctions = new Functions();
        $_objFunctions->CriaHeader(
            array(
                "Telemedicina - Nova Agenda",
                "",
                ""
            )
        );




        $_objMenu = new Menu();
        $_objMenu->ExibeMenu('inicio');



        require_once($_SESSION['pmodel'] . '/Agenda.php');
        require_once($_SESSION['pmodel'] . '/Agendamento.php');
        require_once($_SESSION['pmodel'] . '/Medico.php');
        require_once($_SESSION['pmodel'] . '/Paciente.php');

        $GLOBALS["Agendamento"] = $Agendamento;
        $agendas = $Agenda->buscar_todas_as_agendas();
        $pacientes = $Paciente->buscar_todos_paciente();

        if (isset($_POST['agenda']) && $_POST['agenda'] == 'true') {

            $id_agenda = filter_input(INPUT_POST, 'id_agenda', FILTER_SANITIZE_STRING);
            $id_paciente = filter_input(INPUT_POST, 'id_paciente', FILTER_SANITIZE_STRING);

            $diasdetrabalho = $Agenda->buscar_diasdetrabalho($id_agenda);


            /*             echo "<pre>";
            print_r($diasdetrabalho);
            exit; */

            if (isset($diasdetrabalho)) {
            } else {
                $status = "error";
                $msg = "Preencha os Campos Obrigatórios";
            }
        } // fim if filtropost





        if (isset($_POST['dias_trabalho']) && $_POST['dias_trabalho'] == 'true') {

            $id_agenda = filter_input(INPUT_POST, 'id_agenda', FILTER_SANITIZE_STRING);
            $data_agendamento = filter_input(INPUT_POST, 'data_agendamento', FILTER_SANITIZE_STRING);
            $id_paciente = filter_input(INPUT_POST, 'id_paciente', FILTER_SANITIZE_STRING);
            $diasdetrabalho = $Agenda->buscar_diasdetrabalho($id_agenda);
            $_SESSION['dataselecionada'] = $data_agendamento;
            /*  echo "<pre>";
            print_r($data_agendamento);
            exit; */

            if(strtotime($data_agendamento) >=  strtotime(date('d/m/Y'))){
                if ($id_agenda != "" && $data_agendamento != "") {
                    $cont = 0;
    
                    $diasemana_numero = date('w', strtotime($data_agendamento));
                    if ($diasemana_numero == 0) {
                        $diasemana_numero = 7;
                    }
                    foreach ($diasdetrabalho as $diadetrabalho) {
    
    
                        if ($diadetrabalho["id_semana"] == $diasemana_numero) {
                            $cont++;
                        }
                    }
                } else {
                    $status = "error";
                    $msg = "informações necessarias não encontradas.";
                }
            }else{
                $status = "error";
                $msg = "data informada invalida.";
            }



            /*             echo "<pre>";
            print_r($diasemana_numero);
            exit; */
        } // fim if comparar datas



        if (isset($_POST['confirmar']) && $_POST['confirmar'] == 'true') {

            $id_agenda = filter_input(INPUT_POST, 'id_agenda', FILTER_SANITIZE_STRING);
            $id_paciente = filter_input(INPUT_POST, 'id_paciente', FILTER_SANITIZE_STRING);
            $data_agendamento = filter_input(INPUT_POST, 'data_agendamento', FILTER_SANITIZE_STRING);
            $hora_selecionada = filter_input(INPUT_POST, 'hora_selecionada', FILTER_SANITIZE_STRING);
            $dataehora = $data_agendamento . " " . $hora_selecionada;

            /*                         echo "<pre>";
            print_r($dataehora);
            exit; */

            if ($id_agenda != ""  && $id_paciente != ""  && $dataehora != "") {

                if ($Agendamento->inserir_agendamento($id_agenda, $id_paciente, $dataehora)) {
                    $status = "success";
                    /*  unset($_POST['confirmar']); */
                } else {
                    $status = "error";
                    $msg = "falha ao tentar salvar o registro";
                }
            } else {
                $status = "error";
                $msg = "Preencha os Campos Obrigatórios";
            }
        } // fim if confirmar

?>
        <br>
        <!-- pop up -->
        <div class="pop-up">

            <?php if (isset($status) && $status == "success") { ?>
                <div class='toast success' role='alert' aria-live='assertive' aria-atomic='true'>
                    <div class='toast-header'>

                        <strong class='mr-auto'>Notificação</strong>
                        <small class='text-muted'>agora</small>
                    </div>
                    <div class='toast-body'>
                        Agendamento criada com sucesso
                    </div>
                </div>
            <?php } else if (isset($status) && $status == "error") { ?>
                <div class='toast danger' role='alert' aria-live='assertive' aria-atomic='true'>
                    <div class='toast-header'>

                        <strong class='mr-auto'>Notificação</strong>
                        <small class='text-muted'>agora</small>
                    </div>
                    <div class='toast-body'>
                        <?php echo $msg ?>
                    </div>
                </div>


            <?php } ?>
        </div>
        <!--fim  tag popup -->


        <div class="container">
            <h2> Agendamento: </h2>
            <br>
            <?php if (!isset($diasdetrabalho)) { ?>
                <form action="" method="POST">
                    <input type="hidden" name="agenda" value="true">
                    <!--            <input type="hidden" name="id_agenda" value="<?php echo @$id_agenda ?>">
                    <input type="hidden" name="id_paciente" value="<?php echo @$id_paciente ?>"> -->


                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="inputAgenda">Agenda <span class="red-text">*</span></label>
                            <select name="id_agenda" id="inputAgenda" class="form-control">
                                <option value="" selected>Escolher...</option>

                                <?php foreach ($agendas as $agenda) {
                                    $medico = $Medico->buscar_medico_id($agenda['medico'])

                                ?>
                                    <option value="<?= $agenda['id'] ?>"><?= $medico['nome'] ?> - <?= $medico['especialidade'] ?> </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="inputPaciente">Paciente <span class="red-text">*</span></label>
                            <select name="id_paciente" id="inputPaciente" class="form-control">
                                <option value="" selected>Escolher...</option>

                                <?php foreach ($pacientes as $paciente) {

                                ?>
                                    <option value="<?= $paciente['id'] ?>"><?= $paciente['nome'] ?> - <?= $paciente['cpf'] ?> </option>
                                <?php } ?>
                            </select>
                        </div>

                    </div>

                    <br>
                    <button type="submit" class="btn btn-primary">Buscar Vagas</button>
                </form>
            <?php } else { ?>


                <form action="" method="POST">

                    <input type="hidden" name="id_agenda" value="<?php echo $id_agenda ?>">
                    <input type="hidden" name="id_paciente" value="<?php echo $id_paciente ?>">

                    <input type="hidden" name="dias_trabalho" value="true">

                    <div class="form-collumn">
                        <h4>dias de trabalho: <?php
                                                foreach ($diasdetrabalho as $diadetrabalho) {
                                                    $diadasemana =  $Agenda->buscar_diasdasemana($diadetrabalho['id_semana']);
                                                    echo  $diadasemana['dia'] . " | ";
                                                }  ?>
                        </h4>
                        <br>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="inputAgenda">Selecione a data de acordo com os dias de trabalho <span class="red-text">*</span></label>
                                <input type="date" name="data_agendamento">
                            </div>

                        </div>

                    </div>

                    <br>
                    <button type="submit" class="btn btn-primary">Buscar Vagas</button>
                </form>
                <br>
                <?php if (isset($cont) && $cont != 0) {


                    function CalculaQuantidadeDeVagas($hora)
                    {
                       
                      
                       /*    require_once($_SESSION['pmodel'] . '/Agenda.php'); */
                        $agendamentos = $GLOBALS["Agendamento"]->buscar_todos_os_agendamentos();
                        /*  */
                        foreach($agendamentos as $agendamento){
                            $dataagendamentobanco = substr($agendamento['data_agendamento'], 0, 10);
                            $horaagendamentobanco = substr($agendamento['data_agendamento'], 11, 8);
                            
                            if($dataagendamentobanco ==  $_SESSION['dataselecionada']){
                               
                                if($hora == $horaagendamentobanco){
                                    return 1;
                                }
                            }
                        }
                        return 0;
                       
                      
                 

                       
                    }


                ?>
                    <!-- form com funcao gera hora -->

                    <form action="" method="post">
                        <input type="hidden" name="confirmar" value="true">
                        <input type="hidden" name="id_agenda" value="<?php echo $id_agenda ?>">
                        <input type="hidden" name="id_paciente" value="<?php echo $id_paciente ?>">
                        <input type="hidden" name="data_agendamento" value="<?php echo $data_agendamento ?>">


                        <table id='tbl_horarios' class='tbl-de-horarios' align='center'>
                            <!--  tabela de vagas -->
                            <tr><th colspan="3">DATA SELECIONADA: <?php echo @$_SESSION['dataselecionada']?></th></tr>
                            <tr>
                                <td style='text-align: center;'>Horarios</td>
                                <td style='text-align: center;'>Vagas</td>
                                <td style='text-align: center;'>&nbsp;</td>
                            </tr>
                            <?php

                            function Intervalo($de, $ate, $quaatendimentos)
                            {

                                $ts = strtotime($de);
                                $tsf = strtotime($ate);

                                $difMinutos = round(abs($tsf - $ts) / 60, 2);

                                $intervalo = ceil((($difMinutos / $quaatendimentos))) * 60;

                                while ($ts < $tsf) {
                                    $qtd_ja_agendado = CalculaQuantidadeDeVagas(date('H:i:s', $ts));
                                    $_quantidade = (1 - $qtd_ja_agendado);

                                    $horinicial = date('H:i:s', $ts);
                                    $horfinal = date('H:i:s', $ts + $intervalo - 1);
                            ?>
                                    <tr>
                                        <td style='text-align: center;'><?php echo $horinicial; ?></td>
                                        <td style='text-align: center;'><?php echo $_quantidade; ?></td>
                                        <td style='text-align: center;'>
                                            <?php if ($_quantidade == 1) { ?>

                                                <input type='radio' name='hora_selecionada' id='hora_selecionada' value='<?php echo $horinicial /* . "/" . $horfinal . "/1" */; ?>' style='cursor: pointer;' />
                                            <?php
                                            } else {
                                                echo "Já Reservado!";
                                            } ?>
                                        </td>
                                    </tr>
                            <?php
                                    $ts += $intervalo;
                                }
                            }

                            /* echo "<pre>"; print_r($Agenda->buscar_agenda_id($id_agenda)); */
                            $agenda = $Agenda->buscar_agenda_id($id_agenda);
                            Intervalo($agenda['horainicial'], $agenda['horafinal'], $agenda['quantidade']);



                            ?>
                        </table><!--  fim tabela de vagas -->
                        <br>
                        <center><button type="submit" class="btn btn-success">Confirmar</button></center>
                    </form>
                    <!-- form com funcao gera hora -->
                <?php } ?>





            <?php } ?>
        </div>

        <script>
            $(document).ready(function() {
                $('.toast').toast('show');
            });
        </script>

<?php

    }


    public function setParametros($_parametros)
    {
        //echo "<pre>"; print_r($_parametros); exit;
        if (empty($_parametros)) {

            $this->ExibeFormularioDeAgendar();
        } else {
            require_once $_SESSION['pview'] . '/404.php';
        }
    }
}

?>
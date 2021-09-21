<?php


include_once $_SESSION['pview'] . '/menu.php';

class Novaagenda
{

    public function ExibeFormularioDeNovaAgenda()
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
        require_once($_SESSION['pmodel'] . '/Medico.php');


        $medicos = $Medico->buscar_todos_medicos();


        if (isset($_POST['cadastro']) && $_POST['cadastro'] == 'cadastrar') {

            $medico = filter_input(INPUT_POST, 'medico', FILTER_SANITIZE_STRING);
            $qnt = filter_input(INPUT_POST, 'qnt', FILTER_SANITIZE_STRING);
            $hinicial = filter_input(INPUT_POST, 'hinicial', FILTER_SANITIZE_STRING);
            $hfinal = filter_input(INPUT_POST, 'hfinal', FILTER_SANITIZE_STRING);


            $hora_inicial = strtotime($hinicial);
            $hora_final = strtotime($hfinal);

            if ($medico != "" && $qnt != "" && $hinicial != "" && $hfinal != "" && $hora_inicial < $hora_final) {

                if ($Agenda->buscar_agenda_id_medico($medico) == "") {
                    $id_agenda = $Agenda->inserir_agenda($medico, $qnt, $hinicial, $hfinal);
                } else {
                    $status = "error";
                    $msg = "O medico já possui agenda cadastrada.";
                }
            } else {
                $status = "error";
                $msg = "Preencha os Campos Obrigatórios, ou verifique a ordem das horas";
            }
        } // fim if filtropost

        if (isset($_POST['dias_trabalho']) && $_POST['dias_trabalho'] == 'cadastrar') {

            $dias = [];

            $id_agenda = filter_input(INPUT_POST, 'id_agenda', FILTER_SANITIZE_STRING);
            $segunda = filter_input(INPUT_POST, 'segunda', FILTER_SANITIZE_STRING);
            $terca = filter_input(INPUT_POST, 'terca', FILTER_SANITIZE_STRING);
            $quarta = filter_input(INPUT_POST, 'quarta', FILTER_SANITIZE_STRING);
            $quinta = filter_input(INPUT_POST, 'quinta', FILTER_SANITIZE_STRING);
            $sexta = filter_input(INPUT_POST, 'sexta', FILTER_SANITIZE_STRING);
            $sabado = filter_input(INPUT_POST, 'sabado', FILTER_SANITIZE_STRING);
            $domingo = filter_input(INPUT_POST, 'domingo', FILTER_SANITIZE_STRING);

            if ($segunda != "") {
                $dias[] = 1;
            }
            if ($terca != "") {
                $dias[] = 2;
            }
            if ($quarta != "") {
                $dias[] = 3;
            }
            if ($quinta != "") {
                $dias[] = 4;
            }
            if ($sexta != "") {
                $dias[] = 5;
            }
            if ($sabado != "") {
                $dias[] = 6;
            }
            if ($domingo != "") {
                $dias[] = 7;
            }

/*           echo "<pre>";
            print_r($dias);
            exit;  */

            if ($id_agenda != "") {
                $cont = 0;
                foreach ($dias as $dia) {

                    if ($Agenda->inserir_diasdetrabalho($id_agenda, $dia)) {
                        $status = "success";
                        $cont++;
                    } else {
                        $status = "error";
                        $msg = "falha ao gravar informações.";
                    }
                }

                if($cont != 0){
                    unset($id_agenda);
                }

            } else {
                $status = "error";
                $msg = "informações necessarias não encontradas.";
            }
        } // fim if filtropost
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
                        Agenda criada com sucesso
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
            <h2> Nova Agenda:</h2>
            <br>
            <?php if (!isset($id_agenda)) { ?>
                <form action="" method="POST">
                    <input type="hidden" name="cadastro" value="cadastrar">


                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="inputMedico">Médico <span class="red-text">*</span></label>
                            <select name="medico" id="inputMedico" class="form-control">
                                <option value="" selected>Escolher...</option>

                                <?php foreach ($medicos as $medico) { ?>
                                    <option value="<?= $medico['id'] ?>"><?= $medico['nome'] ?> - <?= $medico['especialidade'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputQnt">Max-Atendimentos <span class="red-text">*</span></label>
                            <input type="number" min="1" name="qnt" class="form-control" id="inputQnt" placeholder="qnt pacientes">
                        </div>

                        <div class="form-group col-md-2">
                            <label for="inputCEP">Hora Inicial</label>
                            <input type="time" name="hinicial" class="form-control" id="inputCEP">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputCEP">Hora Final</label>
                            <input type="time" name="hfinal" class="form-control" id="inputCEP">
                        </div>
                    </div>





                    <br>
                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                </form>
            <?php } else { ?>
                <form action="" method="POST">
                    <input type="hidden" name="id_agenda" value="<?php echo $id_agenda ?>">
                    <input type="hidden" name="dias_trabalho" value="cadastrar">

                    <div class="form-collumn">
                        <h4>dias de trabalho:</h4>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" name="segunda" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                Segunda
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="2" name="terca" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                Terça
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="3" name="quarta" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                Quarta
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="4" name="quinta" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                Quinta
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="5" name="sexta" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                Sexta
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="6" name="sabado" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                Sabado
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="7" name="domingo" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                Domingo
                            </label>
                        </div>

                    </div>

                    <br>
                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                </form>
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

            $this->ExibeFormularioDeNovaAgenda();
        } else {
            require_once $_SESSION['pview'] . '/404.php';
        }
    }
}

?>
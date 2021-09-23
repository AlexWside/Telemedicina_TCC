<?php



class Cadastratriagem
{

    public function ExibeFormularioDeAutoavaliacao($_idAgendamento)
    {
        $_objFunctions = new Functions();
        $_objFunctions->CriaHeader(
            array(
                "Telemedicina - Autoavaliação",
                "",
                ""
            )
        );

        require_once($_SESSION['pmodel'] . '/Agendamento.php');
        require_once($_SESSION['pmodel'] . '/Triagem.php');


        $id_agendamento = base64_decode($_idAgendamento);

        if(isset($_POST) && $_POST != null){
            
            $alergia = filter_input(INPUT_POST, 'alergia', FILTER_SANITIZE_STRING);
            $doencacronica = filter_input(INPUT_POST, 'doencacronica', FILTER_SANITIZE_STRING);
            $diabetes = filter_input(INPUT_POST, 'diabetes', FILTER_SANITIZE_STRING);
            $pressao = filter_input(INPUT_POST, 'pressao', FILTER_SANITIZE_STRING);
            $problemarespiratorio = filter_input(INPUT_POST, 'problemarespiratorio', FILTER_SANITIZE_STRING);
            $altura = filter_input(INPUT_POST, 'altura', FILTER_SANITIZE_STRING);
            $peso = filter_input(INPUT_POST, 'peso', FILTER_SANITIZE_STRING);
            $temperatura = filter_input(INPUT_POST, 'temperatura', FILTER_SANITIZE_STRING);

            if($Triagem->inserir_triagem($id_agendamento,$alergia,$doencacronica,$diabetes,$pressao,$problemarespiratorio,$altura,$peso,$temperatura)){
                if($Agendamento->concluir_autoavaliacao($id_agendamento)){
                     //header('Location:'. $_SESSION['url']);
                     echo "<script> window.location.href =  '".$_SESSION['url']."' </script>" ;
                 }
            }else{
                echo 'falha';
            }

        }


?>
        <br>
        <br>
        <div class="container">
            <h2> Autoavaliação:</h2>
            <br>
            <form method="post" action="" >


                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label >Alergia a Medicamento?</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="alergia" id="simam" value="sim">
                            <label class="form-check-label" for="simam">
                                Sim
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="alergia" value="nao" id="naoam" checked>
                            <label class="form-check-label" for="naoam">
                                Não
                            </label>
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <label >Sofre de alguma Doença Crônica</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="doencacronica" value="sim" id="simdc">
                            <label class="form-check-label" for="simdc">
                                Sim
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="doencacronica" value="nao" id="naodc" checked>
                            <label class="form-check-label" for="naodc">
                                Não
                            </label>
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <label >Tem Diabetes?</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="diabetes" value="sim" id="simtd">
                            <label class="form-check-label" for="simtd">
                                Sim
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="diabetes" value="nao" id="naotd" checked>
                            <label class="form-check-label" for="naotd">
                                Não
                            </label>
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <label >Pressão alta?</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="pressao" value="sim" id="simpa">
                            <label class="form-check-label" for="simpa">
                                Sim
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="pressao" value="nao" id="naopa" checked>
                            <label class="form-check-label" for="naopa">
                                Não
                            </label>
                        </div>
                    </div>
                </div>
                <br>
                <div class="form-row">
                <div class="form-group col-md-3">
                        <label >Sofre de algum problema Respiratório?</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="problemarespiratorio" value="sim" id="simpr">
                            <label class="form-check-label" for="simpr">
                                Sim
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="problemarespiratorio" value="nao" id="naopr" checked>
                            <label class="form-check-label" for="naopr">
                                Não
                            </label>
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <label for="inputAltura" >Altura</label>
                    <input  type="number" step="0.01" class="form-control" name="altura" id="inputAltura" placeholder="1,50" maxlength="5">
                </div>
                <div class="form-group">
                    <label for="inputPeso">Peso</label>
                    <input type="number" step="0.01" class="form-control" name="peso" id="inputPeso" placeholder="65" maxlength="5">
                </div>
                <div class="form-row">

                    <div class="form-group col-md-2">
                        <label for="inputTemperatura">Temperatura</label>
                        <input type="number" class="form-control" name="temperatura" id="inputTemperatura" placeholder="28°" maxlength="5">
                    </div>
                </div>
                <br>
                <button type="submit" class="btn btn-primary">Salvar Autoavalição</button>
            </form>
        </div><!-- /container -->







<?php

    }


    public function setParametros($_parametros)
    {
        //echo "<pre>"; print_r($_parametros); exit;

        if (!empty($_parametros)) {
            /* echo '<pre>'; print_r($_parametros[0]); exit; */
            $this->ExibeFormularioDeAutoavaliacao($_parametros[0]);
        } else {
            require_once $_SESSION['pview'] . '/404.php';
        }
    }
}

?>
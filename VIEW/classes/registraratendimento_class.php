<?php



class Registraratendimento
{

    public function ExibeFormularioDeEnvio($_idAgendamento)
    {
        $_objFunctions = new Functions();
        $_objFunctions->CriaHeader(
            array(
                "Telemedicina - Autoavaliação",
                "",
                ""
            )
        );

        require_once($_SESSION['pmodel'] . '/Atendimento.php');
        require_once($_SESSION['pmodel'] . '/Agendamento.php');
        require_once($_SESSION['pmodel'] . '/Triagem.php');
        require_once($_SESSION['pmodel'] . '/Paciente.php');


        $id_agendamento = base64_decode($_idAgendamento);



        $startControl = 0;
        if (isset($_POST['send-link']) && $_POST['send-link'] = 'true') {
            $link = filter_input(INPUT_POST, 'link', FILTER_SANITIZE_STRING);
            if ($link != "" && substr($link, 0, 23) == 'https://meet.google.com') {
                $Agendamento->inserir_link($id_agendamento, $link);
            } else {
                echo "link incompativel!!";
            }
        }

        $agendamento = $Agendamento->buscar_agendamento_id($id_agendamento);

        if (isset($_POST['finalizar-atendimento']) && $_POST['finalizar-atendimento'] = 'true') {
            $anamnese = filter_input(INPUT_POST, 'anamnese', FILTER_SANITIZE_STRING);
            $hipotese = filter_input(INPUT_POST, 'hipotese', FILTER_SANITIZE_STRING);
            $recomendacoes = filter_input(INPUT_POST, 'recomendacoes', FILTER_SANITIZE_STRING);
            $receita = filter_input(INPUT_POST, 'receita', FILTER_SANITIZE_STRING);
            if($anamnese != "" && $hipotese != ""){
                
                if($Atendimento->inserir_atendimento($id_agendamento,$anamnese,$receita, $hipotese,$recomendacoes,$agendamento['id_paciente'])){
                    $Agendamento->concluir_atendimento($id_agendamento);
                    //header("Location:".$_SESSION['url']);
                    echo "<script> window.location.href =  '".$_SESSION['url']."' </script>" ;
                }
            }else {
                echo "falha ao registrar atendimento, campos obrigatorios vazios!!";
            }
        }
        
        

        if ($agendamento['linkatendimento'] != null) {
            $startControl = 1;
            $triagem = $Triagem->buscar_triagem_agendamento_id($id_agendamento);
            $paciente = $Paciente->buscar_paciente_id($agendamento['id_paciente']);
        }





?>
        <br>
        <br>
        <div class="container">
            <h2>Atendimento:</h2>

            <?php if ($startControl == 0) { ?>
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Gerdor de Sala Google Meet</h5>
                        <!-- <a href="https://meet.google.com/new" target="_blank" class="btn btn-primary">Clique aqui</a> -->

                        <a style="color:#fff;" class="btn btn-primary" target = "popup" onclick = "window.open('https://meet.google.com/new','Atendimento','width=600,height=500')" >
                        Clique aqui
                        </a>

                    </div>
                </div>
                <div class="alert alert-info" role="alert">
                    Selecione o Botão para Gerar a sala, copie o link da sala gerada e cole no campo a baixo para disponibilizar o link para o paciente.
                </div>

                <form method="post" class="link-form" action="">
                    <input type="hidden" name="send-link" value="true">

                    <div class="text-link">
                        <label for="link" class="visually-hidden">Password</label>
                        <input type="text" class="form-control" name="link" id="link" placeholder="Cole o link aqui ...">
                    </div>
                    <div class="btn-link">
                        <button type="submit" class="btn btn-primary mb-3" onclick="return confirm('Tem certeza que deseja seder o link, ao seder ira iniciar o atendimento.');"><i class="fas fa-paper-plane"></i></button>
                    </div>
                </form>

            <?php } else { ?>
                <div class="alert alert-info" role="alert">
                    <center><h4 style="background-color:#07c6e6;padding:5px;color:#fff;">Dados Pessoais</h4></center>
                    <br>
                    <div style="display: flex; flex-direction:row; justify-content:space-between;">
                        <p><b>Nome: </b><?php echo $paciente['nome'] ?></p>
                      
                        <div><b>telefone: </b><?php echo @$paciente['telefone'] ?></div>
                   
                        <div><b>CPF: </b><?php echo @$paciente['cpf'] ?></div>
                      
                    </div>
                    <center><h4 style="background-color:#07c6e6;padding:5px; color:#fff;">Triagem</h4></center>
                    <br>
                    <div style="display: flex; flex-direction:row; justify-content:space-between;">
                        
                        
                        <p><b>Altura: </b><?php echo @$triagem['altura'] ?></p>
                        
                        <div><b>Peso: </b><?php echo @$triagem['peso'] ?></div>
                        
                        <div><b>Temperatura: </b><?php echo @$triagem['temperatura'] ?></div>
                   

                    </div>
                    <div style="display: flex; flex-direction:collumn; justify-content:space-between;">
                        <p><b>Alergia: </b><?php echo $triagem['alergia'] ?></p>
                        
                        <div><b>Doença Cronica: </b><?php echo @$triagem['doencacronica'] ?></div>
                    
                        <div><b>Diabetes: </b><?php echo @$triagem['diabetes'] ?></div>
                       
                        <div><b>Pressão: </b><?php echo @$triagem['pressao'] ?></div>
                        
                        <div><b>PR: </b><?php echo @$triagem['problemarespiratorio'] ?></div>

                    </div>
                    <center><h4 style="background-color:#07c6e6;padding:5px; color:#fff;">Link da Consulta</h4></center>
                    <div class="text-center">
                    <p><b>Sala: </b><?php echo @$agendamento['linkatendimento'] ?></p>
                    </div>
                    <!--                          -->
                </div>
                <form action="" method="post">
                    <input type="hidden" name="finalizar-atendimento" value="true">
                    <div class="form-group">
                        <label for="my-textarea">Anamnese <span class="red-text">*</span></label>
                        <textarea id="my-textarea" class="form-control" name="anamnese" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="my-textarea">Hipotese Diagnostica <span class="red-text">*</span></label>
                        <textarea id="my-textarea" class="form-control" name="hipotese" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="my-textarea">Recomendações clinicas</label>
                        <textarea id="my-textarea" class="form-control" name="recomendacoes" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="my-textarea">Receita</label>
                        <textarea id="my-textarea" class="form-control" name="receita" rows="3"></textarea>
                    </div>
                    <center><button class="btn btn-success" type="submit" onclick="return confirm('Tem certeza que deseja finalizar o atendimento?.');">Finalizar Atendimento</button></center>
                </form>

            <?php } ?>
        </div><!-- /container -->







<?php

    }


    public function setParametros($_parametros)
    {
        //echo "<pre>"; print_r($_parametros); exit;

        if (!empty($_parametros)) {
            /* echo '<pre>'; print_r($_parametros[0]); exit; */
            $this->ExibeFormularioDeEnvio($_parametros[0]);
        } else {
            require_once $_SESSION['pview'] . '/404.php';
        }
    }
}

?>
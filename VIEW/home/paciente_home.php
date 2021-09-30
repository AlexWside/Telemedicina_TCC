<?php
include_once $_SESSION['pmodel'] . '/Paciente.php';

$Paciente->paciente_online($_SESSION['token']);




if(isset($_POST['acao']) && $_POST['acao'] == 'cancelar'){

    $Agendamento->cancelar_atendimento($_POST['idagendamento']);

}


$agendamentos = $Agendamento->buscar_agendamento_paciente($_SESSION['token']);

/* echo "<pre>"; print_r($agendamentos); exit; */
?>
<!-- <a href="https://meet.google.com/new" target="_blank" class="btn btn-primary">Entrar no meet</a> -->
<br>
<div id="section">
    <div class="container">

        <h2>Hoje:</h2>
        <br>
        <div class="flex-row float-right">
            <label for="search">Busca</label>
            <input name="busca" id="busca" class="search" placeholder="Nome ou Especialidade">

        </div>




        <?php
        $cont = 0;
        foreach ($agendamentos as $key => $agendamento) {

            $dataagendamentobanco = substr($agendamento['data_agendamento'], 0, 10);
            $horaagendamentobanco = substr($agendamento['data_agendamento'], 11, 8);

            if ($dataagendamentobanco == date('Y-m-d')) {


        ?> <div class="list">
                    <div class="card card_agendamento" data-idmedico="<?= $agendamento['idmedico'] ?>" data-idagendamento="<?= $agendamento['idagendamento'] ?>">
                        <div class="card-body text-center">
                            <h5 class="card-title">Atendimento Agendado</h5>
                            <p class="card-text medico">Medico: <?= $agendamento['nomemedico'] ?></p>
                            <p class="card-text especialidade">Especialidade: <?= $agendamento['especialidade'] ?></p>
                            <p class="card-text status_medico"> Status Medico: <span style='color:red;'><i class='fas fa-circle'></i></span> offline </p>
                            <?php if ($agendamento['statusagendamento'] == 0) { ?>

                                <a class="btn btn-info" href="<?php $_SESSION['url'] ?>/cadastratriagem/<?php echo base64_encode($agendamento['idagendamento']) ?>">Autoavaliação</a>
                                <br><br>   
                                <div class="alert alert-info" role="alert">
                                   <i> clique no botão acima para realizar sua triagem </i>
                                </div>

                                <form action="" method="POST">                           
                                <input type="hidden" name="acao" value="cancelar">
                                <input type="hidden" name="idagendamento" value="<?php echo $agendamento['idagendamento'] ?>">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('ten certeza que deseja cancelar esta consulta?');">Cancelar Consulta</button>
                                </form>
                               
                            <?php } ?>
                            <?php if ($agendamento['statusagendamento'] == 1) { ?>

                                <div id="btn-consulta"> <img width="50px" src="<?php echo $_SESSION['url'] ?>view/img/loading.gif" alt="">
                                    <p style="color:green;"> Aguardando consulta...</p>
                                </div>

                                <form action="" method="POST">
                                <input type="hidden" name="acao" value="cancelar">
                                <input type="hidden" name="idagendamento" value="<?php echo $agendamento['idagendamento'] ?>">
                                <button id="btncancelar" type="submit" class="btn btn-danger" onclick="return confirm('Você tem certeza que deseja cancelar esta consulta?');">Cancelar Consulta</button>
                                </form>

                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php
                $cont++;
            }
        }
        if ($cont == 0) {
            ?>

            <div class="card">
                <div class="card-body">
                    <p class="card-text text-center">Nenhum agendamento encontrado para o dia de Hoje</p>
                </div>
            </div>
        <?php
        }
        ?>

    </div><!-- /container -->

    <script src="//cdnjs.cloudflare.com/ajax/libs/list.js/1.5.0/list.min.js"></script>
    <script>
        var options = {
            valueNames: ['especialidade', 'medico'] //
        };

        var userList = new List('section', options);
    </script>

    <script>
        $(window).on('load', function() {
            var intervalo = window.setInterval(atualizaAgendamento, 3000);

        });

        function atualizaAgendamento() {

            $('div.card_agendamento').each(function(index, div) {

                var linha = $(this);

                var idmedico = linha.data('idmedico');
                var idagendamento = linha.data('idagendamento');

                //alert(idmedico)

                $.post("../../controller/ajax/getagendamentopaciente.php", {
                    idmedico: idmedico,
                    idagendamento: idagendamento
                }, function(data) {


                    var obj = jQuery.parseJSON(data);

                    if (obj.statusmedico == 1) {

                        linha.find('p.status_medico').html("Status Medico: <span style='color:green;'><i class='fas fa-circle'></i></span> online");

                    } else {

                        linha.find('p.status_medico').html("Status Medico: <span style='color:red;'><i class='fas fa-circle'></i></span> offline");
                    }

                    if (obj.link != null && obj.statusagendamento == 1) {

                        linha.find('div#btn-consulta').html("<a target='_blank' href='" + obj.link + "' class='btn btn-success' >Entra na Sala Médica</a>");
                        linha.find('#btncancelar').css('display', 'none');
                    } else if (obj.statusagendamento == 2) {
                        linha.find('div#btn-consulta').html("<button  class='btn btn-secondary' >Finalizado</button>");
                    }

                });

            });
        }
    </script>
</div>
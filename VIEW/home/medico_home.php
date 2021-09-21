
<?php
include_once $_SESSION['pmodel'] . '/Medico.php';

$Medico->medico_online($_SESSION['token']);

$agendamentos = $Agendamento->buscar_agendamento_medico($_SESSION['token']);



/* echo "<pre>"; print_r($Agendamento->buscar_atendimento_medico()); exit; */
?>
<br>

<div id="section">
    <div class="container">
        <h2>Agendamentos de Hoje:</h2>
        <br>
        <div class="flex-row float-right">
            <label for="search">Busca</label>
            <input name="busca" id="busca" class="search" placeholder="Nome">

        </div>

        <table class="table table-light text-center table-medico">
            <tbody class="list">

                <tr>
                    <th>Status</th>
                    <th>Nome Paciente</th>
                    <th>Hora Agendada</th>
                    <th>Medico</th>
                    <th colspan="2">Opções</th>

                </tr>

                <?php 
                $cont = 0;
                foreach ($agendamentos as $key => $agendamento) {
                    
                    $dataagendamentobanco = substr($agendamento['data_agendamento'], 0, 10);
                    $horaagendamentobanco = substr($agendamento['data_agendamento'], 11, 8);

                    if ($dataagendamentobanco == date('Y-m-d')) {


                ?>

                        <tr class="linha_paciente" data-idpaciente="<?= $agendamento['idpaciente'] ?>" data-idagendamento="<?= $agendamento['idagendamento'] ?>">
                            <td class="td_paciente" >
                                <span class="span_paciente" style='color:red;'><i class='fas fa-circle'></i></span> offline
                            </td>
                            <td class="paciente">
                                <?= $agendamento['nomepaciente'] ?>
                            </td>
                            <td><?= $horaagendamentobanco ?></td>
                            <td><?= $agendamento['nomemedico'] ?></td>


                            <td  id="td_atendimento" colspan="2">
                                <button class='btn btn-secondary' disabled>Atender</button>
                            </td>


                        </tr>


                    <?php
                        $cont++;
                        
                    }
                }?>




<?php
 
                if ($cont == 0) {
                   
                    ?>
                    <tr>
                        <td colspan="6">Nenhum agendamento encontrado para o dia de Hoje</td>
                    </tr>
                <?php
                }
                ?>



                <!--                         <script>
                            function ajx() {
                                var ajax = new XMLHttpRequest(); // cria o objeto XHR
                                ajax.onreadystatechange = function() {
                                    // verifica quando o Ajax for completado
                                    if (ajax.readyState == 4 && ajax.status == 200) {

                                        if(ajax.responseText == 0){  
                                            document.getElementById("status<?= $key ?>").innerHTML = "<span style='color:red;'><i class='fas fa-circle'></i></span> offline"; // atualiza o span
                                        setTimeout(ajx, 2000); // chama a função novamente após 2 segundos
                                        }else{
                                            document.getElementById("status<?= $key ?>").innerHTML = "<span style='color:green;'><i class='fas fa-circle'></i></span> online" // atualiza o span
                                        setTimeout(ajx, 2000); // chama a função novamente após 2 segundos
                                        }

                                    }
                                }
                                ajax.open("GET", "../../controller/ajax/getstatuspaciente.php?id=<?= $agendamento['idpaciente'] ?>"); // página a ser requisitada
                                ajax.send(); // envia a requisição
                            }
                            ajx(); // chama a função
                        </script> -->
            </tbody>
        </table>
    </div><!-- /container -->

    <script src="//cdnjs.cloudflare.com/ajax/libs/list.js/1.5.0/list.min.js"></script>
    <script>
        var options = {
            valueNames: ['paciente'] //
        };

        var userList = new List('section', options);
    </script>
    <script>
        $(window).on('load', function() {
            var intervalo = window.setInterval(atualizaPaciente, 3000);

        });

        function atualizaPaciente() {

            $('table > tbody  > tr.linha_paciente').each(function(index, tr) {

                var linha = $(this);

                var idpaciente = linha.data('idpaciente');
                var idagendamento = linha.data('idagendamento');

                $.post("../../controller/ajax/getagendamentomedico.php", {
                    idpaciente: idpaciente,
                    idagendamento:idagendamento
                }, function(data) {

                    var obj = jQuery.parseJSON( data );

                    if (obj.statuspaciente == 1) {

                        linha.find('td.td_paciente').html("<span style='color:green;'><i class='fas fa-circle'></i></span> online");

                    } else {

                        linha.find('td.td_paciente').html("<span style='color:red;'><i class='fas fa-circle'></i></span> offline");
                    }

                    if (obj.statusagendamento == 1 && obj.statuspaciente == 1) {
                        
                        var emBase64 = btoa(idagendamento)
                        linha.find('td#td_atendimento').html("<a class='btn btn-success' href='<?php echo $_SESSION['url'] ?>registraratendimento/"+emBase64+"' >Atender</a>" );

                    }else{

                        linha.find('td#td_atendimento').html("<button class='btn btn-secondary' disabled>Atender</button>" );
                    }

                });

            });
        }
    </script>
</div>
<?php


include_once $_SESSION['pview'] . '/menu.php';


class Buscarpaciente
{

    public function ExibeFormularioDeBuscarPaciente()
    {
        $_objFunctions = new Functions();
        $_objFunctions->CriaHeader(
            array(
                "Telemedicina - Busca de Paciente",
                "descricao-1",
                "descricao-2"
            )
        );

        $_objMenu = new Menu();
        $_objMenu->ExibeMenu('inicio');

        require_once($_SESSION['pmodel'] . '/Paciente.php');




        if(isset($_POST['excluir']) && $_POST['excluir'] == 'true')
        {

            $Paciente->excluir_paciente($_POST['id-exclusao']);
        }

        
        $pacientes = $Paciente->buscar_todos_paciente();



        
?>

        <br>

        <div id="section">
            <div class="container">
                <h2>Busca Paciente:</h2>
                <br>
                <div class="flex-row float-right">
                    <label for="search">Busca</label>
                    <input name="busca" id="busca" class="search" placeholder="Nome ou CPF">

                </div>

                <table class="table table-light">
                    <tbody class="list">

                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>CPF</th>
                            <th>Telefone</th>
                            <th>Dt Nasc</th>
                            <th>Cadastrado</th>
                            <th colspan="2">Opções</th>
                        </tr>

                        <?php foreach ($pacientes as $paciente) { ?>

                            <tr>
                                <td><?= $paciente['id'] ?></td>
                                <td class="nome"><?= $paciente['nome'] ?></td>
                                <td><?= $paciente['email'] ?></td>
                                <td class="cpf"><?= $paciente['cpf'] ?></td>
                                <td><?= $paciente['telefone'] ?></td>
                                <td><?= $paciente['dt_nasc'] ?></td>
                                <td><?= $paciente['created'] ?></td>
                                <td>
                                    <form action="" method="post">
                                        <input type="hidden" name="excluir" value="true">
                                        <input type="hidden" name="id-exclusao" value="<?= $paciente['id'] ?>">
                                        <button class="btn-opcoes" type="submit"><img src="<?php echo $_SESSION['url'] ?>view/img/excluir.png" alt="excluir"></button>
                                    </form>
                                </td>
                                <td>
                                <a class="btn-opcoes" target = "popup" onclick = "window.open('<?php echo $_SESSION['url'] ?>controller/editarpaciente.php?id=<?= $paciente['id'] ?>','editar','width=600,height=400')" >
                                    <img src="<?php echo $_SESSION['url'] ?>view/img/editar.png" alt="excluir">
                                </a>

                                </td>
                            </tr>

                        <?php } ?>

                    </tbody>
                </table>
            </div><!-- /container -->

            <script src="//cdnjs.cloudflare.com/ajax/libs/list.js/1.5.0/list.min.js"></script>
            <script>
                var options = {
                    valueNames: ['nome', 'cpf']
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

            $this->ExibeFormularioDeBuscarPaciente();
        } else {
            require_once $_SESSION['pview'] . '/404.php';
        }
    }
}

?>
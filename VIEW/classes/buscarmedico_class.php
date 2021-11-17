<?php


include_once $_SESSION['pview'] . '/menu.php';


class Buscarmedico
{

    public function ExibeFormularioDeBuscarMedico()
    {
        $_objFunctions = new Functions();
        $_objFunctions->CriaHeader(
            array(
                "Telemedicina - Busca de Medico",
                "descricao-1",
                "descricao-2"
            )
        );

        $_objMenu = new Menu();
        $_objMenu->ExibeMenu('inicio');

        require_once($_SESSION['pmodel'] . '/Medico.php');




        if (isset($_POST['excluir']) && $_POST['excluir'] == 'true') {

            $Medico->excluir_medico($_POST['id-exclusao']);
        }


        $medicos = $Medico->buscar_todos_medicos();




?>

        <br>

        <div id="section">
            <div class="container">
                <h2>Busca Medico:</h2>
                <br>
                <div class="flex-row float-right">
                    <label for="search">Busca</label>
                    <input name="busca" id="busca" class="search" placeholder="Nome ou CRM">

                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tbody class="list">

                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>CRM</th>
                                <th>Telefone</th>
                                <th>Especialidade</th>
                                <th>Cadastrado</th>
                                <th colspan="2">Opções</th>
                            </tr>

                            <?php foreach ($medicos as $medico) { ?>

                                <tr>
                                    <td><?= $medico['id'] ?></td>
                                    <td class="nome"><?= $medico['nome'] ?></td>
                                    <td><?= $medico['email'] ?></td>
                                    <td class="crm"><?= $medico['crm'] ?></td>
                                    <td><?= $medico['telefone'] ?></td>
                                    <td><?= $medico['especialidade'] ?></td>
                                    <td><?= $medico['created'] ?></td>
                                    <td>
                                        <form action="" method="post">
                                            <input type="hidden" name="excluir" value="true">
                                            <input type="hidden" name="id-exclusao" value="<?= $medico['id'] ?>">
                                            <button class="btn-opcoes" type="submit"><img src="<?php echo $_SESSION['url'] ?>VIEW/img/excluir.png" alt="excluir"></button>
                                        </form>
                                    </td>
                                    <td>
                                        <a class="btn-opcoes" target="popup" onclick="window.open('<?php echo $_SESSION['url'] ?>CONTROLLER/editarmedico.php?id=<?= $medico['id'] ?>','editar','width=600,height=400')">
                                            <img src="<?php echo $_SESSION['url'] ?>VIEW/img/editar.png" alt="excluir">
                                        </a>

                                    </td>
                                </tr>

                            <?php } ?>

                        </tbody>
                    </table>
                </div>
            </div><!-- /container -->

            <script src="//cdnjs.cloudflare.com/ajax/libs/list.js/1.5.0/list.min.js"></script>
            <script>
                var options = {
                    valueNames: ['nome', 'crm']
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

            $this->ExibeFormularioDeBuscarMedico();
        } else {
            require_once $_SESSION['pview'] . '/404.php';
        }
    }
}

?>
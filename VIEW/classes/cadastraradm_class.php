<?php


include_once $_SESSION['pview'] . '/menu.php';


class Cadastraradm
{

    public function ExibeFormularioDeCadastroadm()
    {
        $_objFunctions = new Functions();
        $_objFunctions->CriaHeader(
            array(
                "Telemedicina - Cadastro de Paciente",
                "",
                ""
            )
        );


        $_objMenu = new Menu();
        $_objMenu->ExibeMenu('inicio');



        require_once($_SESSION['pmodel'] . '/Administrador.php');

        if (isset($_POST['cadastro']) && $_POST['cadastro'] == 'cadastrar') {

            $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING);
            $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);
            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
            $telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_STRING);
            $rg = filter_input(INPUT_POST, 'rg', FILTER_SANITIZE_STRING);
            $cpf = filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_STRING);
            $dt_nasc = filter_input(INPUT_POST, 'dt_nasc', FILTER_SANITIZE_STRING);
            $endereco = filter_input(INPUT_POST, 'endereco', FILTER_SANITIZE_STRING);
            $cidade = filter_input(INPUT_POST, 'cidade', FILTER_SANITIZE_STRING);
            $estado = filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_STRING);
            $cep = filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_STRING);
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

            if ($login != "" && $nome != "" && $dt_nasc != "" && $cpf != "" && $senha != "") {
                if ($ADM->buscar_usuario_adm($login) == "") {
                    $ADM->inserir_adm($login, $senha_hash, $nome, $telefone, $rg, $cpf, $dt_nasc, $endereco, $cidade, $estado, $cep);
                    $status = "success";
                } else {
                    $status = "Usuario Já Cadastrado";
                }
            } else {
                $status = "Campo Obrigatório não preenchido";
            }
        } // fim if filtropost

?>
        <br>

        <div class="pop-up">

            <?php if (isset($status) && $status == "success") { ?>
                <div class='toast success' role='alert' aria-live='assertive' aria-atomic='true'>
                    <div class='toast-header'>

                        <strong class='mr-auto'>Notificação</strong>
                        <small class='text-muted'>agora</small>
                    </div>
                    <div class='toast-body'>
                        Cadastro efetuado com sucesso
                    </div>
                </div>
            <?php } else if (isset($status) && $status == "error") { ?>
                <div class='toast danger' role='alert' aria-live='assertive' aria-atomic='true'>
                    <div class='toast-header'>

                        <strong class='mr-auto'>Notificação</strong>
                        <small class='text-muted'>agora</small>
                    </div>
                    <div class='toast-body'>
                        <?php echo $status ?>
                    </div>
                </div>


            <?php } ?>
        </div>
        <!--fim  tag popup -->


        <div class="container">
            <h2>Cadastro Administrador:</h2>
            <br>

            <form action="" method="POST">
                <input type="hidden" name="cadastro" value="cadastrar">
                <div class="form-row">

                    <div class="form-group col-md-6">
                        <label for="inputPassword4">Nome<span class="red-text">*</span></label>
                        <input type="text" name="nome" class="form-control" id="inputText" placeholder="Nome">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputTelefone">Telefone</label>
                        <input type="text" name="telefone" class="form-control" id="inputTelefone" placeholder="telefone">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Login <span class="red-text">*</span></label>
                        <input type="text" name="login" class="form-control" id="inputEmail4" placeholder="login">
                        <p><small><i>(login unico)</i></small></p>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Senha (Default: 123456)<span class="red-text">*</span></label>
                        <input type="password" name="senha" class="form-control" id="inputEmail4" placeholder="senha" value="123456" readonly>

                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">RG</label>
                        <input type="text" name="rg" class="form-control" id="inputEmail4" placeholder="Rg">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">CPF <span class="red-text">*</span></label>
                        <input type="text" name="cpf" class="form-control" id="inputText" placeholder="CPF">
                    </div>
                </div>
                <div class="form-row">
                    <label for="inputAddress">Data de Nascimento <span class="red-text">*</span></label>
                    <input class='form-control' name="dt_nasc" type="date">
                </div>
                <div class="form-group">
                    <label for="inputAddress">Endereço</label>
                    <input type="text" name="endereco" class="form-control" id="inputAddress" placeholder="Rua dos Bobos, nº 0">
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputCity">Cidade</label>
                        <input type="text" name="cidade" class="form-control" id="inputCity">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputEstado">Estado</label>
                        <select name="estado" id="inputEstado" class="form-control">
                            <option value="" selected>Escolher...</option>
                            <option value="AC">Acre</option>
                            <option value="AL">Alagoas</option>
                            <option value="AP">Amapá</option>
                            <option value="AM">Amazonas</option>
                            <option value="BA">Bahia</option>
                            <option value="CE">Ceará</option>
                            <option value="ES">Espírito Santo</option>
                            <option value="GO">Goiás</option>
                            <option value="MA">Maranhão</option>
                            <option value="MT">Mato Grosso</option>
                            <option value="MS">Mato Grosso do Sul</option>
                            <option value="MG">Minas Gerais</option>
                            <option value="PA">Pará</option>
                            <option value="PB">Paraíba</option>
                            <option value="PR">Paraná</option>
                            <option value="PE">Pernambuco</option>
                            <option value="PI">Piauí</option>
                            <option value="RJ">Rio de Janeiro</option>
                            <option value="RN">Rio Grande do Norte</option>
                            <option value="RS">Rio Grande do Sul</option>
                            <option value="RO">Rondônia</option>
                            <option value="RR">Roraima</option>
                            <option value="SC">Santa Catarina</option>
                            <option value="SP">São Paulo</option>
                            <option value="SE">Sergipe</option>
                            <option value="TO">Tocantins</option>
                            <option value="DF">Distrito Federal</option>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="inputCEP">CEP</label>
                        <input type="text" name="cep" class="form-control" id="inputCEP">
                    </div>
                </div>
                <br>
                <button type="submit" class="btn btn-primary">Cadastrar</button>
            </form>
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

            $this->ExibeFormularioDeCadastroadm();
        } else {
            require_once $_SESSION['pview'] . '/404.php';
        }
    }
}

?>
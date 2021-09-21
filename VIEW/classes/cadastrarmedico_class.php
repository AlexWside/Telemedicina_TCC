<?php


include_once $_SESSION['pview'] . '/menu.php';

class Cadastrarmedico
{

    public function ExibeFormularioDeCadastroMedico()
    {
        $_objFunctions = new Functions();
        $_objFunctions->CriaHeader(
            array(
                "Telemedicina - Cadastro de Médico",
                "",
                ""
            )
        );



        $_objMenu = new Menu();
        $_objMenu->ExibeMenu('inicio');



        require_once($_SESSION['pmodel'] . '/Medico.php');

        if (isset($_POST['cadastro']) && $_POST['cadastro'] == 'cadastrar') {

            $gmail = filter_input(INPUT_POST, 'gmail', FILTER_SANITIZE_STRING);
            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
            $telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_STRING);
            $rg = filter_input(INPUT_POST, 'rg', FILTER_SANITIZE_STRING);
            $cpf = filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_STRING);
            $dt_nasc = filter_input(INPUT_POST, 'dt_nasc', FILTER_SANITIZE_STRING);
            $endereco = filter_input(INPUT_POST, 'endereco', FILTER_SANITIZE_STRING);
            $cidade = filter_input(INPUT_POST, 'cidade', FILTER_SANITIZE_STRING);
            $estado = filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_STRING);
            $cep = filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_STRING);
            $crm = filter_input(INPUT_POST, 'crm', FILTER_SANITIZE_STRING);
            $especialidade = filter_input(INPUT_POST, 'especialidade', FILTER_SANITIZE_STRING);


            if ($gmail != "" && $nome != "" && $dt_nasc != "" && $cpf != "" && $crm != "" && $especialidade != "") {

                $Medico->setEmail($gmail);
                $Medico->setNome($nome);
                $Medico->setTelefone($telefone);
                $Medico->setRg($rg);
                $Medico->setCpf($cpf);
                $Medico->setDt_nasc($dt_nasc);
                $Medico->setEndereco($endereco);
                $Medico->setCidade($cidade);
                $Medico->setEstado($estado);
                $Medico->setCep($cep);
                $Medico->setCrm($crm);
                $Medico->setEspecialidade($especialidade);

                $Medico->inserir_medico();
                $status = "success";
            } else {
                $status = "error";
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
                        Falha a Cadastrar verifique os campos obrigatórios
                    </div>
                </div>


            <?php } ?>
        </div>
        <!--fim  tag popup -->


        <div class="container">
            <h2>Cadastro Médico:</h2>
            <br>

            <form action="" method="POST">
                <input type="hidden" name="cadastro" value="cadastrar">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Gmail <span class="red-text">*</span></label>
                        <input type="email" name="gmail" class="form-control" id="inputEmail4" placeholder="Gmail">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">Nome<span class="red-text">*</span></label>
                        <input type="text" name="nome" class="form-control" id="inputText" placeholder="Nome">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputTelefone">Telefone</label>
                        <input type="text" name="telefone" class="form-control" id="inputTelefone" placeholder="telefone">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">RG</label>
                        <input type="text" name="rg" class="form-control" id="inputEmail4" placeholder="Rg">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">CPF <span class="red-text">*</span></label>
                        <input type="text" name="cpf" class="form-control" id="inputText" placeholder="Cpf">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputCrm">CRM <span class="red-text">*</span></label>
                        <input type="text" name="crm" class="form-control" id="inputCrm" placeholder="CRM">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputEspecialidade">Especialidade <span class="red-text">*</span></label>
                        <select name="especialidade" id="inputEspecialidade" class="form-control">
                            <option value="" selected>Escolher...</option>
                            <option value="ClinicoGeral">Clinico Geral</option>
                            <option value="Pneumologista">Pneumologista</option>
                            <option value="Infectologista">Infectologista</option>

                        </select>
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

            $this->ExibeFormularioDeCadastroMedico();
        } else {
            require_once $_SESSION['pview'] . '/404.php';
        }
    }
}

?>
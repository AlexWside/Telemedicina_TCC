<?php

@session_start();

if(!isset($_SESSION['permissao'])){
    die('Sessão espirou tente novamente.');
 }

if (isset($_GET['id'])) {
    $id = $_GET['id'];
}else{
    die('sessão espirou tente novamente');
}


require_once($_SESSION['pmodel'] . '/Medico.php');

$medico = $Medico->buscar_medico_id($id);


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

        $Medico->editar_medico($id, $gmail, $nome, $telefone, $rg, $cpf, $dt_nasc, $endereco, $cidade, $estado, $cep,$crm,$especialidade);
        $status = "success";
    } else {
        $status = "error";
    }
} // fim if filtropost



?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar</title>
    <!-- bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>

    <!--jquery-->

    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <style>
        .pop-up {
            position: absolute;
            margin-left: 3em;
            z-index: 4;
        }

        .success {
            background-color: #00ff40 !important;
        }

        .danger {
            background-color: #fd5151 !important;
        }

        .red-text {
            color: red;
        }
    </style>
</head>
<!-- headerzinha -->
<br>

<div class="pop-up">

    <?php if (isset($status) && $status == "success") { 
         echo "<script>window.close();</script>"; 
         } else if (isset($status) && $status == "error") { ?>
        <div class='toast danger' role='alert' aria-live='assertive' aria-atomic='true'>
            <div class='toast-header'>

                <strong class='mr-auto'>Notificação</strong>
                <small class='text-muted'>agora</small>
            </div>
            <div class='toast-body'>
                Falha ao editar verifique os campos obrigatórios
            </div>
        </div>


    <?php } ?>
</div>
<!--fim  tag popup -->


<div class="container">
    <h2>Editar Medico:</h2>
    <br>

    <form action="" method="POST">
        <input type="hidden" name="cadastro" value="cadastrar">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputEmail4">Gmail <span class="red-text">*</span></label>
                <input type="email" name="gmail" class="form-control" id="inputEmail4" placeholder="Gmail" value="<?php echo $medico['email']; ?>">
            </div>
            <div class="form-group col-md-6">
                <label for="inputPassword4">Nome<span class="red-text">*</span></label>
                <input type="text" name="nome" class="form-control" id="inputText" placeholder="Nome" value="<?= $medico['nome']; ?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputTelefone">Telefone</label>
                <input type="text" name="telefone" class="form-control" id="inputTelefone" placeholder="telefone" value="<?= $medico['telefone']; ?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputEmail4">RG</label>
                <input type="text" name="rg" class="form-control" id="inputEmail4" placeholder="Rg" value="<?= $medico['rg']; ?>">
            </div>
            <div class="form-group col-md-6">
                <label for="inputPassword4">CPF <span class="red-text">*</span></label>
                <input type="text" name="cpf" class="form-control" id="inputText" placeholder="Cpf" value="<?= $medico['cpf']; ?>">
            </div>
        </div>
        <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputCrm">CRM <span class="red-text">*</span></label>
                        <input type="text" name="crm" class="form-control" id="inputCrm" placeholder="CRM" value="<?= $medico['cpf']; ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputEspecialidade">Especialidade <span class="red-text">*</span></label>
                        <select name="especialidade" id="inputEspecialidade" class="form-control" value="<?= $medico['especialidade']; ?>">
                            <option value="" selected>Escolher...</option>
                            <option value="ClinicoGeral">Clinico Geral</option>
                            <option value="Pneumologista">Pneumologista</option>
                            <option value="Infectologista">Infectologista</option>

                        </select>
                    </div>
                </div>
        <div class="form-row">
            <label for="inputAddress">Data de Nascimento <span class="red-text">*</span></label>
            <input class='form-control' name="dt_nasc" type="date" value="<?= $medico['dt_nasc']; ?>">
        </div>
        <div class="form-group">
            <label for="inputAddress">Endereço</label>
            <input type="text" name="endereco" class="form-control" id="inputAddress" placeholder="Rua dos Bobos, nº 0" value="<?= $medico['endereco']; ?>">
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputCity">Cidade</label>
                <input type="text" name="cidade" class="form-control" id="inputCity" value="<?= $medico['cidade']; ?>">
            </div>
            <div class="form-group col-md-4">
                <label for="inputEstado">Estado</label>
                <select name="estado" id="inputEstado" class="form-control" value="<?= $medico['estado']; ?>">
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
                <input type="text" name="cep" class="form-control" id="inputCEP" value="<?= $medico['cep']; ?>">
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


</html>
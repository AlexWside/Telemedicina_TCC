<?php

@session_start();

if (!isset($_SESSION['permissao'])) {
    die('Sessão espirou tente novamente.');
}

require_once($_SESSION['pmodel'] . '/Administrador.php');


if (isset($_POST['Mudar']) && $_POST['Mudar'] == 'true') {

    $atual = filter_input(INPUT_POST, 'atual', FILTER_SANITIZE_STRING);
    $senha1 = filter_input(INPUT_POST, 'senha1', FILTER_SANITIZE_STRING);
    $senha2 = filter_input(INPUT_POST, 'senha2', FILTER_SANITIZE_STRING);
    $senha_hash = password_hash($senha1, PASSWORD_DEFAULT);

    $administrador = $ADM->buscar_usuario_adm($_SESSION['login']);
    if ($senha1 == $senha2 && password_verify($atual, $administrador['senha']) && strlen($senha1) >= 6) {

        if ($ADM->mudar_senha($_SESSION['login'], $senha_hash)) {
            $status = "success";
        } else {
            $status = "error";
        }
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
    <title>Trocar de Senha</title>
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

    <?php if (isset($status) && $status == "success") { ?>
        <div class='toast success' role='alert' aria-live='assertive' aria-atomic='true'>
            <div class='toast-header'>

                <strong class='mr-auto'>Notificação</strong>
                <small class='text-muted'>agora</small>
            </div>
            <div class='toast-body'>
                Editado com sucesso
            </div>
        </div>
    <?php } else if (isset($status) && $status == "error") { ?>
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
    <h2>Mudar Senha:</h2>
    <br>

    <form action="" method="POST">
        <input type="hidden" name="Mudar" value="true">
        <div class="form-row">
            <div class="form-group col-md-3">
                <label for="inputEmail4">Senha Atual <span class="red-text">*</span></label>
                <input type="password" name="atual" class="form-control" id="inputEmail4" placeholder="Senha Atual">
            </div>
           
            <div class="alert alert-info text-center" role="alert">
                * No mínimo 6 caracteres
            </div>
           
            <div class="form-group col-md-3">
                <label for="inputPassword4">Nova Senha<span class="red-text">*</span></label>
                <input type="password" name="senha1" class="form-control" id="inputText" placeholder="Nova senha">
            </div>
            <div class="form-group col-md-3">
                <label for="inputPassword4">Confirmar Nova Senha<span class="red-text">*</span></label>
                <input type="password" name="senha2" class="form-control" id="inputText" placeholder="Confirmar Nova Senha">
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
<?php
/* Cria o header principal da página */
include_once $_SESSION['pcontroller'] . '/functions.php';
$_objFunctions = new Functions();
$_objFunctions->CriaHeader(
    array(
        "Telemedicina - Login Adm",
        "",
        ""
    )
);


?>


<!-- P -->

<!--  -->
<div class="container">

    <div class="card card-container">

        <form method="POST" action=<?php echo $_SESSION['url'] . 'CONTROLLER/valida.php' ?> class="">
            <span id="reauth-email" class="reauth-email"></span>
            <input type="text" id="inputEmail" class="form-control" name="login" placeholder="login" required autofocus><br>
            <input type="password" id="inputPassword" class="form-control" name="senha" placeholder="senha" required><br>
            <input type="hidden" name="post_type" value="administrador">

            <?php if (isset($_GET['status']) && $_GET['status'] == 'uerror') { ?>
                <div class="alert alert-info" role="alert">
                    login invalido
                </div>
            <?php } else if (isset($_GET['status']) && $_GET['status'] == 'serror') { ?>
                <div class="alert alert-info" role="alert">
                    senha invalida
                </div>
            <?php } ?>
            <br>

            <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Entrar</button>
        </form><!-- /form -->
        <p id="msg"></p>

    </div><!-- /card-container -->
</div><!-- /container -->
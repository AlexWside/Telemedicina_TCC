<?php



class Medico
{

    public function ExibeFormularioDeMedico()
    {
        $_objFunctions = new Functions();
        $_objFunctions->CriaHeader(
            array(
                "Telemedicina - Login",
                "",
                ""
            )
        );





?>
        <div class="container">
            <div class="card card-container text-center">
                <h2>Olá Doutor,<br> Bem Vindo ao Consultório Virtual</h2>
                <p>aqui você podá atender em um ambiente completamente
                    seguro na comodidade da sua casa,o seu paciente a poucos cliques de distância.</p>
                <center>
                    <div class="g-signin2" data-onsuccess="onSignIn"></div>
                </center>
                <br>
                <div class="alert alert-info" role="alert">
                    <p id="msg"></p>
                </div>
            </div><!-- /card-container -->
        </div><!-- /container -->





        <script>
            function onSignIn(googleUser) {
                var profile = googleUser.getBasicProfile();
                var userID = profile.getId(); // Do not send to your backend! Use an ID token instead.
                var userName = profile.getName();
                var userPicture = profile.getImageUrl();
                var userEmail = profile.getEmail(); // This is null if the 'email' scope is not present.
                var userToken = googleUser.getAuthResponse().id_token;

                // document.getElementById('name').innerHTML = userName;

                if (userName != "") {

                    var dados = {
                        userID: userID,
                        userName: userName,
                        userPicture: userPicture,
                        userEmail: userEmail,
                        userToken: userToken,
                        post_type: 'medico'
                    };




                    $.post('../CONTROLLER/valida.php', dados, function(retorno) {
                        /* alert(retorno)  */
                        if (retorno == 'error') {
                            msg = "falha ao tentar logar"
                            document.getElementById('msg').innerHTML = msg;
                        } else {
                            window.location.href = "http://localhost:8001"
                        }
                        
                    });



                } else {

                    var msg = "usuario não encontrado!"
                    document.getElementById('msg').innerHTML = msg;
                }

            }
        </script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>


<?php

    }


    public function setParametros($_parametros)
    {
        //echo "<pre>"; print_r($_parametros); exit;
        if (empty($_parametros)) {

            $this->ExibeFormularioDeMedico();
        } else {
            require_once $_SESSION['pview'] . '/404.php';
        }
    }
}

?>
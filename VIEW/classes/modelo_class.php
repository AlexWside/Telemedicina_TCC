<?php



class Modelo
{

    public function ExibeFormularioDeModelo()
    {
        $_objFunctions = new Functions();
        $_objFunctions->CriaHeader(
            array(
                "Telemedicina - ",
                "",
                ""
            )
        );



        

?>
        <div class="container">
            <div class="card card-container">
                <center>
                    <h1>modelo de class view </h1>
                </center>
                
            </div><!-- /card-container -->
        </div><!-- /container -->

        



        

<?php

    }


    public function setParametros($_parametros)
    {
        //echo "<pre>"; print_r($_parametros); exit;
        if (empty($_parametros)) {

            $this->ExibeFormularioDeModelo();
        } else {
            require_once $_SESSION['pview'] . '/404.php';
        }
    }
}

?>
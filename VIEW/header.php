<?php

class Header
{

    public function __construct(
        $_title         = '',
        $_description     = '',
        $_keywords         = '',
        $_adicionais     = ''
    ) {
?>

        <!DOCTYPE html>
        <html>

        <head>
            <title><?php echo $_title; ?></title>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            <meta http-equiv="content-language" content="pt-br">

            <meta http-equiv="Expires" content="0">

            <meta name="description" content="<?php echo $_description; ?>" />
            <meta name="keywords" content="<?php echo $_keywords; ?>" />

            <meta name="author" content="Alexsandro Fonseca <alexsandro.akila@gmail.com>" />

            <meta name="editoria" content="" />
            <link rel="shortcut icon" href="/VIEW/img/icon-telemed.png"  />

            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <!-- bootstrap 5 -->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
            <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

            


            <!--jquery-->
            
            <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
            <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>        
           <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>

            <!-- Custom fonts for this template-->
            <script src="https://kit.fontawesome.com/f6c827c339.js" crossorigin="anonymous"></script>
            <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

            <!-- Custom styles for this template-->
            <link href="<?php echo $_SESSION['url']; ?>VIEW/css/style.css" rel="stylesheet" type="text/css" />
            <!-- plugin busca jquery -->

            <!-- <script src="http://cdnjs.cloudflare.com/ajax/libs/list.js/2.3.1/list.min.js"></script> -->

            <!-- google -->
            <script src="https://apis.google.com/js/platform.js" async defer></script>
            <meta name="google-signin-client_id" content="240154881779-qldlhk581bv3b10hpo6p8v203ims960d.apps.googleusercontent.com">

            
            <style>
                @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;1,100;1,300;1,400;1,500&display=swap');
            </style>

            <?php
            if (!empty($_adicionais) and is_array($_adicionais)) {
                foreach ($_adicionais as $_adicional) {
                    echo $_adicional;
                }
            }
            ?>

        </head>

        <body id="page-top">

            <!-- Page Wrapper -->
            <div id="wrapper">
            <?php
        }


        public function CriaCabecalho()
        {
            ?>

        <?php
        }
    } // fim da classe

        ?>
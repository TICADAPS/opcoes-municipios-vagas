<?php
session_start();
require_once ("conexao.php");
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <title>título da aba</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="css/estilo.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <link rel="shortcut icon" href="img/iconAdaps.png"/>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="js/script.js" type="text/javascript"></script>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-4 col-sm-6">
                    <img src="img/Logo_400x200.png" class="img-fluid" alt="logoAdaps" title="Logo Adaps">
                </div>
                <div class="col-12 col-md-8 col-sm-6 mt-5 ">
                    <h3 class="mb-4">título a ser apresentado</h3>
                </div>
            </div>
            <div class="container bg-light mt-4 p-5 mb-4">
                <div class="row">
                    <div class="col-12 col-md-6 mx-auto">
                        <?php
                        $msg = "<p></p>";
                        if(isset($_POST['pesquisarPorCpf'])){
                            $cpf = trim($_POST['cpf']);
                            if($cpf != null && $cpf != '' ){
                                $_SESSION['cpf'] = $cpf;
                                echo "<META HTTP-EQUIV='REFRESH' CONTENT=\"0;
                                URL='cadBolsista.php'\">";
                            }else{
                                $msg = "<p class='bg-warning p-3 rounded text-center'>Digite o seu CPF.</p>";
                            }
                        }
                        echo $msg;
                        ?>
                        <form method="post" action="">
                            <p class="mt-2 text-justify text-danger">*Entre com seu CPF para efetuar o cadastro e a escolha das opções.</p>
                            <h5 class="mt-2">CPF:</a></h5>
                            <input type="text" name="cpf" class="form-control form-control-lg mt-2" placeholder="xxx.xxx.xxx-xx"/>
                            <input type="submit" name="pesquisarPorCpf" class="form-control form-control-lg btn btn-primary btn-lg mt-2" value="Pesquisar"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

<?php
session_start();
require_once ("conexao.php");
require_once ("./Controller/fdatas.php");
if (!isset($_SESSION['msg'])) {
    $_SESSION['msg'] = "";
}
$sql = "select m.municipio , e.uf, e.nomeestado, m.vagas from municipio m INNER JOIN estado e on m.iduf = e.iduf 
    where vagas > 0 order by e.uf";
$stm = mysqli_query($conn, $sql) or die(mysqli_errno($conn));
$nrrows = mysqli_num_rows($stm);
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <title>Área do médico</title>
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
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-4 col-sm-6">
                    <img src="img/Logo_400x200.png" class="img-fluid" alt="logoAdaps" title="Logo Adaps">
                </div>
                <div class="col-12 col-md-8 col-sm-6 mt-5 ">
                    <h3 class="mb-4">Lista dos municípios por estado e as respectivas vagas oferecidas para Bolsistas.</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <img src="./img/barra.png" class="mb-2" style="margin-bottom: 0px; margin-right: 4px;"><a href="logout.php" class="btn btn-danger mb-2">Sair</a>
                </div>
            </div>
            <div class="row">
                <div class="container bg-light">
                    <div class="row">
                        <div class="col-12 mb-5 mt-4">
                            <table class="table table-hover table-bordered table-striped table-responsive rounded">
                                <thead>
                                    <tr class="bg-dark text-light font-weight-bold">
                                        <td>Estado(UF)</td>
                                        <td>Município</td>
                                        <td>Nr. Vagas</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- estrutura do loop -->
                                    <?php
                                    if ($nrrows > 0) {
                                        while ($row_query = mysqli_fetch_assoc($stm)) {
                                            $nomeestado = ucwords($row_query['nomeestado']);
                                            $uf = $row_query['uf'];
                                            $nomemunicipio = ucwords($row_query['municipio']);
                                            $vagas= $row_query['vagas'];
                                            ?>
                                            <tr>
                                                <td><?php echo "$nomeestado ($uf)"; ?></td>
                                                <td><?php echo "$nomemunicipio"; ?></td>
                                                <td><?php if($vagas == 1) echo "$vagas vaga.";
                                                          else echo "$vagas vagas."?></td>
                                            <?php } ?>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>


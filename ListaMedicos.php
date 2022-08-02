<?php
session_start();
require_once ("conexao.php");
require_once ("./Controller/fdatas.php");
if (!isset($_SESSION['msg'])) {
    $_SESSION['msg'] = "";
}
$sql = "select medico.idmedico, medico.nomemedico, medico.cpf, medico.cargo, m1.municipio as municipio1, e1.uf as uf1, 
    m1.vagas as vagas1, m2.vagas as vagas2, m3.vagas as vagas3,
    m2.municipio as municipio2, e2.uf as uf2, m3.municipio as municipio3, e3.uf as uf3, medico.datahoraregistro
    from medico inner join municipio m1 on m1.idmunicipio = medico.municipio1 INNER JOIN estado e1 on m1.iduf = e1.iduf 
    left join municipio m2 on m2.idmunicipio = medico.municipio2 left JOIN estado e2 on m2.iduf = e2.iduf 
    left join municipio m3 on m3.idmunicipio = medico.municipio3 left JOIN estado e3 on m3.iduf = e3.iduf order by medico.nomemedico";
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
                    <h3 class="mb-4">Lista dos médicos bolsistas e suas respectivas escolhas</h3>
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
                                        <td>Bolsista</td>
                                        <td>1ª Opção</td>
                                        <td>2ª Opção</td>
                                        <td>3ª Opção</td>
                                        <td>Data/Hora do Registro</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- estrutura do loop -->
                                    <?php
                                    if ($nrrows > 0) {
                                        while ($row_query = mysqli_fetch_assoc($stm)) {
                                            $idmedico = $row_query['idmedico'];
                                            $nomemedico = $row_query['nomemedico'];
                                            $cargo = $row_query['cargo'];
                                            $nomemunicipio1 = ucwords($row_query['municipio1']);
                                            $nomemunicipio2 = ucwords($row_query['municipio2']);
                                            $nomemunicipio3 = ucwords($row_query['municipio3']);
                                            $uf1 = $row_query['uf1'];
                                            $uf2 = $row_query['uf2'];
                                            $uf3 = $row_query['uf3'];
                                            $vagas1= $row_query['vagas1'];
                                            $vagas2 = $row_query['vagas2'];
                                            $vagas3 = $row_query['vagas3'];
                                            $datahoraregistro = vemdata($row_query['datahoraregistro']) . " " . horaEmin($row_query['datahoraregistro']);
                                            ?>
                                            <tr>
                                                <td><?php echo ucwords($nomemedico); ?></td>
                                                <td><?php if($nomemunicipio1 != null) echo "$nomemunicipio1-$uf1 - $vagas1 vagas."; ?></td>
                                                <td><?php if($nomemunicipio2 != null) echo "$nomemunicipio2-$uf2 - $vagas2 vagas."; ?></td>
                                                <td><?php if($nomemunicipio3 != null) echo "$nomemunicipio3-$uf3 - $vagas3 vagas."; ?></td>
                                                <td><?php echo $datahoraregistro; ?></td>
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


<?php
session_start();
require_once ("conexao.php");

date_default_timezone_set('America/Sao_Paulo');
//$dataHora = date('d');
$dt = new DateTime();
$dia = $dt->format('d');
$horaH = $dt->format('H');

if($dia == 12 && $horaH > 17){
    header("Location: encerramento.php"); exit();
}
if (!isset($_SESSION['cpf'])) {
    header("Location: logout.php"); exit();
}
$cpf = $_SESSION['cpf'];
//var_dump($cpf);
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
<?php
if($cpf != '' || $cpf != null){
    $sql = "select * from medico where cpf = '$cpf'";
    $stm = mysqli_query($conn, $sql) or die(mysqli_errno($conn));
    $nrrows = mysqli_num_rows($stm);
    //var_dump($row_query);
    if ($nrrows > 0) {
        //var_dump($nrrows);
        while ($row_query = mysqli_fetch_assoc($stm)) {
            $idmedico = $row_query['idmedico'];
            $nomemedico = $row_query['nomemedico'];
            $cpf = $row_query['cpf'];
            $cargo = $row_query['cargo'];
            $municipio1= $row_query['municipio1'];
            $municipio2 = $row_query['municipio2'];
            $municipio3 = $row_query['municipio3'];
            $datahoraregistro = $row_query['datahoraregistro'];
            //var_dump($datahoraregistro);
            
            if($municipio1 != null || $municipio1 != ""){
               $sql = "select medico.idmedico, medico.nomemedico, medico.cpf, medico.cargo, m1.municipio as municipio1, e1.uf as uf1, 
                        m1.vagas as vagas1, m2.vagas as vagas2, m3.vagas as vagas3,
                        m2.municipio as municipio2, e2.uf as uf2, m3.municipio as municipio3, e3.uf as uf3, medico.datahoraregistro
                        from medico inner join municipio m1 on m1.idmunicipio = medico.municipio1 INNER JOIN estado e1 on m1.iduf = e1.iduf 
                        left join municipio m2 on m2.idmunicipio = medico.municipio2 left JOIN estado e2 on m2.iduf = e2.iduf 
                        left join municipio m3 on m3.idmunicipio = medico.municipio3 left JOIN estado e3 on m3.iduf = e3.iduf 
                        where cpf = '$cpf'";
                $stm = mysqli_query($conn, $sql) or die(mysqli_errno($conn));
                $nrrows = mysqli_num_rows($stm);
                if ($nrrows > 0) {
                    while ($row_query = mysqli_fetch_assoc($stm)) {
                        $uf= $row_query['uf1'];
                        $uf2 = $row_query['uf2'];
                        $uf3 = $row_query['uf3'];
                        $nomemunicipio1= $row_query['municipio1'];
                        $nomemunicipio2 = $row_query['municipio2'];
                        $nomemunicipio3 = $row_query['municipio3'];
                        $vagas1= $row_query['vagas1'];
                        $vagas2 = $row_query['vagas2'];
                        $vagas3 = $row_query['vagas3'];
                    }
                }
?>
            
        <div class="row">
            <div class="col-12 col-md-4 col-sm-6">
                <img src="img/Logo_400x200.png" class="img-fluid" alt="logoAdaps" title="Logo Adaps">
            </div>
            <div class="col-12 col-md-8 col-sm-6 mt-5 ">
                <h4 class="mb-4 font-weight-bold">Escolhas das opções de vagas disponíveis.</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <img src="./img/barra.png" class="mb-2" style="margin-bottom: 0px; margin-right: 4px;"><a href="logout.php" class="btn btn-danger mb-2">Sair</a>
            </div>
        </div>
        <div class="container bg-light p-5 mb-4">
            <div class="row">
                <div class="col-12 col-md-6 mx-auto">
                    <?php 
                        if($_SESSION['msg']!=""){
                            echo $_SESSION['msg'];
                            echo "<META HTTP-EQUIV='REFRESH' CONTENT=\"2;
                            URL='cadBolsista.php'\">";
                            $_SESSION['msg']="";
                        }
                    ?>
                    <form method="post" action="cadBolsistaApaga.php">
                        <input type="hidden" name="idmedico" value="<?= $idmedico ?>"/>
                        <label>Nome completo:</a></label>
                        <input type="text" name="nome" disabled class="form-control form-control-lg mb-2" value="<?= $nomemedico ?>"/>
                        <label class="mt-2"></label>CPF:</a></label>
                        <input type="text" disabled name="cpf" class="form-control form-control-lg mb-2" value="<?= $cpf ?>"/>
                        <label class="mt-2"></label>Cargo:</a></label>
                        <input type="text" disabled name="cargo" class="form-control form-control-lg mb-2" value="<?= ucwords($cargo) ?>"/>
                        <div class="col-12 mx-auto border rounded mt-3 p-3">
                            <h6 class="text-primary"><label class="text-danger">* </label> 1ª opção de município:</h6>
                            <label class="mt-2">UF <?php echo $uf;?>:</a></label>
                            <input type="text" disabled name="uf" class="form-control form-control-lg mb-2" value="<?= $uf ?>"/>
                            <label class="mt-2">Município: </label> 
                            <input type="text" disabled name="municipio" class="form-control form-control-lg mb-2" value="<?php if($nomemunicipio1!=null) echo "$nomemunicipio1 - $vagas1 vagas."; ?>"/>
                        </div>
                        <div class="col-12 mx-auto border rounded mt-2 p-3">
                            <h6 class="text-primary">2ª opção de município:</h6>
                            <label class="mt-2">UF:</a></label>
                            <input type="text" disabled name="uf2" class="form-control form-control-lg mb-2" value="<?= $uf2 ?>"/>
                            <label class="mt-2">Município: </label> 
                            <input type="text" disabled name="municipio2" class="form-control form-control-lg mb-2" value="<?php if($nomemunicipio2!=null) echo "$nomemunicipio2 - $vagas2 vagas."; ?>"/>
                        </div>
                        <div class="col-12 mx-auto border rounded mt-2 p-3">
                            <h6 class="text-primary">3ª opção de município:</h6>
                            <label class="mt-2">UF:</a></label>
                            <input type="text" disabled name="uf3" class="form-control form-control-lg mb-2" value="<?= $uf3 ?>"/>
                            <label class="mt-2">Município: </label> 
                            <input type="text" disabled name="municipio3" class="form-control form-control-lg mb-2" value="<?php if($nomemunicipio3!=null) echo "$nomemunicipio3 - $vagas3 vagas."; ?>"/>
                        </div>
                        <button type="button" class="btn btn-primary form-control form-control-lg mt-2" data-toggle="modal" data-target="#modalConfirma2">Apagar e escolher novamente</button>
                        <a href="logout.php" class="btn btn-danger form-control form-control-lg mt-2">Sair</a>
                        <!-- modalOprSim de confirmação de apresentação do médico -->
                            <div class="modal fade" id="modalConfirma2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header bg-dark">
                                      <h6 class="modal-title text-light" id="exampleModalLabel">Confirmação de exclusão das escolhas</h6>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                        <label for="date-apresentacao" class="text-justify">As escolhas dos municípios serão apagadas da base de dados, e você 
                                            será redirecionado para uma nova escolha.</label><br>
                                        <label for="date-apresentacao" class="text-justify font-weight-bold text-danger">Deseja Confirmar?</label><br>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="submit" class="btn btn-danger" name="confirmaEnvio" value="Apagar">
                                      <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            <!-- fim do modalOprSim de confirmação de apresentação do médico -->
                    </form>
                </div>
            </div>
        </div>
           
<?php
            }else{ 
            ?>
        <div class="row">
            <div class="col-12 col-md-4 col-sm-6">
                <img src="img/Logo_400x200.png" class="img-fluid" alt="logoAdaps" title="Logo Adaps">
            </div>
            <div class="col-12 col-md-8 col-sm-6 mt-5 ">
                <h4 class="mb-4 font-weight-bold">Escolhas das opções de vagas disponíveis.</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <img src="./img/barra.png" class="mb-2" style="margin-bottom: 0px; margin-right: 4px;"><a href="logout.php" class="btn btn-danger mb-2">Sair</a>
            </div>
        </div>
        <div class="container bg-light p-5 mb-4">
            <div class="row">
                <div class="col-12 col-md-6 mx-auto">
                    <?php 
                        if($_SESSION['msg']!=""){
                            echo $_SESSION['msg'];
                            echo "<META HTTP-EQUIV='REFRESH' CONTENT=\"2;
                            URL='cadBolsista.php'\">";
                            $_SESSION['msg']="";
                        }
                    ?>
                    <form method="post" action="">
                        <p class="text-danger">* Na 1ª opção a escolha é obrigatória.</p>
                        <input type="hidden" name="idmedico" value="<?= $idmedico ?>"/>
                        <input type="hidden" name="nomemedico" value="<?= $nomemedico ?>"/>
                        <input type="hidden" name="cpf" value="<?= $cpf ?>"/>
                        <input type="hidden" name="cargo" value="<?= $cargo ?>"/>
                        <label>Nome completo:</a></label>
                        <input type="text" name="nome" disabled class="form-control form-control-lg mb-2" value="<?= $nomemedico ?>"/>
                        <label class="mt-2"></label>CPF:</a></label>
                        <input type="text" disabled name="cpf" class="form-control form-control-lg mb-2" value="<?= $cpf ?>"/>
                        <label class="mt-2"></label>Cargo:</a></label>
                        <input type="text" disabled name="cargo" class="form-control form-control-lg mb-2" value="<?= ucwords($cargo) ?>"/>
                        <div class="col-12 mx-auto border rounded mt-3 p-3">
                            <h6 class="text-primary"><label class="text-danger">* </label> 1ª opção de município:</h6>
                            <label class="mt-2">UF:</a></label>
                            <?php
                                $rs = mysqli_query($conn, "SELECT estado.iduf, estado.uf FROM estado inner join municipio on estado.iduf = municipio.iduf "
                                        . "                 where municipio.vagas > 0 group by estado.uf ORDER BY estado.uf");
                            ?>
                            <select name="uf" id="uf" class="form-control" required="required">
                                <option>[--SELECIONE--]</option>
                                <?php while ($reg = mysqli_fetch_object($rs)): ?>
                                    <option value="<?php echo $reg->iduf; ?>"><?php echo $reg->uf; ?></option>
                                <?php endwhile; ?>
                            </select>
                            <label class="mt-2">Município: </label> 
                            <select name="municipio" class="form-control mb-2" id="municipio">
                                <option value="">[--SELECIONE--]</option>
                            </select>
                        </div>
                        <div class="col-12 mx-auto border rounded mt-2 p-3">
                            <h6 class="text-primary">2ª opção de município:</h6>
                            <label class="mt-2">UF:</a></label>
                            <?php
                                $rs2 = mysqli_query($conn, "SELECT estado.iduf, estado.uf FROM estado inner join municipio on estado.iduf = municipio.iduf "
                                        . "                 where municipio.vagas > 0 group by estado.uf ORDER BY estado.uf");
                            ?>
                            <select name="uf2" id="uf2" class="form-control">
                                <option>[--SELECIONE--]</option>
                                <?php while ($reg2 = mysqli_fetch_object($rs2)): ?>
                                    <option value="<?php echo $reg2->iduf; ?>"><?php echo $reg2->uf; ?></option>
                                <?php endwhile; ?>
                            </select>
                            <label class="mt-2">Município: </label> 
                            <select name="municipio2" class="form-control mb-2" id="municipio2">
                                <option value="">[--SELECIONE--]</option>
                            </select>
                        </div>
                        <div class="col-12 mx-auto border rounded mt-2 p-3">
                            <h6 class="text-primary">3ª opção de município:</h6>
                            <label class="mt-2">UF:</a></label>
                            <?php
                                $rs3= mysqli_query($conn, "SELECT estado.iduf, estado.uf FROM estado inner join municipio on estado.iduf = municipio.iduf "
                                        . "                 where municipio.vagas > 0 group by estado.uf ORDER BY estado.uf");
                            ?>
                            <select name="uf3" id="uf3" class="form-control">
                                <option>[--SELECIONE--]</option>
                                <?php while ($reg3 = mysqli_fetch_object($rs3)): ?>
                                    <option value="<?php echo $reg3->iduf; ?>"><?php echo $reg3->uf; ?></option>
                                <?php endwhile; ?>
                            </select>
                            <label class="mt-2">Município: </label> 
                            <select name="municipio3" class="form-control mb-2" id="municipio3">
                                <option value="">[--SELECIONE--]</option>
                            </select>
                        </div>
                        <input type="submit" class="btn btn-success form-control form-control-lg mt-2" name="confirmaEnvio" value="Salvar">
                        <a href="logout.php" class="btn btn-danger form-control form-control-lg mt-2">Sair</a>
                    </form>
                </div>
            </div>
        </div>
            <?php
            }
        }
    }else{
        header("Location: logout.php"); exit();
   }
} else {
    header("Location: logout.php"); exit();
}
?>
    </div>
<?php
if (isset($_POST['confirmaEnvio'])) {
    $idmedico = $_POST['idmedico'];
    $nomemedico = $_POST['nomemedico'];
    $cpf = $_POST['cpf'];
    $cargo = $_POST['cargo'];
    $uf = $_POST['uf'];
    $uf2 = $_POST['uf2'];
    $uf3 = $_POST['uf3'];
    $municipio1 = $_POST['municipio'];
    $municipio2 = $_POST['municipio2'];
    $municipio3 = $_POST['municipio3'];

    // DEFINE O FUSO HORARIO COMO O HORARIO DE BRASILIA
    date_default_timezone_set('America/Sao_Paulo');
    $datahoraregistro = date('Y/m/d H:i:s', time());
    if ($uf == "[--SELECIONE--]") {
        $_SESSION['msg'] = '<p class="bg-danger text-light text-center p-2 rounded font-weight-bold">Na 1ª opção a escolha é obrigatória.</p>';

    } else {
        $sql = "update medico set municipio1 = '$municipio1', "
                . "datahoraregistro = '$datahoraregistro' "
                . "where idmedico = '$idmedico'";
        mysqli_query($conn, $sql) or die(mysqli_error($conn));
        if ($uf2 == "[--SELECIONE--]"){
            $sql = "update medico set municipio2 = null, "
                . "datahoraregistro = '$datahoraregistro' "
                . "where idmedico = '$idmedico'";
            mysqli_query($conn, $sql) or die(mysqli_error($conn));
        }else{
            $sql = "update medico set municipio2 = '$municipio2', "
                . "datahoraregistro = '$datahoraregistro' "
                . "where idmedico = '$idmedico'";
            mysqli_query($conn, $sql) or die(mysqli_error($conn));
        }   
        if ($uf3 == "[--SELECIONE--]"){
            $sql = "update medico set municipio3 = null, "
                . "datahoraregistro = '$datahoraregistro' "
                . "where idmedico = '$idmedico'";
            mysqli_query($conn, $sql) or die(mysqli_error($conn));
        }else{
            $sql = "update medico set municipio3 = '$municipio3', "
                . "datahoraregistro = '$datahoraregistro' "
                . "where idmedico = '$idmedico'";
            mysqli_query($conn, $sql) or die(mysqli_error($conn));
        }
        $_SESSION['msg'] = "<p class='bg-success text-light text-center p-2 rounded font-weight-bold'>Dados cadastrados com sucesso!</p>";
    }
    
    echo "<META HTTP-EQUIV='REFRESH' CONTENT=\"0;
            URL='cadBolsista.php'\">";
     
}
?>
        
    <script type="text/javascript">
    $(document).ready(function(){
        $('#uf').change(function(){
            $('#municipio').load('listaMunicipios.php?uf='+$('#uf').val());
        });
    });
    $(document).ready(function(){
        $('#uf2').change(function(){
            $('#municipio2').load('listaMunicipios2.php?uf2='+$('#uf2').val());
        });
    });
    $(document).ready(function(){
        $('#uf3').change(function(){
            $('#municipio3').load('listaMunicipios3.php?uf3='+$('#uf3').val());
        });
    });
    </script>
    </body>
</html>
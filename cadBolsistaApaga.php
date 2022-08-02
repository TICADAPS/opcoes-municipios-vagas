<?php
session_start();
if (!isset($_SESSION['msg'])) {
    $_SESSION['msg'] = "";
}
require_once ("conexao.php");
$_SESSION['msg'] = '<p class="bg-warning text-center p-2 rounded">Dados apagados.</p>';
$idmedico = $_POST['idmedico'];

// DEFINE O FUSO HORARIO COMO O HORARIO DE BRASILIA
date_default_timezone_set('America/Sao_Paulo');
$datahoraregistro = date('Y/m/d H:i:s', time());

$sql = "update medico set municipio1 = null, municipio2 = null, municipio3 = null,"
    . "datahoraregistro = null where idmedico = '$idmedico'";
mysqli_query($conn, $sql) or die(mysqli_error($conn));
echo "<META HTTP-EQUIV='REFRESH' CONTENT=\"0;
        URL='cadBolsista.php'\">";
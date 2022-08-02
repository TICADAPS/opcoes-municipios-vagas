<?php
session_start();
require_once ("conexao.php");
 
$iduf3 = $_GET['uf3'];
 
$rs3 = mysqli_query($conn, "SELECT * FROM municipio WHERE iduf = '$iduf3' and vagas > 0 ORDER BY municipio.municipio");
while($reg3 = mysqli_fetch_object($rs3)){
    $idmunicipio3 = $reg3->idmunicipio;
    $nomemunicipio3 = ucwords($reg3->municipio);
    $vagas3 = $reg3->vagas;
    echo "<option value='$idmunicipio3'>$nomemunicipio3  - $vagas3 vagas.</option>";
}

?>
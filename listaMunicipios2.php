<?php
session_start();
require_once ("conexao.php");
 
$iduf2 = $_GET['uf2'];
 
$rs2 = mysqli_query($conn, "SELECT * FROM municipio WHERE iduf = '$iduf2' and vagas > 0 ORDER BY municipio.municipio");
while($reg2 = mysqli_fetch_object($rs2)){
    $idmunicipio2 = $reg2->idmunicipio;
    $nomemunicipio2 = ucwords($reg2->municipio);
    $vagas2 = $reg2->vagas;
    echo "<option value='$idmunicipio2'>$nomemunicipio2 - $vagas2 vagas.</option>";
}

?>
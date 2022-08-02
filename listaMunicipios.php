<?php
session_start();
require_once ("conexao.php");
 
$iduf = $_GET['uf'];
 
$rs = mysqli_query($conn, "SELECT * FROM municipio WHERE iduf = '$iduf' and vagas > 0 ORDER BY municipio.municipio");
while($reg = mysqli_fetch_object($rs)){
    $idmunicipio = $reg->idmunicipio;
    $nomemunicipio = ucwords($reg->municipio);
    $vagas = $reg->vagas;
    echo "<option value='$idmunicipio'>$nomemunicipio - $vagas vagas.</option>";
}

?>
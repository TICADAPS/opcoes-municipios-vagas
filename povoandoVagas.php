<?php
require_once ("conexao.php");

$nrvagas = 1500;
$aux =5;
//$sql = "update municipio set vagas = null";
//mysqli_query($conn, $sql) or die(mysqli_error($conn));
$min=11;
$max = 52;

while($nrvagas > 0){
    $nrvagarand = rand(1,20);
    $nrid = rand($min,$max);
    $sql = "update municipio set vagas = '$nrvagarand' where municipio.iduf = '$nrid'";
    mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $nrvagas -= $nrvagarand;
    if($aux == 2 || $aux == 4)
        $min += 3;
    $aux--;
    if($aux < 1)
        $aux = 5;
}
echo "Acabou!";
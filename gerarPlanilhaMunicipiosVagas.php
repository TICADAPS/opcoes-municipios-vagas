<?php
session_start();
require_once ("conexao.php");

?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <title>Planilha</title>
        
    </head>
    <body>
<?php
    // nome do arquivo que será exportado
    $arquivo = 'vagaspormunicipios.xlsx';
        
    // criando uma tabela HTML com o formato da planilha
    $html = '';
    $html .= '<table border="1">';
    $html .= '<tr>';
    $html .= '<th colspan="4">Relatório dos Municípios por Estado e Respectivas Vagas Oferecidas para Bolsistas</th>';
    $html .= '</tr>';
    $html .= '<tr>';
    $html .= '<td><b>Estado (UF)</b></td>';
    $html .= '<td><b>Município</b></td>';
    $html .= '<td><b>IBGE</b></td>';
    $html .= '<td><b>Nr. Vagas</b></td>';
    $html .= '</tr>';
       
    // trazendo os dados do bd
    $sql = "select m.municipio, m.idmunicipio, e.uf, e.nomeestado, m.vagas from municipio m INNER JOIN estado e on m.iduf = e.iduf 
    where vagas > 0 order by e.uf";
    $smtm = mysqli_query($conn, $sql) or die(mysqli_errno($conn));
    while ($row_query = mysqli_fetch_assoc($smtm)) {
        $nomeestado = ucwords($row_query['nomeestado']);
        $uf = $row_query['uf'];
        $nomemunicipio = ucwords($row_query['municipio']);
        $idmunicipio = ucwords($row_query['idmunicipio']);
        $vagas = $row_query['vagas'];

    $html .= '<tr>';
        $html .= '<td>'.$nomeestado.'('.$uf.')</td>';
        $html .= '<td>'.$nomemunicipio.'</td>';
        $html .= '<td>'.$idmunicipio.'</td>';
        if($vagas == 1) {
            $html .= '<td>'.$vagas.' vaga.</td>';
        }else{
            $html .= '<td>'.$vagas.' vagas.</td>';
        }
        
        $html .= '</tr>';
    }
    $html .= '</table>';

    // configurações header para forçar o download
    header("Expires: Mon, 30 Out 2099 10:00:00 GMT");
    header("Last-Modified: ". gmdate("D,d M YH:i:s")." GMT");
    header("Cache-Control: no-cache, must-revalidate");
    header("Pragma: no-cache");
    header("Content-type: application/x-msexcel");
    header("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
    header("Content-Description: PHP Generated Data" );
      
    // envia o conteúdo do arquivo
    echo $html;
    exit;
?>
    </body>
</html>
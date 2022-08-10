<?php
session_start();
require_once ("conexao.php");
require_once ("./Controller/fdatas.php");
if (!isset($_SESSION['msg'])) {
    $_SESSION['msg'] = "";
}
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
    $arquivo = 'medicosopcoesvagas.xlsx';
        
    // criando uma tabela HTML com o formato da planilha
    $html = '';
    $html .= '<table border="1">';
    $html .= '<tr>';
    $html .= '<th colspan="9">Relatório dos Médicos Bolsistas e suas Respectivas Escolhas</th>';
    $html .= '</tr>';
    $html .= '<tr>';
    $html .= '<td><b>Bolsista</b></td>';
    $html .= '<td><b>CPF</b></td>';
    $html .= '<td><b>1ª Opção</b></td>';
    $html .= '<td><b>IBGE-1</b></td>';
    $html .= '<td><b>2ª Opção</b></td>';
    $html .= '<td><b>IBGE-2</b></td>';
    $html .= '<td><b>3ª Opção</b></td>';
    $html .= '<td><b>IBGE-3</b></td>';
    $html .= '<td><b>Data/Hora do Registro</b></td>';
    $html .= '</tr>';
       
    // trazendo os dados do bd
    $sql = "select medico.idmedico, medico.nomemedico, medico.cpf, medico.cargo, m1.municipio as municipio1, e1.uf as uf1, 
    m1.idmunicipio as ibge1, m2.idmunicipio as ibge2, m3.idmunicipio as ibge3, m1.vagas as vagas1, m2.vagas as vagas2, m3.vagas as vagas3,
    m2.municipio as municipio2, e2.uf as uf2, m3.municipio as municipio3, e3.uf as uf3, medico.datahoraregistro
    from medico inner join municipio m1 on m1.idmunicipio = medico.municipio1 INNER JOIN estado e1 on m1.iduf = e1.iduf 
    left join municipio m2 on m2.idmunicipio = medico.municipio2 left JOIN estado e2 on m2.iduf = e2.iduf 
    left join municipio m3 on m3.idmunicipio = medico.municipio3 left JOIN estado e3 on m3.iduf = e3.iduf order by medico.nomemedico";
    $smtm = mysqli_query($conn, $sql) or die(mysqli_errno($conn));
    $nrrows = mysqli_num_rows($smtm);
    while ($row_query = mysqli_fetch_assoc($smtm)) {
        $idmedico = $row_query['idmedico'];
        $nomemedico = $row_query['nomemedico'];
        $cpf = $row_query['cpf'];
        $cargo = $row_query['cargo'];
        $nomemunicipio1 = ucwords($row_query['municipio1']);
        $nomemunicipio2 = ucwords($row_query['municipio2']);
        $nomemunicipio3 = ucwords($row_query['municipio3']);
        $ibge1 = $row_query['ibge1'];
        $ibge2 = $row_query['ibge2'];
        $ibge3 = $row_query['ibge3'];
        $uf1 = $row_query['uf1'];
        $uf2 = $row_query['uf2'];
        $uf3 = $row_query['uf3'];
        $vagas1 = $row_query['vagas1'];
        $vagas2 = $row_query['vagas2'];
        $vagas3 = $row_query['vagas3'];
        $datahoraregistro = vemdata($row_query['datahoraregistro']) . " " . horaEmin($row_query['datahoraregistro']);

    $html .= '<tr>';
        $html .= '<td>'.$nomemedico.'</td>';
        $html .= '<td>'.$cpf.'</td>';
        if($nomemunicipio1 != null){
            $html .= '<td>'.$nomemunicipio1.'-'.$uf1.' - '.$vagas1.' vaga(s).</td>';
            $html .= '<td>'.$ibge1.'</td>';
        }else{
            $html .= '<td></td>';
            $html .= '<td></td>';
        }
        if($nomemunicipio2 != null){
            $html .= '<td>'.$nomemunicipio2.'-'.$uf2.' - '.$vagas2.' vaga(s).</td>';
            $html .= '<td>'.$ibge2.'</td>';
        }else{
            $html .= '<td></td>';
            $html .= '<td></td>';
        }
        if($nomemunicipio3 != null){
            $html .= '<td>'.$nomemunicipio3.'-'.$uf3.' - '.$vagas3.' vaga(s).</td>';
            $html .= '<td>'.$ibge3.'</td>';
        }else{
            $html .= '<td></td>';
            $html .= '<td></td>';
        }
        $html .= '<td>'.$datahoraregistro.'</td>';
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
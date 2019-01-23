<?php
    //Abrir conexão
    require "../_conexao/abrir_conexao.inc.php";
    
    //Iniciar sessão
    session_start();
    
    if(!isset($_SESSION["user_portal"])){
        header("location:login.php");
    } else {
        $user = $_SESSION["user_portal"];
    }

    //Realizar consulta
    $consulta_empresas  = "SELECT DISTINCT nome_empresa FROM empresas, empresas_participantes ";
    $consulta_empresas .= "WHERE participante = '{$user}' AND id_empresa = empresa";

    $empresas = mysqli_query($conecta, $consulta_empresas);
    
    //Verificando o número de registros
    $num_registros = mysqli_num_rows($empresas);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title> Consulta Empresas </title>
    <link href="../_css/consulta_empresa.css" rel="stylesheet">
</head>

<!-- Navbar -->
<?php
    require "navbar.html";
?>
    
<body>
    <!-- Criando tabela de empresas -->
    <h1> Consultar Empresas </h1>
    <?php
        if($num_registros > 0){
            echo "<table>
                <tr>
                    <th> Empresa </th>
                </tr>";
            
            while($registro = mysqli_fetch_assoc($empresas)){
                echo '<tr>';
                    echo '<td>'.utf8_encode($registro["nome_empresa"]).'</td>';
                echo '</tr>';
            }

            echo "</table>";
            echo "<br> <br>";
            
        } else {
            ?> <h6> Não há empresas cadastradas! </h6> <?php
        }
    ?>
    
    <button class="btn-success" onclick="javascript: location.href='cadastro_empresa.php'"> Inserir </button>
    <button class="btn-danger" onclick="javascript:location.href=''"> Excluir </button>
    
</body>    
</html>

<?php
    require "../_conexao/fechar_conexao.inc.php";
?>


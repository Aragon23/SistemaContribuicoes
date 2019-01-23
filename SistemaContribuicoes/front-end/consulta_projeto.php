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
    $consulta_projetos  = "SELECT nome_projeto, nome_empresa FROM projetos, empresas, projetos_participantes WHERE id_projeto = projeto AND id_empresa = empresa AND participante = '{$user}'";
    $projetos = mysqli_query($conecta, $consulta_projetos);
    
    //Verificar o número de registos
    $num_registros  = mysqli_num_rows($projetos);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title> Consulta Projetos </title>
    <link href="../_css/consulta_projeto.css" rel="stylesheet">
</head>
    
<body>
    
    <!-- Navbar -->
    <?php
        require "navbar.html";
    ?>
    
    <!-- Criando tabela de projetos -->
    <h1> Consultar Projetos </h1>
    <?php
        if($num_registros > 0){
            echo "<table>
                <tr>
                    <th> Empresa </th>
                    <th> Projeto </th>
                </tr>";

            while($registro = mysqli_fetch_assoc($projetos)){
                echo '<tr>';
                    echo '<td>'.utf8_encode($registro["nome_empresa"]).'</td>';
                    echo '<td>'.utf8_encode($registro["nome_projeto"]).'</td>';
                echo '</tr>';
            }

            echo "</table>";
            echo "<br><br>";
        } else {
            ?><p> Não há projetos cadastrados! </p> <br> <br>; <?php
        }
    ?>
    
    <button class="btn-info" onclick="javascript: location.href='cadastro_pr_participantes.php'">Inserir Participantes</button>
    <button class="btn-success" onclick="javascript: location.href='cadastro_projeto.php'"> Inserir Projetos</button>
    <button class="btn-danger"> Excluir </button>
    
</body>    
</html>

<?php
    require "../_conexao/fechar_conexao.inc.php";
?>


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
    $consulta_contribuicoes = "SELECT DISTINCT nome_contribuicao, nome_focodeanalise, nome_projeto, nome_empresa, nome_participante FROM contribuicoes, empresas, empresas_participantes, focosdeanalise, participantes, projetos WHERE participante_contribuicao = id_participante AND participante_contribuicao = '{$user}' AND empresa_contribuicao = id_empresa AND projeto_contribuicao = id_projeto AND focodeanalise_contribuicao = id_focodeanalise ";
    
    $contribuicoes = mysqli_query($conecta, $consulta_contribuicoes);

    //Verificar o número de registos
    $num_registros  = mysqli_num_rows($contribuicoes);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title> Consulta Contribuições </title>
    <link href="../_css/consulta_contribuicao.css" rel="stylesheet">
</head>
    
<body>
    
    <!-- Navbar -->
    <?php
        require "navbar.html";
    ?>
    
    <!-- Criando tabela de projetos -->
    <h1> Consultar Contribuições </h1>
    <?php
        if($num_registros > 0){
            echo "<table>
                <tr>
                    <th> Participante </th>
                    <th> Empresa </th>
                    <th> Projeto </th>
                    <th> Foco de Análise </th>
                    <th> Contribuição </th> 
                </tr>";

            while($registro = mysqli_fetch_assoc($contribuicoes)){
                echo '<tr>';
                    echo '<td>'.utf8_encode($registro["nome_participante"]).'</td>';
                    echo '<td>'.utf8_encode($registro["nome_empresa"]).'</td>';
                    echo '<td>'.utf8_encode($registro["nome_projeto"]).'</td>';
                    echo '<td>'.utf8_encode($registro["nome_focodeanalise"]).'</td>';
                    echo '<td>'.utf8_encode($registro["nome_contribuicao"]).'</td>';
                echo '</tr>';
            }

            echo "</table>";
            echo "<br><br>";
        } else {
            ?><p> Não há contribuições cadastradas! </p> <br><br> ; <?php
        }
    ?>
    
    <button class="btn-success" onclick="javascript: location.href='cadastro_contribuicao.php'"> Inserir </button>
    <button class="btn-danger"> Excluir </button>
    
</body>    
</html>

<?php
    require "../_conexao/fechar_conexao.inc.php";
?>


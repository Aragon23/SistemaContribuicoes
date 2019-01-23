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
    
    //Receber dados
    if(isset($_POST["pesquisar"])){
        $foco = utf8_decode($_POST["foco"]);
        
        //Realizar consulta
        $consulta_focos  = "SELECT DISTINCT nome_focodeanalise, id_focodeanalise, projeto_focodeanalise, id_projeto, nome_projeto, empresa_projeto, id_empresa, nome_empresa FROM focosdeanalise, projetos, empresas WHERE id_projeto = projeto_focodeanalise AND nome_focodeanalise = '{$foco}' AND empresa_projeto = id_empresa";
        $focos = mysqli_query($conecta, $consulta_focos);

        //Verificar o número de registos
        $num_registros  = mysqli_num_rows($focos);
        
    }

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title> Consulta Projetos </title>
    <link href="../_css/consulta_foco.css" rel="stylesheet">
</head>
    
<body>
    
    <!-- Navbar -->
    <?php
        require "navbar.html";
    ?>
    
    <h1> Consultar Focos de Análise </h1>
    
    <!-- Criando tela de pesquisa -->
    <form action="" method="post">
        <fieldset>
            <legend> Pesquisar Foco de análise </legend>
            
            <label class="alinha"> Foco de análise: </label>
            <input type="text" name="foco" required> <br> <br>
            
            <button type="submit" name="pesquisar" class="pesquisar"> Pesquisar </button>
        </fieldset>
    </form>
    
    <!-- Criando tabela de focos -->
    
    <?php
        if(isset($_POST["pesquisar"])){
            if($num_registros > 0){
                echo "<table>
                    <tr>
                        <th> Empresa </th>
                        <th> Projeto </th>
                        <th> Foco de Análise </th>
                    </tr>";

                while($registro = mysqli_fetch_assoc($focos)){
                    echo '<tr>';
                        echo '<td>'.utf8_encode($registro["nome_empresa"]).'</td>';
                        echo '<td>'.utf8_encode($registro["nome_projeto"]).'</td>';
                        echo '<td>'.utf8_encode($registro["nome_focodeanalise"]).'</td>';
                    echo '</tr>';
                }

                echo "</table>";
                echo "<br><br>";
            } else {
                ?><p> Não há focos de análise cadastrados! </p> <br> ; <?php
            }
        }
    ?>
    
    <button class="btn-success" onclick="javascript: location.href='cadastro_foco.php'"> Inserir </button>
    <button class="btn-danger"> Excluir </button>
    
</body>    
</html>

<?php
    require "../_conexao/fechar_conexao.inc.php";
?>


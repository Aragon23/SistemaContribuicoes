<?php
    //Abrir conexão
    require "../_conexao/abrir_conexao.inc.php";

    //iniciar sessão
    session_start();

    if (!isset($_SESSION["user_portal"])){
        header("location:login.php");
    } else {
        $user = $_SESSION["user_portal"];
    }

    //Inserção no banco
    if(isset($_POST["empresa"])){
        $empresa = utf8_decode($_POST["empresa"]);
        
        //Condição para verificar se a empresa já foi cadastrada pelo participante
        $consulta = mysqli_query($conecta,"SELECT * FROM empresas_participantes WHERE participante = '{$user}' AND empresa = '{$empresa}'");
        $registro = mysqli_num_rows($consulta);
        
        if ($registro == 0){
            //Inserir na tabela empresas
            $inserir_empresa = "INSERT INTO empresas(nome_empresa) VALUES ('{$empresa}')";
            $op_inserir_empresa = mysqli_query($conecta, $inserir_empresa);

            //Buscar ID da empresa pelo nome
            $sql_empresa = mysqli_query($conecta, "SELECT id_empresa FROM empresas WHERE nome_empresa = '{$empresa}'");
            $row_empresa = mysqli_fetch_array($sql_empresa);
            $id_empresa = $row_empresa["id_empresa"];

            //Inserir na tabela empresas_participantes
            $inserir_empresas_participantes = "INSERT INTO empresas_participantes(empresa, participante) VALUES ('{$id_empresa}', '{$user}') ";
            $op_inserir_empresas_participantes = mysqli_query($conecta, $inserir_empresas_participantes);

            //Validar a operação
            if(!$op_inserir_empresas_participantes){
                die("Erro no banco de dados");
            } else {
                ?> <script> alert("Cadastro efetuado com sucesso!"); </script> <?php
            }
        } else {
            die("Empresa já cadatrada pelo usuário!");
        }
        
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=devide-width, initial-scale=1">
    <link href="../_css/cadastro_empresa.css" rel="stylesheet">
    <title> Cadastro de empresa </title>
</head>

<body>

<!-- Navbar -->
<?php
    include "navbar.html";
?>
 
    <form action="" method="post">
        <fieldset>
            <legend> Cadastro de Empresa </legend>
            <label class="alinha"> Nome Empresa: </label>
            <input type="text" name="empresa"> <br>
            
            <button class="cadastro" name="cadastrar_empresa">Cadastrar Empresa</button>
        </fieldset>
        
        
    </form>
</body>
</html>

<?php
    //Fechar conexão
    require "../_conexao/fechar_conexao.inc.php";
?>

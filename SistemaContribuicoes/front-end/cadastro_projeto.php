<?php
    //Abrir conexão
    require "../_conexao/abrir_conexao.inc.php";

    //iniciar sessão
    session_start();

    if(!isset($_SESSION["user_portal"])){
        header("location:login.php");
    } else {
        $user = $_SESSION["user_portal"];
    }

    //Combo-box Empresas
    $select  = "SELECT empresa, nome_empresa ";
    $select .= "FROM  empresas, empresas_participantes ";
    $select .= "WHERE id_empresa = empresa AND participante = {$user}";

    $lista_empresas = mysqli_query($conecta, $select);

    //Inserção no banco
    if(isset($_POST["projeto"])){
        //Recebendo as variáveis
        $projeto = utf8_decode($_POST["projeto"]);
        $empresa = utf8_decode($_POST["empresa"]);
        
        //Inserindo na tabela projetos
        $inserir_projeto  = "INSERT INTO projetos ";
        $inserir_projeto .= "(nome_projeto) ";
        $inserir_projeto .= "VALUES ('$projeto')";
        
        $op_inserir_projeto = mysqli_query($conecta, $inserir_projeto);
        
        //Buscando o ID do projeto
        $sql_projeto = mysqli_query($conecta, "SELECT id_projeto FROM projetos WHERE nome_projeto = '{$projeto}'");
        $row_projeto = mysqli_fetch_array($sql_projeto);
        $id_projeto = $row_projeto["id_projeto"];
        
        //Inserindo na tabela projetos_participantes
        $inserir_pr_participantes  = "INSERT INTO projetos_participantes ";
        $inserir_pr_participantes .= "(participante, projeto, empresa) ";
        $inserir_pr_participantes .= "VALUES ('$user', '$id_projeto', '$empresa')";
        
        $op_inserir_pr_participantes = mysqli_query($conecta, $inserir_pr_participantes);
        
        //Inserindo focos de análise iniciais dos projetos
        $inserir_focos  = "INSERT INTO focosdeanalise ";
        $inserir_focos .= "(nome_focodeanalise, projeto_focodeanalise) ";
        $inserir_focos .= "VALUES ('Mao de Obra', $id_projeto), ('Material', $id_projeto), ('Maquina', $id_projeto), 
        ('Metodo', '$id_projeto'), ('Meio Ambiente', $id_projeto), ('Medida', $id_projeto)";
        
        $op_inserir_focos = mysqli_query($conecta, $inserir_focos);
        
        //Validando a operação
        if(!$op_inserir_focos){
            die("Erro no banco de dados");
        } else {
            ?> <script> alert("Projeto cadastrado com sucesso!"); </script> <?php
        }
        
    }

?>

<!DOCTYPE html>
<html lang="pt-BR">
    <head> 
        <meta charset="utf-8">
        <title> Cadastro de Projetos </title>
        <link href="../_css/cadastro_projeto.css" rel="stylesheet">
    </head>
</html>

<body>

<!-- Navbar -->
<?php
    include "navbar.html"
?>
    
    <form action="" method="post">
        <fieldset>
            <legend> Inserir dados do projeto </legend>
            
            <label class="alinha"> Nome do projeto: </label>
            <input type="text" name="projeto" required> <br>
            
            <label class="alinha"> Empresa: </label>
            <select name="empresa">
                <?php
                    while($linha = mysqli_fetch_assoc($lista_empresas)){
                ?>
                    <option value="<?php echo utf8_encode($linha["empresa"]);   ?>"> 
                        <?php echo utf8_encode($linha["nome_empresa"]);   ?>
                    </option>
                <?php
                    }
                ?>
            </select> <br>
        
            <button class="cadastro" name="cadastrar_projeto">Cadastrar</button>
        
        </fieldset>
    </form>
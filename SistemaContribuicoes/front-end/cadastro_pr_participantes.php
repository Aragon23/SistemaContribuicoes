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
    if(isset($_POST["participante"])){
        //Recebendo as variáveis
        $participante = utf8_decode($_POST["participante"]);
        $id_projeto = utf8_decode($_POST["projeto"]);
        
        //Buscar ID do participante
        $sql_participante = mysqli_query($conecta, "SELECT id_participante FROM participantes WHERE username_participante = '{$participante}'");
        $row_participante = mysqli_fetch_array($sql_participante);
        $id_participante = $row_participante["id_participante"];
        
        //Inserindo na tabela projetos_participantes
        $inserir_projeto  = "INSERT INTO projetos_participantes ";
        $inserir_projeto .= "(participante, projeto) ";
        $inserir_projeto .= "VALUES ('$id_participante', '$id_projeto')";
        
        $op_inserir_projeto = mysqli_query($conecta, $inserir_projeto);
        
        //Validando a operação
        if(!$op_inserir_projeto){
            die(utf8_decode("Usuário não cadastrado no banco de dados"));
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
        <link href="../_css/cadastro_pr_participantes.css" rel="stylesheet">
    </head>

<body>

<!-- Navbar -->
<?php
    include "navbar.html"
?>
    
    <form action="" method="post">
        <fieldset>
            <legend> Incluir participante </legend>
            
            <label class="alinha"> Empresa: </label>
            <select name="empresa" id="empresa" required>
            </select> <br>
            
            <label class="alinha"> Projeto: </label>
            <select name="projeto" id="projeto" required></select> <br>
                
            <label class="alinha"> Usuário: </label>
            <input type="text" name="participante" id="participante" required>
    
            <button class="cadastro" name="cadastrar_projeto">Cadastrar</button>
        
        </fieldset>
    </form>
    
</body>
</html>

<!-- Lista aninhada -->
<script src="../js/jquery.js"></script>
    <script>
        function retornarEmpresas(data){
            var empresas = "";
            $.each(data, function(chave, valor){
                empresas += '<option value="' + valor.empresa + '">' + valor.nome_empresa + '</option>';
            });
            $('#empresa').html(empresas);
        }
            
        $('#empresa').change(function(e){
            var empresa = $(this).val();
            $.ajax({
                type:"GET",
                data:"empresa=" + empresa,
                url: "http://localhost/SistemaContribuicoes/front-end/retornar_projetos.php",
                assync: false
            }).done(function(data){
                var projetos = "";
                $.each($.parseJSON(data), function(chave, valor){
                    projetos += '<option value="' + valor.id_projeto + '">' + valor.nome_projeto + '</option>';
                });
                $('#projeto').html(projetos);
            })     
        });
            
    </script>
    
    <script src="http://localhost/SistemaContribuicoes/front-end/retornar_empresas.php?callback=retornarEmpresas"></script>
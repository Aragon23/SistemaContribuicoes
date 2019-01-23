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
    
    //Buscar o ID da 1° empresa cadastrada pelo usuário
    $sql_empresa = mysqli_query($conecta, "SELECT id_participante, id_empresa FROM empresas, participantes WHERE id_participante = '{$user}' LIMIT 1");
    $row_empresa = mysqli_fetch_array($sql_empresa);
    $id_empresa = $row_empresa["id_participante"];

    //Combo-box projetos
    $consulta_projetos = "SELECT id_projeto, nome_projeto FROM projetos_participantes, empresas WHERE empresa = id_empresa AND empresa = '{$id_empresa}'";
    $lista_projetos = mysqli_query($conecta, $consulta_projetos);

    //Inserção no banco de dados
    if(isset($_POST["focodeanalise"])){
        $projeto = utf8_decode($_POST["projeto"]);
        $focodeanalise = utf8_decode($_POST["focodeanalise"]);
        
        //Inserindo na tabela focos
        $inserir_focos = "INSERT INTO focosdeanalise(nome_focodeanalise, projeto_focodeanalise) VALUES ('{$focodeanalise}', '{$projeto}')";
        $op_inserir_focos = mysqli_query($conecta, $inserir_focos);
        
        //Validar a operação
        if(!$op_inserir_focos){
            die("Erro no banco de dados");
        } else {
            ?> <script> alert("Cadastro efetuado com sucesso!"); </script> <?php
        }
    }

?>

<!DOCTYPE html>
<html lang="pt-BR">
    <head> 
        <meta charset="utf-8">
        <title> Cadastro de Projetos </title>
        <link href="../_css/cadastro_focodeanalise.css" rel="stylesheet">
    </head>

<body>

<!-- Navbar -->
<?php
    include "navbar.html"
?>
    
    <form action="" method="post">
        <fieldset>
            <legend> Inserir foco de análise </legend>
            
            <label class="alinha"> Empresa: </label>
            <select name="empresa" id="empresa" required></select> <br>
            
            <label class="alinha"> Projeto: </label>
            <select name="projeto" id="projeto" required>
            <?php
                while($linha = mysqli_fetch_assoc($lista_projetos)){
            ?>
                    <option value="<?php echo utf8_encode($linha["id_projeto"]);   ?>"> 
                        <?php echo utf8_encode($linha["nome_projeto"]);   ?>
                    </option>
            <?php
                }
            ?>
            </select> <br>
            
            <label class="alinha"> Foco de Análise: </label>
            <input type="text" name="focodeanalise" id="focodeanalise" required>
        
            <button class="cadastro" name="cadastrar_projeto">Cadastrar</button>
        
        </fieldset>
    </form>
    
</body>
</html>

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
    
<?php
    require "../_conexao/fechar_conexao.inc.php";
?>

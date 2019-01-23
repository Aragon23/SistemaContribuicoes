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
    $consulta_projetos = "SELECT id_projeto, nome_projeto FROM projetos, empresas WHERE empresa_projeto = id_empresa AND empresa_projeto = '{$id_empresa}'";
    $lista_projetos = mysqli_query($conecta, $consulta_projetos);

    //Buscar o ID do primeiro projeto cadastrado pelo usuário
    $sql_projeto = mysqli_query($conecta, "SELECT id_projeto, nome_projeto FROM projetos, empresas WHERE empresa_projeto = id_empresa AND empresa_projeto = '{$id_empresa}' LIMIT 1");
    $row_projeto = mysqli_fetch_array($sql_projeto);
    $id_projeto = $row_projeto["id_projeto"];

    //Combo-box focos
    $consulta_focos = "SELECT id_focodeanalise, nome_focodeanalise FROM focosdeanalise, projetos WHERE projeto_focodeanalise = id_projeto AND projeto_focodeanalise = '{$id_projeto}' LIMIT 1";
    $lista_focos = mysqli_query($conecta, $consulta_focos);

    //Inserção no banco de dados
    if(isset($_POST["focodeanalise"])){
        $empresa = utf8_decode($_POST["empresa"]);
        $projeto = utf8_decode($_POST["projeto"]);
        $focodeanalise = utf8_decode($_POST["focodeanalise"]);
        $contribuicao = utf8_decode($_POST["contribuicao"]);

        $inserir_contribuicoes  = "INSERT INTO contribuicoes(nome_contribuicao, participante_contribuicao, empresa_contribuicao, projeto_contribuicao, focodeanalise_contribuicao) ";
        $inserir_contribuicoes .= "VALUES ('{$contribuicao}', '{$user}', '{$empresa}', '{$projeto}',
        '{$focodeanalise}')";
        
        $op_inserir_contribuicoes = mysqli_query($conecta, $inserir_contribuicoes);
    
        if(!$inserir_contribuicoes){
            die("Erro no banco de dados");
        } else {
            ?> <script> alert("Contribuição realizada com sucesso!") </script> <?php
        }
        
    }

?>

<!DOCTYPE html>
<html lang="pt-BR">
    <head> 
        <meta charset="utf-8">
        <title> Cadastro de Projetos </title>
        <link href="../_css/cadastro_contribuicao.css" rel="stylesheet">
    </head>

<body>

<!-- Navbar -->
<?php
    include "navbar.html"
?>

    <!--Formulário -->
    <form action="" method="post">
        <fieldset>
            <legend> Inserir Contribuição </legend>
            
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
            
            <label class="alinha",> Foco de Análise: </label>
            <select name="focodeanalise" id="focodeanalise" required>
            <?php
                while($linha = mysqli_fetch_assoc($lista_focos)){
            ?>
                    <option value="<?php echo utf8_encode($linha["id_focodeanalise"]);   ?>"> 
                        <?php echo utf8_encode($linha["nome_focodeanalise"]);   ?>
                    </option>
            <?php
                }
            ?>
            </select> <br>
            
            <label class="contribuicao"> Contribuição: </label>
            <textarea name="contribuicao" size=255 maxlength=255 required></textarea><br>
        
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
            
            $('#projeto').change(function(e){
                var projeto = $(this).val();
                $.ajax({
                    type:"GET",
                    data:"projeto=" + projeto,
                    url:"http://localhost/SistemaContribuicoes/front-end/retornar_focos.php",
                    assync: false
                }).done(function(data){
                    var focos = "";
                    $.each($.parseJSON(data), function(chave, valor){
                        focos += '<option value="' + valor.id_focodeanalise + '">' + valor.nome_focodeanalise + '</option>';
                    });
                    $('#focodeanalise').html(focos);
                })
            });
            
        </script>
        <script src="http://localhost/SistemaContribuicoes/front-end/retornar_empresas.php?callback=retornarEmpresas"></script>
    
<?php
    require "../_conexao/fechar_conexao.inc.php";
?>

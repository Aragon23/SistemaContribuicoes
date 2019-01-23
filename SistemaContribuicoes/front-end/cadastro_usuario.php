<?php
    //Abrir conexão
    require "../_conexao/abrir_conexao.inc.php";

    //Inserção no banco
    if(isset($_POST["usuario"])){
        $nome = utf8_decode($_POST["nome"]);
        $empresa = utf8_decode($_POST["empresa"]);
        $usuario = utf8_decode($_POST["usuario"]);
        $senha = utf8_decode($_POST["senha"]);
        
        //Condição para verificar se usuário já existe
        $consulta = mysqli_query($conecta,"SELECT COUNT(*) FROM participantes WHERE username_participante = '{$usuario}'");
        $registro = mysqli_num_rows($consulta);
        
        //Verificando se o usuário já existe
        if($registro == 0){
            
            //Inserindo empresa
            $inserir_empresa = "INSERT INTO empresas(nome_empresa) VALUES ('$empresa')";

            $op_inserir_empresa = mysqli_query($conecta, $inserir_empresa);
        
            //Buscando o ID da empresa pelo nome
            $sql_empresa = mysqli_query($conecta, "SELECT id_empresa FROM empresas WHERE nome_empresa = ('$empresa')");
            $row_empresa = mysqli_fetch_array($sql_empresa);
            $id_empresa = $row_empresa['id_empresa'];
            
            //Inserindo usuário
            $inserir_usuario  = "INSERT INTO participantes ";
            $inserir_usuario .= "(username_participante, senha_participante, nome_participante, empresa_participante) ";
            $inserir_usuario .= "VALUES ('$usuario', '$senha', '$nome', '$id_empresa')";

            $op_inserir_usuario = mysqli_query($conecta, $inserir_usuario);
            
            //Buscando o ID do usuário pelo nome
            $sql_participante = mysqli_query($conecta, "SELECT id_participante FROM participantes WHERE username_participante = ('$usuario')");
            $row_participante = mysqli_fetch_array($sql_participante);
            $id_participante = $row_participante['id_participante'];

            //Inserir na tabela empresas_participantes
            $inserir_empresas_participantes  = "INSERT INTO empresas_participantes ";
            $inserir_empresas_participantes .= "(participante, empresa) ";
            $inserir_empresas_participantes .= "VALUES ('$id_participante', '$id_empresa')";

            $op_inserir_empresas_participantes = mysqli_query($conecta,$inserir_empresas_participantes);

            //Validando a operação
            if(!$op_inserir_empresas_participantes){
                die("Erro no banco de dados");
            } else {
                ?> <script> alert("Cadastro efetuado com sucesso!"); 
                            window.location="login.php"</script> <?php
            }
            
        } else {
            die("Usuário já cadastrado");
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <title> Cadastro </title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=devide-width, initial-scale=1">
    <link href="../_css/cadastro_usuario.css" rel=stylesheet>
</head>
    
<body>
    
    <h1> Cadastro de usuário </h1>
    
    <form action="" method="post">
        <fieldset>
            <legend> Dados cadastrais </legend>

            <label class="alinha"> Nome: </label>
            <input type="text" name="nome" autofocus> <br>

            <label class="alinha"> Empresa: </label>
            <input type="text" name="empresa"> <br>

            <label class="alinha"> Usuário </label>
            <input type="text" name="usuario"> <br>

            <label class="alinha"> Senha: </label>
            <input type="password" name="senha" required> <br>

            <div class="cadastrar">
                <button type="submit" class="btn btn-success" name="cadastrar"> Cadastrar </button>
            </div>
        </fieldset>
    </form> <br>
    
    <button class="voltar" name="voltar" onclick="javascript: location.href='login.php'">Voltar</button>
    
</body>
</html>

<!-- Fechar conexão -->
<?php
    require "../_conexao/fechar_conexao.inc.php";
?>
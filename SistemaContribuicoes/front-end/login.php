<?php
  require "../_conexao/abrir_conexao.inc.php";

  //iniciar sessão
  session_start();

    //Verificar se as informações foram enviadas
    if(isset($_POST["usuario"])){
      $usuario = $_POST["usuario"];
      $senha = $_POST["senha"];
      
      //login
      $login  = "SELECT * ";
      $login .= "FROM participantes ";
      $login .= "WHERE username_participante = '{$usuario}' and senha_participante = '{$senha}'";
      
      $acesso = mysqli_query($conecta, $login);
      
      if(!$acesso){
          die(utf8_decode("Falha na conexão"));
      }
      
      $informacao = mysqli_fetch_assoc($acesso);
      
      if(empty($informacao)){
          $mensagem = "Login sem sucesso";
          echo $mensagem;
      } else {
          $_SESSION['user_portal'] = $informacao["id_participante"];
          header("location:cadastro_empresa.php");
      }
      
  }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta charset="utf-8">
    <link href="../_css/login.css" rel="stylesheet">
	<title> Login </title>
</head>

<body>
	<h1> Login </h1>
	
	<form action="" method="post">
		<fieldset class="fieldset_login">
			<legend> Credenciais </legend>
			
			<label class="alinha"> Usuário: </label>
			<input type="text" name="usuario" required> <br>
			
			<label class="alinha"> Senha: </label>
			<input type="password" name="senha" required> <br><br>
			
			<button class="btn btn-success" name="login">Login</button>
            
		</fieldset>
	</form>
    
    <button class="cadastro" href="cadastro_usuario.php" onclick="javascript: location.href='cadastro_usuario.php'"> Cadastre-se </button>
    
    
</body>
</html>

<?php
    require "../_conexao/fechar_conexao.inc.php";
?>
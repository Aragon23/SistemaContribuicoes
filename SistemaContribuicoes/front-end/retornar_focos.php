<?php 
    $callback = isset($_GET['callback']) ?  $_GET['callback'] : false;
    $conecta = mysqli_connect("localhost","root","","contribuicoes");

    //iniciar sessão
    session_start();

    if(!isset($_SESSION["user_portal"])){
        header("location:login.php");
    } else {
        $user = $_SESSION["user_portal"];
    }

     if(isset($_GET['projeto'])) {
        $projeto = $_GET['projeto'];
    } else {
        $projeto = "";
    }

    $selecao = "SELECT DISTINCT nome_focodeanalise, id_focodeanalise, id_projeto FROM focosdeanalise, projetos WHERE id_projeto = projeto_focodeanalise AND id_projeto = '{$projeto}'";

    $focosdeanalise = mysqli_query($conecta,$selecao);

    $retorno = array();
    while($linha = mysqli_fetch_object($focosdeanalise)) {
        $retorno[] = $linha;
    } 	

    echo utf8_decode($callback ? $callback . '(' : '') . json_encode($retorno) . ($callback? ')' : '');
    
    // fechar conecta
    mysqli_close($conecta);
?>
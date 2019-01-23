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

    if(isset($_GET['empresa'])) {
        $empresa = $_GET['empresa'];
    } else {
        $empresa = "";
    }

    $selecao = "SELECT DISTINCT nome_projeto FROM projetos, projetos_participantes, empresas WHERE id_projeto = projeto AND id_empresa = empresa AND id_empresa = '{$empresa}' AND participante = '{$user}'";

    $empresas = mysqli_query($conecta,$selecao);

    $retorno = array();
    while($linha = mysqli_fetch_object($empresas)) {
        $retorno[] = $linha;
    } 	

    echo utf8_decode($callback ? $callback . '(' : '') . json_encode($retorno) . ($callback? ')' : '');
    
    // fechar conecta
    mysqli_close($conecta);
?>
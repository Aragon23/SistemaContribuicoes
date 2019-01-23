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

    $selecao  = "SELECT DISTINCT nome_empresa,id_empresa,id_empresa_participante,participante,empresa ";
    $selecao .= "FROM empresas, empresas_participantes WHERE id_empresa = empresa AND participante = '{$user}'";

    $empresas = mysqli_query($conecta,$selecao);

    $retorno = array();
    while($linha = mysqli_fetch_object($empresas)) {
        $retorno[] = $linha;
    } 	

    echo ($callback ? $callback . '(' : '') . json_encode($retorno) . ($callback? ')' : '');
    
    // fechar conecta
    mysqli_close($conecta);
?>
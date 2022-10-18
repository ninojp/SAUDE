<?php
namespace core\classes;

use Exception;

class Store{
    //=================================================================================
    public static function Layout($estruturas, $dados = null){
        //verifica se estruturas é um array
        if(!is_array($estruturas)){
            throw new Exception("coleção de estruturas inválida!");
        }
        //variáveis
        if(!empty($dados) && is_array($dados)){
            extract($dados);
        }

        //apresentar as views da aplicação
        foreach($estruturas as $estrutura){
            include("../core/views/$estrutura.php");
        }
    }

    //=================================================================================
    public static function clienteLogado(){
        //verifica se existe um cliente com sessão(logado)
        return isset($_SESSION['cliente']);

    }
}

/* 
html_header.php
nav_bar.php
inicio.php
html_footer.php
*/
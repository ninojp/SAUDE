<?php

//Abrir a sessão
session_start();

//Carrega todas as classes do projeto, através do autoload do COMPOSER
require_once ('../vendor/autoload.php');
//Carrega o sistema de ROTAS
require_once('../core/rotas.php');







/*=======================================================================================*/
//Adiciona o NAMESPACE da classe Database
// use core\classes\Database;
// $db = new Database();
// $clientes = $db->select("SELECT * FROM clientes");
// echo '<pre>';
// print_r($clientes);

//com o FETCH_CLASS - teria q ser assim
// echo $clientes[2]->nome;
//com o FETCH_ASSOC - teria q ser assim
// echo $clientes[0]['nome'];
//Serve para executar qualquer outra INSTRUÇÃO do sql q não faça parte do CRUD
// $db-> statement("TRUNCATE usuarios");

/* Carregar o config
Carregar classes
    -mostrar loja
    -mostrar carrinho
    -mostarr o backoffice, etc
*/

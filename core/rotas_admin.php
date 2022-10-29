<?php
//Coleção de rotas
$rotas = [
    'inicio'=>'admin@index',
     //rotas de LOGIN
    'admin_login'=>'admin@admin_login',
    'admin_login_submit'=>'admin@admin_login_submit',
    'admin_logout'=>'admin@admin_logout',

    'lista_clientes'=>'admin@lista_clientes',
];

//Define uma ação por default
$acao = 'inicio'; 

//Verifica se existe a ação na query string
if(isset($_GET['a'])){
   //Verifica se a ação existe nas rotas
   if(!key_exists($_GET['a'], $rotas)){
        $acao = 'inicio'; 
   } else {
        $acao = $_GET['a'];
   }
} 

//Trata a definição da rota
$partes = explode('@',$rotas[$acao]);
//a função ucfirst() faz com q a primeira letra, passe a ser Maiúscula
$controlador = 'core\\controllers\\'.ucfirst($partes[0]);
$metodo = $partes[1];

$ctr = new $controlador();
$ctr->$metodo();


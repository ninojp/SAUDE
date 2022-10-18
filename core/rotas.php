<?php
//Coleção de rotas
$rotas = [
    'inicio' => 'main@index',
    'loja' => 'main@loja',
    'novo_cliente' => 'main@novo_cliente',
    'criar_cliente' => 'main@criar_cliente',
    'carrinho' => 'main@carrinho',
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
$controlador = 'core\\controladores\\'.ucfirst($partes[0]);
$metodo = $partes[1];

$ctr = new $controlador();
$ctr->$metodo();

<?php
//Coleção de rotas
$rotas = [
    'inicio' => 'main@index',
    'loja' => 'main@loja',
    //cliente
    'novo_cliente' => 'main@novo_cliente',
    'criar_cliente' => 'main@criar_cliente',
    'confirmar_email' => 'main@confirmar_email',

    //login
    'login' => 'main@login',
    'login_submit' => 'main@login_submit',
    'logout' => 'main@logout',

    //Perfil
    'perfil' => 'main@perfil',
    'alterar_dados_pessoais' => 'main@alterar_dados_pessoais',
    'alterar_dados_pessoais_submit' => 'main@alterar_dados_pessoais_submit',
    'alterar_password' => 'main@alterar_password',
    'alterar_password_submit' => 'main@alterar_password_submit',
    
    //histórico das encomendas
    'historico_encomendas' => 'main@historico_encomendas',
    'detalhe_encomenda' => 'main@historico_encomendas_detalhe',

    //carrinho
    'adicionar_carrinho' => 'carrinho@adicionar_carrinho',
    'remover_produto_carrinho' => 'carrinho@remover_produto_carrinho',
    'limpar_carrinho' => 'carrinho@limpar_carrinho',
    'carrinho' => 'carrinho@carrinho',
    'finalizar_encomenda' => 'carrinho@finalizar_encomenda',
    'finalizar_encomenda_resumo' => 'carrinho@finalizar_encomenda_resumo',
    'endereco_alternativo' => 'carrinho@endereco_alternativo',
    'confirmar_encomenda' => 'carrinho@confirmar_encomenda',
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


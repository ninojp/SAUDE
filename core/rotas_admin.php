<?php
//Coleção de rotas
$rotas = [
    'inicio'=>'admin@index',
     //Admin
    'admin_login'=>'admin@admin_login',
    'admin_login_submit'=>'admin@admin_login_submit',
    'admin_logout'=>'admin@admin_logout',
     
    //Clientes
    'lista_cliente'=>'admin@lista_cliente',
    'detalhe_cliente'=>'admin@detalhe_cliente',
    'cliente_historico_encomenda'=>'admin@cliente_historico_encomenda',
    'lista_encomenda_cliente'=>'admin@lista_encomenda_cliente',

    //Encomendas
    'lista_encomenda'=>'admin@lista_encomenda',
    'detalhe_encomenda'=>'admin@detalhe_encomenda',
    'encomenda_alterar_estado'=>'admin@encomenda_alterar_estado',
    'criar_pdf_encomenda'=>'admin@criar_pdf_encomenda',
    'enviar_pdf_encomenda'=>'admin@enviar_pdf_encomenda',

    //TEMP testes de criação de pdf
    'teste_criar_pdf'=>'admin@teste_criar_pdf'
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


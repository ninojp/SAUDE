<?php
namespace core\controladores;

//indicação do NAMESPACE da minha classe Store
use core\classes\Database;
use core\classes\Store;

class Main{
    //============================================================================
    //Apresenta a pagina da INDEX
    public function index(){
        //minha classe Store com a função Layout()
        Store::Layout([
            'layouts/html_header',
            'layouts/header',
            'inicio',
            'layouts/footer',
            'layouts/html_footer'
        ]);
    }

    //============================================================================
    //Apresenta a pagina da LOJA
    public function loja(){
        Store::Layout([
            'layouts/html_header',
            'layouts/header',
            'loja',
            'layouts/footer',
            'layouts/html_footer'
        ]);
    }
    //============================================================================
    //Apresenta a pagina do novo_cliente
    public function novo_cliente(){
        //verifica se já existe sessão aberta
        if(Store::clienteLogado()){
            $this->index();
            return;
        }
        
        //Apresenta o layout para criar um novo_cliente
        Store::Layout([
            'layouts/html_header',
            'layouts/header',
            'criar_cliente',
            'layouts/footer',
            'layouts/html_footer'
        ]);
    }
    //============================================================================
    public function criar_cliente(){
        //verifica se já existe sessão aberta
        if(Store::clienteLogado()){
            $this->index();
            return;
        }
        //verifica se houve submissão de um formulário
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            $this->index();
            return;
        }
        //verificar se a password está a coincidir (senha_1 == senha_2)
        if($_POST['text_senha_1'] !== $_POST['text_senha_2']){
            //as senhas são diferentes
            $_SESSION['erro']='As senhas não são iguais!';
            $this->novo_cliente();
            return;
        }
        //Verificar se já existe o email.
        $bd = new Database();
        //para garantir que será: mb_strtolower(letras em minúsculo) e trim(remover espaços)
        $parametros = [':email'=>mb_strtolower(trim($_POST['text_email']))];

    }
    //============================================================================
    //Apresenta a pagina da CARRINHO
    public function carrinho(){
        Store::Layout([
            'layouts/html_header',
            'layouts/header',
            'carrinho',
            'layouts/footer',
            'layouts/html_footer'
        ]);
    }
}

/* - VIEWS
1. carreagr e tratar dados (calculos) (bases de dados)
2. apresentar o layout (views)
*/
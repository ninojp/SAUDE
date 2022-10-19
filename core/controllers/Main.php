<?php
namespace core\controllers;

//indicação dos NAMESPACEs das minhas classes do CORE
use core\classes\Database;
use core\classes\Store;
use core\models\Clientes;

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
    //Função para VERIFICAR e CRIAR um novo cliente
    public function criar_cliente(){
        //verifica se já existe sessão(cliente) aberta
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
            $_SESSION['erro_senha_rep']='As senhas não são iguais!';
            $this->novo_cliente();
            return;
        }
        //Verificar se na base de dados já existe um cliente com mesmo email.
        $cliente = new Clientes;
        if($cliente->verificar_email_existe($_POST['text_email'])){
            $_SESSION['erro_email_exist']='Já existe um cliente com este Email!';
            $this->novo_cliente();
            return;
        }
      
        //inserir novo cliente na base de dados e devolver o purl
        $purl = $cliente->registrar_cliente();
      
        //criar um link purl para enviar o email
        $link_purl="https://localhost/SAUDE/public/?a=confirmar_email&purl=$purl";

   
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
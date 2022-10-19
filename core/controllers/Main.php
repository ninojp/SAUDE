<?php
namespace core\controllers;

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
        //Verificar se já existe o email.
        $bd = new Database();
        //garantir que será: mb_strtolower(letras em minúsculo) e trim(remover espaços)
        $parametros = [':e_mail'=>mb_strtolower(trim($_POST['text_email']))];
        //fazer uma consulta para saber se o email já existe
        $resultados = $bd->select("SELECT email FROM clientes WHERE email=:e_mail", $parametros);
        //se o email já existe, retorna para parte de cadastro.
        if(count($resultados) != 0){
            $_SESSION['erro_email_exist']='Já existe um cliente com este Email!';
            $this->novo_cliente();
            return;
        }
        //cliente pronto para ser inserido na base de dados
        $purl=Store::criarHash();
        $parametros = [':email'=>mb_strtolower(trim($_POST['text_email'])),
                    ':senha'=>password_hash(trim($_POST['text_senha_1']),PASSWORD_DEFAULT),
                    ':nome_completo'=>trim($_POST['text_nome_completo']),
                    ':endereco'=>trim($_POST['text_endereco']),
                    ':cidade'=>trim($_POST['text_cidade']),
                    ':telefone'=>trim($_POST['text_telefone']),
                    ':purl'=>$purl,
                    ':ativo'=>0 ];
        $bd->insert("INSERT INTO clientes VALUES(0,:email,:senha,:nome_completo,:endereco,:cidade,:telefone,:purl,:ativo,NOW(),NOW(),NULL)", $parametros);

        //criar um link purl para enviar o email
        $link_purl="https://localhost/SAUDE/public/?a=confirmar_email&purl=$purl";

/*
3.Registro
criar um PURL
guardar um email com um PURL para o cliente
apresentar uma messagem indicando que deve validar o email
*/    
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
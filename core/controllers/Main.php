<?php

namespace core\controllers;

//indicação dos NAMESPACEs das minhas classes do CORE
use core\classes\Database;
use core\classes\EnviarEmail;
use core\classes\Store;
use core\models\Clientes;

class Main
{
    //============================================================================
    //Apresenta a pagina da INDEX
    public function index()
    {


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
    public function loja()
    {
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
    public function novo_cliente()
    {
        //verifica se já existe sessão aberta
        if (Store::clienteLogado()) {
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
    public function criar_cliente()
    {
        //verifica se já existe sessão(cliente) aberta
        if (Store::clienteLogado()) {
            $this->index();
            return;
        }
        //verifica se houve submissão de um formulário
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $this->index();
            return;
        }
        //verificar se a password está a coincidir (senha_1 == senha_2)
        if ($_POST['text_senha_1'] !== $_POST['text_senha_2']) {
            //as senhas são diferentes
            $_SESSION['erro_senha_rep'] = 'As senhas não são iguais!';
            $this->novo_cliente();
            return;
        }
        //Verificar se na base de dados já existe um cliente com mesmo email.
        $cliente = new Clientes;
        if ($cliente->verificar_email_existe($_POST['text_email'])) {
            $_SESSION['erro_email_exist'] = 'Já existe um cliente com este Email!';
            $this->novo_cliente();
            return;
        }

        //inserir novo cliente na base de dados e devolver o purl
        $email_cliente = mb_strtolower(trim($_POST['text_email']));
        $purl = $cliente->registrar_cliente();

        //envio do email para o cliente
        $email = new EnviarEmail();

        $resultado = $email->enviar_email_confirmacao_novo_cliente($email_cliente, $purl);
        if ($resultado) {
            //Apresenta o layout para cliente criado com sucesso
            Store::Layout([
                'layouts/html_header', 'layouts/header',
                'criar_cliente_sucesso',
                'layouts/footer', 'layouts/html_footer'
            ]);
            return;
        } else {
            echo 'Aconteceu um ERRO!';
        }
    }
    //============================================================================
    public function confirmar_email()
    {
        //verifica se já existe sessão(cliente) aberta
        if (Store::clienteLogado()) {
            $this->index();
            return;
        }
        //verificar se na query string tem um purl
        if (!isset($_GET['purl'])) {
            $this->index();
            return;
        }
        $purl = $_GET['purl'];
        //verifica se o purl é valido
        if (strlen($purl) != 12) {
            $this->index();
            return;
        }
        $cliente = new Clientes();
        $resultado =  $cliente->validar_email($purl);
        if ($resultado) {
            //Apresenta o layout para conta CONFIRMADA com sucesso
            Store::Layout([
                'layouts/html_header', 'layouts/header',
                'conta_confirmada_sucesso',
                'layouts/footer', 'layouts/html_footer'
            ]);
            return;
        } else {
            //redirecionar para a pagina inicial
            Store::redirect();
        }
    }
    //============================================================================
    public function login()
    {
        //verificar se já existe um utilizador logado
        if (Store::clienteLogado()) {
            Store::redirect();
            return;
        }
        //apresentação do formulário login
        Store::Layout([
            'layouts/html_header', 'layouts/header',
            'login_frm',
            'layouts/footer', 'layouts/html_footer'
        ]);
    }
    //============================================================================
    public function login_submit()
    {
        //verificar se já existe um utilizador logado
        if (Store::clienteLogado()) {
            Store::redirect();
            return;
        }
        //verifica se foi efetuado o post do formulário de login
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            Store::redirect();
            return;
        }
        //validar se os campos vieram corretamente preenchidos
        if (!isset($_POST['text_usuario']) || 
            !isset($_POST['text_senha']) || 
            !filter_var(trim($_POST['text_usuario']), FILTER_VALIDATE_EMAIL)) {
            //erro de preenchimento do formulário
            $_SESSION['erro_login']='Login Inválido';
            Store::redirect('login');
            return;  
        }
        echo'OK!';
        /*
1.validar o campos prenchidos
2.confirmar as informações no BD
3.Criar a sessão do cliente
*/
    }

    //============================================================================
    //Apresenta a pagina da CARRINHO
    public function carrinho()
    {
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
<?php

namespace core\controllers;

//indicação dos NAMESPACEs das minhas classes do CORE:
use core\classes\Database;
use core\classes\EnviarEmail;
use core\classes\Store;
use core\models\Clientes;
use core\models\Produtos;

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
    public function loja()
    {
        //buscar a lista de produtos disponiveis
        $produtos = new Produtos();

        //analisa que categoria é para mostrar
        $c = 'todos';
        if(isset($_GET['c'])){
            $c = $_GET['c'];
        }
        //buscar informações à BD,(lista de produtos e lista de categorias)
        $lista_produtos = $produtos->lista_produtos_disponiveis($c);
        $lista_categorias = $produtos->listar_categorias();

        $dados = ['produtos' => $lista_produtos, 'categorias' => $lista_categorias];
        
        //Apresenta a pagina(layout) da LOJA
        Store::Layout([ 'layouts/html_header', 'layouts/header',
            'loja',
            'layouts/footer', 'layouts/html_footer'], $dados);
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

        //envio do email de confirmação para o novo cliente
        $email = new EnviarEmail();
        $resultado = $email->enviar_email_confirmacao_novo_cliente($email_cliente, $purl);
        //se o email foi confirmado
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
        //prepara os dados para o models
        $usuario = trim(strtolower($_POST['text_usuario']));
        $senha = trim($_POST['text_senha']);

        //carrega o models e verifica se o login é valido
        $cliente = new Clientes();
        $resultado = $cliente->validar_login($usuario, $senha);

        //analisa o resultado
        if(is_bool($resultado)){
            //login inválido
            $_SESSION['erro'] = 'Login inválido';
            Store::redirect('login');
            return;
        } else {
            //login válido. Coloca os dados na sessão
            $_SESSION['cliente'] = $resultado->id_cliente;
            $_SESSION['usuario'] = $resultado->email;
            $_SESSION['nome_cliente'] = $resultado->nome_completo;
            
            //redirecionar para o local correto
            if(isset($_SESSION['tmp_carrinho'])){
                //remove a variável temporária da sessão
                unset($_SESSION['tmp_carrinho']);
                //direciona para o resumo da encomenda
                Store::redirect('finalizar_encomenda_resumo');
            } else {
                //redireciona para a loja
                Store::redirect();
            }
        }
    }
    //============================================================================
    public function logout()
    {
        //remove as variáveis da sessão
        unset($_SESSION['cliente']);
        unset($_SESSION['usuario']);
        unset($_SESSION['nome_cliente']);

        //redireciona para o inicio da loja
        Store::redirect();
    }
}
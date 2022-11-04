<?php

namespace core\controllers;

//indicação dos NAMESPACEs das minhas classes do CORE:
use core\classes\Database;
use core\classes\EnviarEmail;
use core\classes\PDF;
use core\classes\Store;
use core\models\Clientes;
use core\models\Encomendas;
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
    //============================================================================
    // PERFIL DO USUARIO
    //============================================================================
    public function perfil()
    {
        //verificar se existe um utilizador logado
        if (!Store::clienteLogado()) {
            Store::redirect();
            return;
        }

        //buscar informações do cliente
        $cliente = new Clientes();
        // $dados = ['dados_cliente' => $cliente->buscar_dados_cliente($_SESSION['cliente'])];
        $dtemp = $cliente->buscar_dados_cliente($_SESSION['cliente']);

        $dados_cliente = [
            'Email' => $dtemp->email,
            'Nome Completo' => $dtemp->nome_completo,
            'Endereco' => $dtemp->endereco,
            'Cidade' => $dtemp->cidade,
            'Telefone' => $dtemp->telefone];
        $dados = ['dados_cliente' => $dados_cliente];

        //apresentação da pagina de perfil
        Store::Layout([
            'layouts/html_header', 'layouts/header',
            'perfil_navegacao',
            'perfil',
            'layouts/footer', 'layouts/html_footer'], $dados);
    }
    //============================================================================
    public function alterar_dados_pessoais()
    {
        //verificar se existe um utilizador logado
        if (!Store::clienteLogado()) {
            Store::redirect();
            return;
        }

        //vai buscar os dados pessoais
        $cliente = new Clientes();
        $dados = [
            'dados_pessoais'=>$cliente->buscar_dados_cliente($_SESSION['cliente'])
        ];
        //apresentação da pagina de perfil
        Store::Layout([
            'layouts/html_header', 'layouts/header',
            'perfil_navegacao',
            'alterar_dados_pessoais',
            'layouts/footer', 'layouts/html_footer'], $dados);
    }
    //============================================================================
    public function alterar_dados_pessoais_submit()
    {
        //verificar se existe um utilizador logado
        if (!Store::clienteLogado()) {
            Store::redirect();
            return;
        }
       
        //verifica se existiu submissão de formulário
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            Store::redirect();
            return;
        }
        //validadr os dados q vem do formulário
        $email = trim(strtolower($_POST['text_email']));
        $nome_completo = trim($_POST['text_nome_completo']);
        $endereco = trim($_POST['text_endereco']);
        $cidade = trim($_POST['text_cidade']);
        $telefone = trim($_POST['text_telefone']);

        //validadr se é um email válido
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $_SESSION['erro_email_invalido'] = "Endereço de email inválido";
            $this->alterar_dados_pessoais();
            return;
        }
        //validar os campos restantes(deveria ser feito por cada item, mas por falta de tempo)
        if(empty($nome_completo) || empty($endereco) || empty($cidade)){
            $_SESSION['erro_dados_form'] = "Preencha corretamente os campos!";
            $this->alterar_dados_pessoais();
            return;
        }
        //validar se este email já existe na base de dados
        $cliente = new Clientes();
        $existe_outra_conta = $cliente->verificar_email_existe_outra_conta($_SESSION['cliente'],$email);
        if($existe_outra_conta){
            $_SESSION['erro_email_igual'] = "Este email já pertence a outro cliente!";
            $this->alterar_dados_pessoais();
            return;
        }
        //atualizar os dados do cliente na base de dados
        $cliente->atualizar_dados_cliente($email, $nome_completo, $endereco, $cidade, $telefone);
        
        //atualiza os dados do cliente na sessão
        $_SESSION['usuario']=$email;
        $_SESSION['nome_cliente']=$nome_completo;
        
        //redireciona para a pagina do perfil
        Store::redirect('perfil');
    }
    //============================================================================
    public function alterar_password()
    {
        //verificar se existe um utilizador logado
        if (!Store::clienteLogado()) {
            Store::redirect();
            return;
        }

        //apresentação da pagina de alteração da password
        Store::Layout([
            'layouts/html_header', 'layouts/header',
            'perfil_navegacao',
            'alterar_password',
            'layouts/footer', 'layouts/html_footer']);
    }
    //============================================================================
    public function alterar_password_submit()
    {
        //verificar se existe um utilizador logado
        if (!Store::clienteLogado()) {
            Store::redirect();
            return;
        }
       
        //verifica se existiu submissão de formulário
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            Store::redirect();
            return;
        }
        //validar os dados q vem do formulário
        $senha_atual = trim($_POST['text_senha_atual']);
        $nova_senha = trim($_POST['text_nova_senha']);
        $repetir_nova_senha = trim($_POST['text_repetir_nova_senha']);
                
        //validar se a nova senha vem com dados corretos(quantidade)
        if(strlen($nova_senha) < 6){
            $_SESSION['erro_senha'] = "A nova senha precisa ter mais de 6 caracteres!";
            $this->alterar_password();
            return;
        }

        //verificar se as senhas novas coincidem
        if($nova_senha != $repetir_nova_senha){
            $_SESSION['erro_senha'] = "As senhas não são iguais!";
            $this->alterar_password();
            return;
        }

        //verificar se a senha atual está correta
        $cliente = new Clientes();
        if(!$cliente->ver_se_senha_esta_correta($_SESSION['cliente'], $senha_atual)){
            $_SESSION['erro_senha'] = "A Senha Atual está errada!";
            $this->alterar_password();
            return;
        }

        //verificar se a NOVA é diferente da senha ATUAL 
        if($senha_atual == $nova_senha){
            $_SESSION['erro_senha'] = "A NOVA Senha é igual a senha ATUAL!";
            $this->alterar_password();
            return;
        }
        //atualizar a nova senha
        $cliente->atualizar_nova_senha($_SESSION['cliente'],$nova_senha);

        //redirecionar para a pagina do perfil
        Store::redirect('perfil');

    }
    //============================================================================
    public function historico_encomendas()
    {
        //verificar se existe um utilizador logado
        if (!Store::clienteLogado()) {
            Store::redirect();
            return;
        }
        //carrega o histórico das encomendas
        $encomendas = new Encomendas();
        $historico_encomendas = $encomendas->buscar_historico_encomendas($_SESSION['cliente']);
        
        $data = ['historico_encomendas'=>$historico_encomendas];

        //apresenta a view com o historico das encomendas
        Store::Layout([
            'layouts/html_header', 'layouts/header',
            'perfil_navegacao',
            'historico_encomendas',
            'layouts/footer', 'layouts/html_footer'], $data);
        /*
        apresentar uma tabela com as encomendas eo seu estado
        - detalhes de cada encomenda
        */
    }
    //============================================================================
    public function historico_encomendas_detalhe()
    {
       //verificar se existe um utilizador logado
       if (!Store::clienteLogado()) {
        Store::redirect();
        return;
       }
      //verificar se veio indicado um id_encomenda (encriptado)
      if(!isset($_GET['id'])){
        Store::redirect();
        return;
      }
      $id_encomenda = null;
      //verifica se o id_encomenda é uma string com 32 caracteres
      if(strlen($_GET['id']) != 32){
        Store::redirect();
        return;
      } else {
        $id_encomenda = Store::aesDesencriptar($_GET['id']);
        if(empty($id_encomenda)){
            Store::redirect();
        return;
        }
      }
      //verifica se a encomenda pertence a este cliente
      $encomendas = new Encomendas();
      $resultado = $encomendas->verificar_encomenda_cliente($_SESSION['cliente'], $id_encomenda);
      if(!$resultado){
        Store::redirect();
        return;
      }
      //vamos buscar os dados de detalhes da encomenda
      $detalhe_encomenda = $encomendas->detalhes_encomenda($_SESSION['cliente'], $id_encomenda);
      
      //calcular o valor total da encomenda
      $total = 0;
      foreach($detalhe_encomenda['produtos_encomenda'] as $produto){
        $total += ($produto->quantidade * $produto->preco_unidade);
      }


      $data = [
        'dados_encomenda'=>$detalhe_encomenda['dados_encomenda'],
        'produtos_encomenda'=>$detalhe_encomenda['produtos_encomenda'],
        'total_encomenda'=>$total];

      //vamos apresentar a  nova view com esses dados.
      Store::Layout([
        'layouts/html_header', 'layouts/header',
        'perfil_navegacao',
        'encomenda_detalhe',
        'layouts/footer', 'layouts/html_footer'], $data);

    }
    //============================================================================
    public function pagamento()
    {
        //simulação do webhook do getaway de pagamento

        //verificar se o código da encomenda veio indicado
        $codigo_encomenda = '';
        if(!isset($_GET['cod'])){
            return;
        } else {
            $codigo_encomenda = $_GET['cod'];
        }
        //verificar se existe o código ativo (PENDENTE)
        $encomenda = new Encomendas();
        $resultado = $encomenda->efetuar_pagamento($codigo_encomenda);
        echo (int)$resultado;
    }
    //============================================================================
    public function criar_pdf()
    {   
        //getcwd() -> usado para indicar o endereço atual
        // die(getcwd());

        $pdf = new PDF();
        //definir um template de fundo
        $pdf->set_template(getcwd().'/assets/templates_pdf/Template_teste.pdf');

        $texto="<div style='color:green;font-size:30pt;text-align:center;'>Titulo de teste: </div>";
        $texto .="<div style='color:red;font-size:12pt;text-align:right;position:absolute;top:400px;width:50%;padding:50px;'>Aqui vai um texte enormemente <br>extenso apenas para testes ......<br>Texto de teste... </div>";

        $pdf->escrever($texto);

        $pdf->apresentar_pdf();
        //usar os métodos do objeto $pdf para constrir o HTML e fazer o output

    }

}
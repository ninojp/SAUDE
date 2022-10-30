<?php

namespace core\controllers;

//indicação dos NAMESPACEs das minhas classes do CORE:
use core\classes\Database;
use core\classes\EnviarEmail;
use core\classes\Store;
use core\models\AdminModel;

class Admin
{
    //==================================================================================
    // usuario admin: admin@admin.com
    // senha:         123456
    //==================================================================================
    public function index()
    {
        //verifica se já existe sessão aberta (admin)
        if (!Store::adminLogado()){
            Store::redirect('admin_login', true);
            return;
        }

        //verificar o total de encomendas em status (PENDENTES)
        $ADMIN = new AdminModel();
        $total_encomenda_pendente = $ADMIN->total_encomenda_pendente();
        $total_encomenda_processamento = $ADMIN->total_encomenda_processamento();

        $data = ['total_encomenda_pendente'=>$total_encomenda_pendente,
                'total_encomenda_processamento'=>$total_encomenda_processamento]; 

        

        //já existe um admin logado
        Store::Layout_admin([
            'admin/layouts/html_header',
            'admin/layouts/header',
            'admin/home',
            'admin/layouts/footer',
            'admin/layouts/html_footer'], $data);
    }
    //==================================================================================
    public function admin_login()
    {
        if(Store::adminLogado()){
            Store::redirect('inicio',true);
            return;
        }
        //apresenta um quadro para login
        Store::Layout_admin([
            'admin/layouts/html_header',
            'admin/layouts/header',
            'admin/login_form',
            'admin/layouts/footer',
            'admin/layouts/html_footer']);
        
    }
    //==================================================================================
    public function admin_login_submit()
    {
        //verificar se já existe um utilizador logado
        if (Store::adminLogado()) {
            Store::redirect('inicio',true);
            return;
        }
        //verifica se foi efetuado o post do formulário de login do admin
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            Store::redirect('inicio', true);
            return;
        }
        //validar se os campos vieram corretamente preenchidos
        if (!isset($_POST['text_admin']) || 
            !isset($_POST['text_senha']) || 
            !filter_var(trim($_POST['text_admin']), FILTER_VALIDATE_EMAIL)) {
            //erro de preenchimento do formulário
            $_SESSION['erro_login']='Login Inválido';
            Store::redirect('admin_login', true);
            return;  
        }
        //prepara os dados para o models
        $admin = trim(strtolower($_POST['text_admin']));
        $senha = trim($_POST['text_senha']);

        //carrega o models e verifica se o login é valido
        $admin_model = new AdminModel();
        $resultado = $admin_model->validar_login($admin, $senha);

        //analisa o resultado
        if(is_bool($resultado)){
            //login inválido
            $_SESSION['erro_login'] = 'Usuário ou Senha inválido';
            Store::redirect('admin_login', true);
            return;
        } else {
            //login válido. Coloca os dados na sessão do admin
            $_SESSION['admin'] = $resultado->id_admin;
            $_SESSION['admin_usuario'] = $resultado->usuario;
            
            //redirecionar para pagina do backoffice
            Store::redirect('inicio',true);
        }
    }
    //==================================================================================
    public function admin_logout()
    {
        //Faz o logout do admin da sessão
        unset($_SESSION['admin']);
        unset($_SESSION['admin_usuario']);
        //redirecionar para o inicio
        Store::redirect('inicio',true);
    }
    //==================================================================================
    public function lista_clientes()
    {
        echo 'Lista de Clientes';
    }
    //==================================================================================
    public function lista_encomenda()
    {
        //apresenta a lista de encomendas (usando filtro se for o caso)

        //verifica se existe um filtro da query string
        $filtros = ['pendente'=>'PENDENTE',
                'processamento'=>'PROCESSAMENTO',
                'cancelada'=>'CANCELADA',
                'enviada'=>'ENVIADA',
                'concluida'=>'CONCLUIDA'];

        $filtro = '';
        if(isset($_GET['f'])){
            //verifica se a verialvel é uma key dos filtros
            if(key_exists($_GET['f'], $filtros)){
                $filtro = $filtros[$_GET['f']];
            }
        }
        //carregar a lista de encomendas
        $admin_model = new AdminModel();
        $lista_encomenda = $admin_model->lista_encomenda($filtro);

        // Store::printData($lista_encomenda);

        $data = [
            'lista_encomenda'=>$lista_encomenda,
            'filtro'=>$filtro];

        //apresenta a pagina das encomendas
        Store::Layout_admin([
            'admin/layouts/html_header',
            'admin/layouts/header',
            'admin/lista_encomenda',
            'admin/layouts/footer',
            'admin/layouts/html_footer'], $data);
    }

}   
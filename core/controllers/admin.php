<?php

namespace core\controllers;

//indicação dos NAMESPACEs das minhas classes do CORE:
use core\classes\Database;
use core\classes\EnviarEmail;
use core\classes\PDF;
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
    //  AUTENTICAÇÃO
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
    //  CLIENTES
    //==================================================================================
    public function lista_cliente()
    {
        //verificar se existe um Admin logado
        if (!Store::adminLogado()) {
            Store::redirect('inicio',true);
            return;
        }
        //vai buscar a lista de clientes
        $ADMIN = new AdminModel();
        $clientes = $ADMIN->lista_cliente();

        $data=['clientes'=>$clientes];

        //apresenta a pagina da Lista de Clientes
        Store::Layout_admin([
            'admin/layouts/html_header',
            'admin/layouts/header',
            'admin/lista_cliente',
            'admin/layouts/footer',
            'admin/layouts/html_footer'], $data);

    }
    //==================================================================================
    public function detalhe_cliente()
    {
        //verificar se existe um Admin logado
        if (!Store::adminLogado()) {
            Store::redirect('inicio',true);
            return;
        }
        //verifica se existe um id_cliente na query string
        if(!isset($_GET['c'])){
            Store::redirect('inicio', true);
            return;
        }
        $id_cliente = Store::aesDesencriptar($_GET['c']);
        //verifica se o id_cliente é valido
        if(empty($id_cliente)){
            Store::redirect('inicio', true);
            return;
        }
        //buscar os dados do cliente
        $ADMIN = new AdminModel();
        $data = ['dados_cliente'=>$ADMIN->buscar_cliente($id_cliente),
                'total_encomenda'=>$ADMIN->total_encomenda_cliente($id_cliente)];

        //apresenta a pagina da Lista de Clientes
        Store::Layout_admin([
            'admin/layouts/html_header',
            'admin/layouts/header',
            'admin/detalhe_cliente',
            'admin/layouts/footer',
            'admin/layouts/html_footer'], $data);
    }
    //==================================================================================
    public function cliente_historico_encomenda()
    {
        //verificar se existe um Admin logado
        if (!Store::adminLogado()) {
            Store::redirect('inicio',true);
            return;
        }
        //verifica se existe o id_cliente encriptado
        if(!isset($_GET['c'])){
            Store::redirect('inicio',true);
        }

        //definir o id_cliente que vem encriptado
        $id_cliente=Store::aesDesencriptar($_GET['c']);
        //buscar os dados do cliente
        $ADMIN = new AdminModel();
        $data = ['cliente'=>$ADMIN->buscar_cliente($id_cliente),
                'lista_encomenda'=>$ADMIN->buscar_encomendas_cliente($id_cliente)];

        //apresenta a pagina da Lista de Clientes
        Store::Layout_admin([
            'admin/layouts/html_header',
            'admin/layouts/header',
            'admin/lista_encomenda_cliente',
            'admin/layouts/footer',
            'admin/layouts/html_footer'], $data);

    }

    //==================================================================================
    //  ENCOMENDAS
    //==================================================================================
    public function lista_encomenda()
    {
        //verificar se existe um Admin logado
        if (!Store::adminLogado()) {
            Store::redirect('inicio',true);
            return;
        }

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
        $id_cliente=null;
        //vai buscar o id_cliente se existir na query string
        if(isset($_GET['c'])){
            $id_cliente=Store::aesDesencriptar($_GET['c']);
        }

        //carregar a lista de encomendas
        $admin_model = new AdminModel();
        $lista_encomenda = $admin_model->lista_encomenda($filtro, $id_cliente);

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
    //==================================================================================
    public function detalhe_encomenda()
    {
        //verificar se existe um Admin logado
        if (!Store::adminLogado()) {
            Store::redirect('inicio',true);
            return;
        }
        //buscar o id_encomenda
        $id_encomenda = null;
        if(isset($_GET['e'])){
            $id_encomenda = Store::aesDesencriptar($_GET['e']);
        }
        if(gettype($id_encomenda)!='string'){
            Store::redirect('inicio',true);
            return;
            
        }

        //carregar os dados da encoemnda selecionada
        $admin_model = new AdminModel();
        $encomenda = $admin_model->buscar_detalhe_encomenda($id_encomenda);

        //EU FIZ DESTA FORMA - BUSCAR NOME CLIENTE + ENCOMENDAS DO MESMO
        // $td_encomenda = ['d_cliente'=>$admin_model->buscar_cliente($encomenda['encomenda']->id_cliente),'d_encomenda'=> $encomenda];
        //MAS A FORMA DO PROFESSOR ERA BEM MAIS SIMPLES, MODIFICANDO APENAS LA NA QUERY(buscar_detalhe_encomenda)
        // Store::printData($td_encomenda);
        // die('Até Aqui!');
       
        //apresentar os dados por forma a poder ver os detalhes e alterar o seu Status
               
        $data=$encomenda;
        Store::Layout_admin([
            'admin/layouts/html_header',
            'admin/layouts/header',
            'admin/encomenda_detalhe',
            'admin/layouts/footer',
            'admin/layouts/html_footer'], $data);

        //incorporar neste quadro o mcanismo de produçao de documentos (PDF)
    }
    //==================================================================================
    public function encomenda_alterar_estado()
    {
        //verificar se existe um Admin logado
        if (!Store::adminLogado()) {
            Store::redirect('inicio',true);
            return;
        }
        //buscar o id_encomenda
        $id_encomenda = null;
        if(isset($_GET['e'])){
            $id_encomenda = Store::aesDesencriptar($_GET['e']);
        }
        if(gettype($id_encomenda)!='string'){
            Store::redirect('inicio',true);
            return;
        }
        //bsucar o novo estado(status)
        $estado=null;
        if(isset($_GET['s'])){
            $estado=$_GET['s'];
        }
        if(!in_array($estado, STATUS)){
            Store::redirect('inicio',true);
            return;
        }
        //regras de negócio para gerir a encomenda (novo estado)

        //atualizar o estado da encomenda na base de dados
        $admin_model = new AdminModel();
        $admin_model->atualizar_status_encomenda($id_encomenda, $estado);
        //executar operação baseadas no novo estado

        //carregar os dados da encomenda selecionada
        switch ($estado) {
            case 'PENDENTE':
                $this->operacao_notificar_cliente_mudanca_estado($id_encomenda);
                break;
            case 'PROCESSAMENTO':
                # sem ações no momento
                break;
            case 'CANCELADA':
                $this->operacao_notificar_cliente_mudanca_estado($id_encomenda);
                break;
            case 'ENVIADA':
                # Enviar um email com a notificação ao cliente sobre o envio da encomenda
                $this->operacao_enviar_email_encomenda_enviada($id_encomenda);
                break;
            case 'CONCLUIDA':
                $this->operacao_notificar_cliente_mudanca_estado($id_encomenda);
                break;
        }
        //redireciona para a pagina da própria encomenda
        Store::redirect('detalhe_encomenda&e='.$_GET['e'], true);
    }

    //==================================================================================
    // OPERAÇÕES APÓS MUDANÇA DE ESTADO DA ENCOMENDA
    //==================================================================================
    public function operacao_notificar_cliente_mudanca_estado($id_encomenda)
    {
        //vai enviar um email para o cliente notificando que a encomenda sofreu alterações
    }
    //==================================================================================
    private function operacao_enviar_email_encomenda_enviada($id_encomenda)
    {
        //executar as operações para enviar email ao cliente

    }
    //==================================================================================
    public function criar_pdf_encomenda()
    {
        //verificar se existe um Admin logado
        if (!Store::adminLogado()) {
            Store::redirect('inicio',true);
            return;
        }
        //buscar o id_encomenda
        $id_encomenda = null;
        if(isset($_GET['e'])){
            $id_encomenda = Store::aesDesencriptar($_GET['e']);
        }
        if(gettype($id_encomenda)!='string'){
            Store::redirect('inicio',true);
            return;
        }
        //vai buscar todos os dados da encomenda
        $admin_model = new AdminModel();
        $encomenda = $admin_model->buscar_detalhe_encomenda($id_encomenda);
        foreach($encomenda['lista_produtos'] as $produto);
        
        //buscar dados do cliente
        // Store::printData($encomenda);

        //criar o PDF com os detalhes da encomenda
        $pdf = new PDF(false);
        $pdf->set_template(getcwd().'/assets/templates_pdf/templat.pdf');
    //--------------------------------------------------------------------------------------------------
        //mas bora improvisar... DEU CERTO USEI MAS DEPOIS DE CRIAR AS DEFINIÇÕES ORIGINAIS DA PLAYLIST DO PROFESSOR FOI NECESSÁRIO COMENTAR TUDO
        // $texto = "<style>#div_cliente { position: absolute; top: 130px; left: 100px; color: #fff;}
        // #div_encomenda{ position: absolute; top: 350px; left: 100px;}
        // #div_produto{ position: absolute; top: 650px; left: 100px;}
        // .span_desc { font-size: 20pt; font-weight: 700; }
        // .p_texto { font-size: 14pt; }
        // </style>";
        // $texto .= "<div id='div_cliente'><p class='p_texto'>
        //     <span class='span_desc'>Nome Cliente:</span> ".$encomenda['encomenda']->nome_completo."<br>
        //     <span class='span_desc'>Email:</span> ".$encomenda['encomenda']->email."<br>
        //     <span class='span_desc'>Telefone:</span> ".$encomenda['encomenda']->telefone."<br>
        //     <span class='span_desc'>Cidade:</span> ".$encomenda['encomenda']->cidade."<br>
        //     <span class='span_desc'>Endereço:</span> ".$encomenda['encomenda']->email."<br>
        // </p></div><div id='div_encomenda'><p class='p_texto'>
        // <span class='span_desc'>Dados da Encomenda:</span><br>
        // <span class='span_desc'>Codigo da Encomenda:</span> ".$encomenda['encomenda']->codigo_encomenda."<br>
        // <span class='span_desc'>Data da Encomenda:</span> ".$encomenda['encomenda']->data_encomenda."<br>
        // <span class='span_desc'>Estado Atual da Encomenda:</span> ".$encomenda['encomenda']->status."<br>
        // <span class='span_desc'>Mensagem:</span> ".$encomenda['encomenda']->mensagem."<br>
        // </p></div><div id='div_produto'><p class='p_texto'>
        // <span class='span_desc'>Dados dos produtos:</span> ".$produto->designacao_produto."<br>
        // <span class='span_desc'>Quantidade:</span> ".$produto->quantidade."<br>
        // <span class='span_desc'>Preço por Unidade:</span> ".$produto->preco_unidade."<br>
        // <span class='span_desc'>Preço da Total:</span><br>
        // </p></div>";
        //--------------------------------------------------------------------------------------------------
        //titulo - Dados do Cliente:
        $pdf->posicao_dimensao(150, 125, 180, 25);
        $pdf->cor_text('#000');
        $pdf->text_align('center');
        $pdf->font_size('24pt');
        $pdf->letra_espessura('bold');
        $pdf->escrever('Dados do Cliente:');
        //campos de dados do cliente
        $pdf->posicao_dimensao(100, 150, 80, 100);
        $pdf->cor_text('#000');
        $pdf->text_align('left');
        $pdf->font_size('18pt');
        $pdf->letra_espessura('bold');
        $pdf->escrever('Nome: <br>Email: <br>Telefone: <br>Endereço: <br>Cidade: <br>');
        //informações do cliente
        $pdf->posicao_dimensao(180, 150, 300, 100);
        $pdf->cor_text('#000');
        $pdf->font_size('14pt');
        $pdf->letra_espessura('normal');
        $pdf->text_align('left');
        $pdf->escrever($encomenda['encomenda']->nome_completo.'<br>'.$encomenda['encomenda']->email.'<br>'.$encomenda['encomenda']->telefone.'<br>'.$encomenda['encomenda']->endereco.'<br>'.$encomenda['encomenda']->cidade.'<br>');
      
        //titulo - Dados da Encomenda:
        $pdf->posicao_dimensao(150, 350, 180, 25);
        $pdf->cor_text('#000');
        $pdf->text_align('center');
        $pdf->font_size('24pt');
        $pdf->letra_espessura('bold');
        $pdf->escrever('Dados da Encomenda:');
        //campos de dados da Encomenda
        $pdf->posicao_dimensao(100, 375, 80, 100);
        $pdf->cor_text('#000');
        $pdf->text_align('left');
        $pdf->font_size('18pt');
        $pdf->letra_espessura('bold');
        $pdf->escrever('Data: <br>Codigo: <br>Estado: <br>MSG: <br>');
        //informações da Encomenda
        $pdf->posicao_dimensao(180, 375, 300, 100);
        $pdf->cor_text('#000');
        $pdf->font_size('14pt');
        $pdf->letra_espessura('normal');
        $pdf->text_align('left');
        $pdf->escrever($encomenda['encomenda']->data_encomenda.'<br>'.$encomenda['encomenda']->codigo_encomenda.'<br>'.$encomenda['encomenda']->status.'<br>'.$encomenda['encomenda']->mensagem.'<br>');

        //titulo - Dados do Produto:
        $pdf->posicao_dimensao(150, 600, 180, 25);
        $pdf->cor_text('#000');
        $pdf->text_align('center');
        $pdf->font_size('24pt');
        $pdf->letra_espessura('bold');
        $pdf->escrever('Dados do Produto:');
        
        //lista dos produtos da encomenda
        $y=625;
        $total_encomenda = 0;
        $pdf->font_size('34pt');
        foreach($encomenda['lista_produtos'] as $produto){
            //quantidade e descrição dos produtos
            $pdf->posicao_dimensao(100, $y, 280, 35);
            $pdf->letra_espessura('normal');
            $pdf->text_align('left');
            $pdf->escrever($produto->quantidade.' Unidade(s) - '.$produto->designacao_produto);
            //calculo da quantidade x o preço 
            $pdf->posicao_dimensao(450, $y, 180, 35);
            $pdf->text_align('righ');
            $preco=$produto->quantidade * $produto->preco_unidade;
            $total_encomenda += $preco;
            $pdf->escrever('R$ '.number_format($preco,2,',','.'));
            $y+=28;
        }
        //apresenta o preço do TOTAL
        $pdf->posicao_dimensao(150, 750, 380, 25);
        $pdf->cor_text('#000');
        $pdf->text_align('center');
        $pdf->font_size('44pt');
        $pdf->letra_espessura('bold');
        $pdf->escrever('O Valor Total da encomenda é:  R$ '.number_format($total_encomenda,2,',','.'));

        //tranformar o html para pdf
        $pdf->apresentar_pdf();
    }
    //==================================================================================
    public function enviar_pdf_encomenda()
    {
        //verificar se existe um Admin logado
        if (!Store::adminLogado()) {
            Store::redirect('inicio',true);
            return;
        }
        //buscar o id_encomenda
        $id_encomenda = null;
        if(isset($_GET['e'])){
            $id_encomenda = Store::aesDesencriptar($_GET['e']);
        }
        if(gettype($id_encomenda)!='string'){
            Store::redirect('inicio',true);
            return;
        }
        //vai buscar todos os dados da encomenda
        $admin_model = new AdminModel();
        $encomenda = $admin_model->buscar_detalhe_encomenda($id_encomenda);
        foreach($encomenda['lista_produtos'] as $produto);

        //criar o PDF com os detalhes da encomenda
        $pdf = new PDF(false);
        $pdf->set_template(getcwd().'/assets/templates_pdf/templat.pdf');
    
        //titulo - Dados do Cliente:
        $pdf->posicao_dimensao(150, 125, 180, 25);
        $pdf->cor_text('#000');
        $pdf->text_align('center');
        $pdf->font_size('24pt');
        $pdf->letra_espessura('bold');
        $pdf->escrever('Dados do Cliente:');
        //campos de dados do cliente
        $pdf->posicao_dimensao(100, 150, 80, 100);
        $pdf->cor_text('#000');
        $pdf->text_align('left');
        $pdf->font_size('18pt');
        $pdf->letra_espessura('bold');
        $pdf->escrever('Nome: <br>Email: <br>Telefone: <br>Endereço: <br>Cidade: <br>');
        //informações do cliente
        $pdf->posicao_dimensao(180, 150, 300, 100);
        $pdf->cor_text('#000');
        $pdf->font_size('14pt');
        $pdf->letra_espessura('normal');
        $pdf->text_align('left');
        $pdf->escrever($encomenda['encomenda']->nome_completo.'<br>'.$encomenda['encomenda']->email.'<br>'.$encomenda['encomenda']->telefone.'<br>'.$encomenda['encomenda']->endereco.'<br>'.$encomenda['encomenda']->cidade.'<br>');
      
        //titulo - Dados da Encomenda:
        $pdf->posicao_dimensao(150, 350, 180, 25);
        $pdf->cor_text('#000');
        $pdf->text_align('center');
        $pdf->font_size('24pt');
        $pdf->letra_espessura('bold');
        $pdf->escrever('Dados da Encomenda:');
        //campos de dados da Encomenda
        $pdf->posicao_dimensao(100, 375, 80, 100);
        $pdf->cor_text('#000');
        $pdf->text_align('left');
        $pdf->font_size('18pt');
        $pdf->letra_espessura('bold');
        $pdf->escrever('Data: <br>Codigo: <br>Estado: <br>MSG: <br>');
        //informações da Encomenda
        $pdf->posicao_dimensao(180, 375, 300, 100);
        $pdf->cor_text('#000');
        $pdf->font_size('14pt');
        $pdf->letra_espessura('normal');
        $pdf->text_align('left');
        $pdf->escrever($encomenda['encomenda']->data_encomenda.'<br>'.$encomenda['encomenda']->codigo_encomenda.'<br>'.$encomenda['encomenda']->status.'<br>'.$encomenda['encomenda']->mensagem.'<br>');

        //titulo - Dados do Produto:
        $pdf->posicao_dimensao(150, 600, 180, 25);
        $pdf->cor_text('#000');
        $pdf->text_align('center');
        $pdf->font_size('24pt');
        $pdf->letra_espessura('bold');
        $pdf->escrever('Dados do Produto:');
        
        //lista dos produtos da encomenda
        $y=625;
        $total_encomenda = 0;
        $pdf->font_size('34pt');
        foreach($encomenda['lista_produtos'] as $produto){
            //quantidade e descrição dos produtos
            $pdf->posicao_dimensao(100, $y, 280, 35);
            $pdf->letra_espessura('normal');
            $pdf->text_align('left');
            $pdf->escrever($produto->quantidade.' Unidade(s) - '.$produto->designacao_produto);
            //calculo da quantidade x o preço 
            $pdf->posicao_dimensao(450, $y, 180, 35);
            $pdf->text_align('righ');
            $preco=$produto->quantidade * $produto->preco_unidade;
            $total_encomenda += $preco;
            $pdf->escrever('R$ '.number_format($preco,2,',','.'));
            $y+=28;
        }
        //apresenta o preço do TOTAL
        $pdf->posicao_dimensao(150, 750, 380, 25);
        $pdf->cor_text('#000');
        $pdf->text_align('center');
        $pdf->font_size('44pt');
        $pdf->letra_espessura('bold');
        $pdf->escrever('O Valor Total da encomenda é:  R$ '.number_format($total_encomenda,2,',','.'));

        //definir permissões e proteção para o pdf
        $permissoes=['print'];
            //opções de permissão
            //'copy', 'print','modify','annot-forms','fill-forms','extract','assemble','print-highres'
        $pdf->set_permissoes($permissoes,'senha');//basta remover, para ficar sem senha de acesso ao pdf

        //nos testes era apresentado
        // $pdf->apresentar_pdf();
        //Guardar o pdf
        $arquivo = $encomenda['encomenda']->codigo_encomenda . '_' . date('YmdHis').'.pdf';
        $pdf->guardar_pdf($arquivo);
        
        //------------------------------------------------------------------------------------------
        // ENVIAR O EMAIL com o arquivo em anexo
        $email = new EnviarEmail();
        $email->enviar_pdf_encomenda_cliente($encomenda['encomenda']->email, $arquivo);

        // ELIMINAR o arquivo enviado por email(se quiser)
        // unlink(PDF_PATH.$arquivo);
        //-----------------------------------------------------------------------------------------
        
        //redirecionar para a pagina da encomenda
        Store::redirect('detalhe_encomenda&e='.$_GET['e'], true);
    }
    //============================================================================
    //  TESTES DE CRIAÇÃO DE PDF
    //============================================================================
    public function teste_criar_pdf()
    {   
        //getcwd() -> usado para indicar o endereço atual
        // die(getcwd());

        $pdf = new PDF();
        //definir um template de fundo
        $pdf->set_template(getcwd().'/assets/templates_pdf/Template.pdf');

        //posicionamento do texto
        $pdf->posicao_dimensao(100, 150, 300, 50);
        $pdf->cor_text('#000');
        $pdf->cor_fundo('rgb(240,240,240)');
        $pdf->text_align('left');
        // $pdf->font_size('24px');
        //método(escrever()) do objeto ($pdf) para construir o HTML para fazer o output como pdf
        $pdf->escrever('Texto apenas');

        $pdf->posicao_dimensao(450, 350, 300, 100);
        $pdf->cor_text('white');
        $pdf->cor_fundo('blue');
        $pdf->text_align('center');
        // $pdf->set_font_family('Times New Roman');
        $pdf->font_size('14pt');
        $pdf->letra_espessura('bold');
        $pdf->escrever('Segundo Texto apenas para testes<br> Este deve ser ukm texto um pouco maior');

        //método do objeto $pdf que recebe o HTML e faz a conversão para o output em pdf  
        $pdf->apresentar_pdf();
        
        //TETES... só aparece se desativar o metodo de converção para PDF
        // $data= ['texto'=>$texto];
        // Store::Layout_admin([
        //     'admin/layouts/html_header',
        //     'admin/layouts/header',
        //     'admin/layouts/admin_menu',
        //     'admin/pdf_teste',
        //     'admin/layouts/footer',
        //     'admin/layouts/html_footer'], $data);
    }
}   
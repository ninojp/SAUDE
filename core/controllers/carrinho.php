<?php

namespace core\controllers;

//indicação dos NAMESPACEs das minhas classes do CORE:
use core\classes\Database;
use core\classes\EnviarEmail;
use core\classes\Store;

use core\models\Clientes;
use core\models\Encomendas;
use core\models\Produtos;

class Carrinho
{
    //============================================================================
    public function adicionar_carrinho()
    {
        //vai buscar o id_carrinho à query string
        if(!isset($_GET['id_produto'])){
            echo isset($_SESSION['carrinho']) ? count($_SESSION['carrinho']) : '';
            return;
        }
        
        //define o id do produto
        $id_produto = $_GET['id_produto'];

        $produtos = new Produtos();
        $resultados = $produtos->verificar_stock_produto($id_produto);
        if(!$resultados){
            echo isset($_SESSION['carrinho']) ? count($_SESSION['carrinho']) : '';
            return;
        }

        //adiciona/gestão da variável de SESSÃO do carrinho
        $carrinho = [];

        if(isset($_SESSION['carrinho'])){
            $carrinho = $_SESSION['carrinho'];
        }

        //adicionar o produto ao carrinho
        if(key_exists($id_produto, $carrinho)){
            //já existe o produto, acrescenta mais uma unidade
            $carrinho[$id_produto]++;
        } else {
            //adicionar novo produto ao carrinho
            $carrinho[$id_produto] = 1;
        }
        //atualiza os dados do carrinho na sessão
        $_SESSION['carrinho'] = $carrinho;

        //devolve a resposta (número de produtos do carrinho)
        $total_produtos = 0;
        foreach($carrinho as $quantidade){
            $total_produtos += $quantidade;
        }
        echo $total_produtos;
    }
    //============================================================================
    public function remover_produto_carrinho()
    {   
        // vai buscar o id_produto na query string
        $id_produto = $_GET['id_produto'];
        //buscar o carrinho à sessão
        $carrinho = $_SESSION['carrinho'];
        //remover o produto do carrinho
        unset($carrinho[$id_produto]);
        //utualizar o carrinho na sessão
        $_SESSION['carrinho'] = $carrinho;
        //apresentar novamente a pagina do carrinho
        $this->carrinho();
        
    }
    //============================================================================
    public function limpar_carrinho()
    {
        //limpa o carrinho de todos os produtos
        unset($_SESSION['carrinho']);

        //refrescar a pagina do carrinho
        $this->carrinho();
    }
    //============================================================================
    public function carrinho()
    {
        //verifica se existe o carrinho
        if(!isset($_SESSION['carrinho']) || count($_SESSION['carrinho']) == 0){
            $dados = ['carrinho' => null];
        } else {
            $ids = [];
            foreach($_SESSION['carrinho'] as $id_produto => $quantidade){
                array_push($ids, $id_produto);
            }
            $ids = implode(",", $ids);
            $produtos = new Produtos();
            $resultados = $produtos->buscar_produtos_por_ids($ids);

            $dados_tmp = [];
            foreach($_SESSION['carrinho'] as $id_produto => $quantidade_carrinho){
                //id, imagem, titulo, quantidade, preço, do produto
                foreach($resultados as $produto){
                    if($produto->id_produto == $id_produto){
                    $id_produto = $produto->id_produto;
                    $imagem = $produto->imagem;
                    $titulo = $produto->nome_produto;
                    $quantidade = $quantidade_carrinho;
                    $preco = $produto->preco * $quantidade;

                    //colocar o produto na coleção
                    array_push($dados_tmp,[
                        'id_produto'=>$id_produto,
                        'imagem'=>$imagem,
                        'titulo'=>$titulo,
                        'quantidade'=>$quantidade,
                        'preco'=>$preco]);
                        break;
                    }
                }
            }
            //calcular o total
            $total_da_encomenda = 0;
            foreach($dados_tmp as $item){
                $total_da_encomenda += $item['preco'];
            }
            array_push($dados_tmp, $total_da_encomenda);
            
            //colocar o preço total na sessão
            $_SESSION['total_encomenda'] = $total_da_encomenda;
            $dados = ['carrinho'=>$dados_tmp];
        }

        //Apresenta a pagina da CARRINHO
        Store::Layout([
            'layouts/html_header', 'layouts/header',
            'carrinho',
            'layouts/footer', 'layouts/html_footer'], $dados);
    }
    //============================================================================
    public function endereco_alternativo()
    {
        //receber os dados via AJAX(axios, json) e os coloca no $post(array)
        $post = json_decode(file_get_contents('php://input'), true);

        //adiciona ou altera na sessão a variável(array) dados_alternativos
        $_SESSION['dados_alternativos'] = [
            'endereco' => $post['text_endereco'],
            'cidade' => $post['text_cidade'],
            'email' => $post['text_email'],
            'telefone' => $post['text_telefone'],
            ];
            
    }
    //============================================================================
    public function finalizar_encomenda()
    {
        // verifica se existe cliente logado
        if(!isset($_SESSION['cliente'])){
            //coloca na sessão um referrer temporário
            $_SESSION['tmp_carrinho'] = true;
            //redirecionar para o quadro de login
            Store::redirect('login');
        } else {
            Store::redirect('finalizar_encomenda_resumo');
        }
    }
    //============================================================================
    public function finalizar_encomenda_resumo()
    {
        //verifica se existe cliente logado
        if(!isset($_SESSION['cliente'])){
            Store::redirect('inicio');
        }
        //verifica se pode avançar para a gravação da encomenda
        if(!isset($_SESSION['carrinho']) || count($_SESSION['carrinho']) == 0){
            Store::redirect('inicio');
            return;
        }

        //-------------------------------------------------------------------------
        //informações do carrinho
        $ids = [];
        foreach($_SESSION['carrinho'] as $id_produto => $quantidade){
            array_push($ids, $id_produto);
        }
        $ids = implode(",", $ids);
        $produtos = new Produtos();
        $resultados = $produtos->buscar_produtos_por_ids($ids);

        $dados_tmp = [];
        foreach($_SESSION['carrinho'] as $id_produto => $quantidade_carrinho){
            //id, imagem, titulo, quantidade, preço, do produto
            foreach($resultados as $produto){
                if($produto->id_produto == $id_produto){
                $id_produto = $produto->id_produto;
                $imagem = $produto->imagem;
                $titulo = $produto->nome_produto;
                $quantidade = $quantidade_carrinho;
                $preco = $produto->preco * $quantidade;

                //colocar o produto na coleção
                array_push($dados_tmp,[
                    'id_produto'=>$id_produto,
                    'imagem'=>$imagem,
                    'titulo'=>$titulo,
                    'quantidade'=>$quantidade,
                    'preco'=>$preco]);
                    break;
                }
            }
        }
        //calcular o total
        $total_da_encomenda = 0;
        foreach($dados_tmp as $item){
            $total_da_encomenda += $item['preco'];
        }
        array_push($dados_tmp, $total_da_encomenda);
        
        //preparar os dados da view
        $dados = [];
        $dados['carrinho'] = $dados_tmp;
        //-------------------------------------------------------------------------
        
        //buscar as informações do cliente
        $cliente = new Clientes();
        $dados_cliente = $cliente->buscar_dados_cliente($_SESSION['cliente']);
        $dados['cliente'] = $dados_cliente;
        //-------------------------------------------------------------------------
        
        //Gerar o codigo da encomenda
        if(!isset($_SESSION['codigo_encomenda'])){
            $codigo_encomenda = Store::gerarCodigoEncomenda();
            $_SESSION['codigo_encomenda'] = $codigo_encomenda;
        }
        //-------------------------------------------------------------------------

        //Apresenta a pagina da CARRINHO
        Store::Layout([
            'layouts/html_header', 'layouts/header',
            'encomenda_resumo',
            'layouts/footer', 'layouts/html_footer'], $dados);
    }
    //============================================================================
    public function confirmar_encomenda()
    {
        //--------------------------------------------------------------------------
        //verifica se existe cliente logado
        if(!isset($_SESSION['cliente'])){
            Store::redirect('inicio');
            return;
        }
        //verifica se pode avançar para a gravação da encomenda
        if(!isset($_SESSION['carrinho']) || count($_SESSION['carrinho']) == 0){
            Store::redirect('inicio');
            return;
        }

        //enviar email para o cliente com os dados da encomenda e pagamento
        $dados_encomenda = [];

        //buscar os dados dos produtos(por id) 
        $ids = [];
        foreach($_SESSION['carrinho'] as $id_produto => $quantidade){
            array_push($ids, $id_produto);
        }
        $ids = implode(",", $ids);
        $produtos = new Produtos();
        $produtos_da_encomenda = $produtos->buscar_produtos_por_ids($ids);

        //estrutura dos dados dos produtos
        $string_produtos = [];
        
        foreach($produtos_da_encomenda as $resultado){
            //buscar a quantidade
            $quantidade = $_SESSION['carrinho'][$resultado->id_produto];
            //criar uma string do produto
            $string_produtos[] = "$quantidade x $resultado->nome_produto - ".'R$ '.number_format($resultado->preco,2,',','.').' /unidade';
        }
        //lista de produtos para o email
        $dados_encomenda['lista_produtos'] = $string_produtos;
        
        //preço total da encomenda para o email
        $dados_encomenda['total'] = "R$ ".number_format($_SESSION['total_encomenda'],2,',','.');

        //dados de pagamento da encomenda para o email
        $dados_encomenda['dados_pagamento'] = [
            'numero_conta'=>'123456789',
            'codigo_encomenda'=>$_SESSION['codigo_encomenda'],
            'total'=>"R$ ".number_format($_SESSION['total_encomenda'],2,',','.')
        ];
        //---------------------------------------------------------------------------
        
        //---------------------------------------------------------------------------
        //enviar email para o cliente com os dados da encomenda e pagamento

        //envio do email (encomenda) para o USUARIO
        // $email = new EnviarEmail();
        // $resultado = $email->enviar_email_confirmacao_encomenda($_SESSION['usuario'],$dados_encomenda);
        //--------------------------------------------------------------------------
        
        //--------------------------------------------------------------------------
        //guardar na base de dados a encomenda
        $dados_encomenda = [];
        $dados_encomenda['id_cliente']=$_SESSION['cliente'];

        //verificar se existe dados no array dados_alternativos.
        if(isset($_SESSION['dados_alternativos']['endereco']) && !empty($_SESSION['dados_alternativos']['endereco'])){
            //considerar(colocar no array $dados_encomenda) os dados alternativos
            $dados_encomenda['endereco'] = $_SESSION['dados_alternativos']['endereco'];
            $dados_encomenda['cidade'] = $_SESSION['dados_alternativos']['cidade'];
            $dados_encomenda['email'] = $_SESSION['dados_alternativos']['email'];
            $dados_encomenda['telefone'] = $_SESSION['dados_alternativos']['telefone'];
        } else {
            //considerar(deixar) os dados que já estavam na base de dados(cliente)
            $cliente = new Clientes();
            $dados_cliente = $cliente->buscar_dados_cliente($_SESSION['cliente']);

            $dados_encomenda['endereco'] = $dados_cliente->endereco;
            $dados_encomenda['cidade'] = $dados_cliente->cidade;
            $dados_encomenda['email'] = $dados_cliente->email;
            $dados_encomenda['telefone'] = $dados_cliente->telefone;
        }

        //codigo encomenda
        $dados_encomenda['codigo_encomenda'] = $_SESSION['codigo_encomenda'];
        
        //status da encomenda
        $dados_encomenda['status'] = 'PENDENTE';
        $dados_encomenda['mensagem'] = '';

        //------------------------------------------------------------------------
        //dados dos produtos da encomenda
        // $produtos_da_encomenda (nome_produto, preco)
        $dados_produtos = [];
        foreach($produtos_da_encomenda as $produto){
            $dados_produtos[] = [
                'designacao_produto' => $produto->nome_produto,
                'preco_unidade' => $produto->preco,
                'quantidade' => $_SESSION['carrinho'][$produto->id_produto]];
        }
  
        $encomenda = new Encomendas();
        $encomenda->guardar_encomenda($dados_encomenda, $dados_produtos);


        //preparar os dados para apresentar na pagina de agradecimento
        $codigo_encomenda = $_SESSION['codigo_encomenda'];
        $total_encomenda = $_SESSION['total_encomenda'];

        //--------------------------------------------------------------------------
        
        //--------------------------------------------------------------------------
        // Limpar todos os dados da encomenda que estão no carrinho
        unset($_SESSION['codigo_encomenda']);
        unset($_SESSION['carrinho']);
        unset($_SESSION['total_encomenda']);
        unset($_SESSION['dados_alternativos']);

        
        //--------------------------------------------------------------------------
        
        //--------------------------------------------------------------------------
        //guardar estes dados, após a sessão ser limpa
        $dados = [
            'codigo_encomenda' => $codigo_encomenda,
            'total_encomenda' => $total_encomenda
        ];
        //Apresenta a pagina(view) agradecer a encomenda
        Store::Layout([
            'layouts/html_header', 'layouts/header',
            'encomenda_confirmada',
            'layouts/footer', 'layouts/html_footer'], $dados);
    }
}
/* passos a serem feitos

// apenas para DEBUG de codigo
echo '<pre>';
print_r($dados_encomenda);
print_r($produtos_da_encomenda);
echo '</pre>';
die("vai ate aqui!");

    verificar se existe cliente logado
    não existe?
    - colocar um "referrer" na sessão
    - abrir o quadro de login
    - após login com sucesso, regressar à loja
    - remover o referrer da sessão
    Existe?
    - passo 2 (confirmar)

fazer um ciclo por produto no carrinho
 - identificar o id e usar os dados da bd para criar 
    uma coleção de dados para a do carrinho

não existe carrinho
carrinho vazio (link para voltar a loja)

id buscar à bd os dados dos produtos que existem no carrinho
criar um ciclo que constroi a estrutura dos dados para o carrinho

existe carrinho
imagem | titulo | quantidade | preço | (x)
imagem | titulo | quantidade | preço | (x)
imagem | titulo | quantidade | preço | (x)
                    total   | Sum()
                   
 - lista de produtos + quantidade + preço / unidade
 2x [nome produto] - preco unidade
 1x [nome produto] - preco unidade
- total da encomenda
dados de pagamento
numero da conta
codigo da encomenda
total- R$

*/
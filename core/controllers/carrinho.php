<?php

namespace core\controllers;

//indicação dos NAMESPACEs das minhas classes do CORE:
use core\classes\Database;
use core\classes\EnviarEmail;
use core\classes\Store;
use core\models\Clientes;
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
    public function endereco_alternativo()
    {
        //receber os dados via AJAX(axios)
        $post = json_decode(file_get_contents('php://input'), true);
        //adiciona ou altera na sessão a variável(array) dados_alternativos
        $_SESSION['dados_alternativos'] = [
            'endereco' => $post['text_endereco'],
            'cidade' => $post['text_cidade'],
            'telefone' => $post['text_telefone'],
            ];
    }
    //============================================================================
    public function confirmar_encomenda()
    {
        // Store::printData($_SESSION);
        //guardar na base de dados a encomenda
        //--------------------------------------------------------------------------
        

        //--------------------------------------------------------------------------
        //enviar email para o cliente com os dados da encomenda e pagamento
        //buscar os dados dos produtos 
        $ids = [];
        foreach($_SESSION['carrinho'] as $id_produto => $quantidade){
            array_push($ids, $id_produto);
        }
        $ids = implode(",", $ids);
        $produtos = new Produtos();
        $resultados = $produtos->buscar_produtos_por_ids($ids);

        //estrutura dos dados dos produtos
        $string_produtos = [];
        
        foreach($resultados as $resultado){
            //quantidade
            $quantidade = $_SESSION['carrinho'][$resultado->id_produto];
            //stringo do produto
            $string_produtos[] = "$quantidade x $resultado->nome_produto - ".'R$ '.number_format($resultado->preco,2,',','.'). '/unidade';
        }
        //lista de produtos para o email
        $dados_encomenda['lista_produtos'] = $string_produtos;
        
        //preço total da encomenda para o email
        $dados_encomenda['total'] = "R$ ".number_format($_SESSION['total_encomenda'],2,',','.');

        //dados de pagamento
        $dados_encomenda['dados_pagamento'] = [
            'numero_conta'=>'123456789',
            'codigo_encomenda'=>$_SESSION['codigo_encomenda'],
            'total'=>"R$ ".number_format($_SESSION['total_encomenda'],2,',','.')
        ];
        //envio do email (encomenda) para o USUARIO
        $email = new EnviarEmail();
        $resultado = $email->enviar_email_confirmacao_encomenda($_SESSION['usuario'],$dados_encomenda);
        die('Terminado!');
        //--------------------------------------------------------------------------

        //--------------------------------------------------------------------------
        //guardar estes dados para aparecer na pagina de agradecer a encomenda
        $codigo_encomenda = $_SESSION['codigo_encomenda'];
        $total_encomenda = $_SESSION['total_encomenda'];
        //--------------------------------------------------------------------------
        
        //--------------------------------------------------------------------------
        // Limpar todos os dados da encomenda que estão no carrinho
        //--------------------------------------------------------------------------
        
        //--------------------------------------------------------------------------
        //Apresenta a pagina agradecer a encomenda
        $dados = [
            'codigo_encomenda' => $codigo_encomenda,
            'total_encomenda' => $total_encomenda
        ];
        Store::Layout([
            'layouts/html_header', 'layouts/header',
            'encomenda_confirmada',
            'layouts/footer', 'layouts/html_footer'], $dados);
    }
}
/* passos a serem feitos
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
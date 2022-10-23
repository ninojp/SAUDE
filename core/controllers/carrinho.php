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
            $dados = ['carrinho'=>$dados_tmp];
        }

        //Apresenta a pagina da CARRINHO
        Store::Layout([
            'layouts/html_header', 'layouts/header',
            'carrinho',
            'layouts/footer', 'layouts/html_footer'], $dados);
    }
}
/* passos a serem feitos
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

*/
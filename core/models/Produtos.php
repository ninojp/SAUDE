<?php

namespace core\models;

use core\classes\Database;
use core\classes\Store;

class Produtos
{
    //==================================================================================
    public function lista_produtos_disponiveis($categoria)
    {
        //buscar todas as informações dos produtos na base de dados
        $bd = new Database();

        //buscar a lista de categorias de produtos
        $categorias = $this->listar_categorias();
        
        $sql = "SELECT * FROM produtos ";
        $sql .= "WHERE visivel = '1' ";

        if(in_array($categoria, $categorias)){
            $sql .= "AND categoria = '$categoria'";
        }

        $produtos = $bd->select($sql);
        return $produtos;
    }
    //==================================================================================
    public function listar_categorias()
    {
       //devolve a lista de categorias existente na base de dados
       $bd = new Database();
       $resultados = $bd->select("SELECT DISTINCT categoria FROM produtos");
       $categorias = [];
       foreach($resultados as $resultado){
            array_push($categorias, $resultado->categoria);

       }
       return $categorias;
    }
    //==================================================================================
    public function verificar_stock_produto($id_produto)
    {
        $bd = new Database();
        $parametros = [':id_produto' => $id_produto];
        $resultados = $bd->select("SELECT * FROM produtos WHERE id_produto=:id_produto AND visivel=1 AND stock > 0", $parametros);
        return count($resultados) != 0 ? true : false;
    }
    //==================================================================================
    public function buscar_produtos_por_ids($ids)
    {
        $bd = new Database();
        
        // $parametros = [':ids' => $ids];

        return $bd->select("SELECT * FROM produtos WHERE id_produto IN ($ids)");
    }
}
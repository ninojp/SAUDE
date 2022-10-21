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
}
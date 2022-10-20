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

        $sql = "SELECT * FROM produtos ";
        $sql .= "WHERE visivel = '1' ";

        if($categoria == 'masculina' || $categoria == 'feminina'){
            $sql .= "AND categoria = '$categoria'";
        }

        $produtos = $bd->select($sql);
        return $produtos;
    }
    //==================================================================================
    public function listar_categorias()
    {
        
    }
}
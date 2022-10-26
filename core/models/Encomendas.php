<?php

namespace core\models;

use core\classes\Database;
use core\classes\Store;

//====================================================================================
class Encomendas
{
    //================================================================================
    public function guardar_encomenda($dados_encomenda, $dados_produtos)
    {
        $bd = new Database();
        //guardar os dados da encomenda
        $parametros = [
            ':id_encomenda' => 
            ':id_cliente' => 
            ':data_encomenda' => 
            ':endereco' => 
            ':cidade' => 
            ':email' => 
            ':telefone' => 
            ':codigo_encomenda' => 
            ':status' => 
            ':mensagem' => 
            ':created_at' => 
            ':updated' => 
        ];

/*
 1.- guardar os dados da encomenda
 2.- buscar o id_encomenda criado
 3. -dados dos produtos da encomenda
*/
    }

}
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
        //------------------------------------------------------------------------------------------------
        //guardar os dados da encomenda
        $parametros = [
            ':id_cliente' => $_SESSION['cliente'],
            ':endereco' => $dados_encomenda['endereco'],
            ':cidade' => $dados_encomenda['cidade'],
            ':email' => $dados_encomenda['email'],
            ':telefone' => $dados_encomenda['telefone'],
            ':codigo_encomenda' => $dados_encomenda['codigo_encomenda'],
            ':estatos' => $dados_encomenda['estatos'],
            ':mensagem' => $dados_encomenda['mensagem']];
        $bd->insert("INSERT INTO encomendas VALUES(0, :id_cliente, NOW(), :endereco, :cidade, :email, :telefone, :codigo_encomenda, :estatos, :mensagem, NOW(), NOW())",$parametros);
        //buscar o id_encomenda
        $id_encomenda = $bd->select("SELECT MAX(id_encomenda) AS id_encomenda FROM encomendas")[0]->id_encomenda;

        //----------------------------------------------------------------------------------------------------
        //guardar os dados dos produtos da encomenda
        foreach($dados_produtos as $produto){
            $parametros = [
                ':id_encomenda' => $id_encomenda,
                ':designacao_produto' => $produto['designacao_produto'],
                ':preco_unidade' => $produto['preco_unidade'],
                ':quantidade' => $produto['quantidade']];
            $bd->insert("INSERT INTO encomenda_produto VALUES(0, id_encomenda, designacao_produto, preco_unidade, quantidade, NOW())",$parametros);
        }
/*
 1.- guardar os dados da encomenda
 2.- buscar o id_encomenda criado
 3. - guardar os dados dos produtos da encomenda
*/
    }

}
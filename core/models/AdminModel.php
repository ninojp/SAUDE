<?php

namespace core\models;

use core\classes\Database;
use core\classes\Store;

class AdminModel
{
    //==================================================================================
    public function validar_login($usuario_admin, $senha)
    {
        //verificar se o login é válido
        $parametros = [':usuario_admin' => $usuario_admin];

        $bd = new Database();
        $resultado = $bd->select("SELECT * FROM admins WHERE usuario=:usuario_admin AND deleted_at IS NULL", $parametros);

        if (count($resultado) != 1) {
            //não existe usuário
            return false;
        } else {
            //temos usuário admin. Vamos ver a sua senha
            $usuario_admin = $resultado[0];
            //verificar a senha
            if(!password_verify($senha, $usuario_admin->senha)){
                //senha inválida
                return false;
            } else {
                //login válido
                return $usuario_admin;
            }
        }
    }
    //==================================================================================
    //  CLIENTES
    //==================================================================================
    public function lista_cliente()
    {
        //vai buscar todos os clientes registrados na base de dados
        $bd = new Database();
        $resultado = $bd->select("SELECT clientes.id_cliente,clientes.email,clientes.nome_completo,clientes.telefone,clientes.activo,clientes.deleted_at, COUNT(encomendas.id_encomenda) AS total_encomenda FROM clientes LEFT JOIN encomendas ON clientes.id_cliente=encomendas.id_cliente GROUP BY clientes.id_cliente");
        return $resultado;
    }
    //===================================================================================
    public function buscar_cliente($id_cliente)
    {
        $parametros = ['id_cliente' => $id_cliente];

        $bd = new Database();
        $resultados = $bd->select("SELECT * FROM clientes WHERE id_cliente=:id_cliente", $parametros);
        return $resultados[0];
    }

    //==================================================================================
    // ENCOMENDAS    
    //==================================================================================
    public function total_encomenda_pendente()
    {
        //vai buscar a quantidade de encomendas PENDENTES
        $bd = new Database();
        $resultado = $bd->select("SELECT COUNT(*) AS total FROM encomendas WHERE status='PENDENTE' ");
        return $resultado[0]->total;
    }
    //==================================================================================
    public function total_encomenda_processamento()
    {
        //vai buscar a quantidade de encomendas EM PROCESSAMENTO
        $bd = new Database();
        $resultado = $bd->select("SELECT COUNT(*) AS total FROM encomendas WHERE status='PROCESSAMENTO' ");
        return $resultado[0]->total;
    
    }
    //==================================================================================
    //EU QUE CRIEI PARA TESTAR MAS AINDA NÃO FUNCIONOU
    public function total_encomenda_cancelada()
    {
        //vai buscar a quantidade de encomendas CANCELADAS
        $bd = new Database();
        $resultado = $bd->select("SELECT COUNT(*) AS total FROM encomendas WHERE status='CANCELADA' ");
        return $resultado[0]->total;
    
    }
    //==================================================================================
    public function lista_encomenda($filtro, $id_cliente)
    {
        $bd = new Database();
        $sql = "SELECT e.*, c.nome_completo FROM encomendas AS e LEFT JOIN clientes AS c ON e.id_cliente=c.id_cliente WHERE 1";
        if($filtro != ''){
            $sql .= " AND e.status = '$filtro'";
        }
        if(!empty($id_cliente)){
            $sql .= " AND e.id_cliente = '$id_cliente'";
        }
        $sql .= " ORDER BY e.id_encomenda DESC";
        return $bd->select($sql);
    }
    //==================================================================================
    public function total_encomenda_cliente($id_cliente)
    {
        //vai buscar o total de encomendas do cliente
        $parametros = [':id_cliente'=>$id_cliente];
        $bd = new Database();
        return $bd->select("SELECT COUNT(*) AS total FROM encomendas WHERE id_cliente=:id_cliente ",$parametros)[0]->total;
    }
    //==================================================================================
    public function buscar_encomendas_cliente($id_cliente)
    {
        //vai buscar todas as encomendas do cliente indicado
        $parametros = [':id_cliente'=>$id_cliente];
        $bd = new Database();
        return $bd->select("SELECT * FROM encomendas WHERE id_cliente=:id_cliente ",$parametros);
    }
    //==================================================================================
    public function buscar_detalhe_encomenda($id_encomenda)
    {
        //vai buscar os datalhes de uma encomenda
        $bd = new Database();
        $parametros = [':id_encomenda'=>$id_encomenda];
        
        //buscar os dados da encomenda
        $dados_encomenda = $bd->select("SELECT clientes.nome_completo, encomendas.* FROM clientes,encomendas WHERE encomendas.id_encomenda=:id_encomenda AND encomendas.id_cliente=clientes.id_cliente ",$parametros);
        
        //lista de produtos da encomenda
        $lista_produtos = $bd->select("SELECT * FROM encomenda_produto WHERE id_encomenda=:id_encomenda", $parametros);

        return ['encomenda'=>$dados_encomenda[0],
                'lista_produtos'=>$lista_produtos];
    }
    //==================================================================================
    public function atualizar_status_encomenda($id_encomenda, $estado)
    {
        //atualizar o estado da encomenda
        $bd = new Database();
        $parametros = [':id_encomenda'=>$id_encomenda, ':status'=>$estado];

        $bd->update("UPDATE encomendas SET status=:status, updated_at=NOW() WHERE id_encomenda=:id_encomenda ", $parametros);
    }

}
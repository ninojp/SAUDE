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
    public function lista_encomenda($filtro)
    {
        $bd = new Database();
        $sql = "SELECT e.*, c.nome_completo FROM encomendas AS e LEFT JOIN clientes AS c ON e.id_cliente=c.id_cliente";
        if($filtro != ''){
            $sql .= " WHERE e.status = '$filtro'";
        }
        $sql .= " ORDER BY e.id_encomenda DESC";
        return $bd->select($sql);
    }
}
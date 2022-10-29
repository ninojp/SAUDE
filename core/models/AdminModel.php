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
    public function total_encomendas_pendentes()
    {
        //vai buscar a quantidade de encomendas pendentes
        $bd = new Database();
        $resultado = $bd->select("SELECT COUNT(*) AS total FROM encomendas WHERE status='PENDENTE' ");
        return $resultado[0]->total;
    }

    //==================================================================================
    public function lista_encomendas_pendentes()
    {
        //vai buscar a lista de encomendas pendentes

        //EU MESMO QUE FIZ ESTA PARTE....
        //buscar o histórico de encomendas do cliente = id_cliente
    //  $parametros = [
    //         ':id_cliente'=>$id_cliente];

    //     $bd = new Database();
    //     $resultados = $bd->select("SELECT id_encomenda, data_encomenda, codigo_encomenda, status FROM encomendas WHERE id_cliente=:id_cliente AND status='PENDENTE' ORDER BY data_encomenda DESC",$parametros);
    //     return $resultados;
    }
}
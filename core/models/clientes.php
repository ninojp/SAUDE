<?php

namespace core\models;

use core\classes\Database;
use core\classes\Store;

class Clientes
{
    //===================================================================================
    public function verificar_email_existe($email)
    {
        //verifica se já existe outra conta com o mesmo email
        $bd = new Database();
        //garantir que será: mb_strtolower(letras em minúsculo) e trim(remover espaços)
        $parametros = [':e_mail' => mb_strtolower(trim($email))];
        //fazer uma consulta para saber se o email já existe
        $resultados = $bd->select("SELECT email FROM clientes WHERE email=:e_mail", $parametros);
        //se o email já existe, retorna para parte de cadastro.
        if (count($resultados) != 0) {
            return true;
        } else {
            return false;
        }
    }
    //===================================================================================
    public function registrar_cliente()
    {
        //registra um novo cliente na base de dados
        $bd = new Database();

        //cria uma hash para o registro do cliente
        $purl = Store::criarHash();

        //parametros
        $parametros = [
            ':email' => mb_strtolower(trim($_POST['text_email'])),
            ':senha' => password_hash(trim($_POST['text_senha_1']), PASSWORD_DEFAULT),
            ':nome_completo' => trim($_POST['text_nome_completo']),
            ':endereco' => trim($_POST['text_endereco']),
            ':cidade' => trim($_POST['text_cidade']),
            ':telefone' => trim($_POST['text_telefone']),
            ':purl' => $purl,
            ':ativo' => 0
        ];

        $bd->insert("INSERT INTO clientes VALUES(0,:email,:senha,:nome_completo,:endereco,:cidade,:telefone,:purl,:ativo,NOW(),NOW(),NULL)", $parametros);

        //retorna o purl criado
        return $purl;
    }
    //===================================================================================
    public function validar_email($purl)
    {

        //validar o email do novo cliente
        $bd = new Database();
        $parametros = [
            ':purl' => $purl
        ];
        $resultados = $bd->select("SELECT * FROM clientes WHERE purl=:purl", $parametros);

        //verifica se foi encontrado o cliente
        if (count($resultados) != 1) {
            return false;
        }
        //foi encontrado este cliente com o purl indicado 
        $id_cliente = $resultados[0]->id_cliente;

        //atualizar os dados do cliente
        $parametros = [':id_cliente' => $id_cliente];
        $bd->update("UPDATE clientes SET purl=NULL, activo=1, updated_at=NOW() WHERE id_cliente=:id_cliente", $parametros);
        return true;
    }
    //===================================================================================
    public function validar_login($usuario, $senha)
    {
        //verificar se o login é válido
        $parametros = [':usuario' => $usuario];

        $bd = new Database();
        $resultado = $bd->select("SELECT * FROM clientes WHERE email=:usuario AND activo=1 AND deleted_at IS NULL", $parametros);

        if (count($resultado) != 1) {
            //não existe usuário
            return false;
        } else {
            //temos usuário. Vamos ver a sua senha
            $usuario = $resultado[0];
            //verificar a senha
            if(!password_verify($senha, $usuario->senha)){
                //senha inválida
                return false;
            } else {
                //login válido
                return $usuario;
            }
        }
    }
    //===================================================================================
    public function buscar_dados_cliente($id_cliente)
    {
        $parametros = ['id_cliente' => $id_cliente];

        $bd = new Database();
        $resultados = $bd->select("SELECT email, nome_completo, endereco, cidade, telefone FROM clientes WHERE id_cliente=:id_cliente", $parametros);
        return $resultados[0];
    }
    //===================================================================================
    public function verificar_email_existe_outra_conta($id_cliente, $email)
    {
        //verificar se existe a conta de email em outra conta de cliente
        $parametros = [
            ':email'=>$email,
            ':id_cliente'=>$id_cliente
        ];
        $bd = new Database();
        $resultados = $bd->select("SELECT id_cliente FROM clientes WHERE id_cliente <> :id_cliente AND email=:email",$parametros);
        if(count($resultados) != 0){
            return true;
        } else {
            return false;
        }
    }
    //===================================================================================
    public function atualizar_dados_cliente($email, $nome_completo, $endereco, $cidade, $telefone)
    {
        //atualize os dados do cliente na base de dados
        $parametros = [
            ':email'=>$email,
            ':nome_completo'=>$nome_completo,
            ':endereco'=>$endereco,
            ':cidade'=>$cidade,
            ':telefone'=>$telefone
        ];
        $bd=new Database();
        $bd->update("",$parametros);
    }
}

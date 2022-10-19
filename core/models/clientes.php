<?php
namespace core\models;

use core\classes\Database;
use core\classes\Store;

class Clientes{
    //===================================================================================
    public function verificar_email_existe($email){
        //verifica se já existe outra conta com o mesmo email
        $bd = new Database();
        //garantir que será: mb_strtolower(letras em minúsculo) e trim(remover espaços)
        $parametros = [':e_mail'=>mb_strtolower(trim($email))];
        //fazer uma consulta para saber se o email já existe
        $resultados = $bd->select("SELECT email FROM clientes WHERE email=:e_mail", $parametros);
        //se o email já existe, retorna para parte de cadastro.
        if(count($resultados) != 0){
           return true; 
        }else{
            return false;
        }
    }
    //===================================================================================
    public function registrar_cliente(){
        //registra um novo cliente na base de dados
        $bd= new Database();
        
        //cria uma hash para o registro do cliente
        $purl=Store::criarHash();

        //parametros
        $parametros = [':email'=>mb_strtolower(trim($_POST['text_email'])),
                    ':senha'=>password_hash(trim($_POST['text_senha_1']),PASSWORD_DEFAULT),
                    ':nome_completo'=>trim($_POST['text_nome_completo']),
                    ':endereco'=>trim($_POST['text_endereco']),
                    ':cidade'=>trim($_POST['text_cidade']),
                    ':telefone'=>trim($_POST['text_telefone']),
                    ':purl'=>$purl,
                    ':ativo'=>0 ];

        $bd->insert("INSERT INTO clientes VALUES(0,:email,:senha,:nome_completo,:endereco,:cidade,:telefone,:purl,:ativo,NOW(),NOW(),NULL)", $parametros);

        //retorna o purl criado
        return $purl;
    }
}
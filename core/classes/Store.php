<?php

namespace core\classes;

use Exception;

class Store
{
    //=================================================================================
    public static function Layout($estruturas, $dados = null)
    {
        //verifica se estruturas é um array
        if (!is_array($estruturas)) {
            throw new Exception("coleção de estruturas inválida!");
        }
        //variáveis
        if (!empty($dados) && is_array($dados)) {
            extract($dados);
        }

        //apresentar as views da aplicação
        foreach ($estruturas as $estrutura) {
            include("../core/views/$estrutura.php");
        }
    }
    //=================================================================================
    public static function Layout_admin($estruturas, $dados = null)
    {
        //verifica se estruturas é um array
        if (!is_array($estruturas)) {
            throw new Exception("coleção de estruturas inválida!");
        }
        //variáveis
        if (!empty($dados) && is_array($dados)) {
            extract($dados);
        }

        //apresentar as views da aplicação
        foreach ($estruturas as $estrutura) {
            include("../../core/views/$estrutura.php");
        }
    }
    //=================================================================================
    public static function clienteLogado()
    {
        //verifica se existe um cliente com sessão(logado)
        return isset($_SESSION['cliente']);
    }
    //=================================================================================
    public static function adminLogado()
    {
        //verifica se existe um admin na sessão(logado)
        return isset($_SESSION['admin']);
    }
    //=================================================================================
    public static function criarHash($num_caracteres = 12)
    {
        //criar hashes
        $chars = '0123456789abcdefghijklmnopqrstuvxwyzabcdefghijklmnopqrstuvxwyzABCDEFGHIJKLMNOPQRSTUVXWYZABCDEFGHIJKLMNOPQRSTUVXWYZ';
        return substr(str_shuffle($chars), 0, $num_caracteres);
    }
    //=================================================================================
    public static function gerarCodigoEncomenda()
    {
        //Gerar um código para a encomenda - A Z / 100000 999999
        $codigo = "";
        $chars2 = 'ABCDEFGHIJKLMNOPQRSTUVXWYZABCDEFGHIJKLMNOPQRSTUVXWYZABCDEFGHIJKLMNOPQRSTUVXWYZ';
        $codigo .= substr(str_shuffle($chars2),0,2);
        $codigo .= rand(100000,999999);
        return $codigo;
    }
    //=================================================================================
    public static function redirect($rota = '', $admin=false)
    {
        //faz o redirecionamento para a url desejada(rota)
        if(!$admin){
            header("Location: " . BASE_URL . "?a=$rota");
        } else {
            header("Location: " . BASE_URL . "/admin?a=$rota");
        }
        
    }
    //=================================================================================
    public static function printData($data, $die=true)
    {
        if(is_array($data) || is_object($data)){
            echo '<pre>';
            print_r($data);
        } else {
            echo'<pre>';
            echo $data;
        }
        if($die){
            die('<br>Terminado!');
        }
        
    }
    //=================================================================================
    //  ENCRIPTAR
    //=================================================================================
    public static function aesEcncriptar($valor)
    {
        //faz a encriptação do $valor passado na variavel.
        return bin2hex(openssl_encrypt($valor, 'aes-256-cbc', AES_KEY, OPENSSL_RAW_DATA, AES_IV));
    }
    //=================================================================================
    public static function aesDesencriptar($valor)
    {
        //faz a Desencriptação do $valor passado na variavel
        return openssl_decrypt(hex2bin($valor),'aes-256-cbc', AES_KEY, OPENSSL_RAW_DATA, AES_IV);
    }
}   

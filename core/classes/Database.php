<?php
namespace core\classes;

use Exception;
use PDO;
use PDOException;

class Database {
    //gestão de bases de dados
    private $ligacao;
    //===============================================================
    private function ligar(){
        //Ligar à base de dados
        $this->ligacao = new PDO(
            'mysql:'.
            'host='.MYSQL_SERVER.';'.
            'dbname='.MYSQL_DATABASE.';'.
            'charset='.MYSQL_CHARSET,
            MYSQL_USER,
            MYSQL_PASS,
            array(PDO::ATTR_PERSISTENT => true)
        );
        //Debug
        $this->ligacao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }
    //===============================================================
    private function desligar(){
        //Desligar-se da base de dados
        $this->ligacao = null;
    }
    //===============================================================
    //CRUD
    //===============================================================
    public function select($sql, $parametros = null){
        //se necessário for, trim(para remover espaços) de qualquer instrução do CRUD
        $sql = trim($sql);

        //Verifica se é uma instrução SELECT
        //a função preg_match("verifica uma expressão regular")
        if(!preg_match("/^SELECT/i", $sql)){
            throw new Exception('Base de dados - Não é uma instrução SELECT.');
            //poderia fazer assim para não apresentar os detalhes do ERRO!
            // die('Base de dados - Não é uma instrução SELECT.');
        }
        //Liga ao DB
        $this->ligar();

        $resultados = null;

        //Cumunica
        try {
            //comunicação com o db
            if (!empty($parametros)){
                $executar = $this->ligacao->prepare($sql);
                $executar->execute($parametros);
                $resultados = $executar->fetchAll(PDO::FETCH_CLASS);
            } else {
                $executar = $this->ligacao->prepare($sql);
                $executar->execute();
                $resultados = $executar->fetchAll(PDO::FETCH_CLASS);
            }

        } catch (PDOException $e) {
            //caso exista erro
            return false;
        }

        //Desliga da db
        $this->desligar();

        //Devolve o resultados obtidos
        return $resultados;
    }
    //===============================================================
    public function insert($sql, $parametros = null){
        //se necessário for, trim(para remover espaços) de qualquer instrução do CRUD
        $sql = trim($sql);
        //Verifica se é uma instrução do tipo INSERT
        if(!preg_match("/^INSERT/i", $sql)){
            throw new Exception('Base de dados - Não é uma instrução INSERT!');
        }

        //Ligar
        $this->ligar();

        //Cumunica
        try {
            //comunicação com o db
            if (!empty($parametros)){
                $executar = $this->ligacao->prepare($sql);
                $executar->execute($parametros);
            } else {
                $executar = $this->ligacao->prepare($sql);
                $executar->execute();
            }

        } catch (PDOException $e) {
            //caso exista erro
            return false;
        }

        //Desliga da db
        $this->desligar();
    }
    //===============================================================
    public function update($sql, $parametros = null){
        //se necessário for, trim(para remover espaços) de qualquer instrução do CRUD
        $sql = trim($sql);
        //Verifica se é uma instrução do tipo UPDATE
        if(!preg_match("/^UPDATE/i", $sql)){
            throw new Exception('Base de dados - Não é uma instrução UPDATE!');
        }
        //Ligar
        $this->ligar();
        //Cumunica
        try {
            //comunicação com o db
            if (!empty($parametros)){
                $executar = $this->ligacao->prepare($sql);
                $executar->execute($parametros);
            } else {
                $executar = $this->ligacao->prepare($sql);
                $executar->execute();
            }

        } catch (PDOException $e) {
            //caso exista erro
            return false;
        }
        //Desliga da db
        $this->desligar();
    }
    //===============================================================
    public function delete($sql, $parametros = null){
        //se necessário for, trim(para remover espaços) de qualquer instrução do CRUD
        $sql = trim($sql);
        //Verifica se é uma instrução do tipo DELETE
        if(!preg_match("/^DELETE/i", $sql)){
            throw new Exception('Base de dados - Não é uma instrução DELETE!');
        }
        //Ligar
        $this->ligar();
        //Cumunica
        try {
            //comunicação com o db
            if (!empty($parametros)){
                $executar = $this->ligacao->prepare($sql);
                $executar->execute($parametros);
            } else {
                $executar = $this->ligacao->prepare($sql);
                $executar->execute();
            }

        } catch (PDOException $e) {
            //caso exista erro
            return false;
        }
        //Desliga da db
        $this->desligar();
    }
    //===============================================================
    //GENÉRICA - Verificar e executar as outras instruções ()
    //===============================================================
    public function statement($sql, $parametros = null){
        //se necessário for, trim(para remover espaços) de qualquer instrução do CRUD
        $sql = trim($sql);
        //Verifica se é uma instrução diferente das anteriores(CRUD)
        if(preg_match("/^(SELECT|INSERT|UPDATE|DELETE)/i", $sql)){
            throw new Exception('Base de dados - Instrução INVÁLIDA!');
        }
        //Ligar
        $this->ligar();
        //Cumunica
        try {
            //comunicação com o db
            if (!empty($parametros)){
                $executar = $this->ligacao->prepare($sql);
                $executar->execute($parametros);
            } else {
                $executar = $this->ligacao->prepare($sql);
                $executar->execute();
            }

        } catch (PDOException $e) {
            //caso exista erro
            return false;
        }
        //Desliga da db
        $this->desligar();
    }

}
//==========================================================================================
/* 1.Ligar - 2.Comunicar - 3.Fechar
CRUD
Creat - INSERT
Read - SELECT
Update - UPDATE
Delete - DELETE
define('MYSQL_SERVER', 'localhost');
define('MYSQL_DATABASE', 'db_saude');
define('MYSQL_USER', '');
define('MYSQL_PASS', '');
define('MYSQL_CHARSET', 'utf8');
*/
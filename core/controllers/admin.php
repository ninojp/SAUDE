<?php

namespace core\controllers;

//indicação dos NAMESPACEs das minhas classes do CORE:
use core\classes\Database;
use core\classes\EnviarEmail;
use core\classes\Store;

class Admin
{
    //======================================================================================
    public function index()
    {
        //classe para criar o Layout() basico no index
        Store::Layout([
            'admin/layouts/html_header',
            'admin/layouts/header',
            'admin/home',
            'admin/layouts/footer',
            'admin/layouts/html_footer'
        ]);
    }
    //======================================================================================
    public function lista_clientes()
    {
        echo 'Lista de Clientes';
    }

}   
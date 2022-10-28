<?php
//Abrir a sessão
session_start();

//Carrega todas as classes do projeto, através do autoload do COMPOSER
require_once ('../../vendor/autoload.php');

//Carrega o sistema de ROTAS
require_once('../../core/rotas_admin.php');



/****************************************************************************************
 * Página index do meu BackOffice
****************************************************************************************/
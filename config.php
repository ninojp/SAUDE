<?php
/* Terá as configurações básicas da aplicação, as definições das CONSTANTES */
define('APP_NAME', 'SAÚDE');
define('APP_VERSION', '0.1.0');
//URL atual do meu site
define('BASE_URL','https://localhost/SAUDE/public/');

// Status das encomendas
define('STATUS',  ['PENDENTE','PROCESSAMENTO','CANCELADA','ENVIADA','CONCLUIDA']);

//MYSQL
define('MYSQL_SERVER', 'localhost');
define('MYSQL_DATABASE', 'db_saude');
define('MYSQL_USER', 'NinoJP');
define('MYSQL_PASS', 'chNd@w40_(rWpyQC');
define('MYSQL_CHARSET', 'utf8');

//AES Encriptação
define('AES_KEY', 'HhEvhIr3VJ7s9IO23LhcG6F1g4dmNVoI');
define('AES_IV', '7ttgXvsnIE9K8Tys');

//autentificação do EMAIL google
define('MAIL_HOST', 'smtp.gmail.com');
define('MAIL_FROM', 'meuemailparablog@gmail.com');
define('MAIL_PASS', 'dnixpmkkzyyysodx');
define('MAIL_PORT', '587');

//PDFs
define('PDF_PATH', "C:/xampp/htdocs/SAUDE/temp_pdf/");

//=================================================================================================
// USUARIOS ATUAIS
// admin@admin.com          -> admin        -> 123456 (acho eu)
// meu.sem@gmail.com        -> Edenilson JP -> 123456
// teste@sem.com            -> semnome      -> 123
// teste2@sem.com           -> teste nome   -> 123
// ninocriptocoin@gmail.com -> Nino JP      -> 123456
//=================================================================================================
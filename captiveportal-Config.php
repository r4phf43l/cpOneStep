<?php

/**
 * @author Rafael Antonio / https://github.com/r4phf43l
 */

// DATABASE SETTINGS
DEFINE("DBHOST", "localhost");
DEFINE("DBUSER", "rafacom_user");
DEFINE("DBPASS", "R4phf43l2k20#");
DEFINE("DBSCHM", "rafacom_cpos");

//FREERADIUS SETTINGS
DEFINE("FRGROUP", "Free");

//CAPTIVEPORTAL SETTINGS
DEFINE("CPLANG", "pt-br");
DEFINE("CPDEBUG", true); //DEBUG MODE

global $ct, $errormessage;

$ct = [
    'brand' => 'Your brand here',
    'titlestring' => 'Title page here',
    'description' => 'Meta Description here',    
    'companySite' => 'yoursite.com'    
];

$l = [
    'en' => [        
        'termsOfUse_string' => 'Terms of Use',
        'termsOfUseRead_string' => 'I read',
        'generalUseMessage_string' => 'This is a free service, please respect the terms of use and the others users.',
        'welcome_string' => 'Here you have a free internet access.',
        'error_string' => 'Error',
        'termsOfUseAccept_string' => 'I accept the ',
        'connect_string' => 'Connect',
        'newsletter_string' => 'Subscribe in our newsletter',
        'welcomeMessage_string' => 'You need just a few clicks to enjoy',
        'month' => [ 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' ],
        'today' => '%m% ' . date('j') . ', ' . date('Y'),
        'login_message' => 'If you are not redirect, please click on the button above',
        'continue_button' => 'Continue',
        'fieldrequired' => 'Field Required: ',
        'genericerror' => 'Some error has be found, try again in a few minutes.<br>Sorry for the inconvenience'
    ],
    'pt-br' => [        
        'termsOfUse_string' => 'Termos de Uso',
        'termsOfUseRead_string' => 'Eu li',
        'generalUseMessage_string' => 'Este é serviço um gratuíto, por favor respeite os termos de uso e os outros usuários.',
        'welcome_string' => 'Aqui você tem acesso grátis à internet.',
        'error_string' => 'Erro',
        'termsOfUseAccept_string' => 'Eu aceito os ',
        'connect_string' => 'Conectar',
        'newsletter_string' => 'Assine nossa newsletter',
        'welcomeMessage_string' => 'Basta alguns cliques para você aproveitar.',
        'month' => [ 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro' ],
        'today' => date('j') . ' de %m% de ' . date('Y'),
        'login_message' => 'Se você não for redirecionado, clique no botão abaixo',
        'continue_button' => 'Continuar',
        'fieldrequired' => 'Campo Obrigatório: ',
        'genericerror' => 'Algo deu errado, tente novamente em alguns minutos.<br>Desculpe pela inconveniência'
    ]
];

function validateCpf($v)
{ //validates Brasilian Social ID
    $f = preg_replace( '/[^0-9]/is', '', $v );     
    if (strlen($f) != 11) { return false; }
    if (preg_match('/(\d)\1{10}/', $f)) { return false; }
    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) { $d += $f{$c} * (($t + 1) - $c); }
        $d = ((10 * $d) % 11) % 10;
        if ($f{$c} != $d) { return false; }
    }
    return true;
}

function validateFields($fd) {
    foreach ($fd as $k => $v) {
        if ($v==null) {
            throw new Exception($k);
        }
    }
    return true;
}
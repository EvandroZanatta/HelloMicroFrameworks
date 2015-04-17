<?php

header('Content-Type: text/html; charset=utf-8');

require 'vendor/medoo/medoo.min.php';
require 'vendor/autoload.php';


$app = new \Slim\Slim(array(
    'debug' => true
));

$gump = new GUMP();

function validaEntrada($name){
    $data = array(
        'nome' => $name
    );
    
    $validated = GUMP::is_valid($data, array(
        'nome' => 'required|valid_name'
    ));
    
    if($validated === true) {
        return true;
    } else {
        return false;
    }    
}


$app->get('/hello/:name', function ($name) {
    if(validaEntrada($name)){
        echo "Hello, " . utf8_decode($name);    
    }else{
        echo utf8_decode("Você deve ser um humano para usar este site");
    }
    
});

$app->run();
?>
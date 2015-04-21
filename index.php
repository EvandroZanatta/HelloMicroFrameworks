<?php

header('Content-Type: text/html; charset=utf-8');

require_once 'vendor/medoo/medoo.min.php';
require 'vendor/autoload.php';

$app = new \Slim\Slim(array(
    'debug' => true
));

$gump = new GUMP();


function connectDB(){
    $database = new medoo([
    	'database_type' => 'mysql',
    	'database_name' => 'c9',
    	'server' => '0.0.0.0',
    	'username' => 'evandrozanatta',
    	'password' => '',
    	'charset' => 'utf8'
	]);
	
	return $database;
}

function validInput($name){
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

function addUser($name){
    
    $database = connectDB();
    
    $count = $database->count("users", [
    	"name" => $name
    ]);
    
    if($count > 0){
        return false;
    }
    
    $database->insert("users", [
    	"name" => $name
    ]);
    
    return true;

}

$app->get('/hello/:name', function ($name) {
    if(validInput($name)){
        
        if(addUser($name)){
            echo "Ola, " . utf8_decode($name);        
        }else{
            echo utf8_decode("Usuário já cadastrado!");
        }
        
    }else{
        echo utf8_decode("Você deve ser um humano para usar este site");
    }
    
});

$app->run();
?>
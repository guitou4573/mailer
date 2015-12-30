<?php

$env = $app->detectEnvironment(function(){
    $environmentPath = __DIR__.'/..';
    
    if (file_exists($environmentPath . "/.env"))
    {
        $dotenv = new Dotenv\Dotenv($environmentPath);
        $dotenv->load();
        if (getenv('APP_ENV') && file_exists(__DIR__.'/../.' .getenv('APP_ENV') .'.env')) {
            $dotenv = new Dotenv\Dotenv(__DIR__ . '/../', '.' . getenv('APP_ENV') . '.env');
            $dotenv->load();
        }
    }
});
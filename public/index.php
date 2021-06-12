<?php

require "vendor/autoload.php";

use \Light\Framework\Router;

function callback() {
    echo 'in callback';
}

Router::addDirectory("light/index.php");

Router::Get("/", 'callback');

Router::Get("/home", function () {
    echo "home";
});

Router::Run();
<?php

require 'Framework/Router.php';


function callback() {
    echo 'in callback';
}

Router::addDirectory("phprouter/index.php");

Router::Get("/", 'callback');
Router::Get('/index/{name}/info/{id}', function ($name, $id) {
    echo "Name: " . $name . " ID: " . $id;
});
Router::Get("/bree", function () {
    echo "is the best";
});

Router::Run();
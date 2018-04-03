<?php
require("../node_modules/php-require/index.php");

$app = $require("../");

$app->get('/hello/:name', function ($name) {
    echo "Hello, $name";
});

$app->run();

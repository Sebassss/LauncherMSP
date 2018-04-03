# php-slim

This is a [php-require](https://github.com/ricallinson/php-require) module which packages the [Slim](https://github.com/mustangostang/spyc) micro framework.

    <?php
    require("../node_modules/php-require/index.php");

    $app = $require("php-slim");

    $app->get('/hello/:name', function ($name) {
        echo "Hello, $name";
    });

    $app->run();

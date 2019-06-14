<?php
require_once __DIR__. "/../vendor/autoload.php";

use ShegunBabs\Remita\Remita;

function test_init()
{

    $remita = new Remita('27768931', 'Q1dHREVNTzEyMzR8Q1dHREVNTw==', 'SGlQekNzMEdMbjhlRUZsUzJCWk5saDB6SU14Zk15djR4WmkxaUpDTll6bGIxRCs4UkVvaGhnPT0=');

    return $remita->makeCall->getSalaryHistory('08188697770', '1aaa11abcde');
}


dump(test_init());
<?php

namespace ShegunBabs\Remita;

use ShegunBabs\Remita\Init\Boot;

class Remita
{

    public $merchant_id;
    public $api_key;
    public $api_token;
    public $authorization;

    public function __construct($merchant_id, $api_key, $api_token)
    {
        $this->merchant_id = $merchant_id;
        $this->api_key = $api_key;
        $this->api_token = $api_token;
    }


    public function __get($name)
    {
        return new Boot($name, $this);
    }
}
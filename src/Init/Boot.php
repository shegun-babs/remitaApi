<?php
/**
 * Created by PhpStorm.
 * User: shegun
 * Date: 6/13/2019
 * Time: 5:54 PM
 */

namespace ShegunBabs\Remita\Init;


class Boot
{
    private $component_name;
    private $master_object;

    /**
     * Boot constructor.
     * @param $name
     * @param $obj
     */
    public function __construct($name, $obj)
    {

        $this->component_name = $name;
        $this->master_object = $obj;
    }


    public function __call($name, $arguments)
    {
        $componentNamespace = "ShegunBabs\\Remita\\Components\\";
        $componentName = $this->component_name;
        $methodName = $name;
        $arguments = $arguments;

        $merchant_id = $this->master_object->merchant_id;
        $api_key = $this->master_object->api_key;
        $api_token = $this->master_object->api_token;
        $authorization = $this->master_object->authorization;

        $fullClass = $componentNamespace.ucfirst($this->component_name);
        $calledObject = call_user_func_array(
            [$fullClass, 'withConfig'],
            [$merchant_id, $api_key, $api_token, $authorization]
            );

        return call_user_func_array([$calledObject, $methodName], $arguments);


        return [
            'method' => $name,
            'method_arguments' => $arguments,
            'component_name' => $this->component_name,
            'master_object' => $this->master_object,
        ];
    }
}
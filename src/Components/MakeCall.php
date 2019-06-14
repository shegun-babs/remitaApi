<?php
/**
 * Created by PhpStorm.
 * User: shegun
 * Date: 6/13/2019
 * Time: 6:04 PM
 */

namespace ShegunBabs\Remita\Components;

use ShegunBabs\Remita\HttpQuery;

class MakeCall extends HttpQuery
{

    public function getSalaryHistory($mobile, $authCode)
    {
        $url = 'loansvc/data/api/v2/payday/salary/history/ph';
        $params = ['phoneNumber' => $mobile, 'authorisationCode'=> $authCode, 'authorizationChannel' => 'USSD'];
        return $this->params($params)->post($url);
    }
}
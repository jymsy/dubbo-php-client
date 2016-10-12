<?php

require_once "../src/dubboClient.php";

use \dubbo\dubboClient;

$options = array(
    "registry_address" => "192.168.1.198:2181"
);

$dubboCli = new dubboClient($options);
$testService = $dubboCli->getService('demo.service.api.order.OrderService%24Iface', 'OrderService');
//$ret = $testService->ping("dubbo php client");
//$ret = $testService->callFunc('hello');
$ret = $testService->callFunc('getOrder', [1]);
var_dump($ret);


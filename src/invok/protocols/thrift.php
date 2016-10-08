<?php
namespace dubbo\invok\protocols;
require_once dirname(dirname(__FILE__)) . "/invoker.php";

use \dubbo\invok\Invoker;

class thrift extends Invoker
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function callRPC($name, $params)
    {

    }

    protected function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
    }

    protected function formatResponse($response)
    {
        return $response;
    }
}
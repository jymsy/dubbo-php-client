<?php
namespace dubbo\invok\protocols;
require_once dirname(__DIR__) . "/invoker.php";
require_once __DIR__ . '/Thrift_lib/Thrift/ClassLoader/ThriftClassLoader.php';

use \dubbo\invok\Invoker;
use Thrift\ClassLoader\ThriftClassLoader;
use Thrift\Protocol\TCompactProtocol;
use Thrift\Transport\TSocket;
use Thrift\Transport\TFramedTransport;
//use demo\service\api\order\OrderServiceClient;


class thrift extends Invoker
{
    const GEN_DIR = __DIR__ . '/services';
    protected $transport;
    protected $serviceNamespace;
    protected $client;

    public function __construct($service)
    {
        parent::__construct();
        $this->service = $service;
        $this->serviceNamespace = 'ThriftService\\'.$service;
        $loader = new ThriftClassLoader();
        $loader->registerNamespace('Thrift', __DIR__ . '/Thrift_lib');
        $loader->registerDefinition($this->serviceNamespace, self::GEN_DIR);
        $loader->register();
    }

    protected function init()
    {
        list($host, $port) = explode(':', $this->url);
        $socket = new TSocket($host, $port);
        $socket->setSendTimeout(5 * 1000);
        $socket->setRecvTimeout(5 * 1000);

        $this->transport = new TFramedTransport($socket, 1024, 1024);
        $protocol = new TCompactProtocol($this->transport);
        $class = $this->serviceNamespace .'\\' . $this->service . 'Client';
        $this->client = new $class($protocol);
        $this->transport->open();

        $this->initialized = true;
    }

    protected function callRPC($name, $params)
    {
        $str = call_user_func_array(array($this->client, $name), $params);
        return $str;
    }

    protected function formatResponse($response)
    {
        return $response;
    }


    protected function close()
    {
        $this->transport->close();
    }
}
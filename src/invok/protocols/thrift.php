<?php
namespace dubbo\invok\protocols;
require_once dirname(__DIR__) . "/invoker.php";
require_once __DIR__ . '/Thrift_lib/Thrift/ClassLoader/ThriftClassLoader.php';
require_once __DIR__ . '/gen-php/Types.php';
require_once __DIR__ . '/gen-php/OrderService.php';

use \dubbo\invok\Invoker;
use Thrift\ClassLoader\ThriftClassLoader;
use Thrift\Protocol\TCompactProtocol;
use Thrift\Transport\TSocket;
use Thrift\Transport\TFramedTransport;


class thrift extends Invoker
{
    const GEN_DIR = __DIR__ . '/gen-php';
    protected $transport;

    public function __construct()
    {
        parent::__construct();
        $loader = new ThriftClassLoader();
        $loader->registerNamespace('Thrift', __DIR__ . '/Thrift_lib');
        $loader->registerDefinition('demo\service\api\order', self::GEN_DIR);
        $loader->register();
    }

    protected function callRPC($name, $params)
    {
        var_dump($this->url);
        list($host, $port) = explode(':', $this->url);
        $socket = new TSocket($host, $port);
        $socket->setSendTimeout(5 * 1000);
        $socket->setRecvTimeout(5 * 1000);

        $this->transport = new TFramedTransport($socket, 1024, 1024);
        $protocol = new TCompactProtocol($this->transport);
        $client = new \demo\service\api\order\OrderServiceClient($protocol);

        $this->transport->open();
        $str = call_user_func_array(array($client, $name), $params);
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
<?php
namespace dubbo;
require_once "register.php";
require_once "invok/invokerDesc.php";
//require_once "invok/protocols/jsonrpc.php";
use \dubbo\invok\invokerDesc;

class dubboClient
{
    protected $register;
    protected $loadedProtocols = array();

    public function __construct($options = array())
    {
        $this->register = new Register($options);
    }

    /**
     * @param $serviceName
     * @param $version
     * @param $group
     * @param string $protocol
     * @return invok\Invoker
     */
    public function getService($serviceName, $protocol = "thrift")
    {
        $invokerDesc = new InvokerDesc($serviceName);
        $invoker = $this->register->getInvoker($invokerDesc);
        if (!$invoker) {
            $invoker = $this->getInvokerByProtocol($protocol);
            $this->register->register($invokerDesc, $invoker);
        }
        return $invoker;
    }

    public function getInvokerByProtocol($protocol)
    {

        if (!in_array($protocol, $this->loadedProtocols)) {
            $file = __DIR__ . '/invok/protocols/' . $protocol . '.php';
            if (file_exists($file)) {
                array_push($this->loadedProtocols, $protocol);
                require_once($file);
            }
        }

        if (class_exists("dubbo\\invok\\protocols\\$protocol")) {
            $className = "\\dubbo\\invok\\protocols\\$protocol";
            return new $className();
        } else {
            throw new \Exception("can't match the class according to this protocol $protocol");
        }
    }

}

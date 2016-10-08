<?php
namespace dubbo;
require_once "register.php";
require_once "invok/invokerDesc.php";
//require_once "invok/protocols/jsonrpc.php";
use \dubbo\invok\invokerDesc;

class dubboClient
{
    protected $register;
    protected $loadedProtocols;

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
    public function getService($serviceName, $version, $group, $protocol = "jsonrpc")
    {
        $invokerDesc = new InvokerDesc($serviceName, $version, $group);
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
            if (file_exists("invok/protocols/$protocol.php")) {
                array_push($this->loadedProtocols, $protocol);
                require_once "invok/protocols/$protocol.php";
            }


//            foreach (glob("invok/protocols/*.php") as $filename) {
//                $protoName = basename($filename, ".php");
//                array_push($this->loadedProtocols, $protoName);
//                require_once $filename;
//            }
        }

        if (class_exists("dubbo\\invok\\protocols\\$protocol")) {
//            $class = new \ReflectionClass("dubbo\\invok\\protocols\\$protocol");
//            $invoker = $class->newInstanceArgs(array());
            $className = "\\dubbo\\invok\\protocols\\$protocol";
//            return $invoker;
            return new $className();
        } else {
            throw new \Exception("can't match the class according to this protocol $protocol");
        }
    }

}

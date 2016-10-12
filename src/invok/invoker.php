<?php
namespace dubbo\invok;

abstract class Invoker
{
    protected $invokerDesc;
    protected $url;
    protected $id;
    protected $debug;
    protected $notification = false;
    protected $cluster;
    protected $service;
    protected $initialized = false;

    public function __construct($url = null, $debug = false)
    {
        // server URL
        $this->url = $url;
        $this->id = 1;
        $this->debug;
        $this->cluster = Cluster::getInstance();
    }

    public function getCluster()
    {
        return $this->cluster;
    }

    public function setHost($url)
    {
        $this->url = $url;
    }

    public function setDesc($invokerDesc)
    {
        $this->invokerDesc = $invokerDesc;
    }

    public function toString()
    {
        return __CLASS__;
    }

    public function callFunc($name, $params = array())
    {
        if (!is_string($name)) {
            throw new \Exception('Method name should be a string');
        }
        if (is_array($params)) {
            // no keys
            $params = array_values($params);
        } else {
            throw new \Exception('Params must be given as array');
        }

        if (!$this->initialized) {
            $this->init();
        }

        $response = $this->callRPC($name, $params);
        $result = $this->formatResponse($response);
        return $result;
    }

    public function __destruct()
    {
        $this->close();
    }

    abstract protected function init();
    abstract protected function close();
    abstract protected function callRPC($name, $params);
    abstract protected function formatResponse($response);
//    abstract protected function __call($name, $arguments);
}


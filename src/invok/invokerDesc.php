<?php
namespace dubbo\invok;

class invokerDesc
{
    private $serviceName = " ";
    private $group = " ";
    private $version = " ";
    private $schema = '';

    public function __construct($serviceName)
    {
        $this->serviceName = $serviceName;
    }

    public function getService()
    {
        return $this->serviceName;
    }

    public function toString()
    {
        return $this->serviceName . '_' . $this->schema;
    }

//    public function isMatch($group, $version)
//    {
//        return $this->group === $group && $this->version === $version;
//    }
//
//    public function isMatchDesc($desc)
//    {
//        return $this->group == $desc->group && $this->version == $desc->version;
//    }


}

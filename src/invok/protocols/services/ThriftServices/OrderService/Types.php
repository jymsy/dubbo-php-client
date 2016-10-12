<?php
namespace ThriftService\OrderService;
//namespace demo\service\api\order;

/**
 * Autogenerated by Thrift Compiler (0.9.3)
 *
 * DO NOT EDIT UNLESS YOU ARE SURE THAT YOU KNOW WHAT YOU ARE DOING
 *  @generated
 */
use Thrift\Base\TBase;
use Thrift\Type\TType;
use Thrift\Type\TMessageType;
use Thrift\Exception\TException;
use Thrift\Exception\TProtocolException;
use Thrift\Protocol\TProtocol;
use Thrift\Protocol\TBinaryProtocolAccelerated;
use Thrift\Exception\TApplicationException;


class Order {
  static $_TSPEC;

  /**
   * @var int
   */
  public $orderId = null;
  /**
   * @var string
   */
  public $orderTitle = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'orderId',
          'type' => TType::I32,
          ),
        2 => array(
          'var' => 'orderTitle',
          'type' => TType::STRING,
          ),
        );
    }
    if (is_array($vals)) {
      if (isset($vals['orderId'])) {
        $this->orderId = $vals['orderId'];
      }
      if (isset($vals['orderTitle'])) {
        $this->orderTitle = $vals['orderTitle'];
      }
    }
  }

  public function getName() {
    return 'Order';
  }

  public function read($input)
  {
    $xfer = 0;
    $fname = null;
    $ftype = 0;
    $fid = 0;
    $xfer += $input->readStructBegin($fname);
    while (true)
    {
      $xfer += $input->readFieldBegin($fname, $ftype, $fid);
      if ($ftype == TType::STOP) {
        break;
      }
      switch ($fid)
      {
        case 1:
          if ($ftype == TType::I32) {
            $xfer += $input->readI32($this->orderId);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 2:
          if ($ftype == TType::STRING) {
            $xfer += $input->readString($this->orderTitle);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        default:
          $xfer += $input->skip($ftype);
          break;
      }
      $xfer += $input->readFieldEnd();
    }
    $xfer += $input->readStructEnd();
    return $xfer;
  }

  public function write($output) {
    $xfer = 0;
    $xfer += $output->writeStructBegin('Order');
    if ($this->orderId !== null) {
      $xfer += $output->writeFieldBegin('orderId', TType::I32, 1);
      $xfer += $output->writeI32($this->orderId);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->orderTitle !== null) {
      $xfer += $output->writeFieldBegin('orderTitle', TType::STRING, 2);
      $xfer += $output->writeString($this->orderTitle);
      $xfer += $output->writeFieldEnd();
    }
    $xfer += $output->writeFieldStop();
    $xfer += $output->writeStructEnd();
    return $xfer;
  }

}



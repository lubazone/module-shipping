<?php

namespace LubaZone\Shipping\Helper;

use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Data {

    protected $configWriter;

    public function __construct(WriterInterface $configWriter) {
        $this->configWriter = $configWriter;
    }

    /**
     * @param $path = 'extension_name/general/data'
     * @param $value = '1'
     */
    public function setData($path, $value) {
//        $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/custom.log');
//        $logger = new \Zend_Log();
//        $logger->addWriter($writer);
//        $logger->debug('$path' . print_r($path, true));
//        $logger->debug('$value' . print_r($value, true));
//        $x = $this->configWriter->save($path, $value);
        $logger->debug('x   ' . print_r($x, true));
    }
}

<?php

namespace LubaZone\Shipping\Model\Config\Backend;

use Magento\Config\Model\Config\Backend\File;
use Magento\MediaStorage\Model\File\Uploader;
use Magento\Framework\Filesystem;

class FileProcess extends File {

    public $shippingHelper;

    const CONFIG_GROUP = 'carriers/luba_shipping/';

    public function __construct(
            \Magento\Framework\Model\Context $context,
            \Magento\Framework\Registry $registry,
            \Magento\Framework\App\Config\ScopeConfigInterface $config,
            \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
            \Magento\MediaStorage\Model\File\UploaderFactory $uploaderFactory,
            \Magento\Config\Model\Config\Backend\File\RequestData\RequestDataInterface $requestData,
            Filesystem $filesystem,
            \LubaZone\Shipping\Helper\Data $shippingHelper,
            ?\Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
            ?\Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
            array $data = []
    ) {
        
        $this->shippingHelper = $shippingHelper;
        
                parent::__construct($context, $registry, $config, $cacheTypeList,$uploaderFactory,$requestData, $filesystem, $resource, $resourceCollection, $data);

    }

    protected function _getAllowedExtensions() {
        return ['csv'];
    }

//    protected function _getUploadDir() {
//        return 'lubashippingconfig'; // Folder inside pub/media
//    }

    protected function _getUploader($tmpName) {
        $uploader = parent::_getUploader($tmpName);
        $uploader->setAllowRenameFiles(true);
        return $uploader;
    }

    public function afterSave() {
        parent::afterSave();

        if ($this->getValue()) {

            $filePath = $this->_getUploadDir() . '/' . basename($this->getData('value'));
            $this->processCsv($filePath);
        }

        return $this;
    }

    protected function processCsv($filePath) {
//        processCsv
//        dd($this->processCsv($filePath));
        if (!file_exists($filePath)) {
            return;
        }

// Parse the rows
        $rows = [];
        $handle = fopen($filePath, "r");
        while (($row = fgetcsv($handle)) !== false) {
            $rows[] = $row;
        }
        fclose($handle);
// Remove the first one that contains headers
        $headers = array_shift($rows);
// Combine the headers with each following row
        $array = [];
        foreach ($rows as $row) {
            $array[] = array_combine($headers, $row);
        }
        if (count($array[0])) {

            foreach ($array[0] as $key => $value) {
//                var_dump(self::CONFIG_GROUP.$key,$value);exit;
                $this->shippingHelper->setData(self::CONFIG_GROUP.$key,$value);
            }
        }
        $this->shippingHelper->setData(self::CONFIG_GROUP.'import_config',null);

    }
}

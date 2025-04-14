<?php

namespace LubaZone\Shipping\Model\Config\Source;

/**
 * Options provider for Regions list
 */
class Region implements \Magento\Framework\Option\ArrayInterface {

    /**
     * @var \Magento\Directory\Model\ResourceModel\Region\CollectionFactory
     */
    protected $regionCollectionFactory;

    /**
     * Options array
     *
     * @var array
     */
    protected $options;

    /**
     * @param \Magento\Directory\Model\ResourceModel\Region\CollectionFactory $regionCollectionFactory
     */
    public function __construct(\Magento\Directory\Model\ResourceModel\Region\CollectionFactory $regionCollectionFactory) {
        $this->regionCollectionFactory = $regionCollectionFactory;
    }

    public function toOptionArray() {
        $regionOptions = [];
        $regionsCollection = $this->regionCollectionFactory->create()->load();
        $regionsCollection->addFieldToFilter('country_id', 'US');
        $regionData = $regionsCollection->getData();
        foreach ($regionData as $region) {
            $regionOptions[] = ['label' => $region['default_name'], 'value' => $region['region_id']];
        }
        return $regionOptions;
    }
}

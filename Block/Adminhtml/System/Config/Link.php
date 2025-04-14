<?php

namespace LubaZone\Shipping\Block\Adminhtml\System\Config;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

class Link extends Field {

    /**
     * Render the element and add a custom link to the comment field.
     *
     * @param AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element) {
        $element->setComment(
                'Download the <a href="https://github.com/lubazone/module-shipping/blob/main/sample/luba_shipping_config.csv" target="_blank">luba_shipping_config.csv</a> file here.'
        );

        return parent::_getElementHtml($element);
    }
}

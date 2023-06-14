<?php
/**
 * ScandiWeb_Task2 Module
 *
 * @category  ScandiWeb
 * @package   ScandiWeb_Task2
 * @author    Dawood Gondal
 */

namespace ScandiWeb\Task2\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\ScopeInterface;

/**
 * Block Class
 */
class Button extends Template
{
    const PATH_TO_SCANDI_BUTTON_COLOR = 'scandiweb/button/color';
    const HEX_BLUE_COLOR = '1979c3';

    /**
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * @return mixed|string
     */
    public function getButtonColor() :?string
    {
        try {
            $color = $this->_scopeConfig->getValue(
                self::PATH_TO_SCANDI_BUTTON_COLOR,
                ScopeInterface::SCOPE_STORE,
                $this->_storeManager->getStore()->getStoreId()
            );

            if ($color) {
                return $color;
            }
        } catch (\Exception $e) {
            $this->_logger->critical("Error Occurred: " . $e->getMessage());
        }

        // Default color to show for all the buttons
        return self::HEX_BLUE_COLOR;
    }
}

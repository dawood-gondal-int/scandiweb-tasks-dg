<?php
/**
 * ScandiWeb_Task1 Module
 *
 * @category  ScandiWeb
 * @package   ScandiWeb_Task1
 * @author    Dawood Gondal
 */

namespace ScandiWeb\Task1\Block;

use Magento\Cms\Model\Page;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

/**
 * Block Class
 */
class HeadMetaTag extends Template
{
    /**
     * @var Page
     */
    protected $cmsPage;

    /**
     * @param Context $context
     * @param Page $cmsPage
     * @param array $data
     */
    public function __construct(
        Context $context,
        Page $cmsPage,
        array $data = []
    ) {
        $this->cmsPage = $cmsPage;
        parent::__construct($context, $data);
    }

    /**
     * @return string
     */
    public function getHreflangTags(): string
    {
        $tag = "";
        try {
            $store = $this->_storeManager->getStore();
            $languageCode = $store->getConfig('general/locale/code');
            $baseUrl = $store->getBaseUrl();
            $cmsPageUrl = $this->cmsPage->getIdentifier();
            $tag = '<link rel="alternate" hreflang="' . $languageCode . '" href="' . $baseUrl . $cmsPageUrl . '" />';
        } catch (NoSuchEntityException $exception) {
            $this->_logger->critical("Error occurred: " . $exception->getMessage());
        }

        return $tag;
    }
}

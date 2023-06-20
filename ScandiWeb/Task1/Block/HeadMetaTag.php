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
     * @return array
     */
    public function getHreflangTags(): array
    {
        $tags = [];
        try {
            $cmsPageUrl = $this->cmsPage->getIdentifier();
            $assignedToStores = $this->cmsPage->getStores();
            $allStores = false;
            foreach ($assignedToStores as $assignedToStore) {
                // If cms page is assigned to all stores or specific store
                if ($assignedToStore == 0) {
                    $allStores = true;
                    break;
                } else {
                    $store = $this->_storeManager->getStore($assignedToStore);
                    $baseUrl = $store->getBaseUrl();
                    $languageCode = $store->getConfig('general/locale/code');
                    $tag = '<link rel="alternate" hreflang="' . $languageCode . '" href="' . $baseUrl . $cmsPageUrl . '" />';
                    $tags[] = $tag;
                }
            }

            if ($allStores) {
                $stores = $this->_storeManager->getStores();
                foreach ($stores as $store) {
                    $baseUrl = $store->getBaseUrl();
                    $languageCode = $store->getConfig('general/locale/code');
                    $tag = '<link rel="alternate" hreflang="' . $languageCode . '" href="' . $baseUrl . $cmsPageUrl . '" />';
                    $tags[] = $tag;
                }
            }
        } catch (NoSuchEntityException $exception) {
            $this->_logger->critical("Error occurred: " . $exception->getMessage());
        }

        return $tags;
    }
}

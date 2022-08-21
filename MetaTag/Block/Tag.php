<?php

declare(strict_types=1);

namespace Hibrido\MetaTag\Block;

use Magento\Cms\Model\Page;
use Magento\Framework\Locale\Resolver;
use Magento\Framework\View\Element\Template;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\View\Element\Template\Context;
use Magento\Cms\Model\ResourceModel\Page as ResourceModelPage;

class Tag extends Template
{
    /**
     * @var Resolver
     */
    protected $_localeResolver;

    /**
     * @var Page
     */
    protected $_page;

    /**
     * @var ResourceModelPage
     */
    protected $_resourceModelPage;

    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @param Context $context
     * @param array $data
     * @param Resolver $localeResolver
     * @param Page $page
     * @param ResourceModelPage $resourceModelPage
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        Context $context,
        array $data = [],
        Resolver $localeResolver,
        Page $page,
        ResourceModelPage $resourceModelPage,
        StoreManagerInterface $storeManager
    ) {
        parent::__construct($context, $data);
        $this->_localeResolver = $localeResolver;
        $this->_page = $page;
        $this->_resourceModelPage = $resourceModelPage;
        $this->_storeManager = $storeManager;
    }

    /**
     * Get the locale of store by id
     *
     * @param integer|null $storeId
     * @return string
     */
    public function getCurrentLocale(int $storeId = null): string
    {
        $locale = $this->_localeResolver->emulate($storeId);
        return strtolower(str_replace("_", "-", $locale));
    }

    /**
     * Get the baseUrl of store by id
     *
     * @param integer|null $storeId
     * @return string
     */
    public function getBaseUrl(int $storeId = null): string
    {
        return $this->_storeManager->getStore($storeId)
            ->getBaseUrl();
    }

    /**
     * Get the cms id of the current cms page
     *
     * @return string
     */
    public function getCmsPageUrl(): string
    {
        return $this->_page->getIdentifier();
    }

    /**
     * Get the stores id and checks if is used in others stores
     *
     * @return array
     */
    public function getStoresArray(): array
    {
        $pageId = $this->_page->getId();
        $storesIds = $this->_resourceModelPage->lookupStoreIds($pageId);

        if ($storesIds[0] == 0) {
            $storesIds = array_keys($this->_storeManager->getStores());
        }

        return [
            'array' => $storesIds,
            'isUsedInMoreStores' => count($storesIds) > 1
        ];
    }
}

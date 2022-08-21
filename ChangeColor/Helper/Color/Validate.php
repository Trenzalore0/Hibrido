<?php

declare(strict_types=1);

namespace Hibrido\ChangeColor\Helper\Color;

use Magento\Store\Model\StoreManagerInterface;
use Hibrido\ChangeColor\Model\StoreColorFactory;

class Validate
{
    /**
     * @var StoreColorFactory
     */
    protected $_storeColorFactory;

    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @param StoreColorFactory $storeColorFactory
     * @param StoreManagerInterface $storeManagerInterface
     */
    public function __construct(
        StoreColorFactory $storeColorFactory, 
        StoreManagerInterface $storeManagerInterface
    ) {
        $this->_storeColorFactory = $storeColorFactory;
        $this->_storeManager = $storeManagerInterface;
    }

    /**
     * Check the table is populated and if not populated  put the stores id
     *
     * @return void
     */
    public function run()
    {
        $collection = $this->_storeColorFactory->create()
            ->getCollection();

        if (empty($collection->getData())) {
            $stores = array_keys($this->_storeManager->getStores());
            foreach($stores as $storeKey) {
                $this->_storeColorFactory->create()
                    ->addData([
                        'store_id' => (int) $storeKey,
                        'color' => 'ffffff'
                    ])->save();
            }
        }
    }

    /**
     * Get all stores id
     *
     * @return array
     */
    public function getStoresIds(): array
    {
        return array_keys($this->_storeManager->getStores());
    }
}

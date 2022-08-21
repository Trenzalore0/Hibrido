<?php

declare(strict_types=1);

namespace Hibrido\ChangeColor\Helper\Color;

use Hibrido\ChangeColor\Model\StoreColorFactory;

class Save
{
    /**
     * @var StoreColorFactory
     */
    protected $_storeColorFactory;

    /**
     * @var Validate
     */
    protected $_validate;

    /**
     * @param StoreColorFactory $storeColorFactory
     * @param Validate $validate
     */
    public function __construct(StoreColorFactory $storeColorFactory, Validate $validate)
    {
        $this->_storeColorFactory = $storeColorFactory;
        $this->_validate = $validate;
    }

    /**
     * Set the color on the store by store id
     *
     * @param string|null $store
     * @param string|null $color
     * @return void
     */
    public function setColorInStore(string $store = null, string $color = null)
    {
        $this->_validate->run();
        if ($store == 0) {
            $store = $this->_validate->getStoresIds();
        }

        $func = function($storeID, $colorHex) {
            $this->_storeColorFactory->create()
                ->getCollection()
                ->addFieldToFilter('store_id', (int) $storeID)
                ->getFirstItem()
                ->setData('color', $colorHex)
                ->save();
        };

        if (is_array($store)) {
            foreach ($store as $storeId) {
                $func($storeId, $color);
            }
        } else {
            $func($store, $color);
        }
    }
}

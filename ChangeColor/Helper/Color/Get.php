<?php

declare(strict_types=1);

namespace Hibrido\ChangeColor\Helper\Color;

use Hibrido\ChangeColor\Model\StoreColorFactory;

class Get
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
     * get the color of store id
     *
     * @param string|null $store
     * @return string
     */
    public function getColorStoreById(string $store = null): string
    {
        $this->_validate->run();

        $store = (int) $store;
        $row = $this->_storeColorFactory->create()
        ->getCollection()
        ->addFieldToFilter('store_id', $store)
        ->getFirstItem();

        return $row->getData('color');
    }
}

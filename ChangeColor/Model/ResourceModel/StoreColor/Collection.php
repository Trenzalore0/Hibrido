<?php

namespace Hibrido\ChangeColor\Model\ResourceModel\StoreColor;

use Hibrido\ChangeColor\Model\ResourceModel\StoreColor as ResourceModelStoreColor;
use Hibrido\ChangeColor\Model\StoreColor;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'store_id';
    protected $_eventPrefix = 'hibrido_changecolor_store_color_collection';
    protected $_eventObject = 'store_color_collection';

    /**
     * Define the resource model & the model.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(StoreColor::class, ResourceModelStoreColor::class);
    }
}

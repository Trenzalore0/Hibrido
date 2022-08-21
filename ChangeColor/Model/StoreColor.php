<?php

namespace Hibrido\ChangeColor\Model;

use Hibrido\ChangeColor\Model\ResourceModel\StoreColor as ResourceModelStoreColor;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\DataObject\IdentityInterface;

class StoreColor extends AbstractModel implements IdentityInterface
{
    const CACHE_TAG = 'hibrido_changecolor_store_color';

    /**
     * Model cache tag for clear cache in after save and after delete
     *
     * @var string
     */
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'store_color';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModelStoreColor::class);
    }

    /**
     * Return a unique id for the model.
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}

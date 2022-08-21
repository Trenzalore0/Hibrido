<?php

namespace Hibrido\ChangeColor\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class StoreColor extends AbstractDb
{
    /**
     * @var string
     */
    const TABLE_NAME = 'hibrido_color_change_buttons';

    /**
     * @var string
     */
    const TABLE_FIELD_ID = 'id';

    /**
     *  Define the main table & field id.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, self::TABLE_FIELD_ID);
    }
}

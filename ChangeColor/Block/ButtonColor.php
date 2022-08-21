<?php

declare(strict_types=1);

namespace Hibrido\ChangeColor\Block;

use Hibrido\ChangeColor\Helper\Color\Get;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\View\Element\Template\Context;

class ButtonColor extends \Magento\Framework\View\Element\Template
{
    /**
     * @var Get
     */
    protected $_helperGet;

    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @param Context $context
     * @param array $data
     * @param Get $get
     * @param StoreManagerInterface $storeManagerInterface
     */
    public function __construct(
        Context $context,
        array $data = [],
        Get $get,
        StoreManagerInterface $storeManagerInterface

    ) {
        $this->_helperGet = $get;
        $this->_storeManager = $storeManagerInterface;
        parent::__construct($context, $data);
    }

    /**
     * et the color of the current store id
     *
     * @return string
     */
    public function getColor(): string
    {
        return $this->_helperGet->getColorStoreById(
            $this->_storeManager->getStore()->getId()
        );
    }
}

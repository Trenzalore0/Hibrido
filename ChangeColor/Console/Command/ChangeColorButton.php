<?php

declare(strict_types=1);

namespace Hibrido\ChangeColor\Console\Command;

use Hibrido\ChangeColor\Helper\Color\Save;
use Magento\Store\Model\StoreManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ChangeColorButton extends Command
{
    /**
     * @var string
     */
    const CMD_NAME = 'color:change';

    /**
     * @var string
     */
    const CMD_DESCRIPTION = 'Change the color of buttons on the store(s)';

    /**
     * @var string
     */
    const ARG_COLOR = 'color';

    /**
     * @var string
     */
    const ARG_STORE = 'store';

    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var Save
     */
    protected $_helperSave;

    /**
     * @param StoreManagerInterface $storeManagerInterface
     */
    public function __construct(StoreManagerInterface $storeManagerInterface, Save $save)
    {
        $this->_storeManager = $storeManagerInterface;
        $this->_helperSave = $save;

        parent::__construct();
    }

    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this->setName(self::CMD_NAME);
        $this->setDescription(self::CMD_DESCRIPTION)
            ->setDefinition([
                new InputArgument(
                    self::ARG_COLOR,
                    InputArgument::REQUIRED,
                    'color of buttons'
                ),
                new InputArgument(
                    self::ARG_STORE,
                    InputArgument::OPTIONAL,
                    'store to change the color'
                )
            ]);

        parent::configure();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return null|int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $color = $input->getArgument(self::ARG_COLOR);

        $colorLength = strlen($color);
        if (!($colorLength == 3 || $colorLength == 6)) {
            $output->writeln('<error>An error encountered. Color not permited</error>');
            exit;
        }

        $store = $input->getArgument(self::ARG_STORE);
        if (empty($store)) {
            $store = '0';
        }

        $stores = array_keys($this->_storeManager->getStores(true));
        if (!in_array($store, $stores)) {
            $output->writeln('<error>An error encountered. Store no exists please put a store id valid</error>');
            exit;
        }

        $this->_helperSave->setColorInStore($store, $color);
        $output->writeln('<info>Changed color.</info>');
    }
}

<?php
/**
 * ScandiWeb_Task2 Module
 *
 * @category  ScandiWeb
 * @package   ScandiWeb_Task2
 * @author    Dawood Gondal
 */

namespace ScandiWeb\Task2\Console;

use Magento\Framework\App\Area;
use Magento\Framework\App\State;
use Magento\Framework\Console\Cli;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Store\Model\StoreManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ButtonColorChange extends Command
{
    const INPUT_COLOR = 'color';
    const INPUT_STORE_VIEW = 'store_id';

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var State
     */
    protected $state;

    /**
     * @var WriterInterface
     */
    protected $configWriter;

    /**
     * @param StoreManagerInterface $storeManager
     * @param State $state
     * @param WriterInterface $configWriter
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        State $state,
        WriterInterface $configWriter
    ) {
        $this->storeManager = $storeManager;
        $this->state = $state;
        $this->configWriter = $configWriter;
        parent::__construct();
    }

    /**
     * @return void
     */
    protected function configure(): void
    {
        $this->setName('scandiweb:color-change')
            ->setDescription('Command changes the button color for a specific Store. Multiple IDs can be given comma separately. (scandiweb:color-change <color> <store_id>)')
            ->addArgument(self::INPUT_COLOR, InputArgument::REQUIRED, 'HEX color code')
            ->addArgument(self::INPUT_STORE_VIEW, InputArgument::REQUIRED, 'Store IDs');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $colorInHex = $input->getArgument(self::INPUT_COLOR);
        switch (strlen($colorInHex)) {
            case 3:
            case 6:
                break;
            default:
                throw new LocalizedException(
                    __("Error: Color is wrongly formatted. Verify and try again.")
                );
        }

        $storeIds = $input->getArgument(self::INPUT_STORE_VIEW);
        $storeIds = explode(",", $storeIds);
        foreach ($storeIds as $storeId) {
            $this->storeManager->getStore($storeId);
        }

        $this->state->setAreaCode(Area::AREA_FRONTEND);
        try {
            foreach ($storeIds as $storeId) {
                $this->storeManager->setCurrentStore($storeId);
                $this->configWriter->save('scandiweb/button/color', $colorInHex, 'stores', $storeId);
                $output->writeln("<info>Button color changed for Store View ID: $storeId </info>");
            }
        } catch (\Exception $e) {
            throw new LocalizedException(
                __("Error occurred for Store View ID: $storeId - " . $e->getMessage())
            );
        }

        $output->writeln('<info>Button color change completed.</info>');
        return Cli::RETURN_SUCCESS;
    }
}

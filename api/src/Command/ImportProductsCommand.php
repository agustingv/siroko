<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use App\Entity\Product;
use App\Repository\ProductRepository;

#[AsCommand(
    name: 'import-products',
    description: 'Import test products from csv',
)]
class ImportProductsCommand extends Command
{
    public function __construct(
        private MessageBusInterface $messageBus, 
        private ProductRepository $produtRepository
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('test', InputArgument::OPTIONAL, 'Test read a csv file')
            ->addOption('csv', null, InputOption::VALUE_REQUIRED, 'csv file to import produts test')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('test');

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        if ($file = $input->getOption('csv')) {
            $rowNo = 0;
            if (($fp = fopen($file, "r")) !== FALSE) 
            {
                $data = [];
                while (($row = fgetcsv($fp, 1000, ";")) !== FALSE) 
                {
                    $product = new Product();
                    $product->name = $row[2];
                    $product->price = (float)$row[6];
                    $product->stock = $row[23];
                    $desc = (isset($row[29]))? $row[29] : "description";
                    $product->description = $desc;

                    $this->produtRepository->create($product, true);
                    $io->success('Import Product: '.$product->name);
                }
                fclose($fp);
            }
        }

        $io->success('Import complete');

        return Command::SUCCESS;
    }
}

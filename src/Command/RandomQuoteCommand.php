<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class RandomQuoteCommand extends Command
{
    protected static $defaultName = 'app:random-quote';
    protected static $defaultDescription = 'Pick a random quote from the database.';

    private $container;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct();
        $this->container = $container;
    }

    protected function configure()
    {
        $this
            ->setDescription(self::$defaultDescription)
            ->addOption('category', null, InputOption::VALUE_NONE, 'Category name of the quote')
            ->setHelp('This command allows you to pick a random quote from the database. --category to look for a specific category')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $quoteRepository = $this->container->get('doctrine')->getRepository('App:Quote');
        $quote = $quoteRepository->findRandom();

        $output->writeln([
            $quote->getContent(),
            ' ',
            $quote->getMeta(),
        ]);

        return 0;
    }
}

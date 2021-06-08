<?php

namespace App\Command;

use App\Entity\Quote;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpClient\HttpClient;

class ImportQuoteAPICommand extends Command
{
    protected static $defaultName = 'app:import-random-kaamelott-quotes';
    protected static $defaultDescription = 'Import a quote from the Kaamelott API';

    private $manager;
    private $userRepository;
    private $categoryRepository;

    public function __construct(EntityManagerInterface $manager, UserRepository $userRepository, CategoryRepository $categoryRepository)
    {
        parent::__construct();
        $this->manager = $manager;
        $this->userRepository = $userRepository;
        $this->categoryRepository = $categoryRepository;
    }

    protected function configure()
    {
        $this
            ->setDescription(self::$defaultDescription)
            ->addArgument('count', InputArgument::REQUIRED)
            ->setHelp('This command allows you to import quotes from the Kaamelott API Quote')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Import de citation Kaamelott');

        $inputCount = $input->getArgument('count');

        $httpClient = HttpClient::create();

        for ($i = 0; $i < $inputCount; ++$i) {
            $response = $httpClient->request('GET', 'https://kaamelott.chaudie.re/api/random');
            $quote = new Quote();
            $arrayResponse = $response->toArray();

            // author = admin here by default
            $adminUser = $this->userRepository->findOneBy(['email' => 'admin@outlook.fr']);
            $kaamelott = $this->categoryRepository->findOneBy(['name' => 'Kaamelott']);
            $content = $arrayResponse['citation']['citation'];

            $quote->setContent($content);

            $meta =
                $arrayResponse['citation']['infos']['auteur']
                .' '
                .$arrayResponse['citation']['infos']['personnage']
                .' '
                .$arrayResponse['citation']['infos']['saison'];

            $quote->setMeta($meta);
            $quote->setAuthor($adminUser);
            $quote->setCategory($kaamelott);

            $this->manager->persist($quote);

            $io->title('Quote added !');

            $output->writeln([
                ' ',
                $content,
                $meta,
                ' ',
                ' ',
            ]);
        }

        $this->manager->flush();

        return 0;
    }
}
